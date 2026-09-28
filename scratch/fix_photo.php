<?php
$srcPath = 'c:/Users/UserPC/Kelompok7_CatHouse/public/images/cat-photo.jpg';
$outPngPath = 'c:/Users/UserPC/Kelompok7_CatHouse/public/images/cat-photo.png';
$outJpgPath = 'c:/Users/UserPC/Kelompok7_CatHouse/public/images/cat-photo.jpg';

if (!file_exists($srcPath)) {
    echo "Source image not found\n";
    exit;
}

$src = imagecreatefromjpeg($srcPath);
$w = imagesx($src);
$h = imagesy($src);

// Create PNG with alpha transparency
$png = imagecreatetruecolor($w, $h);
imagealphablending($png, false);
imagesavealpha($png, true);

// Create JPG with cream background (#FAF7F2 -> R=250, G=247, B=242)
$jpg = imagecreatetruecolor($w, $h);
$creamColor = imagecolorallocate($jpg, 250, 247, 242);
$transparentColor = imagecolorallocatealpha($png, 0, 0, 0, 127);

imagefill($png, 0, 0, $transparentColor);
imagefill($jpg, 0, 0, $creamColor);

// For each row y from 0 to h-1, scan from right (x = w-1) towards left
for ($y = 0; $y < $h; $y++) {
    // Find the boundary of the black curve from the right
    $inBlackBorder = true;
    for ($x = $w - 1; $x >= 0; $x--) {
        $rgb = imagecolorat($src, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        // Check if pixel is black background (R, G, B all low)
        $isBlack = ($r < 30 && $g < 30 && $b < 30);

        if ($inBlackBorder && $isBlack) {
            // Set transparent in PNG, cream in JPG
            imagesetpixel($png, $x, $y, $transparentColor);
            imagesetpixel($jpg, $x, $y, $creamColor);
        } else {
            // Once we hit non-black (the photo content), keep remaining pixels as photo content
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

echo "Successfully processed cat-photo image! Saved transparent PNG and cream-filled JPG.\n";
