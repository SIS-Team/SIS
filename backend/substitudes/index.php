<?php
	include("../../config.php");
	include(ROOT_LOCATION . "/modules/general/Main.php");
	include(ROOT_LOCATION . "/modules/menu/Main.php");

	if (!$_SESSION['loggedIn']) {
		header("LOCATION: " . RELATIVE_ROOT . "/login/?return=" . urlencode($_SERVER['REQUEST_URI']) . ((isset($_GET['noMobile'])) ? "&noMobile" : ""));
		exit();
	}
		
	$back = RELATIVE_ROOT . "/backend/";
	$headerText = "SIS.Data Inputs";
	$name = $_SESSION['name'];
	
	$buttons[1]['displayed'] = true;
	$buttons[1]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['N'];
	$buttons[1]['svg'] = ROOT_LOCATION . "/data/images/sections/N.svg";
	$buttons[1]['text'] = "Elektronik";
	$buttons[1]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=N";
	$buttons[1]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=N&js";
	
	$buttons[2]['displayed'] = true;
	$buttons[2]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['W'];
	$buttons[2]['svg'] = ROOT_LOCATION . "/data/images/sections/W.svg";
	$buttons[2]['text'] = "Wirtschaft";
	$buttons[2]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=W";
	$buttons[2]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=W&js";
	
	$buttons[5]['displayed'] = true;
	$buttons[5]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['E'];
	$buttons[5]['svg'] = ROOT_LOCATION . "/data/images/sections/E.svg";
	$buttons[5]['text'] = "Elektrotechnik";
	$buttons[5]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=E";
	$buttons[5]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=E&js";
	
	$buttons[6]['displayed'] = true;
	$buttons[6]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['M'];
	$buttons[6]['svg'] = ROOT_LOCATION . "/data/images/sections/M.svg";
	$buttons[6]['text'] = "Maschinenbau";
	$buttons[6]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=M";
	$buttons[6]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=M&js";
	
	generateMenu();

?>
