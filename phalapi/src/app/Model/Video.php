<?php
namespace App\Model;
use PhalApi\Model\NotORMModel as NotORM;

class Video extends NotORM {
	/* 发布视频 */
	public function setVideo($data,$music_id) {
		$uid=$data['uid'];

		$configPri=\App\getConfigPri();

		if($configPri['video_audit_switch']==0){
			$data['status']=1;
		}
		//视频分类是否存在
		if($data['classid']){
			$isexitclass=\PhalApi\DI()->notorm->video_class->where("id=?",$data['classid'])->fetchOne();
			if(!$isexitclass){
				return 1007;//视频分类不存在
            }
		}

		$result= \PhalApi\DI()->notorm->video->insert($data);

		if($music_id>0){ //更新背景音乐被使用次数
			\PhalApi\DI()->notorm->music
            ->where("id = '{$music_id}'")
		 	->update(
		 		array(
		 			'use_nums' => new \NotORM_Literal("use_nums + 1")
		 		)
		 	);
		}
		
		return $result;
	}

	/* 评论/回复 */
    public function setComment($data) {
    	$videoid=$data['videoid'];

		/* 更新 视频 */
		
        $res=\PhalApi\DI()->notorm->video_comments
            ->insert($data);

        if(!$res){
        	return 1001;
        }

        \PhalApi\DI()->notorm->video
            ->where("id = '{$videoid}'")
		 	->update(
		 		array(
		 			'comments' => new \NotORM_Literal("comments + 1")
		 		)
		 	);
			
		$videoinfo=\PhalApi\DI()->notorm->video
					->select("comments")
					->where('id=?',$videoid)
					->fetchOne();
					
		$count=\PhalApi\DI()->notorm->video_comments
					->where("commentid='{$data['commentid']}'")
					->count();
		$rs=array(
			'comments'=>$videoinfo['comments'],
			'replys'=>$count,
		);

		$arr=json_decode($data['at_info'],true); //将json串转为数组


		if(!empty($arr)){

			$data1=array("videoid"=>$data['videoid'],"addtime"=>time(),"uid"=>$data['uid']);

			foreach ($arr as $k => $v) {
				$data1['touid']=$v['uid'];
				\PhalApi\DI()->notorm->video_comments_at_messages->insert($data1);
				//发送腾讯IM
				\App\txMessageIM("@通知",$v['uid'],"dsp_at");
			}
		}

		if($data['uid']!=$data['touid']){

			$data2=array(
				"uid"=>$data['uid'],
				"touid"=>$data['touid'],
				"videoid"=>$data['videoid'],
				"content"=>$data['content'],
				"addtime"=>time()
				
			);

			if($data['commentid'] && $data['parentid']){ //回复
				$data2['type']=1;
			}else{
				$data2['type']=0;
			}

			\PhalApi\DI()->notorm->video_comments_messages->insert($data2);
			//发布腾讯IM
			\App\txMessageIM("评论通知",$data['touid'],"dsp_comment"); //$data['touid']为视频发布者ID或评论者ID
			
			
		}


		return $rs;
    }

	/* 阅读 */
	public function addView($uid,$videoid){
		/*$view=\PhalApi\DI()->notorm->video_view
				->select("id")
				->where("uid='{$uid}' and videoid='{$videoid}'")
				->fetchOne();

		if(!$view){
			\PhalApi\DI()->notorm->video_view
						->insert(array("uid"=>$uid,"videoid"=>$videoid,"addtime"=>time() ));
						
			\PhalApi\DI()->notorm->video
				->where("id = '{$videoid}'")
				->update( array('view' => new \NotORM_Literal("view + 1") ) );
		}*/

		/*//用户看过的视频存入redis中
		$readLists=\App\getcaches('readvideo_'.$uid);
		$readArr=array();
		if($readLists){
			$readArr=json_decode($readLists,true);
			if(!in_array($videoid,$readArr)){
				$readArr[]=$videoid;
			}
		}else{
			$readArr[]=$videoid;
		}

		\App\setcaches('readvideo_'.$uid,json_encode($readArr));*/

		\PhalApi\DI()->notorm->video
				->where("id = '{$videoid}'")
				->update(
					array(
						'views' => new \NotORM_Literal("views + 1")
					)
				);

		return 0;
	}
	/* 点赞 */
	public function addLike($uid,$videoid){
		$rs=array(
			'islike'=>'0',
			'likes'=>'0',
		);
		$video=\PhalApi\DI()->notorm->video
				->select("likes,uid,thumb")
				->where("id = '{$videoid}'")
				->fetchOne();

		if(!$video){
			return 1001;
		}
		if($video['uid']==$uid){
			return 1002;//不能给自己点赞
		}
		$like=\PhalApi\DI()->notorm->video_like
						->select("id")
						->where("uid='{$uid}' and videoid='{$videoid}'")
						->fetchOne();
		if($like){
			\PhalApi\DI()->notorm->video_like
						->where("uid='{$uid}' and videoid='{$videoid}'")
						->delete();
			
			\PhalApi\DI()->notorm->video
				->where("id = '{$videoid}' and likes>0")
				->update(
					array(
						'likes' => new \NotORM_Literal("likes - 1")
					)
				);

			$rs['islike']='0';

			//视频用户总点赞数
			\App\reduceUserPraise($video['uid'],1);
		}else{
			\PhalApi\DI()->notorm->video_like
				->insert(
					array(
						"uid"=>$uid,
						"videoid"=>$videoid,
						"addtime"=>time()
					)
				);
			
			\PhalApi\DI()->notorm->video
				->where("id = '{$videoid}'")
				->update(
					array(
						'likes' => new \NotORM_Literal("likes + 1")
					)
				);

			$rs['islike']='1';

			//视频用户总点赞数
			\App\addUserPraise($video['uid'],1);
		}
		
		$video=\PhalApi\DI()->notorm->video
				->select("likes,uid,thumb")
				->where("id = '{$videoid}'")
				->fetchOne();
				
		$rs['likes']=$video['likes'];

		//获取视频点赞信息列表
		$fabulous=\PhalApi\DI()->notorm->praise_messages
			->where("uid='{$uid}' and obj_id='{$videoid}' and type=1")
			->fetchOne();

		if(!$fabulous){
			\PhalApi\DI()->notorm->praise_messages->insert(
				array(
					"uid"=>$uid,
					"touid"=>$video['uid'],
					"obj_id"=>$videoid,
					"videoid"=>$videoid,
					"addtime"=>time(),
					"type"=>1,
					"video_thumb"=>$video['thumb']
				)
			);
			//发布腾讯IM
			\App\txMessageIM("点赞通知",$video['uid'],"dsp_like");
		}else{
			\PhalApi\DI()->notorm->praise_messages
				->where("uid='{$uid}' and type=1 and obj_id='{$videoid}'")
				->update(array("addtime"=>time()));
		}
		
		return $rs;
	}
	
