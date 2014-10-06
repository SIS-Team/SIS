<?php
	require("../config.php");
	require(ROOT_LOCATION . "/modules/general/Main.php");

	require(ROOT_LOCATION . "/modules/menu/Main.php");

	if (!$_SESSION['loggedIn']) {
		header("LOCATION: " . RELATIVE_ROOT . "/login/?return=" . urlencode($_SERVER['REQUEST_URI']) . ((isset($_GET['noMobile'])) ? "&noMobile&noJS" : ""));
		exit();
	}
		
	$back = RELATIVE_ROOT . "/";
	$headerText = "SIS.Data Inputs";
	$name = $_SESSION['name'];
	
	$buttons[1]['displayed'] = true;
	$buttons[1]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights'][SECTION_E] || $_SESSION['rights'][SECTION_W] || $_SESSION['rights'][SECTION_N] || $_SESSION['rights'][SECTION_M];
	$buttons[1]['svg'] = ROOT_LOCATION . "/data/images/data-input/monitors.svg";
	$buttons[1]['text'] = "Monitore verwalten";
	$buttons[1]['url'] = RELATIVE_ROOT . "/backend/monitors/";
	$buttons[1]['jsurl'] = RELATIVE_ROOT . "/backend/monitors/?js";

	$buttons[2]['displayed'] = true;
	$buttons[2]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights'][SECTION_N] || $_SESSION['rights'][SECTION_W] || $_SESSION['rights'][SECTION_E] || $_SESSION['rights'][SECTION_M];
	$buttons[2]['svg'] = ROOT_LOCATION . "/data/images/data-input/absentees.svg";
	$buttons[2]['text'] = "Fehlende eintragen";
	$buttons[2]['url'] = RELATIVE_ROOT . "/backend/absentees/?noJS" . (isset($_GET['noMobile']) ? "&noMobile" : "");
	$buttons[2]['jsurl'] = RELATIVE_ROOT . "/backend/absentees/?js&menu";

	$buttons[3]['displayed'] = true;
	$buttons[3]['enabled'] = $buttons[2]['enabled'];
	$buttons[3]['svg'] = ROOT_LOCATION . "/data/images/data-input/substitudes.svg";
	$buttons[3]['text'] = "Supplierung anlegen";

	$add = "";
	if (!$_SESSION['rights']['root'])
		$add .= "form/";

	if ($_SESSION['rights'][SECTION_N])
		$add .= "?section=" . SECTION_N;
	else if ($_SESSION['rights'][SECTION_W])
		$add .= "?section=" . SECTION_W;
	else if ($_SESSION['rights'][SECTION_M])
		$add .= "?section=" . SECTION_M;
	else if ($_SESSION['rights'][SECTION_E])
		$add .= "?section=" . SECTION_E;

	$buttons[3]['url'] = RELATIVE_ROOT . "/backend/substitudes/" . $add . (empty($add) ? "?" : "&") . "noJS" . (isset($_GET['noMobile']) ? "&noMobile" : "");
	$buttons[3]['jsurl'] = RELATIVE_ROOT . "/backend/substitudes/" . $add . (empty($add) ? "?" : "&") . "js" . ((strpos($add, "form") === false) ? "&menu" : "");

	$buttons[5]['displayed'] = true;
	$buttons[5]['enabled'] = $_SESSION['rights']['root'] || $_SESSION['rights'][SECTION_N] || $_SESSION['rights'][SECTION_W] || $_SESSION['rights'][SECTION_E] || $_SESSION['rights'][SECTION_M] || $_SESSION['rights']['news'];
	$buttons[5]['svg'] = ROOT_LOCATION . "/data/images/data-input/news.svg";
	$buttons[5]['text'] = "News hinzufügen";
	$buttons[5]['url'] = RELATIVE_ROOT . "/backend/news/";
	$buttons[5]['jsurl'] = RELATIVE_ROOT . "/backend/news/?js";
	
	$buttons[6]['displayed'] = true;	
	$buttons[6]['enabled'] = $_SESSION['rights']['root'];
	$buttons[6]['svg'] = ROOT_LOCATION . "/data/images/data-input/administration.svg";	
	$buttons[6]['text'] = "Administration";		
	$buttons[6]['url'] = RELATIVE_ROOT . "/backend/administration/?noJS" . (isset($_GET['noMobile']) ? "&noMobile" : "");
	$buttons[6]['jsurl'] = RELATIVE_ROOT . "/backend/administration/?js&menu";

	generateMenu();

?>
