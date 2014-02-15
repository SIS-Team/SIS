<?php

	/* /backend/missing/classes/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Fehlenden Klassen
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
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");					//Stell die Formularmasken zur VerfÃ¼gung

if (!($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M']))
	header("Location: ".RELATIVE_ROOT."/");

if(!empty($_POST['save']) && $_POST['save']!="")
	missingClasses();

if (empty($_POST["date"]) && empty($_POST['startDay'])) {		//wenn nichts zurückgegeben wird, dann heute
	$date = no_weekend(strftime("%Y-%m-%d"));
}
else if($_POST['date']!=""){								//sonst zurückgegebenes Datum
	$date = no_weekend($_POST["date"]);
}
else{
	$date = no_weekend($_POST['startDay']);
}

//Seitenheader
pageHeader("Fehlende Klassen","main");

$dropDown=array("Classes");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "clName", 	"Klasse: ", 		"dropdown", "8",	"",		$selectClasses,		"required"),
	array( "startDay", 	"Starttag: ",		"text", 	"10",	"",		"",					"readonly=\"true\",required"),
	array( "startHour", "Start-Stunde: ",	"text",		"5",	"",		"",					"required"),
	array( "endDay", 	"Endtag: ", 		"text",		"10",	"",		"",					"required"),
	array( "endHour", 	"End-Stunde: ", 	"text",		"5",	"",		"",					"required"),
	array( "reason", 	"Grund: ", 			"text",		"30",	"",		"",					""),
	);


$date = dateChange($date);
$fields["2"]["5"] = $date;
$fields["4"]["5"] = $date;


$where="missingClasses.endDay >= '".$date."' AND missingClasses.startDay >= '".$date."'";
$sort = " startDay, hoursStart.hour, classes.name";

$result = selectMissingClass($where,$sort);	//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row,"Fehlende-Klassen");		//Formular wird erstellt	
}

form_new($fields,false,"Fehlende-Klassen");			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