	public function addCollect($uid, $videoid)
	{
		$rs = array(
			'iscollect' => '0',
			'collects' => '0',
		);
		$video = \PhalApi\DI()->notorm->video
			->select('collects,uid,thumb')
			->where("id = '{$videoid}'")
			->fetchOne();
		
		if (!$video) {
			return 1001;
		}
		if ($video['uid'] == $uid) {
			return 1002;//不能给自己点赞
		}
		$collect = \PhalApi\DI()->notorm->video_collect
			->select('id')
			->where("uid='{$uid}' and videoid='{$videoid}'")
			->fetchOne();
		if ($collect) {
			\PhalApi\DI()->notorm->video_collect
				->where("uid='{$uid}' and videoid='{$videoid}'")
				->delete();
			
			\PhalApi\DI()->notorm->video
				->where("id = '{$videoid}' and collects>0")
				->update(
					array(
						'collects' => new \NotORM_Literal('collects - 1')
					)
				);
			
			$rs['iscollect'] = '0';
			
			//视频用户总点赞数
			\App\reduceUserPraise($video['uid'], 1);
		} else {
			\PhalApi\DI()->notorm->video_collect
				->insert(
					array(
						'uid' => $uid,
						'videoid' => $videoid,
						'addtime' => time()
					)
				);
			
			\PhalApi\DI()->notorm->video
				->where("id = '{$videoid}'")
				->update(
					array(
						'collects' => new \NotORM_Literal('collects + 1')
					)
				);
			
			$rs['iscollect'] = '1';
			
			//视频用户总点赞数
			\App\addUserPraise($video['uid'], 1);
		}
		
		$video = \PhalApi\DI()->notorm->video
			->select('collects,uid,thumb')
			->where("id = '{$videoid}'")
			->fetchOne();
		
		$rs['collects'] = $video['collects'];
		
		//获取视频收藏信息列表
		$fabulous = \PhalApi\DI()->notorm->praise_messages
			->where("uid='{$uid}' and obj_id='{$videoid}' and type=2")
			->fetchOne();
		
		if (!$fabulous) {
			\PhalApi\DI()->notorm->praise_messages->insert(
				array(
					'uid' => $uid,
					'touid' => $video['uid'],
					'obj_id' => $videoid,
					'videoid' => $videoid,
					'addtime' => time(),
					'type' => 2,
					'video_thumb' => $video['thumb']
				)
			);
			//发布腾讯IM
			\App\txMessageIM('收藏通知', $video['uid'], 'dsp_collect');
		} else {
			\PhalApi\DI()->notorm->praise_messages
				->where("uid='{$uid}' and type=1 and obj_id='{$videoid}'")
				->update(array('addtime' => time()));
		}
		
		return $rs;
	}
	
	public function collectList($touid,$p)
	{
		if ($p < 1) {
			$p = 1;
		}
		$nums = 50;
		$start = ($p - 1) * $nums;
		$list = \PhalApi\DI()->notorm->video_collect
			->where('uid =? and status=?',$touid,1)
			->order('addtime desc')
			->limit($start, $nums)
			->fetchAll();
		$array = array_column($list, 'videoid');
		
		$video = \PhalApi\DI()->notorm->video
			->select('*')
			->where(['id' => $array])
			->fetchAll();
		foreach ($video as $k => $v) {
			$v = \App\handleVideo($touid, $v);
			$v['islike']=(int)$v['islike'];
			$v['isstep']=(int)$v['isstep'];
			$v['isattent']=(int)$v['isattent'];
			$v['iscollect']=(int)$v['iscollect'];
			$v['goods_type']=(int)$v['goods_type'];
			$video[$k] = $v;
			
		}
		
		return $video;
		
	}
	
	
	
