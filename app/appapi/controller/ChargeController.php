<?php
/**
 * 钻石充值记录
 */
namespace app\appapi\controller;

use cmf\controller\HomeBaseController;
use think\facade\Db;

class ChargeController extends HomebaseController {
    

	function index(){       
		$data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token=$data['token'] ?? '';
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

		$list=Db::name("charge_user")
			->field("coin,coin_give,money,addtime")
            ->where("uid={$uid} and status=1")
            ->order("addtime desc")
            ->limit(0,50)
            ->select()
            ->toArray();

		foreach($list as $k=>$v){

			$list[$k]['addtime']=date('Y-m-d',$v['addtime']);
			$list[$k]['coin']=$v['coin']+$v['coin_give'];
		}
		
		$this->assign("list",$list);
		
		return $this->fetch();
	    
	}
	
	public function getlistmore()
	{
		$data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token=$data['token'] ?? '';
        $p=$data['page'] ?? '1';
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


        $list=Db::name("charge_user")
			->field("coin,coin_give,money,addtime")
            ->where("uid={$uid} and status=1")
            ->order("addtime desc")
            ->limit($start,$pnums)
            ->select()
            ->toArray();

		foreach($list as $k=>$v){

			$list[$k]['addtime']=date('Y.m.d',$v['addtime']);
			$list[$k]['coin']=$v['coin']+$v['coin_give'];
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