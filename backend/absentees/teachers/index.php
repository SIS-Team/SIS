<?php

	/* /backend/missing/teachers/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Fehlenden Lehrer
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */

include("../../../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/dateChange.php");					//Stell die Formularmasken zur Verfügung

if (!($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M']))
	exit();

if(!empty($_POST['save']) && $_POST['save']!="")
	missingTeachers();

if (empty($_POST["date"]) && empty($_POST['startDay'])) {		//wenn nichts zur�ckgegeben wird, dann heute
	$date = strftime("%Y-%m-%d");
}
else if($_POST['date']!=""){								//sonst zur�ckgegebenes Datum
	$date = $_POST["date"];
}
else{
	$date = $_POST['startDay'];
}




//Seitenheader
pageHeader("Fehlende Lehrer","main");

$dropDown=array("Teachers");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "teShort", 	"Lehrer: ", 		"dropdown", "5",	"",		$selectTeachers,	""),
	array( "startDay", 	"Starttag: ",		"text", 	"10",	"",		"",					"readonly=\"true\""),
	array( "startHour", "Start-Stunde: ",	"text",		"5",	"",		"",					""),
	array( "endDay", 	"Endtag: ", 		"text",		"10",	"",		"",					""),
	array( "endHour", 	"End-Stunde: ", 	"text",		"5",	"",		"",					""),
	array( "reason", 	"Grund: ", 			"text",		"30",	"",		"",					""),
	);


$date = dateChange($date);
$fields["2"]["5"] = $date;
$fields["4"]["5"] = $date;


$where = "missingTeachers.endDay >= '".$date."' AND missingTeachers.startDay <= '".$date."'";
$sort = " startDay, hoursStart.hour, teachers.short";

$result = selectMissingTeacher($where,$sort);		//RÃ¼ckgabewert des Selects

while ($row = mysql_fetch_array($result)){	//FÃ¼gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur VerfÃ¼gung steht
	form_new($fields,$row,"Fehlende-Lehrer");		//Formular wird erstellt
}

form_new($fields,false,"Fehlende-Lehrer");			//Formular fÃ¼r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
