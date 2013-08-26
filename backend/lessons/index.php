<?php

	/* /backend/lessons.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Unterrichtsstunden
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verf�gung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen f�r die Dropdownmen�s zur Verf�gung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");			//Bindet die Datenbank ein
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung

//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "clName", 	"Klasse: ", 		"dropdown", "8",	"",		$selectClasses,		""),
	array( "roName",	"Raum: ", 			"dropdown", "8",	"",		$selectRooms,		""),
	array( "teShort", 	"Lehrer: ",	 		"dropdown",	"5",	"",		$selectTeachers,	""),
	array( "suShort", 	"Fach: ", 			"dropdown",	"5",	"",		$selectSubjects,	""),
	array( "daShort",	"Tag: ", 			"dropdown",	"5",	"",		$selectDays,		""),
	array( "startHour",	"Stundenbeginn: ", 	"text",		"5",	"",		"",					""),
	array( "endHour", 	"Stundenende: ", 	"text",		"5",	"",		"",					""),
	);

//Seitenheader
pageHeader("Formular","main");

$result = selectLesson("","");	//R�ckgabewert des Selects

while ($row = mysql_fetch_array($result)){	//F�gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verf�gung steht
	form_new($fields,$row);		//Formular wird erstellt
}

form_new($fields,false);			//Formular f�r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
