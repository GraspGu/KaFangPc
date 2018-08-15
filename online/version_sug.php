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


//查询两张照片是否全部上传，删除垃圾数据
$delete_sql = "delete from user_shirt_opinion_list where (front_photo is null or side_photo is null) and user_id = '$unionid'";
mysql_query($delete_sql);

//数据来自user_shirt_opinion_list中view_flag=”0”且staff_id非空的记录，显示producer_time，前面加单选钮。
$opinion_list_select = "select * from user_shirt_opinion_list where user_id = '$unionid' and view_flag = '0' and staff_id is not null order by produce_time desc";
$opinion_list_select_rs = mysql_query($opinion_list_select);
while ($rows = mysql_fetch_assoc($opinion_list_select_rs)) {
    $view_shirt_opinion_id[] = "$rows[shirt_opinion_id]";
    $view_produce_time[] = "$rows[produce_time]";
}
//如果数据库并无数据
if (@count($view_shirt_opinion_id) == '0') {
    echo "<script>alert('还没有需要确认的版型数据，请到数据提交区提交您的数据。')</script>";
    $url = "http://www.ka-fang.cn:8080/online/dress_design.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    exit;
}

//用户点击查看建议，将view_flag置1
if (isset($_GET['o_id']) && $_GET['o_id'] != null) {
    $opinion_id = $_GET['o_id'];
    //根据获取的opinion_id获取数据，将view_flag置1。目前数据库无建议数据，直接在网页显示。
    $opinion_get = "select * from user_shirt_opinion_list where user_id = '$unionid' and shirt_opinion_id = '$opinion_id'";
	$opinion_get_rs = mysql_query($opinion_get);
	while($rows = mysql_fetch_assoc($opinion_get_rs)){
		$designer_shirt_opinion_id[] = "$rows[shirt_opinion_id]";
	    $designer_produce_time[] = "$rows[produce_time]";
	    $designer_neck_girth[] = "$rows[neck_girth]";//上领围
	    $designer_shoulder_width[] = "$rows[shoulder_width]";//肩宽、
	    $designer_chest_girth[] = "$rows[chest_girth]";//胸围
	    $designer_waist_girth[] = "$rows[waist_girth]";//腰围
	    $designer_sweep_girth[] = "$rows[sweep_girth]";//下摆围
	    $designer_sleeve_width[] = "$rows[sleeve_width]";//袖肥
	    $designer_elbow_girth[] = $rows['elbow_girth'];//肘围
	    $designer_wrist_girth[] = $rows['wrist_girth'];//袖口围
	    $designer_sleeve_length[] = "$rows[sleeve_length]";//袖长
	    $designer_clothes_length[] = "$rows[clothes_length]";//后衣长
	}
	//将view_flag置1
	$data_update = "update user_shirt_opinion_list set view_flag = '1' where user_id = '$unionid' and shirt_opinion_id = '$opinion_id'";
	mysql_query($data_update);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>版型建议</title>
<link rel="stylesheet" href="../css/online_index.css">
<link rel="stylesheet" href="../css/manual_input_volume.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<style>
	.left{
		width: 100px;
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
    <p>您可以在版型建议列表中选择您要看的版型建议，点击查看具体建议后可以看版师的具体细节，谢谢。</p>
</div>
<!-- 版型建议列表 -->
<div id="measure_table">
    <?php for($i=0;$i<count(@$view_shirt_opinion_id);$i++){ ?>
    <h3 id="measure_head_<?php echo "$i"; ?>">
        <label><?php echo @"$view_produce_time[$i]"; ?></label>
        <a href="?o_id=<?php echo "$view_shirt_opinion_id[$i]"; ?>">查看具体建议</a>
    </h3>
    <?php } ?>
</div>
<!-- 版师具体建议区 -->
<?php if(isset($_GET['o_id']) && $_GET['o_id'] != null) { ?>
<div id="manual_input">
    <h3>版师具体建议</h3>
    <form name="form" style="width: 300px;">
        <table>
            <tr>
                <td>上领围：</td>
                <td class="left_input"><p><?php echo @$designer_neck_girth[0]; ?></p></td>
                <td>肩宽：</td>
                <td class="left_input"><p><?php echo @$designer_shoulder_width[0];?></p></td>
            </tr>
            <tr>
                <td>胸围：</td>
                <td class="left_input"><p><?php echo @$designer_chest_girth[0]; ?></p></td>
                <td>腰围：</td>
                <td class="left_input"><p><?php echo @$designer_waist_girth[0]; ?></p></td>
            </tr>
            <tr>
                <td>下摆围：</td>
                <td class="left_input"><p><?php echo @$designer_sweep_girth[0]; ?></p></td>
                <td>袖肥：</td>
                <td class="left_input"><p><?php echo @$designer_sleeve_width[0]; ?></p></td>
            </tr>
            <tr>
                <td>肘围：</td>
                <td class="left_input"><p><?php echo @$designer_elbow_girth[0]; ?></p></td>
                <td>袖口围：</td>
                <td class="left_input"><p><?php echo @$designer_wrist_girth[0]; ?></p></td>
            </tr>
            <tr>
                <td>袖长：</td>
                <td class="left_input"><p><?php echo @$designer_sleeve_length[0]; ?></p></td>
                <td>后衣长：</td>
                <td class="left_input"><p><?php echo @$designer_clothes_length[0]; ?></p></td>
            </tr>
        </table>
    </form>
</div>
<?php } ?>
<!-- 返回首页 -->
<a href="personal_service.php">
    <div class="button">
        <p>返回首页</p>
    </div>
</a>
<script>

</script>
</body>
</html>
