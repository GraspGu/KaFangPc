<?php
/*
    本页处理收藏衬衫或面料时的语句，接收由specific.php或aFabric.php传来的衬衫id或面料id，添加数据库后转向至collection.php
*/

require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
session_start();

@$unionid = $_SESSION["unionidSession"];
@$sessionname = $_SESSION["nameSession"];

//如果获取的是衬衫id,查看数据库是否有此衬衫
if(isset($_GET['id']) && ($_GET['id'])!=null){
//获取从具体衬衫发来的衬衫shirt_id
$id = $_GET["id"];
$shirt_id_select = "select project_id from user_store where project_id = '$id' and user_id = '$unionid'";
$shirt_id_select_rs = mysql_query($shirt_id_select);
    if(mysql_fetch_assoc($shirt_id_select_rs)==null){
        //如果数据库无此衬衫，插入此衬衫id
        $shirt_id_insert = "INSERT into user_store(store_id,user_id,project_id,project_flag) values(UUID(),'$unionid','$id','S')";
        mysql_query($shirt_id_insert);
    $url = "http://www.ka-fang.cn:8080/weixin/collection.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    }
}else{
    $url = "http://www.ka-fang.cn:8080/weixin/collection.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

//如果获得的是面料id
if(isset($_GET['f_id']) && ($_GET['f_id'])!=null){
//获取从具体衬衫发来的衬衫shirt_id
$id = $_GET["f_id"];
$fabric_id_select = "select project_id from user_store where project_id = '$id' and user_id = '$unionid'";
$fabric_id_select_rs = mysql_query($fabric_id_select);
    if(mysql_fetch_assoc($fabric_id_select_rs)==null){
        //如果数据库无此衬衫，插入此衬衫id
        $fabric_id_insert = "INSERT into user_store(store_id,user_id,project_id,project_flag) values(UUID(),'$unionid','$id','F')";
        mysql_query($fabric_id_insert);
    $url = "http://www.ka-fang.cn:8080/weixin/collection.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    }
}else{
    $url = "http://www.ka-fang.cn:8080/weixin/collection.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

 ?>