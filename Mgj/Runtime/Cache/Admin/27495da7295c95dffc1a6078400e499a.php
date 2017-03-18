<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>跳转提示</title>
    <link rel="stylesheet" href="/Public/css/animate.css" />
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #f4f4f4; font-family: '微软雅黑'; color: #333; font-size: 16px; }
        .system-message{width:400px;min-height:350px;position: absolute;top:50%;margin-top: -250px;left:50%;margin-left: -250px;text-align: center; animation:zoomIn 1s;background: #fff;}
        .system-message h1{
            margin-top: 50px;
        }
        .system-message h1 i{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .true i{color:#61f280;}
        .system-message .flase i{color:red;}
        .system-message .jump{ padding-top: 10px}
        .system-message .jump a{ color: #333;}
        .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
        @font-face {font-family: 'iconfont';
    src: url('/Public/css/iconfont.eot'); /* IE9*/
    src: url('/Public/css/iconfont.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
    url('/Public/css/iconfont.woff') format('woff'), /* chrome、firefox */
    url('/Public/css/iconfont.ttf') format('truetype'), /* chrome、firefox、opera、Safari, Android, iOS 4.2+*/
    url('/Public/css/iconfont.svg#iconfont') format('svg'); /* iOS 4.1- */
}
        .iconfont{
            font-family:"iconfont" !important;
            font-size:16px;font-style:normal;
            -webkit-font-smoothing: antialiased;
            -webkit-text-stroke-width: 0.2px;
            -moz-osx-font-smoothing: grayscale;}
    </style>
</head>
<body>
<div class="system-message">
    <?php if(isset($message)): ?><h1 class="true"><i class="iconfont">&#xe751;</i></h1>
        <p class="success"><?php echo($message); ?></p>
        <?php else: ?>
        <h1 class="flase"><i class="iconfont">&#xe656;</i></h1>
        <p class="error"><?php echo($error); ?></p><?php endif; ?>
    <p class="detail"></p>
    <p class="jump">
        页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
    </p>
</div>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</body>
</html>