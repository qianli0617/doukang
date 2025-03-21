<?php
/**
 * 店铺余额提现记录
 */
namespace app\appapi\controller;

use cmf\controller\HomeBaseController;
use think\facade\Db;

class ShopcashController extends HomebaseController {
    
    protected function getStatus($k=''){
        $status=[
            '0'=>lang('审核中'),
            '1'=>lang('成功'),
            '2'=>lang('失败'),
        ];
        if($k===''){
            return $status;
        }
        return $status[$k] ?? '';
    }

    protected function getType($k=''){
        $type=[
            '1'=>lang('支付宝'),
            '2'=>lang('微信'),
            '3'=>lang('银行卡'),
        ];
        if($k==''){
            return $type;
        }
        return $type[$k] ?? '';
    }

	function index(){       
		$data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
        
        $checkToken=checkToken($uid,$token);
		if($checkToken==700){
			$reason=lang('您的登陆状态失效，请重新登陆！');
			$this->assign('reason', $reason);
			return $this->fetch(':error');
		}
        
		$this->assign("uid",$uid);
		$this->assign("token",$token);

		$list=Db::name("user_balance_cashrecord")->where(["uid"=>$uid])->order("addtime desc")->limit(0,50)->select()->toArray();

		foreach($list as $k=>$v){

			$list[$k]['addtime']=date('Y.m.d',$v['addtime']);
			$list[$k]['status_name']=$this->getStatus($v['status']);
			$list[$k]['type_name']=$this->getType($v['type']);
		}
		
		$this->assign("list",$list);
		
		return $this->fetch();
	    
	}
	
	public function getlistmore(){

		$data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $p= $data['page'] ?? '1';
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
        $p=checkNull($p);
		
		$result=array(
			'data'=>array(),
			'nums'=>0,
			'isscroll'=>0,
		);
	
		if(checkToken($uid,$token)==700){
			echo json_encode($result);
            return;
		} 
		
		$pnums=50;
		$start=($p-1)*$pnums;

        $list=Db::name("user_balance_cashrecord")->where(["uid"=>$uid])->order("addtime desc")->limit($start,$pnums)->select()->toArray();
		foreach($list as $k=>$v){

			$list[$k]['addtime']=date('Y.m.d',$v['addtime']);
			$list[$k]['status_name']=$this->getStatus($v['status']);
			$list[$k]['type_name']=$this->getType($v['type']);
		}
		
		$nums=count($list);
		if($nums<$pnums){
			$isscroll=0;
		}else{
			$isscroll=1;
		}
		
		$result=array(
			'data'=>$list,
			'nums'=>$nums,
			'isscroll'=>$isscroll,
		);

		echo json_encode($result);
		
	}

}