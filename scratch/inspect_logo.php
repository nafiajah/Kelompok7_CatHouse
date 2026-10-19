<?php

$uploadedPath = 'C:/Users/LENOVO/.gemini/antigravity/brain/687046dc-dbae-4500-8d12-75a5044476cf/.user_uploaded/media_1792370429982.png';
$loginLogoPath = 'c:/laragon/www/kelompok-7/public/images/logo.png';
$adminLogoPath = 'c:/laragon/www/kelompok-7/public/images/admin-cat-logo.png';

$imgUploaded = imagecreatefrompng($uploadedPath);
echo "Uploaded: " . imagesx($imgUploaded) . "x" . imagesy($imgUploaded) . "\n";

$imgLogin = imagecreatefrompng($loginLogoPath);
echo "Login Logo: " . imagesx($imgLogin) . "x" . imagesy($imgLogin) . "\n";

$imgAdmin = imagecreatefrompng($adminLogoPath);
echo "Admin Logo: " . imagesx($imgAdmin) . "x" . imagesy($imgAdmin) . "\n";
