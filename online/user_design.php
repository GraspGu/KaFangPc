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
    $sessionname = $_SESSION["nameSession"];
}

//获取order_detail_view中的数据
    $current_list_select = "select * from user_current_model_list where model_id in (select model_id from order_list_view) and state = '1' and user_id = '$unionid'";
    $current_list_select_rs = mysql_query($current_list_select);
    while ($rows = mysql_fetch_assoc($current_list_select_rs)) {
        $view_caption[] = "$rows[caption]";
        $view_model_id[] = "$rows[model_id]";
        $view_user_measure_id[] = "$rows[user_measure_id]";
        $view_shoulder_width[] = "$rows[shoulder_width]";
        $view_sleeve_length[] = "$rows[sleeve_length]";
        $view_clothes_length[] = "$rows[clothes_length]";
        $view_neck_girth[] = "$rows[neck_girth]";
        $view_sleeve_width[] = "$rows[sleeve_width]";
        $view_wrist_girth[] = "$rows[wrist_girth]";
        $view_chest_girth[] = "$rows[chest_girth]";
        $view_waist_girth[] = "$rows[waist_girth]";
        $view_sweep_girth[] = "$rows[sweep_girth]";
        $view_shoulder_style[] = "$rows[shoulder_style]";
		$view_elbow_girth[] = "$rows[elbow_girth]";
    }
