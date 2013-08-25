<?php

	/* /backend/news.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der News
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");


$fields = array(
	array( "ID", 	"",			 		"hidden", 	"",		"",		"",	""),
	array( "title", "Titel: ", 			"text", 	"15",	"",		"",	""),
	array( "text", 	"Inhalt: ", 		"textarea", "20",	"4",	"",	""),
	array( "sDay", 	"Start-Datum: ", 	"text",		"15",	"",		"",	""),
	array( "eDay", 	"End-Datum: ", 		"text",		"15",	"",		"",	""),	
	);


pageHeader("Formular","main");

$result = selectAll("news","","");
while ($row = mysql_fetch_array($result)){
	print_r($row);
	form_new("get","",$fields,$row);
}

form_new("get","",$fields,false);

pageFooter();
?>
