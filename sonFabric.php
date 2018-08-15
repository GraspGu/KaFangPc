<?php
require 'inc/conn.php';
$style = htmlspecialchars($_GET['msg']);
if($style=="classic"){
    $style="经典正装";
}else if($style=="office"){
    $style="办公通勤";
}else if($style=="holiday"){
    $style="假日休闲";
}else if($style=="festival"){
    $style="节日宴会";
}else{
    $url = "http://www.ka-fang.cn:8080/shirt.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

//面料图片
$result_1 = "select address,fabric_id from new_fabric_detail_view where style='$style' order by entiry_rank desc";
$rs_1 = mysql_query($result_1);
    while($rows=mysql_fetch_assoc($rs_1)){
    $pic = "<img class='zxx_zoom_image' src = '$rows[address] '/>";
    $array[] = $pic;
    $reel[] = "$rows[address]";
    $fabric_id_rs[] = "$rows[fabric_id]";
}


//根据面料数量获取相关衬衫图片
for($i=0;$i<@count($fabric_id_rs);$i++){
    $select_shirt = "select * from shirt_detail_view where front_body_fabric_id = '$fabric_id_rs[$i]' order by entirety_rank desc";
    $select_shirt_rs = mysql_query($select_shirt);
    while($rows =mysql_fetch_array($select_shirt_rs)){
        $shirt_address[$i][]  = "<img src = '$rows[address]'/>";
        $shirt_address_specific[$i][] = "$rows[shirt_id]";
        $shirt_placket[$i][] = "$rows[placket_style_caption]";
        $shirt_collar[$i][] = "$rows[collar_style_caption]";
}
}


//左侧卷轴面料名字
for($i=0;$i<@count($fabric_id_rs);$i++){
    @$result_reel = "select color_name from new_fabric_detail_view where address = '$reel[$i]'";
    $rs_reel_query = mysql_query($result_reel);
        $rows=mysql_fetch_assoc($rs_reel_query);
        $pic = $rows['color_name'];
        $reel_rs[$i] = $pic;
 }

//页面副标题caption
for($i=0;$i<@count($fabric_id_rs);$i++){
    @$result_cap = "select caption from new_fabric_detail_view where address = '$reel[$i]'";
    $cap_query = mysql_query($result_cap);
        $rows=mysql_fetch_assoc($cap_query);
        $pic = $rows['caption'];
        $cap_rs[$i] = $pic;
}


 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,intial-scale=1,maximum-scale=1,user-scalable=no">
<!-- <title>衬衫子类商城</title> -->
<title><?php echo "$style"; ?>--卡方商城</title>
<link rel="stylesheet" href="css/sonFabric.css">
<style type="text/css">
img{max-width:none;}
.zxx_image_zoom_list{display:inline-block; width:1.2em; height:300px; text-align:center; font-size:128px;}
.zxx_image_zoom_list img.zxx_zoom_image{padding:3px; border:1px solid #cccccc; background:white; vertical-align:middle; position:relative;}
.zxx_image_zoom_div{width:200px; height:200px; padding:3px; background:white; border:1px solid #cccccc; text-align:center; position:absolute; z-index:1000; left:0; top:0; overflow:hidden;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jqzoom.js"></script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function(){
        $("img.zxx_zoom_image").jqueryzoom();
    });
</script>
</head>
<body>
<div id="container">
    <div id="navbar">
        <ul>
            <li><a href="http://www.ka-fang.cn"><img src="images/导航条-首页.png"></a></li>
            <li><a href="online/personal_service.php"><img src="images/导航条-在线版型设计.png"></a></li>
            <li><a href="#"><img src="images/导航条-定制指南-量体规范.png"></a></li>
            <li><a href="#"><img src="images/导航条-微信扫码.png"></a></li>
            <li><a href="weixin/personal.php"><img src="images/导航条-个人中心.png"></a></li>
            <li><a href="weixin/collection.php"><img src="images/导航条-我的收藏.png"></a></li>
            <li><a href="weixin/shopping.php"><img src="images/导航条-购物车.png"></a></li>
            <li><a href="#"><img src="images/导航条-了解卡方.png"></a></li>
        </ul>
    </div>
    <div id="head_line">
        <div><p id="classic"><?php echo "$style"; ?></p><p id="classic_r">Classic suits</p></div>
    </div>
<div id="container">
	<?php for($i=0;$i<@count($fabric_id_rs);$i++) { ?>
	<!-- 检测是否有面料和衬衫 -->
	    <?php if(@$array[$i]!=null&&@$shirt_address[$i][0]!=null) { ?>
	        <div class="body">
	            <div class="body_left"><div class="reel_out"><p class="reel"><?php echo "$reel_rs[$i]"; ?></p></div></div>
	            <ul>
	            <!-- 左侧面料容器 -->
	                <li class="cd">
	                <div>
	                    <a style="cursor:default;" class="zxx_image_zoom_list" href="<?php echo "$reel[$i]"; ?>"><?php echo @"$array[$i]"; ?></a>
	                    <a href="aFabric.php?aFabric_cap=<?php echo @"$cap_rs[$i]"; ?>&f_id=<?php echo "$fabric_id_rs[$i]"; ?>"><p class="body_bottom_cd"><?php echo @"$cap_rs[$i]"; ?></p>
	                    </a>
	                </div>
	                </li>
	                <?php
	                    for($j=0;$j<=3;$j++){
	                        if(@$shirt_address[$i][$j]!=null){
	                    ?>
	                <li><div class="body_right"><a href="specific.php?shirt_address=<?php echo @$shirt_address_specific[$i][$j] ?>"><?php echo @$shirt_address[$i][$j];?></a></div><p class="body_bottom_p"><?php echo @$shirt_placket[$i][$j]; ?>/<?php echo @$shirt_collar[$i][$j]; ?></p>
	                </li>
	                <?php }} ?>
	            </ul>
	        </div>
	    <?php } ?>
	<?php } ?>
</div>
</div>
</body>
</html>
