<?php
session_start();
//检查是否有会话
if(@$_SESSION["unionidSession"]!=null){
  $url = "*****";
  echo "<script language='javascript' type='text/javascript'>";
  echo "window.location.href='$url'";
  echo "</script>";
exit;
}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
    </head>
    <body>
        <span id="login_container"></span>
        <script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
        <script>
            var obj = new WxLogin({
              id: "login_container",
              appid: "*****",
              scope: "snsapi_login",
              redirect_uri:encodeURI("http://*****/weixin/index.php"),
              state: Math.ceil(Math.random()*1000),
              style: "black",
              href: ""});
        </script>
    </body>
</html>
