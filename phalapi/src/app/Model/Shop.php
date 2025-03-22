<?php
namespace App\Model;
use PhalApi\Model\NotORMModel as NotORM;
if (!session_id()) session_start();

class Shop extends NotORM {

    //检测用户是否缴纳保证金
    public function getBond($uid){
        $info=\PhalApi\DI()->notorm->shop_bond->where("uid=?",$uid)->fetchOne();
        if(!$info){
            return -1;
        }

        if($info['status']==0){
            return 1;
        }

        return 2;
    }

    //缴纳保证金
    public function deductBond($uid,$shop_bond){

        //检测用户是否已经缴纳
        $info=\PhalApi\DI()->notorm->shop_bond->where("uid=? and status !=0",$uid)->fetchOne();
        if($info){
            return 1001;
        }

        $isok=\PhalApi\DI()->notorm->user
            ->where("id=? and coin>=?",$uid,$shop_bond)
            ->update(
                array(
                    'coin' => new \NotORM_Literal("coin - {$shop_bond}")
                )
            );

        if(!$isok){
            return 1002;
        }

        //判断是否存在保证金已退回的情况
        $info2=\PhalApi\DI()->notorm->shop_bond->where("uid=? and status =0",$uid)->fetchOne();
        if($info2){

            //更新保证金记录
            $data=array(
                "bond"=>$shop_bond,
                "status"=>1,
                "addtime"=>time(),
                "uptime"=>0
            );

            $res=\PhalApi\DI()->notorm->shop_bond->where("uid=?",$uid)->update($data);

        }else{
            $data=array(
                "uid"=>$uid,
                "bond"=>$shop_bond,
                "status"=>1,
                "addtime"=>time(),
                "uptime"=>time()
            );

            $res=\PhalApi\DI()->notorm->shop_bond->insert($data);
        }

        if(!$res){
            return 1003;
        }

        //写入消费记录
        $data1=array(
            "type"=>'0',
            "action"=>'14',
            "uid"=>$uid,
            "touid"=>$uid,
            "giftid"=>0,
            "giftcount"=>1,
            "totalcoin"=>$shop_bond,
            "addtime"=>time()
        );

        \PhalApi\DI()->notorm->user_coinrecord->insert($data1);
	    
	    //写入消费记录
	    $data1 = array(
		    'type' => '0',
		    'action' => '5',
		    'uid' => $uid,
		    'totalcoin' => $shop_bond,
		    'addtime' => time()
	    );
	    
	    \PhalApi\DI()->notorm->user_coinrecord_all->insert($data1);

        return 1;
    }

    //获取一级商品分类
    public function getOneGoodsClass(){
        $list=[];

        $list1=\PhalApi\DI()->notorm->shop_goods_class->select("gc_one_id")->where("gc_grade=3")->fetchAll();

        if(!$list1){
            return [];
        }

        $gc_one_ids=array_column($list1,"gc_one_id");

        $ids=array_unique($gc_one_ids);

        //语言包
        $list=\PhalApi\DI()->notorm->shop_goods_class
            ->select("gc_id,gc_name,gc_name_en,gc_isshow")
            ->where("gc_id",$ids)
            ->where(" gc_isshow=1")
            ->order("gc_sort")
            ->fetchAll();

        return $list;
    }

    /*获取店铺认证信息*/
    public function getShopApplyInfo($uid){


        $res=array(
            'apply_status'=>'0',
            'apply_info'=>[]
        );

        $info=\PhalApi\DI()->notorm->shop_apply
                ->where("uid=?",$uid)
                ->fetchOne();

        if(!$info){
            $res['apply_status']='-1';
            return $res;
        }

        unset($info['name'],$info['thumb'],$info['des'],$info['license']);

        $info['certificate_format']=\App\get_upload_path($info['certificate']); //营业执照
        $info['other_format']=\App\get_upload_path($info['other']); //其他证件

        //获取用户的经营类目
        $goods_classid=\PhalApi\DI()->notorm->seller_goods_class->select("goods_classid as gc_id")->where("uid=? and status=1",$uid)->fetchAll();
        $info['goods_classid']=$goods_classid;

        //语言包
        $language=\PhalApi\DI()->language;
        if($language=='en'){
            $info['reason']=$info['reason_en'];
        }

        $status=$info['status'];

        if($status==0){ //审核中
            $res['apply_status']='0';
            return $res;
        }else if($status==1){ //审核通过
            $res['apply_status']='1';
            $res['apply_info']=$info;
            return $res;
        }else if($status==2){ //审核拒绝
            $res['apply_status']='2';
            $res['apply_info']=$info;
            return $res;
        }



        return $res;
    }

