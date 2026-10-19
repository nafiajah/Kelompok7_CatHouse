<?php

$uploadedPath = 'C:/Users/LENOVO/.gemini/antigravity/brain/687046dc-dbae-4500-8d12-75a5044476cf/.user_uploaded/media_1792370429982.png';
$src = imagecreatefrompng($uploadedPath);

// Let's crop the icon part (approx x: 10 to 50, y: 5 to 50)
$w = imagesx($src);
$h = imagesy($src);

// Let's save a crop of the left side where the icon is
$icon = imagecrop($src, ['x' => 10, 'y' => 10, 'width' => 40, 'height' => 40]);
if ($icon !== false) {
    imagepng($icon, __DIR__ . '/cropped_icon.png');
    echo "Cropped icon saved.\n";
}
