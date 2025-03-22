<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Wxmini as Domain_Wxmini;
/**
 * 微信小程序接口
 */
class Wxmini extends Api {
	public function getRules() {
		return array(
			
			'uploadImg'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'file' => array('name' => 'file','type' => 'file', 'min' => 0, 'max' => 1024 * 1024 * 30, 'range' => array('image/jpg', 'image/jpeg', 'image/png'), 'ext' => array('jpg', 'jpeg', 'png')),
			),

			'getAuth'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
			),

			'userAuth'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'username' => array('name' => 'username', 'type' => 'string', 'require' => true, 'desc' => '用户姓名'),
				'mobile' => array('name' => 'mobile', 'type' => 'string', 'require' => true, 'desc' => '用户手机号码'),
				'cardno' => array('name' => 'cardno', 'type' => 'string', 'require' => true, 'desc' => '用户身份证号码'),
				'sf_positive' => array('name' => 'sf_positive', 'type' => 'string', 'require' => true, 'desc' => '身份证正面'),
				'sf_back' => array('name' => 'sf_back', 'type' => 'string', 'require' => true, 'desc' => '身份证反面'),
				'sf_hands' => array('name' => 'sf_hands', 'type' => 'string', 'require' => true, 'desc' => '手持身份证'),
			),
			'profitList'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'p' => array('name' => 'p', 'type' => 'int',  'desc' => '页数'),
			),
			'goodsOrderRefundConsult'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'orderid' => array('name' => 'orderid', 'type' => 'int', 'require' => true, 'desc' => '订单id'),
				'user_type' => array('name' => 'user_type', 'type' => 'string', 'require' => true, 'desc' => '用户身份 buyer 买家 seller 卖家'),
			),
			'getOrderExpressInfo'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'orderid' => array('name' => 'orderid', 'type' => 'int', 'require' => true, 'desc' => '订单id'),
				'user_type' => array('name' => 'user_type', 'type' => 'string', 'require' => true, 'desc' => '用户身份 buyer 买家 seller 卖家'),
			),
			'getShopCashRecord'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'p' => array('name' => 'p', 'type' => 'int',  'desc' => '页数'),
			),
			'uploadFiles'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'file' => array('name' => 'file','type' => 'file', 'min' => 0, 'max' => 1024 * 1024 * 30),
			),
			'createM3u8Pull'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'qiniu_sign' => array('name' => 'qiniu_sign', 'type' => 'string','desc' => '七牛sign'),
			),

			
		);
	}

	/**
	 * 微信小程序获取M3U8播流地址
	 * @desc 用于微信小程序获取M3U8播流地址
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function createM3u8Pull(){
		$rs = array('code' => 0 , 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);
		$qiniu_sign=\App\checkNull($this->qiniu_sign);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		file_put_contents("qiniusign.txt", json_encode($qiniu_sign));
		$pull=urldecode(\App\PrivateKeyA('http',$stream.'.flv',0));
		$rs['info'][0]['pull']=$pull;
		return $rs;
	}

	/**
	 * 微信小程序上传单张图片【废弃】
	 * @desc 用于微信小程序上传单张图片
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */

	private function uploadImg(){
		
		$rs = array('code' => 0 , 'msg' => '图片上传成功', 'info' => array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		if (!isset($_FILES['file'])) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T("请选择上传文件");
			return $rs;
		}

		if ($_FILES["file"]["error"] > 0) {
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T("上传失败:").$_FILES['file']['error'];
			return $rs;
		}

		$uptype=\App\getcaches('app.uptype');

		if($uptype==1){
			//七牛
			$url = \PhalApi\DI()->qiniu->uploadFile($_FILES['file']['tmp_name']);

			if (!empty($url)) {
				$space_host=\PhalApi\DI()->config->get('app.Qiniu.space_host');
				$data=array(
					"image"=>$url,
					"image_name"=>str_replace($space_host.'/','',$url),
				);

				
			}
		}else if($uptype==2){
			//本地上传
			//设置上传路径 设置方法参考3.2
			\PhalApi\DI()->ucloud->set('save_path','avatar/'.date("Ymd"));

			//上传表单名
			$res = \PhalApi\DI()->ucloud->upfile($_FILES['file']);
			
			$files='../upload'.$res['file']; 
			$PhalApi_Image = new Image_Lite();
			//打开图片
			$PhalApi_Image->open($files);

			// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
			
			$PhalApi_Image->thumb(600, 600, IMAGE_THUMB_SCALING);
			$PhalApi_Image->save($files);			
			
			$avatar=  '/upload'.$res['file']; //600 X 600

			$data=array(
				"image"=>\App\get_upload_path($avatar),
				"image_name"=>$avatar,
			);
            
			
		}
		
		@unlink($_FILES['file']['tmp_name']);
        if(!$data){
            $rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('上传失败，请稍候重试');
			return $rs;
        }


		$rs['info'][0] = $data;

		return $rs;
		
		
	}
	/**
	 * 微信小程序获取认证信息
	 * @desc 用于微信小程序获取认证信息
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function getAuth(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		$domain=new Domain_Wxmini();
		$res=$domain->getAuth($uid);

		$rs['info'][0]=$res;
		return $rs;

	}
	/**
	 * 微信小程序用户认证
	 * @desc 微信小程序用户认证
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function userAuth() {
		$rs = array('code' => 0, 'msg' => \PhalApi\T('认证信息提交成功,请耐心等待审核'), 'info' => array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$username=\App\checkNull($this->username);
		$mobile=\App\checkNull($this->mobile);
		$cardno=\App\checkNull($this->cardno);
		$front_view=\App\checkNull($this->sf_positive);
		$back_view=\App\checkNull($this->sf_back);
		$handset_view=\App\checkNull($this->sf_hands);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$username_isok=\App\checkUsername($username);
        if($username_isok){
            $rs['code']=1001;
            $rs['msg']=\PhalApi\T('请正确填写真实姓名');
            return $rs;
        }

        $mobile_isok=\App\checkMobile($mobile);
        if(!$mobile_isok){
        	$rs['code']=1002;
            $rs['msg']=\PhalApi\T('请正确填写手机号码');
            return $rs;
        }

        $cardno_isok=\App\isCreditNo($cardno);
        if (!$cardno_isok) {
        	$rs['code']=1003;
            $rs['msg']=\PhalApi\T('身份证号不合法');
            return $rs;
        }

        if(!$front_view){
        	$rs['code']=1004;
            $rs['msg']=\PhalApi\T('请上传证件正面图片');
            return $rs;
        }
        if(!$back_view){
        	$rs['code']=1004;
            $rs['msg']=\PhalApi\T('请上传证件背面图片');
            return $rs;
        }
        $configpub=\App\getConfigPub();
        $wxmini_version=$configpub['wxmini_version'];
        $wxmini_shelves_version=$configpub['wxmini_shelves_version'];

        if($wxmini_version!=$wxmini_shelves_version){ //小程序不上架时，判断手持身份证
        	if(!$handset_view){
	        	$rs['code']=1004;
	            $rs['msg']=\PhalApi\T('请上传手持证件正面照');
	            return $rs;
	        }
        }
        

        $data=array(
        	'uid'=>$uid,
        	'real_name'=>$username,
        	'mobile'=>$mobile,
        	'cer_no'=>$cardno,
        	'front_view'=>$front_view,
        	'back_view'=>$back_view,
        	'handset_view'=>$handset_view,
        	'addtime'=>time()

        );

        $domain=new Domain_Wxmini();
        $res=$domain->userAuth($data);
        if($res==1001){
        	$rs['code']=1005;
            $rs['msg']=\PhalApi\T('请等待管理员审核');
            return $rs;
        }
        if($res==1002){
        	$rs['code']=1006;
            $rs['msg']=\PhalApi\T('认证审核已通过');
            return $rs;
        }
        
        if($res==1004){
        	$rs['code']=1006;
            $rs['msg']=\PhalApi\T('认证信息提交失败,请重试');
            return $rs;
        }

		return $rs;
	}



	
	/**
	 * 微信小程序获取用户的映票提现记录
	 * @desc 用于微信小程序获取用户的映票提现记录
	 * @return int code 操作码，0表示成功， 1表示用户不存在
	 * @return array info 
	 * @return array info[0] 用户信息
	 * @return int info[0].id 用户ID
	 * @return string info[0].level 等级
	 * @return string info[0].lives 直播数量
	 * @return string info[0].follows 关注数
	 * @return string info[0].fans 粉丝数
	 * @return string info[0].agent_switch 分销开关
	 * @return string info[0].family_switch 家族开关
	 * @return string msg 提示信息
	 */
	public function profitList() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$p=\App\checkNull($this->p);
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain = new Domain_Wxmini();
		$info = $domain->profitList($uid,$p);
        $rs['info']=$info;

		return $rs;
	}

	/**
	 * 微信小程序获取订单退款协商历史
	 * @desc 用于微信小程序获取订单退款协商历史
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function goodsOrderRefundConsult() {
		$rs = array('code' => 0 , 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$orderid=\App\checkNull($this->orderid);
		$user_type=\App\checkNull($this->user_type);

		if(!$uid || !$token || !$orderid || !in_array($user_type, ['buyer','seller'])){
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

		$domain=new Domain_Wxmini();
		$res=$domain->goodsOrderRefundConsult($uid,$orderid,$user_type);

		if($res==1001){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('订单不存在');
			return $rs;
		}else if($res==1002){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('订单没有发起退款申请');
			return $rs;
		}


		$rs['info'][0] = $res;

		return $rs;

	}


	/**
	 * 微信小程序获取订单物流信息
	 * @desc 用于微信小程序获取订单物流信息
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */
	public function getOrderExpressInfo(){
		$rs=array('code'=>0,'msg'=>'','info'=>array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$orderid=\App\checkNull($this->orderid);
		$user_type=\App\checkNull($this->user_type);

		if(!$uid || !$token || !$orderid || !in_array($user_type, ['buyer','seller'])){
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

		$domain=new Domain_Wxmini();
		$res=$domain->getOrderExpressInfo($uid,$orderid,$user_type);

		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('订单不存在');
			return $rs;
		}else if($res==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('订单未发货');
			return $rs;
		}else if($res==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('物流参数错误');
			return $rs;
		}else if($res==1004){
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('物流查询失败');
			return $rs;
		}

		$rs['info'][0]=$res;
		return $rs;
	}

	/**
	 * 微信小程序获取提现记录
	 * @desc 用于微信小程序获取提现记录
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return int info[].id 提现记录id
	 * @return int info[].uid 提现记录用户id
	 * @return float info[].money 提现记录金额
	 * @return string info[].orderno 提现记录订单编号
	 * @return string info[].trade_no 提现记录交易单号
	 * @return int info[].status 提现记录状态
	 * @return string info[].addtime 提现记录提交时间
	 * @return int info[].type 提现记录类型
	 * @return string info[].account_bank 提现记录银行名称
	 * @return string info[].account 提现记录账号
	 * @return string info[].status_name 提现记录状态说明
	 * @return string info[].type_name 提现记录类型名称
	 * @return string msg 提示信息
	 */
	public function getShopCashRecord(){
		$rs=array('code'=>0,'msg'=>'','info'=>array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$p=\App\checkNull($this->p);

		if(!$uid || !$token){
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

		$domain=new Domain_Wxmini();
		$res=$domain->getShopCashRecord($uid,$p);
		$rs['info']=$res;
		return $rs;

	}

	/**
	 * 微信小程序上传单个文件【废弃】
	 * @desc 用于微信小程序上传单个文件
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string msg 提示信息
	 */

	private function uploadFiles(){
		
		$rs = array('code' => 0 , 'msg' => \PhalApi\T('文件上传成功'), 'info' => array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$checkToken=\App\checkToken($uid,$token);

		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		if (!isset($_FILES['file'])) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T("请选择上传文件");
			return $rs;
		}

		if ($_FILES["file"]["error"] > 0) {
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T("上传失败:").$_FILES['file']['error'];
			return $rs;
		}

		$uptype=\App\getcaches('app.uptype');

		if($uptype==1){
			//七牛
			$url = \PhalApi\DI()->qiniu->uploadFile($_FILES['file']['tmp_name']);

			if (!empty($url)) {
				$space_host=\PhalApi\DI()->config->get('app.Qiniu.space_host');
				$data=array(
					"file"=>$url,
					"file_name"=>str_replace($space_host.'/','',$url),
				);

				
			}
		}else if($uptype==2){
			//本地上传
			//设置上传路径 设置方法参考3.2
			\PhalApi\DI()->ucloud->set('save_path','avatar/'.date("Ymd"));

			//上传表单名
			$res = \PhalApi\DI()->ucloud->upfile($_FILES['file']);
			
			$files='../upload'.$res['file']; 
			$PhalApi_Image = new Image_Lite();
			//打开图片
			$PhalApi_Image->open($files);

			// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
			
			$PhalApi_Image->thumb(600, 600, IMAGE_THUMB_SCALING);
			$PhalApi_Image->save($files);			
			
			$avatar=  '/upload'.$res['file']; //600 X 600

			$data=array(
				"file"=>\App\get_upload_path($avatar),
				"file_name"=>$avatar,
			);
            
			
		}
		
		@unlink($_FILES['file']['tmp_name']);
        if(!$data){
            $rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('上传失败，请稍候重试');
			return $rs;
        }


		$rs['info'][0] = $data;

		return $rs;
		
		
	}
	
    
}
