<?php /*a:3:{s:98:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/admin/video/see.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
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

</head>
<body>
	<div class="wrap">
        <div class="form-group">
            <div class="col-md-6 col-sm-10">
                <div class="playerzmblbkjP" id="playerzmblbkjP" style="width:100%;height:500px;"></div>
            </div>
        </div>
	</div>
	<script src="/static/js/admin.js"></script>
	<script src="/static/xigua/xgplayer.js?t=1574906138" type="text/javascript"></script>
    <script src="/static/xigua/backups/xgplayer-flv.js.js" type="text/javascript"></script>
    <script src="/static/xigua/backups/xgplayer-hls.js.js" type="text/javascript"></script>
    <script src="/static/xigua/player.js?t=1581042252" type="text/javascript"></script>
    <script>
    (function(){
        var pull='<?php echo $data['href']; ?>';
        if(pull){
            xgPlay('playerzmblbkjP',pull);
        }
    })()
    </script>
</body>
</html>