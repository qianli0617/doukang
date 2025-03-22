<?php

namespace App\Domain;
use App\Model\Login as Model_Login;

class Login {
	
    public function userLogin($country_code,$user_login,$user_pass) {
        $rs = array();

        $model = new Model_Login();
        $rs = $model->userLogin($country_code,$user_login,$user_pass);

        return $rs;
    }

    public function userReg($country_code,$user_login,$source) {
        $rs = array();
        $model = new Model_Login();
        $rs = $model->userReg($country_code,$user_login,$source);

        return $rs;
    }
	
    public function userFindPass($country_code,$user_login,$user_pass) {
        $rs = array();
        $model = new Model_Login();
        $rs = $model->userFindPass($country_code,$user_login,$user_pass);

        return $rs;
    }

    public function userLoginByThird($openid,$type,$nickname,$avatar,$source) {
        $rs = array();

        $model = new Model_Login();
        $rs = $model->userLoginByThird($openid,$type,$nickname,$avatar,$source);

        return $rs;
    }

	public function getUserban($user_login) {
        $rs = array();

        $model = new Model_Login();
        $rs = $model->getUserban($user_login);

        return $rs;
    }
	public function getThirdUserban($openid,$type) {
        $rs = array();

        $model = new Model_Login();
        $rs = $model->getThirdUserban($openid,$type);

        return $rs;
    }

    public function getCancelCondition($uid){
        $rs = array();

        $model = new Model_Login();
        $rs = $model->getCancelCondition($uid);

        return $rs;
    }

    public function cancelAccount($uid){
        $rs = array();

        $model = new Model_Login();
        $rs = $model->cancelAccount($uid);

        return $rs;
    }
	
	public function findMobile($countryCode,$mobile){
		return (new Model_Login())->findMobile($countryCode,$mobile);
	}
	
	public function findUserInfo($countryCode, $telphone)
	{
		return (new Model_Login())->findUserInfo($countryCode, $telphone);
	}
	
	public function addUserInfo($countryCode, $telphone,$source)
	{
		return (new Model_Login())->addUserInfo($countryCode, $telphone,$source);
	}
	
	public function newUsersReceiveCoin($uid)
	{
		$rs = array();
		
		$model = new Model_Login();
		$rs = $model->newUsersReceiveCoin($uid);
		
		return $rs;
	}
	
}
