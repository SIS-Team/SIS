<?php

	/* /backend/teachers.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Lehrer
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */

include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verf�gung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelect.php");		//Stellt die Listen f�r die Dropdownmen�s zur Verf�gung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");			//Bindet die Datenbank ein
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung

//Formularmaske
$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",					""),
	array( "teName", 	"Name: ", 				"text", 	"25",	"",		"",					""),
	array( "teShort", 	"K&uuml;rzel: ", 		"text", 	"5",	"",		"",					""),
	array( "display", 	"Kurzname: ", 			"text",		"20",	"",		"",					""),
	array( "seShort",	"Stammabteilung: ", 	"dropdown",	"5",	"",		$selectSections,	""),	
	);

//Seitenheader
pageHeader("Formular","main");


$result = selectTeacher("","");				//R�ckgabewert des Selects

while ($row = mysql_fetch_array($result)){	//F�gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verf�gung steht
	form_new("get","",$fields,$row);		//Formular wird erstellt
}

form_new("get","",$fields,false);			//Formular f�r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
