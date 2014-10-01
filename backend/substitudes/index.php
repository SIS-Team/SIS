<?php
	require("../../config.php");
	require(ROOT_LOCATION . "/modules/general/Main.php");
	require(ROOT_LOCATION . "/modules/menu/Main.php");

	if (!$_SESSION['loggedIn']) {
		header("LOCATION: " . RELATIVE_ROOT . "/login/?return=" . urlencode($_SERVER['REQUEST_URI']) . ((isset($_GET['noMobile'])) ? "&noMobile&noJS" : ""));
		exit();
	}
		
	$back = RELATIVE_ROOT . "/backend/";
	$headerText = "SIS.Data Inputs";
	$name = $_SESSION['name'];
	
	$buttons[1]['displayed'] = true;
	$buttons[1]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['EL'];
	$buttons[1]['svg'] = ROOT_LOCATION . "/data/images/sections/EL.svg";
	$buttons[1]['text'] = "Elektronik";
	$buttons[1]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=EL";
	$buttons[1]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=EL&js";
	
	$buttons[2]['displayed'] = true;
	$buttons[2]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['WI'];
	$buttons[2]['svg'] = ROOT_LOCATION . "/data/images/sections/WI.svg";
	$buttons[2]['text'] = "Wirtschaft";
	$buttons[2]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=WI";
	$buttons[2]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=WI&js";
	
	$buttons[5]['displayed'] = true;
	$buttons[5]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['ET'];
	$buttons[5]['svg'] = ROOT_LOCATION . "/data/images/sections/ET.svg";
	$buttons[5]['text'] = "Elektrotechnik";
	$buttons[5]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=ET";
	$buttons[5]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=ET&js";
	
	$buttons[6]['displayed'] = true;
	$buttons[6]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['MB'];
	$buttons[6]['svg'] = ROOT_LOCATION . "/data/images/sections/MB.svg";
	$buttons[6]['text'] = "Maschinenbau";
	$buttons[6]['url'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=MB";
	$buttons[6]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/form/?section=MB&js";
	
	generateMenu();

?>
