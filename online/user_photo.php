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

//获取照片提交部分信息
if(isset($_GET['part']) && $_GET['part'] != null){
    $part = $_GET['part'];
    //写入session
    $_SESSION['user_photo_part'] = $part;
    $select_part = "select * from measure_image_para where measure_name = '$part'";
    $select_part_rs = mysql_query($select_part);
    while ($rows = mysql_fetch_assoc($select_part_rs)) {
        $measure_photo[] = "$rows[image]";
        $photo[] = "<img src = '../$rows[image]' />";
        $measure_text[] = "$rows[text]";
    }
}else{
    $url = "http://www.ka-fang.cn:8080/online/edition_assistant_data_input_caption.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>照片提交区--版师辅助量体数据输入</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/new_form_validation.js"></script>
<style>
    .td_submit input{
        height: 30px;
    }
    #exp_img{
        height: 220px;
        width: 1000px;
        margin: 10px auto 0;
    }
    #exp_img img{
        display: block;
        height: 200px;
        margin-top: 10px;
        margin: 0 auto;
    }
</style>
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
    <p>请您按照示范照片的操作进行测量拍照，谢谢！”</p>
</div>
<!-- 示范图片展示区 -->
<div id="exp_img">
    <h3>示范照片展示</h3>
    <p><?php echo "$photo[0]"; ?></p>
</div>

<!-- 示范说明文字区 -->
<div class="button">
    <p><?php echo "$measure_text[0]"; ?></p>
</div>

<div id="img_submit">
    <form action="../upload.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="file">文件名：</label></td>
            </tr>
            <tr>
                <td><input type="file" name="file" id="file"></td>
            </tr>
            <tr>
                <td class="td_submit"><input type="submit" name="submit" value="提交"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>