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

//删除提交时间为空的数据
//$time_null_delete = "DELETE from user_model_staff_temp_list where user_id = '$unionid' and submit_time is null";
//mysql_query($time_null_delete);
//获取可选数据列表数据
	$current_list_select = "select * from user_current_model_list where model_id in (select model_id from user_model_staff_temp_list where submit_time is not null  order by produce_time desc) and user_id = '$unionid'";
    $current_list_select_rs = mysql_query($current_list_select);
    while ($rows = @mysql_fetch_assoc($current_list_select_rs)) {
        $view_caption[] = "$rows[caption]";
        $view_model_id[] = "$rows[model_id]";
    }
	
 //查询提交用户时间
	$user_submit_time_sel = "select * from user_model_staff_temp_list where model_id in (select model_id from user_current_model_list where submit_time is not null) and user_id = '$unionid' order by produce_time desc";
	$user_submit_time_sel_rs = mysql_query($user_submit_time_sel);
	while($rows = mysql_fetch_assoc($user_submit_time_sel_rs)){
		$view_produce_time[] = $rows['produce_time'];
	}
//如果数据列表为空
if (count(@$view_model_id) == '0' ) {
    echo "<script>alert('还没有需要确认的版型数据，请到数据提交区提交您的照片。')</script>";
    $url = "http://www.ka-fang.cn:8080/online/professional_design.html";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

//获取用户提交的model_id
if (isset($_GET['m_id']) && $_GET['m_id'] != null) {
    $model_id = $_GET['m_id'];
    //将model_id写入session，以便确认和放弃使用
    $_SESSION['pro_model_id'] = $model_id;
    //根据model_id查询信息，显示用户和版师数据
    $user_data_select = "select * from user_current_model_list where model_id = '$model_id' and user_id = '$unionid'";
    $user_data_select_rs = mysql_query($user_data_select);
    while ($rows = mysql_fetch_assoc($user_data_select_rs)) {
        $user_caption[] = "$rows[caption]";
        $user_model_id[] = "$rows[model_id]";
        $user_measure_id[] = "$rows[user_measure_id]";
        $user_shoulder_width[] = "$rows[shoulder_width]";
        $user_sleeve_length[] = "$rows[sleeve_length]";
        $user_clothes_length[] = "$rows[clothes_length]";
        $user_neck_girth[] = "$rows[neck_girth]";
        $user_sleeve_width[] = "$rows[sleeve_width]";
        $user_wrist_girth[] = "$rows[wrist_girth]";
        $user_chest_girth[] = "$rows[chest_girth]";
        $user_waist_girth[] = "$rows[waist_girth]";
        $user_sweep_girth[] = "$rows[sweep_girth]";
        $user_shoulder_style[] = "$rows[shoulder_style]";
		$user_elbow_girth[] = "$rows[elbow_girth]";
    }
    //将measure_id写入session
    $_SESSION['pro_measure_id'] = $user_measure_id[0];
    //查询版师数据
    $designer_data_select = "select * from user_model_staff_temp_list where model_id = '$model_id'";
    $designer_data_select_rs = mysql_query($designer_data_select);
    while ($rows = mysql_fetch_assoc($designer_data_select_rs)) {
        $designer_model_id[] = "$rows[model_id]";
        $designer_user_measure_id[] = "$rows[measure_id]";
        $designer_caption[] = "$rows[caption]";
        $designer_shoulder_width[] = "$rows[shoulder_width]";
        $designer_sleeve_length[] = "$rows[sleeve_length]";
        $designer_clothes_length[] = "$rows[clothes_length]";
        $designer_neck_girth[] = "$rows[neck_girth]";
        $designer_sleeve_width[] = "$rows[sleeve_width]";
        $designer_wrist_girth[] = "$rows[wrist_girth]";
        $designer_chest_girth[] = "$rows[chest_girth]";
        $designer_waist_girth[] = "$rows[waist_girth]";
        $designer_sweep_girth[] = "$rows[sweep_girth]";
        $designer_shoulder_style[] = "$rows[shoulder_style]";
        $designer_staff_id[] = "$rows[staff_id]";
		$designer_elbow_girth[] = "$rows[elbow_girth]";
    }

}


//用户点击确认
if (isset($_GET['action']) && $_GET['action'] == 'ad_confirm') {
    $current_list_update = "UPDATE user_current_model_list set state = '0' where model_id = '$_SESSION[pro_model_id]'";
    if (mysql_query($current_list_update)) {
        //根据model_id查找版师数据
        $old_data_select = "select * from user_model_staff_temp_list where model_id = '$_SESSION[pro_model_id]'";
        $old_data_select_rs = mysql_query($old_data_select);
        while ($rows = mysql_fetch_assoc($old_data_select_rs)) {
            $designer_model_id[] = "$rows[model_id]";
            $designer_user_measure_id[] = "$rows[user_measure_id]";
            $designer_shoulder_width[] = "$rows[shoulder_width]";
            $designer_sleeve_length[] = "$rows[sleeve_length]";
            $designer_clothes_length[] = "$rows[clothes_length]";
            $designer_neck_girth[] = "$rows[neck_girth]";
            $designer_sleeve_width[] = "$rows[sleeve_width]";
            $designer_wrist_girth[] = "$rows[wrist_girth]";
            $designer_chest_girth[] = "$rows[chest_girth]";
            $designer_waist_girth[] = "$rows[waist_girth]";
            $designer_sweep_girth[] = "$rows[sweep_girth]";
            $designer_shoulder_style[] = "$rows[shoulder_style]";
            $designer_staff_id[] = "$rows[staff_id]";
			$designer_elbow_girth[] = "$rows[elbow_girth]";
        }
        //在user_current_model_list插入新数据
        $new_data_insert = "INSERT into user_current_model_list(model_id,user_measure_id,produce_time,producer_id,state,shoulder_width,sleeve_length,clothes_length,neck_girth,sleeve_width,wrist_girth,chest_girth,waist_girth,sweep_girth,shoulder_style,elbow_girth) values(UUID(),'$_SESSION[pro_measure_id]',now(),'$designer_staff_id[0]','1','$designer_shoulder_width[0]','$designer_sleeve_length[0]','$designer_clothes_length[0]','$designer_neck_girth[0]','$designer_sleeve_width[0]','$designer_wrist_girth[0]','$designer_chest_girth[0]','$designer_waist_girth[0]','$designer_sweep_girth[0]','$designer_shoulder_style[0]','$designer_elbow_girth[0]')";
        if (mysql_query($new_data_insert)) {
            //销毁session
            unset($_SESSION['pro_measure_id']);
            echo "<script>";
            echo "alert('感谢您使用新的数据。')";
            $url = "http://www.ka-fang.cn:8080/online/pro_ver_con.php";
            echo "window.location.href='$url'";
            echo "</script>";
        }
    }
}

//用户点击取消
if (isset($_GET['action']) && $_GET['action'] == 'ad_giveup') {
    $old_data_delete = "delete from user_model_staff_temp_list where model_id = '$_SESSION[pro_model_id]'";
    if (mysql_query($old_data_delete)) {
        //销毁session
        unset($_SESSION['pro_measure_id']);
        echo "<script>";
        echo "alert('感谢您继续使用原数据。')";
        $url = "http://www.ka-fang.cn:8080/online/pro_ver_con.php";
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
<title>版型确认</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<script src="../js/new_form_validation.js"></script>
<style>
    #manual_input form{
        width: 400px;
        float: left;
        margin-left: 80px;
        margin-top: 50px;
        margin-bottom: 50px;
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
    <p>请在列表中选择您要确认的数据，如果您觉得版师调整的数据更好，请点击确认，如果您觉得版师的结果不好，请点击放弃，谢谢。</p>
</div>
<!-- 可选数据列表 -->
<div id="measure_table">
    <?php for($i=0;$i<count($view_model_id);$i++){ ?>
    <h3 id="measure_head_<?php echo "$i"; ?>">
        <img id="plus_<?php echo "$i"; ?>" src="../images/online/plus.png" height="26" width="26">
        <img style="display:none" id="minus_<?php echo "$i"; ?>" src="../images/online/minus.png" height="26" width="26">
        <label><?php echo @"$view_caption[$i]"; ?></label>
        <a href="?m_id=<?php echo "$view_model_id[$i]"; ?>">查看数据</a>
    </h3>
    <table id="measure_table_<?php echo "$i"; ?>">
            <tr>
                <td>标题：</td>
                <td colspan="3" style="text-align: left;"><?php echo @"$view_caption[$i]"; ?>
                </td>
            </tr>
            <tr>
                <td>提交时间：</td>
                <td colspan="3" class="left_input"><?php echo @"$view_produce_time[$i]"; ?></td>
            </tr>
        </table>
    <?php } ?>
</div>
<!-- 用户数据和版师调整后数据展示区 -->
<!-- 用户数据展示 -->
<?php if(isset($_GET['m_id']) && $_GET['m_id'] != null) { ?>
<div id="manual_input">
    <h3>数据展示区(左侧为用户数据，右侧为版师调整数据)</h3>
    <form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
        <table>
            <tr>
                <td>标题：</td>
                <td id="caption"><?php echo @"$user_caption[0]"; ?></td>
                <td>肩型：</td>
                <td class="left_input"><?php
                	if(@$user_shoulder_style[0] == '1'){
                		echo '正常肩';
                	}elseif(@$user_shoulder_style[0] == '2'){
                		echo '端肩';
                	}elseif(@$user_shoulder_style[0] == '3'){
                		echo '溜肩';
                	}elseif(@$user_shoulder_style[0] == '4'){
                		echo '高低肩';
                	}
                ?></td>
            </tr>
            <tr>
            	<td>上领围：</td>
                <td class="left_input"><?php echo @"$user_neck_girth[0]"; ?></td>
                <td>肩宽：</td>
                <td class="left_input"><?php echo @"$user_shoulder_width[0]"; ?></td>
            </tr>
            <tr>
                <td>胸围：</td>
                <td class="left_input"><?php echo @"$user_chest_girth[0]"; ?></td>
                <td>腰围：</td>
                <td class="left_input"><?php echo @"$user_waist_girth[0]"; ?></td>
            </tr>
            <tr>
            	<td>下摆围：</td>
                <td class="left_input"><?php echo @"$user_sweep_girth[0]"; ?></td>
                <td>袖肥：</td>
                <td class="left_input"><?php echo @"$user_sleeve_width[0]"; ?></td>
            </tr>
            <tr>
                <td>肘围：</td>
                <td class="left_input"><?php echo @"$user_elbow_girth[0]"; ?></td>
                <td>袖口围：</td>
                <td class="left_input"><?php echo @"$user_wrist_girth[0]"; ?></td>
            </tr>
            <tr>
                <td>袖长：</td>
                <td class="left_input"><?php echo @"$user_sleeve_length[0]"; ?></td>
                <td>后衣长：</td>
                <td class="left_input"><?php echo @"$user_clothes_length[0]"; ?></td>
            </tr>
        </table>
    </form>

<!-- 版师调整数据 -->
    <form name="form">
        <table>
            <tr>
                <td>标题：</td>
                <td id="caption"><?php echo @"$designer_caption[0]"; ?></td>
                <td>肩型：</td>
                <td class="left_input"><?php
                	if(@$designer_shoulder_style[0] == '1'){
                		echo '正常肩';
                	}elseif(@$designer_shoulder_style[0] == '2'){
                		echo '端肩';
                	}elseif(@$designer_shoulder_style[0] == '3'){
                		echo '溜肩';
                	}elseif(@$designer_shoulder_style[0] == '4'){
                		echo '高低肩';
                	}
                ?></td>
            </tr>
            <tr>
            	<td>上领围：</td>
                <td class="left_input"><?php echo @"$designer_neck_girth[0]"; ?></td>
                <td>肩宽：</td>
                <td class="left_input"><?php echo @"$designer_shoulder_width[0]"; ?></td>
            </tr>
            <tr>
                <td>胸围：</td>
                <td class="left_input"><?php echo @"$designer_chest_girth[0]"; ?></td>
                <td>腰围：</td>
                <td class="left_input"><?php echo @"$designer_waist_girth[0]"; ?></td>
            </tr>
            <tr>
            	<td>下摆围：</td>
                <td class="left_input"><?php echo @"$designer_sweep_girth[0]"; ?></td>
                <td>袖肥：</td>
                <td class="left_input"><?php echo @"$designer_sleeve_width[0]"; ?></td>
            </tr>
            <tr>
                <td>肘围：</td>
                <td class="left_input"><?php echo @"$designer_elbow_girth[0]"; ?></td>
                <td>袖口围：</td>
                <td class="left_input"><?php echo @"$designer_wrist_girth[0]"; ?></td>
            </tr>
            <tr>
                <td>袖长：</td>
                <td class="left_input"><?php echo @"$designer_sleeve_length[0]"; ?></td>
                <td>后衣长：</td>
                <td class="left_input"><?php echo @"$designer_clothes_length[0]"; ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="submit"><a href="?action=ad_confirm">确认</a></td>
                <td class="submit"><a href="?action=ad_giveup">放弃</a></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
<?php } ?>

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