    /*店铺申请*/
    public function shopApply($uid,$data,$apply_status,$classid_arr){

        if($apply_status==-1){ //无申请记录
            $res=\PhalApi\DI()->notorm->shop_apply->insert($data);
        }

        if($apply_status==2){
            $res=\PhalApi\DI()->notorm->shop_apply->where("uid={$uid}")->update($data);
        }

        if(!$res){
            return 1001;
        }

        if($apply_status=1){

            //写入店铺总评分记录
            $data1=array(
                'shop_uid'=>$uid
            );

            \PhalApi\DI()->notorm->shop_points->insert($data1);
        }

        //更新商家经营类目
        \PhalApi\DI()->notorm->seller_goods_class->where("uid=?",$uid)->delete();
        foreach ($classid_arr as $k => $v) {
            if($v){
                $data1=array(
                    'uid'=>$uid,
                    'goods_classid'=>$v,
                    'status'=>1
                );
                \PhalApi\DI()->notorm->seller_goods_class->insert($data1);
            }
        }


        return 1;
    }


	/* 商铺信息 */
	public function getShop($uid,$fields='') {

        if(!$fields){
            $fields='uid,sale_nums,quality_points,service_points,express_points,certificate,other,service_phone,province,city,area,status';
        }

        $shop_info=\PhalApi\DI()->notorm->shop_apply
                    ->select($fields)
                    ->where('uid=?',$uid)
                    ->fetchOne();

        if(!$shop_info){
            return [];
        }

        if($uid==1){ //平台自营店铺
            $configpub=\App\getConfigPub();
            $shop_info['user_nickname']=\PhalApi\T("平台自营");
            $shop_info['name']=\PhalApi\T('{name}小店',['name'=>$configpub['site_name']]);
        }else{

            //获取用户信息
            $userinfo=\App\getUserInfo($uid);
            $shop_info['user_nickname']=$userinfo['user_nickname']; //用于进入私信聊天顶部显示昵称
            $shop_info['name']=\PhalApi\T('{name}的小店',['name'=>$userinfo['user_nickname']]);
        }



        if($shop_info['certificate']){
           $shop_info['certificate']=\App\get_upload_path($shop_info['certificate']);
        }

        if($shop_info['other']){
            $shop_info['other']=\App\get_upload_path($shop_info['other']);
        }

        $shop_info['sale_nums']=\App\NumberFormat($shop_info['sale_nums']);
        if($uid==1){
            $shop_info['avatar']=\App\get_upload_path("/default.jpg");
        }else{
           $shop_info['avatar']=\App\get_upload_path($userinfo['avatar']);
        }

        $shop_info['composite_points']=(string)number_format(($shop_info['quality_points']+$shop_info['service_points']+$shop_info['express_points'])/3,'1');
        $shop_info['composite_points']=$shop_info['composite_points']==0?'0.0':$shop_info['composite_points'];
        $shop_info['quality_points']=$shop_info['quality_points']>0?(string)$shop_info['quality_points']:\PhalApi\T('暂无评分');
        $shop_info['service_points']=$shop_info['service_points']>0?(string)$shop_info['service_points']:\PhalApi\T('暂无评分');
        $shop_info['express_points']=$shop_info['express_points']>0?(string)$shop_info['express_points']:\PhalApi\T('暂无评分');

        //获取店铺的上架产品总数
        $where=[];
        $where['uid']=$uid;
        $where['status']=1;

        $count=$this->countGoods($where);
        $shop_info['goods_nums']=$count;
        $shop_info['address_format']=$shop_info['city'].$shop_info['area'];

        //获取后台配置的店铺资质说明
        $configpri=\App\getConfigPri();

        //语言包
        $language=\PhalApi\DI()->language;
        $shop_info['certificate_desc']=$configpri['shop_certificate_desc'];

        if($language=='en'){
            $shop_info['certificate_desc']=$configpri['shop_certificate_desc_en'];
        }

        if(isset($shop_info['uid'])){
            $shop_info['uid']=(string)$shop_info['uid'];
        }

        if(isset($shop_info['sale_nums'])){
            $shop_info['sale_nums']=(string)$shop_info['sale_nums'];
        }

        if(isset($shop_info['status'])){
            $shop_info['status']=(string)$shop_info['status'];
        }

        if(isset($shop_info['goods_nums'])){
            $shop_info['goods_nums']=(string)$shop_info['goods_nums'];
        }


		return $shop_info;


	}
	
