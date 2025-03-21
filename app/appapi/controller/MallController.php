<?php
/**
 * 道具商城
 */
namespace app\appapi\controller;

use cmf\controller\HomeBaseController;
use think\facade\Db;

class MallController extends HomebaseController {

    protected function getLong($k=''){
        $long=array(
            '1'=>lang('1个月'),
            '3'=>lang('3个月'),
            '6'=>lang('6个月'),
            '12'=>lang('12个月'),
        );
        if($k===''){
            return $long;
        }
        return $long[$k] ?? '';
    }

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
        
        $user= Db::name("user")
            ->field("id,user_nickname,coin,score")
            ->where(["id"=>$uid])
            ->find();
        $this->assign("user",$user);

        /* vip */
        $vip_list=Db::name("vip")->order("list_order asc")->select();
        $this->assign("long",$this->getLong());
        $this->assign("vip_list",$vip_list);
        
        /* 用户VIP */
		$nowtime=time();
		
        $vip_txt=lang('开通');
        $where=[
            ['uid','=',$uid],
            ['endtime','>',$nowtime],
        ];
		$uservip=Db::name('vip_user')->where($where)->find();
        if($uservip){
            $vip_txt=lang('续费');
            $uservip['endtime']=date("Y.m.d",$uservip['endtime']);
        }else{
            $uservip['endtime']='';
        }
		$this->assign("uservip",$uservip);
		$this->assign("vip_txt",$vip_txt);
        
        $configpub=getConfigPub();
        /* 靓号 */
		$liang_list=Db::name('liang')
            ->where("status=0")
            ->order("list_order asc,id desc")
            ->limit(21)
            ->select()
            ->toArray();
        foreach($liang_list as $k=>$v){
            
            $liang_list[$k]['coin_date']=number_format($v['coin']).$configpub['name_coin'];
            $liang_list[$k]['score_date']=number_format($v['score']).$configpub['name_score']; 
            
        }

		$this->assign("liang_list",$liang_list);
        
        /* 坐骑 */
        $car_key='carinfo';
        $car_list=getcaches($car_key);
        if(!$car_list){
            $car_list=Db::name("car")->order("list_order asc")->select()->toArray();
            if($car_list){
                setcaches($car_key,$car_list);
            }
        }

        //语言包
        
        $language_type=$this->language_type;
        
        foreach($car_list as $k=>$v){
            $car_list[$k]['thumb']=get_upload_path($v['thumb']);
            $car_list[$k]['swf']=get_upload_path($v['swf']);

            if($language_type=='en'){
                $car_list[$k]['name']=$v['name_en']; 
            }
        }
        
        $this->assign("car_list",$car_list);
		
