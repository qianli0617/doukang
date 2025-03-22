<?php
namespace App\Model;
use PhalApi\Model\NotORMModel as NotORM;
use App\Model\Agent as Model_Agent;

class Charge extends NotORM {
	/* 订单号 */
	public function getOrderId($changeid,$orderinfo) {
		
		$charge=\PhalApi\DI()->notorm->charge_rules->select('*')->where('id=?',$changeid)->fetchOne();
		
		if(!$charge || $charge['money']!=$orderinfo['money'] || ($charge['coin']!=$orderinfo['coin']  && $charge['coin_ios']!=$orderinfo['coin'] && $charge['coin_paypal']!=$orderinfo['coin'])){
			return 1003;
		}
		
		$orderinfo['coin_give']=$charge['give'];
		if($charge['type']==1){ //首充规则
			$orderinfo['is_first']=1;
			$orderinfo['score']=$charge['score'];
			$orderinfo['vip_length']=$charge['vip_length'];
			$orderinfo['giftid']=$charge['giftid'];
			$orderinfo['gift_num']=$charge['gift_num'];
		}
		

		$result= \PhalApi\DI()->notorm->charge_user->insert($orderinfo);

		return $result;
	}

	public function getFirstChargeRules(){
		$key='getFirstChargeRules';
		$first_rules=\App\getcaches($key);
		
		//语言包
		if(!$first_rules){
			$first_rules=\PhalApi\DI()->notorm->charge_rules
						->select("id,name,name_en,coin,coin_ios,money,product_id,give,coin_paypal,score,vip_length,giftid,gift_num")
						->where("type=1")
			            ->order('list_order asc')
			            ->fetchAll();
			

			\App\setcaches($key,$first_rules);
		}

		$new_rules=[];
		$configpub=\App\getConfigPub();

		foreach ($first_rules as $k => $v) {
			
			$arr=[];

			//语言包
			$language=\PhalApi\DI()->language;

			if($language=='en'){
				$arr['title']=$v['name_en'];
			}else{
				$arr['title']=$v['name'];
			}

			$arr['id']=(string)$v['id'];
			$arr['money']=$v['money'];
			$arr['coin']=(string)$v['coin'];
			$arr['list']=[];

			$list=[];
			if($v['coin']>0){ //钻石
				$list_arr=[];
				$list_arr['name']=$configpub['name_coin'];
				$list_arr['count']=(string)$v['coin'];
				$list_arr['thumb']=\App\get_upload_path("/static/app/pay/first_coin.png");
				$list[]=$list_arr;
			}

			if($v['score']>0){ //积分
				$list_arr=[];
				$list_arr['name']=$configpub['name_score'];
				$list_arr['count']=(string)$v['score'];
				$list_arr['thumb']=\App\get_upload_path("/static/app/pay/first_score.png");;
				$list[]=$list_arr;
			}

			if($v['vip_length']>0){ //vip会员
				$list_arr=[];
				$list_arr['name']=\PhalApi\T("会员特权");
				$list_arr['count']=(string)$v['vip_length'];
				$list_arr['thumb']=\App\get_upload_path("/static/app/pay/first_vip.png");;
				$list[]=$list_arr;
			}

			//语言包

			if($v['giftid']>0){ //热门礼物
				$gift_info=\PhalApi\DI()->notorm->gift->select("giftname,giftname_en,gifticon")->where("id={$v['giftid']}")->fetchOne();
				$list_arr=[];

				$language=\PhalApi\DI()->language;

				if($language=='en'){
					$gift_info['giftname']=$gift_info['giftname_en'];
				}

				$list_arr['name']=$gift_info['giftname'];
				$list_arr['count']=(string)$v['gift_num'];
				$list_arr['thumb']=\App\get_upload_path($gift_info['gifticon']);
				$list[]=$list_arr;
			}

			$arr['list']=$list;
			$new_rules[]=$arr;
			
		}

		return $new_rules;
	}



}