	public function getShopOnsalePlatformGoods($uid, $p)
	{
		if ($p < 1) {
			$p = 1;
		}
		
		$pnums = 50;
		
		$where = 'uid=' . $uid . ' and status=1';
		
		if ($p > 1) {
			$onsale_platform_addtime = $_SESSION['onsale_platform_addtime'];
			if ($onsale_platform_addtime) {
				$where .= ' and addtime<' . $onsale_platform_addtime;
			}
		}
		
		
		$list = \PhalApi\DI()->notorm->seller_platform_goods
			->where($where)
			->limit(0, $pnums)
			->order('addtime desc')
			->fetchAll();
		
		
		$goodsid_arr = [];
		foreach ($list as $k => $v) {
			$goodsid_arr[] = $v['goodsid'];
		}
		
		$goods_list = \PhalApi\DI()->notorm->shop_goods
			->select('id,name,thumbs,sale_nums,specs,hits,issale,type,original_price,present_price,status,live_isshow,commission')
			->where('id ', $goodsid_arr)
			->order('addtime desc')
			->fetchAll();
		
		$goods_list = \App\handlePlatformGoods($goods_list, [], 1);
		
		$end = end($list);
		if ($end) {
			
			$_SESSION['onsale_platform_addtime'] = $end['addtime'];
		}
		
		return $goods_list;
	}


    /* 自己店铺商品总数 */
    public function countGoods($where=[]){

        $nums=\PhalApi\DI()->notorm->shop_goods
                ->where($where)
                ->count();


        return $nums;
    }

    /* 获取商品信息 */
    public function getGoods($where=[]){

        $info=[];

        if($where){
            $info=\PhalApi\DI()->notorm->shop_goods
                    ->where($where)
                    ->fetchOne();
        }

        return $info;
    }

    /* 更新商品信息 */
    public function upGoods($where=[],$data=[]){
        $result=false;

        if($data){
            $result=\PhalApi\DI()->notorm->shop_goods
                    ->where($where)
                    ->update($data);
        }

        return $result;
    }



    //获取商品列表
    public function getGoodsList($where,$p){

        if($p>1){ //强制一页返回数据
            return [];
        }

        $list=\PhalApi\DI()->notorm->shop_goods
                ->select("id,name,thumbs,sale_nums,specs,hits,issale,type,original_price,present_price,status,live_isshow,commission")
                ->where($where)
                ->order("addtime desc")
                ->fetchAll();

        if(!$list){
            return [];
        }

        foreach ($list as $k => $v) {
            $thumb_arr=explode(',',$v['thumbs']);
            $list[$k]['thumb']=\App\get_upload_path($thumb_arr[0]);


            if($v['type']==1){ //外链商品
                $list[$k]['price']=$v['present_price'];
                $list[$k]['specs']=[];
            }else{
                $spec_arr=json_decode($v['specs'],true);
                $list[$k]['price']=$spec_arr[0]['price'];
                $list[$k]['specs']=$spec_arr;
            }


            unset($list[$k]['thumbs']);
            unset($list[$k]['present_price']);
            unset($list[$k]['specs']);
        }


        return $list;
    }

    //获取商品评价总数
    public function getGoodsCommentNums($goodsid){
        $count=\PhalApi\DI()->notorm->shop_order_comments->where("goodsid=? and is_append=0",$goodsid)->count();
        return $count;
    }

    //获取商品最新的三条评价
    public function getTopThreeGoodsComments($goodsid){
        $list=\PhalApi\DI()->notorm->shop_order_comments
                ->where("goodsid=? and is_append=0",$goodsid)
                ->order("addtime desc")
                ->limit(0,3)
                ->fetchAll();


        if($list){
            foreach ($list as $k => $v) {
                $list[$k]=\App\handleGoodsComments($v);
                $list[$k]['has_append_comment']='0';
                //获取评论的追评信息
                //$append_comment=\App\getGoodsAppendComment($v['uid'],$v['orderid']);
                $list[$k]['append_comment']=(object)[];
                /*if($append_comment){
                    $list[$k]['has_append_comment']='1';

                    $cha=$append_comment['addtime']-$v['addtime'];

                    if($cha<24*60*60){
                        $append_comment['date_tips']='当日评论';
                    }else{

                        $append_comment['date_tips']=floor($cha/(24*60*60)).'天后评论';
                    }
                    $list[$k]['append_comment']=\App\handleGoodsComments($append_comment);
                }*/

            }
        }

        return $list;
    }


