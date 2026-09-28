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
$creamColor = imagecolorallocate($jpg, 250, 247, 242);
$transparentColor = imagecolorallocatealpha($png, 0, 0, 0, 127);

imagefill($png, 0, 0, $transparentColor);
imagefill($jpg, 0, 0, $creamColor);

for ($y = 0; $y < $h; $y++) {
    $inBlackBorder = true;
    for ($x = $w - 1; $x >= 0; $x--) {
        $rgb = imagecolorat($src, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        $avg = ($r + $g + $b) / 3;

        // Threshold dark background pixels (black border)
        if ($inBlackBorder && ($avg < 55 || ($r < 60 && $g < 50 && $b < 50))) {
            imagesetpixel($png, $x, $y, $transparentColor);
            imagesetpixel($jpg, $x, $y, $creamColor);
        } else {
            $inBlackBorder = false;
            $colorPng = imagecolorallocatealpha($png, $r, $g, $b, 0);
            $colorJpg = imagecolorallocate($jpg, $r, $g, $b);
            imagesetpixel($png, $x, $y, $colorPng);
            imagesetpixel($jpg, $x, $y, $colorJpg);
        }
    }
}

imagepng($png, $outPngPath);
imagejpeg($jpg, $outJpgPath, 95);

echo "Refined alpha photo processing complete!\n";
