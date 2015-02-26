<?php
$image = 'empty-room.gif';

    $im = imagecreatefromgif($image);
    imagefilter($im, IMG_FILTER_NEGATIVE);
    header('Content-type: image/gif');
    imagegif($im, 'empty-grey.gif');

?>
