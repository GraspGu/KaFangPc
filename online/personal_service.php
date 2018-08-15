<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';

//检查session，未登录不允许跳向本地址，重定向至登录地址
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}else{
    $unionid = $_SESSION["unionidSession"];
}
?>
<!-- 这是index页面点击个人服务后跳转的页面 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>个人服务</title>
<link rel="stylesheet" href="../css/online_index.css">
<body>
<!-- 导航条 -->
<div id="navbar">
    <ul>
        <li><a href="http://www.ka-fang.cn"><img src="../images/导航条-首页.png"></a></li>
        <li><a href="personal_service.php"><img src="../images/导航条-在线版型设计.png"></a></li>
        <li><a href="#"><img src="../images/导航条-定制指南-量体规范.png"></a></li>
        <li><a href="#"><img src="../images/导航条-微信扫码.png"></a></li>
        <li><a href="../weixin/personal.php"><img src="../images/导航条-个人中心.png"></a></li>
        <li><a href="../weixin/collection.php"><img src="../images/导航条-我的收藏.png"></a></li>
        <li><a href="../weixin/shopping.php"><img src="../images/导航条-购物车.png"></a></li>
        <li><a href="#"><img src="../images/导航条-了解卡方.png"></a></li>
    </ul>
</div>
<!-- 功能说明部分 -->
<div class="func_desc">
    <p>本页面进行个人数据输入、个人版型数据调整</p>
</div>
<!-- 量体服务 -->
<a href="volume_service.html">
    <div id="index_personal" class="button">
        <p>量体服务</p>
    </div>
</a>
<!-- 版型设计 -->
<a href="version_design.html">
    <div id="index_personal" class="button">
        <p>卡方版型设计</p>
    </div>
</a>
<!-- 穿衣设计 -->
<a href="dress_design.php">
    <div id="index_personal" class="button">
        <p>穿衣设计</p>
    </div>
</a>
</body>
</html>