<?php /*a:1:{s:85:"/www/wwwroot/www.doukang.shop/doukang_live/public/../themes/default/portal/index.html";i:1733220272;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="telephone=no" name="format-detection">
    <title>
        <?php if($configpub['site_seo_title'] != ''): ?>
        <?php echo (isset($configpub['site_seo_title']) && ($configpub['site_seo_title'] !== '')?$configpub['site_seo_title']:''); else: ?>
        <?php echo (isset($configpub['site_name']) && ($configpub['site_name'] !== '')?$configpub['site_name']:''); ?>
        <?php endif; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="keywords" content="<?php echo (isset($configpub['site_seo_keywords']) && ($configpub['site_seo_keywords'] !== '')?$configpub['site_seo_keywords']:''); ?>"/>
    <meta name="description" content="<?php echo (isset($configpub['site_seo_description']) && ($configpub['site_seo_description'] !== '')?$configpub['site_seo_description']:''); ?>"/>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/static/index/css/full_index.css" />
    <link rel="stylesheet" type="text/css" href="/static/index/css/jquery.fullPage.css" />
    <style type="text/css">
        a{
            text-decoration: none;
            color: #000;
        }
    </style>

</head>
<body>

<div id="fullpage">

    <!--固定导航-->

    <div class="menu">
        <div class="menu_center">
            <div class="sitename fl">
                <?php echo (isset($configpub['site_name']) && ($configpub['site_name'] !== '')?$configpub['site_name']:''); ?>
            </div>
            <div class="menu_right fr mr_10">
                <ul>
                    <li data-menuanchor="page1" class="active">
                        <a href="#page1">下载演示</a>
                    </Li>
                    <li data-menuanchor="page2">
                        <a href="#page2">关于我们</a>
                    </Li>
                    <!-- <li data-menuanchor="page3">
                        <a href="#page3">第三页</a>
                    </Li> -->

                </ul>
            </div>
            <div class="clearboth">
            </div>
        </div>
    </div>
    
    <!--page1-->
<!--    <div class="section section1">-->
<!--        <div class="section_center">-->

<!--            <div class="section1_left fl">-->
<!--                <img src="/static/index/full_image/demo1.png">-->
<!--            </div>-->

<!--            <div class="section1_right fr">-->
<!--                &lt;!&ndash; logo &ndash;&gt;-->
<!--                <div class="logo_img">-->
<!--                    <img src="/static/index/full_image/logo.png">-->
<!--                </div>-->
<!--                &lt;!&ndash; desc &ndash;&gt;-->
<!--                <div class="desc_img">-->
<!--                    <img src="/static/index/full_image/desc.png">-->
<!--                </div>-->
<!--                &lt;!&ndash; download  &ndash;&gt;-->
<!--                <div class="download">-->
<!--                    <div class="ewm_area fl">-->
<!--                        <div class="ewm_img" style="margin-left: 95px;">-->

<!--                            <p class="ios"></p>-->
<!--                            <p class="android"></p>-->

<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="ewm_area fr mr_20">-->
<!--                        <div class="ewm_img">-->
<!--                            <?php if($configpub['qr_url'] != ''): ?>-->
<!--                                <img src="<?php echo $configpub['qr_url']; ?>">-->
<!--                                <?php else: ?>-->
<!--                                <img src="/static/index/full_image/ewm.png">-->
<!--                            <?php endif; ?>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="clearboth"></div>-->
<!--        </div>-->
<!--    </div>-->
    <!--page2-->
<!--    <div class="section section2">-->
<!--        <div class="section_center">-->
<!--            <div class="section2_left fl">-->
<!--                <div class="company_name">-->
<!--                    <?php echo (isset($configpub['company_name']) && ($configpub['company_name'] !== '')?$configpub['company_name']:''); ?>-->
<!--                </div>-->
<!--                <div class="company_desc">-->
<!--                    <?php echo (isset($configpub['company_desc']) && ($configpub['company_desc'] !== '')?$configpub['company_desc']:''); ?>-->
<!--                </div>-->

<!--            </div>-->
<!--            <div class="section2_right fr">-->
<!--                <img src="/static/index/full_image/demo2.png">-->
<!--            </div>-->

<!--            <div class="clearboth"></div>-->
<!--            <div class="copyright">-->
<!--                <?php if($configpub['copyright_url'] != ''): ?>-->
<!--                    <a href="<?php echo $configpub['copyright_url']; ?>" target="_blank">-->
<!--                        <?php echo (isset($configpub['copyright']) && ($configpub['copyright'] !== '')?$configpub['copyright']:''); ?>-->
<!--                    </a>-->
<!--                    <?php else: ?>-->
<!--                    <?php echo (isset($configpub['copyright']) && ($configpub['copyright'] !== '')?$configpub['copyright']:''); ?>-->
<!--                <?php endif; ?>-->
<!--            </div>-->
<!--        </div>-->

<!--    </div>-->
    <!--page3-->
    <!-- <div class="section">
        <div class="slide">第三屏的第一屏</div>
        <div class="slide">第三屏的第二屏</div>
        <div class="slide">第三屏的第三屏</div>
        <div class="slide">第三屏的第四屏</div>
    </div> -->
    <!--page4-->
    <!-- <div class="section">第四个页面</div> -->

</div>

<script type="text/javascript" src="/static/index/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="/static/index/js/jquery.fullPage.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#fullpage').fullpage({

            sectionsColor:['#FFF','#FFF'], //控制每个section的背景颜色

            controlArrow:true,   //是否隐藏左右滑块的箭头(默认为true)

            verticalCentered: true,  //内容是否垂直居中(默认为true)

            css3: true, //是否使用 CSS3 transforms 滚动(默认为false)

            resize:false, //字体是否随着窗口缩放而缩放(默认为false)

            scrolllingSpeed:1000,  //滚动速度，单位为毫秒(默认为700)

            anchors:['page1','page2'],  //定义锚链接(值不能和页面中任意的id或name相同，尤其是在ie下，定义时不需要加#)

            lockAnchors:false,  //是否锁定锚链接，默认为false。设置weitrue时，锚链接anchors属性也没有效果。

            loopBottom:false,  //滚动到最底部后是否滚回顶部(默认为false)

            loopTop:false, //滚动到最顶部后是否滚底部

            loopHorizontal:false,//左右滑块是否循环滑动

            autoScrolling:true, // 是否使用插件的滚动方式，如果选择 false，则会出现浏览器自带的滚动条

            scrollBar:false,//是否显示滚动条，为true是一滚动就是一整屏

            fixedElements:".logo", //固定元素

            menu:".menu",

            keyboardScrolling:true, //是否使用键盘方向键导航(默认为true)

            keyboardScrolling:true, //页面是否循环滚动（默认为false）

            navigation:true, //是否显示项目导航（默认为false）

            navigationTooltips:["下载演示","关于我们"],//项目导航的 tip

            navigationColor:'#fff', //项目导航的颜色

            slidesNavigation:true,

            afterLoad: function(anchorLink, index){
                if(index == 1){
                    $('.sitename').css('color','#FFF');
                    $('.menu_right li').find('a').css('color','#FFF');

                }
                if(index == 2){
                    $('.sitename').css('color','#000');
                    $('.menu_right li').find('a').css('color','#000');

                }

            },


        });

    });
</script>

</body>
</html>
