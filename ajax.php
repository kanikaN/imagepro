<?php

if(isset($_POST['xoffset'])){
    $x= $_POST['xoffset'];
    $y= $_POST['yoffset'];
    $p = $_POST['points'];
    $imageGrey = 'empty-edge.gif';
    $im = imagecreatefromgif($imageGrey);
    $colorAt = imagecolorat($im, $x, $y);
    print_r($colorAt);
    $colors = imagecolorsforindex($im, $colorAt);
        print_r($p);
      print_r(json_decode($p));
//    
//$sizex = imagesx($im);
//$sizey = imagesy($im);
//for($pixelx = 0;$pixelx<=$sizex;$pixelx++){
//   for($pixely = 0;$pixely<=$sizey;$pixely++){ 
//       $pixelColor = imagecolorat($im, $pixelx, $pixely);
//       $colors = imagecolorsforindex($im, $pixelColor);
//       print_r($colors);
//       echo'<br>';
//   }
//}
}
?>
