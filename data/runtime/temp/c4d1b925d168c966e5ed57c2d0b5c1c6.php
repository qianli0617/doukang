<?php /*a:1:{s:91:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/default/appapi/video/index.html";i:1703495876;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="referrer" content="origin">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta content="telephone=no" name="format-detection" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <title><?php echo (isset($videoinfo['title']) && ($videoinfo['title'] !== '')?$videoinfo['title']:$configpub['site_name']); ?></title>
    <link rel="stylesheet" type="text/css" href="/static/appapi/share/css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="/static/appapi/share/css/style.css">

	<link href="/static/appapi/share/css/video-js.min.css" rel="stylesheet">
    <script type="text/javascript" src="/static/appapi/share/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript">		
		var isiPad = /iPad/i.test(navigator.userAgent);
		var isiPhone = /iPhone|iPod/i.test(navigator.userAgent);
		var isAndroid = /Android/i.test(navigator.userAgent);
		var isWeixin = /MicroMessenger/i.test(navigator.userAgent);
		var isQQ = /QQ/i.test(navigator.userAgent);
		var isIOS = (isiPad || isiPhone);
		var isWeibo = /Weibo/i.test(navigator.userAgent);
		var isApp = (isAndroid || isIOS);

        var videosrc='<?php echo $hls; ?>';
        var myPlayer;
        var h=window.screen.height;
        var videotimer='',request='';

    </script> 
</head>
<body>

<!--视频-->
<section class="section1" style="background: #000;">
    <div id="mse" style="height: 100%;"></div>
    <script src="/static/xigua/xgplayer.js?t=1574906138" type="text/javascript"></script>
    <script>
      let player = new Player({
        "id": "mse",
        "url": "<?php echo $hls; ?>",
        "playsinline": true,
        "whitelist": [
                ""
        ],
        "currentTime":"false",
        "fluid":true,
        "width": "100%",
        "height": "100%",
        "fitVideoSize": 'auto',
        "poster": "<?php echo $videoinfo['thumb']; ?>",
        "ignores":['time','progress','loading','play'] //time当前播放时间/视频时长 progress视频进度条 loading加载提示 play控制条的播放、暂停按钮 replay重播
      });

      $(function(){
        $("#mse").css("height","100%");
      });
      
    </script>
 
    <article class="section1_box" id="section1_box">
        <header class="header clearfix">
            <div class="clearfix">
                <div class="userinfo">
                    <img src="<?php echo $liveinfo['avatar_thumb']; ?>" userid="<?php echo $liveinfo['id']; ?>">
                    <span class="ulive"><?php echo $liveinfo['user_nickname']; ?></span>
                    <span class="unum">ID：<?php echo $liveinfo['id']; ?></span>
                </div>
                <div class="userimg" id="userimg">
                    <ul class="userpic clearfix" id="userpic"></ul>
                </div>
            </div>

        </header>
        <!-- <article id="heart"><canvas id="canvas"></canvas></article> -->


        
    </article>
    <section class="touchbox" id="touchbox"></section>
	<!-- 下载 -->
	<div class="down-bottom" onclick="downurl()" style="z-index: 99999999;">
		<img src="/static/appapi/share/images/down.png">
	</div>
</section>
<!--视频-->

<script type="text/javascript">

	function downurl(){
		var href='';
		if(isIOS){
			href='<?php echo $configpub['app_ios']; ?>';
		}else{
			href='<?php echo $configpub['app_android']; ?>';
		}
		location.href=href;
		return !1;
	}


</script>
</body>
</html> 
