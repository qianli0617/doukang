<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Buyer as Domain_Buyer;
use App\Domain\Shop as Domain_Shop;
/**
 * 买家
 */
class Buyer extends Api {

	public function getRules() {
		return array(

            'getHome'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
            ),

			'addAddress' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
                'username' => array('name' => 'username', 'type' => 'string',  'require' => true, 'desc' => '姓名'),
				'country_code' => array('name' => 'country_code', 'type' => 'int', 'default' => '86', 'desc' => '国家代号'),
                'phone' => array('name' => 'phone', 'type' => 'string', 'require' => true, 'desc' => '联系电话'),
				'province' => array('name' => 'province', 'type' => 'string',  'require' => true, 'desc' => '省份'),
				'city' => array('name' => 'city', 'type' => 'string',  'require' => true, 'desc' => '城市'),
				'area' => array('name' => 'area', 'type' => 'string', 'require' => true, 'desc' => '地区'),
                'address' => array('name' => 'address', 'type' => 'string', 'desc' => '详细地址'),
                'is_default' => array('name' => 'is_default', 'type' => 'int', 'default'=>'0', 'desc' => '是否是默认地址 0 否 1 是'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名'),
			),
            
            'editAddress' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
                'addressid' => array('name' => 'addressid', 'type' => 'int',  'require' => true, 'desc' => '地址id'),
                'username' => array('name' => 'username', 'type' => 'string',  'require' => true, 'desc' => '姓名'),
                'country_code' => array('name' => 'country_code', 'type' => 'int', 'default' => '86', 'desc' => '国家代号'),
                'province' => array('name' => 'province', 'type' => 'string',  'require' => true, 'desc' => '省份'),
                'phone' => array('name' => 'phone', 'type' => 'string', 'require' => true, 'desc' => '联系电话'),
                'city' => array('name' => 'city', 'type' => 'string',  'require' => true, 'desc' => '城市'),
				'area' => array('name' => 'area', 'type' => 'string', 'require' => true, 'desc' => '地区'),
                'address' => array('name' => 'address', 'type' => 'string', 'desc' => '详细地址'),
                'is_default' => array('name' => 'is_default', 'type' => 'int', 'desc' => '是否是默认地址 0 否 1 是'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名'),
			),
            
            'addressList' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string', 'desc' => '用户Token'),
                'time' => array('name' => 'time', 'type' => 'string',  'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'desc' => '签名'),
			),

            'delAddress' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
                'addressid' => array('name' => 'addressid', 'type' => 'string', 'desc' => '地址id'),
                'time' => array('name' => 'time', 'type' => 'string',  'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'desc' => '签名'),
            ),

            'addGoodsVisitRecord'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户Token'),
                'goodsid' => array('name' => 'goodsid', 'type' => 'int', 'desc' => '商品ID'),
                'time' => array('name' => 'time', 'type' => 'string',  'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'desc' => '签名'),
            ),

            'delGoodsVisitRecord'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户Token'),
                'recordids' => array('name' => 'recordids', 'type' => 'string', 'desc' => '商品浏览记录ID拼接字符串'),
                'time' => array('name' => 'time', 'type' => 'string',  'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'desc' => '签名'),
            ),

            'getGoodsVisitRecord'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户Token'),
                'p' => array('name' => 'p', 'type' => 'int',  'desc' => '页数'),
            ),

