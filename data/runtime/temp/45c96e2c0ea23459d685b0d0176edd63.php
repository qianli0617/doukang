<?php /*a:3:{s:99:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/admin/main/index.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
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

<link href="/static/css/admin_index.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="content">
        <div class="content_title">
            实时统计
        </div>
		 <div class="statistics basic">
            <div class="title">待办事项</div>
            <div class="bd" style="padding-left: 5px;">
				<style>
					.stay li{
						border: 1px solid rgb(204 204 204 / 25%);
						padding: 5px 15px;
						border-radius: 28px;
						height: 38px;
						font-size: 14px;
						margin-right: 30px;
						margin-top: 5px;
						margin-bottom: 15px;
						float: left;
						background-color: rgb(204 204 204 / 25%);
						color: rgb(0 0 0 / 84%);
						
					}
					.stay li span{
						color: #00d0a9;
						font-size: 16px;
					}
				
				</style>
			
				<ul class="stay clear">
				
					<a href="<?php echo url('auth/index'); ?>"><li>用户认证待审核数量( <span><?php echo $stayinfo['auth_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('shopapply/index'); ?>"><li>直播小店待审核数量( <span><?php echo $stayinfo['shopapply_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('shopgoods/index'); ?>"><li>小店商品待审核数量( <span><?php echo $stayinfo['shopgoods_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('refundlist/index'); ?>"><li>小店商品退款需平台介入待处理数量( <span><?php echo $stayinfo['shop_order_refund_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('report/index'); ?>"><li>直播间举报待处理数量( <span><?php echo $stayinfo['liverepot_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('Dynamic/wait',array('isdel'=>0,'status'=>0)); ?>"><li>动态待审核数量( <span><?php echo $stayinfo['dynamic_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('Dynamicrepot/index'); ?>"><li>动态举报数量( <span><?php echo $stayinfo['dynamicrepot_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('video/wait',array('isdel'=>0,'status'=>0,'is_draft'=>0)); ?>"><li>视频待审核数量( <span><?php echo $stayinfo['video_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('videorep/index'); ?>"><li>视频举报数量( <span><?php echo $stayinfo['videorepot_count']; ?></span> )</li></a>

					
					<a href="<?php echo url('paidprogram/index'); ?>"><li>付费内容待审核数量( <span><?php echo $stayinfo['paidprogram_count']; ?></span> )</li></a>
					
					<a href="<?php echo url('paidprogram/applylist'); ?>"><li>付费内容申请待审核数量( <span><?php echo $stayinfo['paidprogram_applylist_count']; ?></span> )</li></a>




					<a href="<?php echo url('family/index'); ?>"><li>家族待审核数量( <span><?php echo $stayinfo['family_count']; ?></span> )</li></a>
				
					<a href="<?php echo url('familyuser/divideapply'); ?>"><li>家族分成申请数量( <span><?php echo $stayinfo['familyuser_count']; ?></span> )</li></a>
					
					<li class="hide"></li>
				
				</ul>
			</div>
        </div>
        <div class="statistics basic">
            <div class="title">基本指标</div>
            <div class="bd">
                <div class="bd_title">
                    <input type="hidden" class="action" value='1'>
                    <div class="dropdown">
                        <div class="dropdown_input"  data-type="1">
                            今日
                        </div>
                        <div class="dropdown_list">
                            <ul>
                                <li data-type="1">今日</li>
                                <li data-type="2">昨日</li>
                                <li data-type="3">近7日</li>
                                <li data-type="4">近30日</li>
                            </ul>
                        </div>
                    </div>
                    <div class="data_select">
                        <input type="text" name="start_time" class="form-control js-bootstrap-date" value="" style="width: 80px;display:inline-block;" autocomplete="off">-
                        <input type="text" class="form-control js-bootstrap-date" name="end_time" value="" style="width: 80px;display:inline-block;" autocomplete="off">
                    </div>
                    <div class="search">
                        查询
                    </div>
                    <div class="export">
                        导出
                    </div>
                </div>
                <div class="basic_list clear">
                    <ul>
                        <li class="active on" data-type="1">
                            <div class="basic_list_t">新增用户</div>
                            <div class="basic_list_n"><span><?php echo $basic_today['newUsers']; ?></span></div>
                        </li>
                        <li class="active" data-type="2">
                            <div class="basic_list_t">APP启动次数</div>
                            <div class="basic_list_n"><span><?php echo $basic_today['launches']; ?></span></div>
                        </li>
                        
                        <li class="active" data-type="4">
                            <div class="basic_list_t">活跃用户数</div>
                            <div class="basic_list_n"><span><?php echo $basic_today['activityUsers']; ?></span></div>
                        </li>
                        <li class="active" data-type="3">
                            <div class="basic_list_t">平均使用时长</div>
                            <div class="basic_list_n"><span>0</span>分钟</div>
                        </li>
                        
                        <!-- <li class="active" data-type="5">
                            <div class="basic_list_t">留存用户数</div>
                            <div class="basic_list_n"><?php echo $basic_today['launches']; ?></div>
                        </li> -->
                        <li>
                            <div class="basic_list_t">总注册数</div>
                            <div class="basic_list_n"><span><?php echo $users_total; ?></span></div>
                        </li>
                    </ul>
                </div>
                <div id="echarts_basic" style="width:100%;height:300px;"></div>
            </div>
        </div>
        <div class="statistics w50 mr10 source">
            <div class="title">设备终端</div>
            <div class="bd">
                <div id="echarts_source" style="width:100%;height:300px;"></div>
            </div>
        </div>
        <div class="statistics w50 reg">
            <div class="title">注册渠道</div>
            <div class="bd">
                <div id="echarts_reg" style="width:100%;height:300px;"></div>
            </div>
        </div>
<!--         <div class="statistics clear users">
            <div class="title">用户画像</div>
            <div class="bd">
                <div class="bd_title">
                    <div class="users_tab clear">
                        <ul>
                            <li class="on">新增用户</li>
                            <li>活跃用户</li>
                            <li>启动次数</li>
                        </ul>
                    </div>
                    <input type="hidden" class="action" value='2'>
                    <div class="search">
                        查询
                    </div>
                    <div class="data_select">
                        <input type="text" name="start_time" class="js-date date" value="" style="width: 80px;" autocomplete="off">-
                        <input type="text" class="js-date date" name="end_time" value="" style="width: 80px;" autocomplete="off">
                    </div>
                    <div class="dropdown">
                        <div class="dropdown_input" data-type="1">
                            今日
                        </div>
                        <div class="dropdown_list">
                            <ul>
                                <li data-type="1">今日</li>
                                <li data-type="2">昨日</li>
                                <li data-type="3">近7日</li>
                                <li data-type="4">近30日</li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div id="echarts_users" style="width:100%;height:300px;"></div>
            </div>
        </div> -->
        <div class="statistics w33 mr10 anchor">
            <div class="title">主播数据</div>
            <div class="bd">
                <div class="bd_title">
                    <input type="hidden" class="action" value='3'>
                    <div class="dropdown">
                        <div class="dropdown_input" data-type="1">
                            今日
                        </div>
                        <div class="dropdown_list">
                            <ul>
                                <li data-type="1">今日</li>
                                <li data-type="2">昨日</li>
                                <li data-type="3">近7日</li>
                                <li data-type="4">近30日</li>
                            </ul>
                        </div>
                    </div>
                    <div class="data_select">
                        <input type="text" name="start_time" class="form-control js-bootstrap-date" value="" style="width: 80px;display:inline-block;" autocomplete="off">-
                        <input type="text" class="form-control js-bootstrap-date" name="end_time" value="" style="width: 80px;display:inline-block;" autocomplete="off">
                        
                    </div>
                    <div class="search">
                        查询
                    </div>
                    <div class="export">
                        导出
                    </div>
                </div>
                <div class="data_list">
                    <ul>
                        <li>
                            <div class="data_list_left">主播总数</div>
                            <div class="data_list_right"><?php echo number_format($anchor['anchor_total']); ?>位</div>
                        </li>
                        <li>
                            <div class="data_list_left">在线主播</div>
                            <div class="data_list_right"><?php echo number_format($anchor['anchor_online']); ?>位</div>
                        </li>
                        <li>
                            <div class="data_list_left">直播次数</div>
                            <div class="data_list_right"><span id="anchor_live_today"><?php echo $anchor['anchor_live_today']; ?></span>次</div>
                        </li>
                        <li>
                            <div class="data_list_left">直播时长</div>
                            <div class="data_list_right"><span id="anchor_live_long_today"><?php echo $anchor['anchor_live_long_today']; ?></span>分钟</div>
                        </li>
                        <li class="last">
                            <div class="data_list_left">总直播时长</div>
                            <div class="data_list_right"><?php echo $anchor['anchor_live_long_total']; ?>分钟</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="statistics w33 mr10 votestotal">
            <div class="title">网红榜</div>
            <div class="bd">
                <div class="list">
                    <ul>
                        <?php if(is_array($votes_list) || $votes_list instanceof \think\Collection || $votes_list instanceof \think\Paginator): $i = 0; $__LIST__ = $votes_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <li>
                            <img class="list_order" src="/static/images/<?php echo $i; ?>.png">
                            <img class="list_avatar" src="<?php echo $v['avatar']; ?>">
                            <div class="list_info">
                                <p class="list_name"><?php echo $v['user_nickname']; ?></p>
                                <p>累计收益<span><?php echo number_format($v['votestotal']); ?></span><?php echo $config['name_votes']; ?></p>
                            </div>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="statistics w33 rich">
            <div class="title">富豪榜</div>
            <div class="bd">
                <div class="list">
                    <ul>
                        <?php if(is_array($rich_list) || $rich_list instanceof \think\Collection || $rich_list instanceof \think\Paginator): $i = 0; $__LIST__ = $rich_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <li>
                            <img class="list_order" src="/static/images/<?php echo $i; ?>.png">
                            <img class="list_avatar" src="<?php echo $v['avatar']; ?>">
                            <div class="list_info">
                                <p class="list_name"><?php echo $v['user_nickname']; ?></p>
                                <p>累计送出<span><?php echo number_format($v['consumption']); ?><span><?php echo $config['name_coin']; ?></p>
                            </div>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="statistics clear charge">
            <div class="title">财务</div>
            <div class="bd">
                <div class="bd_title">
                    <input type="hidden" class="action" value='4'>
                    <div class="dropdown">
                        <div class="dropdown_input" data-type="1">
                            今日
                        </div>
                        <div class="dropdown_list">
                            <ul>
                                <li data-type="1">今日</li>
                                <li data-type="2">昨日</li>
                                <li data-type="3">近7日</li>
                                <li data-type="4">近30日</li>
                            </ul>
                        </div>
                    </div>
                    <div class="data_select">
                        <input type="text" name="start_time" class="form-control js-bootstrap-date" value="" style="width: 80px;display:inline-block;" autocomplete="off">-
                        <input type="text" class="form-control js-bootstrap-date" name="end_time" value="" style="width: 80px;display:inline-block;" autocomplete="off">
                    </div>
                    <div class="search">
                        查询
                    </div>
                    <div class="export">
                        导出
                    </div>
                    <div class="charge_total">
                        历史总收益
                        <span><?php echo $charge_total; ?> 元</span>
                    </div>
                </div>
                <div id="echarts_charge" style="width:100%;height:400px;"></div>
            </div>
        </div>
        <div class="statistics cash">
            <div class="title">提现</div>
            <div class="bd">
                <div class="bd_title">
                    <input type="hidden" class="action" value='5'>
                    <div class="dropdown">
                        <div class="dropdown_input" data-type="1">
                            今日
                        </div>
                        <div class="dropdown_list">
                            <ul>
                                <li data-type="1">今日</li>
                                <li data-type="2">昨日</li>
                                <li data-type="3">近7日</li>
                                <li data-type="4">近30日</li>
                            </ul>
                        </div>
                    </div>
                    <div class="data_select">
                        <input type="text" name="start_time" class="form-control js-bootstrap-date" value="" style="width: 80px;display:inline-block;" autocomplete="off">-
                        <input type="text" class="form-control js-bootstrap-date" name="end_time" value="" style="width: 80px;display:inline-block;" autocomplete="off">
                    </div>
                    <div class="search">
                        查询
                    </div>
                    <div class="export">
                        导出
                    </div>
                </div>
                <div class="cash_list clear">
                    <ul>
                        <li>
                            <div class="cash_list_t">申请提现金额</div>
                            <div class="cash_list_m"><span id="cash_apply"><?php echo $cashinfo['cash_apply']; ?></span> 元</div>
                            <div class="cash_list_h">
                                <!-- <a>查看列表</a> -->
                            </div>
                        </li>
                        <li>
                            <div class="cash_list_t">已通过金额</div>
                            <div class="cash_list_m"><span id="cash_adopt"><?php echo $cashinfo['cash_adopt']; ?></span> 元</div>
                            <div class="cash_list_h">
                                <!-- <a>查看列表</a> -->
                            </div>
                        </li>
                        <li>
                            <div class="cash_list_t">主播提现数量</div>
                            <div class="cash_list_m"><span id="cash_anchor"><?php echo $cashinfo['cash_anchor']; ?></span> 位</div>
                            <div class="cash_list_h">
                                <!-- <a>查看列表</a> -->
                            </div>
                        </li>
                        <li class="last">
                            <div class="cash_list_t">总提现金额</div>
                            <div class="cash_list_m"><?php echo $cash_total; ?> 元</div>
                            <div class="cash_list_h"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	<script src="/static/js/admin.js"></script>
	<script src="/static/js/echarts/echarts.min.js"></script>
    <script>
        var users_total='<?php echo $users_total; ?>';
        var data_basic=<?php echo $data_basicj; ?>;
        var data_source=<?php echo $data_sourcej; ?>;
        var data_charge=<?php echo $data_chargej; ?>;
        var data_type=<?php echo $data_typej; ?>;
    </script>
    <script src="/static/js/admin_index.js"></script>
</body>
</html>