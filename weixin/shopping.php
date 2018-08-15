<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
require 'shirt_db_handle.php';

//检查session，未登录不允许查看收藏夹，跳向登录地址
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}
@$unionid = $_SESSION["unionidSession"];
@$sessionname = $_SESSION["nameSession"];


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="卡方高级服装定制">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,intial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="stylesheet" href="../css/collection.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<title>我的购物车--卡方商城</title>
</head>
<body>
<div id="navbar">
    <ul>
        <li><a href="http://www.ka-fang.cn"><img src="../images/导航条-首页.png"></a></li>
        <li><a href="../online/personal_service.php"><img src="../images/导航条-在线版型设计.png"></a></li>
        <li><a href="#"><img src="../images/导航条-定制指南-量体规范.png"></a></li>
        <li><a href="#"><img src="../images/导航条-微信扫码.png"></a></li>
        <li><a href="personal.php"><img src="../images/导航条-个人中心.png"></a></li>
        <li><a href="collection.php"><img src="../images/导航条-我的收藏.png"></a></li>
        <li><a href="shopping.php"><img src="../images/导航条-购物车.png"></a></li>
        <li><a href="#"><img src="../images/导航条-了解卡方.png"></a></li>
    </ul>
</div>
<div id="welcome">
    <h2>欢迎 <label><?php if($name!=null) echo "$name";else echo "$sessionname";?> </label>进入卡方高级服装定制</h2>
</div>
<div id="container">
    <div id="toggle">
        <ul>
            <a id="a_collection" href="shopping.php"><li class="select"><b>购物车</b></li></a>
        </ul>
    </div>
    <div id="body">
        <!-- 购物车部分 -->
        <div id="body_shopping">
        <h2>我的购物车</h2>
        <?php for($i=0;$i<@count($shopping_order_id);$i++){ ?>
            <ul class="shopping_ul">
                <li>
                    <ul class="shopping_inner_ul">
                    <!-- 放置衬衫图片 -->
                        <li><?php echo "$user_shopping_address[$i]"; ?></li>
                    <!-- 放置衬衫详情信息 -->
                        <li>
                            <h3>衬衫详情</h3>
                            <p><?php echo "$shopping_placket[$i]"; ?></p>
                            <p><?php echo "$shopping_collar[$i]"; ?></p>
                            <p><?php echo "$shopping_cuff[$i]"; ?></p>
                        </li>
                    <!-- 放置量体数据和收获地址 -->
                        <li>
                            <h3>版型数据</h3>
                            <p><?php echo "$version_caption[$i]"; ?></p>
                        </li>
                    <!--放置用户选择的地址信息-->
                    	<li>
                            <h3>地址信息</h3>
                            <p><?php echo "$shopping_address[$i]"; ?></p>
                        </li>
                    <!-- 放置衬衫价格信息 -->
                        <li>
                            <h3>衬衫价格</h3>
                            <p><?php echo $shopping_price[$i]/100; ?>元</p>
                        </li>
                        <li>
                        	<h3><a href="shopping_modify.php?mod_msg=<?php echo "$shopping_order_id[$i]"; ?>">修改信息</a></h3>
                            <h3><a href="delete.php?del_shop=<?php echo "$shopping_order_id[$i]"; ?>">删除</a></h3>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>

