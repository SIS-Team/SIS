<?php

function ifNotLoggedInGotoLogin(){ //wenn nicht angemeldet zu gegebener Seite weiterleiten
	if(!($_SESSION['loggedIn'])){
		header("LOCATION: " . RELATIVE_ROOT . "/");
		exit();
	}
}

function getPermission(){ //gibt die Berechtigungsstufe zurück
	$isAdmin = $_SESSION['rights']['E'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['M'];
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
	if($_SESSION['rights']['E']) return 'E';
	if($_SESSION['rights']['N']) return 'N';
	if($_SESSION['rights']['W']) return 'W';
	if($_SESSION['rights']['M']) return 'M';
	else return false;
}

// maskiert alle nicht-ascii-Zeichen im Parameter 
function sanitize($s) {
	return preg_replace('/[^a-zA-Z0-9_.]/', '_', $s);
}

?>