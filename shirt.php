<!--
这是主页大图点击后跳转的页面
-->
<?php
require 'inc/conn.php';
//经典正装
    $shirt_1_sql = "select * from shirt_detail_view where front_body_fabric_style_id=01 group by front_body_fabric_id having max(entirety_rank) order by entirety_rank desc";
    $rs_1 = mysql_query($shirt_1_sql);
    while($rows=mysql_fetch_assoc($rs_1)) {
	    $shirt_1[] = "<img src = '$rows[address] '/>";
	    $shirt1_address[] = "$rows[shirt_id]";
    }
//查询经典正装领型
for($i=0;$i<count(@$shirt1_address);$i++){
    $shirt_1_collar_select = "select collar_style_caption from shirt_detail_view where shirt_id = '$shirt1_address[$i]'";
    $shirt_1_collar_select_rs = mysql_query($shirt_1_collar_select);
    $rows = mysql_fetch_assoc($shirt_1_collar_select_rs);
    $shirt_1_collar[] = "$rows[collar_style_caption]";
}


//办公通勤
    $shirt_2_sql = "select * from shirt_detail_view where front_body_fabric_style_id=02 group by front_body_fabric_id having max(entirety_rank) order by entirety_rank desc";
    $rs_2 = mysql_query($shirt_2_sql);
    while($rows=mysql_fetch_assoc($rs_2)) {
	    $shirt_2[] = "<img src = '$rows[address] '/>";
	    $shirt2_address[] = "$rows[shirt_id]";
    }
//查询办公通勤领型
for($i=0;$i<@count($shirt2_address);$i++){
    @$shirt_2_collar_select = "select collar_style_caption from shirt_detail_view where shirt_id = '$shirt2_address[$i]'";
    $shirt_2_collar_select_rs = mysql_query($shirt_2_collar_select);
    $rows = mysql_fetch_assoc($shirt_2_collar_select_rs);
    $shirt_2_collar[] = "$rows[collar_style_caption]";
}


//假日休闲
    $shirt_3_sql = "select * from shirt_detail_view where front_body_fabric_style_id=04 group by front_body_fabric_id having max(entirety_rank) order by entirety_rank desc";
    $rs_3 = mysql_query($shirt_3_sql);
    while($rows=mysql_fetch_assoc($rs_3)) {
	    $shirt_3[] = "<img src = '$rows[address] '/>";
	    $shirt3_address[] = "$rows[shirt_id]";
    }
//查询假日休闲领型
for($i=0;$i<@count($shirt3_address);$i++){
    @$shirt_3_collar_select = "select collar_style_caption from shirt_detail_view where shirt_id = '$shirt3_address[$i]'";
    $shirt_3_collar_select_rs = mysql_query($shirt_3_collar_select);
    $rows = mysql_fetch_assoc($shirt_3_collar_select_rs);
    $shirt_3_collar[] = "$rows[collar_style_caption]";
}


//节日庆典
    $shirt_4_sql = "select * from shirt_detail_view where front_body_fabric_style_id=08 group by front_body_fabric_id having max(entirety_rank) order by entirety_rank desc";
    $rs_4 = mysql_query($shirt_4_sql);
    while($rows=mysql_fetch_assoc($rs_4)) {
	    $shirt_4[] = "<img src = '$rows[address] '/>";
	    $shirt4_address[] = "$rows[shirt_id]";
    }
//查询节日庆典领型
for($i=0;$i<@count($shirt4_address);$i++){
    @$shirt_4_collar_select = "select collar_style_caption from shirt_detail_view where shirt_id = '$shirt2_address[$i]'";
    $shirt_4_collar_select_rs = mysql_query($shirt_4_collar_select);
    $rows = mysql_fetch_assoc($shirt_4_collar_select_rs);
    $shirt_4_collar[] = "$rows[collar_style_caption]";
}

