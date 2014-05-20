<?php


if($_POST['type'] == '4s') {
	$case_w = 650;
	$case_h = 1245;
}
if($_POST['type'] == '4s3d') {
	$case_w = 886;
	$case_h = 1329;	
}
if($_POST['type'] == '5s') {
	$case_w = 650;
	$case_h = 1353;	
}
if($_POST['type'] == '5s3d') {
	$case_w = 886;
	$case_h = 1427;	
}

$photo_w = $case_w / 2;
$photo_h = $case_h / 2;

$new = imagecreatetruecolor($case_w, $case_h);

for($i = 0; $i < 4; $i++)
{
	$path = "colored/".time()."_".rand(100, 500) . ".png";
	$img[$i] = base64_decode(str_replace('data:image/png;base64,', '', $_POST['array'][$i]));
	file_put_contents($path, $img[$i]);
	$im = imagecreatefrompng($path);
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
	if($i == 0) {
		$x = 0; $y = 0;
	}
	if($i == 1) { 
		$x = $photo_w; $y = 0;
	}
	if($i == 2) {
		$x = 0; $y = $photo_h;
		//$crop_y = 200;
	}
	if($i == 3) { 
		$x = $photo_w; $y = $photo_h;
		//$crop_y = 200;
	}
	imagecopyresized($new, $im, $x, $y, $crop, $crop_y, $photo_ratio_w, $photo_h, $size[0], $size[1]);
}

$chester_size = array(112, 170);
$chester_path = '../img/chester.png';


$chester_img = imagecreatefrompng($chester_path);
$chester_margin = $case_w - 190 - $chester_size[0];
//$chester_margin_top = $case_h - $chester_size[1];
$chester_margin_top = 0;
imagecopy($new, $chester_img, $chester_margin, $chester_margin_top, 0, 0, $chester_size[0], $chester_size[1]);

$new_name = $_POST['phone'].".png";
imagepng($new, 'art/'.$new_name);

echo $new_name;

?>