<?php

$src = imagecreatefrompng('c:/laragon/www/kelompok-7/public/images/logo.png');
$w = imagesx($src);
$h = imagesy($src);

// Let's find bounding box of non-transparent pixels, and inspect colors
$minX = $w; $maxX = 0; $minY = $h; $maxY = 0;

for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < $w; $x++) {
        $rgba = imagecolorat($src, $x, $y);
        $alpha = ($rgba & 0x7F000000) >> 24;
        if ($alpha < 127) {
            if ($x < $minX) $minX = $x;
            if ($x > $maxX) $maxX = $x;
            if ($y < $minY) $minY = $y;
            if ($y > $maxY) $maxY = $y;
        }
    }
}

echo "Overall Content bounds: X: $minX to $maxX, Y: $minY to $maxY\n";

// Let's check where the text "CAT HOUSE" starts
// The text is reddish brown. Let's find where the house ends and text begins.
for ($y = $minY; $y <= $maxY; $y++) {
    $hasColor = false;
    $isRedText = false;
    for ($x = $minX; $x <= $maxX; $x++) {
        $rgba = imagecolorat($src, $x, $y);
        $alpha = ($rgba & 0x7F000000) >> 24;
        if ($alpha < 100) {
            $r = ($rgba >> 16) & 0xFF;
            $g = ($rgba >> 8) & 0xFF;
            $b = $rgba & 0xFF;
            // Check if this row has green/teal roof or pink wall
            if ($g > 100 && $b > 100) { // teal
                $hasTeal = true;
            }
            if ($r > 150 && $g < 100 && $b < 100) { // red text
                $isRedText = true;
            }
        }
    }
    if ($isRedText && !isset($textStartY)) {
        $textStartY = $y;
    }
    if (!$isRedText && isset($textStartY) && !isset($textEndY)) {
        // ...
    }
}

echo "Text 'CAT HOUSE' starts around Y: " . ($textStartY ?? 'none') . "\n";
