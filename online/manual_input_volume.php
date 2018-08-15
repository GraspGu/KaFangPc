<!-- 自量体页面点击手动输入量体数据后跳转的页面-->
<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
require 'form_validation.class.php';

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


// 获取manual_input_volume_caption页面传来的caption
if (isset($_GET['caption']) && $_GET['caption'] != null) {
    $caption = $_GET['caption'];
    $_SESSION['manual_caption'] = $caption;
    //检查数据库是否有此标题，如果有，返回标题
    $caption_select = "SELECT caption from user_measure_temp_list where user_id = '$unionid' and caption = '$caption'";
    $caption_select_rs = mysql_query($caption_select);
    $rows = mysql_fetch_assoc($caption_select_rs);
    if ($rows['caption'] != null) {
        echo "<script>alert('标题已存在，请重新输入。');</script>";
        echo "<script>window.location.href='manual_input_volume_caption.php'</script>";
        exit;
    }
    $caption_select_2 = "SELECT caption from user_measure_list where user_id = '$unionid' and caption = '$caption'";
    $caption_select_2_rs = mysql_query($caption_select_2);
    $rows_2 = mysql_fetch_assoc($caption_select_2_rs);
    if ($rows_2['caption'] != null) {
        echo "<script>alert('标题已存在，请重新输入。');</script>";
        echo "<script>window.location.href='manual_input_volume_caption.php'</script>";
        exit;
    }
}
//获取表单数据
if(($_SERVER['REQUEST_METHOD'])=='POST') {
    //获取post提交的数据
    //$caption = htmlspecialchars($_POST['caption']);
    //strTrim($caption);//去除空格

    $shoulder_style = (int)($_POST['shoulder_style']);

    $neck = (int)$_POST['neck'];
    //strTrim($neck);

    $shoulder = (int)$_POST['shoulder'];
    //strTrim($shoulder);

    $arm = (int)$_POST['arm'];
    //strTrim($arm);

    $elbow = (int)$_POST['elbow'];
    //strTrim($elbow);

    $wrist = (int)$_POST['wrist'];
    //strTrim($wrist);

    $sleeve = (int)$_POST['sleeve'];
    //strTrim($sleeve);

    $chest = (int)$_POST['chest'];
    //strTrim($chest);

    $waist = (int)$_POST['waist'];
    //strTrim($waist);

    $clothes = (int)$_POST['clothes'];
    //strTrim($clothes);

    $hip = (int)$_POST['hip'];
    //strTrim($hip);

//分类暂存和确认数据提交
    if (@$_REQUEST['temp']) {
            $temp_sql_insert = "INSERT into user_measure_temp_list(measure_id,user_id,start_time,caption,data_type,shoulder_style,neck,shoulder,arm,elbow,wrist,sleeve,chest,waist,clothes,hip) values(UUID(),'$unionid',now(),'$_SESSION[manual_caption]','1','$shoulder_style','$neck','$shoulder','$arm','$elbow','$wrist','$sleeve','$chest','$waist','$clothes','$hip')";
            if(mysql_query($temp_sql_insert)){
                //销毁session
                unset($_SESSION['manual_caption']);
                $url = "http://www.ka-fang.cn:8080/online/volume_self.html";
                echo "<script language='javascript' type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";
            }else{
                echo "<script>alert('暂存提交失败！'); history.go(-1);</script>";
            }
    }
    if(@$_REQUEST['confirm']){
        //用户提交确认数据后启动配版程序，具体看文档地7条，成功后跳向volume_self页面
            $confirm_sql_insert = "INSERT into user_measure_list(measure_id,user_id,start_time,end_time,shoulder_style,neck,shoulder,arm,elbow,wrist,sleeve,chest,waist,clothes,hip,is_use,caption) VALUES(UUID(),'$unionid', now(), now(), '$shoulder_style', '$neck', '$shoulder', '$arm', '$elbow', '$wrist', '$sleeve', '$chest',  '$waist', '$clothes', '$hip','1','$_SESSION[manual_caption]')";
            if(mysql_query($confirm_sql_insert)){
                //删除由于新建标题而新增的user_measure_temp_list表数据
                //$caption_data_delete = "delete from user_measure_temp_list where measure_id = '$_SESSION[manual_measure_id]'";
                //if (mysql_query($caption_data_delete)) {
                //获取在user_measure_list表新建数据measure_id放入配版数据库
                $current_measure_id_select = "SELECT measure_id from user_measure_list where user_id = '$unionid' order by start_time desc limit 1";
                $current_measure_id_select_rs = mysql_query($current_measure_id_select);
                while ($rows = mysql_fetch_array($current_measure_id_select_rs)) {
                    $current_measure_id[] = "$rows[measure_id]";
                }
                    require 'version_adjustment.php';   //进行配版
                    $current_model_list_insert = "INSERT into user_current_model_list(user_id,model_id,user_measure_id,produce_time,shoulder_width,sleeve_length,clothes_length,neck_girth,sleeve_width,wrist_girth,chest_girth,waist_girth,sweep_girth,caption) values('$unionid',UUID(),'$current_measure_id[0]',now(),'$fini_shoulder','$fini_sleeve','$fini_clothes','$fini_neck','$fini_arm','$fini_wrist','$fini_chest','$fini_waist','$fini_sweep','$_SESSION[manual_caption]')";
                    if(mysql_query($current_model_list_insert)){
                        //删除session
                        unset($_SESSION['manual_caption']);
                        echo "<script>alert('提交成功！');</script>";
                        $url = "http://www.ka-fang.cn:8080/online/volume_self.html";
                        echo "<script language='javascript' type='text/javascript'>";
                        echo "window.location.href='$url'";
                        echo "</script>";
                    }else{
                        echo "<script>alert('配版失败！'); history.go(-1);</script>";
                    }
                //}
            }else{
                echo "<script>alert('确认数据提交失败！'); history.go(-1);</script>";
            }
        }
}

