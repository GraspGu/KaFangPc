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

//9.图1中，点击“查看版师意见”在表中查找user_id，如果有记录，判断staff_submit_time是否为空，如果为空，则进入图1.4，如果不为空，说明版师已经处理完，则进入图1.2。如果没有记录，弹出对话框，您还没有提交照片，并返回图1.
$data_select = "select * from user_measure_photo_opinion where user_id = '$unionid'";
$data_select_rs = mysql_query($data_select);
//如果数据库没有数据
if (mysql_num_rows($data_select_rs) == '0') {
    echo "<script>alert('您还没有提交照片！');</script>";
    echo "<script>window.location.href='http://www.ka-fang.cn:8080/online/edition_assistant.html'</script>";
    exit;
}elseif (mysql_num_rows($data_select_rs) >= '0'){
    //查询staff_submit_time，如果没有，进入图1.4,如果有，进入图1.2
    $staff_time_sel = "SELECT staff_submit_time from user_measure_photo_opinion where user_id = '$unionid'";
    $staff_time_sel_rs = mysql_query($staff_time_sel);
    if (mysql_num_rows($staff_time_sel_rs) == '0') {
        echo "<script>window.location.href='view_data_four.html'</script>";
    }else{
        #进入图1.2，即本页面
        //获取版师意见
        $staff_opinion_select = "select * from user_measure_photo_opinion where user_id = '$unionid'";
        $staff_opinion_select_rs = mysql_query($staff_opinion_select);
        while ($rows = mysql_fetch_assoc($staff_opinion_select_rs)) {
            $caption[] = $rows['caption'];

            $neck_photo[] = $rows['neck_photo'];
            $shoulder_photo[] = $rows['shoulder_photo'];
            $arm_photo[] = $rows['arm_photo'];
            $elbow_photo[] = $rows['elbow_photo'];
            $wrist_photo[] = $rows['wrist_photo'];
            $sleeve_photo[] = $rows['sleeve_photo'];
            $chest_photo[] = $rows['chest_photo'];
            $waist_photo[] = $rows['waist_photo'];
            $clothes_photo[] = $rows['clothes_photo'];
            $hip_photo[] = $rows['hip_photo'];

            $neck_opion[] = $rows['neck_opion'];
            $shoulder_opion[] = $rows['shoulder_opion'];
            $arm_opion[] = $rows['arm_opion'];
            $elbow_opion[] = $rows['elbow_opion'];
            $wrist_opion[] = $rows['wrist_opion'];
            $sleeve_opion[] = $rows['sleeve_opion'];
            $chest_opion[] = $rows['chest_opion'];
            $waist_opion[] = $rows['waist_opion'];
            $clothes_opion[] = $rows['clothes_opion'];
            $hip_opion[] = $rows['hip_opion'];
        }
    }
}

 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>查看版师确认数据</title>
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
<!-- 功能说明部分 -->
<div class="func_desc">
    <p>下面是版师对您提供的照片进行的建议，希望您在量体的过程中能够采用，谢谢您的观看。点击我已明白按钮后，该资料将删除，如果您还想以后再看，请点击“以后再看”按钮。谢谢。</p>
</div>

<!-- 用户照片、版师意见展示区 -->
<div id="photo_opion">
<h3>用户照片展示及版师意见浏览区</h3>
    <div class="part">
        <ul>
            <li><p class="vertical_p">上领围</p></li>
            <li><?php echo "<img src='D:user_photo/$shoulder_photo[0]'>"; ?></li>
            <li><p class="transverse_p"><?php echo "$neck_opion[0]"; ?></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">肩宽</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$shoulder_opion[0]"; ?></p></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">胸围</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$chest_opion[0]"; ?></p></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">腰围</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$waist_opion[0]"; ?></p></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">臀围</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$hip_opion[0]"; ?></p></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">上臂围</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$arm_opion[0]"; ?></p></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">肘围</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$elbow_opion[0]"; ?></p></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">腕围</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$wrist_opion[0]"; ?></p></p></li>
        </ul>
    </div>
    <div class="part">
        <ul>
            <li><p class="vertical_p">袖长</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$sleeve_opion[0]"; ?></p></p></li>
        </ul>
    </div>

    <div class="part">
        <ul>
            <li><p class="vertical_p">后衣长</p></li>
            <li><img src="../images/logo.png" ></li>
            <li><p class="transverse_p"><?php echo "$clothes_opion[0]"; ?></p></p></li>
        </ul>
    </div>

    <a href="../weixin/delete.php?del_part=delete">我已明白</a>
    <a href="edition_assistant.html">以后再看</a>
</div>
</body>
</html>