<?php
/*
本页接收购物车传来的衬衫id，将衬衫和版型添加至数据库
 */
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
session_start();
@$unionid = $_SESSION["unionidSession"];

if(isset($_GET['s_id']) && $unionid != null && isset($_POST['address']) && isset($_POST['model'])){
$id = htmlspecialchars($_GET['s_id']);//获取衬衫id
$model_id = htmlspecialchars($_POST['model']);//获取model_id
$address_id = htmlspecialchars($_POST['address']);//获取地址id
//$measure_id = htmlspecialchars($_GET['mea_id']);//获取measure_id
$measure_id_select = "select user_measure_id from user_current_model_list where model_id = '$model_id'";
$measure_id_select_rs = mysql_query($measure_id_select);
while($rows = mysql_fetch_assoc($measure_id_select_rs)){
	$measure_id[] =$rows['user_measure_id'];
}

//这里不能对shirt_id进行查重，因为一件衬衫不能只购买一次
//查询衬衫信息
//$shopping_id_select = "select shirt_id from order_list where shirt_id = '$id' and user_id = '$unionid'";
//$shopping_id_select_rs = mysql_query($shopping_id_select);
//如果购物车无此衬衫，插入此衬衫id
    if(!empty($id)){

        //根据user_basic_info表里面leve字段的值（该值为字符）进行选取价格，0表示使用price，1表示使用price_2,2表示使用price_3
        $shirt_leve_select = "select level from user_basic_info where user_id = '$unionid'";
        $shirt_leve_select_rs = mysql_query($shirt_leve_select);
        while($rows_leve = mysql_fetch_assoc($shirt_leve_select_rs)){
            $shirt_leve[] = $rows_leve['level'];
        }

        //获取衬衫价格，以便添加到order_list.
        $shirt_price_select = "select price,price_2,price_3 from shirt_detail_view where shirt_id = '$id'";
        $shirt_price_select_rs = mysql_query($shirt_price_select);
        while($rows_price = mysql_fetch_assoc($shirt_price_select_rs)){
            $shirt_price[] = $rows_price['price'];
            $shirt_price_2[] = $rows_price['price_2'];
            $shirt_price_3[] = $rows_price['price_3'];
        }

        //将数据添加到购物车order_list
        if($shirt_leve[0] == '0'){
            $shopping_id_insert = "INSERT into order_list(order_id,user_id,shirt_id,finished,start_time,completed,price,model_id,measure_id,address_id) values(UUID(),'$unionid','$id','0',now(),'0','$shirt_price[0]','$model_id','$measure_id[0]','$address_id')";
            mysql_query($shopping_id_insert);
            $url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }else if($shirt_leve[0] == '1'){
            $shopping_id_insert = "INSERT into order_list(order_id,user_id,shirt_id,finished,start_time,completed,price,model_id,measure_id,address_id) values(UUID(),'$unionid','$id','0',now(),'0','$shirt_price_2[0]','$model_id','$measure_id[0]','$address_id')";
            mysql_query($shopping_id_insert);
            $url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }else if($shirt_leve[0] == '2'){
            $shopping_id_insert = "INSERT into order_list(order_id,user_id,shirt_id,finished,start_time,completed,price,model_id,measure_id,address_id) values(UUID(),'$unionid','$id','0',now(),'0','$shirt_price_3[0]','$model_id','$measure_id[0]','$address_id')";
            mysql_query($shopping_id_insert);
            $url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }
    }else{
        $url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
        }
}else{
    $url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

if(isset($_GET['order_id']) && $_GET['order_id'] != null){
	$order_id = $_GET['order_id'];
	$address = $_POST['address'];
	$model_id = $_POST['model'];
	$data_update = "update order_list set address_id = '$address',model_id = '$model_id' where user_id = '$unionid' and order_id = '$order_id'";
	if(mysql_query($data_update)){
		echo "<script>alert('修改成功！')</script>";
		$url = "http://www.ka-fang.cn:8080/weixin/shopping.php";
	    echo "<script language='javascript' type='text/javascript'>";
	    echo "window.location.href='$url'";
	    echo "</script>";
	}
}
?>