	/* 分享 */
	public function addShare($uid,$videoid){

		
		$rs=array(
			'isshare'=>'0',
			'shares'=>'0',
		);
		\PhalApi\DI()->notorm->video
			->where("id = '{$videoid}'")
			->update(
				array(
					'shares' => new \NotORM_Literal("shares + 1")
				)
			);

		$rs['isshare']='1';

		
		$video=\PhalApi\DI()->notorm->video
				->select("shares")
				->where("id = '{$videoid}'")
				->fetchOne();
		$rs['shares']=$video['shares'];
		
		return $rs;
	}

	/* 拉黑视频 */
	public function setBlack($uid,$videoid){
		$rs=array(
			'isblack'=>'0',
		);
		$like=\PhalApi\DI()->notorm->video_black
			->select("id")
			->where("uid='{$uid}' and videoid='{$videoid}'")
			->fetchOne();

		if($like){
			\PhalApi\DI()->notorm->video_black
				->where("uid='{$uid}' and videoid='{$videoid}'")
				->delete();

			$rs['isshare']='0';
		}else{
			\PhalApi\DI()->notorm->video_black
				->insert(
					array(
						"uid"=>$uid,
						"videoid"=>$videoid,
						"addtime"=>time()
					)
				);

			$rs['isshare']='1';
		}
		return $rs;
	}


	/* 评论/回复 点赞 */
	public function addCommentLike($uid,$commentid){
		$rs=array(
			'islike'=>'0',
			'likes'=>'0',
		);

		//根据commentid获取对应的评论信息
		$commentinfo=\PhalApi\DI()->notorm->video_comments
			->where("id='{$commentid}'")
			->fetchOne();

		if(!$commentinfo){
			return 1001;
		}

		$like=\PhalApi\DI()->notorm->video_comments_like
			->select("id")
			->where("uid='{$uid}' and commentid='{$commentid}'")
			->fetchOne();

		if($like){
			\PhalApi\DI()->notorm->video_comments_like
				->where("uid='{$uid}' and commentid='{$commentid}'")
				->delete();
			
			\PhalApi\DI()->notorm->video_comments
				->where("id = '{$commentid}' and likes>0")
				->update(
					array(
						'likes' => new \NotORM_Literal("likes - 1")
					)
				);

			$rs['islike']='0';

		}else{
			\PhalApi\DI()->notorm->video_comments_like
				->insert(
					array(
						"uid"=>$uid,
						"commentid"=>$commentid,
						"addtime"=>time(),
						"touid"=>$commentinfo['uid'],
						"videoid"=>$commentinfo['videoid']
					)
				);
			
			\PhalApi\DI()->notorm->video_comments
				->where("id = '{$commentid}'")
				->update(
					array(
						'likes' => new \NotORM_Literal("likes + 1")
					)
				);
			$rs['islike']='1';
		}
		
		$video=\PhalApi\DI()->notorm->video_comments
				->select("likes")
				->where("id = '{$commentid}'")
				->fetchOne();

		//获取视频信息
		$videoinfo=\PhalApi\DI()->notorm->video
			->select("thumb")
			->where("id='{$commentinfo['videoid']}'")
			->fetchOne();

		$rs['likes']=$video['likes'];

		//获取评论点赞信息列表
		$fabulous=\PhalApi\DI()->notorm->praise_messages
				->where("uid='{$uid}' and obj_id='{$commentid}' and type=0")
				->fetchOne();

		if(!$fabulous){
			\PhalApi\DI()->notorm->praise_messages
				->insert(
					array(
						"uid"=>$uid,
						"touid"=>$commentinfo['uid'],
						"obj_id"=>$commentid,
						"videoid"=>$commentinfo['videoid'],
						"addtime"=>time(),
						"type"=>0,
						"video_thumb"=>$videoinfo['thumb']
					)
				);

		}else{
			\PhalApi\DI()->notorm->praise_messages
				->where("uid='{$uid}' and type=0 and obj_id='{$commentid}'")
				->update(
					array("addtime"=>time())
				);
		}

		return $rs;
	}
	
