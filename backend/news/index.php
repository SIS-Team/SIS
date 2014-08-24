<?php

	/* /backend/news/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der News
	 */

require_once("../../config.php");
require_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
require_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
require_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung
require_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verfügung
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");	

$hashGenerator = new HashGenerator("MissingTeacher", __FILE__);

ifNotLoggedInGotoLogin(); //Kontrolle ob angemeldet
$permission = getPermission(); //Erhalten der Berechtigungen

if($permission == false) noPermission();  
if($permission == "admin" || $permission == "root") $isAdmin = 1;
else $isAdmin = 0;
if(isset($_POST['save']) && $_POST['save'] !="") {
	news($isAdmin);
	HashCheck($hashGenerator);

}

pageHeader("Formular","main");
$hashGenerator->generate();
HashFail();
$dropDown=array("Sections");
require_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung	
if($isAdmin) {
	$fields = array(
		array( "ID", 			"",			 							"hidden", 	"",		"",		"",					""),
		array( "title", 		"Titel: ", 								"text", 	"8",	"",		"",					""),
		array( "text", 			"Text: ",								"textarea", "20",	"5",	"",					""),
		array( "seShort", 		"Abt.: ",								"dropdown", "5",	"",		$selectSections,	""),	
		array( "startDay",		"Anzeigebeginn-Datum: (YYYY-MM-DD) ",	"date",		"10",	"",		"",					""),
		array( "endDay",		"Anzeigeend-Datum: (YYYY-MM-DD)",		"date",		"10",	"",		"",					""),
		array( "display",		"Anzeigen",								"checkbox",	"",		"",		"",					""),
		array( "user", 			"Erstellter:",							"text", 	"8",	"5",	"",					"readonly=\"true\" background =\"#FFF\""),
		array( "web",			"Nur Website:",							"checkbox",	"",		"",		"",					""),
	);
}
else {
	$fields = array(
		array( "ID", 			"",			 							"hidden", 	"",		"",		"",					""),
		array( "title", 		"Titel: ", 								"text", 	"8",	"",		"",					""),
		array( "text", 			"Text: ",								"textarea", "20",	"5",	"",					""),	
		array( "startDay",		"Anzeigebeginn-Datum: (YYYY-MM-DD) ",	"date",		"10",	"",		"",					""),
		array( "endDay",		"Anzeigeend-Datum: (YYYY-MM-DD)",		"date",		"10",	"",		"",					""),
	);
}
if($isAdmin){
	$sql =	"SELECT
				`news`.`ID`,
				`title`,
				`text`,
				`startDay`,
				`endDay`,
				`display`,
				`sections`.`short` AS seShort,
				`user`,
				`web`
			 FROM `news` 
				LEFT JOIN `sections` ON `news`.`sectionFK` = `sections`.`ID`";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
		if($row['endDay']<(date("Y-m-d",time()-30*60*60*24))) deleteID($row['ID'],"news");
		else form_new($fields,$row,$hashGenerator);		//Formular wird erstellt
	}
}
form_new($fields,false,$hashGenerator);

pageFooter();

function news($Admin)
{
	$post= $_POST;
	unset($post["save"]);
	$data =array("ID"=>"","title"=>"","text"=>"","startDay"=>"","endDay"=>"","display"=>"","sectionFK"=>"","user"=>"","web"=>"");
	$data["ID"]=$post["ID"];
	$data["title"]=mysql_real_escape_string(htmlspecialchars($post["title"]));
	$data["text"]=mysql_real_escape_string(htmlspecialchars($post["text"]));
	if(!empty($post['startDay']) &&check_date($post["startDay"])){
		$data["startDay"]=mysql_real_escape_string($post["startDay"]);
	}
	else{
		$data["startDay"]= "2000-01-01";
	}
	if(!empty($post["endDay"]) && check_date($post["endDay"])){
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
	if(!empty($post["seShort"])){
		$sql = "SELECT ID FROM sections WHERE short = '" .$post["seShort"]."'";
		$section_result  = mysql_query($sql);
		while ($row = mysql_fetch_object($section_result)) {
				$section = $row;
		}
		$data["sectionFK"] = $section->ID;
	}
	else {
		$data["sectionFK"]=0;
	}
	if(empty($post['user'])) $data["user"]=$_SESSION['id'];
	if(isset($post['web'])) $data['web']=1;
	else $data['web']=0;
	if(empty($post["delete"])){
		saveupdate($data,"news");
	}
	else {
		deleteID($data["ID"],"news");
 	}

}

function check_date($date)
{ //kontrolliert ob ein gültiges Datum eingegeben wurde
	$date_parts = array();
 	$date_parts =  explode('-',$date,3);
	return checkdate($date_parts[1],$date_parts[2],$date_parts[0]);
}
?>
