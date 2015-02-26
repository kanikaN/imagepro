<?php 
 include_once '../image_class.php';
 $imgObj = new image();
 $image = 'blue-room.jpg';
$size = getimagesize($image);
 if($_POST){
     $image = $_POST['image'];
     $x = $_POST['x'];
     $y = $_POST['y'];
     foreach($x as $key=>$xs ){
         $points[] = $xs;
         $points[] = $y[$key];
     }
     $imgObj->getSelectedEdgePixels($x, $y, $image);
     return $imgObj->createSelectedPolygon($image,$points);
 }
?>
 