    //获取商品评论列表
    public function getGoodsCommentList($uid,$goodsid,$type,$p){

        if($p<1){
            $p=1;
        }

        $pnums=50;

        $where="goodsid={$goodsid} and is_append=0";

        switch ($type) {

            case 'all':
                //$where="goodsid={$goodsid}";
                break;
            case 'img':
                $where="goodsid={$goodsid} and is_append=0 and thumbs !=''";
                break;

            case 'video':
                $where="goodsid={$goodsid} and is_append=0 and video_url !=''";
                break;

            case 'append':

                //获取有追评的评论订单ID
                $orderids=\PhalApi\DI()->notorm->shop_order_comments->where("goodsid={$goodsid} and is_append=1")->select("orderid")->fetchAll();
                if($orderids){
                    $orderid_arr=array_column($orderids, 'orderid');

                }else{

                    return [];
                }


                break;

        }

        if($p>1){
            $goodscomment_endtime=$_SESSION['goodscomment_endtime'];
            if($goodscomment_endtime){
                $where.=" and addtime<".$goodscomment_endtime;
            }

        }


        if($type=='append'){

            $list=\PhalApi\DI()->notorm->shop_order_comments
                ->where($where)
                ->where('orderid',$orderid_arr)
                ->order("addtime desc")
                ->limit(0,$pnums)
                ->fetchAll();


        }else{

            $list=\PhalApi\DI()->notorm->shop_order_comments
                ->where($where)
                ->order("addtime desc")
                ->limit(0,$pnums)
                ->fetchAll();
        }

        foreach ($list as $k => $v) {
            $v=\App\handleGoodsComments($v);
            $list[$k]=$v;
            $list[$k]['has_append_comment']='0';
            //获取评论的追评信息
            $append_comment=\App\getGoodsAppendComment($v['uid'],$v['orderid']);

            $list[$k]['append_comment']=(object)[];

            if($append_comment){

                $list[$k]['has_append_comment']='1';
                $cha=$append_comment['addtime']-$v['addtime'];

                if($cha<24*60*60){
                    $append_comment['date_tips']=\PhalApi\T('当日评论');
                }else{

                    $append_comment['date_tips']=\PhalApi\T('{num}天后评论',['num'=>floor($cha/(24*60*60))]);
                }

                $list[$k]['append_comment']=\App\handleGoodsComments($append_comment);
            }

        }

        $end=end($list);
        if($end){
            $_SESSION['goodscomment_endtime']=$end['addtime'];
        }

        return $list;

    }


    //获取商品评论不同类型下的评论总数
    public function getGoodsCommentsTypeNums($goodsid){

        $data=array();

        $data['all_nums']='0';
        $data['img_nums']='0';
        $data['video_nums']='0';
        $data['append_nums']='0';


        $all_nums=\PhalApi\DI()->notorm->shop_order_comments->where("goodsid=? and is_append=0",$goodsid)->count();

        $img_nums=\PhalApi\DI()->notorm->shop_order_comments->where("goodsid=? and is_append=0 and thumbs !=''",$goodsid)->count();

        $video_nums=\PhalApi\DI()->notorm->shop_order_comments->where("goodsid=? and is_append=0 and video_url !=''",$goodsid)->count();

        $append_nums=\PhalApi\DI()->notorm->shop_order_comments->where("goodsid=? and is_append=1 ",$goodsid)->count();


        $data['all_nums']=$all_nums;
        $data['img_nums']=$img_nums;
        $data['video_nums']=$video_nums;
        $data['append_nums']=$append_nums;

        return $data;

    }

    public function searchShopGoods($uid,$keywords,$p){
        if($p<1){
            $p=1;
        }

        $pnums=50;
        $start=($p-1)*$pnums;

        $where="uid={$uid} and status=1";

        if($keywords!=''){
            $where.=" and name like '%".$keywords."%'";
        }

        $list=\PhalApi\DI()->notorm->shop_goods
                ->select("id,specs,name,addtime")
                ->where($where)
                ->order("addtime desc")
                ->limit($start,$pnums)
                ->fetchAll();

        foreach ($list as $k => $v) {
            $goods_info=\App\handleGoods($v);
            $list[$k]['price']=$goods_info['specs_format'][0]['price'];
            $list[$k]['thumb']=$goods_info['specs_format'][0]['thumb'];
            unset($list[$k]['addtime']);
            unset($list[$k]['specs']);
        }

        return $list;
    }


	/* 收藏商品 */
	public function setCollect($uid,$goodsid,$goodsuid){
		//判断收藏列表情况
		$isexist=\PhalApi\DI()->notorm->user_goods_collect
					->select("*")
					->where('uid=? and goodsid=?',$uid,$goodsid)
					->fetchOne();
		if($isexist){
			\PhalApi\DI()->notorm->user_goods_collect
				->where('uid=? and goodsid=?',$uid,$goodsid)
				->delete();
			return '0';
		}else{
			\PhalApi\DI()->notorm->user_goods_collect
				->insert(
                    array(
                        "uid"=>$uid,
                        "goodsid"=>$goodsid,
                        "goodsuid"=>$goodsuid,
                        "addtime"=>time()
                    )
                );

			return '1';
		}
	}

	/* 收藏商品列表 */
	public function getGoodsCollect($uid,$p){


        $nums=50;
        $start=($p-1)*$nums;

		//收藏列表
		$lists=\PhalApi\DI()->notorm->user_goods_collect
					->select("goodsid")
					->where('uid=?',$uid)
					->order('addtime desc')
					->limit($start,$nums)
					->fetchAll();

		return $lists;
	}


