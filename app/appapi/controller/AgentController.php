<?php
/**
 * 分销
 */
namespace app\appapi\controller;

use cmf\controller\HomeBaseController;
use think\facade\Db;

class AgentController extends HomebaseController {
	
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
		  
		$nowtime=time();

		$userinfo=getUserInfo($uid);
		$code=Db::name('agent_code')->where(["uid"=>$uid])->value('code');
		
		if(!$code){
			$code=createCode();
            $ifok=Db::name('agent_code')->where(["uid"=>$uid])->update(array("code"=>$code));
            if(!$ifok){
                Db::name('agent_code')->insert(array('uid'=>$uid,"code"=>$code));
            }
			
		}

		$code_a=str_split($code);

		$this->assign("code",$code);
		$this->assign("code_a",$code_a);
		$agentinfo=array();
        
        /* 是否是分销下级 */
        $users_agent=Db::name("agent")->where(["uid"=>$uid])->find();
		if($users_agent){
			$agentinfo= getUserInfo($users_agent['one_uid']);
		}

        $one_profit=0;
		
		$agentprofit=Db::name("agent_profit")->where(["uid"=>$uid])->find();
        if($agentprofit){
            $one_profit=$agentprofit['one_profit'];
        }

		$agnet_profit=array(
			'one_profit'=>number_format($one_profit),
		);

		$this->assign("uid",$uid);
		$this->assign("token",$token);
		$this->assign("userinfo",$userinfo);
		$this->assign("agentinfo",$agentinfo);
		$this->assign("agnet_profit",$agnet_profit);

		return $this->fetch();
	    
	}
	
	function agent(){
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
		
		$agentinfo=array();
		
		$users_agent=Db::name('agent')->where(["uid"=>$uid])->find();
		if($users_agent){
			$agentinfo=getUserInfo($users_agent['one_uid']);
			
			$code=Db::name('agent_code')->where("uid={$users_agent['one_uid']}")->value('code');
			
			$agentinfo['code']=$code;
			$code_a=str_split($code);

			$this->assign("code_a",$code_a);
		}
	
		
		$this->assign("uid",$uid);
		$this->assign("token",$token);

		$this->assign("agentinfo",$agentinfo);

		return $this->fetch();
	}
	
	function setAgent(){
		$data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $code= $data['code'] ?? '';
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
        $code=checkNull($code);
		
		$rs=array('code'=>0,'info'=>array(),'msg'=>lang('设置成功'));
		
		if(checkToken($uid,$token)==700){
			$rs['code']=700;
			$rs['msg']=lang('您的登陆状态失效，请重新登陆！');
			echo json_encode($rs);
            return;
		} 

		if($code==""){
			$rs['code']=1001;
			$rs['msg']=lang('邀请码不能为空');
			echo json_encode($rs);
            return;
		}
		
		$isexist=Db::name('agent')->where(["uid"=>$uid])->find();
		if($isexist){
			$rs['code']=1001;
			$rs['msg']=lang('已设置');
			echo json_encode($rs);
            return;
		}
		
		$oneinfo=Db::name('agent_code')->field("uid")->where(["code"=>$code])->find();
		if(!$oneinfo){
			$rs['code']=1002;
			$rs['msg']=lang('邀请码错误');
			echo json_encode($rs);
            return;
		}
		
		if($oneinfo['uid']==$uid){
			$rs['code']=1003;
			$rs['msg']=lang('不能填写自己的邀请码');
			echo json_encode($rs);
            return;
		}
		
		$one_agent=Db::name('agent')->where("uid={$oneinfo['uid']}")->find();
		if(!$one_agent){
			$one_agent=array(
				'uid'=>$oneinfo['uid'],
				'one_uid'=>0,
			);
		}else{

			if($one_agent['one_uid']==$uid){
				$rs['code']=1004;
				$rs['msg']=lang('您已经是该用户的上级');
				echo json_encode($rs);
                return;
			}
		}
		
		$data=array(
			'uid'=>$uid,
			'one_uid'=>$one_agent['uid'],
			'addtime'=>time(),
		);
		Db::name('agent')->insert($data);

		echo json_encode($rs);
		
	}

	function quit(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());
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
		
		$isexist=Db::name('agent')->where(["uid"=>$uid])->delete();

		echo json_encode($rs);
		
	}
	
	function one(){
		$data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
		
		if(checkToken($uid,$token)==700){
			$this->assign("reason",lang('您的登陆状态失效，请重新登陆！'));
			return $this->fetch(':error');
		}
		
		$list=Db::name('agent_profit_recode')
            ->field("uid,sum(one_profit) as total")
            ->where(["one_uid"=>$uid])->group("uid")
            ->order("addtime desc")
            ->limit(0,50)
            ->select()
            ->toArray();
		foreach($list as $k=>$v){
			$list[$k]['userinfo']=getUserInfo($v['uid']);
			$list[$k]['total']=NumberFormat($v['total']);
		}
		$this->assign("uid",$uid);
		$this->assign("token",$token);
		$this->assign("list",$list);
		return $this->fetch();
	}

	function one_more(){
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
		
		$list=Db::name('agent_profit_recode')
            ->field("uid,sum(one_profit) as total")
            ->where(["one_uid"=>$uid])
            ->group("uid")
            ->order("addtime desc")
            ->limit($start,$pnums)
            ->select()
            ->toArray();
		foreach($list as $k=>$v){
			$list[$k]['userinfo']=getUserInfo($v['uid']);
			$list[$k]['total']=NumberFormat($v['total']);
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

	//扫描app生成的分享二维码显示的下载页面，通过openinstall 自动建立上下级关系
	public function downapp(){
		$data=$this->request->param();
		$code='';
		if(!isset($data['code'])){
			$this->assign("reason",lang('邀请码错误'));
			return $this->fetch(':error');
			
		}

		$code=$data['code'];
		$code_info=Db::name("agent_code")->where("code='{$code}'")->find();

		if(!$code_info){
			$this->assign("reason",lang('邀请码不存在'));
			return $this->fetch(':error');
			
		}
		$configpub=getConfigPub();
		$site_name=$configpub['site_name'];
		$configpri=getConfigPri();
		$openinstall_switch=$configpri['openinstall_switch'];
		if(!$openinstall_switch){
			$this->assign("reason",lang('分享通道关闭'));
			return $this->fetch(':error');
			
		}
		$openinstall_appkey=$configpri['openinstall_appkey'];
		if(!$openinstall_appkey){
			$this->assign("reason",lang('信息配置错误'));
			return $this->fetch(':error');
			
		}
		$this->assign("site_name",$site_name);
		$this->assign("openinstall_appkey",$openinstall_appkey);
		return $this->fetch();
	}

}