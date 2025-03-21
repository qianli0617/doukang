<?php /*a:1:{s:90:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/default/portal/page/index.html";i:1703495876;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $page['post_title']; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="referrer" content="origin">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta content="telephone=no" name="format-detection" />
<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">

<!-- No Baidu Siteapp-->
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<link href="/static/appapi/css/page.css" rel="stylesheet">
</head>

<body class="body-white">
	<?php if($ish5 == 1): ?>
	<div class="ret">
		<a class="ricon" href="javascript:history.back(-1)"><img src="/static/wxshare/images/return_h.png"></a>
		<div class="tit"><?php echo $page['post_title']; ?></div>
	</div>
	<?php endif; ?>
	<div class="container tc-main">	
	   <div class="page_content">
		     <?php echo $page['post_content']; ?>
		 </div>
		
	</div>
	<!-- /container -->
</body>
</html>