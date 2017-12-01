<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\www\twothink\public/../application/home/view/default/app\activityto.html";i:1511964513;}*/ ?>
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

    <div class="container-fluid">
        <div class="blank"></div>
        <h3 class="noticeDetailTitle"><strong><?php echo $list['title']; ?>活动</strong></h3>
        <div class="noticeDetailInfo">发布者:<span style="color: #7F007F"><?php echo $list['username']; ?></span></div>
        <div class="noticeDetailInfo">报名起始时间:<?php echo $list['start_time']; ?></div>
        <div class="noticeDetailInfo">报名结束时间:<?php echo $list['end_time']; ?></div>
        <div class="noticeDetailInfo">浏览: <?php echo $list['click']; ?>次</div>
        <div class="noticeDetailInfo pull-right"><a class="ajax_ctivity confirm" data-id="<?php echo $list['title']; ?>" href=""><h4>申请参与活动</h4></a></div>

        <div class="noticeDetailContent">

             <br/><br/><br/><br/>
            <?php echo $list['content']; ?>
        </div>
    </div>

</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="__PUBLIC__/home/home2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="__PUBLIC__/home/home2/bootstrap/js/bootstrap.min.js"></script>
</body>
<script>

    $(".ajax_ctivity").click(function() {
       // var url="<?php echo url('ajaxcome'); ?>";
        if (confirm('确定要参加活动吗?')) {
            var url = "<?php echo url('ajaxcome'); ?>";
            var title = $(this).attr('data-id');
            var that = this;
            $.post(url, {title: title}, function (data) {
                if (data == 'yes') {
                    //报名成功
                    alert('报名成功');
                } else if(data == 'no') {
                //报过名了
                    alert('您已经报过名了');
                }else if(data == 'login') {
                    //没登录
                        //$(this).attr( "href","<?php echo url('user/login/index'); ?>");
                        alert('您还没有登录,不能报名!');

                }
            });
        }

    });

</script>
</html>