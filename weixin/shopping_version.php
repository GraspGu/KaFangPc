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
if (isset($_GET['id']) && $_GET['id'] == null) {
    $url = "http://www.ka-fang.cn:8080/weixin/collection.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}
$shirt_id = $_GET['id'];
//查询用户所有版型信息
$version_select = "select * from user_current_model_list where user_id = '$unionid'";
$version_select_rs = mysql_query($version_select);
while ($rows = mysql_fetch_assoc($version_select_rs)) {
    $version_model_id[] = "$rows[model_id]";
    $version_caption[] = "$rows[caption]";
}
//查询用户地址
$address_select = "select * from user_address_list where user_id = '$unionid' and is_use = '1'";
$address_select_rs = mysql_query($address_select);
while($rows = mysql_fetch_assoc($address_select_rs)){
	$address_id[] = $rows['address_id'];
	$address[] = $rows['address'];
	$receive_name[] = $rows['receive_name'];
	$telephone[] = $rows['telephone'];
}

//获取用户提交的地址id和量体id
if(isset($_POST['model']) && isset($_POST['address'])){
	$model_id = $_POST['model'];
	$address_id = $_POST['address'];
}
 ?>
 <!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>选择您的信息</title>
<link rel="stylesheet" href="../css/online_index.css">
<style>
	form{
		width: 400px;
		margin: 0 auto;
	}
	tr{
		height: 35px;
	}
	td{
		text-align: left;
	}
	td select{
		border:none;
		border:1px #666 solid;
		height: 25px;
	}
	input[type = 'submit']{
		background:#4791ff;
	    cursor: pointer;
	    font-size: 16px;
	    padding: 5px 15px;
	    border-radius: 10px;
	    font-family: "微软雅黑";
	    margin-top:10px;
	    margin-left: 50px;
	}
</style>
</head>
<body>
<!-- 导航条 -->
<div id="navbar">
    <ul>
        <li><a href="http://www.ka-fang.cn"><img src="../images/导航条-首页.png"></a></li>
        <li><a href="../online/personal_service.php"><img src="../images/导航条-在线版型设计.png"></a></li>
        <li><a href="#"><img src="../images/导航条-定制指南-量体规范.png"></a></li>
        <li><a href="#"><img src="../images/导航条-微信扫码.png"></a></li>
        <li><a href="personal.php"><img src="../images/导航条-个人中心.png"></a></li>
        <li><a href="collection.php"><img src="../images/导航条-我的收藏.png"></a></li>
        <li><a href="collection.php"><img src="../images/导航条-购物车.png"></a></li>
        <li><a href="#"><img src="../images/导航条-了解卡方.png"></a></li>
    </ul>
</div>
<!-- 功能说明部分 -->
<div class="func_desc">
    <p align="center" style="margin-left:-2em ;">请选择您的版型信息和地址信息</p>
</div>
<div id="version_ul">
	<form action="shopping_handle.php?s_id=<?php echo "$shirt_id" ?>" method="post">
	    <table>
			<tr>
				<td class="left">请选择地址：</td>
				<td>
					<select name="address">
						<?php for($i = 0;$i < count(@$address_id);$i++) { ?>
							<option value="<?php echo "$address_id[$i]" ?>"><?php echo "$address[$i]" ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="left">请选择版型：</td>
				<td>
					<select name="model">
						<?php for($i = 0; $i < count(@$version_model_id); $i++) { ?>
							<option value="<?php echo "$version_model_id[$i]"; ?>"><?php echo "$version_caption[$i]"; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="确定"/></td>
			</tr>
    	</table>
    </form>
</div>
</body>
</html>