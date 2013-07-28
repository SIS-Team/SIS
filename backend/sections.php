<?php

	/* /backend/sections.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Abteilungen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");


$selectTeachers = array(
	array( "XH",	 	""),
	array( "Test2", 	""),
	array( "Test3", 	""),
	);

$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",						""),
	array( "seName",	"Name: ", 				"text", 	"15",	"",		"",						""),
	array( "teShort",	"Abteilungsleiter: ", 	"dropdown", "15",		"",		$selectTeachers,	""),
	);


pageHeader("Formular","main");

$result = selectSection("","");
while ($row = mysql_fetch_array($result)){
	print_r($row);
	form_new("get","",$fields,$row);
}

form_new("get","",$fields,false);


pageFooter();
?>
