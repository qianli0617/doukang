<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Linkmic extends NotORM {
	/* 设置连麦开关 */
	public function setMic($uid,$ismic) {

        $result=\PhalApi\DI()->notorm->live
                ->where('uid=?',$uid)
                ->update( ['ismic'=>$ismic] );
        
		return $result;
	}		


	/* 判断主播连麦开关 */
	public function isMic($liveuid) {
		
        $isexist=\PhalApi\DI()->notorm->live
                ->select('ismic')
                ->where('uid=?',$liveuid)
                ->fetchOne();
        if($isexist && $isexist['ismic']){
            return 1;
        }
        
		return 0;
	}	

	

}
