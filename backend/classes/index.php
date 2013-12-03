<?php

	/* /backend/classes.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Klassen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung

if (!($_SESSION['loggedIn'] == true && ($_SESSION['isTeacher'] == true || $_SESSION['cn']=="20090334")))
	die("Nicht berechtigt");

if($_POST['save']!="")
	classes();

//Formularmaske
$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",					""),
	array( "clName", 	"Name: ", 				"text", 	"8",	"",		"",					""),
	array( "seShort", 	"Abteilung: ", 			"dropdown", "5",	"",		$selectSections, 	""),
	array( "teShort",	"Klassenvorstand: ", 	"dropdown",	"",		"",		$selectTeachers, 	""),
	array( "roName", 	"Stammklasse: ", 		"dropdown",	"",		"",		$selectRooms, 		""),
	array( "invisible", "Unsichtbar: ", 		"checkbox",	"",		"",		"",			 		""),		
	);

//Seitenheader
pageHeader("Formular","main");

$sort = "classes.invisible,sections.short,classes.name";
$result = selectClass("",$sort);	//Rückgabewert des Selects


while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row);		//Formular wird erstellt
}

form_new($fields,false);			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
