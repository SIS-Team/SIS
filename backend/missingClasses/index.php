<?php

	/* /backend/missingClasses.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Fehlenden Klassen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */

include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung

//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "clName", 	"Klasse: ", 		"dropdown", "5",	"",		$selectClasses,		""),
	array( "startDay", 	"Starttag: ",		"text", 	"10",	"",		"",					""),
	array( "startHour", "Start-Stunde: ",	"text",		"5",	"",		"",					""),
	array( "endDay", 	"Endtag: ", 		"text",		"10",	"",		"",					""),
	array( "endHour", 	"End-Stunde: ", 	"text",		"5",	"",		"",					""),
	array( "sure", 		"Sicher? ", 		"checkbox",	"",		"",		"",					""),
	array( "reason", 	"Grund: ", 			"text",		"30",	"",		"",					""),
	);

//Seitenheader
pageHeader("Formular","main");

$result = selectMissingClass("","");	//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row);		//Formular wird erstellt	
}

form_new($fields,false);			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
