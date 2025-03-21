<?php

namespace app\wxshare\controller;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use cmf\controller\HomeBaseController;

class LoginController extends HomebaseController
{
	public function index()
	{
		$aliToken = $this->request->param('token', '');
		if (!$aliToken) {
			return json_encode(array('ret' => 200, 'data' => ['code' => 0, 'msg' => '缺少token', 'info' => []],'msg' => ''));
		}
		$countryCode = $this->request->param('country_code', 86);
		$source = $this->request->param('source', 'pc');
		
		$rs = array('ret' => 200, 'data' => ['code' => 0, 'msg' => '登录/注册成功', 'info' => []],'msg' => '');
	
		$aliRes = $this->aliLoginGetMobile($aliToken);
		if($aliRes['status'] === 'success'){
			if(isset($aliRes['data']['Code']) && $aliRes['data']['Code'] === 'OK') {
				$telphone = $aliRes['data']['GetMobileResultDTO']['Mobile'];//得到手机号
//				$countryCode = 86;
//			   	$telphone = 1599012426;
				$resJson=$this->findMobile($countryCode,$telphone);
				$res = json_decode($resJson,true);
				if ($res['data']==1){
					$info = $this->findUserInfo($countryCode,$telphone);
					$data= json_decode($info,true)['data'];
					if($data==1005){
						$rs['data']['code'] = 1005;
						$rs['data']['msg'] = '请先下麦再登录';
						return $rs;
					}else if($data==1002){
						$rs['data']['code'] = 1002;
						$rs['data']['msg'] = '该账号已被禁用';
						return $rs;
					}else if($data==1003){
						$rs['data']['code'] = 1003;
						$rs['data']['msg'] = '该账号已被禁用';
						return $rs;
					}else if($data==1004){
						$rs['data']['code'] = 1004;
						$rs['data']['msg'] =  '该账号已注销';
						return $rs;
					}else if($data==1001){
						$rs['data']['code'] = 1001;
						$rs['data']['msg'] =  '该账号已被禁用';
						return json_encode($rs);
					}
					$rs['data']['info'] = $data;
					return json_encode($rs);
				}else{
					$info = $this->addUserInfo($countryCode,$telphone,$source);
					$data = json_decode($info,true)['data'];
					if ($data ==1007){
						$rs['data']['code'] = 1007;
						$rs['data']['msg'] =  '注册失败，请重试';
					}
					
					$rs['data']['info'] = $data;
					return json_encode($rs);
				}
			}

			$rs['data']['code'] = $aliRes['data']['Code'];
			$rs['data']['msg'] = $aliRes['data']['Message'];
			return json_encode($rs);

		}
		
		$rs['data']['code'] = $aliRes['data']['Code'];
		$rs['data']['msg'] = '失败';
		return json_encode($rs);
	
	}
	
	
	function aliLoginGetMobile($token = '')
	{
		$accessKeyId = 'ceshi';
		$accessKeySecret = 'ceshi';
		AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
			->regionId('cn-hangzhou')
			->asDefaultClient();
		
		try {
			$result = AlibabaCloud::rpc()
				->product('Dypnsapi')
				->scheme('https') // https | http
				->version('2017-05-25')
				->action('GetMobile')
				->method('POST')
				->host('dypnsapi.aliyuncs.com')
				->options([
					'query' => [
						'RegionId' => 'cn-hangzhou',
						'AccessToken' => $token
					],
				])
				->request();
			
			return array('status' => 'success', 'data' => $result->toArray());
		} catch (ClientException $e) {
			return array('status' => 'failed', 'code' => $e->getErrorCode(), 'msg' => $e->getErrorMessage());
		} catch (ServerException $e) {
			return array('status' => 'failed', 'code' => $e->getErrorCode(), 'msg' => $e->getErrorMessage());
		}
	}
	
	private function getUrl($url,$data)
	{
		$urlPost = 'https://www.doukang.shop/' . $url;
		return $this->httpRequest($urlPost, json_encode($data, JSON_THROW_ON_ERROR), 'POST', ['Content-Type: application/json']);
	}
	
	function httpRequest($url, $params = [], $method = 'GET', $headers = [])
	{
		$ch = curl_init();
		
		if ($method == 'GET') {
			$url .= '?' . http_build_query($params);
		}
		
		curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
		]);
		
		if (!empty($headers)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}
		
		$output = curl_exec($ch);
		
		if ($output === false) {
			// 请求失败时处理错误
			$error = curl_error($ch);
			curl_close($ch);
			return $error;
		}
		
		curl_close($ch);
		return $output;
	}
	
	private function findMobile($countryCode, $telphone)
	{
		$data = [
			'country_code' => $countryCode,
			'mobile' => $telphone,
		];
		return $this->getUrl('appapi/?s=App.Login.FindMobile', $data);
	}
	
	private function findUserInfo($countryCode, $telphone)
	{
		$data = [
			'country_code' => $countryCode,
			'mobile' => $telphone,
		];
		return $this->getUrl('appapi/?s=App.Login.FindUserInfo', $data);
	}
	
	private function addUserInfo($countryCode, $telphone, $source)
	{
		$data = [
			'country_code' => $countryCode,
			'mobile' => $telphone,
			'source' => $source,
		];
		return $this->getUrl('appapi/?s=App.Login.AddUserInfo', $data);
	}
	
	private function getUserban(int $telphone)
	{
		$userinfo=\PhalApi\DI()->notorm->user
			->select('id,end_bantime')
			->where('openid=? and login_type=? ',$openid,$type)
			->fetchOne();
		
		$rs=$this->baninfo($userinfo['id'],$userinfo['end_bantime']);
	}
	
}
