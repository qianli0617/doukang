<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Charge as Domain_Charge;
/**
 * 充值
 */
class Charge extends Api {

	public function getRules() {
		return array(
			'getAliOrder' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'changeid' => array('name' => 'changeid', 'type' => 'int',  'require' => true, 'desc' => '充值规则ID'),
				'coin' => array('name' => 'coin', 'type' => 'string',  'require' => true, 'desc' => '钻石'),
				'money' => array('name' => 'money', 'type' => 'string', 'require' => true, 'desc' => '充值金额'),
				'appid' => array('name' => 'appid', 'type' => 'string', 'require' => true, 'desc' => 'appid'),
			),
			'getWxOrder' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'changeid' => array('name' => 'changeid', 'type' => 'string',  'require' => true, 'desc' => '充值规则ID'),
				'coin' => array('name' => 'coin', 'type' => 'string',  'require' => true, 'desc' => '钻石'),
				'money' => array('name' => 'money', 'type' => 'string', 'require' => true, 'desc' => '充值金额'),
			),
			'getIosOrder' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'changeid' => array('name' => 'changeid', 'type' => 'string',  'require' => true, 'desc' => '充值规则ID'),
				'coin' => array('name' => 'coin', 'type' => 'string',  'require' => true, 'desc' => '钻石'),
				'money' => array('name' => 'money', 'type' => 'string', 'require' => true, 'desc' => '充值金额'),
			),

			'getWxMiniOrder' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'chargeid' => array('name' => 'chargeid', 'type' => 'string',  'require' => true, 'desc' => '充值规则ID'),
				'coin' => array('name' => 'coin', 'type' => 'string',  'require' => true, 'desc' => '钻石'),
				'money' => array('name' => 'money', 'type' => 'string', 'require' => true, 'desc' => '充值金额'),
				'openid' => array('name' => 'openid', 'type' => 'string', 'require' => true, 'desc' => '用户在商户appid下的唯一标识'),
			),
			'getPaypalOrder' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'changeid' => array('name' => 'changeid', 'type' => 'int',  'require' => true, 'desc' => '充值规则ID'),
				'coin' => array('name' => 'coin', 'type' => 'string',  'require' => true, 'desc' => '钻石'),
				'money' => array('name' => 'money', 'type' => 'string', 'require' => true, 'desc' => '充值金额'),
			),

			'getBraintreePaypalOrder' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'changeid' => array('name' => 'changeid', 'type' => 'int',  'require' => true, 'desc' => '充值规则ID'),
				'coin' => array('name' => 'coin', 'type' => 'string',  'require' => true, 'desc' => '钻石'),
				'money' => array('name' => 'money', 'type' => 'string', 'require' => true, 'desc' => '充值金额'),
			),

			'getFirstChargeRules'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
			),


		);
	}
	
	/* 获取订单号 */
	protected function getOrderid($uid){
		$orderid=$uid.'_'.date('YmdHis').rand(100,999);
		return $orderid;
	}

	/**
	 * 微信支付获取订单号
	 * @desc 用于 微信支付获取订单号
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0] 支付信息
	 * @return string msg 提示信息
	 */
	public function getWxOrder() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$changeid=\App\checkNull($this->changeid);
		$coin=\App\checkNull($this->coin);
		$money=\App\checkNull($this->money);

		$checkToken=\App\checkToken($uid,$token);

		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$orderid=$this->getOrderid($uid);
		$type=2;
		
		if($coin==0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('信息错误');
			return $rs;
		}
		
		$configpri = \App\getConfigPri();
		$configpub = \App\getConfigPub();

		 //配置参数检测
			
		if($configpri['wx_appid']== "" || $configpri['wx_mchid']== "" || $configpri['wx_key']== ""){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('微信未配置');
			return $rs;
		}
		
		$orderinfo=array(
			"uid"=>$uid,
			"touid"=>$uid,
			"money"=>$money,
			"coin"=>$coin,
			"orderno"=>$orderid,
			"type"=>$type,
			"status"=>0,
			"addtime"=>time()
		);

		
		$domain = new Domain_Charge();
		$info = $domain->getOrderId($changeid,$orderinfo);
		if($info==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('订单信息有误，请重新提交');
            return $rs;
		}else if(!$info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单生成失败');
            return $rs;
		}

		
		$noceStr = md5(rand(100,1000).time());//获取随机字符串
		$time = time();
		
		$paramarr = array(
			"appid"       =>   $configpri['wx_appid'],
			"body"        =>    \PhalApi\T("充值{coin}抖康钻石",array('coin'=>$coin)),
			"mch_id"      =>    $configpri['wx_mchid'],
			"nonce_str"   =>    $noceStr,
			"notify_url"  =>    $configpub['site'].'/appapi/pay/notify_wx',
			"out_trade_no"=>    $orderid,
			"total_fee"   =>    $money*100,
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
			file_put_contents(API_ROOT.'/../log/phalapi/charge_wxpay_'.date('Y-m-d').'.txt',date('y-m-d H:i:s').' 提交参数信息 ch:'.json_encode(curl_error($ch))."\r\n\r\n",FILE_APPEND);
		}
		curl_close($ch);

		$result2 = $this->xmlToArray($resultXmlStr);
        
        if($result2['return_code']=='FAIL'){
            $rs['code']=1005;
			$rs['msg']=$result2['return_msg'];
            return $rs;
        }
		$time2 = time();
		$prepayid = $result2['prepay_id'];
		$sign = "";
		$noceStr = md5(rand(100,1000).time());//获取随机字符串
		$paramarr2 = array(
			"appid"     =>  $configpri['wx_appid'],
			"noncestr"  =>  $noceStr,
			"package"   =>  "Sign=WXPay",
			"partnerid" =>  $configpri['wx_mchid'],
			"prepayid"  =>  $prepayid,
			"timestamp" =>  $time2
		);
		$paramarr2["sign"] = $this -> sign($paramarr2,$configpri['wx_key']);//生成签名
		
		$rs['info'][0]=$paramarr2;
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
	 * 支付宝支付获取订单号
	 * @desc 用于支付宝支付获取订单号
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].orderid 订单号
	 * @return string msg 提示信息
	 */
	public function getAliOrder() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$changeid=\App\checkNull($this->changeid);
		$coin=\App\checkNull($this->coin);
		$money=\App\checkNull($this->money);
		$appid=\App\checkNull($this->appid);

		$checkToken=\App\checkToken($uid,$token);

		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$configpri=\App\getConfigPri();
        if(!$configpri['aliapp_partner']||!$configpri['aliapp_seller_id']||!$configpri['aliapp_key_android']||!$configpri['aliapp_key_ios']){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('支付宝未配置');
            return $rs;
        }
		
		$orderid=$this->getOrderid($uid);
		$type=1;
		
		if($coin==0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('信息错误');
			return $rs;
		}
		
		$orderinfo=array(
			"uid"=>$uid,
			"touid"=>$uid,
			"money"=>$money,
			"coin"=>$coin,
			"orderno"=>$orderid,
			"type"=>$type,
			"status"=>0,
			"addtime"=>time()
		);
		
		$domain = new Domain_Charge();
		$info = $domain->getOrderId($changeid,$orderinfo);
		if($info==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('订单信息有误，请重新提交');
		}else if(!$info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单生成失败');
		}
		
		$data = [
			'app_id' => $appid,
			'biz_content' => json_encode([
				'timeout_express' => '30m',
				'product_code' => 'QUICK_MSECURITY_PAY',
				'total_amount' => $info['money'],
//				'total_amount' => 0.01,
				'subject' => '1',
				'body' => '抖康币充值',
				'out_trade_no' => $info['orderno'],
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
		
		$rs['info'][0]['orderid']=$orderid;
		$rs['info'][0]['string']=$finalRequestString;
		
		return $rs;
	}

	/**
	 * 苹果支付获取订单号
	 * @desc 用于苹果支付获取订单号
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].orderid 订单号
	 * @return string msg 提示信息
	 */
	public function getIosOrder() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$changeid=\App\checkNull($this->changeid);
		$coin=\App\checkNull($this->coin);
		$money=\App\checkNull($this->money);

		$checkToken=\App\checkToken($uid,$token);

		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$orderid=$this->getOrderid($uid);
		$type=3;
		
		if($coin==0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('信息错误');
			return $rs;
		}

		$configpri = \App\getConfigPri();
		
		$orderinfo=array(
			"uid"=>$uid,
			"touid"=>$uid,
			"money"=>$money,
			"coin"=>$coin,
			"orderno"=>$orderid,
			"type"=>$type,
			"status"=>0,
			"addtime"=>time()
		);
		
		$domain = new Domain_Charge();
		$info = $domain->getOrderId($changeid,$orderinfo);
		if($info==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('订单信息有误，请重新提交');
		}else if(!$info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单生成失败');
		}

		$rs['info'][0]['orderid']=$orderid;
		return $rs;
	}


	/**
	 * 微信小程序支付获取订单号
	 * @desc 用于 微信小程序支付获取订单号
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0] 支付信息
	 * @return string msg 提示信息
	 */
	public function getWxMiniOrder() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$chargeid=\App\checkNull($this->chargeid);
		$coin=\App\checkNull($this->coin);
		$money=\App\checkNull($this->money);
		$openid=\App\checkNull($this->openid);

		$orderid=$this->getOrderid($uid);
		$type=4;
		
		if($coin==0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('信息错误');
			return $rs;
		}
		
		$configpri = \App\getConfigPri();
		$configpub = \App\getConfigPub();

		 //配置参数检测
			
		if($configpri['wx_mini_appid']== "" || $configpri['wx_mini_mchid']== "" || $configpri['wx_mini_key']== ""){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('微信小程序支付未配置');
			return $rs;
		}

		if(!$openid){
            $rs['code'] = 1002;
            $rs['msg'] = \PhalApi\T('缺少必要参数openid');
            return $rs;
        }
		
		$orderinfo=array(
			"uid"=>$uid,
			"touid"=>$uid,
			"money"=>$money,
			"coin"=>$coin,
			"orderno"=>$orderid,
			"type"=>$type,
			"status"=>0,
			"addtime"=>time()
		);

		
		$domain = new Domain_Charge();
		$info = $domain->getOrderId($chargeid,$orderinfo);
		if($info==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('订单信息有误，请重新提交');
            return $rs;
		}else if(!$info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单生成失败');
            return $rs;
		}

		
		$noceStr = md5(rand(100,1000).time());//获取随机字符串
		$time = time();
		
		$paramarr = array(
			"appid"       =>   $configpri['wx_mini_appid'],
			"body"        =>    \PhalApi\T("充值{coin}虚拟币",array('coin'=>$coin)),
			"mch_id"      =>    $configpri['wx_mini_mchid'],
			"nonce_str"   =>    $noceStr,
			"notify_url"  =>    $configpub['site'].'/appapi/pay/notify_wx_mini',
			"openid"	  =>    $openid,
			"out_trade_no"=>    $orderid,
			"spbill_create_ip"   =>$_SERVER["REMOTE_ADDR"],
			"total_fee"   =>    $money*100,
			"trade_type"  =>    "JSAPI"
		);

		
		$sign = $this -> sign($paramarr,$configpri['wx_mini_key']);//生成签名
		$paramarr['sign'] = $sign;

		/*var_dump($paramarr);
		die;*/

		$paramXml = "<xml>";
		foreach($paramarr as $k => $v){
			$paramXml .= "<" . $k . ">" . $v . "</" . $k . ">";
		}
		$paramXml .= "</xml>";

		/*var_dump($paramXml);
		die;*/
		
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
			file_put_contents(API_ROOT.'/../log/phalapi/charge_wxmini_pay_'.date('Y-m-d').'.txt',date('y-m-d H:i:s').' 提交参数信息 ch:'.json_encode(curl_error($ch))."\r\n\r\n",FILE_APPEND);
		}
		curl_close($ch);

		$result2 = $this->xmlToArray($resultXmlStr);

        
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
		return $rs;
	}

	/**
	 * paypal支付获取订单号
	 * @desc 用于贝宝支付获取订单号
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].orderid 订单号
	 * @return string msg 提示信息
	 */
	private function getPaypalOrderBF() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$changeid=\App\checkNull($this->changeid);
		$coin=\App\checkNull($this->coin);
		$money=\App\checkNull($this->money);
		
		$configpri=\App\getConfigPri();
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

		$orderid=$this->getOrderid($uid);
		$type=5;
		
		if($coin==0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('信息错误');
			return $rs;
		}
		
		$orderinfo=array(
			"uid"=>$uid,
			"touid"=>$uid,
			"money"=>$money,
			"coin"=>$coin,
			"orderno"=>$orderid,
			"type"=>$type,
			"status"=>0,
			"addtime"=>time()
		);
		
		$domain = new Domain_Charge();
		$info = $domain->getOrderId($changeid,$orderinfo);
		if($info==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('订单信息有误，请重新提交');
		}else if(!$info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单生成失败');
		}
		
		$paypal=[
			'paypal_sandbox'=>$configpri['paypal_sandbox'],//支付模式：0：沙盒支付；1：生产支付
			'sandbox_clientid'=>$configpri['sandbox_clientid'],//沙盒客户端ID
			'product_clientid'=>$configpri['product_clientid'],//生产客户端ID
		];
		
		$rs['info'][0]=$paypal;
		$rs['info'][0]['orderid']=$orderid;
		
		return $rs;
	}


	/**
	 * Braintree绑定Paypal支付获取订单号
	 * @desc 用于Braintree绑定Paypal支付获取订单号
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].orderid 订单号
	 * @return string msg 提示信息
	 */
	public function getBraintreePaypalOrder() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$changeid=\App\checkNull($this->changeid);
		$coin=\App\checkNull($this->coin);
		$money=\App\checkNull($this->money);

		$checkToken=\App\checkToken($uid,$token);

		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$configpri=\App\getConfigPri();

		$environment=$configpri['braintree_paypal_environment'];

		$merchantId='';
		$publicKey='';
		$privateKey='';

		if($environment==0){ //沙盒
			$merchantId=$configpri['braintree_merchantid_sandbox'];
			$publicKey=$configpri['braintree_publickey_sandbox'];
			$privateKey=$configpri['braintree_privatekey_sandbox'];
			
		}else{ //生产

			$merchantId=$configpri['braintree_merchantid_product'];
			$publicKey=$configpri['braintree_publickey_product'];
			$privateKey=$configpri['braintree_privatekey_product'];
			
		}

		if(!$merchantId || !$publicKey ||!$privateKey){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('BraintreePaypal未配置');
			return $rs;
		}

		$orderid=$this->getOrderid($uid);
		$type=6;
		
		if($coin==0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('信息错误');
			return $rs;
		}
		
		$orderinfo=array(
			"uid"=>$uid,
			"touid"=>$uid,
			"money"=>$money,
			"coin"=>$coin,
			"orderno"=>$orderid,
			"type"=>$type,
			"status"=>0,
			"addtime"=>time()
		);
		
		$domain = new Domain_Charge();
		$info = $domain->getOrderId($changeid,$orderinfo);
		if($info==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('订单信息有误，请重新提交');
		}else if(!$info){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单生成失败');
		}
		
		$rs['info'][0]['orderid']=$orderid;
		return $rs;
	}
	
	/**
	 * 获取首充充值规则列表
	 * @desc 获取首充充值规则列表
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return int info[0]['has_used'] 首充机会是否已用完 0 否 1 是
	 * @return int info[0]['list'] 返回充值规则
	 * @return int info[0]['list'][]['id'] 返回充值规则ID
	 * @return int info[0]['list'][]['title'] 返回充值规则名称
	 * @return int info[0]['list'][]['money'] 返回充值规则金额
	 * @return int info[0]['list'][]['coin'] 返回充值规则钻石数
	 * @return array info[0]['list'][]['list'] 返回充值规则项目列表
	 * @return string info[0]['list'][]['list'][]['name'] 返回充值规则项目列表项的名称
	 * @return string info[0]['list'][]['list'][]['count'] 返回充值规则项目列表项的数量
	 * @return string info[0]['list'][]['list'][]['thumb'] 返回充值规则项目列表项的数量
	 */
	public function getFirstChargeRules(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);

		$checkToken=\App\checkToken($uid,$token);

		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Charge();
		$res=$domain->getFirstChargeRules();
		$rs['info']['0']['list']=$res;

		$configpri=\App\getConfigPri();
		$switch=$configpri['firstcharge_repeatedly'];
		$has_used='0';
		if(!$switch){
			$firstcharge_used=\App\checkUserFirstCharge($uid);
			if($firstcharge_used){
				$has_used='1';
			}
		}

		$rs['info']['0']['has_used']=$has_used;
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
