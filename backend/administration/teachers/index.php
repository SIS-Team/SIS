<?php

	/* /backend/teachers/index.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Lehrer
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */

include("../../../config.php");

include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verf�gung

if (!($_SESSION['rights']['root']))
	exit();


if(!empty($_POST['save']) && $_POST['save']!="")
	teachers();


//Seitenheader
pageHeader("Lehrer","main");

$dropDown=array("Sections");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
//Formularmaske
$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",					""),
	array( "teName", 	"Name: ", 				"text", 	"30",	"",		"",					"required"),
	array( "teShort", 	"K&uuml;rzel: ", 		"text", 	"5",	"",		"",					"required"),
	array( "display", 	"Kurzname: ", 			"text",		"20",	"",		"",					"required"),
	array( "seShort",	"Stammabteilung: ", 	"dropdown",	"5",	"",		$selectSections,	""),
	array( "invisible", "Unsichtbar: ", 		"checkbox",	"",		"",		"",			 		""),			
	);


$sort = "teachers.invisible,sections.short,teachers.short";
$result = selectTeacher("",$sort);				//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row,"Lehrer");		//Formular wird erstellt
}

form_new($fields,false,"Lehrer");			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
