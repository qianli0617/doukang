<?php /*a:3:{s:98:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/admin/video/add.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
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
		<ul class="nav nav-tabs">
			<li ><a href="<?php echo url('Video/index',array('isdel'=>0,'status'=>1,'is_draft'=>0)); ?>">视频列表</a></li>
			<li class="active"><a ><?php echo lang('ADD'); ?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('Video/addPost'); ?>">
            
            <div class="form-group">
				<label for="input-name" class="col-sm-2 control-label"><span class="form-required">*</span>分类</label>
				<div class="col-md-6 col-sm-10">
					<select class="form-control" name="classid">
                        <?php if(is_array($class) || $class instanceof \think\Collection || $class instanceof \think\Paginator): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
				</div>
			</div>
            
            <div class="form-group">
				<label for="input-uid" class="col-sm-2 control-label"><span class="form-required">*</span>用户ID</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-uid" name="uid">
				</div>
			</div>
            
            <div class="form-group">
				<label for="input-title" class="col-sm-2 control-label"><span class="form-required">*</span>标题</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-title" name="title">
				</div>
			</div>
            
            <div class="form-group">
				<label for="input-user_login" class="col-sm-2 control-label"><span class="form-required">*</span>图片</label>
				<div class="col-md-6 col-sm-10">
					<input type="hidden" name="thumb" id="thumbnail" value="">
                    <a href="javascript:uploadOneImage('图片上传','#thumbnail');">
                        <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                 id="thumbnail-preview"
                                 style="cursor: pointer;max-width:100px;max-height:100px;"/>
                    </a>
                    <input type="button" class="btn btn-sm btn-cancel-thumbnail" value="取消图片">
                    <p class="help-block">如果视频为横屏，封面图也需上传横屏图片，且比例要一致。反之也是同样规则</p>
				</div>
			</div>
            
            <div class="form-group">
				<label for="input-href" class="col-sm-2 control-label"><span class="form-required">*</span>上传视频</label>
				<div class="col-md-6 col-sm-10">
					<input class="form-control" id="js-file-input" type="text" name="href" style="width: 300px;display: inline-block;" title="视频文件地址" >

                    <a href="javascript:uploadOne('文件上传','#js-file-input','video');">上传文件</a>MP4格式
                   	<p class="help-block">可填写视频链接 [只能包含字母,数字,下划线,不能包含*#$等特殊字符]，可直接上传视频获取链接</p> 
				</div>
				
			</div>
            
            <div class="form-group">
				<label for="input-href_w" class="col-sm-2 control-label"><span class="form-required">*</span>上传水印视频</label>
				<div class="col-md-6 col-sm-10">
					<input class="form-control" id="js-file-input2" type="text" name="href_w" style="width: 300px;display: inline-block;" title="水印视频文件地址">
                    <a href="javascript:uploadOne('文件上传','#js-file-input2','video');">上传文件</a>MP4格式
                    <p class="help-block">可填写视频链接 [只能包含字母,数字,下划线,不能包含*#$等特殊字符]，可直接上传视频获取链接</p> 
				</div>
			</div>
            
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="status" value="1">
					<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('ADD'); ?></button>
					<a class="btn btn-default" href="javascript:history.back(-1);"><?php echo lang('BACK'); ?></a>
				</div>
			</div>
            
		</form>
	</div>
	<script src="/static/js/admin.js"></script>
    <script>
        (function(){
            $('.btn-cancel-thumbnail').click(function () {
                $('#thumbnail-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
                $('#thumbnail').val('');
            });
            
            
        })()
    </script>
</body>
</html>