//判断是否有数据
if (count(@$view_model_id) == '0') {
    echo "<script>alert('您还没有可以调整的版型数据，只有在您购买后才可以进行版型设计，谢谢.');</script>";
    $url = "http://www.ka-fang.cn:8080/online/version_design.html";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

//获取本页面提交的model_id，得到数据并写入session
if (isset($_GET['m_id']) && $_GET['m_id'] != null) {
    $GET_model_id = $_GET['m_id'];
    //获取user_measure_list中的对应值
    $data_model_select = "select * from user_current_model_list where model_id = '$GET_model_id'";
    $data_model_select_rs = mysql_query($data_model_select);
    while ($rows = mysql_fetch_assoc($data_model_select_rs)) {
        $model_caption[] = "$rows[caption]";
        $model_id[] = "$rows[model_id]";
        $model_user_measure_id[] = "$rows[user_measure_id]";
        $model_shoulder_width[] = "$rows[shoulder_width]";
        $model_sleeve_length[] = "$rows[sleeve_length]";
        $model_clothes_length[] = "$rows[clothes_length]";
        $model_neck_girth[] = "$rows[neck_girth]";
        $model_sleeve_width[] = "$rows[sleeve_width]";
        $model_wrist_girth[] = "$rows[wrist_girth]";
        $model_chest_girth[] = "$rows[chest_girth]";
        $model_waist_girth[] = "$rows[waist_girth]";
        $model_sweep_girth[] = "$rows[sweep_girth]";
        $model_shoulder_style[] = "$rows[shoulder_style]";
		$model_elbow_girth[] = "$rows[elbow_girth]";
    }
        //将measure_id写入session，以便保存数据时使用
        $_SESSION['model_user_measure_id'] = $model_user_measure_id[0];
        $_SESSION['model_id'] = $model_id[0];
    //获取user_measure_temp_list中的对应值
    $data_temp_select = "select * from user_current_model_temp_list where model_id = '$GET_model_id'";
    $data_temp_select_rs = mysql_query($data_temp_select);
    while ($rows = mysql_fetch_assoc($data_temp_select_rs)) {
        $temp_model_caption[] = "$rows[caption]";
        $temp_model_id[] = "$rows[model_id]";
        $temp_model_shoulder_width[] = "$rows[shoulder_width]";
        $temp_model_sleeve_length[] = "$rows[sleeve_length]";
        $temp_model_clothes_length[] = "$rows[clothes_length]";
        $temp_model_neck_girth[] = "$rows[neck_girth]";
        $temp_model_sleeve_width[] = "$rows[sleeve_width]";
        $temp_model_wrist_girth[] = "$rows[wrist_girth]";
        $temp_model_chest_girth[] = "$rows[chest_girth]";
        $temp_model_waist_girth[] = "$rows[waist_girth]";
        $temp_model_sweep_girth[] = "$rows[sweep_girth]";
        $temp_model_shoulder_style[] = "$rows[shoulder_style]";
		$temp_model_elbow_girth[] = "$rows[elbow_girth]";
    }
}

//用户保存表单暂存数据的操作
if (isset($_POST['temp_caption']) && @$_POST["temp"] == "保存") {
    $temp_data_update = "UPDATE user_current_model_list set state = '1' where model_id = '$_SESSION[model_id]'";
    if (mysql_query($temp_data_update)) {
        //销毁model_id的session
        unset($_SESSION['model_id']);
        $temp_caption = $_POST['temp_caption'];
        $temp_shoulder_width = $_POST['temp_shoulder_width'];
        $temp_sleeve_length = $_POST['temp_sleeve_length'];
        $temp_clothes_length = $_POST['temp_clothes_length'];
        $temp_neck_girth = $_POST['temp_neck_girth'];
        $temp_sleeve_width = $_POST['temp_sleeve_width'];
        $temp_wrist_girth = $_POST['temp_wrist_girth'];
        $temp_chest_girth = $_POST['temp_chest_girth'];
        $temp_waist_girth = $_POST['temp_waist_girth'];
        $temp_sweep_girth = $_POST['temp_sweep_girth'];
        $temp_shoulder_style = $_POST['temp_shoulder_style'];
		$temp_elbow_girth = $_POST['temp_elbow_girth'];

        $new_data_insert = "INSERT into user_current_model_list(model_id,user_id,user_measure_id,produce_time,producer_id,state,caption,shoulder_width,sleeve_length,clothes_length,neck_girth,sleeve_width,wrist_girth,chest_girth,waist_girth,sweep_girth,shoulder_style,elbow_girth) values(UUID(),'$unionid','$_SESSION[model_user_measure_id]',now(),'$unionid','1','$temp_caption','$temp_shoulder_width','$temp_sleeve_length','$temp_clothes_length','$temp_neck_girth','$temp_sleeve_width','$temp_wrist_girth','$temp_chest_girth','$temp_waist_girth','$temp_sweep_girth','$temp_shoulder_style','$temp_elbow_girth')";
        if (mysql_query($new_data_insert)) {
            //销毁measure_id的session
            unset($_SESSION['user_measure_id']);
            echo "<script>alert('保存数据成功！');</script>";
            $url = "http://www.ka-fang.cn:8080/online/user_design.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }else{
            echo "<script>alert('保存数据失败！'); history.go(-2);</script>";
        }
    }else{
        echo "<script>alert('表单提交失败！请刷新重试。'); history.go(-2);</script>";
    }
}

//用户另存表单暂存数据的操作
if (isset($_POST['temp_caption']) && @$_POST["confirm"] == "另存") {
    $temp_caption = $_POST['temp_caption'];
    $temp_shoulder_width = $_POST['temp_shoulder_width'];
    $temp_sleeve_length = $_POST['temp_sleeve_length'];
    $temp_clothes_length = $_POST['temp_clothes_length'];
    $temp_neck_girth = $_POST['temp_neck_girth'];
    $temp_sleeve_width = $_POST['temp_sleeve_width'];
    $temp_wrist_girth = $_POST['temp_wrist_girth'];
    $temp_chest_girth = $_POST['temp_chest_girth'];
    $temp_waist_girth = $_POST['temp_waist_girth'];
    $temp_sweep_girth = $_POST['temp_sweep_girth'];
    $temp_shoulder_style = $_POST['temp_shoulder_style'];
	$temp_elbow_girth = $_POST['temp_elbow_girth'];

    $new_data_insert = "INSERT into user_current_model_list(model_id,user_id,user_measure_id,produce_time,producer_id,state,caption,shoulder_width,sleeve_length,clothes_length,neck_girth,sleeve_width,wrist_girth,chest_girth,waist_girth,sweep_girth,shoulder_style,elbow_girth) values(UUID(),'$unionid','$_SESSION[model_user_measure_id]',now(),'$unionid','1','$temp_caption','$temp_shoulder_width','$temp_sleeve_length','$temp_clothes_length','$temp_neck_girth','$temp_sleeve_width','$temp_wrist_girth','$temp_chest_girth','$temp_waist_girth','$temp_sweep_girth','$temp_shoulder_style','$temp_elbow_girth')";
    if (mysql_query($new_data_insert)) {
        //销毁measure_id的session
        unset($_SESSION['user_measure_id']);
        unset($_SESSION['model_id']);
        echo "<script>alert('另存数据成功！');</script>";
        $url = "http://www.ka-fang.cn:8080/online/user_design.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }else{
        echo "<script>alert('另存数据失败！'); history.go(-2);</script>";
    }
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>卡方版型设计</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<script src="../js/new_form_validation.js"></script>
<style>

    form table tr td{
        padding-left: 10px;
    }
    form table tr td p{
        width: 200px;
        text-align: center;
    }
    button{
        border:none;
        background-color: #f40;
        padding:5px;
        border-radius: 10px;
        width: 50px;
    }
    button:hover{
        cursor: pointer;
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
    <p>您可以根据自己的感觉，在我们的调整说明指引下修改自己的版型数据，谢谢。点击保存按钮，您讲把调整后的数据覆盖到当前数据上，点击另存按钮，将根据您调整后的数据生成新的版型数据，为了方便起见，如果您使用另存，最好更改标题内容，这样您再购买衣服或者调整数据的时候会很方便的选择您所需要的版型。(以下数据单位均为厘米)</p>
</div>
<!-- 可选数据列表 -->
<div id="measure_table">
    <?php for($i=0;$i<count($view_model_id);$i++){ ?>
    <h3 id="measure_head_<?php echo "$i"; ?>">
        <img id="plus_<?php echo "$i"; ?>" src="../images/online/plus.png" height="26" width="26">
        <img style="display:none" id="minus_<?php echo "$i"; ?>" src="../images/online/minus.png" height="26" width="26">
        <label><?php echo @"$view_caption[$i]"; ?></label>
        <a href="?m_id=<?php echo "$view_model_id[$i]"; ?>">调整</a>
    </h3>
    <table id="measure_table_<?php echo "$i"; ?>">
            <tr>
                <td>标题：</td>
                <td id="caption"><?php echo @"$view_caption[$i]"; ?></td>
                <td>肩型：</td>
                <td class="left_input"><?php
                	if(@$view_shoulder_style[$i] == '1'){
                		echo '正常肩';
                	}elseif(@$view_shoulder_style[$i] == '2'){
                		echo '端肩';
                	}elseif(@$view_shoulder_style[$i] == '3'){
                		echo '溜肩';
                	}elseif(@$view_shoulder_style[$i] == '4'){
                		echo '高低肩';
                	}
                ?></td>
            </tr>
            <tr>
            	<td>上领围：</td>
                <td class="left_input"><?php echo @"$view_neck_girth[$i]"; ?></td>
                <td>肩宽：</td>
                <td class="left_input"><?php echo @"$view_shoulder_width[$i]"; ?></td>
            </tr>
            <tr>
                <td>胸围：</td>
                <td class="left_input"><?php echo @"$view_chest_girth[$i]"; ?></td>
                <td>腰围：</td>
                <td class="left_input"><?php echo @"$view_waist_girth[$i]"; ?></td>
            </tr>
            <tr>
            	<td>下摆围：</td>
                <td class="left_input"><?php echo @"$view_sweep_girth[$i]"; ?></td>
                <td>袖肥：</td>
                <td class="left_input"><?php echo @"$view_sleeve_width[$i]"; ?></td>
            </tr>
            <tr>
                <td>肘围：</td>
                <td class="left_input"><?php echo @"$view_elbow_girth[$i]"; ?></td>
                <td>袖口围：</td>
                <td class="left_input"><?php echo @"$view_wrist_girth[$i]"; ?></td>
            </tr>
            <tr>
                <td>袖长：</td>
                <td class="left_input"><?php echo @"$view_sleeve_length[$i]"; ?></td>
                <td>后衣长：</td>
                <td class="left_input"><?php echo @"$view_clothes_length[$i]"; ?></td>
            </tr>
        </table>
    <?php } ?>
</div>
<!-- 数据输入区 -->
<div id="manual_input">
    <h3>数据输入区(以下数据请全部填写)</h3>
    <form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="width:750px;">
        <table>
            <tr>
                <th>数据名称</th>
                <th>原始数据值</th>
                <th>暂存数据值</th>
                <th>数据调整</th>
            </tr>
            <tr>
                <td>标题：</td>
                <td class="left_input"><p><?php echo @$model_caption[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_caption" value="<?php
                    if(@$temp_model_caption != null){
                        echo @$temp_model_caption[0];
                    }else{
                        echo @$model_caption[0];
                    }
                ?>"></td>
            </tr>
            <tr>
                <td>肩型：</td>
                <td class="left_input"><p><?php echo @$model_shoulder_style[0];
                    if (@$model_shoulder_style[0] == 1) {
                        echo "正常肩";
                    }elseif (@$model_shoulder_style[0] == 2) {
                        echo "端肩";
                    }elseif (@$model_shoulder_style[0] == 3) {
                        echo "溜肩";
                    }
                ?></p></td>
                <td>
                    <select name="temp_shoulder_style" >
                        <option value="1" <?php
                        if (@$temp_model_shoulder_style[0] != null) {
                            if (@$temp_model_shoulder_style[0] == 1) {
                                echo "selected";
                        }elseif(@$model_shoulder_style[0] != null){
                            if (@$model_shoulder_style[0] == 1) {
                                echo "selected";
                            }
                        }
                        } ?>>正常肩</option>
                        <option value="2" <?php
                        if (@$temp_model_shoulder_style[0] != null) {
                            if (@$temp_model_shoulder_style[0] == 2) {
                                echo "selected";
                        }elseif(@$model_shoulder_style[0] != null){
                            if (@$model_shoulder_style[0] == 2) {
                                echo "selected";
                        }
                            }} ?>>端肩</option>
                        <option value="3" <?php
                        if (@$temp_model_shoulder_style[0] != null) {
                            if (@$temp_model_shoulder_style[0] == 3) {
                                echo "selected";
                        }elseif(@$model_shoulder_style[0] != null){
                            if (@$model_shoulder_style[0] == 3) {
                                echo "selected";
                        }
                            }} ?>>溜肩</option>
                        <option value="4" <?php
                        if (@$temp_model_shoulder_style[0] != null) {
                            if (@$temp_model_shoulder_style[0] == 4) {
                                echo "selected";
                        }elseif(@$model_shoulder_style[0] != null){
                            if (@$model_shoulder_style[0] == 4) {
                                echo "selected";
                        }
                            }} ?>>高低肩</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>上领围：</td>
                <td class="left_input"><p><?php echo @$model_neck_girth[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_neck_girth" value="<?php
                    if (@$temp_model_neck_girth != null) {
                        echo @"$temp_model_neck_girth[0]";
                    }else{
                        echo @$model_neck_girth[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus" value="+">+</button>
                    <button type="button" class="data_minus" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>肩宽：</td>
                <td class="left_input"><p><?php echo @$model_shoulder_width[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_shoulder_width" value="<?php
                    if (@$temp_model_shoulder_width != null) {
                        echo @"$temp_model_shoulder_width[0]";
                    }else{
                        echo @$model_shoulder_width[0];
                    }
                ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus" value="+">+</button>
                    <button type="button" class="data_minus" value="-">-</button>
                </td>
            </tr>
			<tr>
                <td>胸围：</td>
                <td class="left_input"><p><?php echo @$model_chest_girth[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_chest_girth" value="<?php
                    if (@$temp_model_chest_girth != null) {
                        echo @"$temp_model_chest_girth[0]";
                    }else{
                        echo @$model_chest_girth[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus_3" value="+">+</button>
                    <button type="button" class="data_minus_3" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>腰围：</td>
                <td class="left_input"><p><?php echo @$model_waist_girth[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_waist_girth" value="<?php
                    if (@$temp_model_waist_girth != null) {
                        echo @"$temp_model_waist_girth[0]";
                    }else{
                        echo @$model_waist_girth[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus_3" value="+">+</button>
                    <button type="button" class="data_minus_3" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>下摆围：</td>
                <td class="left_input"><p><?php echo @$model_sweep_girth[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_sweep_girth" value="<?php
                    if (@$temp_model_sweep_girth != null) {
                        echo @"$temp_model_sweep_girth[0]";
                    }else{
                        echo @$model_sweep_girth[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus_3" value="+">+</button>
                    <button type="button" class="data_minus_3" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>袖肥：</td>
                <td class="left_input"><p><?php echo @$model_sleeve_width[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_sleeve_width" value="<?php
                    if (@$temp_model_sleeve_width != null) {
                        echo @"$temp_model_sleeve_width[0]";
                    }else{
                        echo @$model_sleeve_width[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus" value="+">+</button>
                    <button type="button" class="data_minus" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>肘围：</td>
                <td class="left_input"><p><?php echo @$model_elbow_girth[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_elbow_girth" value="<?php
                    if (@$temp_model_elbow_girth != null) {
                        echo @"$temp_model_sleeve_width[0]";
                    }else{
                        echo @$model_elbow_girth[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus" value="+">+</button>
                    <button type="button" class="data_minus" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>袖口围：</td>
                <td class="left_input"><p><?php echo @$model_wrist_girth[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_wrist_girth" value="<?php
                    if (@$temp_model_wrist_girth != null) {
                        echo @"$temp_model_wrist_girth[0]";
                    }else{
                        echo @$model_wrist_girth[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus" value="+">+</button>
                    <button type="button" class="data_minus" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>袖长：</td>
                <td class="left_input"><p><?php echo @$model_sleeve_length[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_sleeve_length" value="<?php
                    if (@$temp_model_sleeve_length != null) {
                        echo @"$temp_model_sleeve_length[0]";
                    }else{
                        echo @$model_sleeve_length[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus" value="+">+</button>
                    <button type="button" class="data_minus" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td>后衣长：</td>
                <td class="left_input"><p><?php echo @$model_clothes_length[0];?></p></td>
                <td class="left_input"><input type="text" name="temp_clothes_length" value="<?php
                    if (@$temp_model_clothes_length != null) {
                        echo @"$temp_model_clothes_length[0]";
                    }else{
                        echo @$model_clothes_length[0];
                    }
                 ?>"></td>
                <td class="left_input">
                    <button type="button" class="data_plus" value="+">+</button>
                    <button type="button" class="data_minus" value="-">-</button>
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="submit"><input id="submit_one" type="submit" name="temp" value="保存" onclick="return beforeSubmit_user_design_b()"></td>
                <td class="submit"><input id="submit_two" type="submit" name="confirm" value="另存" onclick="return beforeSubmit_user_design_l()"></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
<!--返回按钮-->
<div class="button">
	<a href="version_design.html">
		<p>返回上一级</p>
	</a>
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

//数据调整按钮，点击一次分别对暂存数据进行加一减一操作
$(".data_plus").click(function() {
    if ($(this).parent().prev().children('input').val() == '' || $(this).parent().prev().children('input').val() == null) {
        $(this).parent().prev().children('input').val("0");
    };
    var val = $(this).parent().prev().children('input').val();
    var plus = parseInt(val) + 1;
    $(this).parent().prev().children('input').val(plus);
});

$(".data_minus").click(function() {
    if ($(this).parent().prev().children('input').val() == '' || $(this).parent().prev().children('input').val() == null || $(this).parent().prev().children('input').val() == '1' || $(this).parent().prev().children('input').val() == '0') {
        alert("数据不能小于1！！");
        return false;
    };
    var val = $(this).parent().prev().children('input').val();
    var minus = parseInt(val) - 1;
    $(this).parent().prev().children('input').val(minus);
});

//数据调整按钮，点击一次分别对暂存数据进行加3减3操作
$(".data_plus_3").click(function() {
    if ($(this).parent().prev().children('input').val() == '' || $(this).parent().prev().children('input').val() == null) {
        $(this).parent().prev().children('input').val("0");
    };
    var val = $(this).parent().prev().children('input').val();
    var plus = parseInt(val) + 3;
    $(this).parent().prev().children('input').val(plus);
});

$(".data_minus_3").click(function() {
    if ($(this).parent().prev().children('input').val() == '' || $(this).parent().prev().children('input').val() == null || $(this).parent().prev().children('input').val() == '1' || $(this).parent().prev().children('input').val() == '0') {
        alert("数据不能小于1！");
        return false;
    };
    var val = $(this).parent().prev().children('input').val();
    var minus = parseInt(val) - 3;
    $(this).parent().prev().children('input').val(minus);
});
</script>
</body>
</html>