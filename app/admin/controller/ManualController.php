<?php

/**
 * 管理员手动充值记录
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class ManualController extends AdminbaseController {

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
        
        $status= $data['status'] ?? '';
        if($status!=''){
            $map[]=['status','=',$status];
        }

        $uid=$data['uid'] ?? '';
        if($uid!=''){
            $lianguid=getLianguser($uid);
            if($lianguid){
                
                array_push($lianguid,$uid);
                $map[]=['touid','in',$lianguid];
            }else{
                $map[]=['touid','=',$uid];
            }
        }

        $lists = Db::name("charge_admin")
            ->where($map)
			->order("id desc")
			->paginate(20);
        
        $lists->each(function($v,$k){
			$v['userinfo']=getUserInfo($v['touid']);
			$v['ip']=long2ip($v['ip']);
            return $v;
        });
        
        $lists->appends($data);
        $page = $lists->render();

    	$this->assign('lists', $lists);
    	$this->assign("page", $page);
    	
        $coin = Db::name("charge_admin")
            ->where($map)
			->sum('coin');
        if(!$coin){
            $coin=0;
        }

    	$this->assign('coin', $coin);
     
    	return $this->fetch();
    }
		
	function add(){
		return $this->fetch();
	}
	function addPost(){
		if ($this->request->isPost()) {
            
            $data = $this->request->param();
            
			$touid=$data['touid'];

			if($touid==""){
				$this->error("请填写用户ID");
			}
            
            $uid=Db::name("user")->where(["id"=>$touid])->value("id");
            if(!$uid){
                $this->error("会员不存在，请更正");
                
            }
            
			$coin=$data['coin'];
			if($coin==""){
				$this->error("请填写充值点数");
			}

            if(!is_numeric($coin)){
                $this->error("充值点数必须为数字");
            }

            if(floor($coin)!=$coin){
                $this->error("充值点数必须为整数");
            }

            $user_coin=Db::name("user")->where(["id"=>$touid])->value("coin");

            $total=$user_coin+$coin;
            if($total<0){
                $total=0;
            }
            
            $adminid=cmf_get_current_admin_id();
            $admininfo=Db::name("user")->where(["id"=>$adminid])->value("user_login");
            
            $data['admin']=$admininfo;
            $ip=get_client_ip(0,true);
            
            $data['ip']=ip2long($ip);
            
            $data['addtime']=time();
            
			$id = DB::name('charge_admin')->insertGetId($data);
            if(!$id){
                $this->error("充值失败！");
            }
			
			$action="手动充值抖康钻石zID：".$id;
			setAdminLog($action);
            
            Db::name("user")->where(["id"=>$touid])->update(['coin'=>$total]);
            $this->success("充值成功！");
            
		}
	}
    
    function export(){
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

        $status=$data['status'] ?? '';
        if($status!=''){
            $map[]=['status','=',$status];
        }

        $uid=$data['uid'] ?? '';
        if($uid!=''){
            $lianguid=getLianguser($uid);
            if($lianguid){
                
                array_push($lianguid,$uid);
                $map[]=['touid','in',$lianguid];
            }else{
                $map[]=['touid','=',$uid];
            }
        }
        
        $xlsName  = "手动充值记录";
        $xlsData = Db::name("charge_admin")
            ->where($map)
			->order("id desc")
			->select()
            ->toArray();

        if(empty($xlsData)){
            $this->error("数据为空");
        }

        foreach ($xlsData as $k => $v){

            $userinfo=getUserInfo($v['touid']);

            $xlsData[$k]['ip']=long2ip($v['ip']);
            $xlsData[$k]['user_nickname']= $userinfo['user_nickname'].'('.$v['touid'].')';
            $xlsData[$k]['addtime']=date("Y-m-d H:i:s",$v['addtime']);
        }
        
        $action="导出手动充值记录：".Db::name("charge_admin")->getLastSql();
        setAdminLog($action);
        $cellName = array('A','B','C','D','E','F');
        $xlsCell  = array(
            array('id','序号'),
            array('admin','管理员'),
            array('user_nickname','会员 (账号)(ID)'),
            array('coin','充值点数'),
            array('ip','IP'),
            array('addtime','时间'),
        );
        exportExcel($xlsName,$xlsCell,$xlsData,$cellName);
    }

}
