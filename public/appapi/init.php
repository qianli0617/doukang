<?php
/**
 * 统一初始化
 */
/*error_reporting(E_ALL);
ini_set('display_errors', 'On');*/

// 定义项目路径
defined('API_ROOT') || define('API_ROOT', dirname(__FILE__) . '/../../phalapi');

// 运行模式，可以是：dev, test, prod
defined('API_MODE') || define('API_MODE', 'prod');

// 引入composer
require_once API_ROOT . '/vendor/autoload.php';

// 时区设置
date_default_timezone_set('Asia/Shanghai');

// 引入DI服务
include API_ROOT . '/config/di.php';

// 调试模式
if (\PhalApi\DI()->debug) {
    // 启动追踪器
    \PhalApi\DI()->tracer->mark('PHALAPI_INIT');

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

// 翻译语言包设定-简体中文
//\PhalApi\SL(isset($_COOKIE['language']) ? $_COOKIE['language'] : 'zh_cn');

//语言包
if(isset($_REQUEST['language'])){
    \PhalApi\DI()->language=$_REQUEST['language'];

    if($_REQUEST['language']=='en'){
        \PhalApi\SL('en');
    }else{
        \PhalApi\SL('zh-cn');
    }

}else{
    \PhalApi\SL('zh-cn');
}

// English
// \PhalApi\SL('en');
