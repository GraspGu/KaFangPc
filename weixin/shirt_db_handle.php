<?php
/*
本页获取衬衫在数据库的所有数据，包括地址，id，详情等。
*/

/*
本页不单独使用，作为collection.php引用文件。session已在collection.php开启，故不再重复开启。
*/

@$unionid = $_SESSION["unionidSession"];

//查询数据库用户基本信息
$sql = "select * from user_basic_info where user_id = '$unionid'";
$rs = mysql_query($sql);
while($rows=mysql_fetch_assoc($rs)){
    $name = $rows["name"];
    $telephone = $rows["telephone"];
}
//获取已收藏衬衫的id，方便删除时使用
$shirt_id_user = "select project_id from user_store where  `user_id` = '$unionid' and `project_flag` = 'S'";
$shirt_user_rs = mysql_query($shirt_id_user);
    while($rows=mysql_fetch_assoc($shirt_user_rs)) {
        $user_shirt_id[] = "$rows[project_id]";
    }

//获取已收藏衬衫的地址
for($i=0;$i<@count($user_shirt_id);$i++){
@$shirt_address = "select * from shirt_detail_view where shirt_id = '$user_shirt_id[$i]'";
$shirt_address_rs = mysql_query($shirt_address);
    $rows=mysql_fetch_assoc($shirt_address_rs);
    $pic = "<img src = '../$rows[address] '/>";
    $user_shirt_address[$i] = $pic;
    $user_shirt_spercific[$i] = $rows['shirt_id'];
}

//根据地址获取收藏衬衫信息
for($i=0;$i<@count($user_shirt_id);$i++){
@$shirt_xq_select = "select * from shirt_detail_view where address='$user_shirt_spercific[$i]'";
$shirt_xq_select_rs = mysql_query($shirt_xq_select);
$rows=mysql_fetch_assoc($shirt_xq_select_rs);
    $shirt_model[$i] = $rows['model_style_caption'];
    $shirt_cuff[$i] = $rows['cuff_style_caption'];
    $shirt_placket[$i] = $rows['placket_style_caption'];
    $shirt_collar[$i] = $rows['collar_style_caption'];
}

//获取已收藏面料的id，方便删除时使用
$fabric_id_user = "select project_id from user_store where user_id = '$unionid' and project_flag = 'F'";
$fabric_user_rs = mysql_query($fabric_id_user);
    while($rows=mysql_fetch_assoc($fabric_user_rs)) {
        $user_fabric_id[] ="$rows[project_id]";
    }

//获取已收藏的面料地址
for($i=0;$i<@count($user_fabric_id);$i++){
@$fabric_address = "select address from new_fabric_detail_view where fabric_id = '$user_fabric_id[$i]'";
$fabric_address_rs = mysql_query($fabric_address);
$rows=mysql_fetch_assoc($fabric_address_rs);
    $pic = "<img src = '../$rows[address] '/>";
    $user_fabric_address[$i] = $pic;
    $user_fabric_spercific[$i] = $rows['address'];
}

//获取已收藏面料的信息
for($i=0;$i<@count($user_fabric_id);$i++){
$fabric_xq_select= "select caption,tech,grammage,ingredient,ingredient_para,color_name,tr from new_fabric_detail_view where fabric_id = '$user_fabric_id[$i]'";
$fabric_xq_select_rs = mysql_query($fabric_xq_select);
$rows=mysql_fetch_assoc($fabric_xq_select_rs);
    //编号
    $fabric_caption[$i] = $rows["caption"];
    //工艺
    $fabric_tech[$i] = $rows["tech"];
    //克重
    $fabric_grammage[$i] = $rows["grammage"];
    //成分
    $fabric_ingredient[$i] = $rows["ingredient"];
    //成分参数
    $fabric_ingredient_para[$i] = $rows["ingredient_para"];
    //颜色
    $fabric_color_name[$i] = $rows["color_name"];
    //品牌
    $fabric_tr[$i] = $rows["tr"];
}


//获取购物车的order_id和model_id
@$shopping_shirt_address = "select * from order_list_view where user_id = '$unionid' and finished = '0' order by start_time desc";
$shopping_shirt_address_rs = mysql_query($shopping_shirt_address);
    while($rows=mysql_fetch_assoc($shopping_shirt_address_rs)){
	    $shopping_order_id[] = "$rows[order_id]";
	    $shopping_model_id[] = "$rows[model_id]";
}

//获取购物车的衬衫信息
for($i=0;$i<@count($shopping_order_id);$i++){
$shopping_select = "select * from order_list_view where user_id='$unionid' and order_id = '$shopping_order_id[$i]' and finished = '0'";
$shopping_select_rs = mysql_query($shopping_select);
    $rows=mysql_fetch_assoc($shopping_select_rs);
    $pic = "<img src = '../$rows[shirt_iamge_add] '/>";
    $user_shopping_address[$i] = $pic;
    $shopping_placket[$i] = "$rows[shirt_placket]";
    $shopping_collar[$i] = "$rows[shirt_collar]";
    $shopping_cuff[$i] = "$rows[shirt_cuff]";
    //获取价格
    $shopping_price[$i] = "$rows[price]";
    //获取id
    $shopping_order_id[$i] = "$rows[order_id]";
    //获取地址id
    $address_id[$i] = $rows['address_id'];
}

//获取model_id对应的版型信息
for($i=0;$i<@count($shopping_order_id);$i++){
    $version_caption_select = "select * from user_current_model_list where user_id = '$unionid' and model_id = '$shopping_model_id[$i]'";
    $version_caption_select_rs = mysql_query($version_caption_select);
    $rows = mysql_fetch_assoc($version_caption_select_rs);
    $version_caption[$i] = "$rows[caption]";
}
//获取model_id对应的地址信息
for($i=0;$i<@count($shopping_order_id);$i++){
	$address_select = "select * from user_address_list where user_id = '$unionid' and address_id = '$address_id[$i]'";
	$address_select_rs = mysql_query($address_select);
	$rows = mysql_fetch_assoc($address_select_rs);
    $shopping_address[$i] = "$rows[address]";
}
?>