	/* 热门视频 */
	public function getVideoList($uid,$p){

        if($p<1){
            $p=1;
        }
		$nums=20;
		$start=($p-1)*$nums;

		$videoids_s='';
		$where="isdel=0 and status=1 and is_ad=0";  //上架且审核通过
		
		$video=\PhalApi\DI()->notorm->video
				->select("*")
				->where($where)
				->order("RAND()")
				->limit($start,$nums)
				->fetchAll();

		$videoCount=count($video);

		//广告视频
		$configPri=\App\getConfigPri();
		$ad_video_switch=$configPri['ad_video_switch'];
		$ad_video_loop=$configPri['ad_video_loop'];
		$video_ad_num=$configPri['video_ad_num']; //广告视频间隔数
		$orderStr="orderno desc,addtime desc";
		$nowtime=time();


		if($ad_video_switch){
			if(!$ad_video_loop){
				$ad_pnums=(int)($nums/$video_ad_num);
				$start1=($p-1)*$ad_pnums;
				$Adwhere=array();

				$adLists=\PhalApi\DI()->notorm->video
						->where("isdel=0 and status=1 and is_ad=1 and (ad_endtime=0 or (ad_endtime>0 and ad_endtime>{$nowtime}))")
						->limit($start1,$ad_pnums)
						->order($orderStr)
						->fetchAll();


				if($adLists){
					foreach ($adLists as $k => $v) {
						$videoNum=($k+1)*$video_ad_num;
						if($videoCount>=$videoNum){
							array_splice($video, ($k+1)*$video_ad_num+$k, 0, array($v)); //向推荐视频列表中插入广告位视频
						}
					}
				}
			}else{ //广告轮循展示
				//广告总量
				$adcount=\PhalApi\DI()->notorm->video
						->where("isdel=0 and status=1 and is_ad=1 and (ad_endtime=0 or (ad_endtime>0 and ad_endtime>{$nowtime}))")
						->count();

				//视频总数
				$videocount=\PhalApi\DI()->notorm->video
						->where("isdel=0 and status=1 and is_ad=0")
						->count();

				if($adcount>0){
					$needcount=floor($videocount/$video_ad_num);
					$cha=ceil($needcount/$adcount);
					$key="ad_lists";
					$ad_lists=\App\getcaches($key);

					if(!$ad_lists){
						$ad_lists=\PhalApi\DI()->notorm->video
								->where("isdel=0 and status=1 and is_ad=1 and (ad_endtime=0 or (ad_endtime>0 and ad_endtime>{$nowtime}))")
								->order($orderStr)
								->fetchAll();


						\App\setcaches($key,$ad_lists,5);

					}

					$ad_list1=array();

					for($i=0;$i<$cha;$i++){
						$ad_list1=array_merge($ad_list1,$ad_lists);
					}

					array_values($ad_list1);

					$ad_pnums=(int)($nums/$video_ad_num);

					$start1=($p-1)*$ad_pnums;

					$adLists=array_slice($ad_list1,$start1,$ad_pnums);

					if($adLists){

						foreach ($adLists as $k => $v) {
							if($v){

								$videoNum=($k+1)*$video_ad_num;

								if($videoCount>=$videoNum){
									
									array_splice($video, ($k+1)*$video_ad_num+$k, 0, array($v)); //向推荐视频列表中插入广告位视频
									
								}
								
							}
						}

					}
				}
			}
		}

		foreach($video as $k=>$v){
			
			$v=\App\handleVideo($uid,$v);
            
            $video[$k]=$v;

		}

		return $video;
	}
	
	/* 搜索到的视频 */
	public function getVideoSearchList($uid,$keyword,$p)
	{
		if ($p < 1) {
			$p = 1;
		}
		$nums = 20;
		$start = ($p - 1) * $nums;
		
		$where = 'isdel=0 and status=1 and is_ad=0';  //上架且审核通过
		$where .= " and title LIKE '%$keyword%'";
		
		$video = \PhalApi\DI()->notorm->video
			->select('*')
			->where($where)
			->order('views DESC, comments DESC, shares DESC')
			->limit($start, $nums)
			->fetchAll();
		
		foreach ($video as $k => $v) {
			
			$v = \App\handleVideo($uid, $v);
			$v['islike']=(int)$v['islike'];
			$v['isstep']=(int)$v['isstep'];
			$v['isattent']=(int)$v['isattent'];
			$v['iscollect']=(int)$v['iscollect'];
			$v['goods_type']=(int)$v['goods_type'];
			$video[$k] = $v;
			
		}
		
		return $video;
	}


	/* 关注人视频 */
	public function getAttentionVideo($uid,$p){
        if($p<1){
            $p=1;
        }
		$nums=20;
		$start=($p-1)*$nums;
		
		$video=array();
		$attention=\PhalApi\DI()->notorm->user_attention
				->select("touid")
				->where("uid='{$uid}'")
				->fetchAll();
		
		if($attention){
			
			$uids=array_column($attention,'touid');
			$touids=implode(",",$uids);
			
			$videoids_s=\App\getVideoBlack($uid);
			$where="uid in ({$touids}) and id not in ({$videoids_s})  and isdel=0 and status=1";
			
			$video=\PhalApi\DI()->notorm->video
					->select("*")
					->where($where)
					->order("addtime desc")
					->limit($start,$nums)
					->fetchAll();


			if(!$video){
				return 0;
			}
			
			foreach($video as $k=>$v){
				$v=\App\handleVideo($uid,$v);
            
                $video[$k]=$v;
				
			}
			
		}
		

		return $video;
	}
	
	/* 视频详情 */
	public function getVideo($uid,$videoid){
		$video=\PhalApi\DI()->notorm->video
					->select("*")
					->where("id = {$videoid}")
					->fetchOne();
		if(!$video){
			return 1000;
		}
		
		$video=\App\handleVideo($uid,$video);
		
		return 	$video;
	}
	