		return $this->fetch();
	    
	}

    /* 购买VIP */
	function buyvip(){
        
        $data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $vipid= $data['vipid'] ?? '';
        $type= $data['type'] ?? '';
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
        $vipid=(int)checkNull($vipid);
        $type=(int)checkNull($type);

		$rs=array('code'=>0,'info'=>array(),'msg'=>lang('购买成功'));
		
		if( !$uid || !$token || checkToken($uid,$token)==700){
			$rs['code']=700;
			$rs['msg']=lang('您的登陆状态失效，请重新登陆！');
			echo json_encode($rs);
			return;
		} 

		$vipinfo=Db::name("vip")->where(["id"=>$vipid])->find();
		if(!$vipinfo){
			$rs['code']=1001;
			$rs['msg']=lang('VIP信息错误');
			echo json_encode($rs);
			return;
		}

		$total=$vipinfo['coin'];
		$score=$vipinfo['score'];
		$giftid=$vipinfo['id'];
		$addtime=time();
		$giftcount=$vipinfo['length'];
        
        if($type==1){
            /* 积分 */
            $ifok=Db::name('user')
                ->where([['id','=',$uid],['score','>=',$score]])
                ->dec('score',$score)
                ->update();
            if(!$ifok){
                $rs['code']=1002;
                $rs['msg']=lang('积分不足');
                echo json_encode($rs);
                return;
            }
            
            /* 添加记录 */
            Db::name("user_scorerecord")
                ->insert(
                    array(
                        "type"      =>'0',
                        "action"    =>'4',
                        "uid"       =>$uid,
                        "touid"     =>$uid,
                        "giftid"    =>$giftid,
                        "giftcount" =>$giftcount,
                        "totalcoin" =>$score,
                        "addtime"   =>$addtime
                    )
                );
            
        }else{
            /* 更新用户余额 消费 */
            $ifok=Db::name('user')
                    ->where([['id','=',$uid],['coin','>=',$total]])
                    ->dec('coin',$total)
                    ->inc('consumption',$total)
                    ->update();
            if(!$ifok){
                $rs['code']=1002;
                $rs['msg']=lang('余额不足');
                echo json_encode($rs);
                return;
            }
            
            /* 添加记录 */
            Db::name("user_coinrecord")
                ->insert(
                    array(
                        "type"      =>'0',
                        "action"    =>'4',
                        "uid"       =>$uid,
                        "touid"     =>$uid,
                        "giftid"    =>$giftid,
                        "giftcount" =>$giftcount,
                        "totalcoin" =>$total,
                        "addtime"   =>$addtime
                    )
                );
        }

		$endtime=$addtime+60*60*24*30*$giftcount;
		
		$uservip=Db::name('vip_user')->where(["uid"=>$uid])->find();
		
		if($uservip){
			if($uservip['endtime'] > $addtime){
                $endtime=$uservip['endtime']+60*60*24*30*$giftcount;
			}
			$data=array(
				'endtime'=>$endtime,
			);
			Db::name('vip_user')->where(["uid"=>$uid])->update($data);
		}else{
			
			$data=array(
				'uid'=>$uid,
				'addtime'=>$addtime,
				'endtime'=>$endtime,
			);
			Db::name('vip_user')->insert($data);
		}

		$result=date("Y.m.d",$endtime);
		
		$key='vip_'.$uid;
		$isexist=Db::name("vip_user")->where(["uid"=>$uid])->find();		
		if($isexist){
			setcaches($key,$isexist);
		}
        
        $userinfo=Db::name('user')->field("coin,score")->where(["id"=>$uid])->find();

		$rs['info']['endtime']=$result;
		$rs['info']['coin']=$userinfo['coin'];
		$rs['info']['score']=$userinfo['score'];
		echo json_encode($rs);

	}   
    
    /* 靓号加载更多 */
    function getliangmore(){
        
        $rs=array('code'=>0,'info'=>array(),'msg'=>'');
        
        $data = $this->request->param();
        $p= $data['p'] ?? '1';
        $p=(int)checkNull($p);
        if(!$p){
            $p=1;
        }
        $nums=21;
        $start=($p-1) * $nums;
        $isscroll=1;
        
        $configpub=getConfigPub();
        
		$liang_list=Db::name('liang')
            ->where("status=0")
            ->order("list_order asc,id desc")
            ->limit($start,$nums)
            ->select()
            ->toArray();
        foreach($liang_list as $k=>$v){
            $liang_list[$k]['coin_date']=number_format($v['coin']).$configpub['name_coin']; 
            $liang_list[$k]['score_date']=number_format($v['score']).$configpub['name_score']; 
        }      

        $list_num=count($liang_list);
        
        if($list_num < $nums){
            $isscroll=0;
        }
        
        $rs['info']['list']=$liang_list;
        $rs['info']['nums']=$list_num;
        $rs['info']['isscroll']=$isscroll;

        echo json_encode($rs);

    }
    /* 购买靓号 */
    function buyliang(){
        
        $data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $liangid= $data['liangid'] ?? '0';
        $type=$data['type'] ?? '0';
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
        $liangid=(int)checkNull($liangid);
        $type=(int)checkNull($type);
        
		
		$rs=array('code'=>0,'info'=>array(),'msg'=>lang('购买成功'));
		
		if( !$uid || !$token || checkToken($uid,$token)==700){
			$rs['code']=700;
			$rs['msg']=lang('您的登陆状态失效，请重新登陆！');
			echo json_encode($rs);
			return;
		}
		
		$lianginfo=Db::name('liang')->where(["id"=>$liangid])->find();
		if(!$lianginfo){
			$rs['code']=1001;
			$rs['msg']=lang('靓号信息错误');
			echo json_encode($rs);
			return;
		}
		
		if($lianginfo['status']==1){
			$rs['code']=1003;
			$rs['msg']=lang('该靓号已出售');
			echo json_encode($rs);
			return;
		}
		if($lianginfo['status']==2){
			$rs['code']=1003;
			$rs['msg']=lang('该靓号已下架');
			echo json_encode($rs);
			return;
		}
		
		
		
		$total=$lianginfo['coin'];
		$score=$lianginfo['score'];
		$giftid=$lianginfo['id'];
		$addtime=time();
		$giftcount=1;
        
        if($type==1){
            /* 积分 */
            $ifok=Db::name('user')
                ->where([['id','=',$uid],['score','>=',$score]])
                ->dec('score',$score)
                ->update();
            if(!$ifok){
                $rs['code']=1002;
                $rs['msg']=lang('积分不足');
                echo json_encode($rs);
                return;
            }
            
            /* 添加记录 */
            Db::name("user_scorerecord")
                ->insert(
                    array(
                        "type"=>'0',
                        "action"=>'18',
                        "uid"=>$uid,
                        "touid"=>$uid,
                        "giftid"=>$giftid,
                        "giftcount"=>$giftcount,
                        "totalcoin"=>$score,
                        "addtime"=>$addtime
                    )
                );
            
        }else{
            /* 更新用户余额 消费 */
            $ifok=Db::name('user')
                    ->where([['id','=',$uid],['coin','>=',$total]])
                    ->dec('coin',$total)
                    ->inc('consumption',$total)
                    ->update();
            if(!$ifok){
                $rs['code']=1002;
                $rs['msg']=lang('余额不足');
                echo json_encode($rs);
                return;
            }
            
            /* 添加记录 */
            Db::name("user_coinrecord")
                ->insert(
                    array(
                        "type"=>'0',
                        "action"=>'18',
                        "uid"=>$uid,
                        "touid"=>$uid,
                        "giftid"=>$giftid,
                        "giftcount"=>$giftcount,
                        "totalcoin"=>$total,
                        "addtime"=>$addtime
                    )
                );
        }
		
		$data=array(
			'uid'=>$uid,
			'status'=>1,
			'buytime'=>$addtime,
		);
		Db::name('liang')->where(["id"=>$liangid])->update($data);
        
        $userinfo=Db::name('user')->field("coin,score")->where(["id"=>$uid])->find();
		
		//$rs['msg']='您已成功购买'.$carinfo['name'].'坐骑，请前往“装备中心”进行查看';
        $rs['info']['coin']=$userinfo['coin'];
        $rs['info']['score']=$userinfo['score'];
		echo json_encode($rs);

	}

    /* 购买坐骑 */
    function buycar(){
        
        $data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $carid= $data['carid'] ?? '0';
        $type= $data['type'] ?? '0';
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
        $carid=(int)checkNull($carid);
        $type=(int)checkNull($type);
        
		
		$rs=array('code'=>0,'info'=>array(),'msg'=>lang('购买成功'));
		
		if( !$uid || !$token || checkToken($uid,$token)==700){
			$rs['code']=700;
			$rs['msg']=lang('您的登陆状态失效，请重新登陆！');
			echo json_encode($rs);
            return;
		} 

		$carinfo=Db::name("car")->where(["id"=>$carid])->find();
		if(!$carinfo){
			$rs['code']=1001;
			$rs['msg']=lang('坐骑信息错误');
			echo json_encode($rs);
            return;
		}
		
		$total=$carinfo['needcoin'];
		$score=$carinfo['score'];
		$giftid=$carinfo['id'];
		$addtime=time();
		$giftcount=1;
        
        
        if($type==1){
            /* 积分 */
            $ifok=Db::name('user')
                ->where([['id','=',$uid],['score','>=',$score]])
                ->dec('score',$score)
                ->update();
            if(!$ifok){
                $rs['code']=1002;
                $rs['msg']=lang('积分不足');
                echo json_encode($rs);
                return;
            }
            
            /* 添加记录 */
            Db::name("user_scorerecord")
                ->insert(
                    array(
                        "type"      =>'0',
                        "action"    =>'5',
                        "uid"       =>$uid,
                        "touid"     =>$uid,
                        "giftid"    =>$giftid,
                        "giftcount" =>$giftcount,
                        "totalcoin" =>$score,
                        "addtime"   =>$addtime
                    )
                );
            
        }else{
            /* 更新用户余额 消费 */
            $ifok=Db::name('user')
                    ->where([['id','=',$uid],['coin','>=',$total]])
                    ->dec('coin',$total)
                    ->inc('consumption',$total)
                    ->update();
            if(!$ifok){
                $rs['code']=1002;
                $rs['msg']=lang('余额不足');
                echo json_encode($rs);
                return;
            }
            
            /* 添加记录 */
            Db::name("user_coinrecord")
                ->insert(
                    array(
                        "type"      =>'0',
                        "action"    =>'5',
                        "uid"       =>$uid,
                        "touid"     =>$uid,
                        "giftid"    =>$giftid,
                        "giftcount" =>$giftcount,
                        "totalcoin" =>$total,
                        "addtime"   =>$addtime
                    )
                );
        }
        
        
		$endtime=$addtime+60*60*24*30*$giftcount;
		
		$usercar=Db::name('car_user')->where(["uid"=>$uid, "carid"=>$carid])->find();
		
		if($usercar){
			if($usercar['endtime'] > $addtime){
				$endtime=$usercar['endtime']+60*60*24*30*$giftcount;
			}
			$data=array(
				'endtime'=>$endtime,
			);
			Db::name('car_user')->where(["id"=>$usercar['id']])->update($data);
		}else{
			$data=array(
				'uid'=>$uid,
				'addtime'=>$addtime,
				'endtime'=>$endtime,
				'carid'=>$carid,
			);
			Db::name('car_user')->insert($data);
		}
        
        $userinfo=Db::name('user')->field("coin,score")->where(["id"=>$uid])->find();
		//$rs['msg']='您已成功购买'.$carinfo['name'].'坐骑，请前往“装备中心”进行查看';
        $rs['info']['coin']=$userinfo['coin'];
        $rs['info']['score']=$userinfo['score'];
		echo json_encode($rs);

	}
}