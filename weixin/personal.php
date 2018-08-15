<?php
//session_start() 函数必须位于 <html> 标签之前
session_start();
@$openid = $_SESSION["openidSession"];
@$sessionname = $_SESSION["nameSession"];
@$unionid = $_SESSION["unionidSession"];
 //注销登录
if(@$_GET['action'] == "logout"){
    unset($_SESSION['openidSession']);
    unset($_SESSION['nameSession']);
    unset($_SESSION['unionidSession']);
    session_destroy();
    $url = "http://www.ka-fang.cn:8080";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    exit;
}

 //检查会话
if(empty($_SESSION["unionidSession"])){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

//链接数据库
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';

//查询数据库用户基本信息
    $sql = "select * from user_basic_info where user_id = '$unionid'";
    $rs = mysql_query($sql);
    $rows=mysql_fetch_assoc($rs);
    $name = $rows["name"];
    $telephone = $rows["telephone"];

$modify_name = $modify_telephone = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modefi_name'])) {
   $modify_name = test_input($_POST["modify_name"]);
   $modify_telephone = test_input($_POST["modify_telephone"]);
}
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

//修改信息
if(@$_GET["action"]=="modify"){
    $sql_modify = "UPDATE user_basic_info SET telephone = '$modify_telephone',name = '$modify_name' WHERE user_id = '$unionid'";
    mysql_query($sql_modify);
    //更新页面数据
    $url = "http://www.ka-fang.cn:8080/weixin/personal.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    }
//添加地址
if(isset($_GET['action'])&& $_GET['action'] == 'add'){
	$add_name = test_input($_POST['add_name']);
	$add_telephone = test_input($_POST['add_telephone']);
	$add_address = test_input($_POST['add_address']);
	$insert_sql = "INSERT into user_address_list(address_id,user_id,address,receive_name,telephone) values(UUID(),'$unionid','$add_address','$add_name','$add_telephone')";
	mysql_query($insert_sql);
}
//检查用户会员等级
$member_level_select = "select level from user_basic_info where user_id = '$unionid'";
$member_level_select_rs = mysql_query($member_level_select);
$member_rows = mysql_fetch_assoc($member_level_select_rs);
$member_level = "$member_rows[level]";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="卡方高级服装定制">
<meta name="keywords" content="">
<link rel="stylesheet" href="../css/personal.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<title>欢迎您！<?php if($name!=null){echo "$name";} else {echo "$sessionname";}?>-卡方商城</title>
</head>
<body>
<div id="container">
    <div id="navbar">
        <ul>
            <li><a href="http://www.ka-fang.cn"><img src="../images/导航条-首页.png"></a></li>
            <li><a href="../online/personal_service.php"><img src="../images/导航条-在线版型设计.png"></a></li>
            <li><a href="#"><img src="../images/导航条-定制指南-量体规范.png"></a></li>
            <li><a href="#"><img src="../images/导航条-微信扫码.png"></a></li>
            <li><a href="personal.php"><img src="../images/导航条-个人中心.png"></a></li>
            <li><a href="collection.php"><img src="../images/导航条-我的收藏.png"></a></li>
            <li><a href="shopping.php"><img src="../images/导航条-购物车.png"></a></li>
            <li><a href="#"><img src="../images/导航条-了解卡方.png"></a></li>
        </ul>
    </div>
    <div id="welcome">
    <h2>欢迎 <label><?php if($name!=null) echo "$name";else echo "$sessionname";?></label> 进入卡方高级服装定制<a href="?action=logout"> 退出</a></h2>
    </div>
    <div id="body">
        <div id="body_left">
            <h3>中心导航</h3>
            <ul>
                <a id="a_personal" href="personal.php"><li class="select">个人信息</li></a>
                <a id="a_address"><li>地址信息</li></a>
                <a id="a_body"><li>量体信息</li></a>
                <a id="a_version"><li>版型信息</li></a>
                <a id="a_modify"><li>修改资料</li></a>
                <a id="a_history"><li>历史订单</li></a>
            </ul>
        </div>
    <div id="body_right">
        <h3>会员管理中心</h3>
                <!-- 用户信息 -->
        <div id="table_wrap">
            <table id="personal_table" border="0" cellpadding="1" cellspacing="0">
                <tr>
                    <td>电话：<?php echo "$rows[telephone]" ?></td>
                </tr>
                <tr>
                    <td>真实姓名：<?php echo "$rows[name]"; ?></td>
                </tr>
                <tr>
                    <td>剩余调版次数：<?php echo "$rows[model_adjust_times]"; ?></td>
                </tr>
                <tr>
                    <td>账户余额：<?php echo "$rows[account]"; ?></td>
                </tr>
                <tr>
                    <td>您的会员等级：
                        <?php switch ($member_level) {
                            case '0': echo "普通用户";
                                break;
                            case '1': echo "普通会员";
                                break;
                            case '2': echo "终身会员";
                                break;
                            default: echo "显示错误，请刷新重试";
                                break;
                        } ?>
                    </td>
                </tr>
            </table>

            <!-- 地址信息 -->
            <?php
                $sql_info = "select * from user_address_list where user_id = '{$unionid}' and is_use = '1'";
                $info_rs = mysql_query($sql_info);
                while($rows=mysql_fetch_assoc($info_rs)) {
                    $pic1 = "$rows[receive_name]";
                    $rows_receive_name[] = $pic1;
                    $pic2 = "$rows[telephone]";
                    $rows_telephone[] = $pic2;
                    $pic3 = "$rows[address]";
                    $rows_address[] = $pic3;

                    //查询地址id
                    $rows_address_id[] = "$rows[address_id]";
                }
                ?>
                <table id="address_table" border="1" cellpadding="1" cellspacing="0">
                    <?php for($i=0;$i<@count($rows_address);$i++){ ?>
                        <tr>
                            <td>收件人：<?php echo @"$rows_receive_name[$i]" ?></td>
                            <td>电话：<?php echo @"$rows_telephone[$i]"; ?></td>
                            <td><a href="delete.php?del_address=<?php echo "$rows_address_id[$i]"; ?>">删除此地址</a></td>
                        </tr>
                        <tr>
                            <td colspan="3">具体地址：<?php echo @"$rows_address[$i]"; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                        </tr>
                    <?php } ?>
                </table>
               <!-- 添加地址-->
			<form id="add_table" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?action=add" method="post">
                <table style="display:none">
                	<tr>
                    	<td colspan="2"><h3>添加地址</h3></td>
                   </tr>
                    <tr>
                        <td>&nbsp;&nbsp;收件人：<input type="text" name="add_name" style="width:200px;height:20px;"></td>
                    </tr>
                    <tr>	
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;电话：<input type="text" name="add_telephone"  style="width:200px;height:20px;"></td>
                    </tr>
                    <tr>
                    	<td>具体地址：<input type="text" name="add_address" style="width:400px;height:20px;"/></td>
                    </tr>
                    <tr>
                        <td id="submit" colspan="2" style="text-align:center"><input type="submit" value="提交"></td>
                    </tr>
                </table>
            </form>
            <!-- 量体信息 -->
            <?php
            //查询量体信息
                $sql_measure = "select * from user_measure_list where user_id = '$unionid' and is_use = '1' order by start_time desc";
                $measure_rs = mysql_query($sql_measure);
                while($rows=mysql_fetch_assoc($measure_rs)) {
                	$rows_caption[] = "$rows[caption]";
                    $rows_neck[] = "$rows[neck]";
                    $rows_arm[] = "$rows[arm]";
                    $rows_chest[] = "$rows[chest]";
                    $rows_waist[] = "$rows[waist]";
                    $rows_hip[] = "$rows[hip]";
                    $rows_wrist[] = "$rows[wrist]";
                    $rows_shoulder[] = "$rows[shoulder]";
                    $rows_clothes[] = "$rows[clothes]";
                    $rows_sleeve[] = "$rows[sleeve]";
                    $rows_shoulder_style[] = "$rows[shoulder_style]";
                    $rows_elbow[] = "$rows[elbow]";
                    $rows_measure_id[] = "$rows[measure_id]";
                }
                ?>
            <div id="body_table">
            <h3>以下数据单位均为厘米</h3>
            <?php for($i=0;$i<@count($rows_measure_id);$i++){ ?>
            <p id="measure_head_<?php echo "$i"; ?>"><?php echo @"$rows_caption[$i]"; ?></p>
            <a href="delete.php?del_measure=<?php echo "$rows_measure_id[$i]"; ?>">删除量体信息</a>
            <table id="measure_table_<?php echo "$i"; ?>" border="1" cellpadding="1" cellspacing="0">
                <tr>
                    <td colspan="2">肩型：<?php if(@$rows_shoulder_style[$i]=='1'){
                            echo "正常肩";
                        }elseif($rows_shoulder_style[$i]=='2'){
                            echo "端肩";
                        }elseif($rows_shoulder_style[$i]=='3'){
                            echo "溜肩";
                        }elseif($rows_shoulder_style[$i]=='4'){
                            echo "高低肩";
                            } ?></td>
                </tr>
                <tr>
                    <td>上领围：<?php echo @$rows_neck[$i]; ?></td>
                    <td>肩宽：<?php echo @$rows_shoulder[$i]; ?></td>
                </tr>
                <tr>
                    <td>胸围：<?php echo @$rows_chest[$i]; ?></td>
                    <td>腰围：<?php echo @$rows_waist[$i]; ?></td>
                </tr>
                <tr>
                    <td>臀围：<?php echo @$rows_hip[$i]; ?></td>
                    <td>上臂围：<?php echo @$rows_arm[$i]; ?></td>
                </tr>
                <tr>
                    <td>肘围：<?php echo @$rows_elbow[$i]; ?></td>
                    <td>腕围：<?php echo @$rows_wrist[$i]; ?></td>
                </tr>
                <tr>
                    <td>袖长：<?php echo @$rows_sleeve[$i]; ?></td>
                    <td>后衣长：<?php echo @$rows_clothes[$i]; ?></td>
                </tr>
            </table>
            <?php } ?>
            </div>
                <!-- 修改个人信息 -->
            <form id="modify_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?action=modify" method="post">
                <table>
                    <tr>
                        <td>电话：</td>
                        <td><input type="text" name="modify_telephone" value="<?php echo $telephone; ?>" style="width:200px;height:20px;"></td>
                    </tr>
                    <tr>
                        <td>真实姓名：</td>
                        <td><input type="text" name="modify_name" value="<?php echo $name; ?>" style="width:200px;height:20px;"></td>
                    </tr>
                    <tr>
                        <td id="submit"><input type="submit" value="提交"></td>
                    </tr>
                </table>
            </form>

            <!-- 历史订单 -->
            <?php
                //获取购物车的衬衫id
                @$history_shirt_address = "select shirt_id from order_list_view where user_id = '$unionid' and finished = '1'";
                $history_shirt_address_rs = mysql_query($history_shirt_address);
                    while($rows=mysql_fetch_assoc($history_shirt_address_rs)){
                    $history_shirt_id[] = "$rows[shirt_id]";
                }

                //获取购物车的衬衫信息
                for($i=0;$i<@count($history_shirt_id);$i++){
                $history_select = "select * from order_list_view where user_id='$unionid' and shirt_id = '$history_shirt_id[$i]' and finished = '1'";
                $history_select_rs = mysql_query($history_select);
                    $rows=mysql_fetch_assoc($history_select_rs);
                    $user_history_address[$i] = "<img src = '../$rows[shirt_iamge_add] '/>";
                    $history_placket[$i] = "$rows[shirt_placket]";
                    $history_collar[$i] = "$rows[shirt_collar]";
                    $history_cuff[$i] = "$rows[shirt_cuff]";
                    //获取价格
                    $history_price[$i] = "$rows[price]";
                    //获取购买时间
                    $history_end_time[$i] = "$rows[end_time]";
                }
             ?>
            <div id="history_div">
                <?php for($i=0;$i<@count($history_shirt_id);$i++){ ?>
                    <ul class="history_inner_ul">
                    <!-- 放置衬衫图片 -->
                        <li><?php echo "$user_history_address[$i]"; ?></li>
                    <!-- 放置衬衫详情信息 -->
                        <li>
                            <h4>衬衫详情</h4>
                            <p><?php echo "$history_placket[$i]"; ?></p>
                            <p><?php echo "$history_collar[$i]"; ?></p>
                            <p><?php echo "$history_cuff[$i]"; ?></p>
                        </li>
                    <!-- 放置购买时间 -->
                        <li>
                            <h4>购买时间</h4>
                            <p><?php echo "$history_end_time[$i]"; ?></p>
                        </li>
                    <!-- 放置衬衫价格信息 -->
                        <li>
                            <h4>衬衫价格</h4>
                            <p><?php echo $history_price[$i]/100; ?>元</p>
                        </li>
                    </ul>
                    <?php } ?>
            </div>

            <!-- 版型信息 -->
            <!-- 获取版型信息 -->
            <?php
                $version_select = "select * from user_current_model_list where user_id = '$unionid' and state = '1' order by produce_time desc";
                $version_select_rs = mysql_query($version_select);
                while ($rows = mysql_fetch_assoc($version_select_rs)) {
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
            <div id="version_div">
            <h3>以下数据单位均为厘米</h3>
                <?php for($i=0;$i<count($view_model_id);$i++){ ?>
                <p id="version_head_<?php echo "$i"; ?>">
                    <img id="plus_<?php echo "$i"; ?>" src="../images/online/plus.png" height="26" width="26" >
                    <img style="display:none" id="minus_<?php echo "$i"; ?>" src="../images/online/minus.png" height="26" width="26">
                    <label><?php echo @"$view_caption[$i]"; ?></label>
                </p>
                <a style="float: right;margin-top: -40px;" href="delete.php?del_model=<?php echo "$view_model_id[$i]"; ?>">删除量体信息</a>
                <table id="version_table_<?php echo "$i"; ?>" border="1" cellpadding="1" cellspacing="0">
                    <tr>
                        <td>标题：<?php echo @"$view_caption[$i]"; ?></td>
                        <td>肩型：<?php if(@$view_shoulder_style[$i] == 1) {
                        	echo "正常肩";
                        }elseif(@$view_shoulder_style[$i] == 2){
                        	echo "端肩";
                        }elseif(@$view_shoulder_style[$i] == 3){
                        	echo "溜肩";
                        }elseif(@$view_shoulder_style[$i] == 4){
                        	echo '高低肩';
                        }?>
                        </td>
                    </tr>
                    <tr>
                        <td>上领围：<?php echo @"$view_neck_girth[$i]"; ?></td>
                        <td>肩宽：<?php echo @"$view_shoulder_width[$i]"; ?></td>
                    </tr>
                    <tr>
                        <td>胸围：<?php echo @"$view_chest_girth[$i]"; ?></td>
                        <td>腰围：<?php echo @"$view_waist_girth[$i]"; ?></td>
                    </tr>
                    <tr>
                        <td>下摆围：<?php echo @"$view_sweep_girth[$i]"; ?></td>
                        <td>袖肥：<?php echo @"$view_sleeve_width[$i]"; ?></td>
                    </tr>
                    <tr>
                        <td>肘围：<?php echo @"$view_elbow_girth[$i]"; ?></td>
                        <td>袖口围：<?php echo @"$view_wrist_girth[$i]"; ?></td>
                    </tr>
                    <tr>
                        <td>袖长：<?php echo @"$view_sleeve_length[$i]"; ?></td>
                        <td>后衣长：<?php echo @"$view_clothes_length[$i]"; ?></td>
                    </tr>
                </table>
                <?php } ?>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
$("#a_address").click(function(){
	$("#add_table").children('table').show();
    $("#address_table").show();
    $("#a_address").find("li").addClass('select');
    $("#personal_table").hide();
    $("#body_table").hide();
    $("#modify_form").hide();
    $("#history_div").hide();
    $("#version_div").hide();
    $("#a_personal").find("li").removeClass('select');
    $("#a_body").find("li").removeClass('select');
    $("#a_modify").find("li").removeClass('select');
    $("#a_history").find("li").removeClass('select');
    $("#a_version").find("li").removeClass('select');
});
$("#a_body").click(function(){
    $("#body_table").show();
    $("#a_body").find("li").addClass('select');
    $("#personal_table").hide();
    $("#address_table").hide();
    $("#modify_form").hide();
    $("#history_div").hide();
    $("#version_div").hide();
    $("#add_table").children('table').hide();
    $("#a_address").find("li").removeClass('select');
    $("#a_personal").find("li").removeClass('select');
    $("#a_modify").find("li").removeClass('select');
    $("#a_history").find("li").removeClass('select');
    $("#a_version").find("li").removeClass('select');
});
$("#a_modify").click(function(){
    $("#modify_form").show();
    $("#a_modify").find("li").addClass('select');
    $("#personal_table").hide();
    $("#body_table").hide();
    $("#address_table").hide();
    $("#history_div").hide();
    $("#version_div").hide();
    $("#add_table").children('table').hide();
    $("#a_body").find("li").removeClass('select');
    $("#a_address").find("li").removeClass('select');
    $("#a_personal").find("li").removeClass('select');
    $("#a_history").find("li").removeClass('select');
    $("#a_version").find("li").removeClass('select');
});
$("#a_history").click(function(){
    $("#history_div").show();
    $("#a_history").find("li").addClass('select');
    $("#personal_table").hide();
    $("#body_table").hide();
    $("#address_table").hide();
    $("#modify_form").hide();
    $("#version_div").hide();
    $("#add_table").children('table').hide();
    $("#a_body").find("li").removeClass('select');
    $("#a_address").find("li").removeClass('select');
    $("#a_personal").find("li").removeClass('select');
    $("#a_modify").find("li").removeClass('select');
    $("#a_version").find("li").removeClass('select');
});
$("#a_version").click(function(){
    $("#version_div").show();
    $("#a_version").find("li").addClass('select');
    $("#personal_table").hide();
    $("#body_table").hide();
    $("#address_table").hide();
    $("#modify_form").hide();
    $("#history_div").hide();
    $("#add_table").children('table').hide();
    $("#a_body").find("li").removeClass('select');
    $("#a_address").find("li").removeClass('select');
    $("#a_personal").find("li").removeClass('select');
    $("#a_modify").find("li").removeClass('select');
    $("#a_history").find("li").removeClass('select');
});

// 这里是一个闭包运算。需要学习理解。
var measure = function(i) {
  // 这儿出现了一个新的scope
  return function(){
    $("#measure_table_"+i).fadeToggle();
  };
};
for(var i=0; i<<?php echo count($rows_measure_id); ?>; i++) {
  $('#measure_head_' + i).click( measure(i) );
}

// 这里是一个闭包运算。需要学习理解。
var plus = function(i) {
  // 这儿出现了一个新的scope
  return function(){
    $("#version_table_"+i).fadeToggle();
    $("#plus_"+i).hide();
    $("#minus_"+i).show();
  };
};
var minus = function(i) {
  // 这儿出现了一个新的scope
  return function(){
    $("#version_table_"+i).fadeToggle();
    $("#minus_"+i).hide();
    $("#plus_"+i).show();
  };
};

for(var i=0; i<<?php echo count($view_model_id); ?>; i++) {
  $('#plus_' + i).click( plus(i) );
  $('#minus_' + i).click( minus(i) );
}
</script>
</body>
</html>