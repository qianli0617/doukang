<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Livepk as Domain_Livepk;

/**
 * 直播
 */

class Livepk extends Api {
	public function getRules() {
		return array(
			'getLiveList' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'p' => array('name' => 'p', 'type' => 'int', 'default' => 1, 'desc' => '页码'),
			),
			'search' => array( 
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'key' => array('name' => 'key', 'type' => 'string', 'require' => true, 'desc' => '关键词'),
				'p' => array('name' => 'p', 'type' => 'int', 'default' => 1, 'desc' => '页码'),
			),
			'checkLive' => array(
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '连麦主播流名'),
                'uid_stream' => array('name' => 'uid_stream', 'type' => 'string', 'require' => true, 'desc' => '当前主播流名'),
			),
            
            'changeLive' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'pkuid' => array('name' => 'pkuid', 'type' => 'int', 'require' => true, 'desc' => '连麦主播ID'),
				'type' => array('name' => 'type', 'type' => 'int', 'require' => true, 'desc' => '标识'),
				'sign' => array('name' => 'sign', 'type' => 'string', 'require' => true, 'desc' => '签名'),
			),
            
            'setPK' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'desc' => '用户ID'),
				'pkuid' => array('name' => 'pkuid', 'type' => 'int', 'desc' => '连麦主播ID'),
				'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名'),
			),
            
            'endPK' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'desc' => '用户ID'),
				'addtime' => array('name' => 'addtime', 'type' => 'int', 'desc' => '时间戳'),
				'type' => array('name' => 'type', 'type' => 'int', 'desc' => '标识'),
				'sign' => array('name' => 'sign', 'type' => 'string','desc' => '签名'),
			),
		);
	}

	/**
	 * 获取视频直播中的用户
	 * @desc 用于 获取视频直播中的用户
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string info[].uid 主播ID
	 * @return string info[].pkuid PK对象ID，0表示未连麦
	 * @return string msg 提示信息
	 */
	public function getLiveList() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $p=\App\checkNull($this->p);
        if(!$p){
            $p=1;
        }
        
        $where="uid!={$uid}";

		$domain = new Domain_Livepk();
		$list = $domain->getLiveList($uid,$where,$p);
        
        foreach($list as $k=>$v){
            $userinfo=\App\getUserInfo($v['uid']);
            $v['level']=$userinfo['level'];
            $v['level_anchor']=$userinfo['level_anchor'];
            $v['sex']=$userinfo['sex'];
            $list[$k]=$v;
        }

		$rs['info']=$list;
		return $rs;			
	}
    
	/**
	 * 搜索直播用户
	 * @desc 用于搜索直播中用户
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string info[].uid 主播ID
	 * @return string info[].pkuid PK对象ID，0表示未连麦
	 * @return string msg 提示信息
	 */
	public function search() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $key=\App\checkNull($this->key);
        $p=\App\checkNull($this->p);
        if(!$p){
            $p=1;
        }
        
        if($key==''){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('请输入您要搜索的主播昵称或ID');
            return $rs;
        }
        
        $list=\PhalApi\DI()->notorm->user
                ->select('id')
                ->where("id!={$uid} and (id='{$key}' or user_nickname like '%{$key}%')")
                ->fetchAll();
        if(!$list){
            return $rs;
        }

        $uids=array_column($list,'id');
        
        $uids_s=implode(',',$uids);
        
        $where="uid!={$uid} and uid in ({$uids_s})";
        
		$domain = new Domain_Livepk();
		$list = $domain->getLiveList($uid,$where,$p);
        
        foreach($list as $k=>$v){
            $userinfo=\App\getUserInfo($v['uid']);
            $v['level']=$userinfo['level'];
            $v['level_anchor']=$userinfo['level_anchor'];
            $v['sex']=$userinfo['sex'];
            $list[$k]=$v;
        }

		$rs['info']=$list;
		return $rs;			
	}

	/**
	 * 检测是否直播中
	 * @desc 用于检测要连麦主播是否直播中
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function checkLive() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $stream=\App\checkNull($this->stream);
        $uid_stream=\App\checkNull($this->uid_stream);
        
		$domain = new Domain_Livepk();
		$info = $domain->checkLive($stream);

        if(!$info){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('对方已关播');
            return $rs;
        }

        if($info['anyway'] ==1){
            $rs['code']=1002;
            $rs['msg']=\PhalApi\T('不能跟PC主播连麦');
            return $rs;
        }

		$configpri = \App\getConfigPri(); 
        $nowtime=time();

        $live_sdk=$configpri['live_sdk'];  //live_sdk  0表示金山SDK 1表示腾讯SDK

        if($live_sdk==1){

            //rtmp播流
            /*$bizid = $configpri['tx_bizid'];
            $push_url_key = $configpri['tx_push_key'];
            $tx_acc_key = $configpri['tx_acc_key'];
            $push = $configpri['tx_push'];
            $pull = $configpri['tx_pull'];

            $now_time2 = $nowtime + 3*60*60;
            $txTime = dechex($now_time2);
            
            $live_code = $uid_stream ;
            
            $txSecret2 = md5($tx_acc_key . $live_code . $txTime);
            $safe_url2 = "?txSecret=" . $txSecret2."&txTime=" .$txTime;
            $play_url = "rtmp://" . $pull . "/live/" .$live_code .$safe_url2. "&bizid=" . $bizid;*/


            //trtc播流
            $stream_arr=explode('_', $stream);
            $liveuid=$stream_arr[0];
            $play_url = \App\getTxTrtcUrl($liveuid,$uid_stream);

  
        }else if($configpri['cdn_switch']==5){
			$liveinfo=\PhalApi\DI()->notorm->live
                ->select('pull')
                ->where('stream=?',$uid_stream)
                ->fetchOne();
                
			$play_url=$liveinfo['pull'];
		}else{
			$play_url=\App\PrivateKeyA('rtmp',$uid_stream,0);
		}
		
        $info=array(
			"pull" => $play_url
		);

		$rs['info'][0]=$info;
        
		return $rs;			
	}


	/**
	 * 修改直播信息
	 * @desc 用于连麦成功后更新数据库信息
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function changeLive() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid = \App\checkNull($this->uid);
		$pkuid=\App\checkNull($this->pkuid);

		$type=\App\checkNull($this->type);
		$sign=\App\checkNull($this->sign);
        
        $checkdata=array(
            'uid'=>$uid,
            'pkuid'=>$pkuid,
            'type'=>$type,
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        
        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;	
        } 

		$domain = new Domain_Livepk();
		$info = $domain->changeLive($uid,$pkuid,$type);
        
        if($type==0){
            
            $key1='LivePK';
            $key2='LivePK_gift';
            $key3='LivePK_timer';
            $key4='LiveConnect';
            $key5='LiveConnect_pull';
        
            \App\delcache($key1,$uid);
            \App\delcache($key1,$pkuid);
            
            \App\delcache($key2,$uid);
            \App\delcache($key2,$pkuid);
            
            \App\delcache($key3,$uid);
            \App\delcache($key3,$pkuid);
            
            \App\delcache($key4,$uid);
            \App\delcache($key4,$pkuid);
            
            \App\delcache($key5,$uid);
            \App\delcache($key5,$pkuid);
            
        }else{
            $key4='LiveConnect';
            \App\hSet($key4,$uid,$pkuid);
            \App\hSet($key4,$pkuid,$uid);

        }

		return $rs;			
	}
    
	/**
	 * PK开始
	 * @desc 用于PK开始处理业务
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function setPK() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid = \App\checkNull($this->uid);
		$pkuid=\App\checkNull($this->pkuid);
		$sign=\App\checkNull($this->sign);
        
        $checkdata=array(
            'uid'=>$uid,
            'pkuid'=>$pkuid,
        );
        
        $issign=\App\checkSign($checkdata,$sign);

        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;	
        } 
        
        $key1='LivePK';
        $key2='LivePK_gift';
        
        \App\hSet($key1,$uid,$pkuid);
        \App\hSet($key1,$pkuid,$uid);
        
        \App\hSet($key2,$uid,0);
        \App\hSet($key2,$pkuid,0);


        $nowtime=time();
        $key3='LivePK_timer';
        
        \App\hSet($key3,$uid,$nowtime);
        
        $rs['info'][0]['addtime']=$nowtime;

		return $rs;			
	}



	/**
	 * PK结束
	 * @desc 用于PK结束处理业务
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function endPK() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        
        $uid = \App\checkNull($this->uid);
		$addtime=\App\checkNull($this->addtime);

//        file_put_contents(API_ROOT.'/../log/phalapi/livepk_endpk_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 uid:'.json_encode($uid)."\r\n",FILE_APPEND);
//        file_put_contents(API_ROOT.'/../log/phalapi/livepk_endpk_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 addtime:'.json_encode($addtime)."\r\n",FILE_APPEND);

		$type=\App\checkNull($this->type);
		$sign=\App\checkNull($this->sign);
        
        $checkdata=array(
            'uid'=>$uid,
            'addtime'=>$addtime,
            'type'=>$type,
        );
        
        $issign=\App\checkSign($checkdata,$sign);

        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;	
        }
        
        $key1='LivePK';
        $key2='LivePK_gift';
        $key3='LivePK_timer';
        
        $pkuid = \App\hGet($key1,$uid);
        if(!$pkuid){
            $pkuid=0;
        }
        
        if($type==0){
            $pktime=\App\hGet($key3,$uid);
//            file_put_contents(API_ROOT.'/../log/phalapi/livepk_endpk_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 pktime:'.json_encode($pktime)."\r\n",FILE_APPEND);
            if(!$pktime){
                $pktime=\App\hGet($key3,$pkuid);
            }
//            file_put_contents(API_ROOT.'/../log/phalapi/livepk_endpk_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 pktime:'.json_encode($pktime)."\r\n\r\n",FILE_APPEND);
            if($pktime!=$addtime){
                $rs['code']=1002;
                $rs['msg']=\PhalApi\T('时间不匹配');
                return $rs;	
            }
        }
        
        
        $gift_uid=\App\hGet($key2,$uid);
        if(!$gift_uid){
            $gift_uid=0;
        }
        $gift_pkuid=\App\hGet($key2,$pkuid);
        if(!$gift_pkuid){
            $gift_pkuid=0;
        }
        
        
        $win_uid=0;
        if($type==1){
            $win_uid=$pkuid;
        }else if($gift_uid > $gift_pkuid){
            $win_uid=$uid;
        }else if($gift_uid < $gift_pkuid){
            $win_uid=$pkuid;
        }
        
        
        
        \App\delcache($key1,$uid);
        \App\delcache($key1,$pkuid);
		
        \App\delcache($key2,$uid);
        \App\delcache($key2,$pkuid);
        
        \App\delcache($key3,$uid);
        \App\delcache($key3,$pkuid);
        
        $info=[
            'win_uid'=>$win_uid,
            'pkuid'=>$pkuid,
        ];

        $rs['info'][0]=$info;
        
		return $rs;			
	}    

}
