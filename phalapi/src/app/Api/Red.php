<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Red as Domain_Red;

/**
 * 红包
 */
class Red extends Api {

	public function getRules() {
		return array(
			'sendRed' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
                'stream' => array('name' => 'stream', 'type' => 'string',  'require' => true, 'desc' => '流名'),
				'type' => array('name' => 'type', 'type' => 'int',  'require' => true, 'desc' => '红包类型，0普通，1手气'),
				'type_grant' => array('name' => 'type_grant', 'type' => 'int',  'require' => true, 'desc' => '发放类型，0立即 1延迟'),
				'coin' => array('name' => 'coin', 'type' => 'int',  'require' => true, 'desc' => '钻石'),
				'nums' => array('name' => 'nums', 'type' => 'int', 'require' => true, 'desc' => '数量'),
                'des' => array('name' => 'des', 'type' => 'string', 'default'=>'恭喜发财，大吉大利', 'desc' => '描述'),
			),
			
			'sendRedNew' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'stream' => array('name' => 'stream', 'type' => 'string',  'require' => true, 'desc' => '流名'),
				'type' => array('name' => 'type', 'type' => 'int',  'require' => true, 'desc' => '红包类型，0普通，1手气 , 2专属'),
				'type_grant' => array('name' => 'type_grant', 'type' => 'int', 'default'=>0,'require' => true, 'desc' => '发放类型，0立即 1延迟'),
				'type_user' => array('name' => 'type_user', 'type' => 'int', 'default'=>0,'require' => true, 'desc' => '用户类型，0全体，1部分 , 2指定'),
				'type_scope' => array('name' => 'type_scope', 'type' => 'int','require' => true, 'desc' => '范围类型，0,给主播消费的会员,1守护主播的会员,2关注主播的会员,3普通聊天的会员'),
				'specify_uid' => array('name' => 'specify_uid', 'type' => 'int', 'default'=>0, 'desc' => '专属红包用户id(如果不是专属红包，则填0)'),
				'coin' => array('name' => 'coin', 'type' => 'int',  'require' => true, 'desc' => '钻石'),
				'nums' => array('name' => 'nums', 'type' => 'int', 'require' => true, 'desc' => '数量'),
				'des' => array('name' => 'des', 'type' => 'string', 'default'=>'恭喜发财，大吉大利', 'desc' => '描述'),
			),
            
