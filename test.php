<?php
$image = 'ocean-room.gif';
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style>
    .greyscale{
        position:absolute;
        opacity: 0.5;
        z-index:1000;
    }
</style>
<form method="post" name="from-color" id="from-color">
    <input type="text" name="color-val"/>
    <input type="text" name="points" id="points"/>
    <input type="button" id="start" value="record"/>
    <input type="button" id="save" value="save"/>
    <script type="text/javascript">
        $(document).ready(function() {
            var record = new Array();
            var flag = 0;
            $('#start').click(function(e){
                record = new Array();
                flag = 1;
            });
            $('#save').click(function(e){
                flag = 0;
                $('#from-color').submit();
            });
            $('img').click(function(e) {
                var offset = $(this).offset();
                var xOfset = e.clientX - offset.left;
                var yOfset = e.clientY - offset.top;
                $('#xoffset').val(xOfset);
                $('#yoffset').val(yOfset);
                if(flag){
                    var ar1r = [[xOfset,yOfset]];
                    var arr = [
        { text: "rock", value: "rock", },
        { text: "pop", value: "pop", },
    ];
                    alert(arr);
                    record.push(arr) ;
                    $('#points').val(record);
                }
                //$('#from-color').submit();
//                $.ajax({
//                    url: "ajax.php",
//                    type: 'POST',
//                    data: {'xofset': xOfset, 'yofset': yofset}
//                }).done(function(data) {
//                    $('#div-disp').html(data);
//                    alert(data);
//                    //$(this).addClass("done");
//                });
            });
        });
    </script>
    <input type="hidden" name="yoffset" id="yoffset"/>
    <input type="hidden" name="xoffset" id="xoffset"/>
    <div id="div-disp"></div>
</form>
<?php
if (file_exists($image)) {
    $im = imagecreatefromgif($image);
    imagefilter($im, IMG_FILTER_EDGEDETECT);
    imagegif($im, 'empty-edge.gif');
    $im = imagecreatefromgif($image);
    imagefilter($im, IMG_FILTER_GRAYSCALE);
    imagegif($im, 'empty-grey.gif');
}
if(isset($_POST)){
    include_once('ajax.php');
}

$size = getimagesize($image);
?>
<div style="background-image: url(<?php echo $image;?>);width:<?php echo $size[0]; ?>;height:<?php echo $size[1]; ?>">
    <img class="greyscale" src="empty-grey.gif"/>
    
</div>
<img src="empty-edge.gif"/>
<?php
?>
