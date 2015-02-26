<?php
include_once './image_class.php';
$src = 'empty-room.gif';
$srcHeight = 100;
$srcLength = 200;
$image = new image($src);
$images = array(array('image'=>'http://static.fabfurnish.com/p/fab-home-1873-31263-1-product_432.jpg','height'=>30,'length'=>20),
    array('image'=>'http://static.fabfurnish.com/p/spin-7126-39142-1-product_432.jpg','height'=>10,'length'=>10),
    array('image'=>'http://static.fabfurnish.com/p/elmwood-1868-65092-1-product_432.jpg','height'=>10,'length'=>20),
    array('image'=>'http://static.fabfurnish.com/p/elmwood-1584-46092-1-product_432.jpg','height'=>10,'length'=>20),
    array('image'=>'http://static.fabfurnish.com/p/spin-2466-73621-1-product_432.jpg','height'=>10,'length'=>20));
?>
<html>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="colorMe.js" type="text/javascript"></script>
    <style>
        div{
            border: solid 1px;
        }
        .outer {
            height: 100%;
            width:100%;
        }
        .right{
            float: right;
            width:19%;
            height: 100%;
            overflow: scroll;
        }
        .left {
            float: left;
            width: 1000px;
            height: 100%;
        }
        .left img{
            z-index: -1;
            position: absolute;
            width: 1000px;
            height: 100%;
        }
        .drag{
            width: 209px;
            height:200px;
            margin: 5px 5px 0 5px;  
            float: right;
        }

        .drag img{
            width:209px;
            height: 200px;
            cursor: move;
        }
    </style> 
    <body data-height="<?php echo $srcHeight;?>">
    <div class="outer " >
        <div class="left "><img class="my-room" style="z-index: -1;position: absolute;" src="<?php echo $src; ?>"/>
            <canvas  style="cursor: pointer;" width="<?php echo $image->sizex; ?>" height="<?php echo $image->sizey; ?>" id="myCanvas" ></canvas>
        </div>
        <div class="my-options ui-helper-reset right">
            <?php foreach ($images as $imObj): 
                //convert image into transparent background images
                $im = $imObj['image'];
                $file = file_get_contents($im);
            $filename = explode('/', $im);
            $fileNew = explode('.',$filename[count($filename)-1]);
            $fileNew = $fileNew[0];
            if(!file_exists('images/png/'.$fileNew.'png')){
                file_put_contents('images/old/'.$filename[count($filename)-1], $file);
                $imgObj = new image('images/old/'.$filename[count($filename)-1]);
                $imageContent = $imgObj->convertTopngWithTransparentBackground($fileNew);
            }
            //echo $imageContent;
                
                ?>
            <div class="drag option ui-widget-content"><img data-height ="<?php echo $imObj['height']?>" src="<?php echo 'images/png/'.$fileNew.'png'; ?>"/></div>
                <?php endforeach; ?>
        </div>
    </div>
    <button type="button" name="submit" />
    </body>
</html>