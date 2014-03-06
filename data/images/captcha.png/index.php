<?php
	@session_start();
	include("../../../config.php");

	$letters = "ABCDEFGHIJKLMNOPQRSTUVWgqrtimnaeh";
	$length = 4;
	$fontsize = 20;
	
	$offset = 10;
	
	$fieldWidth = 30;
	$margin = $offset + 5;
	
	$imagesize = array();
	$imagesize['x'] = $fieldWidth * $length + 2 * $margin;
	$imagesize['y'] = 50;
	
	$fonts = array();
	// add your fonts here
	$fonts[] = ROOT_LOCATION."/data/fonts/averia.ttf";
	$fonts[] = ROOT_LOCATION."/data/fonts/bbc.ttf";
	$fonts[] = ROOT_LOCATION."/data/fonts/bybsy.ttf";
	$fonts[] = ROOT_LOCATION."/data/fonts/gtw.ttf";
	$fonts[] = ROOT_LOCATION."/data/fonts/newscycle.ttf";
	//print_r($fonts);
	$numberOfBackgroundLines = 50;
	$thicknesOfBackgroundLines = 2;
	$numberOfFrontLines = 2;
	$thicknesOfFrontLines = 3;
	
	$captcha = array();
	for ($i = 0; $i < $length; $i++) {
		$random = rand(0, strlen($letters) - 1);
		$captcha[$i] = substr($letters, $random, 1);
	}
	
	$rotations = array();
	for ($i = 0; $i < $length; $i++) {
		$random = rand(- $offset, $offset);
		$rotations[$i] = $random;
	}
	
	$positions = array();
	for ($i = 0; $i < $length; $i++) {
		$random = rand(- $offset, $offset);
		$positions[$i] = array();
		$positions[$i]['x'] = $random;
		$random = rand(- $offset, $offset);
		$positions[$i]['y'] = $random;
	}
	
	$lines = array();
	for ($i = 0; $i < $numberOfBackgroundLines; $i++) {
		$lines[$i] = array();
		$lines[$i][0] = rand(0, $imagesize['x']);
		$lines[$i][1] = rand(0, $imagesize['y']);
		$lines[$i][2] = rand(0, $imagesize['x']);
		$lines[$i][3] = rand(0, $imagesize['y']);
		$lines[$i][4] = $thicknesOfBackgroundLines;
	}
	for ($i = $numberOfBackgroundLines; $i < $numberOfBackgroundLines + $numberOfFrontLines; $i++) {
		$lines[$i] = array();
		$lines[$i][0] = rand(0, $imagesize['x']);
		$lines[$i][1] = rand(0, $imagesize['y']);
		$lines[$i][2] = rand(0, $imagesize['x']);
		$lines[$i][3] = rand(0, $imagesize['y']);
		$lines[$i][4] = $thicknesOfFrontLines;
	}
	
	$font = $fonts[rand(0, count($fonts) - 1)];
	
	$image = imagecreatetruecolor($imagesize['x'], $imagesize['y']);
	
	for ($i = 0; $i < $numberOfBackgroundLines; $i++) {
		imagesetthickness($image, $lines[$i][4]);
		$random = rand(0, 128);
		$color = imagecolorallocate($image, $random, 127 - $random, $random);
		imageline($image, $lines[$i][0], $lines[$i][1], $lines[$i][2], $lines[$i][3], $color);
	}
	
	$random = rand(0, 255);
	$fontColor = imagecolorallocate($image, $random, 255, 255 - $random);
	
	for ($i = 0; $i < $length; $i++) {
		imagettftext($image, $fontsize, $rotations[$i], $offset + $i * $fieldWidth + $positions[$i]['x'], $imagesize['y'] - $fontsize / 2 + $positions[$i]['y'], $fontColor, $font, $captcha[$i]);
	}
	
	for ($i = $numberOfBackgroundLines; $i < $numberOfBackgroundLines + $numberOfFrontLines; $i++) {
		imagesetthickness($image, $lines[$i][4]);
		$random = rand(0, 128);
		$color = imagecolorallocate($image, $random, 127 - $random, $random);
		imageline($image, $lines[$i][0], $lines[$i][1], $lines[$i][2], $lines[$i][3], $color);
	}
	
	// Note: only one captcha code at a time can be used
	$_SESSION['captcha'] = array();
	$_SESSION['captcha']['code'] = implode("",$captcha);
	$_SESSION['captcha']['time'] = time();
	$_SESSION['captcha']['used'] = false;

	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-type: image/png");

	imagepng($image);
	imagedestroy($image);
?>
