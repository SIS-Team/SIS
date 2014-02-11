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
	$buttons[1]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M'];
	$buttons[1]['svg'] = ROOT_LOCATION . "/data/images/absentees/teachers.svg";
	$buttons[1]['text'] = "Fehlende Lehrer";
	$buttons[1]['url'] = RELATIVE_ROOT . "/backend/absentees/teachers/";
	$buttons[1]['jsurl'] = RELATIVE_ROOT . "/backend/absentees/teachers/?js";

	$buttons[2]['displayed'] = true;
	$buttons[2]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M'];
	$buttons[2]['svg'] = ROOT_LOCATION . "/data/images/absentees/classes.svg";
	$buttons[2]['text'] = "Fehlende Klassen";
	$buttons[2]['url'] = RELATIVE_ROOT . "/backend/absentees/classes/";
	$buttons[2]['jsurl'] = RELATIVE_ROOT . "/backend/absentees/classes/?js";

	generateMenu();

?>
