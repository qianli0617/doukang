<?php
/**
 * 游戏说明
 */
namespace app\appapi\controller;

use cmf\controller\HomeBaseController;
use think\facade\Db;

class GameController extends HomebaseController {
    
	//星球探宝
	function xqtb(){
        $configpub=getConfigPub();
        $name_coin=$configpub['name_coin'];

		$list=Db::name("xqtb_gift")->order("list_order")->select();
        
		$list->each(function($v,$k) use ($name_coin){
            if($v['type']==0){
            	$v['gift_info']=['giftname'=>$name_coin];
            	$v['total']=$v['coin'];
            }else{

            	//语言包
            	$gift_info=Db::name("gift")->field("giftname,giftname_en,needcoin")->where(['id'=>$v['giftid']])->find();

            	$language=$this->language;
            	if($language=='en'){
            		$gift_info['giftname']=$gift_info['giftname_en'];
            	}
            	$v['gift_info']=$gift_info;
            	$v['total']=$v['gift_num']*$gift_info['needcoin'];
            }
            
            return $v;
        });

		$this->assign("uid",'');
		$this->assign("token",'');
		$this->assign("list",$list);
		$this->assign("name_coin",$name_coin);
		
		return $this->fetch();
	    
	}

	//幸运大转盘
	function xydzp(){
		$configpub=getConfigPub();
        $name_coin=$configpub['name_coin'];

		$list=Db::name("xydzp_gift")->order("list_order")->select();
        
		$list->each(function($v,$k) use ($name_coin){
            if($v['type']==0){
            	$v['gift_info']=['giftname'=>$name_coin];
            	$v['total']=$v['coin'];
            }else{
            	$gift_info=Db::name("gift")->field("giftname,giftname_en,needcoin")->where(['id'=>$v['giftid']])->find();

            	//语言包
            	$language=$this->language;
            	if($language=='en'){
            		$gift_info['giftname']=$gift_info['giftname_en'];
            	}

            	$v['gift_info']=$gift_info;
            	$v['total']=$v['gift_num']*$gift_info['needcoin'];
            }
            
            return $v;
        });

		$this->assign("uid",'');
		$this->assign("token",'');
		$this->assign("list",$list);
		$this->assign("name_coin",$name_coin);
		
		return $this->fetch();
	}
	
}