//左边流行风尚标签
    $sm_sql = "select * from shirt_current_new_product_view";
    $rs = mysql_query($sm_sql);
        while($rows=mysql_fetch_assoc($rs)) {
        $sm[]= "<img src = '$rows[address] '/>";
        $sm_address[] = "$rows[shirt_id]";
    }
//查询流行风尚领型
for($i=0;$i<@count($sm_address);$i++){
    @$sm_collar_select = "select collar_style_caption from shirt_detail_view where shirt_id = '$sm_address[$i]'";
    $sm_select_rs = mysql_query($sm_collar_select);
    $rows = mysql_fetch_assoc($sm_select_rs);
    $sm_collar[] = "$rows[collar_style_caption]";
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,intial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="stylesheet" href="css/shirt.css">
<script src="js/jquery-1.8.2.min.js"></script>
<title>衬衫专栏--卡方商城</title>
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
<div id="body_left">
<img class="body_left_head" src="images/白色衬衫详情页/流行风尚标签.png" height="116" width="400">
<div class="body_left">
    <div class="banner_group_1">
        <ul class="banner_1">
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[2]"; ?>"><?php echo @"$sm[2]"; ?></a><p><?php echo "$sm_collar[2]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[0]"; ?>"><?php echo @"$sm[0]"; ?></a><p><?php echo "$sm_collar[0]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[1]"; ?>"><?php echo @"$sm[1]"; ?></a><p><?php echo "$sm_collar[1]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[2]"; ?>"><?php echo @"$sm[2]"; ?></a><p><?php echo "$sm_collar[2]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[0]"; ?>"><?php echo @"$sm[0]"; ?></a><p><?php echo "$sm_collar[0]"; ?></p></div></li>
        </ul>
    </div>
</div>
<div class="body_left">
    <div class="banner_group_1">
        <ul class="banner_1">
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[5]"; ?>"><?php echo @"$sm[5]"; ?></a><p><?php echo "$sm_collar[0]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[3]"; ?>"><?php echo @"$sm[3]"; ?></a><p><?php echo "$sm_collar[0]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[4]"; ?>"><?php echo @"$sm[4]"; ?></a><p><?php echo "$sm_collar[4]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[5]"; ?>"><?php echo @"$sm[5]"; ?></a><p><?php echo "$sm_collar[5]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[3]"; ?>"><?php echo @"$sm[3]"; ?></a><p><?php echo "$sm_collar[3]"; ?></p></div></li>
        </ul>
    </div>
</div>
<div class="body_left">
    <div class="banner_group_1">
        <ul class="banner_1">
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[8]"; ?>"><?php echo @"$sm[8]"; ?></a><p><?php echo "$sm_collar[8]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[6]"; ?>"><?php echo @"$sm[6]"; ?></a><p><?php echo "$sm_collar[6]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[7]"; ?>"><?php echo @"$sm[7]"; ?></a><p><?php echo "$sm_collar[7]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[8]"; ?>"><?php echo @"$sm[8]"; ?></a><p><?php echo "$sm_collar[8]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[6]"; ?>"><?php echo @"$sm[6]"; ?></a><p><?php echo "$sm_collar[6]"; ?></p></div></li>
        </ul>
    </div>
</div>
<div class="body_left">
    <div class="banner_group_1">
        <ul class="banner_1">
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[8]"; ?>"><?php echo @"$sm[8]"; ?></a><p><?php echo "$sm_collar[8]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[8]"; ?>"><?php echo @"$sm[8]"; ?></a><p><?php echo "$sm_collar[8]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[8]"; ?>"><?php echo @"$sm[8]"; ?></a><p><?php echo "$sm_collar[8]"; ?></p></div></li>
            <li class="li"><div class="left_img"><a href="specific.php?shirt_address=<?php echo "$sm_address[8]"; ?>"><?php echo @"$sm[9]"; ?></a><p><?php echo "$sm_collar[8]"; ?></p></div></li>
        </ul>
    </div>
</div>
</div>
<div id="body_right">
    <div id="body_right_head">
        <img src="images/白色衬衫详情页/卡方商城页-2.png">
        <p>卡方衬衫定制商城</p>
    </div>

    <img class="td_slide" src="images/白色衬衫详情页/经典分割线.png" height="75" width="950">
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td class="label"><a href="sonFabric.php?msg=classic"><img src="images/白色衬衫详情页/经典标签.png" height="253" width="175">
            <img src="images/白色衬衫详情页/进入提示图标-2.png" height="40" width="175"></a></td>
            <td>
                <div class="table_1_wrap">
                    <div id="table_1">
                        <?php for($i=0;$i<count(@$shirt1_address);$i++){ ?>
                            <div class="table_1_inner">
                                <a href="specific.php?shirt_address=<?php echo "$shirt1_address[$i]" ?>"><?php echo @"$shirt_1[$i]"; ?></a>
                                <p><?php echo "$shirt_1_collar[$i]"; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <img class="td_slide" src="images/白色衬衫详情页/办公分割线.png" height="75" width="950">
    <table>
        <tr>
            <td class="label"><a href="sonFabric.php?msg=office"><img src="images/白色衬衫详情页/办公标签.png" height="253" width="175">
            <img src="images/白色衬衫详情页/进入提示图标-2.png" height="40" width="175"></a></td>
            <td>
                <div class="table_1_wrap">
                    <div id="table_2">
                        <?php for($i=0;$i<@count($shirt2_address);$i++){ ?>
                            <div class="table_1_inner">
                                <a href="specific.php?shirt_address=<?php echo "$shirt2_address[$i]" ?>"><?php echo @"$shirt_2[$i]"; ?></a>
                                <p><?php echo "$shirt_2_collar[$i]"; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <img class="td_slide" src="images/白色衬衫详情页/假日分割线.png" height="69" width="950">
    <table>
        <tr>
            <td class="label"><a href="sonFabric.php?msg=holiday"><img src="images/白色衬衫详情页/假日标签.png" height="253" width="175">
            <img src="images/白色衬衫详情页/进入提示图标-2.png" height="40" width="175"></a></td>
            <td>
                <div class="table_1_wrap">
                    <div id="table_3">
                        <?php for($i=0;$i<@count($shirt3_address);$i++){ ?>
                            <div class="table_1_inner">
                                <a href="specific.php?shirt_address=<?php echo "$shirt3_address[$i]" ?>"><?php echo @"$shirt_3[$i]"; ?></a>
                                <p><?php echo "$shirt_3_collar[$i]"; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <img class="td_slide" src="images/白色衬衫详情页/节日分割线.png" height="75" width="950">
    <table>
        <tr>
            <td class="label"><a href="sonFabric.php?msg=festival"><img src="images/白色衬衫详情页/节日标签.png" height="253" width="175">
            <img src="images/白色衬衫详情页/进入提示图标-2.png" height="40" width="175"></a></td>
            <td>
                <div class="table_1_wrap">
                    <div id="table_4">
                        <?php for($i=0;$i<@count($shirt4_address);$i++){ ?>
                            <div class="table_1_inner">
                                <a href="specific.php?shirt_address=<?php echo "$shirt4_address[$i]" ?>"><?php echo @"$shirt_4[$i]"; ?></a>
                                <p><?php echo "$shirt_4_collar[$i]"; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</div>

</div>
<script src="js/shirt_left_one.js"></script>
<script>
    //控制内部容器的宽度
            $("#table_1").css({
                width: ($(".table_1_inner").width()+48) * <?php echo count(@$shirt1_address); ?>+"px",
            });
            $("#table_2").css({
                width: ($(".table_1_inner").width()+48) * <?php echo @count($shirt2_address); ?>+"px",
            });

            $("#table_3").css({
                width: ($(".table_1_inner").width()+48) * <?php echo @count($shirt3_address); ?>+"px",
            });

            $("#table_4").css({
                width: ($(".table_1_inner").width()+48) * <?php echo @count($shirt4_address); ?>+"px",
            });


</script>

</body>
</html>
