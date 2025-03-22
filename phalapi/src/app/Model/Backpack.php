<?php
namespace App\Model;
use PhalApi\Model\NotORMModel as NotORM;

class Backpack extends NotORM {
	/* 背包礼物 */
	public function getBackpack($uid) {
		
        $list=\PhalApi\DI()->notorm->backpack
            ->select('giftid,nums')
            ->where('uid=? and nums>0',$uid)
            ->fetchAll();

		return $list;
	}
    
    /* 添加背包礼物 */
	public function addBackpack($uid,$giftid,$nums) {

        $rs=\PhalApi\DI()->notorm->backpack
                ->where('uid=? and giftid=?',$uid,$giftid)
                ->update(array('nums'=> new \NotORM_Literal("nums + {$nums} ")));
        if(!$rs){
            $rs=\PhalApi\DI()->notorm->backpack
                ->insert(array( 'uid'=>$uid, 'giftid'=>$giftid, 'nums'=>$nums ));
        }

		return $rs;
	}

    /* 减少背包礼物 */
	public function reduceBackpack($uid,$giftid,$nums) {

        $rs=\PhalApi\DI()->notorm->backpack
                ->where('uid=? and giftid=? and nums>=?',$uid,$giftid,$nums)
                ->update(array('nums'=> new \NotORM_Literal("nums - {$nums} ")));

		return $rs;
	}

}
