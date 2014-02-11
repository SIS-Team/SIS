<?php
	include("../../config.php");
	include(ROOT_LOCATION . "/modules/general/Main.php");

	include(ROOT_LOCATION . "/modules/menu/Main.php");

	if (!$_SESSION['loggedIn']) {
		header("LOCATION: " . RELATIVE_ROOT . "/login/?return=" . urlencode($_SERVER['REQUEST_URI']) . ((isset($_GET['noMobile'])) ? "&noMobile" : ""));
		exit();
	}
		
	$back = RELATIVE_ROOT . "/backend/";
	$headerText = "SIS.Administration";
	$name = $_SESSION['name'];
	
	$buttons[0]['displayed'] = true;
	$buttons[0]['enabled'] = $_SESSION['rights']['root'];
	$buttons[0]['svg'] = ROOT_LOCATION . "/data/images/administration/hours.svg";
	$buttons[0]['text'] = "Zeiten";
	$buttons[0]['url'] = RELATIVE_ROOT . "/backend/administration/hours/";
	$buttons[0]['jsurl'] = RELATIVE_ROOT . "/backend/administration/hours/?js";
	
	$buttons[1]['displayed'] = true;
	$buttons[1]['enabled'] = $_SESSION['rights']['root'];
	$buttons[1]['svg'] = ROOT_LOCATION . "/data/images/administration/timetables.svg";
	$buttons[1]['text'] = "Stundenpläne";
	$buttons[1]['url'] = RELATIVE_ROOT . "/backend/administration/lessons/";
	$buttons[1]['jsurl'] = RELATIVE_ROOT . "/backend/administration/lessons/?js";
	
	$buttons[2]['displayed'] = true;
	$buttons[2]['enabled'] = $_SESSION['rights']['root'];
	$buttons[2]['svg'] = ROOT_LOCATION . "/data/images/administration/teacher.svg";
	$buttons[2]['text'] = "Lehrer";
	$buttons[2]['url'] = RELATIVE_ROOT . "/backend/administration/teachers/";
	$buttons[2]['jsurl'] = RELATIVE_ROOT . "/backend/administration/teachers/?js";
	
	$buttons[3]['displayed'] = true;
	$buttons[3]['enabled'] = $_SESSION['rights']['root'];
	$buttons[3]['svg'] = ROOT_LOCATION . "/data/images/administration/subjects.svg";
	$buttons[3]['text'] = "Fächer";
	$buttons[3]['url'] = RELATIVE_ROOT . "/backend/administration/subjects/";
	$buttons[3]['jsurl'] = RELATIVE_ROOT . "/backend/administration/subjects/?js";
	
	$buttons[4]['displayed'] = true;
	$buttons[4]['enabled'] = $_SESSION['rights']['root'];
	$buttons[4]['svg'] = ROOT_LOCATION . "/data/images/administration/whatever.svg";
	$buttons[4]['text'] = "What Ever";
	$buttons[4]['url'] = RELATIVE_ROOT . "/backend/administration/whatever/";
	$buttons[4]['jsurl'] = RELATIVE_ROOT . "/backend/administration/whatever/?js";
	
	$buttons[5]['displayed'] = true;
	$buttons[5]['enabled'] = $_SESSION['rights']['root'];
	$buttons[5]['svg'] = ROOT_LOCATION . "/data/images/administration/rooms.svg";
	$buttons[5]['text'] = "Räume";
	$buttons[5]['url'] = RELATIVE_ROOT . "/backend/administration/rooms/";
	$buttons[5]['jsurl'] = RELATIVE_ROOT . "/backend/administration/rooms/?js";
	
	$buttons[6]['displayed'] = true;
	$buttons[6]['enabled'] = $_SESSION['rights']['root'];
	$buttons[6]['svg'] = ROOT_LOCATION . "/data/images/administration/classes.svg";
	$buttons[6]['text'] = "Klassen";
	$buttons[6]['url'] = RELATIVE_ROOT . "/backend/administration/classes/";
	$buttons[6]['jsurl'] = RELATIVE_ROOT . "/backend/administration/classes/?js";
	
	$buttons[7]['displayed'] = true;
	$buttons[7]['enabled'] = $_SESSION['rights']['root'];
	$buttons[7]['svg'] = ROOT_LOCATION . "/data/images/administration/sections.svg";
	$buttons[7]['text'] = "Abteilungen";
	$buttons[7]['url'] = RELATIVE_ROOT . "/backend/administration/sections/";
	$buttons[7]['jsurl'] = RELATIVE_ROOT . "/backend/administration/sections/?js";
	
	generateMenu();

?>
