<?php
namespace App\Domain;
use App\Model\Paidprogram as Model_Paidprogram;

class Paidprogram {
	public function getApplyStatus($uid) {
		$rs = array();

		$model = new Model_Paidprogram();
		$rs = $model->getApplyStatus($uid);

		return $rs;
	}

	public function apply($uid){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->apply($uid);

		return $rs;
	}

	//获取付费分类列表
	public function getPaidprogramClassList(){
		$key="getPaidClass";

		$list=\App\getcaches($key);

		if(!$list){
			$model=new Model_Paidprogram();
			$list=$model->getPaidprogramClassList();
			if(!$list){
				\App\setcaches($key,$list);
			}	
		}

		//语言包
		$language=\PhalApi\DI()->language;
		foreach ($list as $k => $v) {
			if($language=='en'){
				$list[$k]['name']=$v['name_en'];
			}

			unset($list[$k]['name_en']);
		}

		return $list;
	}

	//添加付费项目
	public function addPaidProgram($data){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->addPaidProgram($data);

		return $rs;
	}

	//获取付费项目详情
	public function getPaidProgramInfo($uid,$object_id){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->getPaidProgramInfo($uid,$object_id);

		return $rs;
	}

	//获取我上传的付费项目
	public function getMyPaidProgram($uid,$p){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->getMyPaidProgram($uid,$p);

		return $rs;
	}

	//创建订单
	public function getOrderId($orderinfo){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->getOrderId($orderinfo);

		return $rs;
	}

	//余额支付
	public function balancePay($uid,$orderinfo){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->balancePay($uid,$orderinfo);

		return $rs;
	}

	//获取购买列表
	public function getPaidProgramList($uid,$p){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->getPaidProgramList($uid,$p);

		return $rs;
	}

	//对付费内容发布评价
	public function setComment($uid,$object_id,$grade){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->setComment($uid,$object_id,$grade);

		return $rs;
	}


	//其他类获取付费项目详情
	public function getPaidProgram($where=[]){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->getPaidProgram($where);

		return $rs;
	}

	//关键词搜索
	public function searchPaidProgram($uid,$keywords,$p){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->searchPaidProgram($uid,$keywords,$p);

		return $rs;
	}

	public function getHomePaidprogram($uid,$touid,$p){
		$rs = array();

		$model = new Model_Paidprogram();

		$rs = $model->getHomePaidprogram($uid,$touid,$p);

		return $rs;
	}
	
}