            'createGoodsOrder'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户Token'),
                'addressid' => array('name' => 'addressid', 'type' => 'int',  'desc' => '地址id'),
                'goodsid' => array('name' => 'goodsid', 'type' => 'int',  'desc' => '商品id'),
                'spec_id' => array('name' => 'spec_id', 'type' => 'string',  'desc' => '商品规格id'),
                'nums' => array('name' => 'nums', 'type' => 'int',  'desc' => '商品购买数量'),
                'message' => array('name' => 'message', 'type' => 'string',  'desc' => '买家留言'),
                'time' => array('name' => 'time', 'type' => 'string',  'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string',  'desc' => '签名串'),
                'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 0, 'default'=>0, 'desc' => '代售平台商品的主播ID'),
                'shareuid' => array('name' => 'shareuid', 'type' => 'int', 'min' => 0, 'default'=>0, 'desc' => '分享该商品的用户ID'),

            ),
			
			'createGoodsOrderCart'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户Token'),
				'addressid' => array('name' => 'addressid', 'type' => 'int',  'desc' => '地址id'),
				'goodsuid' => array('name' => 'goodsuid', 'type' => 'int',  'desc' => '商品店铺id'),
				'cartsid'=>array('name' => 'cartsid', 'type' => 'string',  'desc' => '购物车id,多个商品用逗号隔开'),
				'message' => array('name' => 'message', 'type' => 'string',  'desc' => '买家留言'),
				'time' => array('name' => 'time', 'type' => 'string',  'desc' => '时间戳'),
				'sign' => array('name' => 'sign', 'type' => 'string',  'desc' => '签名串'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 0, 'default'=>0, 'desc' => '代售平台商品的主播ID'),
				'shareuid' => array('name' => 'shareuid', 'type' => 'int', 'min' => 0, 'default'=>0, 'desc' => '分享该商品的用户ID'),
			),

            'getBalance' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
				'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
				'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
			),

			'goodsOrderPay'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
				'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单ids'),
				'type' => array('name' => 'type', 'type' => 'int',  'desc' => '支付类型 1 支付宝 2 微信 3 余额 4 微信小程序 5 paypal 6 BraintreePaypal'),
				'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
				'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
				'appid' => array('name' => 'appid', 'type' => 'string', 'desc' => 'appid'),
			),
			
			'goodsOrderPayNew'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
				'orderid' => array('name' => 'orderid', 'type' => 'string',  'desc' => '订单ids'),
				'type' => array('name' => 'type', 'type' => 'int',  'desc' => '支付类型 1 支付宝 2 微信 3 余额 4 微信小程序 5 paypal 6 BraintreePaypal'),
				'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
				'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
				'appid' => array('name' => 'appid', 'type' => 'string', 'desc' => 'appid'),
			),

            'getGoodsOrderList'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'type' => array('name' => 'type', 'type' => 'string',  'desc' => '订单类型 all 所有订单 wait_payment 待付款 wait_shipment 待发货 wait_receive 待收货 wait_evaluate 待评价 refund 退款'),
                'p' => array('name' => 'p', 'type' => 'int', 'desc' => '页数'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'cancelGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'receiveGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'delGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'getGoodsOrderInfo'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'evaluateGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'content' => array('name' => 'content', 'type' => 'string',  'desc' => '评论文字内容'),
                'thumbs' => array('name' => 'thumbs', 'type' => 'string', 'desc' => '评论图片集合'),
                'video_url' => array('name' => 'video_url', 'type' => 'string', 'desc' => '评论视频链接地址'),
                'video_thumb' => array('name' => 'video_thumb', 'type' => 'string', 'desc' => '评论视频封面地址'),
                'is_anonym' => array('name' => 'is_anonym', 'type' => 'int', 'desc' => '是否匿名评价 0 否 1 是'),
                'quality_points' => array('name' => 'quality_points', 'type' => 'int', 'desc' => '商品质量评分0-5的整数'),
                'service_points' => array('name' => 'service_points', 'type' => 'int', 'desc' => '店铺服务态度评分0-5的整数'),
                'express_points' => array('name' => 'express_points', 'type' => 'int', 'desc' => '物流服务评分0-5的整数'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'appendEvaluateGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'content' => array('name' => 'content', 'type' => 'string',  'desc' => '评论文字内容'),
                'thumbs' => array('name' => 'thumbs', 'type' => 'string', 'desc' => '评论图片集合'),
                'video_url' => array('name' => 'video_url', 'type' => 'string', 'desc' => '评论视频链接地址'),
                'video_thumb' => array('name' => 'video_thumb', 'type' => 'string', 'desc' => '评论视频封面地址'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'getRefundReason'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
            ),

            'applyRefundGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'type' => array('name' => 'type', 'type' => 'int',  'desc' => '退款类型 0 仅退款 1 退货退款'),
                'reasonid' => array('name' => 'reasonid', 'type' => 'int',  'desc' => '退款理由id'),
                'content' => array('name' => 'content', 'type' => 'string',  'desc' => '退款说明'),
                'thumb' => array('name' => 'thumb', 'type' => 'string',  'desc' => '退款图片'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),

            ),

            'cancelRefundGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'getGoodsOrderRefundInfo'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'reapplyRefundGoodsOrder'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'getPlatformReasonList'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
            ),

            'applyPlatformInterpose'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'orderid' => array('name' => 'orderid', 'type' => 'int',  'desc' => '订单id'),
                'reasonid' => array('name' => 'reasonid', 'type' => 'int',  'desc' => '申请平台介入原因ID'),
                'content' => array('name' => 'content', 'type' => 'string',  'desc' => '申请原因说明'),
                'thumb' => array('name' => 'thumb', 'type' => 'string',  'desc' => '上传申请图片'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
            ),

            'getRefundList'=>array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1,  'desc' => '用户ID'),
                'token' => array('name' => 'token', 'type' => 'string',  'desc' => '用户token'),
                'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名字符串'),
                'p' => array('name' => 'p', 'type' => 'int', 'desc' => '分页'),
            ),

		);
	}

    /**
     * 获取买家首页信息
     * @desc 用于 获取买家首页信息
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     * @return int info[0]['wait_payment'] 待付款订单数
     * @return int info[0]['wait_shipment'] 待发货订单数
     * @return int info[0]['wait_receive'] 待收货订单数
     * @return int info[0]['wait_evaluate'] 待收货订单数
     * @return int info[0]['refund'] 退款订单数
     * @return int info[0]['apply_status'] 店铺申请状态
     * @return string info[0]['apply_reason'] 店铺申请被拒绝原因
     */
    public function getHome(){


        $rs = array('code' => 0, 'msg' => '', 'info' => array());
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $res=$domain->getHome($uid);

        $rs['info'][0]=$res;

        $domain_shop=new Domain_Shop();
        $apply_res=$domain_shop->getShopApplyInfo($uid);

        $apply_reason='';
        if($apply_res['apply_status']!=-1){
            $apply_reason=$apply_res['apply_info']['reason'];
        }

        $rs['info'][0]['apply_status']=$apply_res['apply_status'];
        $rs['info'][0]['apply_reason']=$apply_reason;
        
        return $rs;
    }

    

	/**
	 * 添加收货地址
	 * @desc 用于添加收货地址
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string msg 提示信息
	 */
	public function addAddress() {
		$rs = array('code' => 0, 'msg' => \PhalApi\T('地址添加成功'), 'info' => array());
		
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $username=\App\checkNull($this->username);
        $country_code=\App\checkNull($this->country_code);
        $phone=\App\checkNull($this->phone);
        $province=\App\checkNull($this->province);
        $city=\App\checkNull($this->city);
        $area=\App\checkNull($this->area);
		$address=\App\checkNull($this->address);
		$is_default=\App\checkNull($this->is_default);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
		$addtime=time();
        
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

        if(!$time||!$sign){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('参数错误');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time,
            'is_default'=>$is_default,
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }
		
		if($username==''){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('请输入姓名');
			return $rs;
		}

        if(mb_strlen($username)>10){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('姓名长度在10个字内');
            return $rs;
        }

        $checkmobile=\App\checkMobile($phone);

        if(!$checkmobile){
            $rs['code']=1002;
            $rs['msg']=\PhalApi\T('手机号码不正确');
            return $rs;
        }
        
        if($province==''){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('请选择省份');
			return $rs;
		}

        if($city==''){
            $rs['code']=1004;
            $rs['msg']=\PhalApi\T('请选择所在市');
            return $rs;
        }

        if($area==''){
            $rs['code']=1005;
            $rs['msg']=\PhalApi\T('请选择地区');
            return $rs;
        }

        if(!$address){
            $rs['code'] = 1006;
            $rs['msg'] = \PhalApi\T('请填写详细地址');
            return $rs;
        }
        

		$data=array(
			"uid"=>$uid,
			"name"=>$username,
			"country"=>\PhalApi\T('中国'),
			"province"=>$province,
			"city"=>$city,
			"area"=>$area,
			"address"=>$address,
			"phone"=>$phone,
			"country_code"=>$country_code,
			"is_default"=>$is_default,
			"addtime"=>$addtime
		);


		$domain = new Domain_Buyer();
		$result = $domain->addAddress($data);
		
        if($result==1001){
        	$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('地址添加失败');
        	return $rs;
        }

		return $rs;
	}

	/**
	 * 修改收货地址
	 * @desc 用于修改收货地址
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string msg 提示信息
	 */
	public function editAddress() {
        $rs = array('code' => 0, 'msg' => \PhalApi\T('地址修改成功'), 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $addressid=\App\checkNull($this->addressid);
        $username=\App\checkNull($this->username);
        $country_code=\App\checkNull($this->country_code);
        $phone=\App\checkNull($this->phone);
        $province=\App\checkNull($this->province);
        $city=\App\checkNull($this->city);
        $area=\App\checkNull($this->area);
		$address=\App\checkNull($this->address);
		$is_default=\App\checkNull($this->is_default);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
		$edittime=time();

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

        if(!$address){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('请填写详细地址');
            return $rs;
        }

        if(!$time){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('参数错误');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        if(!$sign){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('参数错误');
            return $rs;
        }
        
        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time,
            'addressid'=>$addressid
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;
        }
        
        if($username==''){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('请输入姓名');
			return $rs;
		}

        if(mb_strlen($username)>10){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('姓名长度在10个字内');
            return $rs;
        }

        $checkmobile=\App\checkMobile($phone);

        if(!$checkmobile){
            $rs['code']=1002;
            $rs['msg']=\PhalApi\T('手机号码不正确');
            return $rs;
        }
        
        if($province==''){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('请选择省份');
			return $rs;
		}

        if($city==''){
            $rs['code']=1004;
            $rs['msg']=\PhalApi\T('请选择所在市');
            return $rs;
        }

        if($area==''){
            $rs['code']=1005;
            $rs['msg']=\PhalApi\T('请选择地区');
            return $rs;
        }
        

		$data=array(
			
			"uid"=>$uid,
            "name"=>$username,
			"country"=>\PhalApi\T('中国'),
			"province"=>$province,
			"city"=>$city,
			"area"=>$area,
			"address"=>$address,
			"phone"=>$phone,
			"country_code"=>$country_code,
			"is_default"=>$is_default,
			"edittime"=>$edittime
		);
        
        $domain = new Domain_Buyer();
		$result = $domain->editAddress($addressid,$data);

        if($result==1001){
            $rs['code']=1004;
            $rs['msg']=\PhalApi\T('地址修改失败');
            return $rs;
        }
     
        return $rs;
        
    }
    
	/**
	 * 获取收货地址列表
	 * @desc 用于用户获取收货地址列表
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].name 姓名
     * @return string info[0].country 国家
     * @return string info[0].province 省份
	 * @return string info[0].city 城市
     * @return string info[0].area 地区
     * @return string info[0].address 详细地址
     * @return string info[0].country_code 国家代号
	 * @return string info[0].phone 电话
     * @return string info[0].is_default 是否为默认地址
	 * @return string msg 提示信息
	 */
	public function addressList() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==''||!$time||!$sign){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('参数错误');
            return $rs;
        }
        
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        
        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time,
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;
        }
        
        $domain=new Domain_Buyer();
        $result=$domain->addressList($uid);
        $rs['info']=$result;
        
        return $rs;
        
    }
    
    /**
     * 删除收货地址
     * @desc 用于用户删除收货地址
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     */
    public function delAddress(){

        $rs = array('code' => 0, 'msg' => \PhalApi\T('地址删除成功'), 'info' => array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $addressid=\App\checkNull($this->addressid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==''||!$addressid||!$time||!$sign){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }


        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }


        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time,
            'addressid'=>$addressid
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $result=$domain->delAddress($uid,$addressid);
        if($result==1001){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('收货地址删除失败');
            return $rs;
        }

        if($result==1002){
            $rs['code']=1002;
            $rs['msg']=\PhalApi\T('收货地址不能为空,无法删除');
            return $rs;
        }

        return $rs;
    }
    
    /**
     * 添加商品访问记录
     * @desc 用于 添加商品访问记录
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     */
    public function addGoodsVisitRecord(){

        $rs = array('code' => 0, 'msg' => \PhalApi\T('商品浏览记录添加成功'), 'info' => array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $goodsid=\App\checkNull($this->goodsid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==''||!$goodsid||!$time||!$sign){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time,
            'goodsid'=>$goodsid
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        //判断商品是否存在
        $where['id']=$goodsid;
        $where['status']=1;

        $domain=new Domain_Shop();
        $goodsinfo=$domain->getGoods($where);

        if(!$goodsinfo){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('商品不存在');
            return $rs;
        }

        $visit=\App\getcaches($uid."_".$goodsid);

        if($visit){
            return $rs;
        }

        $domain=new Domain_Buyer();
        $res=$domain->addGoodsVisitRecord($uid,$goodsid);

        return $res;

    }

    /**
     * 删除商品访问记录
     * @desc 用于 删除商品访问记录
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     */
    public function delGoodsVisitRecord(){

        $rs = array('code' => 0, 'msg' => \PhalApi\T('商品浏览记录删除成功'), 'info' => array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $recordids=\App\checkNull($this->recordids);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==''||!$recordids||!$time||!$sign){
            $rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $record_arr=explode(',',$recordids);

        $domain=new Domain_Buyer();
        $res=$domain->delGoodsVisitRecord($uid,$record_arr);

        if(!$res){
        	$rs['code']=1001;
            $rs['msg']=\PhalApi\T('商品浏览记录删除失败');
            return $rs;
        }

        return $rs;
    }

	/**
     * 获取商品访问记录
     * @desc 用于 获取商品访问记录
     * @return int code 操作码，0表示成功
     * @return array info
     * @return array info[].date分组日期
     * @return array info[].[list][]['id'] 访问记录id
     * @return array info[].[list][]['uid'] 访问记录用户id
     * @return array info[].[list][]['goodsid'] 访问记录商品id
     * @return array info[].[list][]['addtime'] 访问记录时间
     * @return array info[].[list][]['goods_name'] 访问记录商品名称
     * @return array info[].[list][]['goods_thumb'] 访问记录商品封面
     * @return array info[].[list][]['goods_price'] 访问记录商品价格
     * @return array info[].[list][]['goods_status'] 访问记录商品状态 0审核中-1商家下架1通过-2管理员下架 2拒绝
     * @return string msg 提示信息
     */
    public function getGoodsVisitRecord(){
    	$rs = array('code' => 0, 'msg' => '', 'info' => array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $p=$this->p;

        if($uid<0||$token==''){
        	$rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $res=$domain->getGoodsVisitRecord($uid,$p);
        $rs['info']=$res;

        return $rs;
    }


    /* 获取订单号 */
	protected function getOrderno($uid,$goodsid){
		$orderid='00'.$uid.$goodsid.date('YmdHis').rand(100,999);
		return $orderid;
	}


    /**
     * 买家提交商品订单
     * @desc 用于 买家提交商品订单
     * @return int code 操作码，0表示成功
     * @return array info
     * @return array info[0].orderid 商品订单ID
     * @return string msg 提示信息
     */
    public function createGoodsOrder(){
    	$rs=array('code'=>0,'msg'=>\PhalApi\T('订单提交成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $addressid=\App\checkNull($this->addressid);
        $goodsid=\App\checkNull($this->goodsid);
        $spec_id=\App\checkNull($this->spec_id);
        $nums=\App\checkNull($this->nums);
        $message=\App\checkNull($this->message);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        $liveuid=\App\checkNull($this->liveuid);
        $shareuid=\App\checkNull($this->shareuid);

        $data=array(
        	'uid'=>$uid,
        	'token'=>$token,
        	'addressid'=>$addressid,
        	'goodsid'=>$goodsid,
        	'spec_id'=>$spec_id,
        	'nums'=>$nums,
            'message'=>$message,
        	'time'=>$time,
        	'sign'=>$sign,
            'liveuid'=>$liveuid,
            'shareuid'=>$shareuid
        );

        $res=$this->createGoodsOrderTest($data);
 
        if($res['code']!=0){
        	return $res;
        }

        $order_data=$res['info'];

        $orderno=$this->getOrderno($uid,$goodsid); //获取订单号

        $order_data['orderno']=$orderno;

        //获取店铺信息
        $domain_shop=new Domain_Shop();
        $shopApplyInfo=$domain_shop->getShopApplyInfo($order_data['shop_uid']);

        $order_data['order_percent']=$shopApplyInfo['apply_info']['order_percent'];

        $domain=new Domain_Buyer();
        $res=$domain->createGoodsOrder($order_data);
        if(!$res){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单生成失败');
			return $rs;
        }

        //减少商品规格库存量
        \App\changeShopGoodsSpecNum($order_data['goodsid'],$order_data['spec_id'],$order_data['nums'],0);

        $rs['info'][0]['orderid']=$res['id'];
		return $rs;

    }
	
	/**
	 * 买家提交商品订单(购物车商品使用)
	 * @desc 用于 买家提交商品订单(购物车商品使用)
	 * @return array|int
	 * @return array info
	 * @return array info[0].orderid 商品订单ID
	 * @return string msg 提示信息
	 */
	public function createGoodsOrderCart(){
		$rs=array('code'=>0,'msg'=>\PhalApi\T('订单提交成功'),'info'=>array());
		
		$uid=\App\checkNull($this->uid);

		$token=\App\checkNull($this->token);
		$addressid=\App\checkNull($this->addressid);
		$goodsuid=\App\checkNull($this->goodsuid);
		$cartsid=\App\checkNull($this->cartsid);
		$message=\App\checkNull($this->message);
		$time=\App\checkNull($this->time);
		$sign=\App\checkNull($this->sign);
		
		$data=array(
			'uid'=>$uid,
			'token'=>$token,
			'addressid'=>$addressid,
			'goodsuid'=>$goodsuid,
			'cartsid'=>$cartsid,
			'message'=>$message,
			'time'=>$time,
			'sign'=>$sign,
			'liveuid'=>0,
			'shareuid'=>0
		);
		
		$res=$this->createGoodsOrderTestCart($data);

		if($res['code']!=0){
			return $res;
		}
		$order_data=$res['info'];
		$rs=[];
		$many = '';
		$order_ids = [];
		foreach ($order_data as $order_datum){
			$goodsid = $order_datum['goodsid'];
			$orderno=$this->getOrderno($uid,$goodsid); //获取订单号
			$order_datum['orderno']=$orderno;
			//获取店铺信息
			$domain_shop=new Domain_Shop();
			$shopApplyInfo=$domain_shop->getShopApplyInfo($order_datum['shop_uid']);
			
			$order_datum['order_percent']=$shopApplyInfo['apply_info']['order_percent'];
			
			$domain=new Domain_Buyer();
			$res=$domain->createGoodsOrder($order_datum);
			if(!$res){
				$rs['code']=1001;
				$rs['msg']=\PhalApi\T('订单生成失败');
				return $rs;
			}
			
			//减少商品规格库存量
			\App\changeShopGoodsSpecNum($order_datum['goodsid'],$order_datum['spec_id'],$order_datum['nums'],0);
     		$rs['info'][]['orderid']=$res['id'];
			$order_ids[] = $res['id'];
			$many .= $orderno .'+';
		}
		$many = rtrim($many, '+');
		foreach ($order_ids as $order_id){
			\PhalApi\DI()->notorm->shop_order
				->where("id = '{$order_id}'")
				->update(
					array(
						'many'=>$many
					)
				);
		}
		$cartsid= explode(',', $cartsid);
		foreach ($cartsid as $cartid){
			\PhalApi\DI()->notorm->shop_cart
				->where('cartid=?',$cartid)
				->delete();
		}
		return $rs;
		
	}

    /**
     * 买家获取余额和支付信息
     * @desc 用于 买家获取余额和支付信息
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string info[0].balance 用户商城人民币余额
	 * @return string info[0].aliapp_partner 支付宝合作者身份ID
	 * @return string info[0].aliapp_seller_id 支付宝帐号
	 * @return string info[0].aliapp_key_android 支付宝安卓密钥
	 * @return string info[0].aliapp_key_ios 支付宝苹果密钥
	 * @return string info[0].wx_appid 开放平台账号AppID
	 * @return string info[0].wx_appsecret 微信应用appsecret
	 * @return string info[0].wx_mchid 微信商户号mchid
	 * @return string info[0].wx_key 微信密钥key
	 * @return string info[0].paylist 支付方式列表
	 * @return string info[0].paylist[].id 支付方式列表项ID
	 * @return string info[0].paylist[].name 支付方式列表项名称
	 * @return string info[0].paylist[].thumb 支付方式列表项图标
	 * @return string info[0].paylist[].href 支付方式列表项链接
     * @return string msg 提示信息
     */

    public function getBalance(){
    	$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==''||!$time||!$sign){
        	$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('参数错误');
        	return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

        $now=time();
        if($now-$time>300){
        	$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('参数错误');
        	return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );
        
        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

		$info=\App\getUserShopBalance($uid);
		$info['balance']=$info['balance'];
		unset($info['balance_total']);

		$configpri=\App\getConfigPri();

		$shop_aliapp_switch=$configpri['shop_aliapp_switch'];
		$shop_wx_switch=$configpri['shop_wx_switch'];

		$info['aliapp_partner']=$shop_aliapp_switch==1?$configpri['aliapp_partner']:'';
		$info['aliapp_seller_id']=$shop_aliapp_switch==1?$configpri['aliapp_seller_id']:'';
		$info['aliapp_key_android']=$shop_aliapp_switch==1?$configpri['aliapp_key_android']:'';
		$info['aliapp_key_ios']=$shop_aliapp_switch==1?$configpri['aliapp_key_ios']:'';

		$info['wx_appid']=$shop_wx_switch==1?$configpri['wx_appid']:'';
		$info['wx_appsecret']=$shop_wx_switch==1?$configpri['wx_appsecret']:'';
		$info['wx_mchid']=$shop_wx_switch==1?$configpri['wx_mchid']:'';
		$info['wx_key']=$shop_wx_switch==1?$configpri['wx_key']:'';

		$shop_balance_switch=$configpri['shop_balance_switch'];

        //店铺微信小程序微信支付开关
        $shop_wxmini_switch=$configpri['shop_wxmini_switch'];
        $info['shop_wxmini_switch']=$shop_wxmini_switch;

        //店铺余额支付微信小程序开关
        $shop_wxmini_balance_switch=$configpri['shop_wxmini_balance_switch'];
        $info['shop_wxmini_balance_switch']=$shop_wxmini_balance_switch;

        //店铺Paypal支付开关【原PayPal支付因无法使用已废弃但保留】
        //$shop_paypal_switch=$configpri['shop_paypal_switch'];

        $shop_braintree_paypal_switch=$configpri['shop_braintree_paypal_switch'];

		$paylist=[];

		if($shop_aliapp_switch){
            $paylist[]=[
                'id'=>'ali',
                'name'=>\PhalApi\T('支付宝支付'),
                'thumb'=>\App\get_upload_path("/static/app/shoppay/ali.png"),
                'href'=>'',
                'type'=>'1' //对应创建订单接口里的type
            ];
        }

        if($shop_wx_switch){
            $paylist[]=[
                'id'=>'wx',
                'name'=>\PhalApi\T('微信支付'),
                'thumb'=>\App\get_upload_path("/static/app/shoppay/wx.png"),
                'href'=>'',
                'type'=>'2'
            ];
        }

        /*if($shop_paypal_switch){ //【原PayPal支付因无法使用已废弃但保留】
            $paylist[]=[
                'id'=>'paypal',
                'name'=>\PhalApi\T('Paypal支付'),
                'thumb'=>get_upload_path("/static/app/shoppay/paypal.png"),
                'href'=>'',
                'type'=>'5'
            ];
        }*/

        if($shop_braintree_paypal_switch){
            $paylist[]=[
                'id'=>'paypal',
                'name'=>\PhalApi\T('Paypal支付'),
                'thumb'=>\App\get_upload_path("/static/app/shoppay/paypal.png"),
                'href'=>'',
                'type'=>'6'
            ];
        }

        if($shop_balance_switch){
            $paylist[]=[
                'id'=>'balance',
                'name'=>\PhalApi\T('余额支付'),
                'thumb'=>\App\get_upload_path("/static/app/shoppay/balance.png"),
                'href'=>'',
                'type'=>'3'
            ];
        }//type：4是给微信小程序预留的

        

        $info['paylist'] =$paylist;

        $rs['info'][0]=$info;
		return $rs;

    }


    /**
     * 买家订单付款
     * @desc 用于 买家订单付款
     * @return int code 操作码，0表示成功
     * @return array info
     * @return array info[0].orderid 商品订单ID
     * @return string msg 提示信息
     */
    public function goodsOrderPay(){

    	$rs=array('code'=>0,'msg'=>\PhalApi\T('订单等待支付'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $type=\App\checkNull($this->type);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        $appid=\App\checkNull($this->appid);
	    $openid = '';
        if($uid<0||$token==""||$orderid<1||!in_array($type, ['1','2','3','4','5','6'])||$time<0||!$sign){
        	$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('参数错误1');
        	return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$now=time();
		if($now-$time>300){
			$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('参数错误2');
        	return $rs;
		}
		$checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'type'=>$type,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误3');
            return $rs;
        }
		
		//获取订单详情
		$where=array(
			'id'=>$orderid,
			'uid'=>$uid
		
		);
	
		$order_info=\App\getShopOrderInfo($where);
		
		if(!$order_info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单不存在');
			return $rs;
		}
		$order_status=$order_info['status'];
		if($order_status==-1){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单已关闭');
			return $rs;
		}
		
		if($order_status>0){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单已支付');
			return $rs;
		}
		
		$configpub = \App\getConfigPub();
		$configpri=\App\getConfigPri();
		switch($type){

			case '1': //支付宝
                if(!$configpri['aliapp_partner']||!$configpri['aliapp_seller_id']||!$configpri['aliapp_key_android']||!$configpri['aliapp_key_ios']){
                    $rs['code']=1001;
                    $rs['msg']=\PhalApi\T('支付宝未配置');
                    return $rs;
                }
				
				$data = [
					'app_id' => $appid,
					'biz_content' => json_encode([
						'timeout_express' => '30m',
						'product_code' => 'QUICK_MSECURITY_PAY',
						'total_amount' => $order_info['total'],
				// 		'total_amount' => 0.01,
						'subject' => '1',
						'body' => $order_info['goods_name'],
						'out_trade_no' => $order_info['orderno'],
					], JSON_UNESCAPED_UNICODE),
					'charset' => 'utf-8',
					'format' => 'json',
					'method' => 'alipay.trade.app.pay',
					'notify_url' => 'https://doukang.wummm.top/appapi/pay/notify_ali',
					'sign_type' => 'RSA2',
					'timestamp' => date('Y-m-d H:i:s'),
					'version' => '1.0'
				];
				
				// 2. 生成待签名字符串
				$unsignedString = $this->createUnsignedString($data);
				
				// 3. 生成签名
			    if ($appid == '2021004161696900'){
				    $sign = $this->generateRSA2Signature($unsignedString,__DIR__.'/pem/private_key_android.pem');
			    }elseif($appid == '2021004163699277'){
				    $sign = $this->generateRSA2Signature($unsignedString,__DIR__.'/pem/private_key_ios.pem');
			    }else{
				    $rs['code']=1001;
				    $rs['msg']=\PhalApi\T('支付宝秘钥不匹配');
				    return $rs;
			    }
				
				
				// 4. 将签名加入参数数组
				$data['sign'] = $sign;
				
				// 5. 对所有一级 value 进行 URL 编码
				$encodedData = array_map('urlencode', $data);
				
				$finalRequestString = urldecode(http_build_query($encodedData));
				
				$rs['info'][0]['orderid']=$order_info['orderno'];
				$rs['info'][0]['string']=$finalRequestString;
				break;

			case '2': //微信
				if($configpri['wx_appid']== "" || $configpri['wx_mchid']== "" || $configpri['wx_key']== ""){
					$rs['code'] = 1002;
					$rs['msg'] = \PhalApi\T('微信未配置');
					return $rs;
				}

				$now = time();
		        $noceStr = md5(rand(100,1000).$now);//获取随机字符串

				$paramarr = array(
					"appid"       =>   $configpri['wx_appid'],
					"body"        =>    \PhalApi\T("支付").$order_info['total'].\PhalApi\T("购买").\App\filterEmoji($order_info['goods_name']),
					"mch_id"      =>    $configpri['wx_mchid'],
					"nonce_str"   =>    $noceStr,
					"notify_url"  =>    $configpub['site'].'/appapi/Shoppay/notify_wx',
					"out_trade_no"=>    $order_info['orderno'],
					"total_fee"   =>    $order_info['total']*100,
					"trade_type"  =>    "APP"
				);

				$sign = $this -> sign($paramarr,$configpri['wx_key']);//生成签名
				$paramarr['sign'] = $sign;
				$paramXml = "<xml>";
				foreach($paramarr as $k => $v){
					$paramXml .= "<" . $k . ">" . $v . "</" . $k . ">";
				}
				$paramXml .= "</xml>";

				$ch = curl_init ();
				@curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
				@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
				@curl_setopt($ch, CURLOPT_URL, "https://api.mch.weixin.qq.com/pay/unifiedorder");
				@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				@curl_setopt($ch, CURLOPT_POST, 1);
				@curl_setopt($ch, CURLOPT_POSTFIELDS, $paramXml);
				@$resultXmlStr = curl_exec($ch);

				if(curl_errno($ch)){
					//print curl_error($ch);
					file_put_contents(API_ROOT.'/../log/phalapi/buyer_wxpay_'.date('Y-m-d').'.txt',date('y-m-d H:i:s').' 提交参数信息 ch:'.json_encode(curl_error($ch))."\r\n\r\n",FILE_APPEND);
				}
				curl_close($ch);

				$result2 = $this->xmlToArray($resultXmlStr);

		        if($result2['return_code']=='FAIL'){
		            $rs['code']=1003;
					$rs['msg']=$result2['return_msg'];
		            return $rs;
		        }

		        $prepayid = $result2['prepay_id'];
				$sign = "";
				$noceStr = md5(rand(100,1000).$now);//获取随机字符串
				$paramarr2 = array(
					"appid"     =>  $configpri['wx_appid'],
					"noncestr"  =>  $noceStr,
					"package"   =>  "Sign=WXPay",
					"partnerid" =>  $configpri['wx_mchid'],
					"prepayid"  =>  $prepayid,
					"timestamp" =>  $now
				);

				$paramarr2["sign"] = $this -> sign($paramarr2,$configpri['wx_key']);//生成签名

				$rs['info'][0]=$paramarr2;

		        break;

			case '3': //余额

				//获取用户的余额
				$userBalance=\App\getUserShopBalance($uid);
				$balance=$userBalance['balance'];

				if($balance<$order_info['total']){ //余额不足
					$rs['code']=1001;
					$rs['msg']=\PhalApi\T('您的余额不足');
					return $rs;
				}

				$domain=new Domain_Buyer();
				$res=$domain->goodsBalancePay($uid,$orderid);

				if(!$res){
					$rs['code']=1001;
					$rs['msg']=\PhalApi\T('使用余额支付订单失败');
					return $rs;
				}

                //写入余额操作记录
                $balance_record=array(
                    'uid'=>$uid,
                    'touid'=>$order_info['shop_uid'],
                    'balance'=>$order_info['total'],
                    'type'=>0, //支出
                    'action'=>1, // 1 买家使用余额付款
                    'orderid'=>$orderid,
                    'addtime'=>$now

                );

                \App\addBalanceRecord($balance_record);

				$rs['msg']=\PhalApi\T('订单余额支付成功');

				break;


            case '4'://微信小程序
                if(!$openid){
                    $rs['code'] = 1002;
                    $rs['msg'] = \PhalApi\T('缺少必要参数openid');
                    return $rs;
                }
                if($configpri['wx_mini_appid']== "" || $configpri['wx_mini_mchid']== "" || $configpri['wx_mini_key']== ""){
                    $rs['code'] = 1002;
                    $rs['msg'] = \PhalApi\T('微信小程序支付未配置');
                    return $rs;
                }

                $time = time();
                $noceStr = md5(rand(100,1000).$time);//获取随机字符串
                $paramarr = array(
                    "appid"       =>   $configpri['wx_mini_appid'],
                    "body"        =>    \PhalApi\T("支付").$order_info['total'].\PhalApi\T("购买").$order_info['goods_name'],
                    "mch_id"      =>    $configpri['wx_mini_mchid'],
                    "nonce_str"   =>    $noceStr,
                    "notify_url"  =>    $configpub['site'].'/appapi/Shoppay/notify_wx_mini',
                    "openid"      =>    $openid,
                    "out_trade_no"=>    $order_info['orderno'],
                    "spbill_create_ip"   =>$_SERVER["REMOTE_ADDR"],
                    "total_fee"   =>    $order_info['total']*100,
                    "trade_type"  =>    "JSAPI"
                );

                $sign = $this -> sign($paramarr,$configpri['wx_mini_key']);//生成签名
                $paramarr['sign'] = $sign;


                $paramXml = "<xml>";
                foreach($paramarr as $k => $v){
                    $paramXml .= "<" . $k . ">" . $v . "</" . $k . ">";
                }
                $paramXml .= "</xml>";

                $ch = curl_init ();
                @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
                @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
                @curl_setopt($ch, CURLOPT_URL, "https://api.mch.weixin.qq.com/pay/unifiedorder");
                @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                @curl_setopt($ch, CURLOPT_POST, 1);
                @curl_setopt($ch, CURLOPT_POSTFIELDS, $paramXml);
                @$resultXmlStr = curl_exec($ch);
                if(curl_errno($ch)){
                    //print curl_error($ch);
                    file_put_contents(API_ROOT.'/../log/phalapi/buyer_wxmini_pay_'.date('Y-m-d').'.txt',date('y-m-d H:i:s').' 提交参数信息 ch:'.json_encode(curl_error($ch))."\r\n\r\n",FILE_APPEND);
                }
                curl_close($ch);

                $result2 = $this->xmlToArray($resultXmlStr);
                /*var_dump($result2);
                die;*/

                if($result2['return_code']=='FAIL'){
                    $rs['code']=1005;
                    $rs['msg']=$result2['return_msg'];
                    return $rs;
                }

                $time2 = time();
                $prepayid = $result2['prepay_id'];
                $sign = "";
                $noceStr = md5(rand(100,1000).time());//获取随机字符串

                //注意参数大小写
                $paramarr2 = array(

                    "appId"     =>  $configpri['wx_mini_appid'],
                    "timeStamp" =>  $time2,
                    "nonceStr"  =>  $noceStr,
                    "package"   =>  "prepay_id=".$prepayid,
                    "signType" =>  "MD5"

                );

                $paramarr2["sign"] = $this -> sign($paramarr2,$configpri['wx_mini_key']);//生成签名

                $rs['info'][0]=$paramarr2;

                break;

            case '5':
                if($configpri['paypal_sandbox']==0){
                    if(!$configpri['sandbox_clientid']){
                        $rs['code']=1001;
                        $rs['msg']=\PhalApi\T('Paypal未配置');
                        return $rs;
                    }
                }else{
                    if(!$configpri['product_clientid']){
                        $rs['code']=1001;
                        $rs['msg']=\PhalApi\T('Paypal未配置');
                        return $rs;
                    }
                }

                $paypal=[
                    'paypal_sandbox'=>$configpri['paypal_sandbox'],//支付模式：0：沙盒支付；1：生产支付
                    'sandbox_clientid'=>$configpri['sandbox_clientid'],//沙盒客户端ID
                    'product_clientid'=>$configpri['product_clientid'],//生产客户端ID
                ];
                $rs['info'][0]=$paypal;
                $rs['info'][0]['orderid']=$order_info['orderno'];
                $rs['info'][0]['goods_name']=\App\filterEmoji($order_info['goods_name']);
                break;
            case '6':
                $environment=$configpri['braintree_paypal_environment'];

                $merchantId='';
                $publicKey='';
                $privateKey='';

                if($environment==0){ //沙盒
                    $merchantId=$configpri['braintree_merchantid_sandbox'];
                    $publicKey=$configpri['braintree_publickey_sandbox'];
                    $privateKey=$configpri['braintree_privatekey_sandbox'];
                    $environment='sandbox';

                }else{ //生产

                    $merchantId=$configpri['braintree_merchantid_product'];
                    $publicKey=$configpri['braintree_publickey_product'];
                    $privateKey=$configpri['braintree_privatekey_product'];
                    $environment='production';

                }

                if(!$merchantId || !$publicKey || !$privateKey){
                    $rs['code']=1001;
                    $rs['msg']=\PhalApi\T('BraintreePaypal未配置');
                    return $rs;
                }

                $rs['info'][0]['orderid']=$order_info['orderno'];

                break;

		}
	 
	    $domain=new Domain_Buyer();
	    $domain->increaseSold($orderid);
	    
		return $rs;


    }
	
	/**
	 * 买家订单付款(new)
	 * @desc 用于 买家订单付款
	 * @return array|int
	 * @return array info
	 * @return array info[0].orderid 商品订单ID
	 * @return string msg 提示信息
	 */
	public function goodsOrderPayNew()
	{
		
		$rs = array('code' => 0, 'msg' => \PhalApi\T('订单等待支付'), 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token = \App\checkNull($this->token);
		$orderid = \App\checkNull($this->orderid);
		$type = \App\checkNull($this->type);
		$time = \App\checkNull($this->time);
		$sign = \App\checkNull($this->sign);
		$appid = \App\checkNull($this->appid);
		$openid = '';
		if ($uid < 0 || $token == '' || $orderid < 1 || !in_array($type, ['1', '2', '3', '4', '5', '6']) || $time < 0 || !$sign) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('参数错误1');
			return $rs;
		}
		
		$checkToken = \App\checkToken($uid, $token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$now = time();
		if($now-$time>300){
			$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('参数错误2');
        	return $rs;
		}
		$checkdata = array(
			'uid' => $uid,
			'token' => $token,
			'orderid' => $orderid,
			'type' => $type,
			'time' => $time
		);
		
		$issign = \App\checkSign($checkdata, $sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误3');
            return $rs;
        }
		
		$orderids = explode(',', $orderid);
		
		$total = 0;
		foreach ($orderids as $orderidOne) {
			//获取订单详情
			$where = array(
				'id' => $orderidOne,
				'uid' => $uid
			
			);
			
			$order_info = \App\getShopOrderInfo($where);
			
			if (!$order_info) {
				$rs['code'] = 1001;
				$rs['msg'] = \PhalApi\T($orderidOne . '订单不存在');
				return $rs;
			}
			$order_status = $order_info['status'];
			if($order_status==-1){
				$rs['code']=1001;
				$rs['msg']=\PhalApi\T($orderidOne . '订单已关闭');
				return $rs;
			}
			
			if ($order_status > 0) {
				$rs['code'] = 1001;
				$rs['msg'] = \PhalApi\T($orderidOne . '订单已支付');
				return $rs;
			}
			
			$total += $order_info['total'];
			$good_name .= $order_info['goods_name'] . '+';
			$orderno = $order_info['orderno'];
		}
		$good_name = rtrim($good_name, '+');
		
		$configpub = \App\getConfigPub();
		$configpri = \App\getConfigPri();
		switch ($type) {
			
			case '1': //支付宝
				if (!$configpri['aliapp_partner'] || !$configpri['aliapp_seller_id'] || !$configpri['aliapp_key_android'] || !$configpri['aliapp_key_ios']) {
					$rs['code'] = 1001;
					$rs['msg'] = \PhalApi\T('支付宝未配置');
					return $rs;
				}
				
				$data = [
					'app_id' => $appid,
					'biz_content' => json_encode([
						'timeout_express' => '30m',
						'product_code' => 'QUICK_MSECURITY_PAY',
						'total_amount' => $total,
//						'total_amount' => 0.01,
						'subject' => '1',
						'body' => $good_name,
						'out_trade_no' => $orderno,
					], JSON_UNESCAPED_UNICODE),
					'charset' => 'utf-8',
					'format' => 'json',
					'method' => 'alipay.trade.app.pay',
					'notify_url' => 'https://doukang.wummm.top/appapi/pay/notify_ali',
					'sign_type' => 'RSA2',
					'timestamp' => date('Y-m-d H:i:s'),
					'version' => '1.0'
				];
				
				// 2. 生成待签名字符串
				$unsignedString = $this->createUnsignedString($data);
				
				// 3. 生成签名
				if ($appid == '2021004161696900') {
					$sign = $this->generateRSA2Signature($unsignedString, __DIR__ . '/pem/private_key_android.pem');
				} elseif ($appid == '2021004163699277') {
					$sign = $this->generateRSA2Signature($unsignedString, __DIR__ . '/pem/private_key_ios.pem');
				} else {
					$rs['code'] = 1001;
					$rs['msg'] = \PhalApi\T('支付宝秘钥不匹配');
					return $rs;
				}
				
				
				// 4. 将签名加入参数数组
				$data['sign'] = $sign;
				
				// 5. 对所有一级 value 进行 URL 编码
				$encodedData = array_map('urlencode', $data);
				
				$finalRequestString = urldecode(http_build_query($encodedData));
				
				$rs['info'][0]['orderid'] = $order_info['orderno'];
				$rs['info'][0]['string'] = $finalRequestString;
				break;
			
			case '2': //微信
				if ($configpri['wx_appid'] == '' || $configpri['wx_mchid'] == '' || $configpri['wx_key'] == '') {
					$rs['code'] = 1002;
					$rs['msg'] = \PhalApi\T('微信未配置');
					return $rs;
				}
				
				$now = time();
				$noceStr = md5(rand(100, 1000) . $now);//获取随机字符串
				
				$paramarr = array(
					'appid' => $configpri['wx_appid'],
					'body' => \PhalApi\T('支付') . $total . \PhalApi\T('购买') . \App\filterEmoji($good_name),
					'mch_id' => $configpri['wx_mchid'],
					'nonce_str' => $noceStr,
					'notify_url' => $configpub['site'] . '/appapi/Shoppay/notify_wx',
					'out_trade_no' => $orderno,
					'total_fee' => $total * 100,
					'trade_type' => 'APP'
				);
				
				$sign = $this->sign($paramarr, $configpri['wx_key']);//生成签名
				$paramarr['sign'] = $sign;
				$paramXml = '<xml>';
				foreach ($paramarr as $k => $v) {
					$paramXml .= '<' . $k . '>' . $v . '</' . $k . '>';
				}
				$paramXml .= '</xml>';
				
				$ch = curl_init();
				@curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
				@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
				@curl_setopt($ch, CURLOPT_URL, 'https://api.mch.weixin.qq.com/pay/unifiedorder');
				@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				@curl_setopt($ch, CURLOPT_POST, 1);
				@curl_setopt($ch, CURLOPT_POSTFIELDS, $paramXml);
				@$resultXmlStr = curl_exec($ch);
				
				if (curl_errno($ch)) {
					//print curl_error($ch);
					file_put_contents(API_ROOT . '/../log/phalapi/buyer_wxpay_' . date('Y-m-d') . '.txt', date('y-m-d H:i:s') . ' 提交参数信息 ch:' . json_encode(curl_error($ch)) . "\r\n\r\n", FILE_APPEND);
				}
				curl_close($ch);
				
				$result2 = $this->xmlToArray($resultXmlStr);
				
				if ($result2['return_code'] == 'FAIL') {
					$rs['code'] = 1003;
					$rs['msg'] = $result2['return_msg'];
					return $rs;
				}
				
				$prepayid = $result2['prepay_id'];
				$sign = '';
				$noceStr = md5(rand(100, 1000) . $now);//获取随机字符串
				$paramarr2 = array(
					'appid' => $configpri['wx_appid'],
					'noncestr' => $noceStr,
					'package' => 'Sign=WXPay',
					'partnerid' => $configpri['wx_mchid'],
					'prepayid' => $prepayid,
					'timestamp' => $now
				);
				
				$paramarr2['sign'] = $this->sign($paramarr2, $configpri['wx_key']);//生成签名
				
				$rs['info'][0] = $paramarr2;
				
				break;
			
			case '3': //余额
				
				//获取用户的余额
				$userBalance = \App\getUserShopBalance($uid);
				$balance = $userBalance['balance'];
				
				if ($balance < $total) { //余额不足
					$rs['code'] = 1001;
					$rs['msg'] = \PhalApi\T('您的余额不足');
					return $rs;
				}
				
				foreach ($orderids as $orderid){
					$domain = new Domain_Buyer();
					$res = $domain->goodsBalancePay($uid, $orderid);
					if (!$res) {
						$rs['code'] = 1001;
						$rs['msg'] = \PhalApi\T('使用余额支付订单失败');
						return $rs;
					}
					//写入余额操作记录
					$balance_record = array(
						'uid' => $uid,
						'touid' => $order_info['shop_uid'],
						'balance' => $order_info['total'],
						'type' => 0, //支出
						'action' => 1, // 1 买家使用余额付款
						'orderid' => $orderid,
						'addtime' => $now
					
					);
					
					\App\addBalanceRecord($balance_record);
				}
				
				$rs['msg'] = \PhalApi\T('订单余额支付成功');
				
				break;
			
			
			case '4'://微信小程序
				if (!$openid) {
					$rs['code'] = 1002;
					$rs['msg'] = \PhalApi\T('缺少必要参数openid');
					return $rs;
				}
				if ($configpri['wx_mini_appid'] == '' || $configpri['wx_mini_mchid'] == '' || $configpri['wx_mini_key'] == '') {
					$rs['code'] = 1002;
					$rs['msg'] = \PhalApi\T('微信小程序支付未配置');
					return $rs;
				}
				
				$time = time();
				$noceStr = md5(rand(100, 1000) . $time);//获取随机字符串
				$paramarr = array(
					'appid' => $configpri['wx_mini_appid'],
					'body' => \PhalApi\T('支付') . $total . \PhalApi\T('购买') . $good_name,
					'mch_id' => $configpri['wx_mini_mchid'],
					'nonce_str' => $noceStr,
					'notify_url' => $configpub['site'] . '/appapi/Shoppay/notify_wx_mini',
					'openid' => $openid,
					'out_trade_no' => $orderno,
					'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
					'total_fee' => $total * 100,
					'trade_type' => 'JSAPI'
				);
				
				$sign = $this->sign($paramarr, $configpri['wx_mini_key']);//生成签名
				$paramarr['sign'] = $sign;
				
				
				$paramXml = '<xml>';
				foreach ($paramarr as $k => $v) {
					$paramXml .= '<' . $k . '>' . $v . '</' . $k . '>';
				}
				$paramXml .= '</xml>';
				
				$ch = curl_init();
				@curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
				@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
				@curl_setopt($ch, CURLOPT_URL, 'https://api.mch.weixin.qq.com/pay/unifiedorder');
				@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				@curl_setopt($ch, CURLOPT_POST, 1);
				@curl_setopt($ch, CURLOPT_POSTFIELDS, $paramXml);
				@$resultXmlStr = curl_exec($ch);
				if (curl_errno($ch)) {
					//print curl_error($ch);
					file_put_contents(API_ROOT . '/../log/phalapi/buyer_wxmini_pay_' . date('Y-m-d') . '.txt', date('y-m-d H:i:s') . ' 提交参数信息 ch:' . json_encode(curl_error($ch)) . "\r\n\r\n", FILE_APPEND);
				}
				curl_close($ch);
				
				$result2 = $this->xmlToArray($resultXmlStr);
				/*var_dump($result2);
				die;*/
				
				if ($result2['return_code'] == 'FAIL') {
					$rs['code'] = 1005;
					$rs['msg'] = $result2['return_msg'];
					return $rs;
				}
				
				$time2 = time();
				$prepayid = $result2['prepay_id'];
				$sign = '';
				$noceStr = md5(rand(100, 1000) . time());//获取随机字符串
				
				//注意参数大小写
				$paramarr2 = array(
					
					'appId' => $configpri['wx_mini_appid'],
					'timeStamp' => $time2,
					'nonceStr' => $noceStr,
					'package' => 'prepay_id=' . $prepayid,
					'signType' => 'MD5'
				
				);
				
				$paramarr2['sign'] = $this->sign($paramarr2, $configpri['wx_mini_key']);//生成签名
				
				$rs['info'][0] = $paramarr2;
				
				break;
			
			case '5':
				if ($configpri['paypal_sandbox'] == 0) {
					if (!$configpri['sandbox_clientid']) {
						$rs['code'] = 1001;
						$rs['msg'] = \PhalApi\T('Paypal未配置');
						return $rs;
					}
				} else {
					if (!$configpri['product_clientid']) {
						$rs['code'] = 1001;
						$rs['msg'] = \PhalApi\T('Paypal未配置');
						return $rs;
					}
				}
				
				$paypal = [
					'paypal_sandbox' => $configpri['paypal_sandbox'],//支付模式：0：沙盒支付；1：生产支付
					'sandbox_clientid' => $configpri['sandbox_clientid'],//沙盒客户端ID
					'product_clientid' => $configpri['product_clientid'],//生产客户端ID
				];
				$rs['info'][0] = $paypal;
				$rs['info'][0]['orderid'] = $orderno;
				$rs['info'][0]['goods_name'] = \App\filterEmoji($good_name);
				break;
			case '6':
				$environment = $configpri['braintree_paypal_environment'];
				
				$merchantId = '';
				$publicKey = '';
				$privateKey = '';
				
				if ($environment == 0) { //沙盒
					$merchantId = $configpri['braintree_merchantid_sandbox'];
					$publicKey = $configpri['braintree_publickey_sandbox'];
					$privateKey = $configpri['braintree_privatekey_sandbox'];
					$environment = 'sandbox';
					
				} else { //生产
					
					$merchantId = $configpri['braintree_merchantid_product'];
					$publicKey = $configpri['braintree_publickey_product'];
					$privateKey = $configpri['braintree_privatekey_product'];
					$environment = 'production';
					
				}
				
				if (!$merchantId || !$publicKey || !$privateKey) {
					$rs['code'] = 1001;
					$rs['msg'] = \PhalApi\T('BraintreePaypal未配置');
					return $rs;
				}
				
				$rs['info'][0]['orderid'] = $order_info['orderno'];
				
				break;
			
		}
		
		foreach ($orderids as $orderid){
			$domain = new Domain_Buyer();
			$domain->increaseSold($orderid);
		}
		
		return $rs;
		
		
	}
	

    /**
     * 买家创建订单时的检测
     * @desc 用于 买家创建订单时的检测
     * @return array info 返回订单信息
     */
    protected function createGoodsOrderTest($data){
    	$rs=array('code'=>0,'msg'=>'','info'=>array());

    	$uid=$data['uid'];
    	$token=$data['token'];
    	$addressid=$data['addressid'];
    	$goodsid=$data['goodsid'];
    	$spec_id=$data['spec_id'];
    	$nums=$data['nums'];
        $message=$data['message'];
    	$time=$data['time'];
    	$sign=$data['sign'];
        $liveuid=$data['liveuid'];
        $shareuid=$data['shareuid'];


    	if($uid<0||$token==''||$addressid<0||$goodsid<0||$spec_id<1||$nums<1||!$time||!$sign){
        	$rs['code']=10011;
        	$rs['msg']=\PhalApi\T('参数错误');
        	return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
        	$rs['code']=10012;
        	$rs['msg']=\PhalApi\T('参数错误');
        	return $rs;
        }

        $checkdata=array(
        	'uid'=>$uid,
        	'addressid'=>$addressid,
        	'goodsid'=>$goodsid,
        	'spec_id'=>$spec_id,
        	'time'=>$time

        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $address_info=$domain->getAddress($uid,$addressid);

        if(!$address_info){
        	$rs['code']=1001;
            $rs['msg']=\PhalApi\T('收货地址不存在');
            return $rs;
        }

        $domain_shop=new Domain_Shop();
        $where['id']=$goodsid;
        $goods_info=$domain_shop->getGoods($where);
        if(!$goods_info){
        	$rs['code'] = 1003;
            $rs['msg'] = \PhalApi\T('商品不存在');
            return $rs;
        }

        if($goods_info['uid']==$uid){
        	$rs['code'] = 1003;
            $rs['msg'] = \PhalApi\T('不能购买自己的商品');
            return $rs;
        }

        $goods_status=$goods_info['status'];


        if($goods_status==-2){
            $rs['code'] = 1004;
            $rs['msg'] = \PhalApi\T('该商品已下架');
            return $rs;
        }
        
        if($goods_status==-1){
            $rs['code'] = 1005;
            $rs['msg'] = \PhalApi\T('该商品已下架');
            return $rs;
        }

        if($goods_status!=1){
            $rs['code'] = 1006;
            $rs['msg'] = \PhalApi\T('商品未通过审核');
            return $rs;
        }

        $spec_arr=json_decode($goods_info['specs'],true);

        $spec_info=[];

        foreach ($spec_arr as $k => $v) {
        	if($v['spec_id']==$spec_id){
        		$spec_info=$v;
        		break;
        	}
        }

        if(empty($spec_info)){
        	$rs['code'] = 1007;
            $rs['msg'] = \PhalApi\T('没有对应的商品规格');
            return $rs;
        }

        if($spec_info['spec_num']<$nums){
        	$rs['code'] = 1007;
            $rs['msg'] = \PhalApi\T('商品库存不足');
            return $rs;
        }

        if($message){
            if(mb_strlen($message)>100){
               $rs['code'] = 1007;
                $rs['msg'] = \PhalApi\T('留言内容在100字以内');
                return $rs;
            }
        }

        //如果是主播代售平台商品的话，检验主播是否代售了
        if($liveuid>1&&$goods_info['uid']==1){
            //判断主播是否存在
            $where=[];
            $where['id']=$liveuid;
            $where['user_type']=2;
            $anchor_isexist=\App\checkUser($where);
            if(!$anchor_isexist){
                $rs['code'] = 1008;
                $rs['msg'] = \PhalApi\T('主播不存在');
                return $rs;
            }

            //判断主播是否代售了该商品
            $where1=[];
            $where1['uid']=$liveuid;
            $where1['goodsid']=$goodsid;
            $where1['status']=1;
            $is_sale=\App\checkUserSalePlatformGoods($where1);
            if(!$is_sale){
                $rs['code'] = 1009;
                $rs['msg'] = \PhalApi\T('主播未代售该商品');
                return $rs;
            }
        }

        if($uid==$shareuid){
            $shareuid=0;
        }

        if($shareuid>0){

            //检测分享用户是否存在
            $where=[];
            $where['id']=$shareuid;
            $where['user_type']=2;
            $anchor_isexist=\App\checkUser($where);
            if(!$anchor_isexist){
                $rs['code'] = 1008;
                $rs['msg'] = \PhalApi\T('分享商品用户不存在');
                return $rs;
            }

        }else{
            $goods_info['share_income']=0;
        }
        

        $price=$spec_info['price'];

        $total=$price*$nums+$goods_info['postage'];

        if($liveuid==1){ //用户直接在平台自营店铺购买商品
            $liveuid=0; //消除订单结算时的代理佣金
        }

        $returnArr=array(
        	'uid'=>$uid, //用户ID
        	'shop_uid'=>$goods_info['uid'], //卖家用户ID
        	'goodsid'=>$goodsid,
        	'goods_name'=>$goods_info['name'],
            'spec_id'=>$spec_info['spec_id'],
        	'spec_name'=>$spec_info['spec_name'],
        	'spec_thumb'=>$spec_info['thumb'],
        	'nums'=>$nums,
        	'price'=>$price, //单价
        	'total'=>$total, //总价
        	'username'=>$address_info['name'],
        	'phone'=>$address_info['phone'],
        	'country'=>$address_info['country'],
        	'country_code'=>$address_info['country_code'],
        	'province'=>$address_info['province'],
        	'city'=>$address_info['city'],
        	'area'=>$address_info['area'],
        	'address'=>$address_info['address'],
        	'postage'=>$goods_info['postage'],
        	'addtime'=>$now,
            'message'=>$message,
            'liveuid'=>$liveuid,
            'commission'=>$goods_info['commission'],
            'admin_id'=>$goods_info['admin_id'],
            'shareuid'=>$shareuid,
            'share_income'=>$goods_info['share_income']

        );

        $rs['info']=$returnArr;

        return $rs;

    }


    /**
	* sign拼装获取
	*/
	protected function sign($param,$key){
		$sign = "";
        ksort($param);
		foreach($param as $k => $v){
			$sign .= $k."=".$v."&";
		}
		$sign .= "key=".$key;
		$sign = strtoupper(md5($sign));
		return $sign;
	
	}

	/**
	* xml转为数组
	*/
	protected function xmlToArray($xmlStr){
		$msg = array();
		$postStr = $xmlStr;
		$msg = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		return $msg;
	}

    /**
     * 买家根据订单类型获取订单列表
     * @desc 用于 买家根据订单类型获取订单列表
     * @return int code 操作码，0表示成功
     * @return array info
     * @return array info[0].id 商品订单ID
     * @return array info[0].uid 用户ID
     * @return array info[0].shop_uid 店铺ID
     * @return array info[0].goodsid 商品ID
     * @return array info[0].goods_name 商品名称
     * @return array info[0].spec_name 商品规格名称
     * @return array info[0].spec_thumb 商品规格封面
     * @return array info[0].nums 商品购买数量
     * @return array info[0].price 商品单价
     * @return array info[0].total 商品总价
     * @return array info[0].status 商品状态【-1 取消 0 待付款 1 待发货 2 待收货 3 待评价 4 已评价 5 退款】
     * @return array info[0].status_name 商品状态名称
     * @return array info[0].is_append_evaluate 订单是否可追加评价
     * @return object info[0].shopinfo 商品所属店铺信息【参考店铺详情注释】
     * @return object info[0].shopinfo.uid 店铺
     * @return string msg 提示信息
     */
    public function getGoodsOrderList(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $type=\App\checkNull($this->type);
        $p=$this->p;
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        $type_arr=['all','wait_payment','wait_shipment','wait_receive','wait_evaluate','refund'];

        if($uid<0||$token==""||!in_array($type, $type_arr)||$p<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $res=$domain->getGoodsOrderList($uid,$type,$p);

        $rs['info']=$res;

        return $rs;

    }


    /**
     * 买家未付款时取消商品订单
     * @desc 用于 买家未付款时取消商品订单
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     */
    public function cancelGoodsOrder(){
        $rs=array('code'=>0,'msg'=>\PhalApi\T('订单取消成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        
        if($uid<0||$token==''||$orderid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $where=array(
            'id'=>$orderid,
            'uid'=>$uid
        );
        $order_info=\App\getShopOrderInfo($where);
        if(!$order_info){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单不存在');
            return $rs;
        }

        $order_status=$order_info['status'];

        if($order_status>0){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单已付款,不可取消');
            return $rs;
        }

        if($order_status==-1){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单已取消');
            return $rs;
        }

        //更新订单信息
        $data=array(
            'status'=>-1,
            'cancel_time'=>$now
        );

        $res=\App\changeShopOrderStatus($uid,$orderid,$data);
        if(!$res){
            $rs['code']=1002;
            $rs['msg']=\PhalApi\T('订单取消失败,请重试');
            return $rs;
        }

        //商品规格库存回增
        \App\changeShopGoodsSpecNum($order_info['goodsid'],$order_info['spec_id'],$order_info['nums'],1);
        

        return $rs;

    }


    /**
     * 买家确认收货
     * @desc 用于买家确认收货
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function receiveGoodsOrder(){
        $rs=array('code'=>0,'msg'=>\PhalApi\T('确认收货成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        
        if($uid<0||$token==''||$orderid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $where=array(
            'id'=>$orderid,
            'uid'=>$uid
        );
        $order_info=\App\getShopOrderInfo($where);
        if(!$order_info){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单不存在');
            return $rs;
        }

        $order_status=$order_info['status'];

        if($order_status==-1){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单已取消');
            return $rs;
        }

        if($order_status==1){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('等待卖家发货');
            return $rs;
        }

        if($order_status==3||$order_status==4){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单已确认收货');
            return $rs;
        }

        if($order_status==5){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单申请退款中');
            return $rs;
        }

        //更新订单信息
        $data=array(
            'status'=>3, //改为待评价状态
            'receive_time'=>$now
        );

        $res=\App\changeShopOrderStatus($uid,$orderid,$data);
        if(!$res){
            $rs['code']=1002;
            $rs['msg']=\PhalApi\T('订单确认收货失败,请重试');
            return $rs;
        }

        return $rs;

    }

    /**
     * 买家删除订单
     * @desc 用于买家删除订单
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function delGoodsOrder(){

        $rs=array('code'=>0,'msg'=>\PhalApi\T('订单删除成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        
        if($uid<0||$token==''||$orderid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $where=array(
            'id'=>$orderid,
            'uid'=>$uid
        );
        $order_info=\App\getShopOrderInfo($where);
        if(!$order_info){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单不存在');
            return $rs;
        }

        $order_status=$order_info['status'];

        if($order_status!=-1 && $order_status!=4){ //已关闭 和已评价的订单可以删除
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单不允许删除');
            return $rs;
        }

        if($order_info['isdel']==1 ||$order_info['isdel']==-1){ //卖家买家都删除了 或 买家已删除
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单已经删除');
            return $rs;
        }

        $data=array(
            'isdel'=>-1
        );

        if($order_info['isdel']==-2){
            $data=array(
                'isdel'=>1
            );
        }

        \App\changeShopOrderStatus($uid,$orderid,$data);

        return $rs;
    }

    /**
     * 买家获取订单详情
     * @desc 用于买家获取订单详情
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     * @return object info[0].order_info 返回订单信息
     * @return object info[0].order_info.address_format 返回订单收货地址格式化
     * @return object info[0].order_info.type_name 返回订单付款方式说明
     * @return object info[0].order_info.status_name 返回订单状态说明
     * @return object info[0].order_info.status_desc 返回订单状态简介
     * @return object info[0].shop_info 返回订单商品所属店铺信息
     * @return object info[0].express_info 返回订单物流信息
     * @return string info[0].express_info.state_name 返回订单物流的状态
     * @return string info[0].express_info.desc 返回订单物流的说明
     */
    public function getGoodsOrderInfo(){

        $rs=array('code'=>0,'msg'=>'','info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        
        if($uid<0||$token==''||$orderid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }


        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $where=array(
            'id'=>$orderid,
            'uid'=>$uid
        );
        $order_info=\App\getShopOrderInfo($where);
        if(!$order_info){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单不存在');
            return $rs;
        }


        $rs['info'][0]['order_info']=\App\handleGoodsOrder($order_info);

        $domain=new Domain_Shop();
        $shop_info=$domain->getShop($order_info['shop_uid']);
		


        //判断用户是否关注了店铺主播
        $isattention=\App\isAttention($uid,$order_info['shop_uid']);
        $shop_info['isattention']=$isattention;

        $rs['info'][0]['shop_info']=$shop_info;



        $rs['info'][0]['express_info']=[];



        if($order_info['status']==2||$order_info['status']==3||$order_info['status']==4){
            $express_info=\App\getExpressStateInfo($order_info['express_code'],$order_info['express_number'],$order_info['express_name'],$order_info['username'],$order_info['phone']);

            $rs['info'][0]['express_info']=$express_info;
        }

        return $rs;
    }


    /**
     * 买家评价商品
     * @desc 用于买家评价商品订单
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function evaluateGoodsOrder(){
        $rs=array('code'=>0,'msg'=>\PhalApi\T('商品评价成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $content=\App\checkNull($this->content);
        $thumbs=\App\checkNull($this->thumbs);
        $video_url=\App\checkNull($this->video_url);
        $video_thumb=\App\checkNull($this->video_thumb);
        $is_anonym=\App\checkNull($this->is_anonym);
        $quality_points=\App\checkNull($this->quality_points);
        $service_points=\App\checkNull($this->service_points);
        $express_points=\App\checkNull($this->express_points);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        
        if($uid<0||$token==''||$orderid<1||!$time||!$sign||!$content){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        if(mb_strlen($content)>200){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('评价内容在200字以内');
            return $rs;
        }

        if($thumbs){
            $thumb_arr=explode(',',$thumbs);
            $count=count($thumb_arr);
            if($count>5){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('评价图片最多上传5张');
                return $rs;
            }
        }

        if($quality_points){
            if(floor($quality_points)!=$quality_points){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('商品质量评分为0-5的整数');
                return $rs;
            }

            if($quality_points>5||$quality_points<0){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('商品质量评分为0-5的整数');
                return $rs;
            }
        }

        if($service_points){
            if(floor($service_points)!=$service_points){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('服务态度评分为0-5的整数');
                return $rs;
            }

            if($service_points>5||$service_points<0){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('服务态度评分为0-5的整数');
                return $rs;
            }
        }

        if($express_points){
            if(floor($express_points)!=$express_points){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('送货服务评分为0-5的整数');
                return $rs;
            }

            if($express_points>5||$express_points<0){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('送货服务评分为0-5的整数');
                return $rs;
            }
        }


        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'is_anonym'=>$is_anonym,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $where=array(
            'id'=>$orderid,
            'uid'=>$uid
        );
        $order_info=\App\getShopOrderInfo($where);
        if(!$order_info){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单不存在');
            return $rs;
        }

        $status=$order_info['status'];

        switch ($status) {
            case '-1':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('订单已关闭');
                return $rs;
                break;
            
            case '0':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('请先对该订单付款');
                return $rs;
                break;

            case '1':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('等待卖家发货');
                return $rs;
                break;

            case '2':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('请先确认收货');
                return $rs;
                break;

            case '4':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('该订单已经评价');
                return $rs;
                break;

            case '5':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('该订单为退款状态,不能评价');
                return $rs;
                break;
        }


        $data=array(
            'uid'=>$uid,
            'orderid'=>$orderid,
            'goodsid'=>$order_info['goodsid'],
            'shop_uid'=>$order_info['shop_uid'],
            'content'=>$content,
            'thumbs'=>$thumbs,
            'video_thumb'=>$video_thumb,
            'video_url'=>$video_url,
            'is_anonym'=>$is_anonym,
            'quality_points'=>$quality_points,
            'service_points'=>$service_points,
            'express_points'=>$express_points,
            'addtime'=>$now
        );

        $domain=new Domain_Buyer();
        $res=$domain->evaluateGoodsOrder($data);
        if(!$res){
            $rs['code']=1002;
            $rs['msg']=\PhalApi\T('订单评价失败');
            return $rs;
        }

        return $rs;

    }

    /**
     * 买家对订单追评
     * @desc 用于卖家对商品进行追评
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function appendEvaluateGoodsOrder(){
        $rs=array('code'=>0,'msg'=>\PhalApi\T('追评成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $content=\App\checkNull($this->content);
        $thumbs=\App\checkNull($this->thumbs);
        $video_url=\App\checkNull($this->video_url);
        $video_thumb=\App\checkNull($this->video_thumb);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        
        if($uid<0||$token==''||$orderid<1||!$time||!$sign||!$content){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        if(mb_strlen($content)>200){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('评价内容在200字以内');
            return $rs;
        }

        if($thumbs){
            $thumb_arr=explode(',',$thumbs);
            $count=count($thumb_arr);
            if($count>5){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('评价图片最多上传5张');
                return $rs;
            }
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $where=array(
            'id'=>$orderid,
            'uid'=>$uid
        );
        $order_info=\App\getShopOrderInfo($where);
        if(!$order_info){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('订单不存在');
            return $rs;
        }

        $status=$order_info['status'];

        switch ($status) {
            case '-1':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('订单已关闭');
                return $rs;
                break;
            
            case '0':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('请先对该订单付款');
                return $rs;
                break;

            case '1':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('等待卖家发货');
                return $rs;
                break;

            case '2':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('请先确认收货');
                return $rs;
                break;

            case '4':
                if(!$order_info['is_append_evaluate']){ //不可追评
                    $rs['code']=1001;
                    $rs['msg']=\PhalApi\T('不可对该订单追评');
                    return $rs;
                }
                
                break;

            case '5':
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('该订单为退款状态,不能评价');
                return $rs;
                break;
        }

        $data=array(
            'uid'=>$uid,
            'orderid'=>$orderid,
            'goodsid'=>$order_info['goodsid'],
            'shop_uid'=>$order_info['shop_uid'],
            'content'=>$content,
            'thumbs'=>$thumbs,
            'video_thumb'=>$video_thumb,
            'video_url'=>$video_url,
            'is_append'=>1,
            'addtime'=>$now
        );

        $domain=new Domain_Buyer();
        $res=$domain->appendEvaluateGoodsOrder($data);

        if(!$res){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('追评失败,请重试');
            return $rs;
        }

        return $rs;
    }

    /**
     * 买家获取退款原因列表
     * @desc 用于买家获取退款原因列表
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     * @return array info[].id 原因ID
     * @return array info[].name 原因名称
     */
    public function getRefundReason(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $list=$domain->getRefundReason();

        //语言包
        $language=\Phalapi\DI()->language;
        foreach ($list as $k => $v) {
            $list[$k]['id']=(string)$v['id'];
            if($language=='en'){
                $list[$k]['name']=$v['name_en'];
            }
        }

        $rs['info']=$list;
        return $rs;

    }

    /**
     * 买家申请订单退款
     * @desc 用于买家申请订单退款
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function applyRefundGoodsOrder(){

        $rs=array('code'=>0,'msg'=>\PhalApi\T('申请退款成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $reasonid=\App\checkNull($this->reasonid);
        $content=\App\checkNull($this->content);
        $thumb=\App\checkNull($this->thumb);
        $type=\App\checkNull($this->type);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==''||$orderid<1||$reasonid<1||!in_array($type,['0','1'])||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $reason_list=$domain->getRefundReason();

        $has_reason=0;
        $reason='';
        //语言包
        $reason_en='';

        foreach ($reason_list as $k => $v) {
            if($reasonid==$v['id']){
                $has_reason=1;
                $reason=$v['name'];
                $reason_en=$v['name_en'];
                break;
            }
        }

        if(!$has_reason){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('请确认退货原因');
            return $rs;
        }

        if($content){
            if(mb_strlen($content)>300){
                $rs['code']=1001;
                $rs['msg']=\PhalApi\T('退款说明在300字以内');
                return $rs;
            }
        }

        $data=array(
            'reason'=>$reason,
            'reason_en'=>$reason_en,
            'content'=>$content,
            'thumb'=>$thumb,
            'type'=>$type
        );

        $domain=new Domain_Buyer();
        $rs=$domain->applyRefundGoodsOrder($uid,$orderid,$data);



        return $rs;

    }

    /**
     * 买家取消订单退款
     * @desc 用于取消订单退款
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function cancelRefundGoodsOrder(){

        $rs=array('code'=>0,'msg'=>\PhalApi\T('订单退款取消成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==""||$orderid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $rs=$domain->cancelRefundGoodsOrder($uid,$orderid);

        return $rs;


    }

    /**
     * 买家获取订单退款详情
     * @desc 用于买家获取订单退款详情
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     * @return string info[0]['refund_info']['reason'] 退款选择的理由
     * @return string info[0]['refund_info']['content'] 退款填写的说明
     * @return int info[0]['refund_info']['shop_process_num'] 店铺拒绝次数
     * @return string info[0]['refund_info']['shop_process_time'] 店铺处理时间
     * @return int info[0]['refund_info']['shop_result'] 店铺处理结果 -1 拒绝 0 处理中 1 同意
     * @return string info[0]['refund_info']['platform_process_time'] 平台处理时间
     * @return int info[0]['refund_info']['platform_result'] 平台处理结果 -1 拒绝 0 处理中 1 同意
     * @return int info[0]['refund_info']['status'] 退款处理状态   0 处理中  -1买家已取消  1 已完成
     * @return int info[0]['refund_info']['is_platform_interpose'] 是否平台介入
     * @return stirng info[0]['refund_info']['system_process_time'] 系统自动处理时间
     */
    public function getGoodsOrderRefundInfo(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==""||$orderid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $rs=$domain->getGoodsOrderRefundInfo($uid,$orderid);

        
        return $rs;

    }

    /**
     * 买家重新申请退款
     * @desc 用于买家重新申请退款
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function reapplyRefundGoodsOrder(){
        $rs=array('code'=>0,'msg'=>\PhalApi\T('重新申请成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==""||$orderid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $rs=$domain->reapplyRefundGoodsOrder($uid,$orderid);

        return $rs;
        
    }

    /**
     * 买家获取退款申请平台介入原因列表
     * @desc 用于买家获取退款申请平台介入原因列表
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     * @return array info[].id 原因ID
     * @return array info[].name 原因名称
     */
    public function getPlatformReasonList(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $list=$domain->getPlatformReasonList();

        //语言包
        $language=\Phalapi\DI()->language;
        foreach ($list as $k => $v) {
            $list[$k]['id']=(string)$v['id'];
            if($language=="en"){
                $list[$k]['name']=$v['name_en'];
            }
        }

        $rs['info']=$list;
        return $rs;
    }


    /**
     * 买家申请平台介入
     * @desc 用于买家申请平台介入
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     */
    public function applyPlatformInterpose(){

        $rs=array('code'=>0,'msg'=>\PhalApi\T('申请平台介入成功'),'info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $orderid=\App\checkNull($this->orderid);
        $reasonid=\App\checkNull($this->reasonid);
        $content=\App\checkNull($this->content);
        $thumb=\App\checkNull($this->thumb);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);

        if($uid<0||$token==""||$orderid<1||$reasonid<1||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        if($content){
            if(mb_strlen($content)>300){
                $rs['code'] = 1001;
                $rs['msg'] = \PhalApi\T('原因描述应在300字以内');
                return $rs;
            }
        }

        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'orderid'=>$orderid,
            'reasonid'=>$reasonid,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $has_reason=0;
        $domain=new Domain_Buyer();

        $reason='';
        //语言包
        $reason_en='';

        $reason_list=$domain->getPlatformReasonList();
        foreach ($reason_list as $k => $v) {
            if($v['id']==$reasonid){
                $has_reason=1;
                $reason=$v['name'];
                $reason_en=$v['name_en'];
                break;
            }
        }

        if(!$has_reason){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('申诉原因不存在');
            return $rs;
        }

        $data=array(
            'is_platform_interpose'=>1,
            'platform_interpose_reason'=>$reason,
            'platform_interpose_reason_en'=>$reason_en,
            'platform_interpose_desc'=>$content,
            'platform_interpose_thumb'=>$thumb
        );

        $rs=$domain->applyPlatformInterpose($uid,$orderid,$data);

        return $rs;
    }


    /**
     * 买家获取退款记录列表
     * @desc 用于买家获取退款记录列表
     * @return int code 状态码，0表示成功
     * @return string msg 提示信息
     * @return array info 返回信息
     * @return object info[0]['user_balance'] 用户余额对象
     * @return array info[0]['user_balance']['balance'] 用户余额
     * @return array info[0]['user_balance']['balance_total'] 用户累计余额
     * @return array info[0]['list'] 退款列表
     * @return array info[0]['list'][]['balance'] 退款金额
     * @return array info[0]['list'][]['addtime'] 添加时间
     * @return array info[0]['list'][]['result'] 退款结果
     */
    public function getRefundList(){
        $rs=array('code'=>0,'msg'=>'','info'=>array());

        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $time=\App\checkNull($this->time);
        $sign=\App\checkNull($this->sign);
        $p=\App\checkNull($this->p);

        if($uid<0||$token==""||!$time||!$sign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
        if($checkToken==700){
            $rs['code'] = $checkToken;
            $rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
            return $rs;
        }

        
        $now=time();
        if($now-$time>300){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('参数错误');
            return $rs;
        }

        $checkdata=array(
            'uid'=>$uid,
            'token'=>$token,
            'time'=>$time
        );

        $issign=\App\checkSign($checkdata,$sign);
        if(!$issign){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('签名错误');
            return $rs;
        }

        $domain=new Domain_Buyer();
        $res=$domain->getRefundList($uid,$p);

        $user_balance=\App\getUserShopBalance($uid);

        $rs['info'][0]['list']=$res;
        $rs['info'][0]['user_balance']=$user_balance;

        return $rs;
    }
	
	/**
	 * 买家创建订单时的检测(购物车多商品)
	 * @desc 用于 买家创建订单时的检测(购物车多商品)
	 * @return array info 返回订单信息
	 */
	protected function createGoodsOrderTestCart($data){
		$rs=array('code'=>0,'msg'=>'','info'=>array());
		
		$uid=$data['uid'];
		$token=$data['token'];
		$addressid=$data['addressid'];
		$goodsuid=$data['goodsuid'];
		$cartsid=$data['cartsid'];
		$message=$data['message'];
		$time=$data['time'];
		$sign=$data['sign'];
		$liveuid=$data['liveuid'];
		$shareuid=$data['shareuid'];

		if (empty($cartsid)){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
		}
		
		if($uid<0||$token==''||$addressid<0||$goodsuid<0||!$time||!$sign){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
		}
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$now=time();
		if($now-$time>300){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
		}
		
		$checkdata=array(
			'uid'=>$uid,
			'addressid'=>$addressid,
			'goodsuid'=>$goodsuid,
			'time'=>$time
		);
		$issign=\App\checkSign($checkdata,$sign);
		if(!$issign){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('签名错误');
			return $rs;
		}

		$domain=new Domain_Buyer();
		$address_info=$domain->getAddress($uid,$addressid);
		
		if(!$address_info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('收货地址不存在');
			return $rs;
		}
		
		$domain_shop=new Domain_Shop();
		
		
		$cartsid= explode(',', $cartsid);
		
		$returnArr = [];
		foreach ($cartsid as $cartid){
			$where['cartid']=$cartid;
			$getCart=$domain_shop->getCart($where);
			if($getCart){
				$where_goods['id']=$getCart['goodsid'];
				$goods_info=$domain_shop->getGoods($where_goods);
				if(!$goods_info){
					$rs['code'] = 1003;
					$rs['msg'] = \PhalApi\T('商品不存在');
					return $rs;
				}
				
				if($goods_info['uid']==$uid){
					$rs['code'] = 1003;
					$rs['msg'] = \PhalApi\T('不能购买自己的商品');
					return $rs;
				}
				
				$goods_status=$goods_info['status'];
				
				
				if($goods_status==-2){
					$rs['code'] = 1004;
					$rs['msg'] = \PhalApi\T('该商品已下架');
					return $rs;
				}
				
				if($goods_status==-1){
					$rs['code'] = 1005;
					$rs['msg'] = \PhalApi\T('该商品已下架');
					return $rs;
				}
				
				if($goods_status!=1){
					$rs['code'] = 1006;
					$rs['msg'] = \PhalApi\T('商品未通过审核');
					return $rs;
				}
				
				$spec_arr=json_decode($goods_info['specs'],true);
				
				$spec_info=[];
				$spec_id = $getCart['specid'];
				foreach ($spec_arr as $k => $v) {
					if($v['spec_id']==$spec_id){
						$spec_info=$v;
						break;
					}
				}

				if(empty($spec_info)){
					$rs['code'] = 1007;
					$rs['msg'] = \PhalApi\T('没有对应的商品规格');
					return $rs;
				}
				if($spec_info['spec_num']<$getCart['nums']){
					$rs['code'] = 1007;
					$rs['msg'] = \PhalApi\T('商品库存不足');
					return $rs;
				}

				if($message){
					if(mb_strlen($message)>100){
						$rs['code'] = 1007;
						$rs['msg'] = \PhalApi\T('留言内容在100字以内');
						return $rs;
					}
				}


				if($uid==$shareuid){
					$shareuid=0;
				}

				if($shareuid>0){

					//检测分享用户是否存在
					$where=[];
					$where['id']=$shareuid;
					$where['user_type']=2;
					$anchor_isexist=\App\checkUser($where);
					if(!$anchor_isexist){
						$rs['code'] = 1008;
						$rs['msg'] = \PhalApi\T('分享商品用户不存在');
						return $rs;
					}

				}else{
					$goods_info['share_income']=0;
				}


				$price=$spec_info['price'];

				$total=$price*$getCart['nums']+$goods_info['postage'];

				if($liveuid==1){ //用户直接在平台自营店铺购买商品
					$liveuid=0; //消除订单结算时的代理佣金
				}
			}
			$returnArr[]=array(
				'uid'=>$uid, //用户ID
				'shop_uid'=>$goods_info['uid'], //卖家用户ID
				'goodsid'=>$getCart['goodsid'],
				'goods_name'=>$goods_info['name'],
				'spec_id'=>$spec_info['spec_id'],
				'spec_name'=>$spec_info['spec_name'],
				'spec_thumb'=>$spec_info['thumb'],
				'nums'=>$getCart['nums'],
				'price'=>$price, //单价
				'total'=>$total, //总价
				'username'=>$address_info['name'],
				'phone'=>$address_info['phone'],
				'country'=>$address_info['country'],
				'country_code'=>$address_info['country_code'],
				'province'=>$address_info['province'],
				'city'=>$address_info['city'],
				'area'=>$address_info['area'],
				'address'=>$address_info['address'],
				'postage'=>$goods_info['postage'],
				'addtime'=>$now,
				'message'=>$message,
				'liveuid'=>$liveuid,
				'commission'=>$goods_info['commission'],
				'admin_id'=>$goods_info['admin_id'],
				'shareuid'=>$shareuid,
				'share_income'=>$goods_info['share_income']
			);
		}
		$rs['info']=$returnArr;
		return $rs;
		
	}
	
	private function generateRSA2Signature($data,$privateKeyFile)
	{
		// 读取私钥
		$privateKey = file_get_contents($privateKeyFile);
		$privateKeyId = openssl_get_privatekey($privateKey);
		
		if (!$privateKeyId) {
			die('私钥加载失败，请检查私钥文件路径！');
		}
		
		// 生成签名
		openssl_sign($data, $sign, $privateKeyId, OPENSSL_ALGO_SHA256);
		
		// 释放私钥资源
		openssl_free_key($privateKeyId);
		
		// 返回 Base64 编码的签名
		return base64_encode($sign);
	}
	
	private function createUnsignedString(array $data)
	{
		ksort($data); // 按键名排序
		$pairs = [];
		foreach ($data as $key => $value) {
			$pairs[] = $key . '=' . $value;
		}
		return implode('&', $pairs);
	}
	
}
