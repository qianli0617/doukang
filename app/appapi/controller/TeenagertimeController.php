<?php
/**
 * 直播回放
 */
namespace app\appapi\controller;

use cmf\controller\HomeBaseController;
use think\facade\Db;

class TeenagertimeController extends HomebaseController {
	
	
	public function index(){
		Db::name('user_teenager_time')->delete(true);
	}

}