<?php

function ifNotLoggedInGotoLogin(){ //wenn nicht angemeldet zu gegebener Seite weiterleiten
	if(!($_SESSION['loggedIn'])){
		header("LOCATION: " . RELATIVE_ROOT . "/");
		exit();
	}
}

function getPermission(){ //gibt die Berechtigungsstufe zurück
	$isAdmin = $_SESSION['rights'][SECTION_E] || $_SESSION['rights'][SECTION_N] || $_SESSION['rights'][SECTION_W] || $_SESSION['rights'][SECTION_M];
	if(($_SESSION['rights']['root'])){
 			return "root";
	}
	else if($isAdmin){
		return "admin";
	} 
	else if($_SESSION['rights']['news']){
		return "news";
	}
	else return false;			
}

function noPermission(){ //wenn keine Berechtigung vorhanden -> weiterleitung
 	header("Location: ".RELATIVE_ROOT."/");
	exit();
 }

function getAdminSection(){ //Abteilung des Administrators abfragen
	if($_SESSION['rights'][SECTION_E]) return SECTION_E;
	if($_SESSION['rights'][SECTION_N]) return SECTION_N;
	if($_SESSION['rights'][SECTION_W]) return SECTION_W;
	if($_SESSION['rights'][SECTION_M]) return SECTION_M;
	else return false;
}

// maskiert alle nicht-ascii-Zeichen im Parameter 
function sanitize($s) {
	return preg_replace('/[^a-zA-Z0-9_.]/', '_', $s);
}

?>
