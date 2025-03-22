<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Auth as Domain_Auth;
use function PhalApi\T;

/**
 * 实名认证
 */

class Auth extends Api {

	public function getRules() {
		return array(

			'getAuth'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
			),
			'setAuth'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'real_name' => array('name' => 'real_name', 'type' => 'string', 'require' => true, 'desc' => '真实姓名'),
				'mobile' => array('name' => 'mobile', 'type' => 'string', 'require' => true, 'desc' => '手机号'),
				'cer_no' => array('name' => 'cer_no', 'type' => 'string', 'require' => true, 'desc' => '身份证号'),
				'front_view' => array('name' => 'front_view', 'type' => 'string', 'desc' => '证件正面'),
				'back_view' => array('name' => 'back_view', 'type' => 'string',  'desc' => '证件反面'),
				'handset_view' => array('name' => 'handset_view', 'type' => 'string', 'desc' => '手持证件照'),
			),
		);
	}


	/**
	 * 获取用户认证信息
	 * @desc 用于获取用户认证信息
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string msg 提示信息
	 */
	public function getAuth() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}else if($checkToken==10020){
			$rs['code'] = 700;
			$rs['msg'] = T('该账号已被禁用');
			return $rs;
		}
		
		$domain = new Domain_Auth();
		$info = $domain->getAuth($uid);
		
		
		$rs['info'][0]=$info;
		
		
		return $rs;
	}
	/**
	 * 用户提交认证信息
	 * @desc 用于用户提交认证信息
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string msg 提示信息
	 */
	public function setAuth() {
		$rs = array('code' => 0, 'msg' => T('提交成功,官方飞速审核中'), 'info' => array());

		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$real_name=\App\checkNull($this->real_name);
		$mobile=\App\checkNull($this->mobile);
		$cer_no=\App\checkNull($this->cer_no);
		$front_view=\App\checkNull($this->front_view);
		$back_view=\App\checkNull($this->back_view);
		$handset_view=\App\checkNull($this->handset_view);
		

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}else if($checkToken==10020){
			$rs['code'] = 700;
			$rs['msg'] = T('该账号已被禁用');
			return $rs;
		}

		if($real_name==''){
			$rs['code'] = 1001;
			$rs['msg'] = T('请填写真实姓名');
			return $rs;
		}

		if(mb_strlen($real_name)>10){
			$rs['code'] = 1001;
			$rs['msg'] = T('姓名长度在10个字符以内');
			return $rs;
		}

		if($cer_no==''){
			$rs['code'] = 1001;
			$rs['msg'] = T('请输入身份证号码');
			return $rs;
		}

		if(!\App\isCreditNo($cer_no)){
        	$rs['code']=1001;
        	$rs['msg']= T('身份证号不合法');
        	return $rs;
        }

		//$ismobile=checkMobile($mobile);

		if($mobile==''){
			$rs['code'] = 1001;
			$rs['msg'] = T('请输入正确手机号码');
			return $rs;
		}

//		if($front_view==''){
//			$rs['code'] = 1001;
//			$rs['msg'] = \PhalApi\T('请上传证件正面');
//			return $rs;
//		}
//
//		if($back_view==''){
//			$rs['code'] = 1001;
//			$rs['msg'] = \PhalApi\T('请上传证件反面');
//			return $rs;
//		}
//
//		if($handset_view==''){
//			$rs['code'] = 1001;
//			$rs['msg'] = \PhalApi\T('请上传手持证件正面照');
//			return $rs;
//		}
		

		$data=[
			'uid'=>$uid,
			'real_name'=>$real_name,
			'mobile'=>$mobile,
			'cer_no'=>$cer_no,
			'front_view'=>$front_view,
			'back_view'=>$back_view,
			'handset_view'=>$handset_view,
			'addtime'=>time(),
			'reason'=>'',
			'status'=>'0',
		];
		$domain = new Domain_Auth();
		$info = $domain->setAuth($data);
		if(!$info){
			$rs['code'] = 1001;
			$rs['msg'] = T('提交失败,请稍后重试!');
			return $rs;
		}
		unset($data['reason']);
		unset($data['addtime']);
		//处理图片路径
		if($data['front_view']){
			$data['front_view']=\App\get_upload_path($data['front_view']);
		}
		if ($data['back_view']){
			$data['back_view']=\App\get_upload_path($data['back_view']);
		}
		if ($data['handset_view']){
			$data['handset_view']=\App\get_upload_path($data['handset_view']);
		}
		
		$rs['info'][0]=$data;
		
		return $rs;
	}
	

}
