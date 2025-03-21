<?php /*a:3:{s:106:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/admin/setting/configpri.html";i:1740476383;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <?php 
        $cmf_version=cmf_version();
        if (strpos(cmf_version(), '6.') === 0) {
            $_app=app()->http->getName();
        }else{
            $_app=request()->module();
        }
     ?>

    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: '<?php echo $_app; ?>'/*当前应用名*/
        };
    </script>
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/wind.js"></script>
    <script src="/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            console.log("弹窗信息");
            $("[data-toggle='tooltip']").tooltip({
                container: 'body',
                html: true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });

        });
    </script>
    
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>

<style>
.cdnhide{
	display:none;
}
.codehide{
	display:none;
}
.w-80{
    width: 80px;
    border:1px solid #0babd1;
}

</style>
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">基本设置</a></li>
        <li><a href="#B" data-toggle="tab">登录配置</a></li>
        <li><a href="#C" data-toggle="tab">直播配置</a></li>
        <li><a href="#D" data-toggle="tab">提现配置</a></li>
        <li><a href="#E" data-toggle="tab">腾讯云推送及IM配置</a></li>
        <li><a href="#F" data-toggle="tab">支付配置</a></li>
        <li><a href="#G" data-toggle="tab">邀请奖励</a></li>
        <li><a href="#H" data-toggle="tab">统计配置</a></li>
        <li><a href="#I" data-toggle="tab">视频配置</a></li>
        <li><a href="#J" data-toggle="tab">店铺/商品配置</a></li>
