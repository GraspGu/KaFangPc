<?php
require 'inc/conn.php';
//按照List_rank降序标准将衬衫信息取出
    $white_shirt_address = "select * from shirt_trial_model_view order by List_rank desc";
    $white_shirt_address_rs = mysql_query($white_shirt_address);
        while($rows=mysql_fetch_assoc($white_shirt_address_rs)) {
        $array_fa[] = "<img src = '$rows[address] '/>";
        $fa_address[] = "$rows[address]";
    //查询shirt_trial_model_view表中白衬衫的id
        $white_shirt_id_row[] = "$rows[shirt_id]";
    }

//查询shirt_trial_model_view表中白衬衫的数量
    $white_shirt_count_select = "select count(shirt_id) as count_shirt from shirt_trial_model_view order by list_rank desc";
    $white_shirt_count_select_rs = mysql_query($white_shirt_count_select);
    while($rows=mysql_fetch_assoc($white_shirt_count_select_rs)) {
        $white_shirt_count = "$rows[count_shirt]";
    }
//根据白衬衫的id和数量循环出衬衫的信息
for($i=0;$i<$white_shirt_count;$i++){
    $white_shirt_xq = "select placket_style_caption,collar_style_caption from shirt_detail_view where shirt_id = '$white_shirt_id_row[$i]'";
    $white_shirt_xq_rs = mysql_query($white_shirt_xq);
    $rows=mysql_fetch_assoc($white_shirt_xq_rs);
        $white_shirt_placket[] = "$rows[placket_style_caption]";
        $white_shirt_collar[] = "$rows[collar_style_caption]";
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,intial-scale=1,maximum-scale=1,user-scalable=no">
<title>白衬衫款式一览--卡方商城</title>
<link rel="stylesheet" href="css/white_aFabric.css">
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
       <div><p id="classic">白衬衫款式一览</p><p id="classic_r">Design view</p></div>
    </div>
    <div id="body">
        <img class="slide" src="images/某一面料衬衫详情页/法式分割线.png" height="95" width="1280" alt="">
        <ul>
        <?php for($i=0;$i<$white_shirt_count;$i++){ ?>
            <li><div class="img_div">
                <a href="specific.php?shirt_address=<?php echo "$fa_address[$i]" ?>"><?php echo @"$array_fa[$i]"; ?></a>
                </div>
                <p><?php echo @"$white_shirt_placket[$i]"; ?>/<?php echo @"$white_shirt_collar[$i]"; ?></p>
                <div class="button_in">
                    <a href="specific.php?shirt_address=<?php echo "$fa_address[$i]" ?>"><img src="images/某一面料衬衫详情页/查看详情.png"></a>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
</div>
</body>
</html>