<?php /*a:3:{s:105:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/user/admin_index/index.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
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
    .table img{
        width:25px;
        height:25px;
    }

    #pop{
        display:none;
    }

    .red_title{
        color: #F00;
    }
</style>
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a><?php echo lang('USER_INDEXADMIN_INDEX'); ?></a></li>
        <li><a href="<?php echo url('adminIndex/add'); ?>"><?php echo lang('ADD'); ?></a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('user/adminIndex/index'); ?>">

        僵尸粉开关：
        <select class="form-control" name="iszombie">
            <option value="">全部</option>
            <option value="1" <?php if(input('request.iszombie') != '' && input('request.iszombie') == 1): ?>selected<?php endif; ?>>开启</option>
            <option value="0" <?php if(input('request.iszombie') != '' && input('request.iszombie') == 0): ?>selected<?php endif; ?>>关闭</option>
        </select>
        僵尸粉：
        <select class="form-control" name="iszombiep">
            <option value="">全部</option>
            <option value="1" <?php if(input('request.iszombiep') != '' && input('request.iszombiep') == 1): ?>selected<?php endif; ?>>是</option>
            <option value="0" <?php if(input('request.iszombiep') != '' && input('request.iszombiep') == 0): ?>selected<?php endif; ?>>否</option>
        </select>

        拉黑：
        <select class="form-control" name="isban">
            <option value="">全部</option>
            <option value="1" <?php if(input('request.isban') != '' && input('request.isban') == 1): ?>selected<?php endif; ?>>是</option>
            <option value="0" <?php if(input('request.isban') != '' && input('request.isban') == 0): ?>selected<?php endif; ?>>否</option>
        </select>

        禁用：
        <select class="form-control" name="disable">
            <option value="">全部</option>
            <option value="1" <?php if(input('request.disable') != '' && input('request.disable') == 1): ?>selected<?php endif; ?>>是</option>
            <option value="0" <?php if(input('request.disable') != '' && input('request.disable') == 0): ?>selected<?php endif; ?>>否</option>
        </select>

        热门：
        <select class="form-control" name="ishot">
            <option value="">全部</option>
            <option value="1" <?php if(input('request.ishot') != '' && input('request.ishot') == 1): ?>selected<?php endif; ?>>是</option>
            <option value="0" <?php if(input('request.ishot') != '' && input('request.ishot') == 0): ?>selected<?php endif; ?>>否</option>
        </select>

        超管：
        <select class="form-control" name="issuper">
            <option value="">全部</option>
            <option value="1" <?php if(input('request.issuper') != '' && input('request.issuper') == 1): ?>selected<?php endif; ?>>是</option>
            <option value="0" <?php if(input('request.issuper') != '' && input('request.issuper') == 0): ?>selected<?php endif; ?>>否</option>
        </select>
        设备来源：
        <select class="form-control" name="source">
            <option value="">全部</option>
            <option value="pc" <?php if(input('request.source') != '' && input('request.source') == 'pc'): ?>selected<?php endif; ?>>PC</option>
            <option value="android" <?php if(input('request.source') != '' && input('request.source') == 'android'): ?>selected<?php endif; ?>>安卓APP</option>
            <option value="ios" <?php if(input('request.source') != '' && input('request.source') == 'ios'): ?>selected<?php endif; ?>>苹果APP</option>
        </select>

        提交时间：
        <input class="form-control js-bootstrap-date" name="start_time" id="start_time" autocomplete="off" value="<?php echo input('request.start_time'); ?>" aria-invalid="false" style="width: 110px;"> -
        <input class="form-control js-bootstrap-date" name="end_time" id="end_time" autocomplete='off' value="<?php echo input('request.end_time'); ?>" aria-invalid="false" style="width: 110px;">

        用户ID：
        <input class="form-control" type="text" name="uid" style="width: 200px;" value="<?php echo input('request.uid'); ?>"
               placeholder="请输入用户ID或靓号">
        关键字：
        <input class="form-control" type="text" name="keyword" style="width: 200px;" value="<?php echo input('request.keyword'); ?>"
               placeholder="用户名/昵称">
        <input type="submit" class="btn btn-primary" value="搜索"/>
        <a class="btn btn-danger" href="<?php echo url('user/adminIndex/index'); ?>">清空</a>
        <br>
        <br>
        用户数：<?php echo $nums; ?>  (根据条件统计)
    </form>
    <form method="post" class="js-ajax-form">
        <div class="table-actions">
            <button class="btn btn-danger btn-sm js-ajax-submit" type="submit" data-action="<?php echo url('user/adminIndex/setzombiepall',array('iszombiep'=>1)); ?>"
                    data-subcheck="true" data-msg="您确定要进行此操作吗？">批量设置为僵尸粉
            </button>
            <button class="btn btn-danger btn-sm js-ajax-submit" type="submit" data-action="<?php echo url('user/adminIndex/setzombiepall',array('iszombiep'=>0)); ?>"
                    data-subcheck="true" data-msg="您确定要进行此操作吗？">批量取消僵尸粉
            </button>

            <button class="btn btn-danger btn-sm js-ajax-submit" type="submit" data-action="<?php echo url('user/adminIndex/setzombieall',array('iszombie'=>1)); ?>" data-msg="您确定要进行此操作吗？">一键开启僵尸粉
            </button>
            <button class="btn btn-danger btn-sm js-ajax-submit" type="submit" data-action="<?php echo url('user/adminIndex/setzombieall',array('iszombie'=>0)); ?>" data-msg="您确定要进行此操作吗？">一键关闭僵尸粉
            </button>
        </div>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th width="16">
                    <label>
                        <input type="checkbox" class="js-check-all" data-direction="x" data-checklist="js-check-x">
                    </label>
                </th>
                <th>ID</th>
                <th>国家/地区</th>
                <th><?php echo lang('USERNAME'); ?></th>
                <th><?php echo lang('NICENAME'); ?></th>
                <th><?php echo lang('AVATAR'); ?></th>
                <th>手机</th>
                <th><?php echo $name_coin; ?>余额</th>
                <th>累计消费<?php echo $name_coin; ?></th>
                <th><?php echo $name_votes; ?>余额</th>
                <th>累计<?php echo $name_votes; ?></th>
                <th>人民币余额</th>
                <th>累计收入人民币</th>
                <th>人民币累计消费</th>
                <th>邀请码</th>
                <th>注册设备</th>
                <th>广告视频发布者</th>
                <th><?php echo lang('REGISTRATION_TIME'); ?></th>
                <th><?php echo lang('LAST_LOGIN_TIME'); ?></th>
                <th><?php echo lang('LAST_LOGIN_IP'); ?></th>
                <th><?php echo lang('STATUS'); ?></th>
                <th><?php echo lang('ACTIONS'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php 
                $user_statuses=array("0"=>lang('USER_STATUS_BLOCKED'),"1"=>lang('USER_STATUS_ACTIVATED'),"2"=>lang('USER_STATUS_UNVERIFIED'),"3"=>"已禁用");$isAd=array("0"=>"否","1"=>"是");
             if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="js-check" data-yid="js-check-y" data-xid="js-check-x" name="ids[]" value="<?php echo $vo['id']; ?>">
                    </td>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php if($vo['login_type'] == 'phone'): ?><?php echo $vo['country_name']; else: ?>--<?php endif; ?></td>
                    <td><?php echo !empty($vo['user_login']) ? $vo['user_login'] : ($vo['mobile']?$vo['mobile']:lang('THIRD_PARTY_USER')); ?>
                    </td>
                    <td><?php echo !empty($vo['user_nickname']) ? $vo['user_nickname'] : lang('NOT_FILLED'); ?></td>
                    <td><img width="25" height="25" src="<?php echo $vo['avatar']; ?>"/></td>
                    <td><?php echo $vo['mobile']; ?></td>
                    <td><?php echo $vo['coin']; ?></td>
                    <td><?php echo $vo['consumption']; ?></td>
                    <td><?php echo $vo['votes']; ?></td>
                    <td><?php echo $vo['votestotal']; ?></td>
                    <td><?php echo $vo['balance']; ?></td>
                    <td><?php echo $vo['balance_total']; ?></td>
                    <td><?php echo $vo['balance_consumption']; ?></td>
                    <td><?php echo $vo['code']; ?></td>
                    <td><?php echo $vo['source']; ?></td>
                    <td><?php echo $isAd[$vo['is_ad']]; ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$vo['create_time']); ?></td>
                    <td><?php if($vo['last_login_time'] > 0): ?><?php echo date('Y-m-d H:i:s',$vo['last_login_time']); else: ?>--<?php endif; ?></td>
                    <td><?php echo $vo['last_login_ip']; ?></td>
                    <td>
                        <?php if($vo['user_status'] == '3'): ?>
                            已注销
                            <?php else: if($vo['user_status'] == 0): ?>
                                <span class="label label-danger"><?php echo $user_statuses[0]; ?></span>
                                <?php elseif($vo['user_status'] == 1 && $vo['end_bantime'] > $nowtime): ?>
                                    <span class="label label-danger"><?php echo $user_statuses[3]; ?></span>
                                    <br />
                                    截止到:<?php echo date('Y-m-d',$vo['end_bantime']); else: ?>
                                    <span class="label label-success"><?php echo $user_statuses[1]; ?></span>
                            <?php endif; ?>

                        <?php endif; ?>

                    </td>
                    <td>
                        <?php if($vo['user_status'] == '3'): ?>
                            <!-- 已注销 -->



                            <?php else: ?>
                            <!-- 未注销 -->

                            <?php if($vo['user_status'] == 0): ?>
                                <a class="btn btn-xs btn-success js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/cancelban',array('id'=>$vo['id'])); ?>"
                                   data-msg="<?php echo lang('ACTIVATE_USER_CONFIRM_MESSAGE'); ?>"><?php echo lang('ACTIVATE_USER'); ?></a>
                                <!-- 启用 -->
                                <?php else: if($vo['end_bantime'] > $nowtime): ?>
                                    <a class="btn btn-xs btn-success js-ajax-dialog-btn"
                                       href="<?php echo url('adminIndex/cancelban',array('id'=>$vo['id'])); ?>"
                                       data-msg="<?php echo lang('ACTIVATE_USER_CONFIRM_MESSAGE'); ?>"><?php echo lang('ACTIVATE_USER'); ?></a>
                                    <!-- 启用 -->
                                    <?php else: ?>
                                    <!--  -->
                                    <a class="btn btn-xs btn-warning"
                                       href="javascript:void(0);"
                                       onclick="showlayer(<?php echo $vo['id']; ?>)">禁用</a>
                                <?php endif; ?>

                                <a class="btn btn-xs btn-warning js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/ban',array('id'=>$vo['id'])); ?>"
                                   data-msg="您确定要拉黑此用户吗？">拉黑</a>
                            <?php endif; if($vo['live_ban'] == '1'): ?>
                                <a class="btn btn-xs btn-warning js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/cancelLiveBan',array('id'=>$vo['id'])); ?>"
                                   data-msg="您确定要将此用户直播间解封吗？">解封直播</a>
                            <?php endif; if($vo['issuper'] == '1'): ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setsuper',array('id'=>$vo['id'],'issuper'=>0)); ?>">取消超管</a>
                                <?php else: ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setsuper',array('id'=>$vo['id'],'issuper'=>1)); ?>">设置超管</a>
                            <?php endif; if($vo['ishot'] == '1'): ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/sethot',array('id'=>$vo['id'],'ishot'=>0)); ?>">取消热门</a>
                                <?php else: ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/sethot',array('id'=>$vo['id'],'ishot'=>1)); ?>">热门</a>
                            <?php endif; if($vo['isrecommend'] == '1'): ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setrecommend',array('id'=>$vo['id'],'isrecommend'=>0)); ?>">取消推荐</a>
                                <?php else: ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setrecommend',array('id'=>$vo['id'],'isrecommend'=>1)); ?>">推荐</a>
                            <?php endif; if($vo['iszombie'] == '1'): ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setzombie',array('id'=>$vo['id'],'iszombie'=>0)); ?>">关闭僵尸粉</a>
                                <?php else: ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setzombie',array('id'=>$vo['id'],'iszombie'=>1)); ?>">开启僵尸粉</a>
                            <?php endif; if($vo['iszombiep'] == '1'): ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setzombiep',array('id'=>$vo['id'],'iszombiep'=>0)); ?>">取消设置僵尸粉</a>
                                <?php else: ?>
                                <a class="btn btn-xs btn-info js-ajax-dialog-btn"
                                   href="<?php echo url('adminIndex/setzombiep',array('id'=>$vo['id'],'iszombiep'=>1)); ?>">设置为僵尸粉</a>
                            <?php endif; ?>

                        <?php endif; ?>


                        <a class="btn btn-xs btn-primary" href='<?php echo url("adminIndex/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
                        <a class="btn btn-xs btn-danger js-ajax-delete" href="<?php echo url('adminIndex/del',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination"><?php echo $page; ?></div>
    </form>
</div>

<div id="pop">
    <div class="wrap" style="padding-bottom:40px;">
        <form method="post" class="form-horizontal margin-top-20">
            <div class="form-group">
                <label for="input-user_login" class="col-sm-2 control-label"><span class="form-required">*</span>禁用截止日期</label>
                <div class="col-md-6 col-sm-10">
                    <input class="form-control js-bootstrap-date" name="ban_long" contenteditable="off" id="ban_long" value="" aria-invalid="false">
                </div>
            </div>

            <div class="form-group">
                <label for="input-user_login" class="col-sm-2 control-label"><span class="form-required">*</span>禁用原因</label>
                <div class="col-md-6 col-sm-10">
                    <textarea class="form-control" id="ban_reason" name="ban_reason" placeholder="200字以内"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="xiajia_submit()">禁用</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/static/js/admin.js"></script>
<script src="/static/js/laydate/laydate.js"></script>
<script>
    Wind.use('layer');
    var clickuid='0';
    function showlayer(id){
        clickuid=id;
        layer.open({
            type: 1,
            title: '禁用',
            shadeClose: true,
            shade: 0.8,
            area: ['800px', '300px'],
            content: $('#pop'),
            success:function(){
                laydate.render({
                    elem: '#ban_long',//指定元素
                    trigger: 'click'
                });
            }
        });
    }


    var xiajia_status=0;
    function xiajia_submit(){
        var ban_long=$("#ban_long").val();
        var reason=$("#ban_reason").val();

        if(ban_long==''){
            layer.msg("请选择禁用截止日期");
            return;
        }

        if(reason==''){
            layer.msg("请填写禁用原因");
            return;
        }

        if(reason.length>200){
            layer.msg("禁用原因必须在200字以内");
            return;
        }

        if(xiajia_status==1){
            return;
        }
        xiajia_status=1;
        $.ajax({
            url: '<?php echo url('user/adminIndex/setBan'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {id:clickuid,reason: reason,ban_long:ban_long},
        success:function(data){
            var code=data.code;
            if(code==0){
                layer.msg(data.msg);
                return !1;
            }

            xiajia_status=0;

            layer.msg("操作成功",{},function(){
                //layer.closeAll();
                clickuid=0;
                $("#ban_long").val("");
                $("#ban_reason").attr("value","");
                layer.closeAll();
                reloadPage(window);
            });
        },
        error:function(e){
        }
    });

    }
</script>
</body>
</html>