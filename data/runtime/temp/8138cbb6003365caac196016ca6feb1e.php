<?php /*a:3:{s:94:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/default/appapi/feedback/index.html";i:1703495876;s:84:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/default/appapi/head.html";i:1703495876;s:86:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/default/appapi/footer.html";i:1703495876;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <title><?php echo lang('意见反馈'); ?></title>	
    
    <meta charset="utf-8">
    <meta name="referrer" content="origin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link href='/static/appapi/css/common.css?t=1576565546' rel="stylesheet" type="text/css" >
      
    <link type="text/css" rel="stylesheet" href="/static/appapi/css/feedback.css"/>
</head>
<body>
    <div id="test">
        <textarea placeholder="<?php echo lang('请将您遇到的问题／产品建议反馈给我们，建议您尽可能详细的描述问题，便于运营同学帮您解决。'); ?>" id="content" oninput="check_input()" maxlength='200'></textarea>
        <div class="num"><?php echo lang('最多只能输入200字'); ?></div>

        <div class="thumb_bd">
            <div id="upload" ></div>
            <input type="hidden" id="thumb" name="thumb" value="">
            <img src="/static/appapi/images/feedback/<?php echo lang('feedback_add'); ?>.png" class="fl img-sfz" data-index="ipt-file1" id="img_file1" onclick="file_click($(this))">
            <input type="file" id="ipt-file1" class="file_input" name="file"  accept="image/*" style="display:none;"/>
            <div class="shad1 shadd" data-select="ipt-file1">
                <div class="title-upload"><?php echo lang('正在上传中'); ?>...</div>
                <div id="progress1">
                    <div class="progress ipt-file1"></div>
                </div>
            </div>
        </div>

    </div>
    <div id="btm">
        <button disabled id="save_btn" class="button_default"><?php echo lang('点击反馈'); ?></button>
    </div>
    <input type="hidden" id="uid" value="<?php echo $uid; ?>">
    <input type="hidden" id="token" value="<?php echo $token; ?>">
    <input type="hidden" id="version" value="<?php echo $version; ?>">
    <input type="hidden" id="model" value="<?php echo $model; ?>">

    <script>

    var lang=<?php echo $lang_json; ?>;
    var language_type='<?php echo $language_type; ?>';

    var uid='<?php echo (isset($uid) && ($uid !== '')?$uid:''); ?>';
    var token='<?php echo (isset($token) && ($token !== '')?$token:''); ?>';
    var baseSize = 100;
    function setRem () {
      var scale = document.documentElement.clientWidth / 750;
      document.documentElement.style.fontSize = (baseSize * Math.min(scale, 3)) + 'px';
    }
    setRem();
    window.onresize = function () {
      setRem();
    }
</script>
<script src="/static/js/jquery.js"></script>
<script src="/static/js/layer/layer.js"></script>
<script src="/static/js/function.js?t=123409504"></script>


    <script src="/static/js/ajaxfileupload.js"></script>
    <script src="/static/appapi/js/feedback.js?t=123"></script>

    
</body>
</html>