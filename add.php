<?php
/**
 * Created by PhpStorm.
 * User: 马凌峰
 * Date: 2017/11/28
 * Time: 21:56
 */?>
<?php
//把传递过来的信息入库；
session_start();
//用于核对验证码
header ("Content-type:text/html;charset=utf8_bin");

//连库
$servername = "localhost";
$username = "root";
$password1 = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=mydb", $username, $password1);

}
catch(PDOException $e)
{
    echo $e->getMessage();
}

//字符集
$conn->exec('set names utf8_bin');
//  print_r($_POST);
$nickname=isset($_POST['nickname'])?$_POST['nickname']:"";
$password=isset($_POST['password'])?$_POST['password']:"";
$password=md5($password);
$confirm=isset($_POST['confirm'])?$_POST['confirm']:"";
$confirm=md5($confirm);
$emailaddress= isset($_POST['emailaddress'])?$_POST['emailaddress']:"";
$verification=isset($_POST['verification'])?$_POST['verification']:"";
$today=date('Y-m-d H:i:s');//获取时间作为注册时间
$result=$conn->prepare("select * from student_information where nickname =$nickname");
$result->execute();
$rows=$result->fetch();
$result->closeCursor();
$conn = null;
//验证填写信息是否合乎规范
if(empty($nickname)||empty($password)||empty($confirm)||empty($emailaddress)||empty($emailaddress)) {
    echo "<script>alert('信息不能为空！重新填写');window.location.href='register.html'</script>";
}elseif ((strlen($nickname) < 4)||(!preg_match('/^\w+$/i', $nickname))) {
    echo "<script>alert('用户名至少4位且不含非法字符！重新填写');window.location.href='register.html'</script>";
    //判断用户名长度
}elseif( $rows > 0){
    echo "<script>alert('此用户名已经注册！重新填写');window.location.href='register.html'</script>";
    //学号不能重复
}elseif(strlen($password) < 6){
    echo "<script>alert('密码至少6位！重新填写');window.location.href='register.html'</script>";
    //判断密码长度
}elseif($password!=$confirm){
    echo "<script>alert('两次密码不相同！重新填写');window.location.href='register.html'</script>";
    //检测两次输入密码是否相同
}elseif (!preg_match('/^[\w\.]+@\w+\.\w+$/i', $emailaddress)) {
    echo "<script>alert('邮箱不合法！重新填写');window.location.href='register.html'</script>";
    //判断邮箱格式是否合法
}//elseif($verification !=$_SESSION['$code']) {
elseif(($_SESSION['rand'])!=($verification )){
    echo "<script>alert('验证码错误！重新填写');window.location.href='register.html'</script>";
    //判断验证码是否填写正确
} else{
    try {

        $conn = new PDO("mysql:host=localhost;dbname=mydb", "root", "");
        // 设置 PDO 错误模式，用于抛出异常
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("INSERT INTO student_information(nickname,password,confirm,emailaddress,registrationtime,logintime)
                    values('$nickname','$password','$confirm','$emailaddress','$today','$today')");
        //插入数据库
        //$conn->exec($insertsql);
        echo "<script>alert('注册成功！去登陆');window.location.href='login.html'</script>";
    }
    catch(PDOException $e) {
        echo   $e->getMessage();
    }
}
$conn = null;
?>

