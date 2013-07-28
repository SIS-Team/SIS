<?php

	/* /backend/monitors.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Monitore
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:	27. 07. 2013, Handle Marco - selects hinzugefügt
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");

$selectRooms = array(
	array("I164", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);

$selectMonitorMode = array(
	array("bild", 	""),
	array("Test2", 	""),
	array("Test3", 	""),
	);


$fields = array(
	array( "ID", 	"",			"hidden", 	"",		"",		"",					""),
	array( "name", 	"Name: ", 	"text", 	"15",	"",		"",					""),
	array( "mode", 	"Modus: ", 	"dropdown", "8",	"",		$selectMonitorMode,	""),
	array( "file", 	"File: ", 	"text",		"20",	"",		"",					""),
	array( "roName","Raum: ", 	"dropdown",	"5",	"",		$selectRooms,		""),	
	);


pageHeader("Formular","main");

$result = selectMonitor("","");
while ($row = mysql_fetch_array($result)){
	print_r($row);
	form_new("get","",$fields,$row);
}


form_new("get","",$fields,false);

pageFooter();
?>
