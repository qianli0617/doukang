<?php

/**
 * 直播列表
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class LiveingController extends AdminbaseController {
    protected function getLiveClass(){

        $liveclass=Db::name("live_class")->order('list_order asc, id desc')->column('id,name');

        return $liveclass;
    }
    
    protected function getTypes($k=''){
        $type=[
            '0'=>'普通房间',
            '1'=>'密码房间',
            '2'=>'门票房间',
            '3'=>'计时房间',
        ];
        
        if($k===''){
            return $type;
        }
        return $type[$k];
    }
    
    function index(){
        $data = $this->request->param();
        $map=[];
        $map[]=['islive','=',1];
        $start_time= $data['start_time'] ?? '';
        $end_time= $data['end_time'] ?? '';
        
        if($start_time!=""){
           $map[]=['starttime','>=',strtotime($start_time)];
        }

        if($end_time!=""){
           $map[]=['starttime','<=',strtotime($end_time) + 60*60*24];
        }

        $uid=$data['uid'] ?? '';
        if($uid!=''){
            $lianguid=getLianguser($uid);
            if($lianguid){
                
                array_push($lianguid,$uid);
                $map[]=['uid','in',$lianguid];
            }else{
                $map[]=['uid','=',$uid];
            }
        }
        
        $configpri=getConfigPri();   

        $lists = Db::name("live")
                ->where($map)
                ->order("starttime DESC")
                ->paginate(20);

        $liveclass=$this->getLiveClass();

        array_push($liveclass,['id'=>0,'name'=>'默认分类']);
        
        $lists->each(function($v,$k) use ($configpri,$liveclass){

             $v['userinfo']=getUserInfo($v['uid']);
             $where=[];
             $where['action']=1;
             $where['touid']=$v['uid'];
             $where['showid']=$v['showid'];
             /* 本场总收益 */
             $totalcoin=Db::name("user_coinrecord")->where($where)->sum('totalcoin');
             if(!$totalcoin){
                $totalcoin=0;
             }
             /* 送礼物总人数 */
             $total_nums=Db::name("user_coinrecord")->where($where)->group("uid")->count();
             if(!$total_nums){
                $total_nums=0;
             }
             /* 人均 */
             $total_average=0;
             if($totalcoin && $total_nums){
                $total_average=round($totalcoin/$total_nums,2);
             }
             
             /* 人数 */
            $nums=zSize('user_'.$v['stream']);
            
            $v['totalcoin']=$totalcoin;
            $v['total_nums']=$total_nums;
            $v['total_average']=$total_average;
            $v['nums']=$nums;
            
            if($v['isvideo']==0 && $configpri['cdn_switch']!=5){
                $v['pull']=PrivateKeyA('rtmp',$v['stream'],0);
            }

            foreach ($liveclass as $k1 => $v1) {
                if($v['liveclassid']==$v1['id']){
                    $v['liveclassname']=$v1['name'];
                    break;
                }
            }
                
            return $v;           
        });

        
        $lists->appends($data);
        $page = $lists->render();


        $this->assign('lists', $lists);
        $this->assign("page", $page);
        $this->assign("type", $this->getTypes());
        
        return $this->fetch();
    }

    function del(){
        
        $uid = $this->request->param('uid', 0, 'intval');
        
        $rs = DB::name('live')->where("uid={$uid}")->delete();
        if(!$rs){
            $this->error("删除失败！");
        }
		
		$action="直播管理-直播列表删除UID：".$uid;
		setAdminLog($action);
        
        $this->success("删除成功！",url("liveing/index"));
            
    }
    
    function add(){

        $this->assign("liveclass", $this->getLiveClass());
        $this->assign("type", $this->getTypes());
        return $this->fetch();
    }
    
    function addPost(){
        if ($this->request->isPost()) {
            
            $data = $this->request->param();
            
            $nowtime=time();
            $uid=$data['uid'];
            
            $userinfo=DB::name('user')->field("ishot,isrecommend")->where(["id"=>$uid,"user_type"=>2])->find();
            if(!$userinfo){
                $this->error('用户不存在');
            }
            
            $liveinfo=DB::name('live')->field('uid,islive')->where(["uid"=>$uid])->find();
            if($liveinfo && $liveinfo['islive']==1){
                $this->error('该用户正在直播');
            }
            
            $pull=urldecode($data['pull']);
            $type=$data['type'];
            $type_val=$data['type_val'];
            $anyway=$data['anyway'];
            $liveclassid=$data['liveclassid'];
            $live_type=$data['live_type'];
            $stream=$uid.'_'.$nowtime;
            $title='';
            $goodsid=$data['goodsid'];

            if($live_type==1){
                $liveclassid=0;
                $type=0;
                $type_val='';
            }
            
            $data2=array(
                "uid"           =>$uid,
                "ishot"         =>$userinfo['ishot'],
                "isrecommend"   =>$userinfo['isrecommend'],
                "showid"        =>$nowtime,
                "starttime"     =>$nowtime,
                "title"         =>$title,
                "province"      =>'',
                "city"          =>'好像在火星',
                "stream"        =>$stream,
                "thumb"         =>'',
                "pull"          =>$pull,
                "lng"           =>'',
                "lat"           =>'',
                "type"          =>$type,
                "type_val"      =>$type_val,
                "isvideo"       =>1,
                "islive"        =>1,
                "anyway"        =>$anyway,
                "liveclassid"   =>$liveclassid,
                "live_type"     =>$live_type
            );

            if(!empty($goodsid) && $live_type==0){
               $data2['isshop']=1; 
            }
            
            if($liveinfo){
                $rs = DB::name('live')->update($data2);
            }else{
                $rs = DB::name('live')->insertGetId($data2);
            }

            if($rs===false){
                $this->error("添加失败！");
            }

            Db::name("shop_goods")->where(['uid'=>$uid])->update(['issale'=>0]);

            if(!empty($goodsid) && $live_type==0){
                Db::name("shop_goods")->where(['id'=>$goodsid])->update(['issale'=>1]);
            }

			$action="直播管理-直播列表添加UID：".$uid;
			setAdminLog($action);
            
            $this->success("添加成功！");
        }           
    }
    
    function edit(){
        $uid   = $this->request->param('uid', 0, 'intval');
        
        $data=Db::name('live')
            ->where("uid={$uid}")
            ->find();
        if(!$data){
            $this->error("信息错误");
        }

        $goods_list=Db::name("shop_goods")->field("id,name,issale,live_isshow")->where(['uid'=>$uid,'status'=>1])->select();
        
        $this->assign('data', $data);
        $this->assign("liveclass", $this->getLiveClass());
        $this->assign("type", $this->getTypes());
        $this->assign('goods_list', $goods_list);
        
        return $this->fetch();
    }
    
    function editPost(){
        if ($this->request->isPost()) {
            
            $data  = $this->request->param();
            
            $data['pull']=urldecode($data['pull']);

            $live_type=$data['live_type'];
            if($live_type==1){
                $data['liveclassid']=0;
                $data['type']=0;
                $data['type_val']='';
            }
            $uid=$data['uid'];

            if(isset($data['goodsid'])){
                $goodsid=$data['goodsid'];

                Db::name("shop_goods")->where(['uid'=>$uid])->update(['issale'=>0]);

                if(!empty($goodsid) && $live_type==0){
                    Db::name("shop_goods")->where(['id'=>$goodsid])->update(['issale'=>1]);
                    $data['isshop'] =1;
                }

                unset($data['goodsid']);
            }

            $rs = DB::name('live')->update($data);
            if($rs===false){
                $this->error("修改失败！");
            }
			
			$action="直播管理-直播列表修改UID：".$data['uid'];
			setAdminLog($action);
            $this->success("修改成功！");
        }
    }

    function getGoodsList(){

        $rs=array('code'=>0,'msg'=>'','info'=>array());
        $uid   = $this->request->param('uid', 0, 'intval');
        if(!$uid){
            $rs['code']=1001;
            $rs['msg']='用户不存在';
            echo json_encode($rs);
            return;
        }

        $goods_list=Db::name("shop_goods")->field("id,name,issale,live_isshow")->where(['uid'=>$uid,'status'=>1])->select();

        $rs['info']=$goods_list;
       
        echo json_encode($rs);
    }
        
}
