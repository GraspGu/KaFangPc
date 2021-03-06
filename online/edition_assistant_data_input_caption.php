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
    $sessionname = $_SESSION["nameSession"];
}

//检查数据库是否有数据，如果有，直接跳转到edition_assistant_data_input页面
$data_select = "SELECT * from user_measure_photo_opinion where user_id = '$unionid'";
$data_select_rs = mysql_query($data_select);
if (mysql_num_rows($data_select_rs) > 0) {
    echo "<script>window.location.href='http://www.ka-fang.cn:8080/online/edition_assistant_data_input.php'</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>版师辅助新量体数据标题输入</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<script src="../js/new_form_validation.js"></script>
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

<!-- 量体标题caption -->
<div id="manual_input">
    <h3>量体标题数据输入区（必填字段。一旦确认不可更改，谢谢合作。）</h3>
    <form action="edition_assistant_data_input.php" method="post">
        <table>
            <tr>
                <td style="padding-left:30px;">请输入您的标题：</td>
                <td id="caption"><input type="text" style="width:400px;" name="caption" placeholder="标题数据用于您识别自己的量体信息，提交后输入相应的量体信息。"></td>
            </tr>
            <tr>
                <td colspan="2" class="submit"><input id="submit_two" type="submit" value="提交" onclick="return beforeSubmit_caption()"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
