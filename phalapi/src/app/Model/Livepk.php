<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class Livepk extends NotORM {
	/* 直播中用户列表 */
	public function getLiveList($uid,$where,$p) {
		if($p<1){
            $p=1;
        }
        $pnum=50;
		$start=($p-1)*$pnum;
        
        $list=\PhalApi\DI()->notorm->live
                ->select('uid,stream,pkuid,starttime')
                ->where('islive=1 and isvideo=0 and live_type=0')
                ->where($where)
                ->order('starttime desc')
                ->limit($start,$pnum)
                ->fetchAll();
        foreach($list as $k=>$v){
            $userinfo=\App\getUserInfo($v['uid']);
            $v['avatar']=$userinfo['avatar'];
			$v['avatar_thumb']=$userinfo['avatar_thumb'];
			$v['user_nickname']=$userinfo['user_nickname'];
            
            $list[$k]=$v;
        }
        
		return $list;
	}		


	/* 直播中用户列表 */
	public function checkLive($stream) {
		
        $isexist=\PhalApi\DI()->notorm->live
                ->select('uid,anyway')
                ->where('islive=1 and isvideo=0 and live_type=0 and stream=?',$stream)
                ->fetchOne();
        return $isexist;
	}	


	/* 更新连麦用户信息 */
	public function changeLive($uid,$pkuid,$type) {

        if($type == 1){
            /* 连麦 */
            $uid_live=\PhalApi\DI()->notorm->live
                ->select('uid,stream,pkuid')
                ->where('islive=1 and isvideo=0 and live_type=0 and uid=?',$uid)
                ->fetchOne();
            
            $pkuid_live=\PhalApi\DI()->notorm->live
                ->select('uid,stream,pkuid')
                ->where('islive=1 and isvideo=0 and live_type=0 and uid=?',$pkuid)
                ->fetchOne();

            if($uid_live && $pkuid_live && $uid_live['pkuid']==0 && $pkuid_live['pkuid']==0){
                \PhalApi\DI()->notorm->live
                ->where(" uid={$uid} ")
                ->update( array('pkuid'=>$pkuid_live['uid'],'pkstream'=>$pkuid_live['stream']) );
                
                \PhalApi\DI()->notorm->live
                ->where(" uid={$pkuid} ")
                ->update( array('pkuid'=>$uid_live['uid'],'pkstream'=>$uid_live['stream']) );
                
            }    
            
        }else{
            /* 断麦 */
            \PhalApi\DI()->notorm->live
                ->where(" uid={$uid}  or pkuid={$uid}")
                ->update( array('pkuid'=>0,'pkstream'=>'') );
        }


		return $rs;
	}			
	

}
