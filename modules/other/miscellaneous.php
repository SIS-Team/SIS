<?php

function ifNotLoggedInGotoLogin(){ //wenn nicht angemeldet zu gegebener Seite weiterleiten
	if(!($_SESSION['loggedIn'])){
		header("LOCATION: " . RELATIVE_ROOT . "/");
		exit();
	}
}

function getPermission(){ //gibt die Berechtigungsstufe zurück
	$isAdmin = $_SESSION['rights']['ET'] || $_SESSION['rights']['EL'] || $_SESSION['rights']['WI'] || $_SESSION['rights']['MB'];
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
	if($_SESSION['rights']['ET']) return 'ET';
	if($_SESSION['rights']['EL']) return 'EL';
	if($_SESSION['rights']['WI']) return 'WI';
	if($_SESSION['rights']['MB']) return 'MB';
	else return false;
}

// maskiert alle nicht-ascii-Zeichen im Parameter 
function sanitize($s) {
	return preg_replace('/[^a-zA-Z0-9_.]/', '_', $s);
}

?>