	//获取正在经营的一级商品分类
    public function getBusinessCategory($uid){
        $list=[];

        $list1=\PhalApi\DI()->notorm->shop_goods_class->select("gc_one_id")->where("gc_grade=3")->fetchAll();
        if(!$list1){
            return [];
        }

        //语言包
        $gc_one_ids=array_column($list1,"gc_one_id");
        $ids=array_unique($gc_one_ids);
        $list=\PhalApi\DI()->notorm->shop_goods_class
			->select("gc_id,gc_name,gc_name_en,gc_isshow")
			->where("gc_id",$ids)
			->where("gc_isshow=1")
			->order("gc_sort")
			->fetchAll();

		//获取用户的经营类目
        $goods_classid_list=\PhalApi\DI()->notorm->seller_goods_class
			->select("goods_classid as gc_id")
			->where("uid=? and status=1",$uid)
			->fetchAll();

		$goods_gc_ids=array_column($goods_classid_list,"gc_id");
        $goods_classids=array_unique($goods_gc_ids);

        $language=\PhalApi\DI()->language;
		foreach($list as $k=>$v){
			$isexists='0';
			if(in_array($v['gc_id'],$goods_classids)){
				$isexists='1';
			}
			$list[$k]['isexists']=$isexists;

            if($language=='en'){
                $list[$k]['gc_name']=$v['gc_name_en'];
            }
		}

        return $list;
    }


	//获取正在申请的经营类目
	public function getApplyBusinessCategory($uid){
		$rs = array();

		$info=\PhalApi\DI()->notorm->apply_goods_class
			->select("goods_classid,status,reason")
			->where("uid=? and status!=1",$uid)
			->fetchOne();


		if($info){
			$classid_arr=explode(",",$info['goods_classid']);
			$list=[];

            //语言包
            $language=\PhalApi\DI()->language;
			foreach ($classid_arr as $k => $v) {
				$class_info=\PhalApi\DI()->notorm->shop_goods_class
					->select("gc_id,gc_name,gc_name_en,gc_isshow")
					->where("gc_id=?",$v)
					->fetchOne();
				if($class_info){
                    if($language=='en'){
                        $class_info['gc_name']=$class_info['gc_name_en'];
                    }
					$list[]=$class_info;
				}
			}


			$info['goods_class_list']=$list;
			unset($info['goods_classid']);
			$rs=$info;
		}


		return $rs;
	}


	//申请经营类目
	public function applyBusinessCategory($uid,$classid){

		$apply=\PhalApi\DI()->notorm->apply_goods_class
			->where("uid=? and status=0",$uid)
			->fetchOne();
		if($apply){
			return 1001;
		}

		//语言包
		//申请类目,添加或修改
		$data=array(
			'uid'=>$uid,
			'goods_classid'=>$classid,
			'reason'=>'',
            'reason_en'=>'',
			'status'=>0,
			'addtime'=>time(),
		);

		$configpri=\App\getConfigPri();
		$show_category_switch=$configpri['show_category_switch'];
		if(!$show_category_switch){
			$data['status']=1;
			$classids=explode(",",$classid);
			//更新用户经营类目
			foreach ($classids as $k => $v){
				//获取一级分类的状态
				$status=\PhalApi\DI()->notorm->shop_goods_class
					->select("gc_isshow")
					->where("gc_id=?",$v)
					->fetchOne();
				$data1=array(
					'uid'=>$uid,
					'goods_classid'=>$v,
					'status'=>$status['gc_isshow']
				);
				\PhalApi\DI()->notorm->seller_goods_class->insert($data1);
			}
		}

		$apply=\PhalApi\DI()->notorm->apply_goods_class
			->where("uid=? and status!=1",$uid)
			->update($data);
		if(!$apply){
			$apply=\PhalApi\DI()->notorm->apply_goods_class->insert($data);
		}
		return $apply;
	}



	//判断商品是否删除及下架
	public function getGoodExistence($uid,$goodsid){

		$info=\PhalApi\DI()->notorm->shop_goods
            ->where("id=?",$goodsid)
            ->fetchOne();

        if(($uid!=$info['uid'])&&$info['status']!=1){

            return 0;
        }

        return $info;
	}

    /* 代卖平台商品总数 */
    public function countPlatformSale($where){

        $nums=\PhalApi\DI()->notorm->seller_platform_goods
                ->where($where)
                ->count();


        return $nums;
    }


    //获取代卖平台商品列表
    public function onsalePlatformList($where,$p){

        if($p>1){ //加$p是为了适应小程序请求，其实是一次性返回数据
            return [];
        }

        $platform_list=\PhalApi\DI()->notorm->seller_platform_goods
            ->where($where)
            ->where("status=1 and issale=1")
            ->select("*")
            ->fetchAll();

        if(!$platform_list){
            return [];
        }

        $goodsid_arr=[];

        foreach ($platform_list as $k => $v) {
            $goodsid_arr[]=$v['goodsid'];
        }



        $list=\PhalApi\DI()->notorm->shop_goods
                ->select("id,name,thumbs,sale_nums,specs,hits,issale,type,original_price,present_price,status,live_isshow,commission")
                ->where("id ",$goodsid_arr)
                ->order("addtime desc")
                ->fetchAll();


        if(!$list){
            return [];
        }

        $type=1;
        $list=\App\handlePlatformGoods($list,$platform_list,$type);


        return $list;
    }
	
