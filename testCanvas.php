<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
 
   // window.onload = function(){
        
        var start = Array();
        var cnt = 0;
        $(document).ready(function() {
         $('#myCanvas').click(function(e) {
             
             var canvas = document.getElementById("myCanvas");
             var context = canvas.getContext("2d");
             
                var offset = $(this).offset();
                var xOfset = e.clientX - offset.left;
                var yOfset = e.clientY - offset.top;
                if(typeof(start.x) == 'undefined'){
                    context.moveTo(xOfset, yOfset);
                }else{
                    context.lineTo(xOfset, yOfset);
                    context.moveTo(xOfset, yOfset);
                    context.lineWidth = 3;
                    context.strokeStyle = 'orange';
                    context.stroke();
                }
                start.x = xOfset;
                start.y = yOfset;
                var pointsHtml = $('#points').html();
                $('#points').html(pointsHtml+'<input type="hidden" name="x['+cnt+']" value="'+xOfset+'" id="pointx" /><input  value="'+yOfset+'" type="hidden" name="y['+cnt+']" id="pointy" />');
                cnt++;
    });
    });
    //};
    
 
</script>
<form method="post" name="canvas">
    <div id="points">
        
    </div>
<input type="submit" id="submit" value="submit"/>
 <?php 
 include_once './image_class.php';
 $imgObj = new image();
 $image = 'blue-room.jpg';
$size = getimagesize($image);
?>
 
 </form>
<canvas  style="border:solid 1px;cursor: pointer;" id="myCanvas" width="<?php echo $size[0]?>" height="<?php echo $size[1]?>">

</canvas>
<?php

 if($_POST){
     $x = $_POST['x'];
     $y = $_POST['y'];
     foreach($x as $key=>$xs ){
         $points[] = $xs;
         $points[] = $y[$key];
     }
     $imgObj->getSelectedEdgePixels($x, $y, $image);
     $imgObj->createSelectedPolygon($image,$points);
     //$imgObj->readImage($image);
     
//     echo '<img src="newImg.png"/>';
//     echo '<img src="imagepoly.png"/>';
//     echo '<img src="imagetrans.png"/>';
 }
 
?>
<div style="background-image: url(<?php echo $image;?>); background-repeat: no-repeat"><img style="opacity:0.4;filter:alpha(opacity=40);" src="imagepoly.png"/></div>