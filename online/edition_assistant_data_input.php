<!-- 版师辅助页面点击新数据输入页面 -->
<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
require 'form_validation.class.php';//引入验证类库

//检查session，未登录不允许跳向本地址，重定向至登录地址
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}else{
    $unionid = $_SESSION["unionidSession"];
}

$data_select = "SELECT * from user_measure_photo_opinion where user_id = '$unionid'";
$data_select_rs = mysql_query($data_select);
if(mysql_num_rows($data_select_rs) != '0'){      //如果数据库有数据
    while ($rows = @mysql_fetch_assoc($data_select_rs)) {
        $user_caption[] = $rows['caption'];
        $user_submit_time[] = $rows['user_submit_time'];
    }

    if (@$user_submit_time[0] == null || @$user_submit_time[0] == '0' || @$user_submit_time[0] == '') {
        //没有提交时间，说明此数据并未提交完成或者此用户根本没有数据。无需做任何操作。
    }else{
        //如果有提交时间，说明此数据已完成，跳转到信息提示界面
        echo "<script>window.location.href='view_data_three.html'</script>";
    }
}else{
    //如果数据库查不到此用户，新建数据
    $new_data_insert = "INSERT into user_measure_photo_opinion(id,user_id) values(UUID(),'$unionid')";
    mysql_query($new_data_insert);
}


//数据库无数据，且获得post提交的标题
if (@$user_caption[0] == null) {
    if (@isset($_POST['caption']) && $_POST['caption'] != null) {
        $caption = $_POST['caption'];
        //更新数据库标题数据
        $caption_insert = "UPDATE user_measure_photo_opinion set caption = '$caption' where user_id = '$unionid'";
        mysql_query($caption_insert);
    }
}



//已插入数据查询，以便显示在页面提示用户和已上传照片展示
$data_select = "select * from user_measure_photo_opinion where user_id = '$unionid'";
    $data_select_rs = mysql_query($data_select);
    while ($rows = mysql_fetch_assoc($data_select_rs)) {
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
    }


//用户点击暂存或保存信息，如果是全部保存，需要提交全部照片。
if (isset($_GET['action'])) {
    //点击暂存
    if ($_GET['action'] == 'temp_save') {
        echo "<script>alert('数据暂存成功！');</script>";
        echo "<script>window.location.href='http://www.ka-fang.cn:8080/online/edition_assistant.html'</script>";
    }elseif($_GET['action'] == 'all_save'){
        //检查图片是否全部上传。目前这部分先在提交时检查，后期改为ajax验证。
        if ($neck_photo[0] == null || $shoulder_photo[0] = null || $arm_photo[0] == null || $elbow_photo[0] == null || $wrist_photo[0] == null || $sleeve_photo[0] == null || $chest_photo[0] == null || $waist_photo[0] == null || $clothes_photo[0] == null || $hip_photo[0] == null) {
        echo "<script>alert('您还有照片尚未提交，请提交全部照片后进行保存。')</script>";
        echo "<script>window.location.href='http://www.ka-fang.cn:8080/online/edition_assistant_data_input.php'</script>";
        exit;
        }else{
            //更新数据库user_submit_time字段
            $data_update = "UPDATE user_measure_photo_opinion set user_submit_time = now() where user_id = '$unionid'";
            if (mysql_query($data_update)) {
                echo "<script>alert('数据全部上传完毕！');</script>";
                echo "<script>window.location.href='http://www.ka-fang.cn:8080/online/edition_assistant.html'</script>";
                }
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
<title>新数据输入--版师辅助量体数据输入</title>
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
    <p>请在“标题输入区”输入您该次提交照片的标题，方便您以后查看。请在“照片提交区”按照指示提交您的量体照片。点击“全部上传完毕”将启动版师服务，点击“暂存”可以使您以后继续补充照片。谢谢！</p>
</div>
<!-- 用户数据输入区 -->
<div id="manual_input">
<!-- 图片上传部分 -->
<div id="upload_file">
    <h3>标题：<?php echo @"$user_caption[0]"; ?></h3>
    <h3>照片提交区</h3>
        <table>
            <tr>
            <!-- 上领围neck -->
                <td>上领围<?php if(@$neck_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$neck_photo[0]){
                        echo "<a href='user_photo.php?part=neck_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=neck_photo'>提交</a>";
                        } ?></td>
            <!-- 肩宽shoulder -->
                <td>肩宽<?php if(@$shoulder_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$shoulder_photo[0]){
                        echo "<a href='user_photo.php?part=shoulder_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=shoulder_photo'>提交</a>";
                        } ?></td>
            </tr>
            <tr>
            <!-- 胸围chest -->
                <td>胸围<?php if(@$chest_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$chest_photo[0]){
                        echo "<a href='user_photo.php?part=chest_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=chest_photo'>提交</a>";
                        } ?></td>
            <!-- 腰围/小肚围waist -->
                <td>腰围<?php if(@$waist_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$waist_photo[0]){
                        echo "<a href='user_photo.php?part=waist_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=waist_photo'>提交</a>";
                        } ?></td>
            </tr>
            <tr>
            <!-- 臀围hip -->
                <td>臀围<?php if(@$hip_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$hip_photo[0]){
                        echo "<a href='user_photo.php?part=hip_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=hip_photo'>提交</a>";
                        } ?></td>
            <!-- 上臂围arm -->
                <td>上臂围<?php if(@$arm_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$arm_photo[0]){
                        echo "<a href='user_photo.php?part=arm_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=arm_photo'>提交</a>";
                        } ?></td>
            </tr>
            <tr>
            <!-- 肘围elbow -->
                <td>肘围<?php if(@$elbow_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$elbow_photo[0]){
                        echo "<a href='user_photo.php?part=elbow_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=elbow_photo'>提交</a>";
                        } ?></td>
            <!-- 腕围wrist -->
                <td>腕围<?php if(@$wrist_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$wrist_photo[0]){
                        echo "<a href='user_photo.php?part=wrist_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=wrist_photo'>提交</a>";
                        } ?></td>
            </tr>
            <tr>
            <!-- 袖长sleeve -->
                <td>袖长<?php if(@$sleeve_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$sleeve_photo[0]){
                        echo "<a href='user_photo.php?part=sleeve_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=sleeve_photo'>提交</a>";
                        } ?></td>
            <!-- 前衣长clothes -->
                <td>后衣长<?php if(@$clothes_photo[0]) echo "(已提交)"; ?></td>
                <td><?php if(@$clothes_photo[0]){
                        echo "<a href='user_photo.php?part=clothes_photo'>重新提交</a>";
                    }else{
                        echo "<a href='user_photo.php?part=clothes_photo'>提交</a>";
                        } ?></td>

            </tr>
            <tr>
                <td><a href="?action=temp_save">暂存</a></td>
                <td colspan="2"><a href="?action=all_save">确认提交</a></td>
                <td><a href="../weixin/delete.php?del_part=delete">取消</a></td>
                <!-- 取消后注意及时销毁session对象 -->
            </tr>
        </table>
    </div>
</div>

</body>
</html>