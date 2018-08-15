<!-- 未确认数据调整页面 -->
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

//获取user_measure_temp_list数据
$user_measure_list_select = "select * from user_measure_temp_list where user_id = '$unionid' and data_type = '1' order by start_time desc";
$user_measure_list_select_rs = mysql_query($user_measure_list_select);
while($rows = mysql_fetch_assoc($user_measure_list_select_rs)){
    $measure_id[] = $rows['measure_id'];
    $caption[] = $rows['caption'];
    $shoulder_style[] = $rows['shoulder_style'];
    $neck[] = $rows['neck'];
    $shoulder[] = $rows['shoulder'];
    $arm[] = $rows['arm'];
    $elbow[] = $rows['elbow'];
    $wrist[] = $rows['wrist'];
    $sleeve[] = $rows['sleeve'];
    $chest[] = $rows['chest'];
    $waist[] = $rows['waist'];
    $clothes[] = $rows['clothes'];
    $hip[] = $rows['hip'];
}

//获取本页面提交的measure_id
if(@isset($_GET['m_id']) && $_GET['m_id'] != null){
    $m_id = $_GET['m_id'];
    //将measure_id写入session，以便修改暂存数据使用
    $_SESSION['temp_measure_id'] = $m_id;
    $m_id_select = "select * from user_measure_temp_list where user_id = '$unionid' and data_type = '1' and measure_id = '$m_id'";
    $m_id_select_rs = mysql_query($m_id_select);
    while($rows = mysql_fetch_assoc($m_id_select_rs)){
        $table_measure_id[] = $rows['measure_id'];
        $table_caption[] = $rows['caption'];
        $table_shoulder_style[] = $rows['shoulder_style'];
        $table_neck[] = $rows['neck'];
        $table_shoulder[] = $rows['shoulder'];
        $table_arm[] = $rows['arm'];
        $table_elbow[] = $rows['elbow'];
        $table_wrist[] = $rows['wrist'];
        $table_sleeve[] = $rows['sleeve'];
        $table_chest[] = $rows['chest'];
        $table_waist[] = $rows['waist'];
        $table_clothes[] = $rows['clothes'];
        $table_hip[] = $rows['hip'];
    }
    //将caption写入session，以便修改数据使用
    $_SESSION['temp_caption'] = $table_caption[0];
}
//表单提交数据
if(($_SERVER['REQUEST_METHOD'])=='POST') {
        //获取post提交的数据

    $shoulder_style = (int)($_POST['shoulder_style']);

    $neck = (int)$_POST['neck'];
    strTrim($neck);

    $shoulder = (int)$_POST['shoulder'];
    strTrim($shoulder);

    $arm = (int)$_POST['arm'];
    strTrim($arm);

    $elbow = (int)$_POST['elbow'];
    strTrim($elbow);

    $wrist = (int)$_POST['wrist'];
    strTrim($wrist);

    $sleeve = (int)$_POST['sleeve'];
    strTrim($sleeve);

    $chest = (int)$_POST['chest'];
    strTrim($chest);

    $waist = (int)$_POST['waist'];
    strTrim($waist);

    $clothes = (int)$_POST['clothes'];
    strTrim($clothes);

    $hip = (int)$_POST['hip'];
    strTrim($hip);

//分类暂存和确认数据更新
    if (@$_REQUEST['temp']) {
        $temp_sql_update = "UPDATE user_measure_temp_list set neck = '$neck',arm = '$arm',chest = '$chest',waist = '$waist',hip = '$hip',wrist = '$wrist',shoulder = '$shoulder',sleeve = '$sleeve',clothes = '$clothes',shoulder_style = '$shoulder_style',elbow = '$elbow',start_time = now() where user_id = '$unionid' and measure_id = '$_SESSION[temp_measure_id]'";
        if(mysql_query($temp_sql_update)){
            //销毁session
            unset($_SESSION['temp_measure_id']);
            unset($_SESSION['temp_caption']);
            echo "<script>alert('修改成功！')</script>";
            $url = "http://www.ka-fang.cn:8080/online/volume_self.html";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }else{
            echo "提交失败！";
        }
    }
    if(@$_REQUEST['confirm']){
        //用户提交确认数据后启动配版程序，具体看文档地7条，成功后跳向volume_self页面
            $confirm_sql_insert = "INSERT into user_measure_list(measure_id,user_id,start_time,end_time,shoulder_style,neck,shoulder,arm,elbow,wrist,sleeve,chest,waist,clothes,hip,is_use,caption) VALUES(UUID(),'$unionid', now(), now(), '$shoulder_style', '$neck', '$shoulder', '$arm', '$elbow', '$wrist', '$sleeve', '$chest', '$waist', '$clothes',  '$hip','1','$_SESSION[temp_caption]')";
            if(mysql_query($confirm_sql_insert)){
                //删除由于user_measure_temp_list暂存表数据
                $caption_data_delete = "delete from user_measure_temp_list where measure_id = '$_SESSION[temp_measure_id]'";
                if (mysql_query($caption_data_delete)) {
                    //删除暂存表session
                    unset($_SESSION['manual_measure_id']);
                    //获取user_measure_list对应的measure_id
                    $measure_id_select = "select measure_id from user_measure_list where user_id = '$unionid' order by start_time desc limit 1";
                    $measure_id_select_rs = mysql_query($measure_id_select);
                    while ($rows = mysql_fetch_assoc($measure_id_select_rs)) {
                        $list_measure_id[] = "$rows[measure_id]";
                    }
                    require 'version_adjustment.php';   //进行配版
                    $current_model_list_insert = "INSERT into user_current_model_list(user_id,model_id,user_measure_id,produce_time,shoulder_width,sleeve_length,clothes_length,neck_girth,sleeve_width,wrist_girth,chest_girth,waist_girth,sweep_girth,caption) values('$unionid',UUID(),'$list_measure_id[0]',now(),'$fini_shoulder','$fini_sleeve','$fini_clothes','$fini_neck','$fini_arm','$fini_wrist','$fini_chest','$fini_waist','$fini_sweep','$_SESSION[temp_caption]')";
                    if(mysql_query($current_model_list_insert)){
                        //销毁caption
                        unset($_SESSION['temp_caption']);
                        echo "<script>alert('提交成功！');</script>";
                        $url = "http://www.ka-fang.cn:8080/online/volume_self.html";
                        echo "<script language='javascript' type='text/javascript'>";
                        echo "window.location.href='$url'";
                        echo "</script>";
                    }else{
                        echo "<script>alert('配版失败！'); history.go(-1);</script>";
                    }
                }
            }else{
                echo "<script>alert('确认数据提交失败！'); history.go(-1);</script>";
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
<title>未确认数据调整</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<script src="../js/new_form_validation.js"></script>
<style>
    #manual_input form{
        width: 550px;
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
    <p>在该页面您可以对您输入的还未确认的数据进行调整，从数据列表中选择您要调整或者补充的量体数据，调整后如果您点击暂存，那么您以后还可以继续调整，如果您点击确认提交，那么这条量体信息就会成为您的确认信息，来实现您的定制了，谢谢！(以下数据单位均为厘米。)</p>
</div>

<!-- 待确认数据列表部分 -->
<div id="measure_table">
    <?php for($i=0;$i<count($measure_id);$i++){ ?>
    <h3 id="measure_head_<?php echo "$i"; ?>">
        <img id="plus_<?php echo "$i"; ?>" src="../images/online/plus.png" height="26" width="26">
        <img style="display:none" id="minus_<?php echo "$i"; ?>" src="../images/online/minus.png" height="26" width="26">
        <label><?php echo @"$caption[$i]"; ?></label>
        <a href="?m_id=<?php echo "$measure_id[$i]"; ?>">调整数据</a>
        <a href="../weixin/delete.php?del_temp_mid=<?php echo "$measure_id[$i]"; ?>">删除</a>
    </h3>
    <table id="measure_table_<?php echo "$i"; ?>">
        <tr>
            <td>肩型：</td>
            <td class="left_input"><?php if(@$shoulder_style[$i]==1){
                    echo "正常肩";
                }elseif($shoulder_style[$i] == '2'){
                    echo "端肩";
                }elseif($shoulder_style[$i] == '3'){
                    echo "溜肩";
                }elseif($shoulder_style[$i] == '4') {
                    echo "高低肩";
                } ?></td>
        </tr>
        <tr>
            <td>上领围：</td>
            <td class="left_input"><?php echo @$neck[$i]; ?></td>
            <td>肩宽：</td>
            <td class="left_input"><?php echo @$shoulder[$i]; ?></td>
        </tr>
        <tr>
            <td>胸围：</td>
            <td class="left_input"><?php echo @$chest[$i]; ?></td>
            <td>腰围：</td>
            <td class="left_input"><?php echo @$waist[$i]; ?></td>
        </tr>
        <tr>
            <td>臀围：</td>
            <td class="left_input"><?php echo @$hip[$i]; ?></td>
            <td>上臂围：</td>
            <td class="left_input"><?php echo @$arm[$i]; ?></td>
        </tr>
        <tr>
            <td>肘围：</td>
            <td class="left_input"><?php echo @$elbow[$i]; ?></td>
            <td>腕围：</td>
            <td class="left_input"><?php echo @$wrist[$i]; ?></td>
        </tr>
        <tr>
            <td>袖长：</td>
            <td class="left_input"><?php echo @$sleeve[$i]; ?></td>
            <td>后衣长：</td>
            <td class="left_input"><?php echo @$clothes[$i]; ?></td>
        </tr>
    </table>
    <?php } ?>
</div>


<!-- 用户数据输入区 -->
<div id="manual_input">
    <h3>数据输入区(以下数据请全部填写)</h3>
    <form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="return beforeSubmit_caption_p()">
        <table>
            <tr>
                <td>标题：</td>
                <td colspan="3" id="caption"><p><?php if(@$table_caption[0] == '0'){echo "";}else{ echo @$table_caption[0];} ?></p>
                </td>
            </tr>
            <tr>
                <td>肩型：</td>
                <td>
                    <select name="shoulder_style" value="<?php if(@$table_shoulder_style[0] == '0'){echo "";}else{ echo @$table_shoulder_style[0];} ?>">
                        <option value="1">正常肩</option>
                        <option value="2">端肩</option>
                        <option value="3">溜肩</option>
                        <option value="4">高低肩</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>上领围：</td>
                <td class="left_input"><input type="text" name="neck" value="<?php if(@$table_neck[0] == '0'){echo "";}else{ echo @$table_neck[0];} ?>"></td>
                <td>肩宽：</td>
                <td class="left_input"><input type="text" name="shoulder" value="<?php if(@$table_shoulder[0] == '0'){echo "";}else{ echo @$table_shoulder[0];} ?>"></td>
            </tr>
            <tr>
                <td>胸围：</td>
                <td class="left_input"><input type="text" name="chest" value="<?php if(@$table_chest[0] == '0'){echo "";}else{ echo @$table_chest[0];} ?>"></td>
                <td>腰围：</td>
                <td class="left_input"><input type="text" name="waist" value="<?php if(@$table_waist[0] == '0'){echo "";}else{ echo @$table_waist[0];} ?>"></td>
            </tr>
            <tr>
                <td>臀围：</td>
                <td class="left_input"><input type="text" name="hip" value="<?php if(@$table_hip[0] == '0'){echo "";}else{ echo @$table_hip[0];} ?>"></td>
                <td>上臂围：</td>
                <td class="left_input"><input type="text" name="arm" value="<?php if(@$table_arm[0] == '0'){echo "";}else{ echo @$table_arm[0];} ?>"></td>
            </tr>
            <tr>
                <td>肘围：</td>
                <td class="left_input"><input type="text" name="elbow" value="<?php if(@$table_elbow[0] == '0'){echo "";}else{ echo @$table_elbow[0];} ?>"></td>
                <td>腕围：</td>
                <td class="left_input"><input type="text" name="wrist" value="<?php if(@$table_wrist[0] == '0'){echo "";}else{ echo @$table_wrist[0];} ?>"></td>
            </tr>
            <tr>
                <td>袖长：</td>
                <td class="left_input"><input type="text" name="sleeve" value="<?php if(@$table_sleeve[0] == '0'){echo "";}else{ echo @$table_sleeve[0];} ?>"></td>
                <td>后衣长：</td>
                <td class="left_input"><input type="text" name="clothes" value="<?php if(@$table_clothes[0] == '0'){echo "";}else{ echo @$table_clothes[0];} ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td class="submit"><input id="submit_one" type="submit" name="temp" value="暂存" onclick="return beforeSubmit_temp()"></td>
                <td class="submit"><input id="submit_two" type="submit" name="confirm" value="确认提交" onclick="return beforeSubmit_confirm()"></td>
                <td class="submit" style="text-align:center"><a href="volume_self.html">取消</a></td>
            </tr>
        </table>
    </form>
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

for(var i=0; i<<?php echo count($measure_id); ?>; i++) {
  $('#plus_' + i).click( plus(i) );
  $('#minus_' + i).click( minus(i) );
}


</script>
</body>
</html>