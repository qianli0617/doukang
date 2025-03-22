<?php
namespace App\Domain;
use App\Model\Seller as Model_Seller;
use App\Model\Shop as Model_Shop;

class Seller {

	public function getHome($uid){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$status=\App\getShopApplyStatus($uid);
		if($status==-1){
			$rs['code']=1001;
			$rs['msg']=\Phalapi\T('未申请店铺');
			return $rs;
		}

		if($status==0){
			$rs['code']=1002;
			$rs['msg']=\Phalapi\T('店铺审核中,请耐心等待');
			return $rs;
		}

		if($status==2){
			$rs['code']=1003;
			$rs['msg']=\Phalapi\T('店铺申请被拒,请联系平台客服');
			return $rs;
		}

		$model=new Model_Shop();

		//获取卖家的店铺信息
        $shop_info=$model->getShop($uid);
        $userinfo=\App\getUserInfo($uid);
        $shop_info['name']=$userinfo['user_nickname']; //卖家查看自己的店铺 要将店铺名称显示为自己的昵称

        $rs['info'][0]['shop_info']=$shop_info;

        if(!$shop_info['goods_nums']&&!$shop_info['sale_nums']){
        	$seller_desc=\Phalapi\T('暂无商品');
        }else{
        	$seller_desc=\Phalapi\T('共{num}件商品 总销量{sale_num}件',['num'=>$shop_info['goods_nums'],'sale_num'=>$shop_info['sale_nums']]);
        }

        $rs['info'][0]['seller_desc']=$seller_desc;

        $user_balance=\App\getUserBalance($uid);
        $rs['info'][0]['balance_info']=$user_balance;

        $model=new Model_Seller();
        $orderinfo=$model->getHome($uid);
        $rs['info'][0]['order_info']=$orderinfo;
        return $rs;

        
	}

	public function getGoodsClass($uid) {
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->getGoodsClass($uid);

		return $rs;
	}

	public function setGoods($data){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->setGoods($data);

		return $rs;
	}

	public function getGoodsNums($uid){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->getGoodsNums($uid);

		return $rs;
	}

	public function getGoodsList($uid,$type,$p){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->getGoodsList($uid,$type,$p);

		return $rs;
	}

	public function getReceiverAddress($uid){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->getReceiverAddress($uid);

		return $rs;
	}

	public function upReceiverAddress($uid,$data){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->upReceiverAddress($uid,$data);

		return $rs;
	}

	public function upGoodsSpecs($uid,$goodsid,$specs){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->upGoodsSpecs($uid,$goodsid,$specs);

		return $rs;
	}

	public function upGoods($uid,$goodsid,$data){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->upGoods($uid,$goodsid,$data);

		return $rs;
	}

	public function delGoods($uid,$goodsid) {
        
		$rs = array('code' => 0, 'msg' => \Phalapi\T('操作成功'), 'info' => array());

		$model = new Model_Shop();
        
        $where=[];
        $where['id=?']=$goodsid;
        
        $info=$model->getGoods($where);
        if(!$info){
            $rs['code'] = 1001;
			$rs['msg'] = \Phalapi\T('商品不存在');
			return $rs;
        }
        
        
        if($info['uid']!=$uid){
            $rs['code'] = 1003;
			$rs['msg'] = \Phalapi\T('无权操作');
			return $rs;
        }
        $where['uid']=$uid;

        $model = new Model_Seller();
		$res = $model->delGoods($where);

		return $rs;
	}

	public function upStatus($uid,$goodsid,$status){
		$rs = array('code' => 0, 'msg' => \Phalapi\T('操作成功'), 'info' => array());

		$model = new Model_Shop();
        
        $where=[];
        $where['id=?']=$goodsid;
        
        $info=$model->getGoods($where);
        if(!$info){
            $rs['code'] = 1001;
			$rs['msg'] = \Phalapi\T('商品不存在');
			return $rs;
        }

        if($info['uid']!=$uid){
            $rs['code'] = 1002;
			$rs['msg'] = \Phalapi\T('无权操作');
			return $rs;
        }

        if($info['status']==-2){
            $rs['code'] = 1002;
			$rs['msg'] = \Phalapi\T('商品已被平台下架,您无法上架');
			return $rs;
        }

		$model = new Model_Seller();
		$res = $model->upStatus($goodsid,$status);
		if(!$res){
			$rs['code'] = 1003;
			$rs['msg'] = \Phalapi\T('操作失败,请重试');
			return $rs;
		}

		return $rs;
	}

