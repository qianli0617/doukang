<?php /*a:3:{s:101:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/admin/setting/site.html";i:1720519533;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
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

<style type="text/css">
    .w-80{
        width: 80px;
        border:1px solid #0babd1;
    }
</style>
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab"><?php echo lang('WEB_SITE_INFOS'); ?></a></li>
        <li><a href="#B" data-toggle="tab"><?php echo lang('SEO_SETTING'); ?></a></li>
        <li><a href="#C" data-toggle="tab">APP版本管理</a></li>
        <li><a href="#D" data-toggle="tab">登录开关</a></li>
        <li><a href="#E" data-toggle="tab">分享设置</a></li>
        <li><a href="#H" data-toggle="tab">直播管理</a></li>
        <li><a href="#I" data-toggle="tab">美颜/萌颜</a></li>
        <li><a href="#J" data-toggle="tab">付费内容</a></li>
        <li><a href="#K" data-toggle="tab">登录协议弹窗</a></li>
<!--        <li><a href="#L" data-toggle="tab">微信小程序版本管理</a></li>-->
        <li><a href="#M" data-toggle="tab">青少年模式设置</a></li>
        <li><a href="#N" data-toggle="tab">排行榜设置</a></li>
    </ul>
    <form class="form-horizontal js-ajax-form margin-top-20" role="form" action="<?php echo url('setting/sitePost'); ?>"
          method="post">
        <fieldset>
            <div class="tabbable">
                <div class="tab-content">
                    <div class="tab-pane active" id="A">
                        <div class="form-group">
                            <label for="input-site_name" class="col-sm-2 control-label"><span
                                    class="form-required"></span><?php echo lang('WEBSITE_NAME'); ?>--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-site-name" name="options[site_name]"
                                       value="<?php echo (isset($site_info['site_name']) && ($site_info['site_name'] !== '')?$site_info['site_name']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-site_name_en" class="col-sm-2 control-label"><span
                                    class="form-required"></span><?php echo lang('WEBSITE_NAME'); ?>--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-site_name_en" name="options[site_name_en]"
                                       value="<?php echo (isset($site_info['site_name_en']) && ($site_info['site_name_en'] !== '')?$site_info['site_name_en']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-site" class="col-sm-2 control-label"><span
                                    class="form-required"></span>网站域名</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-site-name" name="options[site]" value="<?php echo (isset($site_info['site']) && ($site_info['site'] !== '')?$site_info['site']:''); ?>">
                                <p class="help-block">格式： http(s)://xxxx.com(:端口号)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-maintain_switch" class="col-sm-2 control-label">网站是否维护</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[maintain_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($site_info['maintain_switch'])): ?>
                                        <option value="1" <?php if($site_info['maintain_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                                <p class="help-block">网站维护开启后，无法开启直播，进入直播间</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-maintain_tips" class="col-sm-2 control-label">维护提示--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-maintain_tips" name="options[maintain_tips]" ><?php echo (isset($site_info['maintain_tips']) && ($site_info['maintain_tips'] !== '')?$site_info['maintain_tips']:''); ?></textarea>
                                <p class="help-block">维护提示信息（200字以内）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-maintain_tips_en" class="col-sm-2 control-label">维护提示--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-maintain_tips_en" name="options[maintain_tips_en]" ><?php echo (isset($site_info['maintain_tips_en']) && ($site_info['maintain_tips_en'] !== '')?$site_info['maintain_tips_en']:''); ?></textarea>
                                <p class="help-block">维护提示信息（200字以内）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-company_name" class="col-sm-2 control-label">公司名称</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-company_name" name="options[company_name]"
                                       value="<?php echo (isset($site_info['company_name']) && ($site_info['company_name'] !== '')?$site_info['company_name']:''); ?>">
                                <p class="help-block">下载页关于我们使用</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  for="input-company_desc" class="col-sm-2 control-label">公司简介</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea  class="form-control" name="options[company_desc]"><?php echo (isset($site_info['company_desc']) && ($site_info['company_desc'] !== '')?$site_info['company_desc']:''); ?></textarea>
                                <p class="help-block">下载页关于我们使用,字数在200字以内</p>
                            </div>
                        </div>

                        <div class="form-group" style="display:none;">
                            <label for="input-admin_url_password" class="col-sm-2 control-label">
                                后台加密码
                                <a href="http://www.thinkcmf.com/faq.html?url=https://www.kancloud.cn/thinkcmf/faq/493509"
                                   title="查看帮助手册"
                                   data-toggle="tooltip"
                                   target="_blank"><i class="fa fa-question-circle"></i></a>
                            </label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-admin_url_password"
                                       name="admin_settings[admin_password]"
                                       value="<?php echo (isset($admin_settings['admin_password']) && ($admin_settings['admin_password'] !== '')?$admin_settings['admin_password']:''); ?>"
                                       id="js-site-admin-url-password">
                                <p class="help-block">英文字母数字，不能为纯数字</p>
                                <p class="help-block" style="color: red;">
                                    设置加密码后必须通过以下地址访问后台,请劳记此地址，为了安全，您也可以定期更换此加密码!</p>
                                <?php 
                                    $root=cmf_get_root();
                                    $root=empty($root)?'':'/'.$root;
                                    $site_domain = cmf_get_domain().$root;
                                 ?>
                                <p class="help-block">后台登录地址：<span id="js-site-admin-url"><?php echo $site_domain; ?>/<?php echo (isset($admin_settings['admin_password']) && ($admin_settings['admin_password'] !== '')?$admin_settings['admin_password']:'admin'); ?></span>
                                </p>
                            </div>
                        </div>

                        <div class="form-group" style="display:none;">
                            <label for="input-site_admin_theme" class="col-sm-2 control-label">后台模板</label>
                            <div class="col-md-6 col-sm-10">
                                <?php 
                                    $site_admin_theme=empty($admin_settings['admin_theme'])?'':$admin_settings['admin_theme'];
                                 ?>
                                <select class="form-control" name="admin_settings[admin_theme]"
                                        id="input-site_admin_theme">
                                    <?php if(is_array($admin_themes) || $admin_themes instanceof \think\Collection || $admin_themes instanceof \think\Paginator): if( count($admin_themes)==0 ) : echo "" ;else: foreach($admin_themes as $key=>$vo): $admin_theme_selected = $site_admin_theme == $vo ? "selected" : ""; ?>
                                        <option value="<?php echo $vo; ?>" <?php echo $admin_theme_selected; ?>><?php echo $vo; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label for="input-site_adminstyle" class="col-sm-2 control-label"><?php echo lang('WEBSITE_ADMIN_THEME'); ?></label>
                            <div class="col-md-6 col-sm-10">
                                <?php 
                                    $site_admin_style=empty($admin_settings['admin_style'])?cmf_get_admin_style():$admin_settings['admin_style'];
                                 ?>
                                <select class="form-control" name="admin_settings[admin_style]"
                                        id="input-site_adminstyle">
                                    <?php if(is_array($admin_styles) || $admin_styles instanceof \think\Collection || $admin_styles instanceof \think\Paginator): if( count($admin_styles)==0 ) : echo "" ;else: foreach($admin_styles as $key=>$vo): $admin_style_selected = $site_admin_style == $vo ? "selected" : ""; ?>
                                        <option value="<?php echo $vo; ?>" <?php echo $admin_style_selected; ?>><?php echo $vo; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-copyright" class="col-sm-2 control-label">版权信息</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-copyright" name="options[copyright]" ><?php echo (isset($site_info['copyright']) && ($site_info['copyright'] !== '')?$site_info['copyright']:''); ?></textarea>
                                <p class="help-block">版权信息（200字以内）PC首页和下载页用</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-copyright_url" class="col-sm-2 control-label">版权链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-copyright_url"
                                       name="options[copyright_url]"
                                       value="<?php echo (isset($site_info['copyright_url']) && ($site_info['copyright_url'] !== '')?$site_info['copyright_url']:''); ?>">
                            </div>
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label for="input-name_coin" class="col-sm-2 control-label">钻石名称&#45;&#45;中文</label>-->
<!--                            <div class="col-md-6 col-sm-10">-->
<!--                                <input type="text" class="form-control" id="input-name_coin" name="options[name_coin]"-->
<!--                                       value="<?php echo (isset($site_info['name_coin']) && ($site_info['name_coin'] !== '')?$site_info['name_coin']:''); ?>">-->
<!--                                <p class="help-block">用户充值得到的虚拟币名称</p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="form-group">-->
<!--                            <label for="input-name_coin_en" class="col-sm-2 control-label">钻石名称&#45;&#45;英文</label>-->
<!--                            <div class="col-md-6 col-sm-10">-->
<!--                                <input type="text" class="form-control" id="input-name_coin_en" name="options[name_coin_en]"-->
<!--                                       value="<?php echo (isset($site_info['name_coin_en']) && ($site_info['name_coin_en'] !== '')?$site_info['name_coin_en']:''); ?>">-->
<!--                                <p class="help-block">用户充值得到的虚拟币名称</p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="form-group">-->
<!--                            <label for="input-name_score" class="col-sm-2 control-label">积分名称&#45;&#45;中文</label>-->
<!--                            <div class="col-md-6 col-sm-10">-->
<!--                                <input type="text" class="form-control" id="input-name_score" name="options[name_score]"-->
<!--                                       value="<?php echo (isset($site_info['name_score']) && ($site_info['name_score'] !== '')?$site_info['name_score']:''); ?>">-->
<!--                                <p class="help-block">直播间玩游戏得到的虚拟币名称</p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="form-group">-->
<!--                            <label for="input-name_score_en" class="col-sm-2 control-label">积分名称&#45;&#45;英文</label>-->
<!--                            <div class="col-md-6 col-sm-10">-->
<!--                                <input type="text" class="form-control" id="input-name_score_en" name="options[name_score_en]"-->
<!--                                       value="<?php echo (isset($site_info['name_score_en']) && ($site_info['name_score_en'] !== '')?$site_info['name_score_en']:''); ?>">-->
<!--                                <p class="help-block">直播间玩游戏得到的虚拟币名称</p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="form-group">-->
<!--                            <label for="input-name_votes" class="col-sm-2 control-label">云票名称&#45;&#45;中文</label>-->
<!--                            <div class="col-md-6 col-sm-10">-->
<!--                                <input type="text" class="form-control" id="input-name_votes"-->
<!--                                       name="options[name_votes]"-->
<!--                                       value="<?php echo (isset($site_info['name_votes']) && ($site_info['name_votes'] !== '')?$site_info['name_votes']:''); ?>">-->
<!--                                <p class="help-block">主播获得的虚拟票名称</p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="form-group">-->
<!--                            <label for="input-name_votes_en" class="col-sm-2 control-label">云票名称&#45;&#45;英文</label>-->
<!--                            <div class="col-md-6 col-sm-10">-->
<!--                                <input type="text" class="form-control" id="input-name_votes_en"-->
<!--                                       name="options[name_votes_en]"-->
<!--                                       value="<?php echo (isset($site_info['name_votes_en']) && ($site_info['name_votes_en'] !== '')?$site_info['name_votes_en']:''); ?>">-->
<!--                                <p class="help-block">主播获得的虚拟票名称</p>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="form-group">
                            <label for="input-mobile" class="col-sm-2 control-label">公司电话</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-mobile"
                                       name="options[mobile]"
                                       value="<?php echo (isset($site_info['mobile']) && ($site_info['mobile'] !== '')?$site_info['mobile']:''); ?>">
                                <p class="help-block">PC首页用</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-address" class="col-sm-2 control-label">公司地址</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-address"
                                       name="options[address]"
                                       value="<?php echo (isset($site_info['address']) && ($site_info['address'] !== '')?$site_info['address']:''); ?>">
                                <p class="help-block">PC首页用</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_img" class="col-sm-2 control-label">APP登录页logo--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[login_img]" id="thumbnail7" value="<?php echo (isset($site_info['login_img']) && ($site_info['login_img'] !== '')?$site_info['login_img']:''); ?>">

                                <input type="hidden" name="options[login_img_old]"  value="<?php echo (isset($site_info['login_img']) && ($site_info['login_img'] !== '')?$site_info['login_img']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail7');">
                                    <?php if(empty($site_info['login_img'])): ?>
                                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail7-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                        <?php else: ?>
                                        <img src="<?php echo cmf_get_image_preview_url($site_info['login_img']); ?>"
                                             id="thumbnail7-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail7" value="取消图片">  APP登录页使用
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="input-login_img_en" class="col-sm-2 control-label">APP登录页logo--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[login_img_en]" id="thumbnail8" value="<?php echo (isset($site_info['login_img_en']) && ($site_info['login_img_en'] !== '')?$site_info['login_img_en']:''); ?>">

                                <input type="hidden" name="options[login_img_en_old]"  value="<?php echo (isset($site_info['login_img_en']) && ($site_info['login_img_en'] !== '')?$site_info['login_img_en']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail8');">
                                    <?php if(empty($site_info['login_img_en'])): ?>
                                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail8-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                        <?php else: ?>
                                        <img src="<?php echo cmf_get_image_preview_url($site_info['login_img_en']); ?>"
                                             id="thumbnail8-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail8" value="取消图片">  APP登录页使用
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-apk_ewm" class="col-sm-2 control-label">android版下载二维码</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[apk_ewm]" id="thumbnail1" value="<?php echo (isset($site_info['apk_ewm']) && ($site_info['apk_ewm'] !== '')?$site_info['apk_ewm']:''); ?>">

                                <input type="hidden" name="options[apk_ewm_old]"  value="<?php echo (isset($site_info['apk_ewm']) && ($site_info['apk_ewm'] !== '')?$site_info['apk_ewm']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail1');">
                                    <?php if(empty($site_info['apk_ewm'])): ?>
                                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail1-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                        <?php else: ?>
                                        <img src="<?php echo cmf_get_image_preview_url($site_info['apk_ewm']); ?>"
                                             id="thumbnail1-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail1" value="取消图片">  PC首页用
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-ipa_ewm" class="col-sm-2 control-label">iPhone版下载二维码</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[ipa_ewm]" id="thumbnail2" value="<?php echo (isset($site_info['ipa_ewm']) && ($site_info['ipa_ewm'] !== '')?$site_info['ipa_ewm']:''); ?>">
                                <input type="hidden" name="options[ipa_ewm_old]" value="<?php echo (isset($site_info['ipa_ewm']) && ($site_info['ipa_ewm'] !== '')?$site_info['ipa_ewm']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail2');">
                                    <?php if(empty($site_info['ipa_ewm'])): ?>
                                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail2-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                        <?php else: ?>
                                        <img src="<?php echo cmf_get_image_preview_url($site_info['ipa_ewm']); ?>"
                                             id="thumbnail2-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail2" value="取消图片">  PC首页用
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-wechat_ewm" class="col-sm-2 control-label">微信公众号</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[wechat_ewm]" id="thumbnail3" value="<?php echo (isset($site_info['wechat_ewm']) && ($site_info['wechat_ewm'] !== '')?$site_info['wechat_ewm']:''); ?>">
                                <input type="hidden" name="options[wechat_ewm_old]" value="<?php echo (isset($site_info['wechat_ewm']) && ($site_info['wechat_ewm'] !== '')?$site_info['wechat_ewm']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail3');">
                                    <?php if(empty($site_info['wechat_ewm'])): ?>
                                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail3-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                        <?php else: ?>
                                        <img src="<?php echo cmf_get_image_preview_url($site_info['wechat_ewm']); ?>"
                                             id="thumbnail3-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail3" value="取消图片"> PC首页用 建议尺寸  100 X 100
                            </div>
                        </div>

                        <div class="form-group" style="display:none;">
                            <label for="input-voicelive_icon" class="col-sm-2 control-label">语音聊天室图标</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[voicelive_icon]" id="thumbnail4" value="<?php echo (isset($site_info['voicelive_icon']) && ($site_info['voicelive_icon'] !== '')?$site_info['voicelive_icon']:''); ?>">
                                <input type="hidden" name="options[voicelive_icon_old]"  value="<?php echo (isset($site_info['voicelive_icon']) && ($site_info['voicelive_icon'] !== '')?$site_info['voicelive_icon']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail4');">
                                    <?php if(empty($site_info['voicelive_icon'])): ?>
                                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail4-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                        <?php else: ?>
                                        <img src="<?php echo cmf_get_image_preview_url($site_info['voicelive_icon']); ?>"
                                             id="thumbnail4-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail4" value="取消图片"> APP首页使用 建议尺寸  50 X 50
                                <p class="help-block">用于APP首页顶部分类显示</p>
                            </div>
                        </div>

                        <div class="form-group" style="display:none;">
                            <label for="input-voicelive_name" class="col-sm-2 control-label">语音聊天室名称</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-voicelive_name"
                                       name="options[voicelive_name]"
                                       value="<?php echo (isset($site_info['voicelive_name']) && ($site_info['voicelive_name'] !== '')?$site_info['voicelive_name']:''); ?>">
                                <p class="help-block">用于APP首页顶部分类显示</p>
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
                            <label for="input-site_seo_title" class="col-sm-2 control-label"><?php echo lang('WEBSITE_SEO_TITLE'); ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-site_seo_title"
                                       name="options[site_seo_title]" value="<?php echo (isset($site_info['site_seo_title']) && ($site_info['site_seo_title'] !== '')?$site_info['site_seo_title']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-site_seo_keywords" class="col-sm-2 control-label"><?php echo lang('WEBSITE_SEO_KEYWORDS'); ?></label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-site_seo_keywords"
                                       name="options[site_seo_keywords]"
                                       value="<?php echo (isset($site_info['site_seo_keywords']) && ($site_info['site_seo_keywords'] !== '')?$site_info['site_seo_keywords']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-site_seo_description" class="col-sm-2 control-label"><?php echo lang('WEBSITE_SEO_DESCRIPTION'); ?></label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-site_seo_description"
                                          name="options[site_seo_description]"><?php echo (isset($site_info['site_seo_description']) && ($site_info['site_seo_description'] !== '')?$site_info['site_seo_description']:''); ?></textarea>
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
                            <label for="input-isup" class="col-sm-2 control-label">强制更新</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[isup]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($site_info['isup'])): ?>
                                        <option value="1" <?php if($site_info['isup'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-apk_ver" class="col-sm-2 control-label">APK版本号</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-apk_ver"
                                       name="options[apk_ver]" value="<?php echo (isset($site_info['apk_ver']) && ($site_info['apk_ver'] !== '')?$site_info['apk_ver']:''); ?>">
                                <p class="help-block">安卓APP最新的版本号，请勿随意修改</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-apk_url" class="col-sm-2 control-label">APK下载链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-apk_url"
                                       name="options[apk_url]" value="<?php echo (isset($site_info['apk_url']) && ($site_info['apk_url'] !== '')?$site_info['apk_url']:''); ?>">
                                <p class="help-block">安卓最新版APK下载链接</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-apk_des" class="col-sm-2 control-label">APK更新说明--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-apk_des"
                                          name="options[apk_des]"><?php echo (isset($site_info['apk_des']) && ($site_info['apk_des'] !== '')?$site_info['apk_des']:''); ?></textarea>
                                <p class="help-block">APK更新说明（200字以内）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-apk_des_en" class="col-sm-2 control-label">APK更新说明--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-apk_des_en"
                                          name="options[apk_des_en]"><?php echo (isset($site_info['apk_des_en']) && ($site_info['apk_des_en'] !== '')?$site_info['apk_des_en']:''); ?></textarea>
                                <p class="help-block">APK更新说明（200字以内）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-ipa_ver" class="col-sm-2 control-label">IPA版本号</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-ipa_ver"
                                       name="options[ipa_ver]" value="<?php echo (isset($site_info['ipa_ver']) && ($site_info['ipa_ver'] !== '')?$site_info['ipa_ver']:''); ?>">
                                <p class="help-block">IOS APP最新的版本号，请勿随意修改</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-ios_shelves" class="col-sm-2 control-label">IPA上架版本号</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-ios_shelves"
                                       name="options[ios_shelves]" value="<?php echo (isset($site_info['ios_shelves']) && ($site_info['ios_shelves'] !== '')?$site_info['ios_shelves']:''); ?>">
                                <p class="help-block">IOS上架审核中版本的版本号(用于上架期间隐藏上架版本部分功能,不要和IPA版本号相同)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-ipa_url" class="col-sm-2 control-label">IPA下载链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-ipa_url"
                                       name="options[ipa_url]" value="<?php echo (isset($site_info['ipa_url']) && ($site_info['ipa_url'] !== '')?$site_info['ipa_url']:''); ?>">
                                <p class="help-block">IOS最新版IPA下载链接</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-ipa_des" class="col-sm-2 control-label">IPA更新说明--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-ipa_des"
                                          name="options[ipa_des]"><?php echo (isset($site_info['ipa_des']) && ($site_info['ipa_des'] !== '')?$site_info['ipa_des']:''); ?></textarea>
                                <p class="help-block">IPA更新说明（200字以内）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-ipa_des_en" class="col-sm-2 control-label">IPA更新说明--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-ipa_des_en"
                                          name="options[ipa_des_en]"><?php echo (isset($site_info['ipa_des_en']) && ($site_info['ipa_des_en'] !== '')?$site_info['ipa_des_en']:''); ?></textarea>
                                <p class="help-block">IPA更新说明（200字以内）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-qr_url" class="col-sm-2 control-label">二维码下载链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="hidden" name="options[qr_url]" id="thumbnail6" value="<?php echo (isset($site_info['qr_url']) && ($site_info['qr_url'] !== '')?$site_info['qr_url']:''); ?>">
                                <input type="hidden" name="options[qr_url_old]" value="<?php echo (isset($site_info['qr_url']) && ($site_info['qr_url'] !== '')?$site_info['qr_url']:''); ?>">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail6');">
                                    <?php if(empty($site_info['qr_url'])): ?>
                                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                             id="thumbnail6-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                        <?php else: ?>
                                        <img src="<?php echo cmf_get_image_preview_url($site_info['qr_url']); ?>"
                                             id="thumbnail6-preview"
                                             style="cursor: pointer;max-width:150px;max-height:150px;"/>
                                    <?php endif; ?>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail6" value="取消图片">
                                <p class="help-block">PC下载页面用 二维码生成链接：<?php echo $site_info['site']; ?>/portal/index/scanqr   </p>
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
                            <label for="input-site-name" class="col-sm-2 control-label">登录方式</label>
                            <div class="col-md-6 col-sm-10">
                                <?php 
                                    $qq='qq';
                                    $wx='wx';
                                    $sina='sina';
                                    $facebook='facebook';
                                    $twitter='twitter';
                                    $ios='ios';
                                 if(isset($site_info['login_type'])): ?>
                                    <label class="checkbox-inline"><input type="checkbox" value="qq" name="login_type[]" <?php if(in_array(($qq), is_array($site_info['login_type'])?$site_info['login_type']:explode(',',$site_info['login_type']))): ?>checked="checked"<?php endif; ?>>QQ</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="wx" name="login_type[]" <?php if(in_array(($wx), is_array($site_info['login_type'])?$site_info['login_type']:explode(',',$site_info['login_type']))): ?>checked="checked"<?php endif; ?>>微信</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="facebook" name="login_type[]" <?php if(in_array(($facebook), is_array($site_info['login_type'])?$site_info['login_type']:explode(',',$site_info['login_type']))): ?>checked="checked"<?php endif; ?>>FaceBook</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="twitter" name="login_type[]" <?php if(in_array(($twitter), is_array($site_info['login_type'])?$site_info['login_type']:explode(',',$site_info['login_type']))): ?>checked="checked"<?php endif; ?>>Twitter</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="ios" name="login_type[]" <?php if(in_array(($ios), is_array($site_info['login_type'])?$site_info['login_type']:explode(',',$site_info['login_type']))): ?>checked="checked"<?php endif; ?>>iOS</label>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-site-name" class="col-sm-2 control-label">分享方式</label>
                            <div class="col-md-6 col-sm-10">
                                <?php 
                                    $share_qq='qq';
                                    $share_qzone='qzone';
                                    $share_wx='wx';
                                    $share_wchat='wchat';
                                    $share_sina='sina';
                                    $share_facebook='facebook';
                                    $share_twitter='twitter';
                                 if(isset($site_info['share_type'])): ?>
                                    <label class="checkbox-inline"><input type="checkbox" value="qq" name="share_type[]" <?php if(in_array(($share_qq), is_array($site_info['share_type'])?$site_info['share_type']:explode(',',$site_info['share_type']))): ?>checked="checked"<?php endif; ?>>QQ</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="qzone" name="share_type[]" <?php if(in_array(($share_qzone), is_array($site_info['share_type'])?$site_info['share_type']:explode(',',$site_info['share_type']))): ?>checked="checked"<?php endif; ?>>QQ空间</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="wx" name="share_type[]" <?php if(in_array(($share_wx), is_array($site_info['share_type'])?$site_info['share_type']:explode(',',$site_info['share_type']))): ?>checked="checked"<?php endif; ?>>微信</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="wchat" name="share_type[]" <?php if(in_array(($share_wchat), is_array($site_info['share_type'])?$site_info['share_type']:explode(',',$site_info['share_type']))): ?>checked="checked"<?php endif; ?>>微信朋友圈</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="facebook" name="share_type[]" <?php if(in_array(($share_facebook), is_array($site_info['share_type'])?$site_info['share_type']:explode(',',$site_info['share_type']))): ?>checked="checked"<?php endif; ?>>FaceBook</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="twitter" name="share_type[]" <?php if(in_array(($share_twitter), is_array($site_info['share_type'])?$site_info['share_type']:explode(',',$site_info['share_type']))): ?>checked="checked"<?php endif; ?>>Twitter</label>
                                <?php endif; ?>
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
                            <label for="input-wx_siteurl" class="col-sm-2 control-label">微信推广域名</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wx_siteurl"
                                       name="options[wx_siteurl]" value="<?php echo (isset($site_info['wx_siteurl']) && ($site_info['wx_siteurl'] !== '')?$site_info['wx_siteurl']:''); ?>">
                                <p class="help-block">http:// 开头 参数值为用户ID</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-share_title" class="col-sm-2 control-label">直播分享标题--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-share_title"
                                       name="options[share_title]" value="<?php echo (isset($site_info['share_title']) && ($site_info['share_title'] !== '')?$site_info['share_title']:''); ?>">
                                <p class="help-block">{username}代表了用户昵称，分享时，app端会将该变量替换为直播用户的昵称，格式必须固定为{username}；如果不需要显示直播用户的昵称，此处可以不配置{username}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-share_title_en" class="col-sm-2 control-label">直播分享标题--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-share_title_en"
                                       name="options[share_title_en]" value="<?php echo (isset($site_info['share_title_en']) && ($site_info['share_title_en'] !== '')?$site_info['share_title_en']:''); ?>">
                                <p class="help-block">{username}代表了用户昵称，分享时，app端会将该变量替换为直播用户的昵称，格式必须固定为{username}；如果不需要显示直播用户的昵称，此处可以不配置{username}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-share_des" class="col-sm-2 control-label">直播分享话术--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-share_des"
                                       name="options[share_des]" value="<?php echo (isset($site_info['share_des']) && ($site_info['share_des'] !== '')?$site_info['share_des']:''); ?>">
                                <p class="help-block">如果直播有标题，分享出去的简介就显示直播标题；如果直播没有标题，分享出去的简介就显示该处设置的默认话术</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-share_des_en" class="col-sm-2 control-label">直播分享话术--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-share_des_en"
                                       name="options[share_des_en]" value="<?php echo (isset($site_info['share_des_en']) && ($site_info['share_des_en'] !== '')?$site_info['share_des_en']:''); ?>">
                                <p class="help-block">如果直播有标题，分享出去的简介就显示直播标题；如果直播没有标题，分享出去的简介就显示该处设置的默认话术</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-app_android" class="col-sm-2 control-label">AndroidAPP下载链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-app_android"
                                       name="options[app_android]" value="<?php echo (isset($site_info['app_android']) && ($site_info['app_android'] !== '')?$site_info['app_android']:''); ?>">
                                <p class="help-block">分享用Android APP 下载链接</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-app_ios" class="col-sm-2 control-label">IOSAPP下载链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-app_ios"
                                       name="options[app_ios]" value="<?php echo (isset($site_info['app_ios']) && ($site_info['app_ios'] !== '')?$site_info['app_ios']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-video_share_title" class="col-sm-2 control-label">短视频分享标题--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-video_share_title"
                                       name="options[video_share_title]" value="<?php echo (isset($site_info['video_share_title']) && ($site_info['video_share_title'] !== '')?$site_info['video_share_title']:''); ?>">
                                <p class="help-block">{username}代表了用户昵称，分享时，app端会将该变量替换为视频用户的昵称，格式必须固定为{username}；如果不需要显示视频用户的昵称，此处可以不配置{username}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-video_share_title_en" class="col-sm-2 control-label">短视频分享标题--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-video_share_title_en"
                                       name="options[video_share_title_en]" value="<?php echo (isset($site_info['video_share_title_en']) && ($site_info['video_share_title_en'] !== '')?$site_info['video_share_title_en']:''); ?>">
                                <p class="help-block">{username}代表了用户昵称，分享时，app端会将该变量替换为视频用户的昵称，格式必须固定为{username}；如果不需要显示视频用户的昵称，此处可以不配置{username}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-video_share_des" class="col-sm-2 control-label">短视频分享话术--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-video_share_des"
                                       name="options[video_share_des]" value="<?php echo (isset($site_info['video_share_des']) && ($site_info['video_share_des'] !== '')?$site_info['video_share_des']:''); ?>">
                                <p class="help-block">如果视频有标题，分享出去的简介就显示视频标题;如果视频没有标题，分享出去的简介就显示该处设置的默认话术</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-video_share_des_en" class="col-sm-2 control-label">短视频分享话术--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-video_share_des_en"
                                       name="options[video_share_des_en]" value="<?php echo (isset($site_info['video_share_des_en']) && ($site_info['video_share_des_en'] !== '')?$site_info['video_share_des_en']:''); ?>">
                                <p class="help-block">如果视频有标题，分享出去的简介就显示视频标题;如果视频没有标题，分享出去的简介就显示该处设置的默认话术</p>
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
                            <label for="input-site-name" class="col-sm-2 control-label">房间类型</label>
                            <div class="col-md-6 col-sm-10">
                                <?php 
                                    $type_0='0;普通房间';
                                    $type_1='1;密码房间';
                                    $type_2='2;门票房间';
                                    $type_3='3;计时房间';
                                 if(isset($site_info['live_type'])): ?>
                                    <label class="checkbox-inline hide"><input type="checkbox" value="0;普通房间" name="live_type[]" checked="checked">普通房间</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="1;密码房间" name="live_type[]" <?php if(in_array(($type_1), is_array($site_info['live_type'])?$site_info['live_type']:explode(',',$site_info['live_type']))): ?>checked="checked"<?php endif; ?>>密码房间</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="2;门票房间" name="live_type[]" <?php if(in_array(($type_2), is_array($site_info['live_type'])?$site_info['live_type']:explode(',',$site_info['live_type']))): ?>checked="checked"<?php endif; ?>>门票房间</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="3;计时房间" name="live_type[]" <?php if(in_array(($type_3), is_array($site_info['live_type'])?$site_info['live_type']:explode(',',$site_info['live_type']))): ?>checked="checked"<?php endif; ?>>计时房间</label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-live_time_coin" class="col-sm-2 control-label">计时直播收费</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-live_time_coin"
                                       name="options[live_time_coin]" value="<?php echo (isset($site_info['live_time_coin']) && ($site_info['live_time_coin'] !== '')?$site_info['live_time_coin']:''); ?>">
                                <p class="help-block">计时直播收费，价格梯度用 , 分割 例：1,2,3</p>
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
                            <label for="input-sprout_appid" class="col-sm-2 control-label">萌颜APPID-Andriod</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-sprout_appid"
                                       name="options[sprout_appid]" value="<?php echo (isset($site_info['sprout_appid']) && ($site_info['sprout_appid'] !== '')?$site_info['sprout_appid']:''); ?>">
                                <p class="help-block">留空 表示使用默认美颜</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-sprout_key" class="col-sm-2 control-label">萌颜授权码-Andriod</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-sprout_key"
                                       name="options[sprout_key]" value="<?php echo (isset($site_info['sprout_key']) && ($site_info['sprout_key'] !== '')?$site_info['sprout_key']:''); ?>">
                                <p class="help-block">留空 表示使用默认美颜</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-sprout_appid_ios" class="col-sm-2 control-label">萌颜APPID-iOS</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-sprout_appid_ios"
                                       name="options[sprout_appid_ios]" value="<?php echo (isset($site_info['sprout_appid_ios']) && ($site_info['sprout_appid_ios'] !== '')?$site_info['sprout_appid_ios']:''); ?>">
                                <p class="help-block">留空 表示使用默认美颜</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-sprout_key_ios" class="col-sm-2 control-label">萌颜授权码-IOS</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-sprout_key_ios"
                                       name="options[sprout_key_ios]" value="<?php echo (isset($site_info['sprout_key_ios']) && ($site_info['sprout_key_ios'] !== '')?$site_info['sprout_key_ios']:''); ?>">
                                <p class="help-block">留空 表示使用默认美颜</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-sprout_white" class="col-sm-2 control-label">美颜</label>
                            <div class="col-md-6 col-sm-10">
                                美白：<input type="text" class="form-control control3" name="options[skin_whiting]" value="<?php echo (isset($site_info['skin_whiting']) && ($site_info['skin_whiting'] !== '')?$site_info['skin_whiting']:'0'); ?>" > <br><br>
                                磨皮：<input type="text" class="form-control control3" name="options[skin_smooth]" value="<?php echo (isset($site_info['skin_smooth']) && ($site_info['skin_smooth'] !== '')?$site_info['skin_smooth']:'0'); ?>" > <br><br>
                                红润：<input type="text" class="form-control control3" name="options[skin_tenderness]" value="<?php echo (isset($site_info['skin_tenderness']) && ($site_info['skin_tenderness'] !== '')?$site_info['skin_tenderness']:'0'); ?>" > <br><br>
                                <p class="help-block">0-9 整数</p>
                                亮度：<input type="text" class="form-control control3" name="options[brightness]" value="<?php echo (isset($site_info['brightness']) && ($site_info['brightness'] !== '')?$site_info['brightness']:'0'); ?>" > <br><br>
                                <p class="help-block">0-100 整数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-sprout_skin" class="col-sm-2 control-label">磨皮默认值</label>
                            <div class="col-md-6 col-sm-10">
                                眉毛：<input type="text" class="form-control control3" name="options[eye_brow]" value="<?php echo (isset($site_info['eye_brow']) && ($site_info['eye_brow'] !== '')?$site_info['eye_brow']:'0'); ?>" > <br><br>
                                大眼：<input type="text" class="form-control control3" name="options[big_eye]" value="<?php echo (isset($site_info['big_eye']) && ($site_info['big_eye'] !== '')?$site_info['big_eye']:'0'); ?>" > <br><br>
                                眼距：<input type="text" class="form-control control3" name="options[eye_length]" value="<?php echo (isset($site_info['eye_length']) && ($site_info['eye_length'] !== '')?$site_info['eye_length']:'0'); ?>" > <br><br>
                                眼角：<input type="text" class="form-control control3" name="options[eye_corner]" value="<?php echo (isset($site_info['eye_corner']) && ($site_info['eye_corner'] !== '')?$site_info['eye_corner']:'0'); ?>" > <br><br>
                                开眼角：<input type="text" class="form-control control3" name="options[eye_alat]" value="<?php echo (isset($site_info['eye_alat']) && ($site_info['eye_alat'] !== '')?$site_info['eye_alat']:'0'); ?>" > <br><br>
                                瘦脸：<input type="text" class="form-control control3" name="options[face_lift]" value="<?php echo (isset($site_info['face_lift']) && ($site_info['face_lift'] !== '')?$site_info['face_lift']:'0'); ?>" > <br><br>
                                削脸：<input type="text" class="form-control control3" name="options[face_shave]" value="<?php echo (isset($site_info['face_shave']) && ($site_info['face_shave'] !== '')?$site_info['face_shave']:'0'); ?>" > <br><br>
                                嘴形：<input type="text" class="form-control control3" name="options[mouse_lift]" value="<?php echo (isset($site_info['mouse_lift']) && ($site_info['mouse_lift'] !== '')?$site_info['mouse_lift']:'0'); ?>" > <br><br>
                                瘦鼻：<input type="text" class="form-control control3" name="options[nose_lift]" value="<?php echo (isset($site_info['nose_lift']) && ($site_info['nose_lift'] !== '')?$site_info['nose_lift']:'0'); ?>" > <br><br>
                                下巴：<input type="text" class="form-control control3" name="options[chin_lift]" value="<?php echo (isset($site_info['chin_lift']) && ($site_info['chin_lift'] !== '')?$site_info['chin_lift']:'0'); ?>" > <br><br>
                                额头：<input type="text" class="form-control control3" name="options[forehead_lift]" value="<?php echo (isset($site_info['forehead_lift']) && ($site_info['forehead_lift'] !== '')?$site_info['forehead_lift']:'0'); ?>" > <br><br>
                                长鼻：<input type="text" class="form-control control3" name="options[lengthen_noseLift]" value="<?php echo (isset($site_info['lengthen_noseLift']) && ($site_info['lengthen_noseLift'] !== '')?$site_info['lengthen_noseLift']:'0'); ?>" > <br><br>
                                <p class="help-block">0-100 整数</p>
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
                    <div class="tab-pane" id="G">
                        <div class="form-group">
                            <label for="input-cdn_static_root" class="col-sm-2 control-label">静态资源cdn地址</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-cdn_static_root"
                                       name="cdn_settings[cdn_static_root]"
                                       value="<?php echo (isset($cdn_settings['cdn_static_root']) && ($cdn_settings['cdn_static_root'] !== '')?$cdn_settings['cdn_static_root']:''); ?>">
                                <p class="help-block">
                                    不能以/结尾；设置这个地址后，请将ThinkCMF下的静态资源文件放在其下面；<br>
                                    ThinkCMF下的静态资源文件大致包含以下(如果你自定义后，请自行增加)：<br>
                                    themes/admin_simplebootx/public/assets<br>
                                    static<br>
                                    themes/simplebootx/public/assets<br>
                                    例如未设置cdn前：jquery的访问地址是/static/js/jquery.js, <br>
                                    设置cdn是后它的访问地址就是：静态资源cdn地址/static/js/jquery.js
                                </p>
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
                            <label for="input-payment_des" class="col-sm-2 control-label">付费内容申请说明--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" style="min-height: 200px;" id="input-payment_des"
                                          name="options[payment_des]"><?php echo (isset($site_info['payment_des']) && ($site_info['payment_des'] !== '')?$site_info['payment_des']:''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-payment_des_en" class="col-sm-2 control-label">付费内容申请说明--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" style="min-height: 200px;" id="input-payment_des_en"
                                          name="options[payment_des_en]"><?php echo (isset($site_info['payment_des_en']) && ($site_info['payment_des_en'] !== '')?$site_info['payment_des_en']:''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-payment_time" class="col-sm-2 control-label">申请付费内容间隔天数(天)</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-payment_time"
                                       name="options[payment_time]" value="<?php echo (isset($site_info['payment_time']) && ($site_info['payment_time'] !== '')?$site_info['payment_time']:'0'); ?>">
                                <p class="help-block">申请付费内容被拒后再次申请的间隔天数</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-payment_percent" class="col-sm-2 control-label">付费内容默认抽水比例</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-payment_percent"
                                       name="options[payment_percent]" value="<?php echo (isset($site_info['payment_percent']) && ($site_info['payment_percent'] !== '')?$site_info['payment_percent']:'0'); ?>">
                                <p class="help-block">0-100之间的整数,用户购买付费内容时,给发布者结算时的抽水比例</p>
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
                            <label for="input-login_alert_title" class="col-sm-2 control-label"><span
                                    class="form-required"></span>弹框标题--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_alert_title" name="options[login_alert_title]" value="<?php echo (isset($site_info['login_alert_title']) && ($site_info['login_alert_title'] !== '')?$site_info['login_alert_title']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_alert_title_en" class="col-sm-2 control-label"><span
                                    class="form-required"></span>弹框标题--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_alert_title_en" name="options[login_alert_title_en]" value="<?php echo (isset($site_info['login_alert_title_en']) && ($site_info['login_alert_title_en'] !== '')?$site_info['login_alert_title_en']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_alert_content" class="col-sm-2 control-label">弹框内容--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-login_alert_content" name="options[login_alert_content]" ><?php echo (isset($site_info['login_alert_content']) && ($site_info['login_alert_content'] !== '')?$site_info['login_alert_content']:''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_alert_content_en" class="col-sm-2 control-label">弹框内容--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-login_alert_content_en" name="options[login_alert_content_en]" ><?php echo (isset($site_info['login_alert_content_en']) && ($site_info['login_alert_content_en'] !== '')?$site_info['login_alert_content_en']:''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_clause_title" class="col-sm-2 control-label"><span
                                    class="form-required"></span>APP登录界面底部协议标题--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_clause_title" name="options[login_clause_title]" value="<?php echo (isset($site_info['login_clause_title']) && ($site_info['login_clause_title'] !== '')?$site_info['login_clause_title']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_clause_title_en" class="col-sm-2 control-label"><span
                                    class="form-required"></span>APP登录界面底部协议标题--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_clause_title_en" name="options[login_clause_title_en]" value="<?php echo (isset($site_info['login_clause_title_en']) && ($site_info['login_clause_title_en'] !== '')?$site_info['login_clause_title_en']:''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_private_title" class="col-sm-2 control-label"><span
                                    class="form-required"></span>隐私政策名称--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_private_title" name="options[login_private_title]" value="<?php echo (isset($site_info['login_private_title']) && ($site_info['login_private_title'] !== '')?$site_info['login_private_title']:''); ?>">
                                <p class="help-block">填写的名称必须与弹框内容和登录界面底部协议标题中填写的名称相符</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_private_title_en" class="col-sm-2 control-label"><span
                                    class="form-required"></span>隐私政策名称--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_private_title_en" name="options[login_private_title_en]" value="<?php echo (isset($site_info['login_private_title_en']) && ($site_info['login_private_title_en'] !== '')?$site_info['login_private_title_en']:''); ?>">
                                <p class="help-block">填写的名称必须与弹框内容和登录界面底部协议标题中填写的名称相符</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_private_url" class="col-sm-2 control-label"><span
                                    class="form-required"></span>隐私政策跳转链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_private_url" name="options[login_private_url]" value="<?php echo (isset($site_info['login_private_url']) && ($site_info['login_private_url'] !== '')?$site_info['login_private_url']:''); ?>">
                                <p class="help-block">本站链接请以/开头，如：/portal/page/index?id=3 外链请以http://或https://开头</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-login_service_title" class="col-sm-2 control-label"><span
                                    class="form-required"></span>服务协议名称--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_service_title" name="options[login_service_title]" value="<?php echo (isset($site_info['login_service_title']) && ($site_info['login_service_title'] !== '')?$site_info['login_service_title']:''); ?>">
                                <p class="help-block">填写的名称必须与弹框内容和登录界面底部协议标题中填写的名称相符</p>
                            </div>


                        </div>

                        <div class="form-group">
                            <label for="input-login_service_title_en" class="col-sm-2 control-label"><span
                                    class="form-required"></span>服务协议名称--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_service_title_en" name="options[login_service_title_en]" value="<?php echo (isset($site_info['login_service_title_en']) && ($site_info['login_service_title_en'] !== '')?$site_info['login_service_title_en']:''); ?>">
                                <p class="help-block">填写的名称必须与弹框内容和登录界面底部协议标题中填写的名称相符</p>
                            </div>


                        </div>

                        <div class="form-group">
                            <label for="input-login_service_url" class="col-sm-2 control-label"><span
                                    class="form-required"></span>服务协议跳转链接</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-login_service_url" name="options[login_service_url]" value="<?php echo (isset($site_info['login_service_url']) && ($site_info['login_service_url'] !== '')?$site_info['login_service_url']:''); ?>">
                                <p class="help-block">本站链接请以/开头，如：/portal/page/index?id=4 外链请以http://或https://开头</p>
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

                    <div class="tab-pane" id="L">

                        <div class="form-group">
                            <label for="input-wxmini_version" class="col-sm-2 control-label">微信小程序当前版本号</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wxmini_version"
                                       name="options[wxmini_version]" value="<?php echo (isset($site_info['wxmini_version']) && ($site_info['wxmini_version'] !== '')?$site_info['wxmini_version']:''); ?>">
                                <p class="help-block">直播微信小程序最新的版本号，请勿随意修改</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-wxmini_shelves_version" class="col-sm-2 control-label">微信小程序上架版本号</label>
                            <div class="col-md-6 col-sm-10">
                                <input type="text" class="form-control" id="input-wxmini_shelves_version"
                                       name="options[wxmini_shelves_version]" value="<?php echo (isset($site_info['wxmini_shelves_version']) && ($site_info['wxmini_shelves_version'] !== '')?$site_info['wxmini_shelves_version']:''); ?>">
                                <p class="help-block">直播微信小程序上架审核中版本的版本号(用于上架期间隐藏上架版本直播间钻石充值、个人中心钻石充值功能)，如果上架版本号与当前版本号相同时，上述功能将被隐藏。</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-wxmini_des" class="col-sm-2 control-label">微信小程序更新说明</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-wxmini_des"
                                          name="options[wxmini_des]"><?php echo (isset($site_info['wxmini_des']) && ($site_info['wxmini_des'] !== '')?$site_info['wxmini_des']:''); ?></textarea>
                                <p class="help-block">微信小程序更新说明（200字以内）</p>
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

                    <!-- 青少年模式 -->
                    <div class="tab-pane" id="M">


                        <div class="form-group">
                            <label for="input-teenager_des" class="col-sm-2 control-label">青少年模式提示语--中文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-teenager_des"
                                          name="options[teenager_des]"><?php echo (isset($site_info['teenager_des']) && ($site_info['teenager_des'] !== '')?$site_info['teenager_des']:''); ?></textarea>
                                <p class="help-block">青少年模式提示语（200字以内）</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-teenager_des_en" class="col-sm-2 control-label">青少年模式提示语--英文</label>
                            <div class="col-md-6 col-sm-10">
                                <textarea class="form-control" id="input-teenager_des_en"
                                          name="options[teenager_des_en]"><?php echo (isset($site_info['teenager_des_en']) && ($site_info['teenager_des_en'] !== '')?$site_info['teenager_des_en']:''); ?></textarea>
                                <p class="help-block">青少年模式提示语（200字以内）</p>
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

                    <!-- 排行榜设置 -->
                    <div class="tab-pane" id="N">

                        <div class="form-group">
                            <label for="input-leaderboard_switch" class="col-sm-2 control-label">排行榜开关</label>
                            <div class="col-md-6 col-sm-10">
                                <select class="form-control w-80" name="options[leaderboard_switch]">
                                    <option value="0">关闭</option>
                                    <?php if(isset($site_info['leaderboard_switch'])): ?>
                                        <option value="1" <?php if($site_info['leaderboard_switch'] == '1'): ?>selected<?php endif; ?>>开启</option>
                                    <?php endif; ?>
                                </select>
                                <p class="help-block">关闭后，APP端首页不显示排行榜入口</p>
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
<script type="text/javascript">
    (function(){
        $('.btn-cancel-thumbnail1').click(function () {
            $('#thumbnail1-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail1').val('');
        });

        $('.btn-cancel-thumbnail2').click(function () {
            $('#thumbnail2-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail2').val('');
        });

        $('.btn-cancel-thumbnail3').click(function () {
            $('#thumbnail3-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail3').val('');
        });

        $('.btn-cancel-thumbnail4').click(function () {
            $('#thumbnail4-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail4').val('');
        });

        $('.btn-cancel-thumbnail5').click(function () {
            $('#thumbnail5-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail5').val('');
        });

        $('.btn-cancel-thumbnail6').click(function () {
            $('#thumbnail6-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail6').val('');
        });

        $('.btn-cancel-thumbnail7').click(function () {
            $('#thumbnail7-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail7').val('');
        });

        $('.btn-cancel-thumbnail8').click(function () {
            $('#thumbnail8-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail8').val('');
        });

    })()

</script>
</body>
</html>