	/* 评论列表 */
	public function getComments($uid,$videoid,$p){
        if($p<1){
            $p=1;
        }
		$nums=20;
		$start=($p-1)*$nums;
		$comments=\PhalApi\DI()->notorm->video_comments
					->select("*")
					->where("videoid='{$videoid}' and parentid='0'")
					->order("addtime desc")
					->limit($start,$nums)
					->fetchAll();
		
		foreach($comments as $k=>$v){
			$comments[$k]['content_json']= $v['content_json'] ? json_decode($v['content_json'],true) : [];
			$comments[$k]['userinfo']=\App\getUserInfo($v['uid']);
			$comments[$k]['datetime']=\App\datetime($v['addtime']);
			$comments[$k]['likes']=\App\NumberFormat($v['likes']);
			if($uid){
				$comments[$k]['islike']=(string)$this->ifCommentLike($uid,$v['id']);
			}else{
				$comments[$k]['islike']='0';
			}
			
			if($v['touid']>0){
				$touserinfo=\App\getUserInfo($v['touid']);
			}
			if(!$touserinfo){
				$touserinfo=(object)array();
				$comments[$k]['touid']='0';
			}
			$comments[$k]['touserinfo']=$touserinfo;

			$count=\PhalApi\DI()->notorm->video_comments
					->where("commentid='{$v['id']}'")
					->count();
			$comments[$k]['replys']=$count;
            
            /* 回复 */
            $reply=\PhalApi\DI()->notorm->video_comments
					->select("*")
					->where("commentid='{$v['id']}'")
					->order("addtime desc")
					->limit(0,1)
					->fetchAll();
            foreach($reply as $k1=>$v1){
                
                $v1['userinfo']=\App\getUserInfo($v1['uid']);
                $v1['datetime']=\App\datetime($v1['addtime']);
                $v1['likes']=\App\NumberFormat($v1['likes']);
                $v1['islike']=(string)$this->ifCommentLike($uid,$v1['id']);
                if($v1['touid']>0){
                    $touserinfo=\App\getUserInfo($v1['touid']);
                }
                if(!$touserinfo){
                    $touserinfo=(object)array();
                    $v1['touid']='0';
                }
                
                if($v1['parentid']>0 && $v1['parentid']!=$v['id']){
                    $tocommentinfo=\PhalApi\DI()->notorm->video_comments
                        ->select("content,at_info")
                        ->where("id='{$v1['parentid']}'")
                        ->fetchOne();
                }else{
                    $tocommentinfo=(object)array();
                    $touserinfo=(object)array();
                    $v1['touid']='0';
                }
                $v1['touserinfo']=$touserinfo;
                $v1['tocommentinfo']=$tocommentinfo;
	            $v1['content_json']= $v1['content_json'] ? json_decode($v1['content_json'],true) : [];

                $reply[$k1]=$v1;
            }
            
            $comments[$k]['replylist']=$reply;
		}
		
		$commentnum=\PhalApi\DI()->notorm->video_comments
					->where("videoid='{$videoid}'")
					->count();
		
		$rs=array(
			"comments"=>$commentnum,
			"commentlist"=>$comments,
		);
		
		return $rs;
	}

	/* 回复列表 */
	public function getReplys($uid,$commentid,$p){
        if($p<1){
            $p=1;
        }
		$nums=20;
		$start=($p-1)*$nums;
		$comments=\PhalApi\DI()->notorm->video_comments
					->select("*")
					->where("commentid='{$commentid}'")
					->order("addtime desc")
					->limit($start,$nums)
					->fetchAll();

		
		foreach($comments as $k=>$v){
			$comments[$k]['userinfo']=\App\getUserInfo($v['uid']);
			$comments[$k]['datetime']=\App\datetime($v['addtime']);
			$comments[$k]['likes']=\App\NumberFormat($v['likes']);
			$comments[$k]['islike']=(string)$this->ifCommentLike($uid,$v['id']);
			if($v['touid']>0){
				$touserinfo=\App\getUserInfo($v['touid']);


			}
			if(!$touserinfo){
				$touserinfo=(object)array();
				$comments[$k]['touid']='0';
			}
			


			if($v['parentid']>0 && $v['parentid']!=$commentid){
				$tocommentinfo=\PhalApi\DI()->notorm->video_comments
					->select("content,at_info")
					->where("id='{$v['parentid']}'")
					->fetchOne();
     
			}else{

				$tocommentinfo=(object)array();
				$touserinfo=(object)array();
				$comments[$k]['touid']='0';

			}

			$comments[$k]['touserinfo']=$touserinfo;
			$comments[$k]['tocommentinfo']=$tocommentinfo;
		}

		return $comments;
	}
	
	
	
	/* 评论/回复 是否点赞 */
	public function ifCommentLike($uid,$commentid){
		$like=\PhalApi\DI()->notorm->video_comments_like
				->select("id")
				->where("uid='{$uid}' and commentid='{$commentid}'")
				->fetchOne();
		if($like){
			return 1;
		}else{
			return 0;
		}
	}
	
	/* 我的视频 */
	public function getMyVideo($uid,$p){
        if($p<1){
            $p=1;
        }
		$nums=20;
		$start=($p-1)*$nums;
		
		$video=\PhalApi\DI()->notorm->video
				->select("*")
				->where('uid=?  and isdel=0',$uid)
				->order("addtime desc")
				->limit($start,$nums)
				->fetchAll();
		
		foreach($video as $k=>$v){
            
            $xiajia_reason=$v['xiajia_reason'];
			$v=\App\handleVideo($uid,$v);
            $v['xiajia_reason']=$xiajia_reason;
            
            $video[$k]=$v;
			
		}

		
		return $video;
	}
	/* 删除视频 */
	public function del($uid,$videoid){
		
		$result=\PhalApi\DI()->notorm->video
					->where("id='{$videoid}' and uid='{$uid}'")
					->update( array( 'isdel'=>1 ) );
		if($result){
			// 删除 评论记录
			 /*\PhalApi\DI()->notorm->video_comments
						->where("videoid='{$videoid}'")
						->delete();
			//删除视频评论喜欢
			\PhalApi\DI()->notorm->video_comments_like
						->where("videoid='{$videoid}'")
						->delete();
			
			// 删除  点赞
			 \PhalApi\DI()->notorm->video_like
						->where("videoid='{$videoid}'")
						->delete();
			//删除视频举报
			\PhalApi\DI()->notorm->video_report
						->where("videoid='{$videoid}'")
						->delete();
			// 删除视频
			 \PhalApi\DI()->notorm->video
						->where("id='{$videoid}'")
						->delete();	*/

			//将喜欢的视频列表状态修改
			\PhalApi\DI()->notorm->video_like
				->where("videoid='{$videoid}'")
				->update(array("status"=>0));

			//将点赞信息列表里的状态修改
			\PhalApi\DI()->notorm->praise_messages
				->where("videoid='{$videoid}'")
				->update(array("status"=>0));

			//将视频评论@信息列表的状态更改
			\PhalApi\DI()->notorm->video_comments_at_messages
				->where("videoid='{$videoid}'")
				->update(array("status"=>0));

			//将评论信息列表的状态更改

			\PhalApi\DI()->notorm->video_comments_messages
				->where("videoid='{$videoid}'")
				->update(array("status"=>0));
		}
		return 0;
	}

