<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
if(@$_SESSION["unionidSession"]==null){
    $url = "http://www.ka-fang.cn:8080/weixin/login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}
        $code = $_GET["code"];
        $appid = "wxe635c8106a62cbde";
        $secret = "f44b2867407de523280cf113bc714370";
        if (!empty($code))  //有code
        {
            //通过code获得 access_token + openid
            $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid
            . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $jsonResult = file_get_contents($url);
            $resultArray = json_decode($jsonResult, true);
            $access_token = $resultArray["access_token"];
            $openid = $resultArray["openid"];

            //通过access_token + openid 获得用户所有信息,结果全部存储在$infoArray里,后面再写自己的代码逻辑
            $infoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token . "&openid=" . $openid;
            $infoResult = file_get_contents($infoUrl);
            $infoArray = json_decode($infoResult, true);

	        //获取用户unionid和name
	        $unionid = $infoArray['unionid'];
	        $name = $infoArray['nickname'];
	        //写入session
	        $_SESSION['unionidSession'] = $unionid;
	        $_SESSION['nameSession'] = $name;
		}
	//查询数据
	$sql_select = "select user_id from user_basic_info where user_id = '$unionid'";
	$sql_select_rs = mysql_query($sql_select);//获取返回数据行数
	if(mysql_num_rows($sql_select_rs) < '1'){
		//插入用户
		$sql_insert = "insert into user_basic_info(user_id,name) values('$unionid','$name')";
	    mysql_query($sql_insert);
		
	    $url = "http://www.ka-fang.cn:8080";
	    echo "<script language='javascript' type='text/javascript'>";
	    echo "window.location.href='$url'";
	    echo "</script>";
	}elseif(mysql_num_rows($sql_select_rs) == '1'){
	    $url = "http://www.ka-fang.cn:8080";
	    echo "<script language='javascript' type='text/javascript'>";
	    echo "window.location.href='$url'";
	    echo "</script>";
	}
 ?>