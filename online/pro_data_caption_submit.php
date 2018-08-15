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
    <p style="text-align:center;">请选择您要提交的版型数据</p>
</div>
<!-- 可选数据列表 -->
<div id="measure_table">
    <?php for($i=0;$i<count($view_model_id);$i++){ ?>
    <h3 id="measure_head_<?php echo "$i"; ?>">
        <img id="plus_<?php echo "$i"; ?>" src="../images/online/plus.png" height="26" width="26">
        <img style="display:none" id="minus_<?php echo "$i"; ?>" src="../images/online/minus.png" height="26" width="26">
        <label><?php echo @"$view_caption[$i]"; ?></label>
        <a href="pro_data_img_submit.php?m_id=<?php echo "$view_model_id[$i]"; ?>">确定</a>
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
<div class="button">
    <a href="professional_design.html">
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
</script>
</body>
</html>