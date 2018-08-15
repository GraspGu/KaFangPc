<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
require 'shirt_db_handle.php';

//检查session，未登录不允许查看收藏夹，跳向登录地址
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}
@$unionid = $_SESSION["unionidSession"];
@$sessionname = $_SESSION["nameSession"];


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="卡方高级服装定制">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,intial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="stylesheet" href="../css/collection.css">
<script src="../js/jquery-1.8.2.min.js"></script>
<title>我的收藏--卡方商城</title>
</head>
<body>
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
    <h2>欢迎 <label><?php if($name!=null) echo "$name";else echo "$sessionname";?> </label>进入卡方高级服装定制</h2>
</div>
<div id="container">
    <div id="toggle">
        <ul>
            <a id="a_collection" href="collection.php"><li class="select"><b>我的收藏</b></li></a>
        </ul>
    </div>
    <div id="body">
        <!-- 收藏部分 -->
        <div id="body_collection">
            <p id="body_collection_head">
                <a id="li_collection" href="collection.php" class="select"><b>我收藏的衬衫 /</b></a>
                <a id="li_shopping"><b>我收藏的面料</b></a>
            </p>

<!-- 收藏的衬衫 -->
            <div id="container_shirt">
            <table>
                <tr>
                    <td>
                        <div class="collection_wrap">
                            <div class="collection_table">
                                <?php
                                    for($i=0;$i<@count($user_fabric_id);$i++){
                                ?>
                                <div class="collection_inner_wrap">
                                    <a href="../specific.php?shirt_address=<?php echo "$user_shirt_spercific[$i]"; ?>"><?php echo @"$user_shirt_address[$i]";?></a><a class="del" href="delete.php?del_coll=<?php echo @"$user_shirt_id[$i]"; ?>">删除</a>
                                    <p><?php echo @"$shirt_model[$i]"; ?></p>
                                    <p><?php echo @"$shirt_cuff[$i]"; ?></p>
                                    <p><?php echo @"$shirt_placket[$i]"; ?></p>
                                    <p><?php echo @"$shirt_collar[$i]"; ?></p>
                                    <p id="submit_shirt"><a href="shopping_version.php?id=<?php echo "$user_shirt_id[$i]"; ?>" style="color:#f40">已看好，立即加入购物车</a></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            </div>
<!-- 收藏的面料 -->
            <div id="container_fabric" style="display:none;">
            <table>
                <tr>
                    <td>
                        <div class="collection_wrap">
                            <div class="collection_table">
                                <?php for($i=0;$i<@count($user_fabric_id);$i++){ ?>
                                <div class="collection_inner_wrap">
                                    <?php echo @"$user_fabric_address[$i]";?><a class="del" href="delete.php?del_coll=<?php echo @"$user_fabric_id[$i]"; ?>">删除</a>
                                    <p>编号：<?php echo @"$fabric_caption[$i]"; ?></p>
                                    <p>工艺：<?php echo @"$fabric_tech[$i]"; ?></p>
                                    <p>克重：<?php echo @"$fabric_grammage[$i]"; ?></p>
                                    <p>成分：<?php echo @"$fabric_ingredient[$i]"; ?></p>
                                    <p>成分参数：<?php echo @"$fabric_ingredient_para[$i]"; ?></p>
                                    <p>颜色：<?php echo @"$fabric_color_name[$i]"; ?></p>
                                    <p>品牌：<?php echo @"$fabric_tr[$i]"; ?></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>
<script>

$("#li_shopping").click(function(){
    $("#li_shopping").addClass('select');
    $("#li_collection").removeClass('select');
    $("#container_shirt").hide();
    $("#container_fabric").show();
});
</script>
</body>
</html>

