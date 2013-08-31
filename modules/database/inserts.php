<?php

	/* /modules/database/inserts.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Select Befehle fÃ¼r die Datenbank
	 *
	 * Changelog:
	 * 	0.1.0:  26. 08. 2013, Handle Marco - erste Version
	 */
	 
	 include($_SERVER['DOCUMENT_ROOT'] . "/modules/other/dateFunctions.php");					//Stell Datumfunktionen zur Verf�gung


function classes(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$classesInsert=array("ID" => "","name" => "","sectionFK" => "","teacherFK" => "","roomFK" => "");

$data["ID"]=$post["ID"];
$data["name"]=$post["clName"];

$temp = mysql_fetch_array(mysql_query("SELECT ID FROM sections WHERE short='".$post["seShort"]."'"));
$data["sectionFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$data["teacherFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".$post["roName"]."'"));
$data["roomFK"] = $temp["ID"];

if(empty($post["delete"]))
	saveupdate($data,"classes");
else
	delete($data["ID"],"classes");
}

function missingClasses(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","classFK" => "","startDay" => "","startHourFK" => "","endDay" => "","endHourFK" => "","sure" => "","reason" => "");

$data["ID"]=$post["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".$post["clName"]."'"));
$data["classFK"]=$temp["ID"];
$day = weekday($post["startDay"]);
$data["startDay"]=$post["startDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["startHour"]."'"));
$data["startHourFK"]=$temp["ID"];
$day = weekday($post["endDay"]);
$data["endDay"]=$post["endDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["endHour"]."'"));
$data["endHourFK"]=$temp["ID"];
if(!empty($post["sure"]))
	$data["sure"]=true;
$data["reason"]=$post["reason"];

if(empty($post["delete"]))
	saveupdate($data,"missingClasses");
else
	delete($data["ID"],"missingClasses");
	
}


function missingTeachers(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","teacherFK" => "","startDay" => "","startHourFK" => "","endDay" => "","endHourFK" => "","sure" => "","reason" => "");

$data["ID"]=$post["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$data["teacherFK"]=$temp["ID"];
$day = weekday($post["startDay"]);
$data["startDay"]=$post["startDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["startHour"]."'"));
$data["startHourFK"]=$temp["ID"];
$day = weekday($post["endDay"]);
$data["endDay"]=$post["endDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["endHour"]."'"));
$data["endHourFK"]=$temp["ID"];
if(!empty($post["sure"]))
	$data["sure"]=true;
$data["reason"]=$post["reason"];

if(empty($post["delete"]))
	saveupdate($data,"missingTeachers");
else
	delete($data["ID"],"missingTeachers");
	
}

function rooms(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","teacherFK" => "");

$data["ID"]=$post["ID"];
$data["name"]=$post["roName"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$data["teacherFK"]=$temp["ID"];

if(empty($post["delete"]))
	saveupdate($data,"rooms");
else
	delete($data["ID"],"rooms");
	
}

function sections(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","short" => "","teacherFK" => "");

$data["ID"]=$post["ID"];
$data["name"]=$post["seName"];
$data["short"]=$post["seShort"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$data["teacherFK"]=$temp["ID"];

if(empty($post["delete"]))
	saveupdate($data,"sections");
else
	delete($data["ID"],"sections");
	
}

function subjects(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","short" => "");

$data["ID"]=$post["ID"];
$data["name"]=$post["name"];
$data["short"]=$post["short"];

if(empty($post["delete"]))
	saveupdate($data,"subjects");
else
	delete($data["ID"],"subjects");
	
}

function substitudes(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","move" => "","lessonFK" => "","subjectFK" => "","teacherFK" => "","time" => "","roomFK" => "","startHourFK" => "","endHourFK" => "","hidden" => "","sure" => "","comment" => "");

$data["ID"]=$post["ID"];
$data["move"]=$post["move"];
$day = weekday($post["time"]);
$stHour = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["startHour"]."'"));
$enHour = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["endHour"]."'"));
$class = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".$post["clName"]."'"));
$temp = mysql_fetch_array(mysql_query("SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.startHourFK='".$stHour["ID"]."' AND lessonsBase.endHourFK='".$enHour["ID"]."' AND lessonsBase.classFK='".$class["ID"]."'"));
$data["lessonFK"]=$temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM subjects WHERE short LIKE '%".$post["suShort"]."%'"));
$data["subjectFK"]=$temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$data["teacherFK"]=$temp["ID"];
$data["time"]=$post["time"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".$post["roName"]."'"));
$data["roomFK"]=$temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["newStartHour"]."'"));
$data["startHourFK"]=$temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["newEndHour"]."'"));
$data["endHourFK"]=$temp["ID"];
if(!empty($post["hidden"]))
	$data["hidden"]=true;
if(!empty($post["sure"]))
	$data["sure"]=true;
$data["comment"]=$post["comment"];

if(empty($post["delete"]))
	saveupdate($data,"substitudes");
else
	delete($data["ID"],"substitudes");
	
}



function saveUpdate($insert,$table){

	if(empty($insert['ID']))
	{
	
		$col="";
		$dat="";
		$len=count($insert);
		$lauf=1;

		foreach($insert as $i => $p)
		{
			if($i != "ID"){
				$col.= $i;
				$dat.= "'".$p."'";
				if($lauf < $len){
					$col.=" , ";
					$dat.=" , ";
				}
			}
			$lauf+=1;		
		}

		$sql="INSERT INTO ".$table." (".$col.") VALUES (".$dat.")";
	
	}
	else if(!empty($insert['ID']))
	{
		$dat="";
		$len=count($insert);
		$lauf=1;
		
		foreach($insert as $i => $p)
		{
			if($i != "ID"){
				$dat.= $i." = '".$p."'";

				if($lauf < $len)
					$dat.=" , ";
			}
			$lauf+=1;		
		}
	
		$sql="UPDATE ".$table." SET ".$dat." WHERE ID = '".$insert["ID"]."'";
	}

mysql_query($sql);

}

function delete($ID,$table){

$sql="DELETE FROM ".$table." WHERE ID = '".$ID."'";
mysql_query($sql);

}


?>