	/* 个人主页视频 */
	public function getHomeVideo($uid,$touid,$p){
        if($p<1){
            $p=1;
        }
		$nums=21;
		$start=($p-1)*$nums;
		
		
		if($uid==$touid){  //自己的视频（需要返回视频的状态前台显示）
			$where=" uid={$uid} and isdel='0' and is_ad=0";
		}else{  //访问其他人的主页视频
            $videoids_s=\App\getVideoBlack($uid);
			$where="id not in ({$videoids_s}) and uid={$touid} and isdel='0' and status=1  and is_ad=0";
		}
		
		
		$video=\PhalApi\DI()->notorm->video
				->select("*")
				->where($where)
				->order("addtime desc")
				->limit($start,$nums)
				->fetchAll();

		foreach($video as $k=>$v){
			$v=\App\handleVideo($uid,$v);
            
            $video[$k]=$v;
		}

		return $video;
		
	}
	/* 举报 */
	public function report($data) {
		
		$video=\PhalApi\DI()->notorm->video
					->select("uid")
					->where("id='{$data['videoid']}'")
					->fetchOne();
		if(!$video){
			return 1000;
		}
		
		$data['touid']=$video['uid'];
		
		\PhalApi\DI()->notorm->video_report->insert($data);
		return 0;
	}
	

	/*获取附近的视频*/
	public function getNearby($uid,$city,$lng,$lat,$p){
        if($p<1){
            $p=1;
        }
		$pnum=20;
		$start=($p-1)*$pnum;

		if ($city){
			$info = \PhalApi\DI()->notorm->video
				->select('*')
				->where('uid != ?', $uid)
				->where('city', $city)
				->where('isdel', 0)
				->where('status', 1)
				->where('is_ad', 0)
				->order('addtime desc')
				->limit($start, $pnum)
				->fetchAll();
			
		}else{
			$prefix = \PhalApi\DI()->config->get('dbs.tables.__default__.prefix');
			
			$info = \PhalApi\DI()->notorm->video->queryAll('select *, round(6378.138 * 2 * ASIN(SQRT(POW(SIN(( ' . $lat . ' * PI() / 180 - lat * PI() / 180) / 2),2) + COS(' . $lat . ' * PI() / 180) * COS(lat * PI() / 180) * POW(SIN((' . $lng . ' * PI() / 180 - lng * PI() / 180) / 2),2))) * 1000) AS distance FROM ' . $prefix . 'video  where uid !=' . $uid . ' and isdel=0 and status=1  and is_ad=0 order by distance asc,addtime desc limit ' . $start . ',' . $pnum);
		}
		

		if(!$info){
			return 1001;
		}


		foreach ($info as $k => $v) {
            
            $v=\App\handleVideo($uid,$v);
            $v['distance']=\App\distanceFormat($v['distance']);
            
            $info[$k]=$v;
			
		}
		
		return $info;
	}
	
	/*获取随机的视频*/
	public function getRandom($uid,$p)
	{
		if ($p < 1) {
			$p = 1;
		}
		$pnum = 20;
		$start = ($p - 1) * $pnum;
		
		$prefix = \PhalApi\DI()->config->get('dbs.tables.__default__.prefix');
		
		$sql = 'SELECT id FROM ' . $prefix . 'video WHERE uid != ' . $uid . ' AND isdel = 0 AND status = 1 AND is_ad = 0 ORDER BY RAND() LIMIT ' . $pnum;
		
		$randomIds = \PhalApi\DI()->notorm->video->queryAll($sql);

        // 使用随机的 id 查询实际的数据
		$randomIdList = array_column($randomIds, 'id');
		$ids = implode(',', $randomIdList);
		
		$sql = 'SELECT * FROM ' . $prefix . 'video WHERE id IN (' . $ids . ') ORDER BY FIELD(id, ' . $ids . ') LIMIT ' . $start . ',' . $pnum;
		
		$info = \PhalApi\DI()->notorm->video->queryAll($sql);
		
		
		
		if (!$info) {
			return 1001;
		}
		
		foreach($info as $k=>$v){
			
			$v=\App\handleVideo($uid,$v);
			
			$info[$k]=$v;
			
		}
		
		
		return $info;
	}
	
