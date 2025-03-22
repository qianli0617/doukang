<?php

namespace App\Domain;
use App\Model\Red as Model_Red;

class Red {
	public function sendRed($data) {
		$rs = array();

		$model = new Model_Red();
		$rs = $model->sendRed($data);

		return $rs;
	}
	
	public function sendRedNew($data) {
		$rs = array();
		
		$model = new Model_Red();
		$rs = $model->sendRedNew($data);
		
		return $rs;
	}
	
	
	public function getRedList($liveuid,$showid) {
		$rs = array();

		$model = new Model_Red();
		$rs = $model->getRedList($liveuid,$showid);

		return $rs;
	}

	public function robRed($data) {
		$rs = array();

		$model = new Model_Red();
		$rs = $model->robRed($data);

		return $rs;
	}
	public function robRedNew($data)
	{
		$rs = array();
		
		$model = new Model_Red();
		$rs = $model->robRedNew($data);
		
		return $rs;
	}

	public function getRedInfo($redid) {
		$rs = array();

		$model = new Model_Red();
		$rs = $model->getRedInfo($redid);

		return $rs;
	}

	public function getRedRobList($redid) {
		$rs = array();

		$model = new Model_Red();
		$rs = $model->getRedRobList($redid);

		return $rs;
	}
	
	public function isEligibility($data)
	{
		$rs = array();
		
		$model = new Model_Red();
		$rs = $model->isEligibility($data);
		
		return $rs;
	}
	
}