	//获取代卖平台商品列表
	public function onsalePlatformListNew($where, $p)
	{
		
		if ($p > 1) { //加$p是为了适应小程序请求，其实是一次性返回数据
			return [];
		}
		
		$platform_list = \PhalApi\DI()->notorm->seller_platform_goods
			->where($where)
			->where('status=1 and issale=1')
			->select('*')
			->fetchAll();
		
		if (!$platform_list) {
			return [];
		}
		
		$goodsid_arr = [];
		
		foreach ($platform_list as $k => $v) {
			$goodsid_arr[] = $v['goodsid'];
		}
		
		
		$list = \PhalApi\DI()->notorm->shop_goods
			->select('id,name,thumbs,sale_nums,specs,hits,issale,type,original_price,present_price,status,live_isshow,commission,content')
			->where('id ', $goodsid_arr)
			->order('addtime desc')
			->fetchAll();
		
		
		if (!$list) {
			return [];
		}
		
		$type = 1;
		$list = \App\handlePlatformGoodsNew($list, $platform_list, $type);
		
		
		return $list;
	}

    //主播增删代售的平台商品
    public function setPlatformGoodsSale($uid,$goodsid,$issale){
        //判断用户是否代卖了该商品

        $where=[];
        $where['uid']=$uid;
        $where['goodsid']=$goodsid;

        $info=\PhalApi\DI()->notorm->seller_platform_goods
        ->where($where)
        ->fetchOne();

        if(!$info){
            return 1001;
        }

        if(!$info['status']){
            return 1002;
        }

        if($issale){ //添加到直播间销售
            if($info['issale']){
                return 1004;
            }
        }else{
            if(!$info['issale']){
                return 1005;
            }
        }



        $data['issale']=$issale;
        if($issale==0){
            $data['live_isshow']=0;
        }


        $res=\PhalApi\DI()->notorm->seller_platform_goods
        ->where($where)
        ->update($data);

        if(!$res){
            return 1003;
        }

        return 1;
    }

    //用户代售平台的商品搜索
    public function searchOnsalePlatformGoods($uid,$keywords,$p){
        if($p>1){
            return [];
        }

        $where=[];
        $where['uid']=$uid;
        $where['status']=1;

        $platform_list=\PhalApi\DI()->notorm->seller_platform_goods
        ->where($where)
        ->fetchAll();

        if(!$platform_list){
            return [];
        }

        $goodsid_arr=[];
        foreach ($platform_list as $k => $v) {
            $goodsid_arr[]=$v['goodsid'];
        }

        $list=\PhalApi\DI()->notorm->shop_goods
                ->select("id,name,thumbs,sale_nums,specs,hits,issale,type,original_price,present_price,status,live_isshow,commission")
                ->where("id ",$goodsid_arr)
                ->where("name like '%".$keywords."%'")
                ->order("addtime desc")
                ->fetchAll();


        if(!$list){
            return [];
        }

        $type=0;
        $list=\App\handlePlatformGoods($list,$platform_list,$type);

        return $list;

    }

    //获取店铺代售平台商品列表
    public function getOnsalePlatformGoods($uid,$p){
        if($p<1){
            $p=1;
        }

        $pnums=50;

        $where="uid=".$uid." and status=1";

        if($p>1){
            $onsale_platform_addtime=$_SESSION['onsale_platform_addtime'];
            if($onsale_platform_addtime){
                $where.=" and addtime<".$onsale_platform_addtime;
            }
        }


        $list=\PhalApi\DI()->notorm->seller_platform_goods
        ->where($where)
        ->limit(0,$pnums)
        ->order("addtime desc")
        ->fetchAll();


        $goodsid_arr=[];
        foreach ($list as $k => $v) {
            $goodsid_arr[]=$v['goodsid'];
        }

        $goods_list=\PhalApi\DI()->notorm->shop_goods
                ->select("id,name,thumbs,sale_nums,specs,hits,issale,type,original_price,present_price,status,live_isshow,commission")
                ->where("id ",$goodsid_arr)
                ->order("addtime desc")
                ->fetchAll();

        $goods_list=\App\handlePlatformGoods($goods_list,[],1);

        $end=end($list);
        if($end){

            $_SESSION['onsale_platform_addtime']=$end['addtime'];
        }

        return $goods_list;
    }


    public function delGoodsCollect($uid,$new_arr){
        $res=\PhalApi\DI()->notorm->user_goods_collect
            ->where("uid=?",$uid)
            ->where("goodsid",$new_arr)
            ->delete();

        return $res;
    }

