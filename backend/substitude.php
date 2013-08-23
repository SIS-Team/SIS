<?php

	/* /backend/substitude.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Supplierungen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");

$selectTeachers = array(
	array("HJ", 	""),
	array("XH", 	""),
	array("Test3", 	""),
	);

$selectRooms = array(
	array("I164", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);

$selectSubjects = array(
	array("TKHF", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);


$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "suShort", 	"Fach: ", 			"dropdown", "8",	"",		$selectSubjects,	""),
	array( "teShort", 	"Supplierlehrer: ",	"dropdown", "5",	"",		$selectTeachers,	""),
	array( "time", 		"Datum: ",			"text",		"10",	"",		"",					""),
	array( "roName",	"Raum: ", 			"dropdown",	"8",	"",		$selectRooms,		""),
	array( "startHour", "Start-Stunde: ", 	"text",		"5",	"",		"",					""),
	array( "endHour",	"End-Stunde: ",	 	"text",		"4",	"",		"",					""),
	array( "hidden",	"Ausblednen? ", 	"checkbox",	"",		"",		"",					""),
	array( "sure", 		"Sicher? ", 		"checkbox",	"",		"",		"",					""),
	array( "comment", 	"Kommentar: ", 		"text",		"25",	"",		"",					""),
	);


pageHeader("Formular","main");

$result = selectSubstitude("","");
while ($row = mysql_fetch_array($result)){
	print_r($row);
	form_new("get","",$fields,$row);
}


form_new("get","",$fields,false);

pageFooter();
?>
