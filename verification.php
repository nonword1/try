<?php
/**
 * Created by PhpStorm.
 * User: 马凌峰
 * Date: 2017/11/28
 * Time: 17:21
 */?>
<?php
session_start();
//$img = imagecreatetruecolor(100, 35);
$img = imagecreatetruecolor(100, 35);
$width=100;$height=35;$codelen=4;$fontsize=20;
$black = imagecolorallocate($img, 0x00, 0x00, 0x00);
$green = imagecolorallocate($img, 0x00, 0xFF, 0x00);
$white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
$text_color = imagecolorallocate($img,rand(00,100),rand(00,100),rand(00,100));
imagefill($img,0,0,$white);
$font = 'D:\workplace\php\formaltry\font\Elephant.ttf';//
$charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//随机因子
$_len=strlen($charset)-1;
//生成随机的验证码
$code = '';
for($i = 0; $i < 4; $i++) {
    $code .= $charset[rand(0, $_len)];
}
$_SESSION['rand'] = $code;  //存储验证码
//生成背景
//imagestring($img, 185, 25, 5, $code, $text_color);
for($i = 0; $i < 4; $i++) {
    $_x = $width / $codelen;
    imagettftext($img, $fontsize, mt_rand(-30, 30), $_x*$i + mt_rand(1, 5), $height / 1.4, $text_color, $font, $code[$i]);
}
//$img = imagecreatetruecolor($width, $height);
//$color = imagecolorallocate($img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));

//生成线条、雪花
//加入噪点干扰
for($i=0;$i<200;$i++) {
      imagesetpixel($img, rand(0, 100) , rand(0, 100) , $black);
  imagesetpixel($img, rand(0, 100) , rand(0, 100) , $green);
}

//线条
for ($i=0;$i<6;$i++) {
    $color = imagecolorallocate($img,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
    imageline($img,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),$color);
}
//雪花
/*for ($i=0;$i<50;$i++) {
    $color = imagecolorallocate($img,mt_rand(175,225),mt_rand(175,225),mt_rand(175,225));
    imagestring($img,mt_rand(1,5),mt_rand(0,$width),mt_rand(0,$height),'*',$color);
}*/
//输出验证码
header("content-type: image/png");
imagepng($img);
imagedestroy($img);
?>

