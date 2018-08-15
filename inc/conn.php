<?php
$config = require $_SERVER['DOCUMENT_ROOT'].'/KaFangPc/config/config.php';
$con = mysql_connect($config['host'].':'.$config['port'],$config['name'],$config['pwd']) or die('连接失败！错误信息为：' . mysql_error());
//选择数据库
mysql_select_db($config['database']);
//设置编码
mysql_query("set names {$config['charset']}");
?>