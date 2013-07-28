<?php

	/* /backend/subjects.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Faecher
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");

$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",		""),
	array( "name", 		"Name: ", 			"text", 	"50",	"",		"",		""),
	array( "short", 	"K&uuml;rzel: ", 	"text", 	"5",	"",		"",		""),
	array( "new", 	"Neues Fach: ", 	"checkbox",	"",		"",		"",		""),
	);


pageHeader("Formular","main");

$result = selectAll("subjects","","");
while ($row = mysql_fetch_array($result)){
	//print_r($row);
	form_new("get","",$fields,$row);
}

form_new("get","",$fields,false);

pageFooter();
?>
