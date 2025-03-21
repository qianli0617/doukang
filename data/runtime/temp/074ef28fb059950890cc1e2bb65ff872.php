<?php /*a:3:{s:100:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/admin/music/index.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
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
			<li class="active"><a >音乐列表</a></li>
            <li><a href="<?php echo url('Music/add'); ?>"><?php echo lang('ADD'); ?></a></li>
		</ul>
		
		<form class="well form-inline margin-top-20" method="post" action="<?php echo url('Music/index'); ?>">
			选择分类：
            <select class="form-control" name="classify_id">
				<option value="">全部</option>
                <?php if(is_array($classify) || $classify instanceof \think\Collection || $classify instanceof \think\Paginator): $i = 0; $__LIST__ = $classify;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $key; ?>" <?php if(input('request.classify_id') != '' && input('request.classify_id') == $key): ?>selected<?php endif; ?> ><?php echo $v; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>                
			</select>
			关键字： 
            <input class="form-control" type="text" name="keyword" style="width: 200px;" value="<?php echo input('request.keyword'); ?>"
                   placeholder="请输入音乐名称">
			<input type="submit" class="btn btn-primary" value="搜索">
		</form>		
		
		<form method="post" class="js-ajax-form" >
		
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>音乐名称</th>
						<th>演唱者</th>
						<th>上传类型</th>
						<th>上传者</th>
						<th>封面</th>
						<th>音乐长度</th>
						<th>音乐地址</th>
						<th>使用次数</th>
						<th>是否删除</th>
						<th>所属分类</th>
						<th>添加时间</th>
						<th>修改时间</th>
						<th><?php echo lang('ACTIONS'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): if( count($lists)==0 ) : echo "" ;else: foreach($lists as $key=>$vo): ?>
					<tr>
						<td align="center"><?php echo $vo['id']; ?></td>
						<td><?php echo $vo['title']; ?></td>
						<td><?php echo $vo['author']; ?></td>
						<td><?php echo $type[$vo['upload_type']]; ?></td>
						<td><?php echo $vo['uploader_nicename']; ?>(<?php echo $vo['uploader']; ?>)</td>
						<td><img src="<?php echo $vo['img_url']; ?>" width="50" height="50"></td>
						<td><?php echo $vo['length']; ?></td>
						<td style="max-width: 300px;word-break:break-all;"><?php echo $vo['file_url']; ?></td>
						<td><?php echo $vo['use_nums']; ?></td>
						<td><?php echo $isdel[$vo['isdel']]; ?></td>
						<td>
                        <?php if(isset($classify[$vo['classify_id']])): ?>
                            <?php echo $classify[$vo['classify_id']]; else: ?>
                            --
                            <?php endif; ?>
                        </td>
						<td><?php echo date('Y-m-d H:i:s',$vo['addtime']); ?></td>
						<td>
                            <?php if($vo['updatetime'] != '0'): ?>
                            <?php echo date('Y-m-d H:i:s',$vo['updatetime']); else: ?>
                            --
                            <?php endif; ?>
                        </td>
						<td align="center">
                            <a class="btn btn-xs btn-info" href="javascript:void(0)" onclick="musicListen(<?php echo $vo['id']; ?>)">试听</a>
                            <a class="btn btn-xs btn-primary" href='<?php echo url("Music/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
							 <?php if($vo['isdel'] == '0'): ?>
                             <a class="btn btn-xs btn-danger js-ajax-delete" href="<?php echo url('Music/del',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
							 <?php else: ?>
							 
                             <a class="btn btn-xs btn-info js-ajax-dialog-btn" href="<?php echo url('Music/canceldel',array('id'=>$vo['id'])); ?>" >取消删除</a>
                             
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div class="pagination"><?php echo $page; ?></div>
		</form>
	</div>
	<script src="/static/js/admin.js"></script>
	<script src="/static/js/layer/layer.js"></script>
	<script type="text/javascript">
		function musicListen(id){
			layer.open({
			  type: 2,
			  title: '音乐试听',
			  shadeClose: true,
			  shade: 0.8,
			  area: ['500px', '140px'],
			  content: '/admin/Music/listen/?id='+id
			}); 
		}
	</script>
</body>
</html>