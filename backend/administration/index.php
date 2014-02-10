<?php
	include("../../config.php");
	include(ROOT_LOCATION . "/modules/general/Main.php");

	include(ROOT_LOCATION . "/modules/menu/Main.php");

	if (!$_SESSION['loggedIn']) {
		header("LOCATION: " . RELATIVE_ROOT . "/login/?return=" . urlencode($_SERVER['REQUEST_URI']) . ((isset($_GET['noMobile'])) ? "&noMobile" : ""));
		exit();
	}
		
	$back = RELATIVE_ROOT . "/";
	$headerText = "SIS.Administration";
	$name = $_SESSION['name'];
	
	$buttons[0]['displayed'] = true;
	$buttons[0]['enabled'] = $_SESSION['rights']['root'];
	$buttons[0]['svg'] = ROOT_LOCATION . "/data/images/administration/classes.svg";
	$buttons[0]['text'] = "Klassen";
	$buttons[0]['url'] = RELATIVE_ROOT . "/backend/administration/classes/";
	$buttons[0]['jsurl'] = RELATIVE_ROOT . "/backend/administration/classes/?js";

	$buttons[1]['displayed'] = true;
	$buttons[1]['enabled'] = $_SESSION['rights']['root'];
	$buttons[1]['svg'] = ROOT_LOCATION . "/data/images/administration/hours.svg";
	$buttons[1]['text'] = "Zeiten";
	$buttons[1]['url'] = RELATIVE_ROOT . "/backend/administration/hours/";
	$buttons[1]['jsurl'] = RELATIVE_ROOT . "/backend/administration/hours/?js";
	
	$buttons[2]['displayed'] = true;
	$buttons[2]['enabled'] = $_SESSION['rights']['root'];
	$buttons[2]['svg'] = ROOT_LOCATION . "/data/images/administration/teacher.svg";
	$buttons[2]['text'] = "Lehrer";
	$buttons[2]['url'] = RELATIVE_ROOT . "/backend/administration/teachers/";
	$buttons[2]['jsurl'] = RELATIVE_ROOT . "/backend/administration/teachers/?js";
	
	$buttons[6]['displayed'] = true;
	$buttons[6]['enabled'] = $_SESSION['rights']['root'];
	$buttons[6]['svg'] = ROOT_LOCATION . "/data/images/administration/timetables.svg";
	$buttons[6]['text'] = "Stundenpläne";
	$buttons[6]['url'] = RELATIVE_ROOT . "/backend/administration/lessons/";
	$buttons[6]['jsurl'] = RELATIVE_ROOT . "/backend/administration/lessons/?js";
	
	generateMenu();

?>
