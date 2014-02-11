<?php

	/* /backend/sections/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Abteilungen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */
	
	include("../../../config.php");

include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung

if (!($_SESSION['rights']['root']))
	exit();


if(!empty($_POST['save']) && $_POST['save']!="")
	sections();


include(ROOT_LOCATION . "/modules/general/Menu.php");
generateAdminMenu();

	
//Seitenheader
pageHeader("Formular","main");

include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
//Formularmaske
$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",					""),
	array( "seName",	"Name: ", 				"text", 	"40",	"",		"",					""),
	array( "seShort",	"K&uuml;rzel: ",	 	"text",	 	"5",	"",		"",					""),
	array( "teShort",	"Abteilungsleiter: ", 	"dropdown", "5",	"",		$selectTeachers,	""),
	);


$result = selectSection("","");				//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row);		//Formular wird erstellt
}

form_new($fields,false);			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
