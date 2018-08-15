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

//获取用户点击确定的view_model_id
if (isset($_GET['m_id']) && $_GET['m_id'] != null) {
	$get_model_id = $_GET['m_id'];
	//将model_id写入session以便上传照片
	$_SESSION['pro_data_model_id'] = $get_model_id;
	//删除没有提交时间的垃圾数据
	//如果有图片，先删除上传的图片
	$delete_img_sel = "select * from user_model_staff_temp_list where user_id = '$unionid' and model_id = '$get_model_id' and submit_time is null";
	$delete_img_sel_rs = mysql_query($delete_img_sel);
	if(mysql_num_rows($delete_img_sel_rs) != 0){
		while($rows = mysql_fetch_assoc($delete_img_sel_rs)){
			$front_photo[] = $rows['front_photo'];
			$side_photo[] = $rows['side_photo'];
			$back_photo[] = $rows['back_photo'];
		}
		@$front_add = "D:/user_photo/" . "$front_photo[0]";
		@$side_photo = "D:/user_photo/" . "$side_photo[0]";
		@$back_add = "D:/user_photo" . "$back_photo[0]";
		if(@$front_photo[0] != null){
			@unlink($front_add);
		}
		if(@$side_photo[0] != null){
			@unlink($side_add);
		}
		if(@$back_photo[0] != null){
			@unlink($back_add);
		}
		//删除数据库数据
		$delete_sql = "delete from user_model_staff_temp_list where user_id = '$unionid' and model_id = '$get_model_id' and submit_time is null";
		mysql_query($delete_sql);
	}
	
	//根据model_id查询user_model_staff_temp_list表中是否有记录
	$model_id_select = "select model_id from user_model_staff_temp_list where model_id = '$get_model_id'";
	$model_id_select_rs = mysql_query($model_id_select);
	//根据model_id查询measure_id和caption
	$measure_caption_select = "select * from user_current_model_list where user_id = '$unionid' and model_id = '$get_model_id'";
	$measure_caption_select_rs = mysql_query($measure_caption_select);
	while($rows = mysql_fetch_assoc($measure_caption_select_rs)){
		$old_user_measure_id[] = $rows['user_measure_id'];
		$old_caption[] = $rows['caption'];
	}
    //如果没有该记录
    if (mysql_num_rows($model_id_select_rs) < 1) {
        //插入新记录
        $new_data_insert = "INSERT into user_model_staff_temp_list(model_id,state,produce_time,user_id,remark,measure_id,caption) values('$_SESSION[pro_data_model_id]','0',now(),'$unionid','0','$old_user_measure_id[0]','$old_caption[0]')";
        $new_data_insert_rs = mysql_query($new_data_insert);
            echo "<script>alert('提交成功！请继续提交图片。')</script>";
            $url = "http://www.ka-fang.cn:8080/online/pro_data_img_submit.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
    }elseif (mysql_num_rows($model_id_select_rs) >= 1) {       //如果有该model_id记录
        //查询state数据
        $state_select = "select state from user_model_staff_temp_list where model_id = '$get_model_id'";
        $state_select_rs = mysql_query($state_select);
        while ($rows = mysql_fetch_assoc($state_select_rs)) {
            $state[] = "$rows[state]";
        }
        //判断state数据是0还是1
        if ($state[0] == '1') {
            echo "<script>alert('您选择的该版型数据版师已经进行了调整，请您到数据确认页面确认后再进行调整。')</script>";
            $url = "http://www.ka-fang.cn:8080/online/pro_ver_con.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
            exit;
        }
        elseif($state[0] == '0'){
            //删除该记录所以数据及图片
            $old_image_select = "select * from user_model_staff_temp_list where model_id = '$get_model_id'";
            $old_image_select_rs = mysql_query($old_image_select);
            while ($rows = mysql_fetch_assoc($old_image_select_rs)) {
                //查询三张图片的信息并删除
                $front_photo[] = "$rows[front_photo]";
                $side_photo[] = "$rows[side_photo]";
                $back_photo[] = "$rows[back_photo]";
            }
            //删除照片
            $front_photo_add = "D:user_photo/"."$front_photo[0]";
            $side_photo_add = "D:user_photo/"."$side_photo[0]";
            $back_photo_add = "D:user_photo/"."$back_photo[0]";
            @unlink($front_photo_add);
            @unlink($side_photo_add);
            @unlink($back_photo_add);
            //删除数据库信息
            $old_date_delete = "delete from user_model_staff_temp_list where user_id = '$unionid' and model_id = '$get_model_id'";
            mysql_query($old_date_delete);

            //重新插入信息
            $new_data_insert = "INSERT into user_model_staff_temp_list(model_id,state,produce_time,user_id) values('$_SESSION[pro_data_model_id]','1',now(),'$unionid')";
            $new_data_insert_rs = mysql_query($new_data_insert);
            echo "<script>alert('提交成功！请继续提交图片。')</script>";
            $url = "http://www.ka-fang.cn:8080/online/pro_data_img_submit.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }

    }
}

//获取三张示例照片
$exp_image_select_1 = "select image from measure_image_para where measure_name = 'front_photo'";
$exp_image_select_1_rs = mysql_query($exp_image_select_1);
while ($rows = mysql_fetch_assoc($exp_image_select_1_rs)) {
    $front_photo_img[] = "$rows[image]";
}
$exp_image_select_2 = "select image from measure_image_para where measure_name = 'back_photo'";
$exp_image_select_2_rs = mysql_query($exp_image_select_2);
while ($rows = mysql_fetch_assoc($exp_image_select_2_rs)) {
    $back_photo_img[] = "$rows[image]";
}
$exp_image_select_3 = "select image from measure_image_para where measure_name = 'side_photo'";
$exp_image_select_3_rs = mysql_query($exp_image_select_3);
while ($rows = mysql_fetch_assoc($exp_image_select_3_rs)) {
    $side_photo_img[] = "$rows[image]";
}

//获取已插入数据库的照片
@$insert_img_select = "select * from user_model_staff_temp_list where model_id = '$_SESSION[pro_data_model_id]'";
$insert_img_select_rs = mysql_query($insert_img_select);
while ($rows = mysql_fetch_assoc($insert_img_select_rs)) {
    $front_photo_sel[] = "$rows[front_photo]";
    $back_photo_sel[] = "$rows[back_photo]";
    $side_photo_sel[] = "$rows[side_photo]";
}

//用户点击保存信息
if (@$_GET['action'] == 'save') {
    //首先检查三张照片是否全部提交
    if ($front_photo_sel[0] != null && $back_photo_sel[0] != null && $side_photo_sel[0] != null && $front_photo_sel[0] != '' && $back_photo_sel[0] != '' && $side_photo_sel[0] != '') {
        //更新数据库submit_time
        $time_update = "UPDATE user_model_staff_temp_list set submit_time = now() where model_id = '$_SESSION[pro_data_model_id]'";
        if(mysql_query($time_update)){
            //销毁session
            unset($_SESSION['pro_data_model_id']);
            echo "<script>alert('提交成功！感谢您的使用。')</script>";
            $url = "http://www.ka-fang.cn:8080/online/professional_design.html";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }
    }else{
        //如果未全部提交
        echo "<script>alert('您还有照片未上传，不能提交。')</script>";
        $url = "http://www.ka-fang.cn:8080/online/pro_data_img_submit.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }

}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>数据提交</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<script src="../js/new_form_validation.js"></script>
<style>
    #upload_file{
        width: 400px;
        margin-bottom: 100px;
    }
    #upload_file table tr td{
        width: 200px;
    }
    #exp_img{
        height: 300px;
    }
    #exp_img ul{
        width:1000px;
    }
    #exp_img ul li{
        width: 200px;
        list-style: none;
        float: left;
        margin-left: 100px;
    }
    #exp_img ul li img{
        width: 200px;
        margin:0 auto;
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
    <p>在选择您要调整的版型数据后，需要您按照提示提交三张照片供版师参考，点击确认提交后将由卡方专业版师帮您确定版型数据，您可以在版型确认里面看到版师给您提供的版型数据，点击放弃提交将取消您的这次服务请求。谢谢。</p>
