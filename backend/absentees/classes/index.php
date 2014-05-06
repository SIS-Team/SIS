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
include_once(ROOT_LOCATION . "/modules/database/inserts.php");					
include_once(ROOT_LOCATION . "/modules/other/dateChange.php");					
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");					
include_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("MissingClasses", __FILE__);

if (!($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}

if(!empty($_POST['save']) && $_POST['save']!=""){
	HashCheck($hashGenerator);
	missingClasses();
}



//Seitenheader
pageHeader("Fehlende Klassen","main");
$hashGenerator->generate();

HashFail();

$dropDown=array("Classes");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "clName", 	"Klasse: ", 		"dropdown", "8",	"",		$selectClasses,		"required"),
	array( "startDay", 	"Starttag: ",		"text", 	"10",	"",		"",					"readonly=\"true\",required"),
	array( "startHour", "Start-Stunde: ",	"text",		"5",	"",		"",					"required"),
	array( "endDay", 	"Endtag: ", 		"date",		"10",	"",		"",					"required"),
	array( "endHour", 	"End-Stunde: ", 	"text",		"5",	"",		"",					"required"),
	array( "reason", 	"Grund: ", 			"text",		"30",	"",		"",					""),
	);

//wenn nichts zurückgegeben wird, dann heute
if (empty($_POST["date"]) && empty($_POST['startDay'])) {
	$date = no_weekend(strftime("%Y-%m-%d"));
}
//sonst zurückgegebenes Datum
else if($_POST['date']!=""){
	$date = no_weekend($_POST["date"]);
}
else{
	$date = no_weekend($_POST['startDay']);
}

$date = dateChange($date);
$fields["2"]["5"] = $date;	//Zuweisen des aktuellen Datums
$fields["4"]["5"] = $date;	//Zuweisen des aktuellen Datums


$where="missingClasses.endDay >= '".$date."' AND missingClasses.startDay >= '".$date."'";
$sort = " startDay, hoursStart.hour, classes.name";

$result = selectMissingClass($where,$sort);	//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row,$hashGenerator);		//Formular wird erstellt	
}

form_new($fields,false,$hashGenerator);			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
