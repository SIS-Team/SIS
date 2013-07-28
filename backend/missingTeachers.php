<?php

	/* /backend/missingTeachers.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Fehlenden Lehrer
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");

$selectTeachers = array(
	array( "HJ",""),
	array( "XH", ""),
	array( "test3", ""),
	);

$selectHours = array(
	array( "1",""),
	array( "2",""),
	array( "5",""),
	);


$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "teShort", 	"Lehrer: ", 		"dropdown", "5",	"",		$selectTeachers,	""),
	array( "sDay", 		"Starttag: ",		"text", 	"15",	"",		"",					""),
	array( "sHour", 	"Start-Stunde: ",	"dropdown",	"5",	"",		$selectHours,		""),
	array( "eDay", 		"Endtag: ", 		"text",		"15",	"",		"",					""),
	array( "eHour", 	"End-Stunde: ", 	"dropdown",	"5",	"",		$selectHours,		""),
	array( "sure", 		"Sicher? ", 		"checkbox",	"",		"",		"",					""),
	array( "reason", 	"Grund: ", 			"text",		"30",	"",		"",					""),
	);


pageHeader("Formular","main");

$result = selectMissingTeacher("","");
while ($row = mysql_fetch_array($result)){
	print_r($row);
	form_new("get","",$fields,$row);
}


form_new("get","",$fields,false);

pageFooter();
?>
