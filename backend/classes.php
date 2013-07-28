<?php

	/* /backend/classes.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Klassen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");

$selectSections = array(
	array("Elektronik", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);

$selectTeachers = array(
	array("XH", 	""),
	array("HJ", 	""),
	array("Test3", 	""),
	);

$selectClasses = array(
	array("I164", 	""),
	array("I160", 	""),
	array("Test3", 	""),
	);

$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",					""),
	array( "clName", 	"Name: ", 				"text", 	"8",	"",		"",					""),
	array( "seName", 	"Abteilung: ", 			"dropdown", "",		"",		$selectSections,	""),
	array( "teShort",	"Klassenvorstand: ", 	"dropdown",	"",		"",		$selectTeachers,	""),
	array( "roName", 	"Stammklasse: ", 		"dropdown",	"",		"",		$selectClasses,		""),	
	);


pageHeader("Formular","main");

$result = selectClass("","");
while ($row = mysql_fetch_array($result)){
	print_r($row);
	form_new("get","",$fields,$row);
}


form_new("get","",$fields,false);

pageFooter();
?>
