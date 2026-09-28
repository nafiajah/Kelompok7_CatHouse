<?php
$srcPath = 'c:/Users/UserPC/Kelompok7_CatHouse/public/images/cat-photo.jpg';
$outPngPath = 'c:/Users/UserPC/Kelompok7_CatHouse/public/images/cat-photo.png';
$outJpgPath = 'c:/Users/UserPC/Kelompok7_CatHouse/public/images/cat-photo.jpg';

$src = imagecreatefromjpeg($srcPath);
$w = imagesx($src);
$h = imagesy($src);

$png = imagecreatetruecolor($w, $h);
imagealphablending($png, false);
imagesavealpha($png, true);

$jpg = imagecreatetruecolor($w, $h);

$transparentColor = imagecolorallocatealpha($png, 0, 0, 0, 127);
$creamColor = imagecolorallocate($jpg, 250, 247, 242);

imagefill($png, 0, 0, $transparentColor);
imagefill($jpg, 0, 0, $creamColor);

$creamR = 250;
$creamG = 247;
$creamB = 242;

// Step 1: Detect raw black boundary
$boundaries = [];
for ($y = 0; $y < $h; $y++) {
    $edgeX = 0;
    for ($x = $w - 1; $x >= 0; $x--) {
        $rgb = imagecolorat($src, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        $isDarkBg = ($r < 80 && $g < 70 && $b < 70) || (($r + $g + $b) / 3 < 75);

        if (!$isDarkBg) {
            $edgeX = $x;
            break;
        }
    }
    $boundaries[$y] = $edgeX;
}

// Smooth boundary array & pull back 4 pixels to shave off all dark fringing
$smoothedBoundaries = [];
$window = 4;
for ($y = 0; $y < $h; $y++) {
    $sum = 0;
    $count = 0;
    for ($dy = -$window; $dy <= $window; $dy++) {
        $ny = $y + $dy;
        if ($ny >= 0 && $ny < $h) {
            $sum += $boundaries[$ny];
            $count++;
        }
    }
    $smoothedBoundaries[$y] = intval($sum / $count) - 4;
}

// Step 2: Render PNG & JPG
for ($y = 0; $y < $h; $y++) {
    $cutoff = $smoothedBoundaries[$y];
    for ($x = 0; $x < $w; $x++) {
        if ($x > $cutoff) {
            imagesetpixel($png, $x, $y, $transparentColor);
            imagesetpixel($jpg, $x, $y, $creamColor);
        } else {
            $rgb = imagecolorat($src, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            $dist = $cutoff - $x;
            if ($dist < 6) {
                $alpha = intval(127 * (1 - ($dist / 6)));
                if ($alpha > 127) $alpha = 127;
                if ($alpha < 0) $alpha = 0;

                $factor = $dist / 6;
                $finalR = intval($creamR * (1 - $factor) + $r * $factor);
                $finalG = intval($creamG * (1 - $factor) + $g * $factor);
                $finalB = intval($creamB * (1 - $factor) + $b * $factor);

                $pxColorPng = imagecolorallocatealpha($png, $finalR, $finalG, $finalB, $alpha);
                $pxColorJpg = imagecolorallocate($jpg, $finalR, $finalG, $finalB);

                imagesetpixel($png, $x, $y, $pxColorPng);
                imagesetpixel($jpg, $x, $y, $pxColorJpg);
            } else {
                $pxColorPng = imagecolorallocatealpha($png, $r, $g, $b, 0);
                $pxColorJpg = imagecolorallocate($jpg, $r, $g, $b);

                imagesetpixel($png, $x, $y, $pxColorPng);
                imagesetpixel($jpg, $x, $y, $pxColorJpg);
            }
        }
    }
}

imagepng($png, $outPngPath);
imagejpeg($jpg, $outJpgPath, 95);

echo "Super smooth processing complete for PNG and JPG!\n";
