<?php

	/* /backend/substitude/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 * Erstellt die Formulare fuer die Eingabe der Supplierungen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */

include("../../../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/dateChange.php");			//Stell die Funktion für die Datumsauswahl zur VerfÃ¼gung

if (!($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M']))
	exit();


if(!empty($_POST['save']) && $_POST['save']!="")
	substitudes();

if(empty($_GET['section']) && empty($_POST['section']))
	exit();
else if($_GET['section']!="")
	$section = $_GET['section'];
else if($_POST['section']!="")
	$section = $_POST['section'];


if (empty($_POST["date"]) && empty($_POST['time'])) {		//wenn nichts zurÃ¼ckgegeben wird, dann heute
	$date = strftime("%Y-%m-%d");
}
else if(empty($_POST['time'])){								//sonst zurÃ¼ckgegebenes Datum
	$date = $_POST["date"];
}
else if(empty($_POST['date'])){								//sonst zurÃ¼ckgegebenes Datum
	$date = $_POST["time"];
}

echo $section;
//Seitenheader
pageHeader("Supplierungen eintragen","main");

$dropDown=array("Classes","Subjects","Teachers","Rooms");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung


//Formularmaske
$fieldsRow1 = array(
	array( "ID", 		"",			 		"hidden", 		"",		"",		"",					""),
	array( "move",	 	"Verschiebung: ", 	"checkboxJava", "8",	"",		"",					""),
	array( "clName", 	"Klasse: ", 		"dropdown", 	"8",	"",		$selectClasses,		""),
	array( "suShort", 	"Fach: ", 			"dropdown", 	"8",	"",		$selectSubjects,	""),
	array( "teShort", 	"Supplierlehrer: ",	"dropdown", 	"5",	"",		$selectTeachers,	""),
	array( "time", 		"Datum: ",			"text",			"10",	"",		"",					""),
	array( "roName",	"Raum: ", 			"dropdown",		"8",	"",		$selectRooms,		""),
	array( "startHour",	"Start-Std.: ", 	"text",			"5",	"",		"",					""),
	array( "endHour",	"End-Std.: ",	 	"text",			"4",	"",		"",					""),
	array( "hidden",	"Entf&auml;llt? ", 	"checkbox",		"",		"",		"",					""),
	array( "comment", 	"Kommentar: ", 		"text",			"25",	"",		"",					""),
	);
	
$fieldsRow2 = array(
	array( "newStartHour",  "Neue Start-St.: ", 	"text",		"5",	"",		"",		""),
	array( "newEndHour",	"Neue End-St.: ",		"text",		"4",	"",		"",		""),
	);




printf("<script language=\"javascript\" type=\"text/javascript\" src=\"%s/data/scripts/substitudes.js\"></script>",RELATIVE_ROOT);


$date = dateChange($date);		//Datumsauswahl erzeugen
$fieldsRow1[5][5] = $date;	//Standartdatum ins Formular schreiben

$where = "substitudes.time = '".$date."' AND sections.short = '".$section."'";		//Filter
$sort = "classes.name, hoursStart.hour";		//Sortierung nach dem Klassenname und der Startstunde

$result = selectSubstitude($where,$sort);			//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_substitudes($fieldsRow1,$fieldsRow2 ,$row,$section);		//Formular wird erstellt
}

form_substitudes($fieldsRow1,$fieldsRow2,false,$section);			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
