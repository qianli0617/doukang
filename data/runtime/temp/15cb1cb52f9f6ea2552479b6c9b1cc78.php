<?php /*a:3:{s:100:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/admin/video/index.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/header.html";i:1703495876;s:96:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/admin_simpleboot3/public/active.html";i:1703495876;}*/ ?>
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
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a >视频列表</a></li>
            <?php if($status2 == 1): ?>
            <li><a href="<?php echo url('Video/add'); ?>"><?php echo lang('ADD'); ?></a></li>
            <?php endif; ?>
		</ul>
		
		<form class="well form-inline margin-top-20" method="post" action='<?php echo url("Video/index"); ?>'>
			排序：
            <select class="form-control" name="ordertype">
				<option value="">默认</option>
                <?php if(is_array($ordertype) || $ordertype instanceof \think\Collection || $ordertype instanceof \think\Paginator): $i = 0; $__LIST__ = $ordertype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $key; ?>" <?php if(input('request.ordertype') != '' && input('request.ordertype') == $key): ?>selected<?php endif; ?>><?php echo $v; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
            
			
            标题：
            <input class="form-control" type="text" name="keyword1" style="width: 200px;" value="<?php echo input('request.keyword1'); ?>"
                   placeholder="请输入视频标题">
            用户ID：
            <input class="form-control" type="text" name="uid" style="width: 200px;" value="<?php echo input('request.uid'); ?>"
                   placeholder="请输入用户ID、靓号">
                   
            关键字：
            <input class="form-control" type="text" name="keyword" style="width: 200px;" value="<?php echo input('request.keyword'); ?>"
                   placeholder="请输入视频ID">
            <input type="hidden" name="status" value="<?php echo $status2; ?>"/>
            <input type="hidden" name="isdel" value="<?php echo $isdel2; ?>"/>
			<input type="submit" class="btn btn-primary" value="搜索">
		</form>		
		
		<form method="post" class="js-ajax-form">
            <div class="table-actions">

                <button class="btn btn-danger btn-sm js-ajax-submit" type="submit" data-action="<?php echo url('Video/del'); ?>"
                        data-subcheck="true"><?php echo lang('DELETE'); ?>
                </button>

                <?php if(isset($sign) and $sign == 'wait'): ?>
                    <button class="btn btn-success btn-sm js-ajax-submit" type="submit" data-action="<?php echo url('Video/batchPass'); ?>"
                            data-subcheck="true">批量同意
                    </button>

                    <button class="btn btn-danger btn-sm js-ajax-submit" type="submit" data-action="<?php echo url('Video/batchReject'); ?>"
                            data-subcheck="true">批量拒绝
                    </button>
                <?php endif; ?>

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
						<th>会员昵称（ID）</th>
						<th>分类</th>
						<th width="10%">标题</th>
						<th>图片</th>
						<th>点赞数</th>
						<th>评论数</th>
						<th>分享数</th>
						<th>视频状态</th>
                        <?php if(isset($sign) and $sign != 'wait' and $sign != 'nopass'): ?>
						  <th>上下架状态</th>
                        <?php endif; ?>
						<th>是否绑定商品</th>
						<th>发布时间</th>
						<th><?php echo lang('ACTIONS'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): if( count($lists)==0 ) : echo "" ;else: foreach($lists as $key=>$vo): ?>
					<tr>
                        <td>
                            <input type="checkbox" class="js-check" data-yid="js-check-y" data-xid="js-check-x" name="ids[]" value="<?php echo $vo['id']; ?>">
                        </td>
						<td><?php echo $vo['id']; ?></td>
						<td><?php echo $vo['userinfo']['user_nickname']; ?> (<?php echo $vo['uid']; ?>)</td>
                        <td><?php echo (isset($class[$vo['classid']]['name']) && ($class[$vo['classid']]['name'] !== '')?$class[$vo['classid']]['name']:'默认'); ?></td>
						<td><?php echo $vo['title']; ?></td>
						<td><img src="<?php echo $vo['thumb']; ?>" class="imgtip" style="max-width:100px;max-height:100px;"/></td>
						<td><?php echo $vo['likes']; ?></td>
						<td><?php echo $vo['comments']; ?></td>
						<td><?php echo $vo['shares']; ?></td>
						<td><?php echo $status[$vo['status']]; ?></td>
                        <?php if(isset($sign) and $sign != 'wait' and $sign != 'nopass'): ?>
						  <td><?php echo $isdel[$vo['isdel']]; ?></td>
                        <?php endif; ?>
						<td><?php if($vo['type'] == '1'): ?>是<?php else: ?>否<?php endif; ?></td>
						<td><?php echo date('Y-m-d H:i:s',$vo['addtime']); ?></td>
						<td>
                            <a class="btn btn-xs btn-info view" data-id="<?php echo $vo['id']; ?>">查看视频</a>
                            
                            <?php if($vo['isdel'] == '0' and $vo['status'] != '0'): ?>
                            <a class="btn btn-xs btn-info comment" data-id="<?php echo $vo['id']; ?>">评论列表</a>
                            <?php endif; if($vo['isdel'] == '0' and $vo['status'] != '0' and $vo['status'] != '2'): ?>
                            <a class="btn btn-xs btn-warning xiajia" data-id="<?php echo $vo['id']; ?>">下架视频</a>
                            <?php endif; if($vo['isdel'] == '1'): ?>
                            <a class="btn btn-xs btn-success js-ajax-dialog-btn" href="<?php echo url('Video/setDel',array('id'=>$vo['id'],'isdel'=>0,'reason'=>'')); ?>">上架</a>
                            <?php endif; if($vo['status'] == 0): ?>
                                <a class="btn btn-xs btn-success js-ajax-dialog-btn" href="<?php echo url('Video/setstatus',array('id'=>$vo['id'],'status'=>1)); ?>">同意</a>
                                <a class="btn btn-xs btn-warning js-ajax-dialog-btn" href="<?php echo url('Video/setstatus',array('id'=>$vo['id'],'status'=>2)); ?>">拒绝</a>
                            <?php endif; ?>
                            
                            
                            <a class="btn btn-xs btn-primary" href='<?php echo url("Video/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
							<a class="btn btn-xs btn-danger js-ajax-delete" href="<?php echo url('Video/del',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
						</td>
					</tr>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div class="pagination"><?php echo $page; ?></div>
		</form>
	</div>
	<script src="/static/js/admin.js"></script>
	<script type="text/javascript">
        $(function(){
            
            Wind.use('layer');
            $('.comment').click(function(){
                var _this=$(this);
                var id=_this.data('id');

                layer.open({
                    type: 2,
                    title: '评论列表',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['800px', '90%'],
                    content: '/admin/videocom/index?videoid='+id
                }); 
                
            });
            
            $('.view').click(function(){
                var _this=$(this);
                var id=_this.data('id');

                layer.open({
                    type: 2,
                    title: '查看',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['500px', '600px'],
                    content: '/admin/Video/see?id='+id
                }); 
                
            });
            
            $('.xiajia').click(function(){
                var _this=$(this);
                var id=_this.data('id');
                
                layer.prompt({
                    formType: 2,
                    title: '请输入下架原因',
                    area: ['800px', '100px'] //自定义文本域宽高
                }, function(value, index, elem){
                    $.ajax({
                        url:"<?php echo url('video/setDel'); ?>",
                        type:'POST',
                        data:{id:id,isdel:1,reason:value},
                        dataType:'json',
                        success:function(data){
                            var code=data.code;
                            if(code==0){
                                layer.msg(data.msg);
                                return !1;
                            }
                            layer.msg(data.msg,{},function(){
                                layer.closeAll();
                                reloadPage(window);
                            });
                            
                        },
                        error:function(){
                            layer.msg('操作失败，请重试')
                        }
                    });
                    
                });
                
            })
        })
	</script>
</body>
</html>