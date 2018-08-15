<?php
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
session_start();
@$unionid = $_SESSION["unionidSession"];
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    exit;
}

//用户删除收藏的衬衫
if((@$_GET["del_coll"])!=null){
@$shirt_id_del = @$_GET['del_coll'];
$shirt_id_del_sql = "DELETE from user_store where project_id = '$shirt_id_del' and user_id = '$unionid'";
mysql_query($shirt_id_del_sql);
if(mysql_query($shirt_id_del_sql)!=null){
    $url = "http://www.ka-fang.cn:8080/weixin/collection.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    }else{
        $url = "http://www.ka-fang.cn:8080/weixin/collection.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}

/*删除购物车*/
if((@$_GET["del_shop"])!=null){
    $shirt_shopping_id = $_GET['del_shop'];
    $shirt_shopping_del = "DELETE from order_list where user_id = '$unionid' and order_id = '$shirt_shopping_id'";
    mysql_query($shirt_shopping_del);
    if(mysql_query($shirt_shopping_del)!=null){
        $url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        $url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}

//传入measure_id，删除量体信息
if((@$_GET["del_measure"])!=null){
    $measure_id = $_GET['del_measure'];
    $measure_del = "UPDATE user_measure_list set is_use = '0' where user_id = '$unionid' and measure_id = '$measure_id'";
    if(mysql_query($measure_del)){
        $url = "http://www.ka-fang.cn:8080/weixin/personal.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        $url = "http://www.ka-fang.cn:8080/weixin/personal.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}
//传入版型model，删除版型信息
if(isset($_GET['del_model']) && $_GET['del_model'] != null){
	$model_id = $_GET['del_model'];
	$model_del = "UPDATE user_current_model_list set state = '0' where user_id = '$unionid' and model_id = '$model_id'";
	if(mysql_query($model_del)){
		$url = "http://www.ka-fang.cn:8080/weixin/personal.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
	}else{
        $url = "http://www.ka-fang.cn:8080/weixin/personal.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}

//传入address_id，删除地址信息
if((@$_GET["del_address"])!=null){
    $address_id = $_GET['del_address'];
    $address_del = "UPDATE user_address_list set is_use = '0' where user_id = '$unionid' and address_id = '$address_id'";
    mysql_query($address_del);
    if(mysql_query($address_del)!=null){
        $url = "http://www.ka-fang.cn:8080/weixin/personal.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        $url = "http://www.ka-fang.cn:8080/weixin/personal.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}

//传入图片上传区数据的处理,传入表user_measure_temp_list数据的measure_id
if (isset($_GET['del_part']) && $_GET['del_part'] == 'delete') {
        //查询已上传的图片并删除
    $image_select = "select * from user_measure_photo_opinion where user_id = '$unionid'";
    $image_select_rs = mysql_query($image_select);
    while ($rows = mysql_fetch_assoc($image_select_rs)) {
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
    //拼接已上传的图片路径
    $neck_part = "D:/user_photo/" . "$neck_photo[0]";
    if (@$neck_photo[0] != null) {
        unlink($neck_part);
    }
    $shoulder_part = "D:/user_photo/" . "$shoulder_photo[0]";
    if (@$shoulder_photo[0] != null) {
        unlink($shoulder_part);
    }
    $arm_part = "D:/user_photo/" . "$arm_photo[0]";
    if (@$arm_photo[0] != null) {
        unlink($arm_part);
    }
    $elbow_part = "D:/user_photo/" . "$elbow_photo[0]";
    if (@$elbow_photo[0] != null) {
        unlink($elbow_part);
    }
    $wrist_part = "D:/user_photo/" . "$wrist_photo[0]";
    if (@$wrist_photo[0] != null) {
        unlink($wrist_part);
    }
    $sleeve_part = "D:/user_photo/" . "$sleeve_photo[0]";
    if (@$sleeve_photo[0] != null) {
        unlink($sleeve_part);
    }
    $chest_part = "D:/user_photo/" . "$chest_photo[0]";
    if (@$chest_photo[0] != null) {
        unlink($chest_part);
    }
    $waist_part = "D:/user_photo/" . "$waist_photo[0]";
    if (@$waist_photo[0] != null) {
        unlink($waist_part);
    }
    $clothes_part = "D:/user_photo/" . "$clothes_photo[0]";
    if (@$clothes_photo[0] != null) {
        unlink($clothes_part);
    }
    $shoulder_part = "D:/user_photo/" . "$hip_photo[0]";
    if (@$hip_photo[0] != null) {
        unlink($shoulder_part);
    }

//删除数据库数据
    $measure_id_del = "delete from user_measure_photo_opinion where user_id = '$unionid'";
    if(mysql_query($measure_id_del)){
        echo "<script>alert('删除成功！');</script>";
        $url = "http://www.ka-fang.cn:8080/online/edition_assistant.html";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        echo "<script>alert('删除失败！');</script>";
        $url = "http://www.ka-fang.cn:8080/online/edition_assistant.html";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}
//删除暂存量体数据
if (@$_GET['del_temp_mid'] != null) {
    $temp_m_id = $_GET['del_temp_mid'];
    $data_delete = "delete from user_measure_temp_list where measure_id = '$temp_m_id'";
    if (mysql_query($data_delete)) {
        $url = "http://www.ka-fang.cn:8080/online/volume_self.html";
        echo "<script>alert('删除成功！');";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        $url = "http://www.ka-fang.cn:8080/online/volume_self.html";
        echo "<script>alert('删除失败！');";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}
//删除量体数据，即is_use字段置0
if (@$_GET['del_mid']!=null) {
    $m_id = $_GET['del_mid'];
    $data_delete = "UPDATE user_measure_list set is_use = '0' where measure_id = '$m_id'";
    if(mysql_query($data_delete)){
        $url = "http://www.ka-fang.cn:8080/online/unconfirmed_data_adjust.php";
        echo "<script>alert('删除成功！');";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        $url = "http://www.ka-fang.cn:8080/online/unconfirmed_data_adjust.php";
        echo "<script>alert('删除失败！');";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}

//取消专业版型设计数据确认
if (isset($_GET['del_pro_part']) && @$_GET['del_pro_part']!=null) {
    $m_id = $_GET['del_pro_part'];
    //如有已上传的照片，将其删除后删除数据库数据
    $img_select = "select * from user_model_staff_temp_list where model_id = '$m_id'";
    $img_select_rs = mysql_query($img_select);
    while ($rows = mysql_fetch_assoc($img_select_rs)) {
        $front_photo[] = "$rows[front_photo]";
        $back_photo[] = "$rows[back_photo]";
        $side_photo[] = "$rows[side_photo]";
    }
    $front_photo_add = "D:/user_photo/". "$front_photo[0]";
    $back_photo_add  = "D:/user_photo/". "$back_photo[0]";
    $side_photo_add  = "D:/user_photo/". "$side_photo[0]";
    if (@$front_photo[0] != null) {
        unlink($front_photo_add);
    }
    if (@$back_photo[0] != null) {
        unlink($back_photo_add);
    }
    if (@$side_photo[0] != null) {
        unlink($side_photo_add);
    }
    //删除数据库数据
    $data_delete = "DELETE from user_model_staff_temp_list where model_id = '$m_id' and user_id = '$unionid'";
    if(mysql_query($data_delete)){
        unset($_SESSION['pro_data_model_id']);
        $url = "http://www.ka-fang.cn:8080/online/professional_design.html";
        echo "<script>alert('取消成功！');";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        $url = "http://www.ka-fang.cn:8080/online/professional_design.html";
        echo "<script>alert('删除失败！');";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}
 ?>