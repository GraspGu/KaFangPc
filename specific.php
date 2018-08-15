<?php
require 'inc/conn.php';
session_start();
@$unionid = $_SESSION["unionidSession"];
//得到传过来的衬衫id，通过id找到衬衫
if(isset($_GET['shirt_address'])){
    $get_shirt = htmlspecialchars($_GET['shirt_address']);
}else{
    $url = "http://www.ka-fang.cn:8080/shirt.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

    //衬衫全景照
    $result_1 = "select * from shirt_detail_view where shirt_id='$get_shirt'";
    $rs_1 = mysql_query($result_1);
        while($rows=mysql_fetch_assoc($rs_1)) {
        //衬衫id
        $shirt_id[] = "$rows[shirt_id]";
        //衬衫正面照
        $array_1[] = "<img class='zxx_zoom_shirt' src = '$rows[photo_1_add] '/>";
        $array_1_rs[] = "$rows[photo_1_add]";
        //侧面照
        $array_2[]= "<img class='zxx_zoom_shirt' src = '$rows[photo_2_add] '/>";
        $array_2_rs[] = "$rows[photo_2_add]";
        //背后照
        $array_3[] = "<img class='zxx_zoom_shirt' src = '$rows[photo_3_add] '/>";
        $array_3_rs[] = "$rows[photo_3_add]";

        $array_4[] = "<img class='zxx_zoom_shirt' src = '$rows[photo_4_add] '/>";
        $array_4_rs[] = "$rows[photo_4_add]";

        //衬衫详情信息
        $array_model[] = "$rows[model_style_caption]";
        $array_cuff[] = "$rows[cuff_style_caption]";
        $array_placket[] = "$rows[placket_style_caption]";
        $array_collar[] = "$rows[collar_style_caption]";
        $array_front[] = "$rows[front_body_fabric_id]";
        $array_price[] = "$rows[price]";
        $price_2[] = "$rows[price_2]";
        $price_3[] = "$rows[price_3]";
    }


    //面料详情
    $fabric_select = "select * from new_fabric_detail_view where fabric_id = '$array_front[0]'";
    $fabric_select_rs = mysql_query($fabric_select);
    while($rows = mysql_fetch_assoc($fabric_select_rs)){
        //地址
        $fabric_address[] = "<img class='zxx_zoom_image' src = '$rows[address] '/>";
        $fabric_address_specific[] = "$rows[address]";
        //克重
        $fabric_grammage[] = "$rows[grammage]";
        //成分参数
        $fabric_ingredient_para[] = "$rows[ingredient_para]";
        //颜色名称
        $fabric_color_name[] = "$rows[color_name]";
    }

    //获取会员等级
    $member_level_select = "select level from user_basic_info where user_id = '$unionid'";
    $member_level_select_rs = mysql_query($member_level_select);
    $member_rows = mysql_fetch_assoc($member_level_select_rs);
    $member_level = "$member_rows[level]";

 ?>
 <!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,intial-scale=1,maximum-scale=1,user-scalable=no">
<title>衬衫详情--卡方商城</title>
<link rel="stylesheet" href="css/specific.css">
<style type="text/css">
img{max-width:none;}
.zxx_image_zoom_list{display:inline-block; text-align:center; font-size:128px;}
.zxx_image_zoom_list img.zxx_zoom_image{padding:3px; border:1px solid #cccccc; background:white; vertical-align:middle; position:relative;}

.zxx_image_zoom_div{width:200px; height:200px; padding:3px; background:white; border:1px solid #cccccc; text-align:center; position:absolute; z-index:1000; left:0; top:0; overflow:hidden;}

.zxx_image_zoom_shirt{display:inline-block; text-align:center; font-size:128px;}
.zxx_image_zoom_shirt img.zxx_zoom_shirt{padding:3px; border:1px solid #cccccc; background:white; vertical-align:middle; position:relative;height:350px;margin-right: 10px;margin-bottom: 10px;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jqzoom.js"></script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function(){
        $("img.zxx_zoom_image").jqueryzoom();
        $("img.zxx_zoom_shirt").jqueryzoom();
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
                <li><a href="weixin/collection.php"><img src="images/导航条-购物车.png"></a></li>
                <li><a href="#"><img src="images/导航条-了解卡方.png"></a></li>
            </ul>
    </div>
    <div id="body_left_head" >
        <img id="body_left_logo" src="images/具体衬衫详情页/标题.png" height="90" width="300">

        <a style="cursor:default;" class="zxx_image_zoom_shirt" href="<?php echo "$array_1_rs[0]"; ?>"><?php echo @"$array_1[0]"; ?></a>

        <?php   $str = "$array_2_rs[0]";
                $var = trim($str);
                $len = strlen($var)-1;
                if($var{$len}=="g"){?>
        <a style="cursor:default;" class="zxx_image_zoom_shirt" href="<?php echo "$array_2_rs[0]"; ?>"><?php echo @"$array_2[0]"; ?></a>
        <?php } ?>

        <?php   $str = "$array_3_rs[0]";
                $var = trim($str);
                $len = strlen($var)-1;
                if($var{$len}=="g"){?>
        <a style="cursor:default;" class="zxx_image_zoom_shirt" href="<?php echo "$array_3_rs[0]"; ?>"><?php echo @"$array_3[0]"; ?></a>
        <?php } ?>

        <?php   $str = "$array_4_rs[0]";
                $var = trim($str);
                $len = strlen($var)-1;
                if($var{$len}=="g") {?>
        <a style="cursor:default;" class="zxx_image_zoom_shirt" href="<?php echo "$array_4_rs[0]"; ?>"><?php echo @"$array_4[0]"; ?></a>
        <?php } ?>

    </div>
    <div id="body_specific">
        <div id="body_specific_head">
            <p>Design view</p>
        </div>
        <div id="fabric">
            <a style="cursor:default;" class="zxx_image_zoom_list" href="<?php echo "$fabric_address_specific[0]"; ?>"><?php echo "$fabric_address[0]"; ?></a>
        </div>
        <table class="bigimg_table">
            <th colspan="4"><p id="bigimg_one_xq_head"><b>衬衫具体描述</b></p></th>
            <tr>
                <td class="td_left">款式：<?php echo "$array_model[0]";?></td>
                <td class="td_left">面料编号：<?php echo "$array_front[0]";?></td>
            </tr>
            <tr>
                <td class="td_left">袖口：<?php echo "$array_cuff[0]";?></td>
                <td class="td_left">面料颜色：<?php echo "$fabric_color_name[0]";?></td>
            </tr>
            <tr>
                <td class="td_left">领型：<?php echo "$array_collar[0]";?></td>
                <td class="td_left">面料克重：<?php echo "$fabric_grammage[0]";?></td>
            </tr>
            <tr>
                <td class="td_left">门襟：<?php echo "$array_placket[0]";?></td>
                <td class="td_left">面料成分：<?php echo "$fabric_ingredient_para[0]";?></td>
            </tr>
            <tr>
                <td id="price" colspan="2" class="td_middle">正常价格：<?php echo $array_price[0]/100;?>元</td>
            </tr>
            <tr>
                <td id="price_2" colspan="2" class="td_middle">一般会员价：<?php echo $price_2[0]/100;?>元</td>
            </tr>
            <tr>
                <td id="price_3" colspan="2" class="td_middle">终身会员价：<?php echo $price_3[0]/100;?>元</td>
            </tr>
            <tr>
                <td colspan="2" class="td_middle"><a href="weixin/collection_handle.php?id=<?php echo "$shirt_id[0]"; ?>"><img src="images/具体衬衫详情页/收藏按钮.png" width="250" height="50px"></a></td>
            </tr>
            <tr>
                <td colspan="2" class="td_middle"><a href="weixin/shopping_version.php?id=<?php echo "$shirt_id[0]"; ?>"><img src="images/具体衬衫详情页/加入购物车按钮.png" width="250" height="50px"></a></td>
            </tr>
            <tr>
                <td>扫码登录公众号商城：</td>
                <td><img src="images/具体衬衫详情页/公众号商城二维码.png" height="100" width="100" ></td>
            </tr>
        </table>
    </div>
</div>
<?php if($member_level=="0"){ ?>
<script>
$("#price").css({
    color: '#f40'
});
</script>
<?php } ?>
<?php if($member_level=="1"){ ?>
<script>
$("#price_2").css({
    color: '#f40'
});
</script>
<?php } ?>
<?php if($member_level=="2"){ ?>
<script>
$("#price_3").css({
    color: '#f40'
});
</script>
<?php } ?>
</body>
</html>