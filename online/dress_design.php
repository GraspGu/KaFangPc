<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';//链接数据库

//检查session，未登录不允许跳向本地址，重定向至登录地址
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}else{
    $unionid = $_SESSION["unionidSession"];
}
//用户点击提交照片
if (isset($_GET['action']) && $_GET['action'] == 'submit') {
	//清除没有时间数据的垃圾数据信息
	$delete_sql = "delete from user_shirt_opinion_list where user_id = '$unionid' and produce_time is null";
	mysql_query($delete_sql);
    $new_data_insert = "INSERT into user_shirt_opinion_list(shirt_opinion_id,user_id,view_flag) values(UUID(),'$unionid','0')";
    if (mysql_query($new_data_insert)) {
        //查询出user_shirt_opinion_id并写入session，以便上传照片使用
        $opinion_id_select = "select shirt_opinion_id from user_shirt_opinion_list where user_id = '$unionid' and produce_time is null";
        $opinion_id_select_rs = mysql_query($opinion_id_select);
        while ($rows = mysql_fetch_assoc($opinion_id_select_rs)) {
            $opinion_id[] = "$rows[shirt_opinion_id]";
        }
        $_SESSION['user_opinion_id'] = $opinion_id[0];
        $url = "http://www.ka-fang.cn:8080/online/photo_sub.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        echo "<script>alert('提交失败！');history.go(-1);</script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>穿衣设计</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
</head>
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
    <p>提交您的衬衫穿着照片，卡方设计师将给您一份专业的版型设计建议。</p>
</div>
<!-- 建议内容说明 -->
<div class="button">
    <p>建议内容说明</p>
</div>
<!-- 提交照片 -->
<a href="?action=submit">
    <div class="button">
        <p>前往提交照片</p>
    </div>
</a>
<!-- 查看版型建议 -->
<a href="version_sug.php">
    <div class="button">
        <p>查看版型建议</p>
    </div>
</a>
<!--返回按钮-->
<div class="button">
	<a href="personal_service.php">
		<p>返回上一级</p>
	</a>
</div>
</body>
</html>
