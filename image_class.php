<?php

class image {

    public $xArr = array();
    public $yArr = array();

    public function __construct($src) {
        $this->imageSrc = $src;
        $type = self::getImageType($src);
        switch ($type):
            case 'JPEG':
                $this->image = imagecreatefromjpeg($src);
                break;
            case 'GIF':
                $this->image = imagecreatefromgif($src);
                break;
            case 'PNG':
                $this->image = imagecreatefrompng($src);
                break;
            case 'BMP':
                $this->image = imagecreatefrombmp($src);
                break;
            default :
                return false;
                break;
        endswitch;
        $this->sizex = imagesx($this->image);
        $this->sizey = imagesy($this->image);
    }

    public function convertTopngWithTransparentBackground($newPath) {
        $white = imagecolorallocate($this->image, 255, 255, 255);
        imagecolortransparent($this->image, $white);
        imagepng($this->image,'images/png/'.$newPath.'png');
    }

    public static function getImageType($src) {
        $expl = explode('.', $src);
        $sub = $expl[count($expl) - 1];
        $sub = trim(strtoupper($sub));
        if ($sub == 'JPG' || $sub == 'JPEG')
            return 'JPEG';
        return $sub;
    }

    public function getSelectedEdgePixels($xs, $ys, $src) {
        //get all xs and ys
        $im = imagecreatefromjpeg($src);
        $color = imagecolorallocate($im, 255, 0, 0);
        foreach ($xs as $key => $x) {
            $x1 = (int) $x;
            $y1 = $ys[$key];
            $this->xArr = $this->yArr = array();
            if (!isset($xs[$key + 1])) {
                //echo 'broken';
                break;
            }
            $x2 = isset($xs[$key + 1]) ? $xs[$key + 1] : $xs[0];
            $y2 = isset($ys[$key + 1]) ? $ys[$key + 1] : $ys[0];
            $x2x1 = abs($x2 - $x1);
            $y2y1 = abs($y2 - $y1);
            $star = 'x';
            $t1 = '1';
            $t2 = '2';
            $other = 'y';
            if ($y2y1 > $x2x1) {
                $star = 'y';
                $other = 'x';
            }
            if (${$star . '1'} > ${$star . '2'}) {
                $t1 = '2';
                $t2 = '1';
            }
            //echo $x2.','.$x1.','.$m.','.$x2x1.','.$y2y1.'<br>';
            $this->xArr[] = $x1;
            $this->xArr[] = $x2;
            $this->yArr[] = $y1;
            $this->yArr[] = $y2;
            $m = (((int) (${'x' . $t2} - ${'x' . $t1}) == 0) ? 0 : (int) (${'y' . $t2} - ${'y' . $t1}) / (int) (${'x' . $t2} - ${'x' . $t1}));
            //$m = abs(((int)($x2 - $x1)==0)?0:(int)($y2 - $y1) / (int)($x2 - $x1));
            //echo 'pnt'.${$star.$t1};
            for ($pnt = ${$star . $t1} + 1; $pnt < ${$star . $t2}; $pnt++) {
                $diff = $pnt - ${$star . $t1};
                if ($star == 'x') {
                    $pnt_other = round(($m == 0) ? ${'y' . $t1} : (($diff * $m) + ${'y' . $t1}));
                } else {
                    $pnt_other = round(($m == 0) ? ${'x' . $t1} : ${'x' . $t1} + ($diff / $m));
                }
                $this->{$star . 'Arr'}[] = $pnt;
                $this->{$other . 'Arr'}[] = $pnt_other;
            }
            arsort($this->xArr);
            foreach ($this->xArr as $key => $x) {
                $y = $this->yArr[$key];
                $this->points[] = $x;
                $this->points[] = $y;
                $this->coordinates[] = array($x, $y);
                //echo $x.','.$y.'<br>';
                //$rgb = imagecolorat($im, $x, $y);
                //var_dump($rgb);
                //$colors = imagecolorsforindex($im, $rgb);
                //$color = imagecolorallocate($im, $colors['red'], $colors['green'], $colors['blue']);
                //imagecolorset($im, $rgb, 255, 0, 0);
                imagesetpixel($im, $x, $y, $color);
            }
        }

        imagepng($im, 'newImg.png');
    }

    function intercept($point, $slope) {
        if ($slope === 0) {
            // vertical line
            return $point[0];
        }

        return $point[1] - $slope * $point[0];
    }

    function slope($a, $b) {
        if ($a[0] == $b[0]) {
            return null;
        }

        return ($b[1] - $a[1]) / ($b[0] - $a[0]);
    }

    public function createSelectedPolygon($src, $points) {
        $im = imagecreatefromjpeg($src);
        $sizex = imagesx($im);
        $sizey = imagesy($im);
        $im = imagecreatetruecolor($sizex, $sizey);
//$im = imagecreatefromjpeg($src);
// Allocate a color for the polygon
        $col_poly = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagecolortransparent($im, $black);
// Draw the polygon
        echo count($this->coordinates);
        imagefilledpolygon($im, $points, count($points) / 2, $col_poly);

        imagepng($im, '../images/imagepoly.png');
        return '../images/imagepoly.png';
    }

    public function readImage($src) {
        $im = imagecreatefromjpeg($src);
        $sizex = imagesx($im);
        $sizey = imagesy($im);
        $newIm = imagecreatetruecolor($sizex, $sizey);
        $black = imagecolorallocate($newIm, 0, 0, 0);
        imagecolortransparent($newIm, $black);
        imagefill($newIm, 0, 0, $black);
        imagepng($newIm, 'newImg1.png');
//        
//        $newIm2 = imagecreatetruecolor($sizex, $sizey);
//        for ($x = 0; $x < $sizex; $x++) {
//            for ($y = 0; $y < $sizey; $y++) {
//                if (in_array(array($x, $y), $this->coordinates)) {
//                     break;
//                }else{
//                $rgb = imagecolorat($im, $x, $y);
//                imagesetpixel($newIm, $x, $y, $rgb);
//                }
//            }
//        }
//        imagepng($newIm, 'newImg1.png');
    }

}

?>
