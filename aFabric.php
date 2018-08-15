<?php
require 'inc/conn.php';
header("Content-type:text/html;charset=utf-8");
if(isset($_GET['aFabric_cap'])&&isset($_GET['f_id'])){
    $aFabric_cap = htmlspecialchars($_GET['aFabric_cap']);
    $fabric_id = htmlspecialchars($_GET['f_id']);
}else{
    $url = "http://www.ka-fang.cn:8080/sonFabric.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

//根据传来的面料id获取面料信息
$fabric_address_select= "select * from new_fabric_detail_view where fabric_id = '$fabric_id'";
$fabric_address_select_rs = mysql_query($fabric_address_select);
while($rows=mysql_fetch_assoc($fabric_address_select_rs)){
    //地址
    $fabric_address_specific[] = $rows["address"];
    $fabric_address[] = "<img class='zxx_zoom_image' src = '$rows[address] '/>";
    //编号
    $fabric_caption[] = $rows["caption"];
    //工艺
    $fabric_tech[] = $rows["tech"];
    //克重
    $fabric_grammage[] = $rows["grammage"];
    //成分
    $fabric_ingredient[] = $rows["ingredient"];
    //成分参数
    $fabric_ingredient_para[] = $rows["ingredient_para"];
    //颜色
    $fabric_color_name[] = $rows["color_name"];
}


//获取法式门襟衬衫地址
    $result_fa = "select * from shirt_detail_view where placket_style_caption='法式门襟' and front_body_fabric_id = '$fabric_id'";
    $rs_fa = mysql_query($result_fa);
        while($rows=mysql_fetch_assoc($rs_fa)) {
        $array_fa[] = "<img src = '$rows[address] '/>";
        $fa_address[] = "$rows[shirt_id]";
    }
//获取法式门襟衬衫信息
for($i=0;$i<count(@$array_fa);$i++){
    $fa_shirt_xq = "select placket_style_caption,collar_style_caption from shirt_detail_view where placket_style_caption='法式门襟' and front_body_fabric_id = '$fabric_id' and shirt_id = '$fa_address[$i]'";
    $fa_shirt_xq_rs = mysql_query($fa_shirt_xq);
    $rows=mysql_fetch_assoc($fa_shirt_xq_rs);
        $fa_shirt_placket[] = "$rows[placket_style_caption]";
        $fa_shirt_collar[] = "$rows[collar_style_caption]";
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,intial-scale=1,maximum-scale=1,user-scalable=no">
<!-- <title>某一面料衬衫详情页</title> -->
<title><?php echo @"$aFabric_cap";?>款式一览--卡方商城</title>
<link rel="stylesheet" href="css/aFabric.css">
<style type="text/css">
img{max-width:none;}
.zxx_image_zoom_list{display:inline-block; width:1.2em; height:1.1em; text-align:center; font-size:128px;}
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
    <div id="head_bottom">
    <div>
        <p id="classic"><?php echo @"$aFabric_cap";?>款式一览</p>
        <p id="classic_b">Design view</p>
        <p id="classic_r">
            <a style="cursor:default;" href="<?php echo "$fabric_address_specific[0]"; ?>" class="zxx_image_zoom_list"><?php echo "$fabric_address[0]"; ?>
            </a>
        </p>
        <div id="classic_ul">
            <h3>面料参数详情</h3>
            <ul>
                <li><p>编号：<?php echo "$fabric_caption[0]"; ?></p></li>
                <li><p>工艺：<?php echo "$fabric_tech[0]"; ?></p></li>
                <li><p>克重：<?php echo "$fabric_grammage[0]"; ?></p></li>

            </ul>
            <ul>
                <li><p>成分参数:<?php echo "$fabric_ingredient_para[0]"; ?></p></li>
                <li><p>颜色：<?php echo "$fabric_color_name[0]"; ?></p></li>
                <li><p>成分：<?php echo "$fabric_ingredient[0]"; ?></p></li>
            </ul>
            <ul>
                <li><a id="fabric_coll" href="weixin/collection_handle.php?f_id=<?php echo "$fabric_id"; ?>">点击收藏面料</a></li>
            </ul>
        </div>
    </div>
    </div>
    <div id="body">
        <img class="slide" src="images/某一面料衬衫详情页/法式分割线.png" height="95" width="1326" alt="">
        <ul>
        <?php for($i=0;$i<count(@$array_fa);$i++){ ?>
            <li>
                <div class="fabric_con"><a href="specific.php?shirt_address=<?php echo "$fa_address[$i]"; ?>"><?php echo @"$array_fa[$i]"; ?></a>
                </div>
                <p><?php echo @"$fa_shirt_placket[$i]"; ?>/<?php echo @"$fa_shirt_collar[$i]"; ?></p>
                <div class="button_in">
                    <a href="specific.php?shirt_address=<?php echo "$fa_address[$i]"; ?>"><img src="images/某一面料衬衫详情页/查看详情.png"></a>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
</div>
</body>
</html>