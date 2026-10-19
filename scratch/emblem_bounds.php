<?php

$src = imagecreatefrompng('c:/laragon/www/kelompok-7/public/images/logo.png');
$w = imagesx($src);

$minX = $w; $maxX = 0; $minY = 377; $maxY = 0;

for ($y = 0; $y < 310; $y++) {
    for ($x = 0; $x < $w; $x++) {
        $rgba = imagecolorat($src, $x, $y);
        $alpha = ($rgba & 0x7F000000) >> 24;
        if ($alpha < 100) {
            if ($x < $minX) $minX = $x;
            if ($x > $maxX) $maxX = $x;
            if ($y < $minY) $minY = $y;
            if ($y > $maxY) $maxY = $y;
        }
    }
}

echo "House emblem bounds: X: $minX to $maxX, Y: $minY to $maxY\n";
echo "Width: " . ($maxX - $minX + 1) . ", Height: " . ($maxY - $minY + 1) . "\n";