	public function getShoppingCartList($uid)
	{
		$prefix = \PhalApi\DI()->config->get('dbs.tables.__default__.prefix');

		$tableNameCart = 'shop_cart';
		$tableNameGoods = 'shop_goods';

		$sql = 'SELECT vl.*, v.id,v.uid as goods_uid,v.name,v.thumbs,v.sale_nums,v.specs,v.hits,v.issale,v.type,v.original_price,v.present_price,v.status,v.live_isshow,v.commission,v.postage
		        FROM ' . $prefix . $tableNameCart . ' vl
		        LEFT JOIN ' . $prefix . $tableNameGoods . ' v ON vl.goodsid = v.id
		        WHERE vl.uid = :uid
		        ORDER BY vl.addtime DESC';

		$getShopCart = \PhalApi\DI()->notorm->shop_cart->queryAll($sql, array(':uid' => $uid));
		if (!$getShopCart){
			return [];
		}
		$listGoods = [];
		foreach ($getShopCart as $k => $v){
			$specid = $v['specid'];
			$v['specs'] = json_decode($v['specs'], true);
			$filteredSpecs = array_filter($v['specs'], function ($spec) use ($specid) {
				return $spec['spec_id'] == $specid;
			});
			$specs= array_values($filteredSpecs);
			if (!empty($specs)) {
				$v['specs'] = $specs[0];
			}
			$listGoods[] = $v;
		}

		$list = [];
		foreach ($listGoods as $k=>$v) {
			$thumb_arr=explode(',',$v['thumbs']);
			$listGoods[$k]['thumb']=\App\get_upload_path($thumb_arr[0]);
			$v['thumbs'] = \App\get_upload_path($v['thumbs']);
			if($v['specs']){
				$v['specs']['thumb'] = \App\get_upload_path($v['specs']['thumb']);
			}
			$v['postage'] = number_format($v['postage'], 2);
			if($v['type']==1){ //外链商品
				$listGoods[$k]['price']=$v['present_price'];
				$listGoods[$k]['specs']=[];
			}
			unset($listGoods[$k]['thumbs']);
			unset($listGoods[$k]['present_price']);
			unset($listGoods[$k]['specs']);
			$list[]  = $v;
		}

		$result = [];

		// 遍历原始数据
		foreach ($list as $item) {
			// 获取当前条目的 goods_uid
			$goodsUid = $item['goods_uid'];
			//获取用户信息
			$userinfo=\App\getUserInfo($goodsUid);
			$goodsName['goods_name']=\PhalApi\T('{name}的小店',['name'=>$userinfo['user_nickname']]);
			$goodsName['thumb'] = \App\get_upload_path($userinfo['avatar']);
			// 如果 result 数组中已经存在该 goods_uid 的分组，则将当前条目添加到对应的分组中
			if (isset($result[$goodsUid])) {
				$result[$goodsUid]['cart_list'][] = $item;
			}
			// 否则，创建一个新的分组并将当前条目添加到该分组中
			else {
				$result[$goodsUid] = [
					'goods_uid' => $goodsUid,
					'goods_name' =>$goodsName['goods_name'],
					'thumb' => $goodsName['thumb'],
					'cart_list' => [$item]
				];
			}
		}

//		 将结果转换为索引数组形式，以符合您的要求
		$list = array_values($result);
		return $list;
	}

	public function addShoppingCart($uid, $goodsid, $num,$specid)
	{
		$goods = \PhalApi\DI()->notorm->shop_goods
			->where(['id'=>$goodsid,'status'=>1])
			->fetchOne();
		if(!$goods){
			return 1001;
		}
		$getShopCart = \PhalApi\DI()->notorm->shop_cart
			->where(['uid'=>$uid,'goodsid'=>$goodsid,'specid' => $specid])
			->fetchOne();
		if($getShopCart){
			$res=\PhalApi\DI()->notorm->shop_cart
				->where(['uid'=>$uid,'goodsid'=>$goodsid,'specid' => $specid])
				->update(['nums' => $getShopCart['nums']+$num,'addtime'=>time()]);
			if(!$res){
				return 1003;
			}
		}else{
			$res= \PhalApi\DI()->notorm-> shop_cart
				->insert(
					array(
						'uid' => $uid,
						'goodsid' => $goodsid,
						'nums' => $num,
						'addtime' => time(),
						'specid' => $specid,
					)
				);
			if(!$res){
				return 1003;
			}
		}

		return 1;
	}

	public function updateShoppingCart($uid, $cartid, $num)
	{
		$findCart = \PhalApi\DI()->notorm->shop_cart
			->where(['uid'=>$uid,'cartid'=>$cartid])
			->fetchOne();
		if(!$findCart){
			return 1002;
		}

		$goods = \PhalApi\DI()->notorm->shop_goods
			->where(['id'=>$findCart['goodsid'],'status'=>1])
			->fetchOne();
		if(!$goods){
			return 1001;
		}
		$res=\PhalApi\DI()->notorm->shop_cart
			->where(['cartid'=>$findCart['cartid']])
			->update(['nums' => $num,'addtime'=>time()]);
		if(!$res){
			return 1003;
		}
		return 1;

	}