            'getRedList' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'stream' => array('name' => 'stream', 'type' => 'string',  'require' => true, 'desc' => '流名'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'require' => true, 'desc' => '签名'),
			),
            'robRed' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
                'stream' => array('name' => 'stream', 'type' => 'string',  'require' => true, 'desc' => '流名'),
                'redid' => array('name' => 'redid', 'type' => 'int',  'require' => true, 'desc' => '红包ID'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'require' => true, 'desc' => '签名'),
			),
			'robRedNew' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'stream' => array('name' => 'stream', 'type' => 'string',  'require' => true, 'desc' => '流名'),
				'redid' => array('name' => 'redid', 'type' => 'int',  'require' => true, 'desc' => '红包ID'),
				'sign' => array('name' => 'sign', 'type' => 'string',  'require' => true, 'desc' => '签名'),
			),
			
            'getRedRobList' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'stream' => array('name' => 'stream', 'type' => 'string',  'require' => true, 'desc' => '流名'),
                'redid' => array('name' => 'redid', 'type' => 'int',  'require' => true, 'desc' => '红包ID'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'require' => true, 'desc' => '签名'),
			),
			
			'redIsEligibility' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'stream' => array('name' => 'stream', 'type' => 'string',  'require' => true, 'desc' => '流名'),
				'redid' => array('name' => 'redid', 'type' => 'int',  'require' => true, 'desc' => '红包ID'),
				'sign' => array('name' => 'sign', 'type' => 'string',  'require' => true, 'desc' => '签名'),
			),
		);
	}

	/**
	 * 发送红包
	 * @desc 用于 发送红包
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].redid 红包ID
     * @return string info[0].level 用户等级
     * @return string info[0].level_anchor 主播等级
	 * @return string msg 提示信息
	 */
	public function sendRed() {
		$rs = array('code' => 0, 'msg' => \PhalApi\T('发送成功'), 'info' => array());
		
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);
		$type=\App\checkNull($this->type);
		$type_grant=\App\checkNull($this->type_grant);
		$coin=\App\checkNull($this->coin);
		$nums=\App\checkNull($this->nums);
		$des=\App\checkNull($this->des);
		
        
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		if((int)$coin==0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('请输入正确的金额');
			return $rs;
		}
        
        if((int)$nums==0){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('请输入正确的个数');
			return $rs;
		}
        
        if($type==0){
            /* 平均 */
            $avg=$coin ;
            $coin=$avg*$nums;
        }else{
            if($nums > $coin){
                $rs['code']=1004;
                $rs['msg']=\PhalApi\T('红包数量不能超过红包金额');
                return $rs;
            }
        }
        
        if(mb_strlen($des)>50){
            $rs['code']=1004;
			$rs['msg']=\PhalApi\T('红包名称最多{num}个字',['num'=>50]);
			return $rs;
        }

		
        $stream_a=explode("_",$stream);
        $liveuid=$stream_a[0];
        $showid=$stream_a[1];
        if((int)$liveuid==0 || (int)$showid==0){
            $rs['code']=1007;
            $rs['msg']=\PhalApi\T('信息错误');
            return $rs;
        }
        
        $nowtime=time();
        $addtime=$nowtime;
        $effecttime=$nowtime;
        if($type_grant==1){
            $effecttime=$nowtime + 3 * 60;
        }

		$data=array(
			"uid"=>$uid,
			"liveuid"=>$liveuid,
			"showid"=>$showid,
			"type"=>$type,
			"type_grant"=>$type_grant,
			"coin"=>$coin,
			"nums"=>$nums,
			"des"=>$des,
			"effecttime"=>$effecttime,
			"status"=>0,
			"addtime"=>$addtime
		);
		$domain = new Domain_Red();
		$result = $domain->sendRed($data);
		if($result['code']!=0){
            return $result;
		}
        $redinfo=$result['info'];
        
        $redid=$redinfo['id'];
        
        $key='red_list_'.$stream;
        \App\rPush($key,$redid);
        
        $key2='red_list_'.$stream.'_'.$redid;
        $red_list=$this->redlist($coin,$nums,$type);
        foreach($red_list as $k=>$v){
            \App\rPush($key2,$v);
        }
        $rs['info'][0]['redid']=(string)$redid;
        $userinfo=\App\getUserInfo($uid);
        $rs['info'][0]['level']=(string)$userinfo['level'];
        $rs['info'][0]['level_anchor']=(string)$userinfo['level_anchor'];

		return $rs;
	}
	
	/**
	 * 发送红包 New
	 * @desc 用于 发送红包 New
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].redid 红包ID
	 * @return string info[0].level 用户等级
	 * @return string info[0].level_anchor 主播等级
	 * @return string msg 提示信息
	 */
	public function sendRedNew()
	{
		$rs = array('code' => 0, 'msg' => \PhalApi\T('发送成功'), 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token = \App\checkNull($this->token);
		$stream = \App\checkNull($this->stream);
		$type = \App\checkNull($this->type);
		$type_grant = \App\checkNull($this->type_grant);
		$type_user = \App\checkNull($this->type_user);
		$type_scope = \App\checkNull($this->type_scope);
		$specify_uid = \App\checkNull($this->specify_uid);
		$coin = \App\checkNull($this->coin);
		$nums = \App\checkNull($this->nums);
		$des = \App\checkNull($this->des);
		
		
		$checkToken = \App\checkToken($uid, $token);
		if ($checkToken == 700) {
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		if ((int)$coin == 0) {
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('请输入正确的金额');
			return $rs;
		}
		
		if ((int)$nums == 0) {
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('请输入正确的个数');
			return $rs;
		}
		
		if ($type == 0) {
			/* 平均 */
			$avg = $coin;
			$coin = $avg * $nums;
		} else {
			if ($nums > $coin) {
				$rs['code'] = 1004;
				$rs['msg'] = \PhalApi\T('红包数量不能超过红包金额');
				return $rs;
			}
		}
		
		if (mb_strlen($des) > 50) {
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('红包名称最多{num}个字', ['num' => 50]);
			return $rs;
		}
		
		if ((int)$type_user === 2){
			if ((int)$specify_uid === 0){
				$rs['code'] = 1005;
				$rs['msg'] = \PhalApi\T('需要专属用户');
				return $rs;
			}
			
		}
		
		$stream_a = explode('_', $stream);
		$liveuid = $stream_a[0];
		$showid = $stream_a[1];
		if ((int)$liveuid == 0 || (int)$showid == 0) {
			$rs['code'] = 1007;
			$rs['msg'] = \PhalApi\T('信息错误');
			return $rs;
		}
		
		$nowtime = time();
		$addtime = $nowtime;
		$effecttime = $nowtime;
		if ($type_grant == 1) {
			$effecttime = $nowtime + 3 * 60;
		}
		
		$data = array(
			'uid' => $uid,
			'liveuid' => $liveuid,
			'showid' => $showid,
			'type' => $type,
			'type_grant' => $type_grant,
			'type_user' => $type_user,
			'type_scope' => $type_scope,
			'coin' => $coin,
			'nums' => $nums,
			'des' => $des,
			'effecttime' => $effecttime,
			'status' => 0,
			'addtime' => $addtime,
			'specify_uid' =>$specify_uid
		);
		$domain = new Domain_Red();
		$result = $domain->sendRedNew($data);
		if ($result['code'] != 0) {
			return $result;
		}
		$redinfo = $result['info'];
		
		$redid = $redinfo['id'];
		
		$key = 'red_list_' . $stream;
		\App\rPush($key, $redid);
		
		$key2 = 'red_list_' . $stream . '_' . $redid;
		$red_list = $this->redlist($coin, $nums, $type);
		foreach ($red_list as $k => $v) {
			\App\rPush($key2, $v);
		}
		$rs['info'][0]['redid'] = (string)$redid;
		$userinfo = \App\getUserInfo($uid);
		$rs['info'][0]['level'] = (string)$userinfo['level'];
		$rs['info'][0]['level_anchor'] = (string)$userinfo['level_anchor'];
		
		return $rs;
	}
	
	
	/**
	 * 获取红包列表
	 * @desc 用于 获取红包列表
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[].id 红包ID
	 * @return string info[].uid 发布者ID
	 * @return string info[].type 红包类型
	 * @return string info[].type_grant 发放类型
	 * @return string info[].second 剩余时间(秒)
	 * @return string info[].isrob 是否能抢
	 * @return string msg 提示信息
	 */
	public function getRedList() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $sign=\App\checkNull($this->sign);
        $stream=\App\checkNull($this->stream);
        
        $checkdata=array(
            'stream'=>$stream
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;
        }
        
        $stream_a=explode("_",$stream);
        $liveuid=$stream_a[0];
        $showid=$stream_a[1];
        if((int)$liveuid==0 || (int)$showid==0){
            $rs['code']=1007;
            $rs['msg']=\PhalApi\T('信息错误');
            return $rs;
        }
        
        $domain = new Domain_Red();
		$result = $domain->getRedList($liveuid,$showid);
        
        $nowtime=time();
        foreach($result as $k=>$v){
            $userinfo=\App\getUserInfo($v['uid']);
            
            $v['user_nickname']=$userinfo['user_nickname'];
            $v['avatar']=$userinfo['avatar'];
            $v['avatar_thumb']=$userinfo['avatar_thumb'];
            $v['second']='0';
            if($v['type_grant']==1){
                if($v['effecttime']>$nowtime){
                    $v['second']=(string)($v['effecttime']-$nowtime);
                }
            }
            $isrob='0';
            
            $key='red_user_winning_'.$stream.'_'.$v['id'];
            $key2='red_list_'.$stream.'_'.$v['id'];
            $ifwin=\App\zScore($key,$uid);
            if($ifwin==false){
                $ifexist=\App\exists($key2);
                if($ifexist){
                    $isrob='1';
                }
            }
            $v['isrob']=$isrob;
            $result[$k]=$v;
            
        }
		
        
        $rs['info']=$result;
        
        return $rs;
        
    }
    
	/**
	 * 抢红包
	 * @desc 用于 用户抢红包
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0]
	 * @return string info[0].win 抢到的红包金额，0表示没抢到
	 * @return string info[0].msg 提示信息
	 * @return string msg 提示信息
	 */
	public function robRed() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);
        $redid=\App\checkNull($this->redid);
        $sign=\App\checkNull($this->sign);
        
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        
        $checkdata=array(
            'uid'=>$uid,
            'redid'=>$redid,
            'stream'=>$stream,
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;
        }
        
        $nowtime=time();
        $key='red_user_winning_'.$stream.'_'.$redid;
        $key2='red_list_'.$stream.'_'.$redid;
        
        $result=array(
            'win'=>'0',
            'msg'=>\PhalApi\T('手慢了，红包派完了'),
        );
        
        $ifwin=\App\zScore($key,$uid);
        if($ifwin==false){
            $ifexist=\App\exists($key2);
            if($ifexist){
                $coin=\App\lPop($key2);
                if($coin>0){
                    
                    $stream_a=explode("_",$stream);
                    $liveuid=$stream_a[0];
                    $showid=$stream_a[1];
        
                    $data=array(
                        'uid'=>$uid,
                        'redid'=>$redid,
                        'coin'=>$coin,
                        'showid'=>$showid,
                        'addtime'=>$nowtime,
                    );
                    
                    $domain = new Domain_Red();
                    $result2 = $domain->robRed($data);
                    $score=$coin;
                    \App\zAdd($key,$score,$uid);
                    
                    $result['win']=(string)$coin;
                    //$result['msg']='';
                }
            }
            
        }else{
            
            $ifwin_a=explode(".",$ifwin);
            $time=$ifwin_a[0];
            $coin=$ifwin_a[1];
            $coin=substr($coin,0,-1);
            
            $result['win']=(string)$coin;
            //$result['msg']='';
        }
        
        $rs['info'][0]=$result;
        
        return $rs;
        
    }
	
	/**
	 * 抢红包 New
	 * @desc 用于 用户抢红包 New
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0]
	 * @return string info[0].win 抢到的红包金额，0表示没抢到
	 * @return string info[0].msg 提示信息
	 * @return string msg 提示信息
	 */
	public function robRedNew()
	{
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token = \App\checkNull($this->token);
		$stream = \App\checkNull($this->stream);
		$redid = \App\checkNull($this->redid);
		$sign = \App\checkNull($this->sign);
		
		$checkToken = \App\checkToken($uid, $token);
		if ($checkToken == 700) {
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$checkdata = array(
			'uid' => $uid,
			'redid' => $redid,
			'stream' => $stream,
		);
		
		$issign = \App\checkSign($checkdata, $sign);
		if (!$issign) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('签名错误');
			return $rs;
		}
		
		$nowtime = time();
		$key = 'red_user_winning_' . $stream . '_' . $redid;
		$key2 = 'red_list_' . $stream . '_' . $redid;
		
		$result = array(
			'win' => '0',
			'msg' => \PhalApi\T('手慢了，红包派完了'),
		);
		
		$ifwin = \App\zScore($key, $uid);
		if ($ifwin == false) {
			$ifexist = \App\exists($key2);
			if ($ifexist) {
				$coin = \App\lPop($key2);
				if ($coin > 0) {
					
					$stream_a = explode('_', $stream);
					$liveuid = $stream_a[0];
					$showid = $stream_a[1];
					
					$data = array(
						'uid' => $uid,
						'redid' => $redid,
						'coin' => $coin,
						'showid' => $showid,
						'addtime' => $nowtime,
					);
					
					$domain = new Domain_Red();
					$result2 = $domain->robRedNew($data);
					$score = $coin;
					\App\zAdd($key, $score, $uid);
					
					$result['win'] = (string)$coin;
					//$result['msg']='';
				}
			}
			
		} else {
			
			$ifwin_a = explode('.', $ifwin);
			$time = $ifwin_a[0];
			$coin = $ifwin_a[1];
			$coin = substr($coin, 0, -1);
			
			$result['win'] = (string)$coin;
			//$result['msg']='';
		}
		
		$rs['info'][0] = $result;
		
		return $rs;
		
	}
    
    /**
	 * 红包领取列表
	 * @desc 用于 获取红包领取列表
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return object info[0].redinfo 红包信息
	 * @return string info[0].redinfo.coin 总金额
	 * @return string info[0].redinfo.nums 总数量
	 * @return string info[0].redinfo.coin_rob 已抢金额
	 * @return string info[0].redinfo.nums_rob 已抢数量
     * @return array info[0].list 领取列表
     * @return string info[0].win 抢到金额，0表示未抢到
	 * @return string msg 提示信息
	 */
	public function getRedRobList() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $sign=\App\checkNull($this->sign);
        $stream=\App\checkNull($this->stream);
        $redid=\App\checkNull($this->redid);
        
        $checkdata=array(
            'redid'=>$redid,
            'stream'=>$stream,
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;
        }
        
        $stream_a=explode("_",$stream);
        $liveuid=$stream_a[0];
        $showid=$stream_a[1];
        
        $domain = new Domain_Red();
		$redinfo = $domain->getRedInfo($redid);
        if(!$redinfo){
            $rs['code']=1002;
			$rs['msg']=\PhalApi\T('红包不存在');
			return $rs;
        }
        
        $senduserinfo=\App\getUserInfo($redinfo['uid']);

        $redinfo['user_nickname']=$senduserinfo['user_nickname'];
        $redinfo['avatar']=$senduserinfo['avatar'];
        $redinfo['avatar_thumb']=$senduserinfo['avatar_thumb'];
        
        $list=array();
        $win=0;

        $win_list=$domain->getRedRobList($redid);
        foreach($win_list as $k=>$v){
            $userinfo=\App\getUserInfo($v['uid']);

            $coin=$v['coin'];

            
            if($v['uid']==$uid){
                $win=$coin;
            }
            
            $data=array(
                'uid'=>$userinfo['id'],
                'user_nickname'=>$userinfo['user_nickname'],
                'avatar'=>$userinfo['avatar'],
                'win'=>$coin,
                'time'=>date('H:i:s',$v['addtime']),
            );
            $list[]=$data;
            
        }
        
        $rs['info'][0]['redinfo']=$redinfo;
        $rs['info'][0]['list']=$list;
        $rs['info'][0]['win']=(string)$win;
        
        return $rs;
    }
    
  
    /**
     * 分配红包个数
     * @param int $total
     */
    protected function redlist($total,$nums,$type){
        if($type==1){
            /* 手气红包 */
            $list=$this->red_rand_list2($total,$nums);
        }else{
            /* 平均红包 */
            $list=$this->red_average($total,$nums);
        }
        
        return $list;
    }

    /**
     * 平分红包
     * @param int $total
     */
    protected function red_average($total,$nums){
        $coin=floor($total/$nums);
        $list = array();
        for($i=0;$i<$nums;$i++){
            $list[]=$coin;
        }

        return $list;
    }

    /**
     * 预生成好，红包随机队列
     * @param int $total
     */
    protected function red_rand_list($total){
        $list = array();
        while ($total > 0) {
            $diamonds = mt_rand(1, 20);//随机取：1至20中的一个数字
            if ($total >= $diamonds) {
                $total = $total - $diamonds;
                $list[] = $diamonds;
            } else {
                if ($total >= 1) {
                    $diamonds = 1;
                    $total = $total - $diamonds;
                    $list[] = $diamonds;
                }
            }
        }

        return $list;
    }

    /**
     * 把$total 生成指定数量$num的，随机列表数
     * @param int $total
     * @param int $num
     * @return multitype:number
     */
    protected function red_rand_list2($total, $num){
        $list = array();
        if ($num > $total) {
            $num = $total;
        }
        //先生成一批为：1 的
        for ($x = 0; $x < $num; $x++) {
            $list[] = 1;
            $total = $total - 1;
        }

        while ($total > 0) {
            foreach ($list as $k => $v) {
                $diamonds = mt_rand(1, 19);//随机取：1至20中的一个数字
                if ($total >= $diamonds) {
                    $total = $total - $diamonds;
                } else {
                    if ($total >= 1) {
                        $diamonds = 1;
                        $total = $total - $diamonds;
                    }
                }

                $list[$k] = $v + $diamonds;
                if ($total == 0) {
                    break;
                }
            }
        };

        return $list;
    }
	
	/**
	 * 判断是否可以领取红包 (当 打赏给部分人员,指定人员调用)
	 * @desc 用于  判断是否可以领取红包
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].isEligibility 1 可以领取 0不可以领取
	 * @return string msg 提示信息
	 */
	public function redIsEligibility()
	{
		$rs = array('code' => 0, 'msg' => \PhalApi\T('发送成功'), 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token = \App\checkNull($this->token);
		$stream = \App\checkNull($this->stream);
		$redid = \App\checkNull($this->redid);
		$sign = \App\checkNull($this->sign);

		$checkToken = \App\checkToken($uid, $token);
		if ($checkToken == 700) {
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$checkdata = array(
			'uid' => $uid,
			'redid' => $redid,
			'stream' => $stream,
		);
		
		$issign = \App\checkSign($checkdata, $sign);
		if (!$issign) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('签名错误');
			return $rs;
		}

		
		$dataEligibility = [
			'uid' => $uid,
			'redid' => $redid,
			'stream' => $stream,
		];
		$domain = new Domain_Red();
		$isEligibility = $domain->isEligibility($dataEligibility);
		if ($isEligibility !== 1){
			$rs['msg'] = \PhalApi\T('专属/指定红包不可领取');
			$result = array(
				'isEligibility' => 0,
			);
			
		}else{
			$rs['msg'] = \PhalApi\T('专属/指定红包可领取');
			$result = array(
				'isEligibility' => 1,
			);
		}
		$rs['info'][0] = $result;
		return $rs;
		
	}


}
