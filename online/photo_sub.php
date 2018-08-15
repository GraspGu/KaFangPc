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

//查询已提交的照片，提示用户是否提交
$photo_select = "select * from user_shirt_opinion_list where user_id = '$unionid' and shirt_opinion_id = '$_SESSION[user_opinion_id]'";
$photo_select_rs = mysql_query($photo_select);
while ($rows = mysql_fetch_assoc($photo_select_rs)) {
    $front_photo[] = "$rows[front_photo]";
    $side_photo[] = "$rows[side_photo]";
}

//用户点击提交
if (isset($_GET['action']) && $_GET['action'] == 'submit') {
    //检测两张图片是否全部上传
    if ($front_photo[0] == null || $front_photo[0] == '' || $side_photo[0] == null || $side_photo[0] == '') {
        echo "<script>alert('您还有照片未上传！请全部上传后提交。')</script>";
        $url = "http://www.ka-fang.cn:8080/online/photo_sub.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
    	//更新produce_time子段
    	$time_update = "update user_shirt_opinion_list set produce_time = now() where user_id = '$unionid' and shirt_opinion_id = '$_SESSION[user_opinion_id]'";
        mysql_query($time_update);
        //销毁提交照片需要用到的session
        unset($_SESSION['user_opinion_id']);
        unset($_SESSION['des_part']);
        echo "<script>alert('提交成功！')</script>";
        $url = "http://www.ka-fang.cn:8080/online/dress_design.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}
//用户点击取消
if (isset($_GET['action']) && $_GET['action'] == 'cancel') {
    //查询出图片地址
    $front_photo_add = "D:/user_photo" . "$front_photo[0]";
    $side_photo_add = "D:/user_photo" . "$side_photo[0]";
    if (@$front_photo[0] != null) {
        unlink($front_photo_add);
    }
    if (@$side_photo[0] != null) {
        unlink($side_photo_add);
    }
	//删除数据库数据
	$data_delete = "delete from user_shirt_opinion_list where user_id = '$unionid' and shirt_opinion_id = '$_SESSION[user_opinion_id]'";
    mysql_query($data_delete);
    //销毁session
    unset($_SESSION['user_opinion_id']);
    unset($_SESSION['des_part']);
    $url = "http://www.ka-fang.cn:8080/online/dress_design.php";
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
<title>提交照片</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<style>
    #upload_file{
        width: 400px;
        margin-bottom: 100px;
    }
    #upload_file table tr td{
        width: 200px;
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
<!-- 示意图 -->
<div class="button">
    <p>示意图</p>
</div>
<!-- 照片上传部分 -->
<div id="upload_file">
<h3>照片提交区</h3>
    <table>
        <tr>
            <td>正前照：<?php if(@$front_photo[0] != null) echo "(已提交)"; ?></td>
            <td>
                <?php
                    if (@$front_photo[0] != null) {
                        echo "<a href='dress_design_photo_up.php?des_part=front_photo'>重新提交</a>";
                    }else{
                        echo "<a href='dress_design_photo_up.php?des_part=front_photo'>提交</a>";
                    }
                 ?>
            </td>
        </tr>
        <tr>
            <td>侧面照：<?php if(@$side_photo[0] != null) echo "(已提交)"; ?></td>
            <td>
                <?php
                    if (@$side_photo[0] != null) {
                        echo "<a href='dress_design_photo_up.php?des_part=side_photo'>重新提交</a>";
                    }else{
                        echo "<a href='dress_design_photo_up.php?des_part=side_photo'>提交</a>";
                    }
                 ?>
            </td>
        </tr>
        <tr>
            <td><a href="?action=submit">确认提交</a></td>
            <td><a href="?action=cancel">取消</a></td>
        </tr>
            <!-- 保存取消后注意及时销毁session对象 -->
    </table>
</div>
<!-- 温馨提示 -->
<div class="button">
    <p align="center">温馨提示</p>
    <p>请耐心等待公众号通知，前往个人中心或该通道首页查看版型建议。</p>
</div>
</body>
</html>