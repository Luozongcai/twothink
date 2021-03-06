<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\www\twothink\public/../application/home/view/default/app\notice.html";i:1512017939;}*/ ?>
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
                <p class="navbar-text"><a href="<?php echo url('app/fuwu'); ?>" class="navbar-link">服务</a></p>
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

    <div class="container-fluid" id="content_list">
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$channel): $mod = ($i % 2 );++$i;?>
        <div class="row noticeList">
            <div class="col-xs-2">
                <img class="noticeImg" src="__PUBLIC__/home/home2/image/tupian/<?=rand(1,8)?>.jpg" />
            </div>
            <div class="col-xs-10">
                <p class="title"><a href="<?php echo url('noticeto?id='.$channel['id']); ?>"><?php echo $channel['title']; ?></a></p>

                 <p class="info">发布人: <?php echo $channel['username']; ?>&emsp;浏览: <?php echo $channel['click']; ?><span class="pull-right"><?php echo $channel['start_time']; ?></span> </p>
            </div>
           <!-- <ul class="nav" style="margin-right:0">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0"><?php echo get_username(); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo url('user/user/profile'); ?>">修改密码</a></li>
                        <li><a href="<?php echo url('user/login/logout'); ?>">退出</a></li>
                    </ul>
                </li>
            </ul>-->
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>

    </div>
    <div class="text-center">
        <button type="button" class="btn btn-info ajax-page">获取更多信息</button>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="__PUBLIC__/home/home2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="__PUBLIC__/home/home2/bootstrap/js/bootstrap.min.js"></script>
</body>
<script type="application/javascript">
    var p = 1;
    $(".ajax-page").click(function() {
        //hasClass检查当前的元素是否含有某个特定的类，如果有，则返回true。
        if($(this).hasClass('ajax-page')) {
            p = p + 1;
            var url = "<?php echo url('ajaxnotice'); ?>";
            var that = this;
            $.post(url, {p: p}, function (data) {
                if (data) {
                    //alert(data);
                    $('#content_list').append(data);
                } else {
                    $('.ajax-page').html("没有跟多数据了！！").removeClass('ajax-page')
                }
            });
        }
    });
</script>

</html>