	/*获取关注人的视频*/
	public function getFocuson($uid,$p)
	{
		if ($p < 1) {
			$p = 1;
		}
		$pnum = 20;
		$start = ($p - 1) * $pnum;
		
		$focusons =  \PhalApi\DI()->notorm->user_attention
				->select('*')
				->where('uid=?', $uid)
				->fetchAll();
		$focus = [];
		 foreach ($focusons as $v){
			 $focus[] = $v['touid'];
		 }
		 if(empty($focus)){
			return 1001;
		}
		$focusStr = implode(',', $focus);
		
		$prefix = \PhalApi\DI()->config->get('dbs.tables.__default__.prefix');
		
		$info = \PhalApi\DI()->notorm->video->queryAll('select * FROM ' . $prefix . 'video  where uid !=' . $uid . ' and isdel=0 and status=1  and is_ad=0 and uid in (' . $focusStr . ') order by addtime DESC limit ' . $start . ',' . $pnum);
		
		if (!$info) {
			return 1001;
		}
		
		foreach($info as $k=>$v){
			
			$v=\App\handleVideo($uid,$v);
			
			$info[$k]=$v;
			
		}
		
		
		return $info;
	}
	
	/*获取互相关注人的视频(朋友)*/
	public function getFriend($uid, $p)
	{
		if ($p < 1) {
			$p = 1;
		}
		$pnum = 20;
		$start = ($p - 1) * $pnum;
		
		// 查询互相关注的用户，并按 `touid` 倒序
		$focusons = \PhalApi\DI()->notorm->user_attention
			->select('touid')
			->where('uid = ? AND touid IN (SELECT uid FROM cmf_user_attention WHERE touid = ?)', $uid, $uid)
			->order('touid DESC')  // 按 `touid` 倒序排列
			->fetchAll();
		
		// 将好友 ID 收集到数组中
		$focus = array_column($focusons, 'touid');

		if (empty($focus)) {
			return 1001; // 无朋友
		}
		
		$focusStr = implode(',', $focus);
		
		$prefix = \PhalApi\DI()->config->get('dbs.tables.__default__.prefix');
		
		// 仅查询这些朋友的视频信息，按 `uid` 倒序
		$info = \PhalApi\DI()->notorm->video->queryAll(
			'SELECT * FROM ' . $prefix . 'video WHERE uid != ' . $uid .
			' AND isdel = 0 AND status = 1 AND is_ad = 0 AND uid IN (' . $focusStr . ') ORDER BY uid DESC, addtime DESC LIMIT ' . $start . ',' . $pnum
		);
		
		if (!$info) {
			return 1001;
		}
		
		// 处理视频信息
		foreach ($info as $k => $v) {
			$info[$k] = \App\handleVideo($uid, $v);
		}
		
		return $info;
	}
	
	
	
	
	/* 举报分类列表 */
	public function getReportContentlist() {
		
		$reportlist=\PhalApi\DI()->notorm->video_report_classify
					->select("*")
					->order("list_order asc")
					->fetchAll();
		if(!$reportlist){
			return 1001;
		}

		//语言包
		$language=\PhalApi\DI()->language;
		foreach ($reportlist as $k => $v) {
			if($language=='en'){
				$reportlist[$k]['name']=$v['name_en'];
			}
		}
		
		return $reportlist;
		
	}

	/*更新视频看完次数*/
	public function setConversion($videoid){


		//更新视频看完次数
		$res=\PhalApi\DI()->notorm->video
				->where("id = '{$videoid}' and isdel=0 and status=1")
				->update(
					array(
						'watch_ok' => new \NotORM_Literal("watch_ok + 1")
					)
				);

		return 1;
	}

	
	/* 分类视频 */
	public function getClassVideo($videoclassid,$uid,$p){
        if($p<1){
            $p=1;
        }
		$nums=21;
		$start=($p-1)*$nums;
		$where="  isdel='0' and status=1  and classid={$videoclassid}";
		
		$video=\PhalApi\DI()->notorm->video
				->select("*")
				->where($where)
				->order("addtime desc")
				->limit($start,$nums)
				->fetchAll();

		
		foreach($video as $k=>$v){
			$v=\App\handleVideo($uid,$v);
            
            $video[$k]=$v;
		}

		return $video;
		
	}
	
	/*删除评论 删除子级评论*/
	public function delComments($uid,$videoid,$commentid,$commentuid) {
       $result=\PhalApi\DI()->notorm->video
					->select("uid")
					->where("id='{$videoid}'")
					->fetchOne();
					
		if(!$result){
			return 1001;
		}
		
		
		if($uid!=$commentuid){
			if($uid!=$result['uid']){
				return 1002;
			}
		}
		
		
		
		// 删除 评论记录
		\PhalApi\DI()->notorm->video_comments
					->where("id='{$commentid}'")
					->delete();
		//删除视频评论喜欢
		\PhalApi\DI()->notorm->video_comments_like
					->where("commentid='{$commentid}'")
					->delete();
		/* 更新 视频 */
		\PhalApi\DI()->notorm->video
            ->where("id = '{$videoid}' and comments>0")
		 	->update(
		 		array(
		 			'comments' => new \NotORM_Literal("comments - 1")
		 		)
		 	);
		
		
		//删除相关的子级评论
		$lists=\PhalApi\DI()->notorm->video_comments
				->select("*")
				->where("commentid='{$commentid}' or parentid='{$commentid}'")
				->fetchAll();
		foreach($lists as $k=>$v){
			//删除 评论记录
			\PhalApi\DI()->notorm->video_comments
						->where("id='{$v['id']}'")
						->delete();
			//删除视频评论喜欢
			\PhalApi\DI()->notorm->video_comments_like
						->where("commentid='{$v['id']}'")
						->delete();
						
			/* 更新 视频 */
			\PhalApi\DI()->notorm->video
				->where("id = '{$v['videoid']}' and comments>0")
				->update(
					array(
						'comments' => new \NotORM_Literal("comments - 1")
					)
				);
		}
		
		
		
		return 0;

    }


