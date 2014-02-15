<?php

	/* /backend/classes/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Klassen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */

include("../../../config.php");

include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verf�gung

if (!($_SESSION['rights']['root']))
	exit();

if(!empty($_POST['save']) && $_POST['save']!="")
	classes();

//Seitenheader
pageHeader("Klassen","main");

$dropDown=array("Sections","Teachers","Rooms");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen f�r die Dropdownmen�s zur Verf�gung

//Formularmaske
$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",					""),
	array( "clName", 	"Name: ", 				"text", 	"8",	"",		"",					"required"),
	array( "seShort", 	"Abteilung: ", 			"dropdown", "5",	"",		$selectSections, 	"required"),
	array( "teShort",	"Klassenvorstand: ", 	"dropdown",	"",		"",		$selectTeachers, 	""),
	array( "roName", 	"Stammklasse: ", 		"dropdown",	"",		"",		$selectRooms, 		""),
	array( "invisible", "Unsichtbar: ", 		"checkbox",	"",		"",		"",			 		""),		
	);
	
	
$sort = "classes.invisible,sections.short,classes.name";
$result = selectClass("",$sort);	//R�ckgabewert des Selects


while ($row = mysql_fetch_array($result)){	//F�gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verf�gung steht
	form_new($fields,$row,"Klassen");		//Formular wird erstellt
}

form_new($fields,false,"Klassen");			//Formular f�r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
