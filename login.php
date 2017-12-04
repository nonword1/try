<?php
/**
 * Created by PhpStorm.
 * User: 马凌峰
 * Date: 2017/11/29
 * Time: 22:00
 */?>
<?php
session_start();
$conn = new PDO("mysql:host=localhost;dbname=mydb", "root", "");
$nickname=$_POST['nickname'];
$password=$_POST['password'];
$password=md5($password);
$verification=$_POST['verification'];


$today=date('Y-m-d H:i:s');//获取时间作为本次登录时间
$ip=$_SERVER["REMOTE_ADDR"];//获取登陆IP地址

$sql=$conn->prepare("select * from student_information where nickname='{$nickname}' and password='{$password}' ");
$rst=$sql->execute();
$row=$sql->fetch();
$sql->closeCursor();
//验证登录信息是否正确
if(($_SESSION['rand'])!=($verification )){
    echo "<script>alert('验证码错误！重新填写');window.location.href='login.html'</script>";
    //判断验证码是否填写正确
}elseif($row) {
    setcookie('niacname',$nickname,time()+10,'/');
    $up="UPDATE student_information SET logintime='$today' WHERE nickname='$nickname'";
    $ip="UPDATE student_information SET ip='$ip' WHERE nickname='$nickname'";

    if ($conn->exec($up)){

    }
    if ($conn->exec($ip)){

    }
    //更新登录时间及ip
    echo "<script>alert('登陆成功！欢迎');window.location.href='content.php'</script>";
}else{
    echo "<script>alert('登陆信息有误！重新填写');window.location.href='login.html'</script>";

}

?>