	//获取物流公司列表
	public function getExpressList(){

		$key='getExpressList';
		$express_list=\App\getcaches($key);

		if(!$express_list){
			$model=new Model_Seller();
			$express_list=$model->getExpressList();

			\App\setcaches($key,$express_list);

		}
		
		//语言包
		$language=\Phalapi\DI()->language;
		foreach ($express_list as $k => $v) {
			$express_list[$k]['express_thumb']=\App\get_upload_path($v['express_thumb']);
			if($language=='en'){
				$express_list[$k]['express_name']=$v['express_name_en'];
			}
		}

		return $express_list;
	}

	// 卖家根据不同类型获取订单列表
	public function getGoodsOrderList($uid,$type,$p){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->getGoodsOrderList($uid,$type,$p);

		return $rs;
	}

	//获取卖家不同订单类型的总订单数
	public function getTypeListNums($uid,$type_arr){
		$rs = array();

		$model = new Model_Seller();
		$rs = $model->getTypeListNums($uid,$type_arr);

		return $rs;
	}

	//卖家填写物流信息
	public function setExpressInfo($uid,$orderid,$expressid,$express_number){
		$express_info=\App\getExpressInfo(['id'=>$expressid,'express_status'=>1]);

		$now=time();

		//语言包
		$data=array(
			'express_name'=>$express_info['express_name'],
			'express_name_en'=>$express_info['express_name_en'],
			'express_phone'=>$express_info['express_phone'],
			'express_thumb'=>$express_info['express_thumb'],
			'express_code'=>$express_info['express_code'],
			'express_number'=>$express_number,
			'status'=>2,
			'shipment_time'=>$now
		);
		$res=\App\changeShopOrderStatus($uid,$orderid,$data);
		if(!$res){
			return 0;
		}

		//写入订单消息列表【语言包】
		$orderinfo=\App\getShopOrderInfo(['id'=>$orderid]);

        $title="你购买的“".$orderinfo['goods_name']."”商家已经发货,物流单号为:".$express_number;
        $title_en="The {$orderinfo['goods_name']} merchant you purchased has shipped the goods, and the logistics order number is:".$express_number;

        $data1=array(
            'uid'=>$orderinfo['uid'],
            'orderid'=>$orderid,
            'title'=>$title,
            'title_en'=>$title_en,
            'addtime'=>$now,
            'type'=>'0'

        );

        \App\addShopGoodsOrderMessage($data1);

        //发送腾讯IM
        
        $im_msg=[
        	'zh-cn'=>$title,
        	'en'=>$title_en,
        	'method'=>'order'
        ];
        \App\txMessageIM(json_encode($im_msg),$orderinfo['uid'],'goodsorder_admin','TIMCustomElem');

		return 1;
	}

	//卖家获取拒绝退款原因列表
	public function getRefundRefuseReason(){
		$key='getRefundRefuseReason';
		$refuse_list=\App\getcaches($key);

		if(!$refuse_list){
			$model=new Model_Seller();
			$refuse_list=$model->getRefundRefuseReason();

			\App\setcaches($key,$refuse_list);

		}

		return $refuse_list;
	}

	//卖家处理退款
	/*public function setGoodsOrderRefund(){

	}*/

	//获取结算记录
	public function getSettlementList($uid,$p){
		$rs=array();
        $model=new Model_Seller();
        $rs=$model->getSettlementList($uid,$p);
        return $rs;
	}

	//获取卖家待结算总金额
	public function getWaitSettlementTotal($uid){
		$rs=array();
        $model=new Model_Seller();
        $rs=$model->getWaitSettlementTotal($uid);
        return $rs;
	}

	//添加外链商品
	public function setOutsideGoods($data){
		$rs=array();
        $model=new Model_Seller();
        $rs=$model->setOutsideGoods($data);
        return $rs;
	}

	//外链商品编辑提交
	public function upOutsideGoods($goodsid,$data){
		$rs=array();
        $model=new Model_Seller();
        $rs=$model->upOutsideGoods($goodsid,$data);
        return $rs;
	}
	
	//卖家获取平台自营商品列表
	public function getPlatformGoodsLists($uid,$p){
		$rs=array();
        $model=new Model_Seller();
        $rs=$model->getPlatformGoodsLists($uid,$p);
        return $rs;
	}

	public function setPlatformGoods($uid,$goodsid){
		$rs=array();
        $model=new Model_Seller();
        $rs=$model->setPlatformGoods($uid,$goodsid);
        return $rs;
	}

	public function getOnsalePlatformGoods($uid,$p){
		$rs=array();
        $model=new Model_Seller();
        $rs=$model->getOnsalePlatformGoods($uid,$p);
        return $rs;
	}

	
}
