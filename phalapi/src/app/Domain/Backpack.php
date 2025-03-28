<?php
namespace App\Domain;
use App\Model\Backpack as Model_Backpack;
use App\Domain\Live as Domain_Live;

class Backpack {
	public function getBackpack($uid,$live_type) {

		$model = new Model_Backpack();
		$list = $model->getBackpack($uid);
        
        $domain = new Domain_Live();
        $giftlist=$domain->getGiftList($live_type);
		$proplist=$domain->getPropgiftList();
        
        foreach($list as $k=>$v){
            foreach($giftlist as $k2=>$v2){
                if($v['giftid']==$v2['id']){
                    $v2['nums']=$v['nums'];
                    
                    $v=$v2;
                    break;
                }
            }
            $list[$k]=$v;
        }
		
		foreach($list as $k=>$v){
            foreach($proplist as $k2=>$v2){
                if($v['giftid']==$v2['id']){
                    $v2['nums']=$v['nums'];
                    
                    $v=$v2;
                    break;
                }
            }
            $list[$k]=$v;
        }

		return $list;
	}

	public function addBackpack($uid,$giftid,$nums) {
		$rs = array();

		$model = new Model_Backpack();
		$rs = $model->addBackpack($uid,$giftid,$nums);

		return $rs;
	}

	public function reduceBackpack($uid,$giftid,$nums) {
		$rs = array();

		$model = new Model_Backpack();
		$rs = $model->reduceBackpack($uid,$giftid,$nums);

		return $rs;
	}
	
}
