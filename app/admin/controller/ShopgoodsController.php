<?php

/**
 * 商品
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class ShopgoodsController extends AdminbaseController {

    protected function getStatus($k=''){
        $status=[
            '-2'=>'管理员下架',
            '-1'=>'商家下架',
            '0'=>'审核中',
            '1'=>'通过',
            '2'=>'拒绝',
        ];
        if($k===''){
            return $status;
        }
        return $status[$k] ?? '';
    }

    protected function getType($k=''){
        $type=[
            
            '0'=>'站内商品',
            '1'=>'外链商品',
            '2'=>'自营商品',
        ];
        if($k===''){
            return $type;
        }
        return $type[$k] ?? '';
    }
    
    function index(){
        $data = $this->request->param();
        $map=[];
        
        $start_time= $data['start_time'] ?? '';
        $end_time= $data['end_time'] ?? '';
        
        if($start_time!=""){
           $map[]=['addtime','>=',strtotime($start_time)];
        }

        if($end_time!=""){
           $map[]=['addtime','<=',strtotime($end_time) + 60*60*24];
        }

        $uid=$data['uid'] ?? '';
        if($uid!=''){
            $lianguid=getLianguser($uid);
            if($lianguid){
                //$map[]=['uid',['=',$uid],['in',$lianguid],'or'];
                array_push($lianguid,$uid);
                $map[]=['uid','in',$lianguid];
            }else{
                $map[]=['uid','=',$uid];
            }
        }

        $isrecom= $data['isrecom'] ?? '';
        if($isrecom!=''){
			$map[]=['isrecom','=',$isrecom];
        }
        
        $keyword= $data['keyword'] ?? '';
        if($keyword!=''){
            $map[]=['name','like','%'.$keyword.'%'];
        }
		
        $goods_type= $data['goods_type'] ?? '';
        if($goods_type!=''){
            $map[]=['type','=',$goods_type];
        }

    	$lists = Db::name("shop_goods")
                ->where($map)
                ->order("id DESC")
                ->paginate(20);
        
        $lists->each(function($v,$k){
			$v['userinfo']=getUserInfo($v['uid']);
			$oneclass_name=Db::name("shop_goods_class")->where("gc_id={$v['one_classid']}")->value("gc_name");
			$twoclass_name=Db::name("shop_goods_class")->where("gc_id={$v['two_classid']}")->value("gc_name");
			$threeclass_name=Db::name("shop_goods_class")->where("gc_id={$v['three_classid']}")->value("gc_name");

			$v['oneclass_name']= $oneclass_name ?? '';
			$v['twoclass_name']= $twoclass_name ?? '';
			$v['threeclass_name']= $threeclass_name ?? '';

			$thumb_arr=explode(',',$v['thumbs']);
			$v['thumb']=get_upload_path($thumb_arr[0]);

            if($v['admin_id']){
                $v['admin_userinfo']=getUserInfo($v['admin_id']);
            }else{
                $v['admin_userinfo']=[];
            }

            return $v;           
        });
        
        $lists->appends($data);
        $page = $lists->render();

    	$this->assign('lists', $lists);
    	$this->assign("page", $page);
    	$this->assign('status', $this->getStatus());
        $this->assign('type', $this->getType());
    	return $this->fetch();
    }
    

    //上架/下架
    function setStatus(){

        $data = $this->request->param();
        $status=$data['status'];
        
        if(isset($data['id'])){

        	$id=$data['id'];

            $goodsinfo=DB::name('shop_goods')->where("id={$id}")->find();

            if($status==1){ //上架操作
                //判断商品所属用户是否注销
                $is_destroy=checkIsDestroy($goodsinfo['uid']);
                if($is_destroy){
                    $this->error('该用户已注销,商品不可上架');
                }
            }

            //判断商品是否在直播间代售
            if($status==-2){ //下架
                $sale_platform=Db::name("seller_platform_goods")->where("goodsid={$id} and (issale=1 or live_isshow=1)")->count();
                if($sale_platform){
                    $this->error("有主播正在直播间代售该商品，暂时无法下架");
                }
            }

        	$rs = DB::name('shop_goods')->where("id={$id}")->update(['status'=>$status]);

	        if(!$rs){
	            $this->error("操作失败！");
	        }

            if($goodsinfo['uid']!=1){ //用户自己发布的商品

                if($status==-2){
                    $title='你的商品“'.$goodsinfo['name'].'”已被平台下架。';
                    $title_en="Your product ".$goodsinfo['name']." has been removed from the platform.";
                }else{
                    $title='你的商品“'.$goodsinfo['name'].'”已被平台上架成功。';
                    $title_en="Your product ".$goodsinfo['name']." has been successfully listed on the platform.";
                }
                //写入记录表
                addSysytemInfo($goodsinfo['uid'],$title,$title_en,1);

                //发送腾讯云推送
                //type=2 非直播开播消息


                txMessageTpns('商品审核',$title,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'zh-cn');
                sleep(2);
                txMessageTpns('Product review',$title_en,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'en');

            }else{ //平台自营商品

                //将主播代售商品列表中的该商品全部下架
                $where=[];
                $where['goodsid']=$id;

                if($status==-2){ //下架
                    $post_data=[];
                    $post_data['status']=0;
                    $post_data['issale']=0;
                    $post_data['live_isshow']=0;
                }else{ //上架
                    $post_data=[];
                    $post_data['status']=1;
                }

                setOnsalePlatformInfo($where,$post_data);
            }

            if($status==-2){ //下架
                setDynamicGoodsStatus(0,$id);
            }else{
                setDynamicGoodsStatus(1,$id);
            }

            $admin_id=cmf_get_current_admin_id();
	
			if($status==-2){
				$action=$admin_id.'下架商品ID: '.$id;
			}else{
				$action=$admin_id.'上架商品ID: '.$id;
			}
			setAdminLog($action);

        }else if(isset($data['ids'])){

        	$ids = $data['ids'];

            foreach ($ids as $k => $v) {

                if($status==-2){ //下架

                    //判断直播间是否在售商品
                    $sale_platform=Db::name("seller_platform_goods")
                        ->where("goodsid={$v} and (issale=1 or live_isshow=1)")
                        ->count();
                    if($sale_platform){
                        continue;
                    }  
                }

                DB::name('shop_goods')->where("id={$v}")->update(['status'=>$status]);

                if($status==-2){
                    setDynamicGoodsStatus(0,$v);
                }else{
                    setDynamicGoodsStatus(1,$v);
                }

                //获取商品信息
                $goodsinfo=DB::name('shop_goods')->where("id={$v}")->find();

                if($goodsinfo['uid']!=1){ //用户自己发布的商品

                    if($status==-2){
                        $title='你的商品“'.$goodsinfo['name'].'”已被平台下架。';
                        $title_en="Your product ".$goodsinfo['name']." has been removed from the platform.";
                    }else{
                        $title='你的商品“'.$goodsinfo['name'].'”已被平台上架成功。';
                        $title_en="Your product ".$goodsinfo['name']." has been successfully listed on the platform.";
                    }

                    //写入记录表
                    addSysytemInfo($goodsinfo['uid'],$title,$title_en,1);

                    //发送腾讯云推送
                    //type=2 非直播开播消息
                    

                    txMessageTpns('商品审核',$title,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'zh-cn');
                    sleep(2);
                    txMessageTpns('Product review',$title_en,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'en');

                }else{//平台商品

                    //将主播代售商品列表中的该商品全部下架
                    $where=[];
                    $where['goodsid']=$v;

                    if($status==-2){ //下架

                        $post_data=[];
                        $post_data['status']=0;
                        $post_data['issale']=0;
                        $post_data['live_isshow']=0;

                    }else{ //上架

                        $post_data=[];
                        $post_data['status']=1;
                    }

                    setOnsalePlatformInfo($where,$post_data);

                }

            }

			$admin_id=cmf_get_current_admin_id();
			if($status==-2){
				$action=$admin_id.'下架商品IDS: '.json_encode($ids);
			}else{
				$action=$admin_id.'上架商品IDS: '.json_encode($ids);
			}
			setAdminLog($action);

        }
        
        $this->success("操作成功！");
    }
    
    
    function setRecom(){
        
        $id = $this->request->param('id', 0, 'intval');
        $isrecom = $this->request->param('isrecom', 0, 'intval');

        $rs = DB::name('shop_goods')->where("id={$id}")->update(['isrecom'=>$isrecom]);
        if(!$rs){
            $this->error("操作失败！");
        }

		if($isrecom==1){
			$action='推荐商品ID: '.$id;
		}else{
			$action='取消推荐商品ID: '.$id;
		}
		setAdminLog($action);

        $this->success("操作成功！");
    }
		
    function del(){

    	$data=$this->request->param();

    	if(isset($data['id'])){

    		$id = $data['id'];

            //判断代售该商品的用户是否有在直播间销售的
            $sale_platform=Db::name("seller_platform_goods")
                ->where("goodsid={$id} and (issale=1 or live_isshow=1)")
                ->count();

            if($sale_platform){
                $this->error("有主播正在直播间代售该商品，暂时无法删除");
            }

            $goodsinfo=DB::name('shop_goods')->where("id={$id}")->find();

	        $rs = DB::name('shop_goods')->where("id={$id}")->delete();
	        if(!$rs){
	            $this->error("删除失败！");
	        }

            if($goodsinfo['uid']>1){

                $title='你的商品“'.$goodsinfo['name'].'”已被平台删除。';
                $title_en="Your product ".$goodsinfo['name']." has been deleted by the platform.";
                //写入记录
                addSysytemInfo($goodsinfo['uid'],$title,$title_en,1);

                //发送腾讯云推送
                //type=2 非直播开播消息
                

                txMessageTpns('商品审核',$title,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'zh-cn');
                sleep(2);
                txMessageTpns('Product review',$title_en,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'en');

            }

            //删除商品访问记录
            Db::name("user_goods_visit")->where("goodsid={$id}")->delete();
            //修改视频的绑定信息
            Db::name("video")->where("type=1 and goodsid={$id}")->update(array('type'=>0,'goodsid'=>0));
			//删除收藏的商品
			Db::name('user_goods_collect')->where("goodsid='{$id}'")->delete();
            //删除代售商品记录
            Db::name("seller_platform_goods")->where("goodsid={$id}")->delete();
            //删除分享商品的动态
            Db::name("dynamic")->where(['goodsid'=>$id])->delete();

			$action='删除商品ID: '.$id;
			setAdminLog($action);

    	}else if(isset($data['ids'])){

    		$ids=$data['ids'];

            foreach ($ids as $k => $v) {

                //判断是否有主播在直播间代售该商品
                
                $sale_platform=Db::name("seller_platform_goods")->where("goodsid={$v} and (issale=1 or live_isshow=1)")->count();

                if($sale_platform){
                    continue;
                }

                $goodsinfo=DB::name('shop_goods')->where("id={$v}")->find();

                $rs = DB::name('shop_goods')->where("id={$v}")->delete();

                if($goodsinfo['uid']>0){

                    $title='你的商品“'.$goodsinfo['name'].'”已被平台删除。';
                    $title_en="Your product ".$goodsinfo['name']." has been deleted by the platform.";

                    
                    //写入记录
                    addSysytemInfo($goodsinfo['uid'],$title,$title_en,1);

                    //发送腾讯云推送
                    //type=2 非直播开播消息
                    

                    txMessageTpns('商品审核',$title,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'zh-cn');
                    sleep(2);
                    txMessageTpns('Product review',$title_en,'single',$goodsinfo['uid'],[],json_encode(['type'=>2]),'en');
                }

                //删除商品访问记录
                Db::name("user_goods_visit")->where("goodsid={$v}")->delete();
                //修改视频的绑定信息
                Db::name("video")->where("type=1 and goodsid={$v}")->update(array('type'=>0,'goodsid'=>0));
                //删除分享商品的动态
                Db::name("dynamic")->where(['goodsid'=>$v])->delete();
            }

			$action='删除商品IDS: '.json_encode($ids);
			setAdminLog($action);
    	}

        $this->success("删除成功！",url("shopgoods/index"));
    }

    //审核/详情
    function edit(){
    	$id = $this->request->param('id', 0, 'intval');

    	$goodsinfo=Db::name("shop_goods")->where("id={$id}")->find();

    	if(!$goodsinfo){
    		$this->error("数据错误");
    	}

    	$userinfo=getUserInfo($goodsinfo['uid']);

    	$goodsinfo['userinfo']=$userinfo;

    	$oneclass_name=Db::name("shop_goods_class")->where("gc_id={$goodsinfo['one_classid']}")->value("gc_name");
		$twoclass_name=Db::name("shop_goods_class")->where("gc_id={$goodsinfo['two_classid']}")->value("gc_name");
		$threeclass_name=Db::name("shop_goods_class")->where("gc_id={$goodsinfo['three_classid']}")->value("gc_name");

		$goodsinfo['oneclass_name']= $oneclass_name ?? '';
		$goodsinfo['twoclass_name']= $twoclass_name ?? '';
		$goodsinfo['threeclass_name']= $threeclass_name ?? '';

    	if(isset($goodsinfo['video_url'])){
    		$goodsinfo['video_url']=get_upload_path($goodsinfo['video_url']);
    	}

    	$thumb_arr=explode(',',$goodsinfo['thumbs']);
    	foreach ($thumb_arr as $k => $v) {
    		$thumb_arr[$k]=get_upload_path($v);
    	}

    	$goodsinfo['thumb_arr']=$thumb_arr;
    	$picture_arr=[];

    	if(isset($goodsinfo['pictures'])){
    		$picture_arr=explode(',',$goodsinfo['pictures']);

    		foreach ($picture_arr as $k => $v) {
    			$picture_arr[$k]=get_upload_path($v);
    		}
    	}

    	$goodsinfo['picture_arr']=$picture_arr;

    	$spec_arr=json_decode($goodsinfo['specs'],true);
    	
    	$goodsinfo['spec_arr']=$spec_arr;

    	unset($goodsinfo['thumbs'],$goodsinfo['pictures'],$goodsinfo['specs']);

    	$this->assign('data', $goodsinfo);
        $status=$this->getStatus();
        unset($status['-2']);
        unset($status['-1']);
    	$this->assign('status', $status);
    	
    	return $this->fetch();
    }

    //编辑提交
    public function editPost(){
    	$data=$this->request->param();

        $id=$data['id'];
        $goodsinfo=Db::name("shop_goods")->where("id={$id}")->find();
        $status=$data['status'];
        $refuse_reason=trim($data['refuse_reason']);

        if($status==2){ //管理员拒绝
            if($refuse_reason==''){
                $this->error("请填写拒绝理由");
            }
        }else{
            $refuse_reason='';
        }

        $data['refuse_reason']=$refuse_reason;

    	$data['uptime']=time();

    	$res=Db::name("shop_goods")->update($data);

        if($res===false){
            $this->error("编辑失败");
        }

        $uid=$goodsinfo['uid'];
        $title='';

        if($status==1){
            $title='你的商品“'.$goodsinfo['name'].'”已通过平台审核,上架成功。';
            $title_en="Your product ".$goodsinfo['name']." has passed the platform review and was successfully put on the shelves.";
            //发送腾讯云推送
            //type=2 非直播开播消息
            

            txMessageTpns('商品审核',$title,'single',$uid,[],json_encode(['type'=>2]),'zh-cn');
            sleep(2);
            txMessageTpns('Product review',$title_en,'single',$uid,[],json_encode(['type'=>2]),'en');
        }

        if($status==2){
            //发送极光推送
            
            $title='你的商品“'.$goodsinfo['name'].'”未通过平台审核。';
            $title_en="Your product ".$goodsinfo['name']." has not passed the platform review.";

            if($refuse_reason){
                $title.='原因：'.$refuse_reason;
            }

            //发送腾讯云推送
            //type=2 非直播开播消息
            

            txMessageTpns('商品审核',$title,'single',$uid,[],json_encode(['type'=>2]),'zh-cn');
            sleep(2);
            txMessageTpns('Product review',$title_en,'single',$uid,[],json_encode(['type'=>2]),'en');
        }

        //写入记录
        addSysytemInfo($uid,$title,$title_en,1);

    	$this->success("修改成功！");
    }

    //商品评论列表
    public function commentlist(){
        $data = $this->request->param();
        $goods_id=$data['goods_id'];
        $map=[];

        $map[]=['goodsid','=',$goods_id];
        $map[]=['is_append','=','0'];
        
        $start_time= $data['start_time'] ?? '';
        $end_time= $data['end_time'] ?? '';
        
        if($start_time!=""){
           $map[]=['addtime','>=',strtotime($start_time)];
        }

        if($end_time!=""){
           $map[]=['addtime','<=',strtotime($end_time) + 60*60*24];
        }

        $keyword= $data['keyword'] ?? '';
        if($keyword!=''){
            $map[]=['content','like','%'.$keyword.'%'];
        }

        $lists = Db::name("shop_order_comments")
                ->where($map)
                ->order("id asc")
                ->paginate(20);
        
        $lists->each(function($v,$k){
            $v['userinfo']=getUserInfo($v['uid']);
            $v['shop_userinfo']=getUserInfo($v['shop_uid']);
            
            if($v['thumbs']){
                $thumb_arr=explode(',',$v['thumbs']);
                foreach ($thumb_arr as $k1 => $v1) {
                    $thumb_arr[$k1]=get_upload_path($v1);
                }
                $v['thumb_arr']=$thumb_arr;
            }else{
                $v['thumb_arr']=[];
            }
            if($v['video_thumb']){
                $v['video_thumb']=get_upload_path($v['video_thumb']);
            }

            if($v['video_url']){
                $v['video_url']=get_upload_path($v['video_url']);
            }

            //获取追评信息
            $append_comment=Db::name("shop_order_comments")->where("orderid={$v['orderid']} and is_append=1")->find();

            if($append_comment){

                $append_comment['userinfo']=getUserInfo($append_comment['uid']);
                $append_comment['shop_userinfo']=getUserInfo($append_comment['shop_uid']);

                if($append_comment['thumbs']){
                    $thumb_arr=explode(',',$append_comment['thumbs']);
                    foreach ($thumb_arr as $k1 => $v1) {
                        $thumb_arr[$k1]=get_upload_path($v1);
                    }
                    $append_comment['thumb_arr']=$thumb_arr;
                }else{
                   $append_comment['thumb_arr']=[];
                }

                if($append_comment['video_thumb']){
                    $append_comment['video_thumb']=get_upload_path($append_comment['video_thumb']);
                }

                if($append_comment['video_url']){
                    $append_comment['video_url']=get_upload_path($append_comment['video_url']);
                }

            }

            $v['append_comment']=$append_comment;

            return $v;           
        });
        
        $lists->appends($data);
        $page = $lists->render();

        $this->assign('lists', $lists);
        $this->assign('goods_id', $goods_id);
        $this->assign("page", $page);
        
        return $this->fetch();
    }

    //删除视频评论
    function delComment(){
        $id = $this->request->param('id', 0, 'intval');
        $rs=Db::name("shop_order_comments")->where("id={$id}")->delete();
        if(!$rs){
            $this->error("评论删除失败");
        }

        $this->success("删除成功");
    }

    //评论视频播放
    function videoplay(){
        $data=$this->request->param();
        $url=$data['url'];
        $this->assign('url',$url);

        return $this->fetch();
    }

    //添加商品
    function add(){

        //判断自营店铺信息是否添加
        $platform_info=Db::name("shop_apply")->where("uid=1")->find();
        if(!$platform_info){
            $this->error("请先填写自营平台店铺信息");
        }
        
        $configpub=getConfigPub();
        $site=$configpub['site'];
        //通过接口获取商品分类中有三级的一级分类

        $header = array(
           'Accept: application/json',
        );
        $url=$site."/appapi/index.php?service=Shop.getOneGoodsClass";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
     
        // 显示错误信息
        if (curl_error($curl)) {
            $this->error("请确认商品分类");
        }
        curl_close($curl);

        
        $info=json_decode($res,true);

        $ret=$info['ret'];
        $code=$info['data']['code'];
        $msg=$info['data']['msg'];
        $one_classlist=$info['data']['info'];
        if($ret!=200){
            $this->error("请确认商品分类");
            
        }
        if($code!=0){
           $this->error($msg);
        }

        $this->assign("one_classlist",$one_classlist);

        return $this->fetch();
    }

    //jquery获取二级商品分类
    function getTwoClassLists(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());
        $data = $this->request->param();
        $one_classid=$data['one_classid'];

        if(!$one_classid){
            $rs['code']=1001;
            $rs['msg']='请选择一级分类';
            echo json_encode($rs);
            return;
        }

        $two_list=Db::name("shop_goods_class")
            ->field("gc_id,gc_name")
            ->where("gc_parentid={$one_classid} and gc_isshow=1")
            ->order("gc_sort")
            ->select()
            ->toArray();

        if(empty($two_list)){
            $rs['code']=1002;
            $rs['msg']='商品二级分类为空';
            echo json_encode($rs);
            return;
        }

        $rs['info']=$two_list;
        echo json_encode($rs);

    }

    //jquery获取二级商品分类
    function getThreeClassLists(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());
        $data = $this->request->param();
        $two_classid=$data['two_classid'];
        if(!$two_classid){
            $rs['code']=1001;
            $rs['msg']='请选择二级分类';
            echo json_encode($rs);
            return;
        }

        $three_list=Db::name("shop_goods_class")
            ->field("gc_id,gc_name")
            ->where("gc_parentid={$two_classid} and gc_isshow=1")
            ->order("gc_sort")
            ->select()
            ->toArray();
        if(empty($three_list)){
            $rs['code']=1002;
            $rs['msg']='商品三级分类为空';
            echo json_encode($rs);
            return;
        }

        $rs['info']=$three_list;
        echo json_encode($rs);
        
    }

    //商品添加保存
    function addPost(){
        $data=$this->request->param();
        $name=$data['name'];
        $one_classid=$data['one_classid'];
        $two_classid=$data['two_classid'];
        $three_classid=$data['three_classid'];
        $video_is_upload=$data['video_is_upload'];
        $video_url=trim($data['video_url']);
        $video_thumb=$data['video_thumb'];
        $thumbs=$data['thumbs'];
        $content=trim($data['content']);
        $pictures=$data['pictures'];
        $spec_name=$data['spec_name'];
        $spec_num=$data['spec_num'];
        $spec_price=$data['spec_price'];
        $spec_thumb=$data['spec_thumb'];
        $postage=$data['postage'];
        $commission=$data['commission'];
        $status=$data['status'];
        $share_income=$data['share_income'];

        if(!$name){
            $this->error("请填写商品标题");
        }
        if(mb_strlen($name)>15){
            $this->error("商品标题长度在15字以内");
        }

        if(!$one_classid){
            $this->error("请选择一级分类");
        }
        if(!$two_classid){
            $this->error("请选择二级分类");
        }
        if(!$three_classid){
            $this->error("请选择三级分类");
        }

        if($video_is_upload){
            if(!$video_thumb){
                $this->error("请上传视频封面图片");
            }

            $video_thumb=set_upload_path($video_thumb);

            if(!$video_url){
                $this->error("请上传视频");
            }
            $video_url=set_upload_path($video_url);
        }else{
            $video_thumb='';
            $video_url='';
        }

        if(!$thumbs){
            $this->error("请上传商品缩略图");
        }
         
        $thumbs_arr=[]; //封面图重新
        foreach ($thumbs as $k => $v) {
            if($v!=""){
                $thumbs_arr[]=set_upload_path($v);
            }
        }

        if(empty($thumbs_arr)){
            $this->error("请上传商品缩略图");
        }

        if($content==""){
            $this->error("请填写商品详情");
        }

        if(mb_strlen($content)>300){
            $this->error("商品详情字数在300字以内");
        }

        $picture_arr=[];
        if($pictures){
            foreach ($pictures as $k => $v) {
               if($v!=''){
                    $picture_arr[]=set_upload_path($v);
               } 
            }
        }

        // 商品规格名称

        if(!$spec_name){
            $this->error("请填写商品规格名称");
        }

        $spec_name_arr=[];
        $spec_name_error=0;
        foreach ($spec_name as $k => $v) {
            $specs_list_name=trim($v);
            if($specs_list_name==''||mb_strlen($specs_list_name)>15){
                $spec_name_error=1;
                break;
            }
            $spec_name_arr[]=$specs_list_name;

        }

        if($spec_name_error){
            $this->error("请确认商品规格名称是否填写或是否超过15字");
        }

        // 商品规格库存
        
        if(!$spec_num){
            $this->error("请填写商品规格库存");
        }

        $spec_num_arr=[];
        $spec_num_error=0;
        foreach ($spec_num as $k => $v) {
            $num=trim($v);
            if($num==''||$num<1||$num>9999999||floor($num) !=$num ){
                $spec_num_error=1;
                break;
            }
            $spec_num_arr[]=$num;  
        }

        if($spec_num_error){
            $this->error("请确认商品规格库存是否在1-9999999之间");
        }

        // 商品规格单价

        if(!$spec_price){
            $this->error("请填写商品规格单价");
        }

        $spec_price_arr=[];
        $spec_price_error=0;
        $share_error=0;
        $commission_error=0;
        foreach ($spec_price as $k => $v) {
            $price=trim($v);
            if($price==''||!$price ||$price<1||$price>99999999||!is_numeric($price)){
                $spec_price_error=1;
                break;
            }

            if($price<$share_income){
               $share_error=1;
               break;
            }

            if($price<$commission){
               $commission_error=1;
               break; 
            }

            $spec_price_arr[]=round($price,2);
        }

        if($spec_price_error){
            $this->error("请确认商品规格价格是否在1-99999999之间");
        }

        if($share_error){
            $this->error("分享佣金应低于商品价格");
        }

        if($commission_error){
            $this->error("代售佣金应低于商品价格");
        }

        // 商品规格封面

        if(!$spec_thumb){
            $this->error("请确认商品规格封面");
        }
        $spec_thumb_arr=[];
        $spec_thumb_error=0;
        foreach ($spec_thumb as $k => $v) {
            $thumb_src=trim($v);
            if(!$thumb_src){
               $spec_thumb_error=1;
               break; 
            }
            $spec_thumb_arr[]=set_upload_path($thumb_src);
        }

        if($spec_thumb_error){
            $this->error("请确认商品规格封面");
        }

        // 邮费

        if(!is_numeric($postage)){
            $this->error("邮费必须为数字");
        }

        if($postage<0||$postage>99999){
            $this->error("邮费必须在0-99999之间");
        }

        $postage=round($postage,2);

        // 佣金

        if(!is_numeric($commission)){
            $this->error("佣金必须为数字");
        }

        if($commission<0||$commission>99999){
            $this->error("佣金必须在0-99999之间");
        }

        $commission=round($commission,2);

        //分享得佣金
        if(!is_numeric($share_income)){
            $this->error("分享佣金必须为数字");
        }

        if($share_income<0||$share_income>99999){
            $this->error("分享佣金必须在0-99999之间");
        }

        $share_income=round($share_income,2);

        $specs_arr=[];
        foreach ($spec_name_arr as $k => $v) {
            $arr=[];
            $arr['spec_id']=$k+1;
            $arr['spec_name']=$v;
            $arr['spec_num']=$spec_num_arr[$k];
            $arr['price']=$spec_price_arr[$k];
            $arr['thumb']=$spec_thumb_arr[$k];
            $specs_arr[]=$arr;
        }

        $admin_id=cmf_get_current_admin_id();

        $post_data=array(
            'uid'=>1,
            'name'=>$name,
            'one_classid'=>$one_classid,
            'two_classid'=>$two_classid,
            'three_classid'=>$three_classid,
            'video_url'=>$video_url,
            'video_thumb'=>$video_thumb,
            'thumbs'=>implode(',', $thumbs_arr),
            'content'=>htmlspecialchars($content),
            'pictures'=>implode(',',$picture_arr),
            'specs'=>json_encode($specs_arr),
            'postage'=>$postage,
            'addtime'=>time(),
            'type'=>2,
            'admin_id'=>$admin_id,
            'commission'=>$commission,
            'status'=>$status,
            'low_price'=>min($spec_price_arr),
            'share_income'=>$share_income
        );

        $id=Db::name("shop_goods")->insertGetId($post_data);
        if(!$id){
            $this->error("商品添加失败！");
        }

        $action=$admin_id."添加商品：{$id}";
        setAdminLog($action);

        $this->success("商品添加成功！");

    }

    //平台自营商品编辑
    public function platformedit(){
        $data=$this->request->param();
        $id=$data['id'];
        $configpub=getConfigPub();
        $site=$configpub['site'];
        //通过接口获取商品分类中有三级的一级分类
        
        $header = array(
           'Accept: application/json',
        );
        $url=$site."/appapi/index.php?service=Shop.getOneGoodsClass";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
     
        // 显示错误信息
        if (curl_error($curl)) {
            $this->error("请确认商品分类");
        }
        curl_close($curl);
        
        $info=json_decode($res,true);

        $ret=$info['ret'];
        $code=$info['data']['code'];
        $msg=$info['data']['msg'];
        $one_classlist=$info['data']['info'];
        if($ret!=200){
            $this->error("请确认商品分类");
        }
        if($code!=0){
           $this->error($msg);
        }

        //获取自营商品信息
        $info=Db::name("shop_goods")->where("id='{$id}'")->find();

        //根据一级分类获取二级分类
        $two_classlist=Db::name("shop_goods_class")
            ->field("gc_id,gc_name")
            ->where("gc_parentid={$info['one_classid']} and gc_isshow=1")
            ->order("gc_sort")
            ->select()
            ->toArray();
        //根据二级分类获取三级分类
        $three_classlist=Db::name("shop_goods_class")
            ->field("gc_id,gc_name")
            ->where("gc_parentid={$info['two_classid']} and gc_isshow=1")
            ->order("gc_sort")
            ->select()
            ->toArray();
        
        $thumbs_arr=[];
        if($info['thumbs']){
            $thumbs_arr=explode(',',$info['thumbs']);  
        }
        
        $pictures_arr=[];
        if($info['pictures']){
            $pictures_arr=explode(',', $info['pictures']); 
        }
        
        $specs_arr=json_decode($info['specs'],true);

        $specs_thumbs_arr=[];
        foreach ($specs_arr as $k => $v) {
            $specs_thumbs_arr[]=$v['thumb'];
        }

        $this->assign("one_classlist",$one_classlist);
        $this->assign("info",$info);
        $this->assign("two_classlist",$two_classlist);
        $this->assign("three_classlist",$three_classlist);
        $this->assign("thumbs_arr",$thumbs_arr);
        $this->assign("thumbs_num",count($thumbs_arr));
        $this->assign("pictures_arr",$pictures_arr);
        $this->assign("pictures_num",count($pictures_arr));
        $this->assign("specs_arr",$specs_arr);
        $this->assign("specs_num",count($specs_arr));
        $this->assign("thumbs",$info['thumbs']);
        $this->assign("pictures",$info['pictures']);
        $this->assign("specs_thumbs",implode(',', $specs_thumbs_arr));

        return $this->fetch();
    }

    //平台自营商品编辑提交
    public function platformeditPost(){
        $data=$this->request->param();
        $id=$data['id'];
        $name=$data['name'];
        $one_classid=$data['one_classid'];
        $two_classid=$data['two_classid'];
        $three_classid=$data['three_classid'];
        $video_is_upload=$data['video_is_upload'];
        $video_url=trim($data['video_url']);
        $video_thumb=$data['video_thumb'];

        if(!isset($data['thumbs'])){
            $this->error("请上传商品缩略图");
        }
        $thumbs=$data['thumbs'];
        $content=trim($data['content']);
        if(isset($data['pictures'])){
            $pictures=$data['pictures'];
        }
        
        $spec_name=$data['spec_name'];
        $spec_num=$data['spec_num'];
        $spec_price=$data['spec_price'];
        $spec_thumb=$data['spec_thumb'];
        $postage=$data['postage'];
        $commission=$data['commission'];
        $status=$data['status'];
        $share_income=$data['share_income'];

        if(!$name){
            $this->error("请填写商品标题");
        }
        if(mb_strlen($name)>15){
            $this->error("商品标题长度在15字以内");
        }

        if(!$one_classid){
            $this->error("请选择一级分类");
        }
        if(!$two_classid){
            $this->error("请选择二级分类");
        }
        if(!$three_classid){
            $this->error("请选择三级分类");
        }

        if($video_is_upload){
            if(!$video_thumb){
                $this->error("请上传视频封面图片");
            }

            $video_thumb_old=$data['video_thumb_old'];
            if($video_thumb!=$video_thumb_old){
                $video_thumb=set_upload_path($video_thumb);
            }

            if(!$video_url){
                $this->error("请上传视频");
            }

            $video_url_old=$data['video_url_old'];
            if($video_url_old!=$video_url){
                $video_url=set_upload_path($video_url);
            }
        }else{
            $video_thumb='';
            $video_url='';
        }

        if(!$thumbs){
            $this->error("请上传商品缩略图");
        }

        $thumbs_old=$data['thumbs_old'];
        $thumbs_old_arr=explode(',',$thumbs_old);
         
        $thumbs_arr=[]; //封面图重新
        foreach ($thumbs as $k => $v) {
            if($v!=""){
                if(!in_array($v, $thumbs_old_arr)){
                    $thumbs_arr[]=set_upload_path($v);
                }else{
                    $thumbs_arr[]=$v;
                }
                
            }
        }

        if(empty($thumbs_arr)){
            $this->error("请上传商品缩略图");
        }

        if($content==""){
            $this->error("请填写商品详情");
        }

        if(mb_strlen($content)>300){
            $this->error("商品详情字数在300字以内");
        }

        $pictures_old=$data['pictures_old'];
        $pictures_old_arr=explode(',', $pictures_old);

        $picture_arr=[];
        if(isset($pictures)){
            foreach ($pictures as $k => $v) {
               if($v!=''){
                if(!in_array($v, $pictures_old_arr)){
                    $picture_arr[]=set_upload_path($v);
                }else{
                    $picture_arr[]=$v;
                }
                
               } 
            }
        }

        if(!$spec_name){
            $this->error("请填写商品规格名称");
        }

        $spec_name_arr=[];
        $spec_name_error=0;
        foreach ($spec_name as $k => $v) {
            $specs_list_name=trim($v);
            if($specs_list_name==''||mb_strlen($specs_list_name)>15){
                $spec_name_error=1;
                break;
            }
            $spec_name_arr[]=$specs_list_name;
        }

        if($spec_name_error){
            $this->error("请确认商品规格名称是否填写或是否超过15字");
        }

        if(!$spec_num){
            $this->error("请填写商品规格库存");
        }

        $spec_num_arr=[];
        $spec_num_error=0;
        foreach ($spec_num as $k => $v) {
            $num=trim($v);
            if($num==''||$num<1||$num>9999999||floor($num) !=$num ){
                $spec_num_error=1;
                break;
            }
            $spec_num_arr[]=$num;  
        }

        if($spec_num_error){
            $this->error("请确认商品规格库存是否在1-9999999之间");
        }

        if(!$spec_price){
            $this->error("请填写商品规格单价");
        }

        $spec_price_arr=[];
        $spec_price_error=0;
        $share_error=0;
        $commission_error=0;

        foreach ($spec_price as $k => $v) {

            $price=trim($v);

            if($price==''||!$price ||$price<1||$price>99999999||!is_numeric($price)){
                $spec_price_error=1;
                break;
            }

            if($price<$share_income){
               $share_error=1;
               break;
            }

            if($price<$commission){
               $commission_error=1;
               break; 
            }

            $spec_price_arr[]=round($price,2);
        }

        if($spec_price_error){
            $this->error("请确认商品规格价格是否在1-99999999之间");
        }

        if($share_error){
            $this->error("分享佣金应低于商品价格");
        }

        if($commission_error){
            $this->error("代售佣金应低于商品价格");
        }

        if(!$spec_thumb){
            $this->error("请确认商品规格封面");
        }

        $specs_thumbs_old=$data['specs_thumbs_old'];
        $specs_thumbs_old_arr=explode(',', $specs_thumbs_old);

        $spec_thumb_arr=[];
        $spec_thumb_error=0;
        foreach ($spec_thumb as $k => $v) {
            $thumb_src=trim($v);
            if(!$thumb_src){
               $spec_thumb_error=1;
               break; 
            }

            if(!in_array($thumb_src, $specs_thumbs_old_arr)){
                $spec_thumb_arr[]=set_upload_path($thumb_src);
            }else{
                $spec_thumb_arr[]=$thumb_src;
            }
        }

        if($spec_thumb_error){
            $this->error("请确认商品规格封面");
        }

        if(!is_numeric($postage)){
            $this->error("邮费必须为数字");
        }

        if($postage<0||$postage>99999){
            $this->error("邮费必须在0-99999之间");
        }

        $postage=round($postage,2);

        if(!is_numeric($commission)){
            $this->error("佣金必须为数字");
        }

        if($commission<0||$commission>99999){
            $this->error("佣金必须在0-99999之间");
        }

        $commission=round($commission,2);

        
        if(!is_numeric($share_income)){
            $this->error("分享佣金必须为数字");
        }

        if($share_income<0||$share_income>99999){
            $this->error("分享佣金必须在0-99999之间");
        }

        $share_income=round($share_income,2);

        $specs_arr=[];
        foreach ($spec_name_arr as $k => $v) {
            $arr=[];
            $arr['spec_id']=$k+1;
            $arr['spec_name']=$v;
            $arr['spec_num']=$spec_num_arr[$k];
            $arr['price']=$spec_price_arr[$k];
            $arr['thumb']=$spec_thumb_arr[$k];
            $specs_arr[]=$arr;
        }

        if($status=='-2'){
            $sale_platform=Db::name("seller_platform_goods")
                ->where("goodsid={$id} and (issale=1 or live_isshow=1)")
                ->count();
            if($sale_platform){
                $this->error("有主播正在直播间代售该商品，暂时无法下架");
            }
        }

        $admin_id=cmf_get_current_admin_id();

        $post_data=array(
            'id'            =>$id,
            'uid'           =>1,
            'name'          =>$name,
            'one_classid'   =>$one_classid,
            'two_classid'   =>$two_classid,
            'three_classid' =>$three_classid,
            'video_url'     =>$video_url,
            'video_thumb'   =>$video_thumb,
            'thumbs'        =>implode(',', $thumbs_arr),
            'content'       =>htmlspecialchars($content),
            'pictures'      =>implode(',',$picture_arr),
            'specs'         =>json_encode($specs_arr),
            'postage'       =>$postage,
            'uptime'        =>time(),
            'type'          =>2,
            'commission'    =>$commission,
            'status'        =>$status,
            'low_price'     =>min($spec_price_arr),
            'share_income'  =>$share_income
        );

        $res=Db::name("shop_goods")->update($post_data);

        /*var_dump(Db::name("shop_goods")->getLastSql());
        die;*/
        if($res===false){
            $this->error("商品修改失败！");
        }

        if($status==0||$status==-2){ //下架或待审核
            Db::name("seller_platform_goods")
                ->where("goodsid={$id}")
                ->update(array("status"=>0,"issale"=>0,"live_isshow"=>0));
        }else if($status==1){
            Db::name("seller_platform_goods")
                ->where("goodsid={$id}")
                ->update(array("status"=>1));
        }

        $action=$admin_id."修改商品：{$id}";
        setAdminLog($action);
        $this->success("商品修改成功！");
    }

    //设置/取消直播间展示
    function setLiveisShow(){
        
        $id = $this->request->param('id', 0, 'intval');
        $isshow = $this->request->param('isshow', 0, 'intval');
        $uid = $this->request->param('uid', 0, 'intval');
        
        if($isshow ==1){
            DB::name('shop_goods')
                ->where("uid={$uid} and id !={$id}")
                ->update(['live_isshow'=>0]);
        }

        $rs = DB::name('shop_goods')
            ->where("id={$id}")
            ->update(['live_isshow'=>$isshow]);
        if(!$rs){
            $this->error("操作失败！");
        }

        if($isshow==1){
            $action='设置商品直播间展示ID: '.$id;
        }else{
            $action='取消商品直播间展示ID: '.$id;
        }
        setAdminLog($action);
        $this->success("操作成功！");
    }
    
}