	public function delShoppingCart($uid, $cartids)
	{
		$cartidsArray = explode(',', $cartids);
		  \PhalApi\DI()->notorm->shop_cart
			      ->where([
					  'uid' => $uid,
				      'cartid' => $cartidsArray
			      ])->delete();
		  return 1;
	}

	public function isApplyShop($uid)
	{
		$findVideoNums = \PhalApi\DI()->notorm->video
			->where("uid=? and status=1 and isdel=0",$uid)
			->count();
		$findFansNums = \PhalApi\DI()->notorm->user_attention
			->select('uid')
			->where('touid=?', $uid)
			->count();
		$findAuth = \PhalApi\DI()->notorm->user_auth
			->where('uid=?', $uid)
			->fetchOne();
		$conditionVideoNums = 10;
		$conditionFansNums = 0;
		$res['isvideo_go'] = ($findVideoNums >= $conditionVideoNums) ? 1 : 0;
		$res['isfans_go'] = ($findFansNums >= $conditionFansNums) ? 1 : 0;
		$res['isauth_go'] = ($findAuth) ? 1 : 0;
		$res['video_nums'] = $findVideoNums;
		$res['fans_nums'] = $findVideoNums;
		return $res;
	}

	public function ProductGuarantees($str)
	{
		$findProductGuarantees = \PhalApi\DI()->notorm->product_guarantees
			->where('FIND_IN_SET(id, ?)',$str)
			->where('is_active=1')
			->select('type,detail')
			->fetchAll();
		return $findProductGuarantees;
	}
	
	public function getCart($where)
	{
		$info=[];
		
		if($where){
			$info=\PhalApi\DI()->notorm->shop_cart
				->where($where)
				->fetchOne();
		}
		
		return $info;
	}
	
	/*店铺申请新*/
	public function shopApplyNew($uid, $data, $apply_status, $classid_arr)
	{
		
		if ($apply_status == -1) { //无申请记录
			$res = \PhalApi\DI()->notorm->shop_apply->insert($data);
		}
		
		if ($apply_status == 2) {
			$res = \PhalApi\DI()->notorm->shop_apply->where("uid={$uid}")->update($data);
		}
		
		if (!$res) {
			return 1001;
		}
		
		if ($apply_status = 1) {
			
			//写入店铺总评分记录
			$data1 = array(
				'shop_uid' => $uid
			);
			
			\PhalApi\DI()->notorm->shop_points->insert($data1);
		}
		
		//更新商家经营类目
		\PhalApi\DI()->notorm->seller_goods_class->where('uid=?', $uid)->delete();
		foreach ($classid_arr as $k => $v) {
			if ($v) {
				$data1 = array(
					'uid' => $uid,
					'goods_classid' => $v,
					'status' => 1
				);
				\PhalApi\DI()->notorm->seller_goods_class->insert($data1);
			}
		}
		
		return 1;
	}
	
	public function liveScore($liveuid)
	{
		$info = \PhalApi\DI()->notorm->shop_points
			->where('shop_uid=?', $liveuid)
			->fetchOne();
		return $info ? $info['quality_points_total'] : 0;
		
	}
	//获取商品列表new
	public function getGoodsListNew($where, $p)
	{
		if ($p > 1) { //强制一页返回数据
			return [];
		}
		
		$list = \PhalApi\DI()->notorm->shop_goods
			->select('id,name,thumbs,sale_nums,specs,hits,issale,type,original_price,present_price,status,live_isshow,commission,content')
			->where($where)
			->order('addtime desc')
			->fetchAll();
		
		if (!$list) {
			return [];
		}
		
		foreach ($list as $k => $v) {
			$thumb_arr = explode(',', $v['thumbs']);
			$list[$k]['thumb'] = \App\get_upload_path($thumb_arr[0]);
			
			
			if ($v['type'] == 1) { //外链商品
				$list[$k]['price'] = $v['present_price'];
				$list[$k]['specs'] = [];
			} else {
				
				$spec_arr = json_decode($v['specs'], true);
				$list[$k]['price'] = $spec_arr[0]['price'];
				$spec_arr = array_map(function ($v) {
					$v['thumb'] = \App\get_upload_path($v['thumb']);
					return $v;
				}, $spec_arr);
				$list[$k]['specs'] = $spec_arr;
				
			}
			
			
			unset($list[$k]['thumbs']);
//			unset($list[$k]['present_price']);
//			unset($list[$k]['specs']);
		}
		
		
		return $list;
		
	}
	
}
