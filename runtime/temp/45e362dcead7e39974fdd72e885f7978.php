<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\www\twothink\public/../application/home/view/default/app\tips.html";i:1512018055;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="__PUBLIC__/home/home2/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/home/home2/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo url('index/index'); ?>" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo url('app/my'); ?>" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid"  id="content_list">
        <h2 style="color: #00cc00">生活贴士</h2>
        <h3 style="color: #7F007F">小区消息</h3>
        <?php if(is_array($notice) || $notice instanceof \think\Collection || $notice instanceof \think\Paginator): $i = 0; $__LIST__ = $notice;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$channel): $mod = ($i % 2 );++$i;?>
        <div class="row noticeList">
            <div class="col-xs-2">
                <img class="noticeImg" src="__PUBLIC__/home/home2/image/tupian/<?=rand(1,8)?>.jpg" />
            </div>
            <div class="col-xs-10">
                <p class="title"><a href="<?php echo url('noticeto?id='.$channel['id']); ?>"><?php echo $channel['title']; ?></a></p>

                <p class="info">发布人: <?php echo $channel['username']; ?>&emsp;浏览: <?php echo $channel['click']; ?><span class="pull-right"><?php echo $channel['start_time']; ?></span> </p>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <br> <br> <br>
        <h3 style="color: #7F007F">小区活动</h3>
        <?php if(is_array($activity) || $activity instanceof \think\Collection || $activity instanceof \think\Paginator): $i = 0; $__LIST__ = $activity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$channel): $mod = ($i % 2 );++$i;?>
        <div class="row noticeList">
            <div class="col-xs-2">
                <img class="noticeImg" src="__PUBLIC__/home/home2/image/tupian/<?=rand(1,8)?>.jpg" />
            </div>
            <div class="col-xs-10">
                <p class="title"><a href="<?php echo url('activityto?id='.$channel['id']); ?>"><?php echo $channel['title']; ?></a></p>
                <p class="info">发布方/个人: <?php echo $channel['username']; ?> &emsp;浏览: <?php echo $channel['click']; ?> &emsp;<span class="pull-right"><?php echo $channel['start_time']; ?></span> </p>
                <p class="info">报名时间:<?php echo $channel['start_time']; ?>至<?php echo $channel['end_time']; ?> </p>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <br> <br> <br>
        <h3 style="color: #7F007F">便民服务</h3>
        <?php if(is_array($service) || $service instanceof \think\Collection || $service instanceof \think\Paginator): $i = 0; $__LIST__ = $service;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$channel): $mod = ($i % 2 );++$i;?>
        <div class="row noticeList">
            <div class="col-xs-2">
                <img class="noticeImg" src="__PUBLIC__/home/home2/image/tupian/<?=rand(1,8)?>.jpg" />
            </div>
            <div class="col-xs-10">
                <p class="title"><a href="<?php echo url('activityto?id='.$channel['id']); ?>"><?php echo $channel['title']; ?></a></p>
                <p class="info">发布人: <?php echo $channel['username']; ?>&emsp;浏览: <?php echo $channel['click']; ?><span class="pull-right"><?php echo $channel['start_time']; ?></span> </p>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>

    </div>
    <div class="text-center">
        <button type="button" class="btn btn-info ajax-page">没有更多消息了喔!</button>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="__PUBLIC__/home/home2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="__PUBLIC__/home/home2/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>