	public function getLikeVideos($uid,$touid,$p,$key){
		if ($uid != $touid){
			$uid = $touid;
		}
        if($p<1){
            $p=1;
        }
		$nums = 20;
		$start = ($p - 1) * $nums;
		$query =  \PhalApi\DI()->notorm->video_like
			->select('videoid')
			->where('uid = ? AND status = 1', $uid)
			->order('addtime desc');
		if (!$key){
			$videoLikes = $query
				->fetchAll();
		}else{
			$videoLikes = $query
				->limit($start, $nums)
				->fetchAll();
		}
	
		
		$videoIds = array_column($videoLikes, 'videoid');
		
		if (!empty($videoIds)) {
			// 获取 video 表中的视频详情
			$videoList = \PhalApi\DI()->notorm->video
				->where('id', $videoIds)
				->fetchAll();
			
			// 将视频详情转换为键值对数组，以便快速查找
			$videoMap = [];
			foreach ($videoList as $video) {
				$videoMap[$video['id']] = $video;
			}
			
			// 重新排序视频详情列表
			$videoListSorted = [];
			foreach ($videoIds as $videoId) {
				if (isset($videoMap[$videoId])) {
					$videoListSorted[] = $videoMap[$videoId];
				}
			}
			
			// 如果有搜索关键词，则进行过滤
			if ($key) {
				$videoListSorted = array_filter($videoListSorted, function($video) use ($key) {
					return stripos($video['title'], $key) !== false;
				});
			}
			
			$list = array_values($videoListSorted);
		} else {
			$list = [];
		}


		$video_list=[];
		
		foreach($list as $k=>$v){

			$video_info=\PhalApi\DI()->notorm->video
				->where(['id'=>$v['id']])
				->fetchOne();
    
			$video_list[]=\App\handleVideo($uid,$video_info);
   
			
		}

		
		return $video_list;
	}
	
	public function addWatchVideoLog($uid, $videoid,$status)
	{
		$findLog = \PhalApi\DI()->notorm->video_watch_log->where(['uid' => $uid, 'videoid' => $videoid])->fetchOne();
		if (!$findLog) {
			\PhalApi\DI()->notorm->video_watch_log
				->insert(
					array(
						'uid' => $uid,
						'videoid' => $videoid,
						'addtime_log' => time(),
						'status' => $status,
					)
				);
		}else{
			\PhalApi\DI()->notorm->video_watch_log
				->where([
					'uid' => $uid,
					'videoid' => $videoid
				])
				->update(
					array(
						'addtime_log' => time(),
						'status' => $status,
					)
				);
		}
		return 1;
	}
	
	
	public function getWatchVideoLog($uid, $key, $status, $p)
	{
		$nums = 20;
		$start = ($p - 1) * $nums;
		
		$prefix = \PhalApi\DI()->config->get('dbs.tables.__default__.prefix');
		
		$tableName = 'video';
		$logTableName = 'video_watch_log';
		
		$sql = 'SELECT vl.*, v.*
            FROM ' . $prefix . $logTableName . ' vl
            LEFT JOIN ' . $prefix . $tableName . ' v ON vl.videoid = v.id
            WHERE vl.uid = :uid
            AND v.isdel = 0
            AND v.status = 1
            AND v.is_ad = 0';
		
		// 如果 $key 不为空，则添加 title 过滤条件
		if (!empty($key)) {
			$sql .= ' AND v.title LIKE :key';
		}
		$status = (int)$status;
		// 根据 $status 添加筛选条件
		if ($status !== 2) {
			$sql .= ' AND vl.status = :status';
		}

		$sql .= ' ORDER BY vl.addtime_log DESC
              LIMIT :start, :pnum';
		
		$params = array(':uid' => $uid, ':start' => $start, ':pnum' => $nums);
		
		// 如果 $key 不为空，则添加到查询参数中
		if (!empty($key)) {
			$params[':key'] = '%' . $key . '%';
		}
		
		// 如果 $status 不是 2，则添加到查询参数中
		if ($status !== 2) {
			$params[':status'] = $status;
		}

		$info = \PhalApi\DI()->notorm->video->queryAll($sql, $params);
		
		foreach ($info as $k => $v) {
			unset($v['videoid']);
			$v = \App\handleVideo($uid, $v);
			$v['addtime_log'] = date('Y-m-d H:i:s', $v['addtime_log']);
			
			$info[$k] = $v;
		}
		
		return $info;
	}
	
	
	public function searchTopics($key, $p)
	{
		if ($p < 1) {
			$p = 1;
		}
		$nums = 20;
		$start = ($p - 1) * $nums;
		
		$list = \PhalApi\DI()->notorm->video_topics
			->select('topic_id,topic_name,description,use_nums')
			->where('topic_name LIKE ?', '%' . $key . '%')
			->order('addtime DESC')
			->limit($start, $nums)
			->fetchAll();
		
		return $list;
		
	}
	
	public function delWatchVideoLog($uid)
	{
		\PhalApi\DI()->notorm->video_watch_log
			->where([
				'uid' => $uid,
			])
			->delete();
			
		return '删除成功';
	}
	
}
