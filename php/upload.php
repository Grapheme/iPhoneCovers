<?php

$uploaddir = '../uploads/';
$name = time() . ".jpg";
$uploadfile = $uploaddir . $name;

if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
    
} else {
    echo "Ошибка!\n";
}

$image = imagecreatefromjpeg($uploadfile);
$exif = exif_read_data($uploadfile);
if(!empty($exif['Orientation'])) {
    switch($exif['Orientation']) {
        case 8:
            $image = imagerotate($image,90,0);
            break;
        case 3:
            $image = imagerotate($image,180,0);
            break;
        case 6:
            $image = imagerotate($image,-90,0);
            break;
    }
}
imagejpeg($image, $uploadfile);

$case_w = 886;
$case_h = 1427; 

$photo_w = $case_w / 2;
$photo_h = $case_h / 2;

$new = imagecreatetruecolor($photo_w, $photo_h);

for($i = 0; $i < 4; $i++)
{
    $path = $uploadfile;
    $img = $uploadfile;
    $im = imagecreatefromjpeg($path);
    //$im = imagerotate($img, 90, 0);
    //file_put_contents($path, $im);
    $size = getimagesize($path);
    $photo_ratio_h = ( ($photo_w * 100) / $size[0] ) * ( $size[1] / 100 );
    $photo_ratio_w = ( ($photo_h * 100) / $size[1] ) * ( $size[0] / 100 );

    /////

    $crop_first = $photo_ratio_w - $photo_w;
    $perc = ($crop_first * 100) / $photo_ratio_w;
    $crop = ( ($size[0] * $perc) / 100 ) / 2;

    /////

    $crop_y = 0;
    $x = 0; $y = 0;

    imagecopyresized($new, $im, $x, $y, $crop, $crop_y, $photo_ratio_w, $photo_h, $size[0], $size[1]);
}
imagejpeg($new, $uploadfile);

print_r($name);

?>