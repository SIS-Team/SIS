<?php

	/* /backend/news.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der News
	 *
	 * Changelog:
	 * 	0.1.0:  15. 10. 2013, Mathias Weiland - erste Version
	 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung


if($_POST['save']!="")
	news();

pageHeader("Formular","main");

//ID,title,text,startDay,endDay
$fields = array(
	array( "ID", 		"",			 				"hidden", 	"",		"",		"",					""),
	array( "title", 	"Titel: ", 					"text", 	"8",	"",		"",					""),
	array( "text", 		"Text: ",					"textarea", "20",	"5",	"",					""),	
	array( "startDay",	"Anzeigebeginn-Datum: ",	"text",		"10",	"",		"",					""),
	array( "endDay",	"Anzeigeend-Datum: ",		"text",		"10",	"",		"",					""),
	array( "display",	"Anzeigen",					"checkbox",	"",		"",		"",					""),
	);

$result = selectAll("news","","");
while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row);		//Formular wird erstellt
}

form_new($fields,false);

pageFooter();



function news()
{
$post= $_POST;
//print_r($post);


unset($post["save"]);

$data =array("ID"=>"","title"=>"","text"=>"","startDay"=>"","endDay"=>"","display"=>"");

$data["ID"]=$post["ID"];
$data["title"]=$post["title"];
$data["text"]=$post["text"];
$data["startDay"]=$post["startDay"];
$data["endDay"]=$post["endDay"];
if(isset($post["display"])){$data["display"]=1;}
else {$data["display"]=0;}
//print_r($data);
if(empty($post["delete"])) saveupdate($data,"news");
else delete($data["ID"],"news");
 
 }

	

?>
