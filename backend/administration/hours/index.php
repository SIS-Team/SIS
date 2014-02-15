<?php

	/* /backend/administration/hours/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Stunden
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */

include("../../../config.php");

include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verf�gung
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");			//Stellt die insert-Befehle zur Verf�gung
include_once(ROOT_LOCATION . "/modules/form/HashGenerator.php");

if(empty($_POST['day']))
	$_POST['day']="Mo";

if (!($_SESSION['rights']['root']))
	header("Location: ".RELATIVE_ROOT."/");

if(!empty($_POST['save']) && $_POST['save']!="")
	hours();

//var_dump(pageHeader);
//Seitenheader
pageHeader("Zeiten","main");

//Formularmaske
$fields = array(
	array( "ID", 			"",			 		"hidden", 	"",		"",		"",		""),
	array( "weekday", 		"Wochentag: ", 		"hidden", 	"",		"",		"",		""),
	array( "weekdayShort", 	"K&uuml;rzel: ", 	"hidden", 	"",		"",		"", 	""),
	array( "hour",			"Stunde: ", 		"text",		"",		"",		"", 	"required"),
	array( "startTime", 	"Start-Zeit: ", 	"text",		"",		"",		"",		"required"),
	array( "endTime", 		"End-Zeit: ", 		"text",		"",		"",		"",		"required"),		
	);

$days=prevNextDay($_POST['day']);

$hashGenerator = new HashGenerator("Tag-Auswahl", __FILE__);
$hashGenerator->generate();

printf("<form action=\"index.php\" method=\"post\">\n");
$hashGenerator->printForm();
printf("<table width=\"100%%\"><tr>");

if($days['prev']!="")
	printf("<td><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['prev']);
	
if($days['next']!="")
	printf("<td style=\"text-align:right\"><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['next']);
	
printf("</tr></table></form>\n");
	
	
$where = "weekdayShort='".$_POST['day']."'";
$sort = "weekday,hour";
$result = selectAll("hours",$where,$sort);	//R�ckgabewert des Selects


while ($row = mysql_fetch_array($result)){	//F�gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verf�gung steht
	form_new($fields,$row,"Stunden");		//Formular wird erstellt
	$weekday = $row['weekday'];
}

form_new($fields,array("ID"=>"","weekday"=>$weekday,"weekdayShort"=>$_POST['day'],"hour"=>"","startTime"=>"","endTime"=>""),"Stunden");			//Formular f�r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
