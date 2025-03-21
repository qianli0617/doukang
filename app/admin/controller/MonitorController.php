<?php

/**
 * 直播监控
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class MonitorController extends AdminbaseController {
    function index(){

		$config=getConfigPri();
		$this->config=$config;
		$this->assign('config', $config);
        
        $lists = Db::name("live")
            ->where(['islive'=>1,'isvideo'=>0])
			->order("starttime desc")
			->paginate(6);
        
        $lists->each(function($v,$k){
			$v['userinfo']=getUserInfo($v['uid']);
            if($this->config['cdn_switch']==5){
                $auth_url=$v['pull'];
            }else{
                $auth_url=PrivateKeyA('http',$v['stream'].'.flv',0);
            }
            $v['url']=$auth_url;
            return $v; 
        });

        $page = $lists->render();

    	$this->assign('lists', $lists);
    	$this->assign("page", $page);
    	return $this->fetch();
    }
    
	public function full(){
        $uid = $this->request->param('uid', 0, 'intval');
        
        $where['islive']=1;
        $where['uid']=$uid;
        
		$live=Db::name("live")->where($where)->find();
		$config=getConfigPri();
        
		if($live['title']=="")
		{
			$live['title']="直播监控后台";
		}
        
        if($config['cdn_switch']==5){
            $pull=$live['pull'];
        }else{
            $pull=urldecode(PrivateKeyA('http',$live['stream'].'.flv',0));
        }
		$live['pull']=$pull;
		$this->assign('config', $config);
		$this->assign('live', $live);
        
		return $this->fetch();
	}

    /**
     * @desc 关播
     * @return void
     */
	public function stopRoom(){
        
		$uid = $this->request->param('uid', 0, 'intval');
        $this->closeLive($uid);

        $action="监控 关闭直播间：{$uid}";
        setAdminLog($action);

		$this->success("操作成功！");
	}

	private function closeLive($uid){
		$where['islive']=1;
        $where['uid']=$uid;
        
		$liveinfo=Db::name("live")
            ->field("uid,showid,starttime,title,province,city,stream,lng,lat,type,type_val,liveclassid")
            ->where($where)
            ->find();
        
		Db::name("live")->where(" uid='{$uid}'")->delete();
        
		if($liveinfo){
			$liveinfo['endtime']=time();
			$liveinfo['time']=date("Y-m-d",$liveinfo['showid']);
            
            $where2=[];
            $where2['touid']=$uid;
            $where2['showid']=$liveinfo['showid'];
            
			$votes=Db::name("user_coinrecord")
				->where($where2)
				->sum('totalcoin');
			$liveinfo['votes']=0;
			if($votes){
				$liveinfo['votes']=$votes;
			}
            
            $stream=$liveinfo['stream'];
			$nums=zSize('user_'.$stream);

			hDel("livelist",$uid);
			delcache($uid.'_zombie');
			delcache($uid.'_zombie_uid');
			delcache('attention_'.$uid);
			delcache('user_'.$stream);
			
			
			$liveinfo['nums']=$nums;
			
			Db::name("live_record")->insert($liveinfo);
            
            /* 游戏处理 */
            $where3=[];
            $where3['state']=0;
            $where3['liveuid']=$uid;
            $where3['stream']=$stream;
            
			$game=Db::name("game")
				->where($where3)
				->find();
			if($game){
				$total=Db::name("gamerecord")
					->field("uid,sum(coin_1 + coin_2 + coin_3 + coin_4 + coin_5 + coin_6) as total")
					->where(["gameid"=>$game['id']])
					->group('uid')
					->select();
				foreach($total as $k=>$v){
                    
                    Db::name("user")->where(["id"=> $v['uid']])->inc('coin',$v['total'])->update();

					delcache('userinfo_'.$v['uid']);
					
					$insert=array(
                        "type"=>'1',
                        "action"=>'20',
                        "uid"=>$v['uid'],
                        "touid"=>$v['uid'],
                        "giftid"=>$game['id'],
                        "giftcount"=>1,
                        "totalcoin"=>$v['total'],
                        "addtime"=>$nowtime
                    );
                    
                    Db::name("user_coinrecord")->insert($insert);
				}

				Db::name("game")->where(["id"=> $game['id']])->save(array('state' =>'3','endtime' => time() ) );
				$brandToken=$stream."_".$game["action"]."_".$game['starttime']."_Game";
				delcache($brandToken);
			}   
		}
	}

	//封禁直播间
	public function banRoom(){
		$rs=array('code'=>'0','msg'=>'封禁成功','info'=>array());
		$uid = $this->request->param('roomid', 0, 'intval');
		$length = $this->request->param('length');

        $this->closeLive($uid);
        $now=time();
        $type='';

        switch ($length) {
        	case '30min':
        		$endtime=$now+30*60;
        		$type='30min';
        		break;

        	case '1day':
        		$endtime=strtotime("+1 day");
        		$type='1day';
        		break;

        	case '7day':
        		$endtime=strtotime("+7 day");
        		$type='7day';
        		break;

        	case '15day':
        		$endtime=strtotime("+15 day");
        		$type='15day';
        		break;

        	case '30day':
        		$endtime=strtotime("+30 day");
        		$type='30day';
        		break;

        	case '90day':
        		$endtime=strtotime("+90 day");
        		$type='90day';
        		break;

        	case '180day':
        		$endtime=strtotime("+180 day");
        		$type='180day';
        		break;

        	case 'all':
        		$endtime=0;
        		$type='all';
        		break;
        	
        	default:
        		$endtime=0;
        		break;
        }


        $ban_info=Db::name("live_ban")->where(['liveuid'=>$uid])->find();
        if($ban_info){
        	$res=Db::name("live_ban")
                ->where(['liveuid'=>$uid])
                ->update(
                    ['superid'=>1,'endtime'=>$endtime,'type'=>$type]
                );
        }else{
        	$res=Db::name("live_ban")->insert(
        		[
        			'liveuid'=>$uid,
        			'superid'=>1,
        			'addtime'=>$now,
        			'endtime'=>$endtime,
        			'type'=>$type
        		]
        	);
        }

        if(!$res){
        	$rs['code']=1001;
        	$rs['msg']='封禁失败';
        	echo json_encode($rs);
        	return;
        }
        echo json_encode($rs);
	}				
}
