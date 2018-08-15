<?php
session_start();
//链接数据库
require $_SERVER['DOCUMENT_ROOT'].'/inc/conn.php';
$path = $_FILES['file']['name'];
// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
/*'文件的大小为'echo $_FILES["file"]["size"];*/
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 2000 kb
&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        $filename = basename($path);// basename($path):返回基本的文件名，如：文件名.doc
        $extpos = strrpos($filename,'.');//返回字符串filename中'.'号最后一次出现的数字位置
        $ext = substr($filename,$extpos+1);//获取后缀
        $unionid = $_SESSION['unionidSession'];//获取用户unionid
        $model_id = $_SESSION['pro_data_model_id'];//获取数据model_id
        $exp_part = $_SESSION['exp_part'];//获取照片部位
        $path = '../../user_photo/'.$unionid.@date("h:i:sa").'.'.$ext;//拼接用户unionid后形成的名字
//      echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
//      echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
//      echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//      echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
        //更新path路径
            $path = '../../user_photo/'."$unionid"."$model_id".@date("hisa").'.'."$ext";//注意变量名不能有非法参数，如冒号：
            $sql_path = substr("$path", 17);
        //将path插入数据库
        $user_photo_update = "UPDATE user_model_staff_temp_list set $_SESSION[exp_part] = '$sql_path' where user_id = '$unionid' and model_id = '$_SESSION[pro_data_model_id]'";
        if(mysql_query($user_photo_update)){
            //cho "图片插入数据库成功！"."<br>";
        }

        // 判断目录下的 user_photo 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists($path))
        {
            echo $path. " 文件已经存在。 "."<br>";
        }
        else
        {
            // 如果 user_photo 目录不存在该文件则将文件上传到 user_photo 目录下
            // 截取path目录字符串
            $img_path = "D:user_photo/"."$sql_path";
            //iconv("UTF-8","GB2312", "$img_path");中文文件名需要改编码
            //echo "$img_path"."<br>";
            move_uploaded_file($_FILES['file']['tmp_name'],"$img_path");
            //$_FILES['file']['tmp_name']=iconv("GBK","UTF-8", $_FILES['file']['tmp_name']);
            //echo "文件存储在: " . $path."<br>";

            echo "<script>alert('上传成功！请继续上传其他照片。')</script>";
            $url = "http://www.ka-fang.cn:8080/online/pro_data_img_submit.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }
    }
}
else
{
	echo "<script>alert('非法的文件格式。请保证图片格式为jpg/jpeg/png/gif，且大小不超过2M！')</script>";
    echo "<script language='javascript' type='text/javascript'>";
    echo "history.go(-1);";
    echo "</script>";
}
?>