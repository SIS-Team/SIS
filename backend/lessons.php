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


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");


$selectClasses = array(
	array("5YHEL", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);

$selectRooms = array(
	array("I164", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);

$selectTeachers = array(
	array("XH", 	""),
	array("HJ", 	""),
	array("Test3", 	""),
	);

$selectSubjects = array(
	array("TKHF", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);

$selectDays = array(
	array("Mo", 	""),
	array("Di", 	""),
	array("Mi", 	""),
	array("Do", 	""),
	array("Fr", 	""),
	);

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


pageHeader("Formular","main");

$result = selectLesson("","");
while ($row = mysql_fetch_array($result)){
	print_r($row);
	form_new("get","",$fields,$row);
}


form_new("get","",$fields,false);

pageFooter();
?>
