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

require("../../../config.php");
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
require_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
require_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
require_once(ROOT_LOCATION . "/modules/database/inserts.php");	
require_once(ROOT_LOCATION . "/modules/other/dateChange.php");									
require_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");					
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("MissingTeacher", __FILE__);

if (!($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}

if(!empty($_POST['save']) && $_POST['save']!=""){
	HashCheck($hashGenerator);
	missingTeachers();
}

if (empty($_POST["date"]) && empty($_POST['startDay'])) {		//wenn nichts zur�ckgegeben wird, dann heute
	$date = no_weekend(strftime("%Y-%m-%d"));
}
else if($_POST['date']!=""){								//sonst zur�ckgegebenes Datum
	$date = no_weekend($_POST["date"]);
}
else{
	$date = no_weekend($_POST['startDay']);
}

$hashGenerator->generate();


//Seitenheader
pageHeader("Fehlende Lehrer","main");

HashFail();

$dropDown=array("Teachers");
require_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "teShort", 	"Lehrer: ", 		"dropdown", "5",	"",		$selectTeachers,	"required"),
	array( "startDay", 	"Starttag: ",		"text", 	"10",	"",		"",					"readonly=\"true\" , required"),
	array( "startHour", "Start-Stunde: ",	"text",		"5",	"",		"",					"required"),
	array( "endDay", 	"Endtag: ", 		"date",		"10",	"",		"",					"required"),
	array( "endHour", 	"End-Stunde: ", 	"text",		"5",	"",		"",					"required"),
	array( "reason", 	"Grund: ", 			"text",		"30",	"",		"",					""),
	);


$date = dateChange($date);
$fields["2"]["5"] = $date;
$fields["4"]["5"] = $date;


$where = "missingTeachers.endDay >= '".$date."' AND missingTeachers.startDay <= '".$date."'";
$sort = " startDay, hoursStart.hour, teachers.short";

$result = selectMissingTeacher($where,$sort);		//RÃ¼ckgabewert des Selects

while ($row = mysql_fetch_array($result)){	//FÃ¼gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur VerfÃ¼gung steht
	form_new($fields,$row,$hashGenerator);		//Formular wird erstellt
}

form_new($fields,false,$hashGenerator);			//Formular fÃ¼r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