</div>
<!-- 示例照片 -->
<div class="button" id="exp_img">
    <ul>
        <li><div class="exp_img"><?php echo "<img src=/online/online/$front_photo_img[0]>"; ?></div></li>
        <li><div class="exp_img"><?php echo "<img src=/online/online/$back_photo_img[0]>"; ?></div></li>
        <li><div class="exp_img"><?php echo "<img src=/online/online/$side_photo_img[0]>"; ?></div></li>
    </ul>
</div>
<!-- 文字提示说明 -->
<div class="button">
    <p>文字提示说明</p>
</div>
<!-- 照片上传区 -->
<div id="upload_file">
<h3>照片提交区</h3>
    <table>
        <tr>
            <td>正前照：<?php if(@$front_photo_sel[0] != null) echo "(已提交)"; ?></td>
            <td><?php if (@$front_photo_sel[0] != null){
                    echo "<a href='pro_data_img_up.php?exp_part=front_photo'>重新提交</a>";
                }else{
                    echo "<a href='pro_data_img_up.php?exp_part=front_photo'>提交</a>";
                    }?>
            </td>
        </tr>
        <tr>
            <td>背后照：<?php if(@$back_photo_sel[0] != null) echo "(已提交)"; ?></td>
            <td><?php if (@$back_photo_sel[0] != null){
                    echo "<a href='pro_data_img_up.php?exp_part=back_photo'>重新提交</a>";
                }else{
                    echo "<a href='pro_data_img_up.php?exp_part=back_photo'>提交</a>";
                    }?>
            </td>
        </tr>
        <tr>
            <td>侧面照：<?php if(@$side_photo_sel[0] != null) echo "(已提交)"; ?></td>
            <td><?php if (@$side_photo_sel[0] != null){
                    echo "<a href='pro_data_img_up.php?exp_part=side_photo'>重新提交</a>";
                }else{
                    echo "<a href='pro_data_img_up.php?exp_part=side_photo'>提交</a>";
                    }?>
            </td>
        </tr>
        <tr>
            <td><a href="?action=save">保存</a></td>
            <td><a href="../weixin/delete.php?del_pro_part=<?php echo "$_SESSION[pro_data_model_id]"; ?>">取消</a></td>
            <!-- 保存取消后注意及时销毁session对象 -->
        </tr>
    </table>
</div>

<script>
        // 这里是一个闭包运算。需要学习理解。
var plus = function(i) {
  // 这儿出现了一个新的scope
  return function(){
    $("#measure_table_"+i).fadeToggle();
    $("#plus_"+i).hide();
    $("#minus_"+i).show();
  };
};
var minus = function(i) {
  // 这儿出现了一个新的scope
  return function(){
    $("#measure_table_"+i).fadeToggle();
    $("#minus_"+i).hide();
    $("#plus_"+i).show();
  };
};

for(var i=0; i< <?php echo count($view_model_id); ?>; i++) {
  $('#plus_' + i).click( plus(i) );
  $('#minus_' + i).click( minus(i) );
}
</script>
</body>
</html>