//如果用户取消提交本次数据
if (@$_GET['action'] == 'cancel') {
        unset($_SESSION['manual_caption']);
        echo "<script>alert('取消成功！欢迎您再次使用。');</script>";
        $url = "http://www.ka-fang.cn:8080/online/volume_self.html";
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
<title>手动输入量体数据</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<script src="../js/new_form_validation.js"></script>
</head>
<body>
<div id="delete">

</div>
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
<!-- 手动输入量体数据说明 -->
<div class="func_desc">
    <p>请按要求输入您的量体数据。填写完成后，如果您对填写的数据还想再重新调整，请点击“暂存”按钮，如果您觉得可以用填写内容定制，请点击“确认提交”按钮，数据确认提交后不能修改，谢谢！</p>
</div>
<!-- 用户数据输入区-->
<div id="manual_input">
    <h3>数据输入区(以下数据请全部填写，单位厘米(cm))</h3>
    <form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table>
            <tr>
                <td>标题：</td>
                <td colspan="3" id="caption"><p><?php echo @$_SESSION['manual_caption']?></p></td>
            </tr>
            <tr>
                <td>肩型：</td>
                <td>
                    <select name="shoulder_style">
                        <option value="1">正常肩</option>
                        <option value="2">端肩</option>
                        <option value="3">溜肩</option>
                        <option value="4">高低肩</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>上领围：</td>
                <td class="left_input"><input type="text" name="neck"></td>
                <td>肩宽：</td>
                <td class="left_input"><input type="text" name="shoulder"></td>
            </tr>
            <tr>
                <td>胸围：</td>
                <td class="left_input"><input type="text" name="chest"></td>
                <td>腰围：</td>
                <td class="left_input"><input type="text" name="waist"></td>
            </tr>
            <tr>
                <td>臀围：</td>
                <td class="left_input"><input type="text" name="hip"></td>
                <td>上臂围：</td>
                <td class="left_input"><input type="text" name="arm"></td>
            </tr>
            <tr>
                <td>肘围：</td>
                <td class="left_input"><input type="text" name="elbow"></td>
                <td>腕围：</td>
                <td class="left_input"><input type="text" name="wrist"></td>
            </tr>
            <tr>
                <td>袖长：</td>
                <td class="left_input"><input type="text" name="sleeve"></td>
                <td>后衣长：</td>
                <td class="left_input"><input type="text" name="clothes"></td>
            </tr>
            <tr>
                <td class="submit"><input id="submit_one" type="submit" name="temp" value="暂存" onclick="return beforeSubmit_temp()"></td>
                <td class="submit" colspan="2"><input id="submit_two" type="submit" name="confirm" value="确认提交" onclick="return beforeSubmit_confirm()"></td>
                <td class="submit"><a href="?action=cancel">取消</a></td>
            </tr>
        </table>
    </form>
</div>
<script>
$(window).bind('beforeunload',function(){
    function(){
        $('#delete').load('close.php');
    }
});
</script>
</body>
</html>