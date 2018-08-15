<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';

//检查session，未登录不允许跳向本地址，重定向至登录地址
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}else{
    $unionid = $_SESSION["unionidSession"];
}

if (isset($_POST['msg']) && $_POST['msg'] != 'caption') {
    $caption = trim($_POST['msg']);
    //查询数据库
    $sql_select = "select caption from user_measure_temp_list where user_id = '$unionid' and caption = '$caption'";
    $sql_select_rs = mysql_query($sql_select);
    //判断输入标题是否存在
    if (mysql_num_rows($sql_select_rs) > 0) {
        echo "1";
    }else{
        echo "0";
    }
}
?>