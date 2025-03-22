<?php
namespace App\Model;
use PhalApi\Model\NotORMModel as NotORM;

class Family extends NotORM {

	/* 轮播 */
	public function createFamily($info){

		$family_info=\PhalApi\DI()->notorm->family
			->select("*")
			->where("uid=?",$info['uid'])
			->fetchOne();

		if($family_info){
			if($family_info['state']==0){
				return 1002;
			}

			if($family_info['state']==2){
				return 1003;
			}

			$res=\PhalApi\DI()->notorm->family->where("id=?",$family_info['id'])->update($info);
			if(!$res){
				return 1001;
			}

		}else{
			$res=\PhalApi\DI()->notorm->family->insert($info);
			if(!$res){
				return 1001;
			}
		}
						

		return 1;
	}


}
