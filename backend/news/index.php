<?php

	/* /backend/news/index.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der News
	 *
	 * Changelog:
	 * 	0.1.0:  15. 10. 2013, Mathias Weiland - erste Version
	 */

include_once("../../config.php");
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verfügung

if(!($_SESSION['loggedIn'])) GotoRoot(); //Kontrolle ob angemeldet

$isAdmin = $_SESSION['rights']['E'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['M'] || $_SESSION['rights']['root'];
$isNews = $_SESSION['rights']['news'];

if(!($isNews or $isAdmin)) GotoRoot(); //Kontrolle wegen Berechtigungen 

if(isset($_POST['save']) && $_POST['save'] !="") {
	news($isAdmin);
}





pageHeader("Formular","main");

//ID,title,text,startDay,endDay
if($isAdmin) {
	$fields = array(
		array( "ID", 			"",			 							"hidden", 	"",		"",		"",					""),
		array( "title", 		"Titel: ", 								"text", 	"8",	"",		"",					""),
		array( "text", 			"Text: ",								"textarea", "20",	"5",	"",					""),
		array( "secShort", 		"Abteilung: ",							"dropdown", "",		"",		"",					""),	
		array( "startDay",		"Anzeigebeginn-Datum: (YYYY-MM-DD) ",	"text",		"10",	"",		"",					""),
		array( "endDay",		"Anzeigeend-Datum: (YYYY-MM-DD)",		"text",		"10",	"",		"",					""),
		array( "display",		"Anzeigen",								"checkbox",	"",		"",		"",					""),
	);
}
else {
	$fields = array(
		array( "ID", 			"",			 							"hidden", 	"",		"",		"",					""),
		array( "title", 		"Titel: ", 								"text", 	"8",	"",		"",					""),
		array( "text", 			"Text: ",								"textarea", "20",	"5",	"",					""),	
		array( "startDay",		"Anzeigebeginn-Datum: (YYYY-MM-DD) ",	"text",		"10",	"",		"",					""),
		array( "endDay",		"Anzeigeend-Datum: (YYYY-MM-DD)",		"text",		"10",	"",		"",					""),
	);
}
if($isAdmin){
 $sql ="SELECT `news`.`ID`, `title`, `text`, `startDay` , `endDay`, `display`, `sections`.`short` AS secShort FROM `news` LEFT JOIN `sections` ON `news`.`sectionFK`= `sections`.`ID`";
	$result = mysql_query($sql);
	echo mysql_error();
	while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row,"Eingabe-News");		//Formular wird erstellt
	}
}
form_new($fields,false,"Eingabe-News");

pageFooter();

function news($Admin)
{
	$post= $_POST;
	unset($post["save"]);
	$data =array("ID"=>"","title"=>"","text"=>"","startDay"=>"","endDay"=>"","display"=>"","sectionFK"=>"");
	$data["ID"]=$post["ID"];
	$data["title"]=mysql_real_escape_string(htmlspecialchars($post["title"]));
	$data["text"]=mysql_real_escape_string(htmlspecialchars($post["text"]));
	if(check_date($post["startDay"])){
		$data["startDay"]=mysql_real_escape_string($post["startDay"]);
	}
	else{
		$data["startDay"]= "2000-01-01";
	}
	if(check_date($post["endDay"])){
		$data["endDay"]=mysql_real_escape_string($post["endDay"]);
	}
	else {
		$data["endDay"]= "2999-12-31";
	}
	if(isset($post["display"]) && $Admin == 1){
		$data["display"]=1;
	}
	else {
		$data["display"]=0;
	}
	if(!empty($post["secShort"])){
	$sql = "SELECT ID FROM sections WHERE short = '" .$post["secShort"]."'";
	$section_result  = mysql_query($sql);
		while ($row = mysql_fetch_object($section_result)) {
			$section = $row;
		}
	$data["sectionFK"] = $section->ID;
	}
	else {
	$data["sectionFK"]=0;
	}
	if(empty($post["delete"])){
		saveupdate($data,"news");
		echo "done";
	}
	else {
		delete($data["ID"],"news");
 	}

 }

function check_date($date)
{
	$date_parts = array();
 	$date_parts =  explode('-',$date,3);
	return checkdate($date_parts[1],$date_parts[2],$date_parts[0]);
}
?>
