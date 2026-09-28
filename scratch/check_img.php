<?php
$imgPath = 'c:/Users/UserPC/Kelompok7_CatHouse/public/images/cat-photo.jpg';
if (!file_exists($imgPath)) {
    echo "Image not found\n";
    exit;
}

$im = imagecreatefromjpeg($imgPath);
$w = imagesx($im);
$h = imagesy($im);

echo "Width: $w, Height: $h\n";

// Sample some pixels on the right side to see their exact RGB values
for ($y = 0; $y < $h; $y += intval($h / 10)) {
    $rgb = imagecolorat($im, $w - 10, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    echo "Pixel at ($w-10, $y): R=$r, G=$g, B=$b\n";
}
