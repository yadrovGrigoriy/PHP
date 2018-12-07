<?php
header("Content-Type: image/png");
$username = $_GET['username'];
$im = imagecreate(250, 50);

$background_color = imagecolorallocate($im, 178, 178, 178);
$text_color = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 6, 55, 20, $username, $text_color);
imagepng($im);
imagedestroy($im);
?>