<!--        <li><a href="#K" data-toggle="tab">动态配置</a></li>-->
        <li><a href="#L" data-toggle="tab">游戏配置</a></li>
        <li><a href="#M" data-toggle="tab">物流配置</a></li>
        <li><a href="#N" data-toggle="tab">每日任务</a></li>
        <li><a href="#O" data-toggle="tab">云存储配置</a></li>
        <li><a href="#P" data-toggle="tab">openinstall配置</a></li>
		<li><a href="#Q" data-toggle="tab">游戏设置</a></li>
		<li><a href="#R" data-toggle="tab">新人奖励抖康币配置</a></li>
		<li><a href="#S" data-toggle="tab">直播权限说明</a></li>
    </ul>
    <form class="form-horizontal js-ajax-form margin-top-20" role="form" action="<?php echo url('setting/configpriPost'); ?>" method="post">
        <fieldset>
            <div class="tabbable">
                <div class="tab-content">
                    <div class="tab-pane active" id="A">
                        <div class="form-group">
                            <label for="input-family_switch" class="col-sm-2 control-label">家族控制</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[family_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['family_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-family_member_divide_switch" class="col-sm-2 control-label">家族长修改成员分成比例是否需要管理员审核</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[family_member_divide_switch]">
                                    <option value="0">否</option>
                                    <option value="1" <?php if($config['family_member_divide_switch'] == '1'): ?>selected<?php endif; ?>>是</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-service_switch" class="col-sm-2 control-label">在线客服</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[service_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['service_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-service_url" class="col-sm-2 control-label">客服链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-service_url"
                                       name="options[service_url]" value="<?php echo (isset($config['service_url']) && ($config['service_url'] !== '')?$config['service_url']:''); ?>">
                                       <p class="help-block">注册链接：http://www.53kf.com/reg/index?yx_from=210260</p>
                            </div>
                        </div>
						
						
						<div class="form-group">
                            <label for="input-list_coin_switch" class="col-sm-2 control-label">榜单金额</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[list_coin_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['list_coin_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
								<p class="help-block">榜单金额金额展示开关：开启展示，关闭则不展示</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-sensitive_words" class="col-sm-2 control-label">敏感词</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-sensitive_words" name="options[sensitive_words]" ><?php echo (isset($config['sensitive_words']) && ($config['sensitive_words'] !== '')?$config['sensitive_words']:''); ?></textarea><p class="help-block">设置多个敏感字，请用英文状态下逗号隔开</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="1">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="B">
                        <div class="form-group">
                            <label for="input-reg_reward" class="col-sm-2 control-label">注册奖励</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-reg_reward"
                                       name="options[reg_reward]" value="<?php echo (isset($config['reg_reward']) && ($config['reg_reward'] !== '')?$config['reg_reward']:''); ?>">
                                       <p class="help-block">新用户注册奖励<?php echo $name_coin; ?>（整数）</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-bonus_switch" class="col-sm-2 control-label">登录奖励开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[bonus_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['bonus_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-login_wx_pc_appid" class="col-sm-2 control-label">PC 微信登录APPID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_wx_pc_appid" name="options[login_wx_pc_appid]" value="<?php echo (isset($config['login_wx_pc_appid']) && ($config['login_wx_pc_appid'] !== '')?$config['login_wx_pc_appid']:''); ?>">
                                <p class="help-block">PC 微信登录APPID（微信开放平台网站应用 APPID） </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-login_wx_pc_appsecret" class="col-sm-2 control-label">PC 微信登录appsecret</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_wx_pc_appsecret" name="options[login_wx_pc_appsecret]" value="<?php echo (isset($config['login_wx_pc_appsecret']) && ($config['login_wx_pc_appsecret'] !== '')?$config['login_wx_pc_appsecret']:''); ?>">
                                <p class="help-block">PC 微信登录appsecret（微信开放平台 网站应用 AppSecret） </p>
                            </div>
                        </div>
                        
                        <!-- <div class="form-group">
                            <label for="input-login_sina_pc_akey" class="col-sm-2 control-label">PC微博登陆akey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_sina_pc_akey" name="options[login_sina_pc_akey]" value="<?php echo (isset($config['login_sina_pc_akey']) && ($config['login_sina_pc_akey'] !== '')?$config['login_sina_pc_akey']:''); ?>">  PC 微信登录appsecret（微信开放平台网页应用 AppSecret）
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-login_sina_pc_skey" class="col-sm-2 control-label">PC新浪微博skey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_sina_pc_skey" name="options[login_sina_pc_skey]" value="<?php echo (isset($config['login_sina_pc_skey']) && ($config['login_sina_pc_skey'] !== '')?$config['login_sina_pc_skey']:''); ?>">  PC 微信登录appsecret（微信开放平台网页应用 AppSecret）
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="input-login_wx_appid" class="col-sm-2 control-label">微信公众平台APPID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_wx_appid" name="options[login_wx_appid]" value="<?php echo (isset($config['login_wx_appid']) && ($config['login_wx_appid'] !== '')?$config['login_wx_appid']:''); ?>">
                                <p class="help-block">微信公众平台==》开发==》基本配置==》APPID</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-login_wx_appsecret" class="col-sm-2 control-label">微信公众平台AppSecret</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_wx_appsecret" name="options[login_wx_appsecret]" value="<?php echo (isset($config['login_wx_appsecret']) && ($config['login_wx_appsecret'] !== '')?$config['login_wx_appsecret']:''); ?>">
                                <p class="help-block">微信公众平台==》开发==》基本配置==》AppSecret</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_qq_appid" class="col-sm-2 control-label">QQ互联移动应用APPID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_qq_appid" name="options[login_qq_appid]" value="<?php echo (isset($config['login_qq_appid']) && ($config['login_qq_appid'] !== '')?$config['login_qq_appid']:''); ?>">
                                <p class="help-block">QQ互联==》应用管理==》移动应用==》APPID</p>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="input-ihuyi_account" class="col-sm-2 control-label">互亿无线APIID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-ihuyi_account" name="options[ihuyi_account]" value="<?php echo (isset($config['ihuyi_account']) && ($config['ihuyi_account'] !== '')?$config['ihuyi_account']:''); ?>"> 短信验证码   http://www.ihuyi.com/  互亿无线后台-》验证码、短信通知-》账号及签名->APIID
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-ihuyi_ps" class="col-sm-2 control-label">互亿无线key</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-ihuyi_ps" name="options[ihuyi_ps]" value="<?php echo (isset($config['ihuyi_ps']) && ($config['ihuyi_ps'] !== '')?$config['ihuyi_ps']:''); ?>">  短信验证码 互亿无线后台-》验证码、短信通知-》账号及签名->APIKEY
                            </div>
                        </div> -->
                        
                        <div class="form-group">
                            <label for="input-sendcode_switch" class="col-sm-2 control-label">短信验证码开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[sendcode_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['sendcode_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                                <p class="help-block">短信验证码开关,关闭后不再发送真实验证码，采用默认验证码123456</p>
                            </div>
                        </div>
                       
						
                        <div class="form-group">
                            <label for="input-typecode_switch" class="col-sm-2 control-label">短信接口平台</label>
                            <div class="col-md-6 col-sm-10" id="duanxin">
                                <label class="radio-inline"><input type="radio" value="1" name="options[typecode_switch]" <?php if(in_array(($config['typecode_switch']), explode(',',"1"))): ?>checked="checked"<?php endif; ?>>阿里云</label>
                                <label class="radio-inline"><input type="radio" value="2" name="options[typecode_switch]" <?php if(in_array(($config['typecode_switch']), explode(',',"2"))): ?>checked="checked"<?php endif; ?>>容联云</label>
                                <label class="radio-inline"><input type="radio" value="3" name="options[typecode_switch]" <?php if(in_array(($config['typecode_switch']), explode(',',"3"))): ?>checked="checked"<?php endif; ?>>腾讯云</label>
                            </div>
                        </div>
						
                        <div class=" code_bd <?php if($config['typecode_switch'] != '1'): ?>codehide<?php endif; ?>" id="typecode_switch_1">
                            <div class="form-group">
								<label for="input-aly_keyid" class="col-sm-2 control-label">阿里云AccessKey ID</label>
								<div class="col-md-6 col-sm-10">
									<input type="text" class="form-control" id="input-aly_keyid" name="options[aly_keyid]" value="<?php echo (isset($config['aly_keyid']) && ($config['aly_keyid'] !== '')?$config['aly_keyid']:''); ?>">  阿里云控制台==》云通信-》短信服务==》 AccessKey ID
								</div>
							</div>

							<div class="form-group">
								<label for="input-aly_secret" class="col-sm-2 control-label">阿里云AccessKey Secret</label>
								<div class="col-md-6 col-sm-10">
									<input type="text" class="form-control" id="input-aly_secret" name="options[aly_secret]" value="<?php echo (isset($config['aly_secret']) && ($config['aly_secret'] !== '')?$config['aly_secret']:''); ?>">  阿里云控制台==》云通信-》短信服务==》 AccessKey Secret
								</div>
							</div>


                            <div class="form-group">
                                <label for="input-aly_sendcode_type" class="col-sm-2 control-label">阿里云短信发送区域</label>
                                <div class="col-md-6 col-sm-10">
                                    <label class="radio-inline"><input type="radio" name="options[aly_sendcode_type]" value="1" <?php if($config['aly_sendcode_type'] == '1'): ?>checked<?php endif; ?>>中国大陆</label>
                                    <label class="radio-inline"><input type="radio" name="options[aly_sendcode_type]" value="2" <?php if($config['aly_sendcode_type'] == '2'): ?>checked<?php endif; ?> >港澳台/国际</label>
                                    <label class="radio-inline"><input type="radio" name="options[aly_sendcode_type]" value="3" <?php if($config['aly_sendcode_type'] == '3'): ?>checked<?php endif; ?> >全球</label>
                                    <p class="help-block">如果选择全球，国内、国际/港澳台等信息都需要配置</p>
                                </div>
                            </div>

							<div class="form-group">
								<label for="input-aly_signName" class="col-sm-2 control-label">国内短信签名</label>
								<div class="col-md-6 col-sm-10">
									<input type="text" class="form-control" id="input-aly_signName" name="options[aly_signName]" value="<?php echo (isset($config['aly_signName']) && ($config['aly_signName'] !== '')?$config['aly_signName']:''); ?>">  阿里云控制台==》云通信==》短信服务==》国内消息==》签名管理
								</div>
							</div>

							<div class="form-group">
								<label for="input-aly_templateCode" class="col-sm-2 control-label">国内短信模板ID</label>
								<div class="col-md-6 col-sm-10">
									<input type="text" class="form-control" id="input-aly_templateCode" name="options[aly_templateCode]" value="<?php echo (isset($config['aly_templateCode']) && ($config['aly_templateCode'] !== '')?$config['aly_templateCode']:''); ?>">  阿里云控制台==》云通信==》短信服务==》国内消息==》 短信模板ID
								</div>
							</div>

							<div class="form-group">
								<label for="input-aly_hw_signName" class="col-sm-2 control-label">国际/港澳台短信签名</label>
								<div class="col-md-6 col-sm-10">
									<input type="text" class="form-control" id="input-aly_hw_signName" name="options[aly_hw_signName]" value="<?php echo (isset($config['aly_hw_signName']) && ($config['aly_hw_signName'] !== '')?$config['aly_hw_signName']:''); ?>">  阿里云控制台==》云通信-》短信服务==》国际/港澳台消息==》 签名管理
								</div>
							</div>

							<div class="form-group">
                                <label for="input-aly_hw_templateCode" class="col-sm-2 control-label">国际/港澳台短信模板ID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aly_hw_templateCode" name="options[aly_hw_templateCode]" value="<?php echo (isset($config['aly_hw_templateCode']) && ($config['aly_hw_templateCode'] !== '')?$config['aly_hw_templateCode']:''); ?>">  阿里云控制台==》云通信-》短信服务==》国际/港澳台消息==》 短信模板ID
                                </div>
                            </div>
                        
                        </div>
				
						<div class=" code_bd <?php if($config['typecode_switch'] != '2'): ?>codehide<?php endif; ?>" id="typecode_switch_2">
							<div class="form-group">
                                <label for="input-ccp_sid" class="col-sm-2 control-label">容联云ACCOUNT SID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ccp_sid" name="options[ccp_sid]" value="<?php echo (isset($config['ccp_sid']) && ($config['ccp_sid'] !== '')?$config['ccp_sid']:''); ?>">
                                    <p class="help-block">容联云控制台==》 ACCOUNT SID </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ccp_token" class="col-sm-2 control-label">容联云AUTH TOKEN</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ccp_token" name="options[ccp_token]" value="<?php echo (isset($config['ccp_token']) && ($config['ccp_token'] !== '')?$config['ccp_token']:''); ?>">
                                    <p class="help-block">容联云控制台==》 AUTH TOKEN </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ccp_appid" class="col-sm-2 control-label">容联云应用APPID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ccp_appid" name="options[ccp_appid]" value="<?php echo (isset($config['ccp_appid']) && ($config['ccp_appid'] !== '')?$config['ccp_appid']:''); ?>">
                                    <p class="help-block">容联云控制台==》 APPID </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ccp_tempid" class="col-sm-2 control-label">容联云短信模板ID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ccp_tempid" name="options[ccp_tempid]" value="<?php echo (isset($config['ccp_tempid']) && ($config['ccp_tempid'] !== '')?$config['ccp_tempid']:''); ?>">
                                    <p class="help-block">容联云控制台==》 短信模板ID </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="code_bd <?php if($config['typecode_switch'] != '3'): ?>cdnhide<?php endif; ?>" id="typecode_switch_3">

                            <div class="form-group">
                                <label for="input-tencent_sendcode_type" class="col-sm-2 control-label">腾讯云短信发送区域</label>
                                <div class="col-md-6 col-sm-10">
                                    <label class="radio-inline"><input type="radio" name="options[tencent_sendcode_type]" value="1" <?php if($config['tencent_sendcode_type'] == '1'): ?>checked<?php endif; ?>>中国大陆</label>
                                    <label class="radio-inline"><input type="radio" name="options[tencent_sendcode_type]" value="2" <?php if($config['tencent_sendcode_type'] == '2'): ?>checked<?php endif; ?> >港澳台/国际</label>
                                    <label class="radio-inline"><input type="radio" name="options[tencent_sendcode_type]" value="3" <?php if($config['tencent_sendcode_type'] == '3'): ?>checked<?php endif; ?> >全球</label>
                                    <p class="help-block">如果选择全球，国内、国际/港澳台等信息都需要配置</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tencent_sms_appid" class="col-sm-2 control-label">腾讯云短信SMS-AppID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tencent_sms_appid" name="options[tencent_sms_appid]" value="<?php echo (isset($config['tencent_sms_appid']) && ($config['tencent_sms_appid'] !== '')?$config['tencent_sms_appid']:''); ?>">
                                    <p class="help-block">腾讯云控制台==》短信-》应用管理-》应用列表==》 应用详情</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tencent_sms_appkey" class="col-sm-2 control-label">腾讯云短信SMS-AppKey</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tencent_sms_appkey" name="options[tencent_sms_appkey]" value="<?php echo (isset($config['tencent_sms_appkey']) && ($config['tencent_sms_appkey'] !== '')?$config['tencent_sms_appkey']:''); ?>">
                                    <p class="help-block">腾讯云控制台==》短信-》应用管理-》应用列表==》 应用详情</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tencent_sms_signName" class="col-sm-2 control-label">腾讯云短信国内签名</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tencent_sms_signName" name="options[tencent_sms_signName]" value="<?php echo (isset($config['tencent_sms_signName']) && ($config['tencent_sms_signName'] !== '')?$config['tencent_sms_signName']:''); ?>">
                                    <p class="help-block">腾讯云控制台==》短信-》国内短信==》 签名管理</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tencent_sms_templateCode" class="col-sm-2 control-label">腾讯云国内短信模板ID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tencent_sms_templateCode" name="options[tencent_sms_templateCode]" value="<?php echo (isset($config['tencent_sms_templateCode']) && ($config['tencent_sms_templateCode'] !== '')?$config['tencent_sms_templateCode']:''); ?>">
                                    <p class="help-block">腾讯云控制台==》短信-》国内短信==》 正文模板管理</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tencent_sms_hw_signName" class="col-sm-2 control-label">腾讯云短信国外签名</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tencent_sms_hw_signName" name="options[tencent_sms_hw_signName]" value="<?php echo (isset($config['tencent_sms_hw_signName']) && ($config['tencent_sms_hw_signName'] !== '')?$config['tencent_sms_hw_signName']:''); ?>">
                                    <p class="help-block">腾讯云控制台==》短信-》国际/港澳台短信==》 签名管理</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tencent_sms_hw_templateCode" class="col-sm-2 control-label">腾讯云国外短信模板ID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tencent_sms_hw_templateCode" name="options[tencent_sms_hw_templateCode]" value="<?php echo (isset($config['tencent_sms_hw_templateCode']) && ($config['tencent_sms_hw_templateCode'] !== '')?$config['tencent_sms_hw_templateCode']:''); ?>">
                                    <p class="help-block">腾讯云控制台==》短信-》国际/港澳台短信==》 正文模板管理</p>
                                </div>
                            </div>
                        
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="input-iplimit_switch" class="col-sm-2 control-label">短信验证码IP限制开关</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control" name="options[iplimit_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['iplimit_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-iplimit_times" class="col-sm-2 control-label">短信验证码IP限制次数</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-iplimit_times" name="options[iplimit_times]" value="<?php echo (isset($config['iplimit_times']) && ($config['iplimit_times'] !== '')?$config['iplimit_times']:''); ?>">
                                <p class="help-block">同一IP每天可以发送验证码的最大次数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="C">

                        <div class="form-group">
                            <label for="input-chatserver" class="col-sm-2 control-label">聊天服务器地址</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-chatserver" name="options[chatserver]" value="<?php echo (isset($config['chatserver']) && ($config['chatserver'] !== '')?$config['chatserver']:''); ?>">
                                <p class="help-block"> 格式：http://域名(:端口) 或者 http://IP(:端口)</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-auth_islimit" class="col-sm-2 control-label">认证限制</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[auth_islimit]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['auth_islimit'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                                <p class="help-block">主播开播是否需要身份认证</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-level_islimit" class="col-sm-2 control-label">直播等级控制</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[level_islimit]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['level_islimit'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                                <p class="help-block">直播等级控制是否开启</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-level_limit" class="col-sm-2 control-label">直播限制等级</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-level_limit" name="options[level_limit]" value="<?php echo (isset($config['level_limit']) && ($config['level_limit'] !== '')?$config['level_limit']:''); ?>">
                                <p class="help-block">直播等级限制开启时，最低开播等级（用户等级）</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-speak_limit" class="col-sm-2 control-label">发言等级限制</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-speak_limit" name="options[speak_limit]" value="<?php echo (isset($config['speak_limit']) && ($config['speak_limit'] !== '')?$config['speak_limit']:''); ?>">
                                <p class="help-block"> 用户等级低于该值时无法在直播间发言，0表示无限制</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-barrage_limit" class="col-sm-2 control-label">弹幕等级限制</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-barrage_limit" name="options[barrage_limit]" value="<?php echo (isset($config['barrage_limit']) && ($config['barrage_limit'] !== '')?$config['barrage_limit']:''); ?>">
                                <p class="help-block">用户等级低于该值时无法在直播间发弹幕，0表示无限制</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-barrage_fee" class="col-sm-2 control-label">弹幕费用</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-barrage_fee" name="options[barrage_fee]" value="<?php echo (isset($config['barrage_fee']) && ($config['barrage_fee'] !== '')?$config['barrage_fee']:''); ?>">
                                <p class="help-block">每条弹幕的价格（整数）</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-userlist_time" class="col-sm-2 control-label">用户列表请求间隔(秒)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-userlist_time" name="options[userlist_time]" value="<?php echo (isset($config['userlist_time']) && ($config['userlist_time'] !== '')?$config['userlist_time']:''); ?>"> <p class="help-block">直播间用户列表刷新间隔时间  注：不小于5s</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-mic_limit" class="col-sm-2 control-label">连麦等级限制</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-mic_limit" name="options[mic_limit]" value="<?php echo (isset($config['mic_limit']) && ($config['mic_limit'] !== '')?$config['mic_limit']:''); ?>">
                               <p class="help-block"> 0表示无限制</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-live_sdk" class="col-sm-2 control-label">模式选择</label>
                            <div class="col-md-6 col-sm-10" id="sdk">
                                <label class="radio-inline"><input type="radio" value="0" name="options[live_sdk]" <?php if(in_array(($config['live_sdk']), explode(',',"0"))): ?>checked="checked"<?php endif; ?>>直播模式</label>
                                <label class="radio-inline"><input type="radio" value="1" name="options[live_sdk]" <?php if(in_array(($config['live_sdk']), explode(',',"1"))): ?>checked="checked"<?php endif; ?>>直播+连麦模式</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-cdn_switch" class="col-sm-2 control-label">CDN</label>
                            <div class="col-md-6 col-sm-10" id="cdn">
                                <label class="radio-inline"><input type="radio" value="1" name="options[cdn_switch]" <?php if(in_array(($config['cdn_switch']), explode(',',"1"))): ?>checked="checked"<?php endif; if(in_array(($config['live_sdk']), explode(',',"1"))): ?>disabled<?php endif; ?>>阿里云</label>
                                <label class="radio-inline"><input type="radio" value="2" name="options[cdn_switch]" <?php if(in_array(($config['cdn_switch']), explode(',',"2"))): ?>checked="checked"<?php endif; ?>>腾讯云</label>
                                <label class="radio-inline"><input type="radio" value="3" name="options[cdn_switch]" <?php if(in_array(($config['cdn_switch']), explode(',',"3"))): ?>checked="checked"<?php endif; if(in_array(($config['live_sdk']), explode(',',"1"))): ?>disabled<?php endif; ?>>七牛云</label>
                                <label class="radio-inline"><input type="radio" value="4" name="options[cdn_switch]" <?php if(in_array(($config['cdn_switch']), explode(',',"4"))): ?>checked="checked"<?php endif; if(in_array(($config['live_sdk']), explode(',',"1"))): ?>disabled<?php endif; ?>>网宿</label>
                                <label class="radio-inline"><input type="radio" value="5" name="options[cdn_switch]" <?php if(in_array(($config['cdn_switch']), explode(',',"5"))): ?>checked="checked"<?php endif; if(in_array(($config['live_sdk']), explode(',',"1"))): ?>disabled<?php endif; ?>>网易云</label>
                                <label class="radio-inline"><input type="radio" value="6" name="options[cdn_switch]" <?php if(in_array(($config['cdn_switch']), explode(',',"6"))): ?>checked="checked"<?php endif; if(in_array(($config['live_sdk']), explode(',',"1"))): ?>disabled<?php endif; ?>>奥点云</label>
                            </div>
                        </div>

                        <div class="cdn_bd <?php if($config['cdn_switch'] != '1'): ?>cdnhide<?php endif; ?>" id="cdn_switch_1">
                             <div class="form-group">
                                <label for="input-push_url" class="col-sm-2 control-label">推流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-push_url" name="options[push_url]" value="<?php echo (isset($config['push_url']) && ($config['push_url'] !== '')?$config['push_url']:''); ?>">
                                    <p class="help-block">格式：域名(:端口) 或者 IP(:端口) 阿里云控制台==》视频直播==》域名管理==》推流域名</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-auth_key_push" class="col-sm-2 control-label">推流鉴权KEY</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-auth_key_push" name="options[auth_key_push]" value="<?php echo (isset($config['auth_key_push']) && ($config['auth_key_push'] !== '')?$config['auth_key_push']:''); ?>">
                                    <p class="help-block">阿里云控制台==》视频直播==》域名管理==》推流域名==》访问控制==》URL鉴权主KEY 留空表示不启用</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-auth_length_push" class="col-sm-2 control-label">推流鉴权有效时长</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-auth_length_push" name="options[auth_length_push]" value="<?php echo (isset($config['auth_length_push']) && ($config['auth_length_push'] !== '')?$config['auth_length_push']:''); ?>">
                                    <p class="help-block">阿里云控制台==》视频直播==》域名管理==》推流域名==》访问控制==》URL鉴权有效时长（秒）</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-pull_url" class="col-sm-2 control-label">播流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-pull_url" name="options[pull_url]" value="<?php echo (isset($config['pull_url']) && ($config['pull_url'] !== '')?$config['pull_url']:''); ?>">
                                    <p class="help-block">格式：域名(:端口) 或者 IP(:端口) 阿里云控制台==》视频直播==》域名管理==》播流域名</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-auth_key_pull" class="col-sm-2 control-label">播流鉴权KEY</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-auth_key_pull" name="options[auth_key_pull]" value="<?php echo (isset($config['auth_key_pull']) && ($config['auth_key_pull'] !== '')?$config['auth_key_pull']:''); ?>">
                                    <p class="help-block">阿里云控制台==》视频直播==》域名管理==》播流域名==》访问控制==》URL鉴权主KEY 留空表示不启用</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-auth_length_pull" class="col-sm-2 control-label">播流鉴权有效时长</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-auth_length_pull" name="options[auth_length_pull]" value="<?php echo (isset($config['auth_length_pull']) && ($config['auth_length_pull'] !== '')?$config['auth_length_pull']:''); ?>">
                                    <p class="help-block">阿里云控制台==》视频直播==》域名管理==》播流域名==》访问控制==》URL鉴权有效时长（秒）</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-aliy_key_id" class="col-sm-2 control-label">阿里云AccessKey ID</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aliy_key_id" name="options[aliy_key_id]" value="<?php echo (isset($config['aliy_key_id']) && ($config['aliy_key_id'] !== '')?$config['aliy_key_id']:''); ?>">
                                    <p class="help-block"> 回放用 不接入回放可不填写 阿里云控制台==》用户头像==》AccessKey管理==》AccessKey ID</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-aliy_key_secret" class="col-sm-2 control-label">阿里云AccessKey Secret</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aliy_key_secret" name="options[aliy_key_secret]" value="<?php echo (isset($config['aliy_key_secret']) && ($config['aliy_key_secret'] !== '')?$config['aliy_key_secret']:''); ?>">
                                    <p class="help-block"> 回放用 不接入回放可不填写 阿里云控制台==》用户头像==》AccessKey管理==》AccessKey Secret</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-aliy_playback_site" class="col-sm-2 control-label">阿里云回放视频域名</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aliy_playback_site" name="options[aliy_playback_site]" value="<?php echo (isset($config['aliy_playback_site']) && ($config['aliy_playback_site'] !== '')?$config['aliy_playback_site']:''); ?>">
                                    <p class="help-block"> 回放用 http(s)开头，结尾不带/</p>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="cdn_bd <?php if($config['cdn_switch'] != '2'): ?>cdnhide<?php endif; ?>" id="cdn_switch_2">
                            <div class="form-group">
                                <label for="input-tx_appid" class="col-sm-2 control-label">注意：</label>
                                <div class="col-md-6 col-sm-10">
                                    <p class="help-block" style="color:red;">1:确保配置直播信息的账号跟配置腾讯云IM的账号为同一账号,否则无法开播</p>
                                    <p class="help-block" style="color:red;">2:TRTC生成流使用的是腾讯云IM应用的sdkAPPID和密钥</p>
                                    <p class="help-block">3:APP主播推流使用TRTC推流</p>
                                    <p class="help-block">4:APP连麦时麦上用户使用TRTC推流,麦上用户使用TRTC播流</p>
                                    <p class="help-block">5:APP直播间普通观看用户使用rtmp播流</p>
                                    <p class="help-block">6:TRTC付费参考:<a target="_blank" href="https://cloud.tencent.com/document/product/647/17157">腾讯云</a></p>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-tx_appid" class="col-sm-2 control-label">腾讯云直播appid</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_appid" name="options[tx_appid]" value="<?php echo (isset($config['tx_appid']) && ($config['tx_appid'] !== '')?$config['tx_appid']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-tx_bizid" class="col-sm-2 control-label">腾讯云直播bizid</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_bizid" name="options[tx_bizid]" value="<?php echo (isset($config['tx_bizid']) && ($config['tx_bizid'] !== '')?$config['tx_bizid']:''); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tx_push" class="col-sm-2 control-label">腾讯云直播推流域名</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_push" name="options[tx_push]" value="<?php echo (isset($config['tx_push']) && ($config['tx_push'] !== '')?$config['tx_push']:''); ?>">
                                    <p class="help-block"> 不带 http:// ,最后无 /</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tx_api_key" class="col-sm-2 control-label">腾讯云直播推流鉴权key</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_api_key" name="options[tx_api_key]" value="<?php echo (isset($config['tx_api_key']) && ($config['tx_api_key'] !== '')?$config['tx_api_key']:''); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tx_push_key" class="col-sm-2 control-label">腾讯云推流防盗链Key</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_push_key" name="options[tx_push_key]" value="<?php echo (isset($config['tx_push_key']) && ($config['tx_push_key'] !== '')?$config['tx_push_key']:''); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tx_acc_key" class="col-sm-2 control-label">腾讯云直播低延迟Key</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_acc_key" name="options[tx_acc_key]" value="<?php echo (isset($config['tx_acc_key']) && ($config['tx_acc_key'] !== '')?$config['tx_acc_key']:''); ?>">
                                    <p class="help-block">一般是 直播推流防盗链Key</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tx_pull" class="col-sm-2 control-label">腾讯云直播播流域名</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_pull" name="options[tx_pull]" value="<?php echo (isset($config['tx_pull']) && ($config['tx_pull'] !== '')?$config['tx_pull']:''); ?>">
                                    <p class="help-block"> 不带 http:// ,最后无 /</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tx_play_key_switch" class="col-sm-2 control-label">是否开启腾讯云播流鉴权</label>
                                <div class="col-md-6 col-sm-10" id="input-tx_play_key_switch">
                                    <label class="radio-inline"><input type="radio" value="0" name="options[tx_play_key_switch]" <?php if(array_key_exists('tx_play_key_switch',$config) && $config['tx_play_key_switch'] == '0'): ?>checked="checked" <?php endif; ?>>关闭</label>
                                    <label class="radio-inline"><input type="radio" value="1" name="options[tx_play_key_switch]" <?php if(array_key_exists('tx_play_key_switch',$config) && $config['tx_play_key_switch'] == '1'): ?>checked="checked" <?php endif; ?>>开启</label>
                                    <p class="help-block">如果选择开启，请确保腾讯云-->云直播-->域名管理--><?php echo (isset($config['tx_pull']) && ($config['tx_pull'] !== '')?$config['tx_pull']:''); ?>-->管理-->访问控制-->鉴权配置 里的信息开启了配置,并保持腾讯云填写的鉴权key和鉴权时间与此处填写的一致,参考文档：<a href="https://cloud.tencent.com/document/product/267/32463" target="_blank">https://cloud.tencent.com/document/product/267/32463</a></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-tx_play_key" class="col-sm-2 control-label">腾讯云直播播流鉴权key</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_play_key" name="options[tx_play_key]" value="<?php echo (isset($config['tx_play_key']) && ($config['tx_play_key'] !== '')?$config['tx_play_key']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-tx_play_time" class="col-sm-2 control-label">腾讯云直播播流鉴权时间(秒)</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-tx_play_time" name="options[tx_play_time]" value="<?php echo (isset($config['tx_play_time']) && ($config['tx_play_time'] !== '')?$config['tx_play_time']:''); ?>">
                                </div>
                            </div>

                            
                            
                        </div>

                        <div class="cdn_bd <?php if($config['cdn_switch'] != '3'): ?>cdnhide<?php endif; ?>" id="cdn_switch_3">
                            <div class="form-group">
                                <label for="input-qn_ak" class="col-sm-2 control-label">七牛云AccessKey</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-qn_ak" name="options[qn_ak]" value="<?php echo (isset($config['qn_ak']) && ($config['qn_ak'] !== '')?$config['qn_ak']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-qn_sk" class="col-sm-2 control-label">七牛云SecretKey</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-qn_sk" name="options[qn_sk]" value="<?php echo (isset($config['qn_sk']) && ($config['qn_sk'] !== '')?$config['qn_sk']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-qn_hname" class="col-sm-2 control-label">七牛云直播空间名称</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-qn_hname" name="options[qn_hname]" value="<?php echo (isset($config['qn_hname']) && ($config['qn_hname'] !== '')?$config['qn_hname']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-qn_push" class="col-sm-2 control-label">七牛云推流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-qn_push" name="options[qn_push]" value="<?php echo (isset($config['qn_push']) && ($config['qn_push'] !== '')?$config['qn_push']:''); ?>">
                                    <p class="help-block">七牛云直播云域名管理中RTMP推流域名</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-qn_pull" class="col-sm-2 control-label">七牛云播流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-qn_pull" name="options[qn_pull]" value="<?php echo (isset($config['qn_pull']) && ($config['qn_pull'] !== '')?$config['qn_pull']:''); ?>">
                                    <p class="help-block">七牛云直播云域名管理中RTMP播流域名</p>
                                </div>
                            </div>
                        </div>

                        <div class="cdn_bd <?php if($config['cdn_switch'] != '4'): ?>cdnhide<?php endif; ?>" id="cdn_switch_4">
                            <div class="form-group">
                                <label for="input-ws_push" class="col-sm-2 control-label">网宿推流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ws_push" name="options[ws_push]" value="<?php echo (isset($config['ws_push']) && ($config['ws_push'] !== '')?$config['ws_push']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ws_pull" class="col-sm-2 control-label">网宿播流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ws_pull" name="options[ws_pull]" value="<?php echo (isset($config['ws_pull']) && ($config['ws_pull'] !== '')?$config['ws_pull']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ws_apn" class="col-sm-2 control-label">网宿AppName</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ws_apn" name="options[ws_apn]" value="<?php echo (isset($config['ws_apn']) && ($config['ws_apn'] !== '')?$config['ws_apn']:''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="cdn_bd <?php if($config['cdn_switch'] != '5'): ?>cdnhide<?php endif; ?>" id="cdn_switch_5">
                            <div class="form-group">
                                <label for="input-wy_appkey" class="col-sm-2 control-label">网易cdn Appkey</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-wy_appkey" name="options[wy_appkey]" value="<?php echo (isset($config['wy_appkey']) && ($config['wy_appkey'] !== '')?$config['wy_appkey']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-wy_appsecret" class="col-sm-2 control-label">网易cdn AppSecret</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-wy_appsecret" name="options[wy_appsecret]" value="<?php echo (isset($config['wy_appsecret']) && ($config['wy_appsecret'] !== '')?$config['wy_appsecret']:''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="cdn_bd <?php if($config['cdn_switch'] != '6'): ?>cdnhide<?php endif; ?>" id="cdn_switch_6">
                            <div class="form-group">
                                <label for="input-ady_push" class="col-sm-2 control-label">奥点云推流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ady_push" name="options[ady_push]" value="<?php echo (isset($config['ady_push']) && ($config['ady_push'] !== '')?$config['ady_push']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ady_pull" class="col-sm-2 control-label">奥点云播流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ady_pull" name="options[ady_pull]" value="<?php echo (isset($config['ady_pull']) && ($config['ady_pull'] !== '')?$config['ady_pull']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ady_hls_pull" class="col-sm-2 control-label">奥点云HLS播流地址</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ady_hls_pull" name="options[ady_hls_pull]" value="<?php echo (isset($config['ady_hls_pull']) && ($config['ady_hls_pull'] !== '')?$config['ady_hls_pull']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-ady_apn" class="col-sm-2 control-label">奥点云AppName</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-ady_apn" name="options[ady_apn]" value="<?php echo (isset($config['ady_apn']) && ($config['ady_apn'] !== '')?$config['ady_apn']:''); ?>">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="D">
                        <div class="form-group">
                            <label for="input-cash_rate" class="col-sm-2 control-label">提现比例</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-cash_rate" name="options[cash_rate]" value="<?php echo (isset($config['cash_rate']) && ($config['cash_rate'] !== '')?$config['cash_rate']:''); ?>">
                                <p class="help-block">(整数)提现一元人民币需要的票数</p>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="input-cash_take" class="col-sm-2 control-label">提现抽成(元)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-cash_take" name="options[cash_take]" value="<?php echo (isset($config['cash_take']) && ($config['cash_take'] !== '')?$config['cash_take']:''); ?>">
                                <p class="help-block">(%-整数)百分比<br/>说明: 当提现比例设置为100映票等于1元时,提现抽成比例设置为10%,那么用户提现1000映票时,通过提现比例转换为10元,平台在从10元的基础上抽成10%,用户最终提现到账金额为9元</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-cash_min" class="col-sm-2 control-label">提现最低额度（元）</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-cash_min" name="options[cash_min]" value="<?php echo (isset($config['cash_min']) && ($config['cash_min'] !== '')?$config['cash_min']:''); ?>">
                                <p class="help-block">可提现的最小额度，低于该额度无法提现</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-cash_start" class="col-sm-2 control-label">每月提现期</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-cash_start" name="options[cash_start]" value="<?php echo (isset($config['cash_start']) && ($config['cash_start'] !== '')?$config['cash_start']:''); ?>" style="width:100px;display:inline-block;"> -
                                <input type="text" class="form-control" id="input-cash_end" name="options[cash_end]" value="<?php echo (isset($config['cash_end']) && ($config['cash_end'] !== '')?$config['cash_end']:''); ?>" style="width:100px;display:inline-block;">
                                <p class="help-block">每月提现期限，不在时间段无法提现</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-cash_max_times" class="col-sm-2 control-label">每月提现次数</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-cash_max_times" name="options[cash_max_times]" value="<?php echo (isset($config['cash_max_times']) && ($config['cash_max_times'] !== '')?$config['cash_max_times']:''); ?>">
                                <p class="help-block">每月可提现最大次数，0表示不限制</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="E">
                        <div class="form-group">
                            <label for="input-letter_switch" class="col-sm-2 control-label">私信开关</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[letter_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['letter_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                                <p class="help-block">关闭后用户间不可私信</p>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label for="input-tencentIM_appid" class="col-sm-2 control-label">腾讯云IM SDKAppID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-tencentIM_appid" name="options[tencentIM_appid]" value="<?php echo (isset($config['tencentIM_appid']) && ($config['tencentIM_appid'] !== '')?$config['tencentIM_appid']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-tencentIM_appkey" class="col-sm-2 control-label">腾讯云IM 密钥</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-tencentIM_appkey" name="options[tencentIM_appkey]" value="<?php echo (isset($config['tencentIM_appkey']) && ($config['tencentIM_appkey'] !== '')?$config['tencentIM_appkey']:''); ?>">
                                <p class="help-block">请务必登录腾讯云控制台==>产品==>即时通信IM==>帐号管理==>新建帐号中添加普通账号dsp_comment、dsp_at、dsp_like、dsp_fans、goodsorder_admin。否则IM功能将无法使用</p>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="input-tencentTpns_area" class="col-sm-2 control-label">腾讯云TPNS应用部署区域</label>
                            <div class="col-md-6 col-sm-10">
                                <label class="radio-inline"><input type="radio" value="guangzhou" name="options[tencentTpns_area]" <?php if(in_array(($config['tencentTpns_area']), explode(',',"guangzhou"))): ?>checked="checked"<?php endif; ?>>广州</label>
                                <label class="radio-inline"><input type="radio" value="shanghai" name="options[tencentTpns_area]" <?php if(in_array(($config['tencentTpns_area']), explode(',',"shanghai"))): ?>checked="checked"<?php endif; ?>>上海</label>
                                <label class="radio-inline"><input type="radio" value="hongkong" name="options[tencentTpns_area]" <?php if(in_array(($config['tencentTpns_area']), explode(',',"hongkong"))): ?>checked="checked"<?php endif; ?>>香港</label>
                                <label class="radio-inline"><input type="radio" value="singapore" name="options[tencentTpns_area]" <?php if(in_array(($config['tencentTpns_area']), explode(',',"singapore"))): ?>checked="checked"<?php endif; ?>>新加坡</label>
                                <p class="help-block">确保配置同腾讯云TPNS控制台创建的应用区域一致，否则推送将失败</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-tencentTpns_accessid_android" class="col-sm-2 control-label">腾讯云TPNS Android AccessID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-tencentTpns_accessid_android" name="options[tencentTpns_accessid_android]" value="<?php echo (isset($config['tencentTpns_accessid_android']) && ($config['tencentTpns_accessid_android'] !== '')?$config['tencentTpns_accessid_android']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-tencentTpns_secretkey_android" class="col-sm-2 control-label">腾讯云TPNS Android SecretKey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-tencentTpns_secretkey_android" name="options[tencentTpns_secretkey_android]" value="<?php echo (isset($config['tencentTpns_secretkey_android']) && ($config['tencentTpns_secretkey_android'] !== '')?$config['tencentTpns_secretkey_android']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-tencentTpns_accessid_ios" class="col-sm-2 control-label">腾讯云TPNS iOS AccessID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-tencentTpns_accessid_ios" name="options[tencentTpns_accessid_ios]" value="<?php echo (isset($config['tencentTpns_accessid_ios']) && ($config['tencentTpns_accessid_ios'] !== '')?$config['tencentTpns_accessid_ios']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-tencentTpns_secretkey_ios" class="col-sm-2 control-label">腾讯云TPNS iOS SecretKey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-tencentTpns_secretkey_ios" name="options[tencentTpns_secretkey_ios]" value="<?php echo (isset($config['tencentTpns_secretkey_ios']) && ($config['tencentTpns_secretkey_ios'] !== '')?$config['tencentTpns_secretkey_ios']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-tencentTpns_ios_environment" class="col-sm-2 control-label">腾讯云TPNS iOS运行环境</label>
                            <div class="col-md-6 col-sm-10">
                                <label class="radio-inline"><input type="radio" value="0" name="options[tencentTpns_ios_environment]" <?php if(in_array(($config['tencentTpns_ios_environment']), explode(',',"0"))): ?>checked="checked"<?php endif; ?>>开发</label>
                                <label class="radio-inline"><input type="radio" value="1" name="options[tencentTpns_ios_environment]" <?php if(in_array(($config['tencentTpns_ios_environment']), explode(',',"1"))): ?>checked="checked"<?php endif; ?>>生产</label>
                                
                                <p class="help-block">iOS未上架时选择开发环境，上架成功后选择生产环境</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="F">
                        
                        <div class="form-group">
                            <label for="input-aliapp_partner" class="col-sm-2 control-label">支付宝合作者身份ID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-aliapp_partner" name="options[aliapp_partner]" value="<?php echo (isset($config['aliapp_partner']) && ($config['aliapp_partner'] !== '')?$config['aliapp_partner']:''); ?>">
                                <p class="help-block">适用于APP支付宝支付和老版支付宝账号PC扫码支付</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-aliapp_seller_id" class="col-sm-2 control-label">支付宝登录账号</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-aliapp_seller_id" name="options[aliapp_seller_id]" value="<?php echo (isset($config['aliapp_seller_id']) && ($config['aliapp_seller_id'] !== '')?$config['aliapp_seller_id']:''); ?>">
                                <p class="help-block">适用于APP支付宝支付和老版支付宝账号PC扫码支付</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-aliapp_key_android" class="col-sm-2 control-label">支付宝安卓密钥</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-aliapp_key_android" name="options[aliapp_key_android]" ><?php echo (isset($config['aliapp_key_android']) && ($config['aliapp_key_android'] !== '')?$config['aliapp_key_android']:''); ?></textarea>
                                <p class="help-block">支付宝安卓密钥pkcs8--适用于APP支付宝支付</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-aliapp_key_ios" class="col-sm-2 control-label">支付宝苹果密钥</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-aliapp_key_ios" name="options[aliapp_key_ios]" ><?php echo (isset($config['aliapp_key_ios']) && ($config['aliapp_key_ios'] !== '')?$config['aliapp_key_ios']:''); ?></textarea>
                                <p class="help-block">支付宝苹果密钥pkcs8--适用于APP支付宝支付</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label">支付宝校验码</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-aliapp_check" name="options[aliapp_check]" value="<?php echo (isset($config['aliapp_check']) && ($config['aliapp_check'] !== '')?$config['aliapp_check']:''); ?>">
                                <p class="help-block">mapi网关--MD5密钥（适用于老版支付宝账号PC扫码支付）（支付宝开放平台==》账户中心==》mapi网关产品密钥=》MD5密钥）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-alipay_pc_type" class="col-sm-2 control-label">支付宝PC支付版本选择</label>
                            <div class="col-md-6 col-sm-10">
                                <label class="radio-inline"><input type="radio" value="0" name="options[alipay_pc_type]" <?php if(in_array(($config['alipay_pc_type']), explode(',',"0"))): ?>checked="checked"<?php endif; ?>>旧版支付宝账号</label>
                                <label class="radio-inline"><input type="radio" value="1" name="options[alipay_pc_type]" <?php if(in_array(($config['alipay_pc_type']), explode(',',"1"))): ?>checked="checked"<?php endif; ?>>新版支付宝账号</label>
                                <p class="help-block">1、旧版指的是很早前注册的支付宝账号，且已经设置了mapi网关产品密钥==》MD5密钥</p>
                                <p class="help-block">2、如果账号不能设置MD5密钥，请选择新版PC支付并配置下面的信息，旧版需配置上面的信息</p>
                                <p class="help-block">3、新版旧版仅针对PC支付，对APP支付的配置信息没有影响</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-ali_application_appid" class="col-sm-2 control-label">支付宝签约应用appid</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-ali_application_appid" name="options[ali_application_appid]" value="<?php echo (isset($config['ali_application_appid']) && ($config['ali_application_appid'] !== '')?$config['ali_application_appid']:''); ?>">
                                <p class="help-block">支付宝开放平台==》控制台==》网页/移动应用==》appid 【适用于新版支付宝账号PC扫码支付，确保应用==》产品绑定 已经开通电脑网站支付】</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-ali_key_pc" class="col-sm-2 control-label">支付宝PC支付应用私钥</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-ali_key_pc" name="options[ali_key_pc]" ><?php echo (isset($config['ali_key_pc']) && ($config['ali_key_pc'] !== '')?$config['ali_key_pc']:''); ?></textarea>
                                <p class="help-block">支付宝PC支付应用私钥pkcs8--【适用于新版支付宝账号PC扫码支付】</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="input-wx_appid" class="col-sm-2 control-label">微信开放平台移动应用AppID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_appid" name="options[wx_appid]" value="<?php echo (isset($config['wx_appid']) && ($config['wx_appid'] !== '')?$config['wx_appid']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-wx_appsecret" class="col-sm-2 control-label">微信开放平台移动应用appsecret</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_appsecret" name="options[wx_appsecret]" value="<?php echo (isset($config['wx_appsecret']) && ($config['wx_appsecret'] !== '')?$config['wx_appsecret']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-wx_mchid" class="col-sm-2 control-label">微信开放平台绑定商户号mchid</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_mchid" name="options[wx_mchid]" value="<?php echo (isset($config['wx_mchid']) && ($config['wx_mchid'] !== '')?$config['wx_mchid']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-wx_key" class="col-sm-2 control-label">微信开放平台绑定商户号密钥key</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_key" name="options[wx_key]" value="<?php echo (isset($config['wx_key']) && ($config['wx_key'] !== '')?$config['wx_key']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-braintree_paypal_environment" class="col-sm-2 control-label">Braintree-Paypal商户类型</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[braintree_paypal_environment]">
                                    <option value="0">沙盒</option>
                                    <?php if(isset($config['braintree_paypal_environment'])): ?>
                                        <option value="1" <?php if($config['braintree_paypal_environment'] == '1'): ?>selected<?php endif; ?>>生产</option>
                                    <?php endif; ?>
                                    
                                </select>
                                <p class="help-block">Braintree集成Paypal支付的商户类型，沙盒环境仅供测试使用</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-braintree_merchantid_sandbox" class="col-sm-2 control-label">Braintree MerchantID(沙盒)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-braintree_merchantid_sandbox" name="options[braintree_merchantid_sandbox]" value="<?php echo (isset($config['braintree_merchantid_sandbox']) && ($config['braintree_merchantid_sandbox'] !== '')?$config['braintree_merchantid_sandbox']:''); ?>">
                                <p class="help-block">https://sandbox.braintreegateway.com登录后-->右上角齿轮设置图标-->Processing-->导航栏API-->Keys-->Merchant ID</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-braintree_publickey_sandbox" class="col-sm-2 control-label">Braintree 公钥(沙盒)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-braintree_publickey_sandbox" name="options[braintree_publickey_sandbox]" value="<?php echo (isset($config['braintree_publickey_sandbox']) && ($config['braintree_publickey_sandbox'] !== '')?$config['braintree_publickey_sandbox']:''); ?>">
                                <p class="help-block">https://sandbox.braintreegateway.com登录后-->右上角齿轮设置图标-->Processing-->导航栏API-->Keys-->API Keys-->Public Key</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-braintree_privatekey_sandbox" class="col-sm-2 control-label">Braintree私钥(沙盒)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-braintree_privatekey_sandbox" name="options[braintree_privatekey_sandbox]" value="<?php echo (isset($config['braintree_privatekey_sandbox']) && ($config['braintree_privatekey_sandbox'] !== '')?$config['braintree_privatekey_sandbox']:''); ?>">
                                <p class="help-block">https://sandbox.braintreegateway.com登录后-->右上角齿轮设置图标-->Processing-->导航栏API-->Keys-->API Keys-->Private Key</p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="input-braintree_merchantid_product" class="col-sm-2 control-label">Braintree MerchantID(生产)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-braintree_merchantid_product" name="options[braintree_merchantid_product]" value="<?php echo (isset($config['braintree_merchantid_product']) && ($config['braintree_merchantid_product'] !== '')?$config['braintree_merchantid_product']:''); ?>">
                                <p class="help-block">https://www.braintreegateway.com登录后-->右上角齿轮设置图标-->Processing-->导航栏API-->Keys-->Merchant ID</p>
                            </div>
                            
                        </div>


                        <div class="form-group">
                            <label for="input-braintree_publickey_product" class="col-sm-2 control-label">Braintree 公钥(生产)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-braintree_publickey_product" name="options[braintree_publickey_product]" value="<?php echo (isset($config['braintree_publickey_product']) && ($config['braintree_publickey_product'] !== '')?$config['braintree_publickey_product']:''); ?>">
                                <p class="help-block">https://www.braintreegateway.com登录后-->右上角齿轮设置图标-->Processing-->导航栏API-->Keys-->API Keys-->Public Key</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-braintree_privatekey_product" class="col-sm-2 control-label">Braintree私钥(生产)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-braintree_privatekey_product" name="options[braintree_privatekey_product]" value="<?php echo (isset($config['braintree_privatekey_product']) && ($config['braintree_privatekey_product'] !== '')?$config['braintree_privatekey_product']:''); ?>">
                                <p class="help-block">https://www.braintreegateway.com登录后-->右上角齿轮设置图标-->Processing-->导航栏API-->Keys-->API Keys-->Private Key</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-wx_mini_appid" class="col-sm-2 control-label">微信小程序AppID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_mini_appid" name="options[wx_mini_appid]" value="<?php echo (isset($config['wx_mini_appid']) && ($config['wx_mini_appid'] !== '')?$config['wx_mini_appid']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_mini_appsecret" class="col-sm-2 control-label">微信小程序appsecret</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_mini_appsecret" name="options[wx_mini_appsecret]" value="<?php echo (isset($config['wx_mini_appsecret']) && ($config['wx_mini_appsecret'] !== '')?$config['wx_mini_appsecret']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_mini_mchid" class="col-sm-2 control-label">微信小程序绑定商户号mchid</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_mini_mchid" name="options[wx_mini_mchid]" value="<?php echo (isset($config['wx_mini_mchid']) && ($config['wx_mini_mchid'] !== '')?$config['wx_mini_mchid']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_mini_key" class="col-sm-2 control-label">微信小程序绑定商户号密钥key</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_mini_key" name="options[wx_mini_key]" value="<?php echo (isset($config['wx_mini_key']) && ($config['wx_mini_key'] !== '')?$config['wx_mini_key']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>
						
						
						<div class="form-group">
                            <label for="input-wx_h5_appid" class="col-sm-2 control-label">微信H5支付AppID</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_h5_appid" name="options[wx_h5_appid]" value="<?php echo (isset($config['wx_h5_appid']) && ($config['wx_h5_appid'] !== '')?$config['wx_h5_appid']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_h5_appsecret" class="col-sm-2 control-label">微信H5支付appsecret</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_h5_appsecret" name="options[wx_h5_appsecret]" value="<?php echo (isset($config['wx_h5_appsecret']) && ($config['wx_h5_appsecret'] !== '')?$config['wx_h5_appsecret']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_h5_mchid" class="col-sm-2 control-label">微信H5支付绑定商户号mchid</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_h5_mchid" name="options[wx_h5_mchid]" value="<?php echo (isset($config['wx_h5_mchid']) && ($config['wx_h5_mchid'] !== '')?$config['wx_h5_mchid']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_h5_key" class="col-sm-2 control-label">微信H5支付绑定商户号密钥key</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_h5_key" name="options[wx_h5_key]" value="<?php echo (isset($config['wx_h5_key']) && ($config['wx_h5_key'] !== '')?$config['wx_h5_key']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>
                        
                        
                        

                        <!-- 【原PayPal支付因无法使用已废弃但保留】<div class="form-group">
                            <label for="input-paypal_sandbox" class="col-sm-2 control-label">APP-Paypal支付模式</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control" name="options[paypal_sandbox]">
                                    <option value="0">沙盒</option>
                                    <?php if(isset($config['paypal_sandbox'])): ?>
                                    <option value="1" <?php if($config['paypal_sandbox'] == '1'): ?>selected<?php endif; ?>>生产</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-sandbox_clientid" class="col-sm-2 control-label">APP-PayPal-沙盒ClientID</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-sandbox_clientid" name="options[sandbox_clientid]" ><?php echo (isset($config['sandbox_clientid']) && ($config['sandbox_clientid'] !== '')?$config['sandbox_clientid']:''); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-product_clientid" class="col-sm-2 control-label">APP-PayPal-生产ClientID</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-product_clientid" name="options[product_clientid]" ><?php echo (isset($config['product_clientid']) && ($config['product_clientid'] !== '')?$config['product_clientid']:''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: center;color: #F00;"><?php echo $name_coin; ?>充值支付方式开关</label>
                            <div class="col-md-6 col-sm-10">
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_switch" class="col-sm-2 control-label">支付宝APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[aliapp_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['aliapp_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_switch" class="col-sm-2 control-label">微信支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[wx_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['wx_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_pc" class="col-sm-2 control-label">支付宝PC开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[aliapp_pc]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['aliapp_pc'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_switch_pc" class="col-sm-2 control-label">微信支付PC开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[wx_switch_pc]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['wx_switch_pc'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wx_mini_switch" class="col-sm-2 control-label">微信小程序支付开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[wx_mini_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['wx_mini_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-braintree_paypal_switch" class="col-sm-2 control-label">Braintree-Paypal支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[braintree_paypal_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($config['braintree_paypal_switch'])): ?>
                                        <option value="1" <?php if($config['braintree_paypal_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                    
                                </select>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="input-alih5_switch" class="col-sm-2 control-label">支付宝H5开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[alih5_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['alih5_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wxh5_switch" class="col-sm-2 control-label">微信支付H5开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[wxh5_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['wxh5_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="input-wxgzh_switch" class="col-sm-2 control-label">微信公众号支付开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[wxgzh_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['wxgzh_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-firstcharge_repeatedly" class="col-sm-2 control-label"><?php echo $name_coin; ?>首充是否可多次使用</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[firstcharge_repeatedly]">
                                    <option value="0">否</option>
                                    <?php if(isset($config['firstcharge_repeatedly'])): ?>
                                        <option value="1" <?php if($config['firstcharge_repeatedly'] == '1'): ?>selected<?php endif; ?>>是</option>
                                    <?php endif; ?>
                                    
                                </select>
                            </div>
                        </div>

                        <!--【原PayPal支付因无法使用已废弃但保留】 <div class="form-group">
                            <label for="input-paypal_switch" class="col-sm-2 control-label"><?php echo $name_coin; ?>充值Paypal支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control" name="options[paypal_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($config['paypal_switch'])): ?>
                                    <option value="1" <?php if($config['paypal_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div> -->
                        
                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: center;color: #F00;">店铺支付开关</label>
                            <div class="col-md-6 col-sm-10">
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_aliapp_switch" class="col-sm-2 control-label">支付宝支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[shop_aliapp_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['shop_aliapp_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_wx_switch" class="col-sm-2 control-label">微信支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[shop_wx_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['shop_wx_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_wxmini_switch" class="col-sm-2 control-label">微信支付微信小程序开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[shop_wxmini_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['shop_wxmini_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_balance_switch" class="col-sm-2 control-label">余额支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[shop_balance_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['shop_balance_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_braintree_paypal_switch" class="col-sm-2 control-label">BraintreePaypal支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[shop_braintree_paypal_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($config['shop_braintree_paypal_switch'])): ?>
                                    <option value="1" <?php if($config['shop_braintree_paypal_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!--【原PayPal支付因无法使用已废弃但保留】 <div class="form-group">
                            <label for="input-shop_paypal_switch" class="col-sm-2 control-label">店铺Paypal支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control" name="options[shop_paypal_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($config['shop_paypal_switch'])): ?>
                                    <option value="1" <?php if($config['shop_paypal_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label for="input-shop_wxmini_balance_switch" class="col-sm-2 control-label">余额支付微信小程序开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[shop_wxmini_balance_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['shop_wxmini_balance_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: center;color: #F00;">付费内容支付方式开关</label>
                            <div class="col-md-6 col-sm-10">
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-paidprogram_aliapp_switch" class="col-sm-2 control-label">支付宝支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[paidprogram_aliapp_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['paidprogram_aliapp_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-paidprogram_wx_switch" class="col-sm-2 control-label">微信支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[paidprogram_wx_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['paidprogram_wx_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-paidprogram_balance_switch" class="col-sm-2 control-label">余额支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[paidprogram_balance_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['paidprogram_balance_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-paidprogram_braintree_paypal_switch" class="col-sm-2 control-label">BrainTree Paypal支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[paidprogram_braintree_paypal_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($config['paidprogram_braintree_paypal_switch'])): ?>
                                    <option value="1" <?php if($config['paidprogram_braintree_paypal_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-aliapp_check" class="col-sm-2 control-label" style="font-weight: normal;padding-top: 0;">-------------------------------</label>
                            <div class="col-md-6 col-sm-10">
                                -------------------------------------------------------------------------------------------------------------------------------------
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: center;color: #F00;"> 虚拟物品支付方式开关</label>
                            <div class="col-md-6 col-sm-10">
                            
                            </div>
                        </div>
          
                        <div class="form-group">
                            <label for="input-virtual_payment" class="col-sm-2 control-label">虚拟物品支付开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[virtual_payment]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['virtual_payment'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        <!--【原PayPal支付因无法使用已废弃但保留】 <div class="form-group">
                            <label for="input-paidprogram_paypal_switch" class="col-sm-2 control-label">Paypal支付APP开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control" name="options[paidprogram_paypal_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($config['paidprogram_paypal_switch'])): ?>
                                    <option value="1" <?php if($config['paidprogram_paypal_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="G">
                        <div class="form-group">
                            <label for="input-agent_switch" class="col-sm-2 control-label">邀请开关</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control" name="options[agent_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['agent_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-agent_must" class="col-sm-2 control-label">邀请码必填</label>
                            <div class="col-md-6 col-sm-10">
                                <label class="radio-inline"><input type="radio" name="options[agent_must]" value="0" <?php if($config['agent_must'] == '0'): ?>checked<?php endif; ?>>关闭</label>
                                <label class="radio-inline"><input type="radio" name="options[agent_must]" value="1" <?php if($config['agent_must'] == '1'): ?>checked<?php endif; ?> >开启</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-distribut1" class="col-sm-2 control-label">一级分成</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-distribut1" name="options[distribut1]" value="<?php echo (isset($config['distribut1']) && ($config['distribut1'] !== '')?$config['distribut1']:''); ?>">%
                                <p class="help-block">一级分成(整数) 注：比例在0-100之间</p>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="H">
                        <div class="form-group">
                            <label for="input-um_apikey" class="col-sm-2 control-label">友盟OpenApi-apiKey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-um_apikey" name="options[um_apikey]" value="<?php echo (isset($config['um_apikey']) && ($config['um_apikey'] !== '')?$config['um_apikey']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-um_apisecurity" class="col-sm-2 control-label">友盟OpenApi-apiSecurity</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-um_apisecurity" name="options[um_apisecurity]" value="<?php echo (isset($config['um_apisecurity']) && ($config['um_apisecurity'] !== '')?$config['um_apisecurity']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-um_appkey_android" class="col-sm-2 control-label">友盟Android应用-appkey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-um_appkey_android" name="options[um_appkey_android]" value="<?php echo (isset($config['um_appkey_android']) && ($config['um_appkey_android'] !== '')?$config['um_appkey_android']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-um_appkey_ios" class="col-sm-2 control-label">友盟IOS应用-appkey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-um_appkey_ios" name="options[um_appkey_ios]" value="<?php echo (isset($config['um_appkey_ios']) && ($config['um_appkey_ios'] !== '')?$config['um_appkey_ios']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="I">
                        
                        <div class="form-group">
                            <label for="input-video_audit_switch" class="col-sm-2 control-label">视频审核开关</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[video_audit_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['video_audit_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
								<p class="help-block">当开关关闭时用户发布视频则无需审核</p>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="input-video_watermark" class="col-sm-2 control-label">视频水印图片</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[video_watermark]" id="thumbnail2" value="<?php echo (isset($config['video_watermark']) && ($config['video_watermark'] !== '')?$config['video_watermark']:''); ?>">
                                <input type="hidden" name="options[video_watermark_old]" value="<?php echo (isset($config['video_watermark']) && ($config['video_watermark'] !== '')?$config['video_watermark']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail2');">
                                    <?php if(empty($config['video_watermark'])): ?>
                                    <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail2-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php else: ?>
                                    <img src="<?php echo cmf_get_image_preview_url($config['video_watermark']); ?>"
                                         id="thumbnail2-preview"
                                         style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail2" value="取消图片">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-ad_video_switch" class="col-sm-2 control-label">广告视频开关</label>
                            <div class="col-md-6 col-sm-10">
                                <label class="radio-inline"><input type="radio" name="options[ad_video_switch]" value="0" <?php if($config['ad_video_switch'] == '0'): ?>checked<?php endif; ?>>关</label>
                                <label class="radio-inline"><input type="radio" name="options[ad_video_switch]" value="1" <?php if($config['ad_video_switch'] == '1'): ?>checked<?php endif; ?> >开</label>
                                <p class="help-block">打开时，在首页推荐视频列表上会出现广告视频</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-ad_video_loop" class="col-sm-2 control-label">广告是否轮循展示</label>
                            <div class="col-md-6 col-sm-10">
                                <label class="radio-inline"><input type="radio" name="options[ad_video_loop]" value="0" <?php if($config['ad_video_loop'] == '0'): ?>checked<?php endif; ?>>否</label>
                                <label class="radio-inline"><input type="radio" name="options[ad_video_loop]" value="1" <?php if($config['ad_video_loop'] == '1'): ?>checked<?php endif; ?> >是</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-video_ad_num" class="col-sm-2 control-label">滑动几个视频出现广告</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-video_ad_num" name="options[video_ad_num]" value="<?php echo (isset($config['video_ad_num']) && ($config['video_ad_num'] !== '')?$config['video_ad_num']:''); ?>" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');">  <p class="help-block">请从1,2,4,5,10,20中选择一个填写</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="J">

                        <div class="form-group">
                            <label for="input-shop_system_name" class="col-sm-2 control-label">系统店铺名称--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_system_name" name="options[shop_system_name]" value="<?php echo (isset($config['shop_system_name']) && ($config['shop_system_name'] !== '')?$config['shop_system_name']:''); ?>">
                                <p class="help-block">用于个人中心店铺显示和店铺个人中心顶部显示</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_system_name_en" class="col-sm-2 control-label">系统店铺名称--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_system_name_en" name="options[shop_system_name_en]" value="<?php echo (isset($config['shop_system_name_en']) && ($config['shop_system_name_en'] !== '')?$config['shop_system_name_en']:''); ?>">
                                <p class="help-block">用于个人中心店铺显示和店铺个人中心顶部显示</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-shop_bond" class="col-sm-2 control-label">申请店铺需要的保证金(<?php echo $name_coin; ?>)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_bond" name="options[shop_bond]" value="<?php echo (isset($config['shop_bond']) && ($config['shop_bond'] !== '')?$config['shop_bond']:''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-show_switch" class="col-sm-2 control-label">店铺审核</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[show_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['show_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="input-show_switch" class="col-sm-2 control-label">店铺经营类目审核</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[show_category_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['show_category_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                                <p>开启后，用户申请店铺经营类目，需经平台管理员审核通过后才能发布商品</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-shoporder_percent" class="col-sm-2 control-label">店铺订单默认抽成比例</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shoporder_percent" name="options[shoporder_percent]" value="<?php echo (isset($config['shoporder_percent']) && ($config['shoporder_percent'] !== '')?$config['shoporder_percent']:'0'); ?>">%
                                <p class="help-block">0-100之间的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-goods_switch" class="col-sm-2 control-label">商品审核</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[goods_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['goods_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_certificate_desc" class="col-sm-2 control-label">店铺资质说明--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-shop_certificate_desc" name="options[shop_certificate_desc]" ><?php echo (isset($config['shop_certificate_desc']) && ($config['shop_certificate_desc'] !== '')?$config['shop_certificate_desc']:''); ?></textarea>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_certificate_desc_en" class="col-sm-2 control-label">店铺资质说明--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-shop_certificate_desc_en" name="options[shop_certificate_desc_en]" ><?php echo (isset($config['shop_certificate_desc_en']) && ($config['shop_certificate_desc_en'] !== '')?$config['shop_certificate_desc_en']:''); ?></textarea>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_payment_time" class="col-sm-2 control-label">店铺付款失效时间(分钟)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_payment_time" name="options[shop_payment_time]" value="<?php echo (isset($config['shop_payment_time']) && ($config['shop_payment_time'] !== '')?$config['shop_payment_time']:'0'); ?>">
                                <p class="help-block">大于0的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_shipment_time" class="col-sm-2 control-label">店铺发货失效时间(天)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_shipment_time" name="options[shop_shipment_time]" value="<?php echo (isset($config['shop_shipment_time']) && ($config['shop_shipment_time'] !== '')?$config['shop_shipment_time']:'0'); ?>">
                                <p class="help-block">大于0的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_receive_time" class="col-sm-2 control-label">店铺自动确认收货时间(天)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_receive_time" name="options[shop_receive_time]" value="<?php echo (isset($config['shop_receive_time']) && ($config['shop_receive_time'] !== '')?$config['shop_receive_time']:'0'); ?>">
                                <p class="help-block">大于0的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_refund_time" class="col-sm-2 control-label">买家发起退款,卖家不做处理自动退款时间(天)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_refund_time" name="options[shop_refund_time]" value="<?php echo (isset($config['shop_refund_time']) && ($config['shop_refund_time'] !== '')?$config['shop_refund_time']:'0'); ?>">
                                <p class="help-block">大于0的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_refund_finish_time" class="col-sm-2 control-label">卖家拒绝买家退款后,买家不做任何操作,订单自动进入退款前状态的时间(天)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_refund_finish_time" name="options[shop_refund_finish_time]" value="<?php echo (isset($config['shop_refund_finish_time']) && ($config['shop_refund_finish_time'] !== '')?$config['shop_refund_finish_time']:'0'); ?>">
                                <p class="help-block">大于0的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_receive_refund_time" class="col-sm-2 control-label">订单确认收货后,支持退货退款的时间限制(天)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_receive_refund_time" name="options[shop_receive_refund_time]" value="<?php echo (isset($config['shop_receive_refund_time']) && ($config['shop_receive_refund_time'] !== '')?$config['shop_receive_refund_time']:'0'); ?>">
                                <p class="help-block">大于0的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shop_settlement_time" class="col-sm-2 control-label">订单确认收货后,货款自动打到卖家的时间(天)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-shop_settlement_time" name="options[shop_settlement_time]" value="<?php echo (isset($config['shop_settlement_time']) && ($config['shop_settlement_time'] !== '')?$config['shop_settlement_time']:'0'); ?>">
                                <p class="help-block">大于0的整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-balance_cash_min" class="col-sm-2 control-label">余额提现最低额度（元）</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-balance_cash_min" name="options[balance_cash_min]" value="<?php echo (isset($config['balance_cash_min']) && ($config['balance_cash_min'] !== '')?$config['balance_cash_min']:''); ?>">
                                <p class="help-block">可提现的最小额度，低于该额度无法提现</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-balance_cash_start" class="col-sm-2 control-label">每月提现期限</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-balance_cash_start" name="options[balance_cash_start]" value="<?php echo (isset($config['balance_cash_start']) && ($config['balance_cash_start'] !== '')?$config['balance_cash_start']:''); ?>" style="width:100px;display:inline-block;"> -
                                <input type="text" class="form-control" id="input-balance_cash_end" name="options[balance_cash_end]" value="<?php echo (isset($config['balance_cash_end']) && ($config['balance_cash_end'] !== '')?$config['balance_cash_end']:''); ?>" style="width:100px;display:inline-block;">
                                <p class="help-block">每月提现期限，不在时间段无法提现 </p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-balance_cash_max_times" class="col-sm-2 control-label">每月提现次数</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-balance_cash_max_times" name="options[balance_cash_max_times]" value="<?php echo (isset($config['balance_cash_max_times']) && ($config['balance_cash_max_times'] !== '')?$config['balance_cash_max_times']:''); ?>">
                                <p class="help-block">每月可提现最大次数，0表示不限制</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-shoporder_percent" class="col-sm-2 control-label">店铺机制说明</label>
                            <div class="col-md-6 col-sm-10">
                                <p class="help-block">1:用户下单后<?php echo (isset($config['shop_payment_time']) && ($config['shop_payment_time'] !== '')?$config['shop_payment_time']:'0'); ?>分钟不付款，系统自动将订单关闭</p>
                                <p class="help-block">2:买家付款成功后，卖家超过<?php echo (isset($config['shop_shipment_time']) && ($config['shop_shipment_time'] !== '')?$config['shop_shipment_time']:'0'); ?>天未发货，系统自动关闭,商品所花费金额退还到买家账户余额中</p>
                                <p class="help-block">3:商家发货后，买家超过<?php echo (isset($config['shop_receive_time']) && ($config['shop_receive_time'] !== '')?$config['shop_receive_time']:'0'); ?>天未确认收货，系统自动确认收货，商品所花费金额自动转到卖家账户余额中</p>
                                <p class="help-block">4:买家发起退款后,卖家超过<?php echo (isset($config['shop_refund_time']) && ($config['shop_refund_time'] !== '')?$config['shop_refund_time']:'0'); ?>天未做处理，系统自动退款，商品所花费金额自动转到买家账户余额中</p>
                                <p class="help-block">5:卖家拒绝买家退款后,买家不做任何操作,超过<?php echo (isset($config['shop_refund_finish_time']) && ($config['shop_refund_finish_time'] !== '')?$config['shop_refund_finish_time']:'0'); ?>天退款处理 系统自动完成，订单自动进入退款前状态</p>
                                <p class="help-block">6:买家确认收货后,<?php echo (isset($config['shop_receive_refund_time']) && ($config['shop_receive_refund_time'] !== '')?$config['shop_receive_refund_time']:'0'); ?>天内可以发起退货退款</p>
                                <p class="help-block">7:买家确认收货后,超过<?php echo (isset($config['shop_settlement_time']) && ($config['shop_settlement_time'] !== '')?$config['shop_settlement_time']:'0'); ?>天系统自动结算，将货款转给卖家</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="K">
                        <div class="form-group">
                            <label for="input-dynamic_auth" class="col-sm-2 control-label">动态认证开关</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[dynamic_auth]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['dynamic_auth'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-dynamic_switch" class="col-sm-2 control-label">动态审核</label>
                            <div class="col-md-6 col-sm-10">
								<select class="form-control w-80" name="options[dynamic_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['dynamic_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-comment_weight" class="col-sm-2 control-label">评论权重值</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-comment_weight" name="options[comment_weight]" value="<?php echo (isset($config['comment_weight']) && ($config['comment_weight'] !== '')?$config['comment_weight']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-like_weight" class="col-sm-2 control-label">点赞权重值</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-like_weight" name="options[like_weight]" value="<?php echo (isset($config['like_weight']) && ($config['like_weight'] !== '')?$config['like_weight']:''); ?>">
                            </div>
                        </div>
                        
                        

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="L">
                        <div class="form-group">
                            <label for="input-dynamic_auth" class="col-sm-2 control-label"></label>
                            <div class="col-md-6 col-sm-10">
								<span style="color:#ff0000">系统干预：人为控制游戏结果，保证平台收益<br>
                                    &nbsp;&nbsp;&nbsp;当进行系统干预时，<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;普通游戏：总是下注金额最少的位置获胜<br>
                                    <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上庄游戏：庄家全胜<br> -->
                                    &nbsp;&nbsp;&nbsp;&nbsp;不进行系统干预时：<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;游戏结果完全随机
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-shop_fans" class="col-sm-2 control-label">游戏开关</label>
                            <div class="col-md-6 col-sm-10">
                                <?php 
									$game1='1';
									$game3='3';
									$game4='4';
								 ?>
								<label class="checkbox-inline"><input type="checkbox" value="1" name="game_switch[]" <?php if(in_array(($game1), is_array($config['game_switch'])?$config['game_switch']:explode(',',$config['game_switch']))): ?>checked="checked"<?php endif; ?>>智勇三张</label>
								<label class="checkbox-inline"><input type="checkbox" value="3" name="game_switch[]" <?php if(in_array(($game3), is_array($config['game_switch'])?$config['game_switch']:explode(',',$config['game_switch']))): ?>checked="checked"<?php endif; ?>>转盘</label>
								<label class="checkbox-inline" style="display:none;"><input type="checkbox" value="4" name="game_switch[]" <?php if(in_array(($game4), is_array($config['game_switch'])?$config['game_switch']:explode(',',$config['game_switch']))): ?>checked="checked"<?php endif; ?>>开心牛仔</label>
                            </div>
                        </div>
                        
                        
                        <div class="form-group" style="display:none;">
                            <label for="input-game_banker_limit" class="col-sm-2 control-label">上庄限制</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-game_banker_limit" name="options[game_banker_limit]" value="<?php echo (isset($config['game_banker_limit']) && ($config['game_banker_limit'] !== '')?$config['game_banker_limit']:''); ?>"> 上庄游戏 申请上庄的用户拥有的钻石数的最低值
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-game_odds" class="col-sm-2 control-label">普通游戏赔率</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-game_odds" name="options[game_odds]" value="<?php echo (isset($config['game_odds']) && ($config['game_odds'] !== '')?$config['game_odds']:''); ?>">%
                                <p class="help-block">游戏结果不进行系统干预的概率，0 表示 完全进行 系统干预，平台绝对不会赔，100 表示完全随机</p>
                            </div>
                        </div>
                        
                        <div class="form-group" style="display:none;">
                            <label for="input-game_odds_p" class="col-sm-2 control-label">系统坐庄游戏赔率</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-game_odds_p" name="options[game_odds_p]" value="<?php echo (isset($config['game_odds_p']) && ($config['game_odds_p'] !== '')?$config['game_odds_p']:''); ?>">%
                                <p class="help-block">游戏结果不进行系统干预的概率 0 表示 完全进行 系统干预，庄家绝对不会赔，100 表示完全随机</p>
                            </div>
                        </div>
                        
                        <div class="form-group" style="display:none;">
                            <label for="input-game_odds_u" class="col-sm-2 control-label">用户坐庄游戏赔率</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-game_odds_u" name="options[game_odds_u]" value="<?php echo (isset($config['game_odds_u']) && ($config['game_odds_u'] !== '')?$config['game_odds_u']:''); ?>">%
                                <p class="help-block">游戏结果不进行系统干预的概率 0 表示 完全进行 系统干预，庄家绝对不会赔，100 表示完全随机</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-game_pump" class="col-sm-2 control-label">游戏抽水</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-game_pump" name="options[game_pump]" value="<?php echo (isset($config['game_pump']) && ($config['game_pump'] !== '')?$config['game_pump']:''); ?>">%
                                <p class="help-block">用户获胜后，去除本金部分的抽成比例 </p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-turntable_switch" class="col-sm-2 control-label">直播间大转盘开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[turntable_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['turntable_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="M">
                        
                        <div class="form-group">
                            <label for="input-express_type" class="col-sm-2 control-label">物流模式</label>
                            <div class="col-md-6 col-sm-10">
                                <label class="radio-inline"><input type="radio" name="options[express_type]" value="0" <?php if($config['express_type'] == '0'): ?>checked<?php endif; ?> >开发版</label>
                                <label class="radio-inline"><input type="radio" name="options[express_type]" value="1" <?php if($config['express_type'] == '1'): ?>checked<?php endif; ?> >正式版</label>
                                <p class="help-block">开发版仅适用于程序调试,每天查询最多500次,且只支持申通、圆通、百世、天天</p>
                                <p class="help-block">正式运营后,请购买三方套餐,将正式版电商用户ID和Api Key填写,并且将此处的物流模式切换为正式版；<a href="http://www.kdniao.com" target="_blank">立即购买</a></p>

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="input-express_id_dev" class="col-sm-2 control-label">用户ID（开发版）</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-express_id_dev" name="options[express_id_dev]" value="<?php echo (isset($config['express_id_dev']) && ($config['express_id_dev'] !== '')?$config['express_id_dev']:''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-express_appkey_dev" class="col-sm-2 control-label">Api Key（开发版）</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-express_appkey_dev" name="options[express_appkey_dev]" value="<?php echo (isset($config['express_appkey_dev']) && ($config['express_appkey_dev'] !== '')?$config['express_appkey_dev']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-express_id" class="col-sm-2 control-label">用户ID (正式版)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-express_id" name="options[express_id]" value="<?php echo (isset($config['express_id']) && ($config['express_id'] !== '')?$config['express_id']:''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-express_appkey" class="col-sm-2 control-label">Api Key (正式版)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-express_appkey" name="options[express_appkey]" value="<?php echo (isset($config['express_appkey']) && ($config['express_appkey'] !== '')?$config['express_appkey']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
					
					
                    <div class="tab-pane" id="N">

                        <div class="form-group">
                            <label for="input-dailytask_switch" class="col-sm-2 control-label">每日任务开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[dailytask_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($config['dailytask_switch'])): ?>
                                        <option value="1" <?php if($config['dailytask_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="input-watch_live_term" class="col-sm-2 control-label">观看直播</label>
                            <div class="col-md-6 col-sm-10"><br />
                                条件(分钟)：<input type="text" class="form-control" id="input-watch_live_term" name="options[watch_live_term]" value="<?php echo (isset($config['watch_live_term']) && ($config['watch_live_term'] !== '')?$config['watch_live_term']:'0'); ?>"><br />
                                奖励(钻石)：<input type="text" class="form-control" id="input-watch_live_coin" name="options[watch_live_coin]" value="<?php echo (isset($config['watch_live_coin']) && ($config['watch_live_coin'] !== '')?$config['watch_live_coin']:'0'); ?>">
								
								<br />注：切记!填写的条件和奖励一定要填写整数;例: 当用户观看直播时长达到X分钟时奖励X钻石
                            </div>
							
                        </div>
                       
						
						 <div class="form-group">
                            <label for="input-watch_video_term" class="col-sm-2 control-label">观看视频</label>
                            <div class="col-md-6 col-sm-10"><br />
                                条件(分钟)：<input type="text" class="form-control" id="input-watch_video_term" name="options[watch_video_term]" value="<?php echo (isset($config['watch_video_term']) && ($config['watch_video_term'] !== '')?$config['watch_video_term']:'0'); ?>"><br />
                                奖励(钻石)：<input type="text" class="form-control" id="input-watch_video_coin" name="options[watch_video_coin]" value="<?php echo (isset($config['watch_video_coin']) && ($config['watch_video_coin'] !== '')?$config['watch_video_coin']:'0'); ?>">
								<br />注：切记!填写的条件和奖励一定要填写整数;例: 当用户观看视频时长达到X分钟时奖励X钻石
                            </div>
							
                        </div>
						
						<div class="form-group">
                            <label for="input-open_live_term" class="col-sm-2 control-label">直播奖励</label>
                            <div class="col-md-6 col-sm-10"><br />
                                条件(小时)：<input type="text" class="form-control" id="input-open_live_term" name="options[open_live_term]" value="<?php echo (isset($config['open_live_term']) && ($config['open_live_term'] !== '')?$config['open_live_term']:'0'); ?>"><br />
                                奖励(钻石)：<input type="text" class="form-control" id="input-open_live_coin" name="options[open_live_coin]" value="<?php echo (isset($config['open_live_coin']) && ($config['open_live_coin'] !== '')?$config['open_live_coin']:'0'); ?>">
								<br />注：切记!填写的条件可以为整数也可以保留一位小数；奖励一定要填写整数;例: 当主播每天开播满足X小时可获得奖励X钻石
                            </div>
							
                        </div>
						
						
						<div class="form-group">
                            <label for="input-award_live_term" class="col-sm-2 control-label">打赏奖励</label>
                            <div class="col-md-6 col-sm-10"><br />
                                条件(钻石)：<input type="text" class="form-control" id="input-award_live_term" name="options[award_live_term]" value="<?php echo (isset($config['award_live_term']) && ($config['award_live_term'] !== '')?$config['award_live_term']:'0'); ?>"><br />
                                奖励(钻石)：<input type="text" class="form-control" id="input-award_live_coin" name="options[award_live_coin]" value="<?php echo (isset($config['award_live_coin']) && ($config['award_live_coin'] !== '')?$config['award_live_coin']:'0'); ?>">
								<br />注：切记!填写的条件和奖励一定要填写整数;例: 当用户打赏主播超过X钻石，奖励X钻石
                            </div>
							
                        </div>
						
						<div class="form-group">
                            <label for="input-share_live_term" class="col-sm-2 control-label">分享奖励</label>
                            <div class="col-md-6 col-sm-10"><br />
                                条件(次)：<input type="text" class="form-control" id="input-share_live_term" name="options[share_live_term]" value="<?php echo (isset($config['share_live_term']) && ($config['share_live_term'] !== '')?$config['share_live_term']:'0'); ?>"><br />
                                奖励(钻石)：<input type="text" class="form-control" id="input-share_live_coin" name="options[share_live_coin]" value="<?php echo (isset($config['share_live_coin']) && ($config['share_live_coin'] !== '')?$config['share_live_coin']:'0'); ?>">
								<br />注：切记!填写的条件和奖励一定要填写整数;例:用户每日分享直播间X次可获得奖励X钻石
                            </div>
							
                        </div>
                        
                       

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 云存储设置 -->
                    <div class="tab-pane" id="O">
                    
                        <div class="form-group">
                            <label for="input-cloudtype" class="col-sm-2 control-label">选择存储方式</label>
                            <div class="col-md-6 col-sm-10" id="cloudtype">
                                <label class="radio-inline"><input type="radio" value="1" name="options[cloudtype]" <?php if(in_array(($config['cloudtype']), explode(',',"1"))): ?>checked="checked"<?php endif; ?>>七牛云存储</label>
                                <label class="radio-inline"><input type="radio" value="2" name="options[cloudtype]" <?php if(in_array(($config['cloudtype']), explode(',',"2"))): ?>checked="checked"<?php endif; ?>>亚马逊存储</label>
                               
                            </div>
                        </div>
                        <div id="cloudtype_1" class="cloudtype_hide <?php if($config['cloudtype'] != '1'): ?>hide<?php endif; ?>">
                            <div class="form-group">
                                <label for="input-aws_bucket" class="col-sm-2 control-label"></label>
                                <div class="col-md-6 col-sm-10">
                                    <p class="help-block">七牛云存储信息请到插件中心--》插件列表里配置</p>
                                </div>
                            </div>
                        </div>
                        <div id="cloudtype_2" class="cloudtype_hide <?php if($config['cloudtype'] != '2'): ?>hide<?php endif; ?>" >
                            <div class="form-group">
                                <label for="input-aws_bucket" class="col-sm-2 control-label">亚马逊存储Bucket</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aws_bucket" name="options[aws_bucket]" value="<?php echo (isset($config['aws_bucket']) && ($config['aws_bucket'] !== '')?$config['aws_bucket']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-aws_region" class="col-sm-2 control-label">亚马逊存储region</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aws_region" name="options[aws_region]" value="<?php echo (isset($config['aws_region']) && ($config['aws_region'] !== '')?$config['aws_region']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-aws_hosturl" class="col-sm-2 control-label">亚马逊存储域名</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aws_hosturl" name="options[aws_hosturl]" value="<?php echo (isset($config['aws_hosturl']) && ($config['aws_hosturl'] !== '')?$config['aws_hosturl']:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-aws_identitypoolid" class="col-sm-2 control-label">亚马逊角色标识</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" class="form-control" id="input-aws_identitypoolid" name="options[aws_identitypoolid]" value="<?php echo (isset($config['aws_identitypoolid']) && ($config['aws_identitypoolid'] !== '')?$config['aws_identitypoolid']:''); ?>">APP端专用
                                </div>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- openinstall配置 -->
                    <div class="tab-pane" id="P">
                        
                        <div class="form-group">
                            <label for="input-openinstall_switch" class="col-sm-2 control-label">openinstall开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[openinstall_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['openinstall_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                                <p class="help-block">该功能打开时，用户扫描他人分享的邀请二维码下载APP，注册账号后，会自动建立上下级邀请关系</p>
                                <p class="help-block">该功能关闭后，用户下载APP后，需要通过填写邀请码的方式建立上下级邀请关系</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-openinstall_appkey" class="col-sm-2 control-label">openinstall AppKey</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-openinstall_appkey" name="options[openinstall_appkey]" value="<?php echo (isset($config['openinstall_appkey']) && ($config['openinstall_appkey'] !== '')?$config['openinstall_appkey']:''); ?>">
                            </div>
                        </div>
    
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
					
					<!-- 游戏设置 -->
                    <div class="tab-pane" id="Q">
						<div class="form-group">
                            <label for="input-game_xqtb_switch" class="col-sm-2 control-label">星球探宝游戏开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control" name="options[game_xqtb_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['game_xqtb_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="input-xqtb_mwx_price" class="col-sm-2 control-label">星球探宝冥王星寻宝1次消耗<?php echo $configpub['name_coin']; ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-xqtb_mwx_price"
                                       name="options[xqtb_mwx_price]" value="<?php echo (isset($config['xqtb_mwx_price']) && ($config['xqtb_mwx_price'] !== '')?$config['xqtb_mwx_price']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-xqtb_twx_price" class="col-sm-2 control-label">星球探宝天王星寻宝1次消耗<?php echo $configpub['name_coin']; ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-xqtb_twx_price"
                                       name="options[xqtb_twx_price]" value="<?php echo (isset($config['xqtb_twx_price']) && ($config['xqtb_twx_price'] !== '')?$config['xqtb_twx_price']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-xqtb_hwx_price" class="col-sm-2 control-label">星球探宝海王星寻宝1次消耗<?php echo $configpub['name_coin']; ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-xqtb_hwx_price"
                                       name="options[xqtb_hwx_price]" value="<?php echo (isset($config['xqtb_hwx_price']) && ($config['xqtb_hwx_price'] !== '')?$config['xqtb_hwx_price']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-game_xydzp_switch" class="col-sm-2 control-label">幸运大转盘游戏开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control" name="options[game_xydzp_switch]">
                                    <option value="0">关闭</option>
                                    <option value="1" <?php if($config['game_xydzp_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-xydzp_one_price" class="col-sm-2 control-label">幸运大转盘单击消耗<?php echo $configpub['name_coin']; ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-xydzp_one_price"
                                       name="options[xydzp_one_price]" value="<?php echo (isset($config['xydzp_one_price']) && ($config['xydzp_one_price'] !== '')?$config['xydzp_one_price']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-xydzp_ten_price" class="col-sm-2 control-label">幸运大转盘10连击消耗<?php echo $configpub['name_coin']; ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-xydzp_ten_price"
                                       name="options[xydzp_ten_price]" value="<?php echo (isset($config['xydzp_ten_price']) && ($config['xydzp_ten_price'] !== '')?$config['xydzp_ten_price']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-xydzp_hundred_price" class="col-sm-2 control-label">幸运大转盘100连击消耗<?php echo $configpub['name_coin']; ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-xydzp_hundred_price"
                                       name="options[xydzp_hundred_price]" value="<?php echo (isset($config['xydzp_hundred_price']) && ($config['xydzp_hundred_price'] !== '')?$config['xydzp_hundred_price']:''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
            
                    <!--新人奖励抖康币配置-->
                    <div class="tab-pane" id="R">
                        <div class="form-group">
                            <label for="input-new_coin_nums" class="col-sm-2 control-label">新用户奖励抖康币</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-new_coin_nums"
                                       name="options[new_coin_nums]" value="<?php echo (isset($config['new_coin_nums']) && ($config['new_coin_nums'] !== '')?$config['new_coin_nums']:''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
            
                    <!--直播权限说明-->
                    <div class="tab-pane" id="S">
                        <div class="form-group">
                            <label for="input-live_video_nums" class="col-sm-2 control-label">视频数量</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-live_video_nums"
                                       name="options[live_video_nums]" value="<?php echo (isset($config['live_video_nums']) && ($config['live_video_nums'] !== '')?$config['live_video_nums']:''); ?>">
                                <p class="help-block">用于开通直播视频数量 0~9999</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-live_fan_nums" class="col-sm-2 control-label">粉丝数量</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-live_fan_nums"
                                       name="options[live_fan_nums]" value="<?php echo (isset($config['live_fan_nums']) && ($config['live_fan_nums'] !== '')?$config['live_fan_nums']:''); ?>">
                                <p class="help-block">用于开通直播粉丝数量 0~9999999</p>
                            </div>
                          
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0">
                                    <?php echo lang('SAVE'); ?>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </fieldset>
    </form>

</div>
<script type="text/javascript" src="/static/js/admin.js"></script>
<script>
(function(){

    $('.btn-cancel-thumbnail2').click(function () {
        $('#thumbnail2-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
        $('#thumbnail2').val('');
    });
    

    $("#sdk label").on('click',function(){
        var v=$("input",this).val();
        if(v==1){
            $("#cdn label input[type=radio]").attr('disabled','disabled');
            $("#cdn label input[type=radio][value=2]").removeAttr('disabled');
            $("#cdn label").eq(1).click();
        }else{
            $("#cdn label input[type=radio]").removeAttr('disabled');
        }
    })
    
    $("#cdn label").on('click',function(){
        var v_d=$("input",this).attr('disabled');
        if(v_d=='disabled'){
            return !1;
        }
        var v=$("input",this).val();
        var b=$("#cdn_switch_"+v);
        $(".cdn_bd").hide();
        b.show();
    })
    
    $("#cloudtype label").on('click',function(){
        var v=$("input",this).val();
        var b=$("#cloudtype_"+v);
        $(".cloudtype_bd").siblings('.cloudtype_bd').hide();
        b.show();
    })
	
	$("#duanxin label").on('click',function(){
        var v_d=$("input",this).attr('disabled');
        if(v_d=='disabled'){
            return !1;
        }
        var v=$("input",this).val();
        console.log(v);
        var b=$("#typecode_switch_"+v);
        $(".code_bd").hide();
        b.show();
    })

     //云存储切换
    $("#cloudtype label.radio-inline").on('click',function(){
            var v=$("input",this).val();
    
            $(".cloudtype_hide").addClass('hide');
            
            $("#cloudtype_"+v).removeClass('hide');
        
    })
    
})()
</script>
</body>
</html>
