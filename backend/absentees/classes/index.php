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
	 
require("../../../config.php");
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
require_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verf�gung
require_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung
require_once(ROOT_LOCATION . "/modules/database/inserts.php");					
require_once(ROOT_LOCATION . "/modules/other/dateChange.php");					
require_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");					
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("MissingClasses", __FILE__);

if (!($_SESSION['rights']['root'] || $_SESSION['rights'][SECTION_N] || $_SESSION['rights'][SECTION_W] || $_SESSION['rights'][SECTION_E] || $_SESSION['rights'][SECTION_M])){
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
require_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen f�r die Dropdownmen�s zur Verf�gung
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

//wenn nichts zur�ckgegeben wird, dann heute
if (empty($_POST["date"]) && empty($_POST['startDay'])) {
	$date = no_weekend(strftime("%Y-%m-%d"));
}
//sonst zur�ckgegebenes Datum
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

$result = selectMissingClass($where,$sort);	//R�ckgabewert des Selects

while ($row = mysql_fetch_array($result)){	//F�gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verf�gung steht
	form_new($fields,$row,$hashGenerator);		//Formular wird erstellt	
}

form_new($fields,false,$hashGenerator);			//Formular f�r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
