<?php

	/* /backend/missingTeachers.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Fehlenden Lehrer
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */


include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/inserts.php");					//Stell die Formularmasken zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/other/dateChange.php");					//Stell die Formularmasken zur Verfügung

if($_POST['save']!="")
	missingTeachers();

if (empty($_POST["date"])) {		//wenn nichts zurückgegeben wird, dann heute
	$date = strftime("%Y-%m-%d");
}
else {								//sonst zurückgegebenes Datum
	$date = $_POST["date"];
}


//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "teShort", 	"Lehrer: ", 		"dropdown", "5",	"",		$selectTeachers,	""),
	array( "startDay", 	"Starttag: ",		"text", 	"10",	"",		"",					""),
	array( "startHour", "Start-Stunde: ",	"text",		"5",	"",		"",					""),
	array( "endDay", 	"Endtag: ", 		"text",		"10",	"",		"",					""),
	array( "endHour", 	"End-Stunde: ", 	"text",		"5",	"",		"",					""),
	array( "sure", 		"Sicher? ", 		"checkbox",	"",		"",		"",					""),
	array( "reason", 	"Grund: ", 			"text",		"30",	"",		"",					""),
	);

//Seitenheader
pageHeader("Formular","main");

$date = dateChange($date);

$where="missingClasses.endDay >= '".$date."'";


$result = selectMissingTeacher("","");		//RÃ¼ckgabewert des Selects

while ($row = mysql_fetch_array($result)){	//FÃ¼gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur VerfÃ¼gung steht
	form_new($fields,$row);		//Formular wird erstellt
}

form_new($fields,false);			//Formular fÃ¼r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
