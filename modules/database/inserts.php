<?php

	/* /modules/database/inserts.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Select Befehle für die Datenbank
	 *
	 * Changelog:
	 * 	0.1.0:  27. 07. 2013, Handle Marco - erste Version
	 */


function classes(){

$post=$_POST;

unset($post["save"]);
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM sections WHERE short='".$post["seShort"]."'"));
$post["seShort"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$post["teShort"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".$post["roName"]."'"));
print_r($post["roName"]);
$post["roName"] = $temp["ID"];

print_r($post);

$classesInsert=array("ID" => "","name" => "","sectionFK" => "","teacherFK" => "","roomFK" => "");

}


function saveUpdate(){

	if(empty($_POST['ID']))
	{
	
	
	}
	else if(!empty($_POST['ID']))
	{
	
	
	}

}




?>