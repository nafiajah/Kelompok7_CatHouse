<?php

$uploaded = imagecreatefrompng('C:/Users/LENOVO/.gemini/antigravity/brain/687046dc-dbae-4500-8d12-75a5044476cf/.user_uploaded/media_1792370429982.png');

// In media_1792370429982.png:
// Top-left of the icon is around x=20, y=18
// Let's sample a few points in the cream background (e.g. top-left of the cream area, x=18, y=18)
$colors = [];
for ($y = 12; $y <= 45; $y++) {
    for ($x = 12; $x <= 45; $x++) {
        $rgb = imagecolorat($uploaded, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        // Looking for the cream background (light yellowish/cream)
        if ($r > 230 && $g > 230 && $b > 200) {
            $hex = sprintf("#%02X%02X%02X", $r, $g, $b);
            $colors[$hex] = ($colors[$hex] ?? 0) + 1;
        }
    }
}
arsort($colors);
echo "Cream colors sampled:\n";
print_r(array_slice($colors, 0, 10));
