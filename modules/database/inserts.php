<?php

	/* /modules/database/inserts.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Select Befehle fÃƒÆ’Ã‚Â¼r die Datenbank
	 *
	 * Changelog:
	 * 	0.1.0:  26. 08. 2013, Handle Marco - erste Version
	 */
	 
	 include($_SERVER['DOCUMENT_ROOT'] . "/modules/other/dateFunctions.php");					//Stell Datumfunktionen zur VerfÃ¼gung


function classes(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","sectionFK" => "","teacherFK" => "","roomFK" => "","invisible" => "");

$data["ID"]=$post["ID"];
$data["name"]=$post["clName"];

$temp = mysql_fetch_array(mysql_query("SELECT ID FROM sections WHERE short='".$post["seShort"]."'"));
$ok1 = control($post["seShort"],$temp["ID"],"Abteilung");
$data["sectionFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$ok2 = control($post["teShort"],$temp["ID"],"Lehrer");
$data["teacherFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".$post["roName"]."'"));
$ok3 = control($post["roName"],$temp["ID"],"Raum");
$data["roomFK"] = $temp["ID"];

if(!empty($post["invisible"]))
	$data["invisible"]=true;

if(empty($post["delete"]) && ($ok1*$ok2*$ok3) == 1)
	saveupdate($data,"classes");
}


function lessons(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$lessonsInsert=array("ID" => "","lessonBaseFK" => "","roomFK" => "","teachersFK" => "","subjectFK" => "","comment"=>"");
$lessonsBaseInsert=array("ID" => "","startHourFK" => "","endHourFK" => "","classFK" => "");

$lessonsInsert["ID"]=$post["ID"];

$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE hour='".$post["hour"]."' AND weekdayShort='".$post["day"]."'"));
$lessonsBaseInsert["startHourFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE hour='".($post["hour"]+$post["length"]-1)."' AND weekdayShort='".$post["day"]."'"));
$lessonsBaseInsert["endHourFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".$post["class"]."'"));
$lessonsBaseInsert["classFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM lessonsBase WHERE startHourFK='".$lessonsBaseInsert["startHourFK"]."' AND classFK='".$lessonsBaseInsert["classFK"]."'"));
$lessonsBaseInsert["ID"] = $temp["ID"];


$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$ok1 = control($post["seShort"],$temp["ID"],"Lehrer");
$lessonsInsert["teachersFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".$post["roName"]."'"));
$ok2 = control($post["roName"],$temp["ID"],"Raum");
$lessonsInsert["roomFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM subjects WHERE short = '".$post["suShort"]."'"));
$ok3 = control($post["suShort"],$temp["ID"],"Fach");
$lessonsInsert["subjectFK"]=$temp["ID"];
$lessonsInsert["comment"]=$post["comment"];
//print_r($lessonsBaseInsert);
//echo ",";
//print_r($lessonsInsert);

if($lessonsBaseInsert['ID']=="" && ($ok1*$ok2*$ok3) == 1){
	saveupdate($lessonsBaseInsert,"lessonsBase");
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM lessonsBase WHERE startHourFK='".$lessonsBaseInsert["startHourFK"]."' AND endHourFK='".$lessonsBaseInsert["endHourFK"]."' AND classFK='".$lessonsBaseInsert["classFK"]."'"));
	$lessonsBaseInsert["ID"] = $temp["ID"];
}

$lessonsInsert["lessonBaseFK"]=$lessonsBaseInsert["ID"];


if(empty($post["delete"]) && ($ok1*$ok2*$ok3) == 1)
	saveupdate($lessonsInsert,"lessons");
else if(($ok1*$ok2*$ok3) == 1)
{

$lessonsbaseID=$lessonsInsert["lessonBaseFK"];

$sql="DELETE FROM lessons WHERE lessonBaseFK = '".$lessonsbaseID."'";
mysql_query($sql);
$sql="DELETE FROM lessonsBase WHERE ID = '".$lessonsbaseID."'";
mysql_query($sql);



}

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
	
}

function subjects(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","short" => "","invisible" => "");

$data["ID"]=$post["ID"];
$data["name"]=$post["name"];
$data["short"]=$post["short"];
if(!empty($post["invisible"]))
	$data["invisible"]=true;


if(empty($post["delete"]))
	saveupdate($data,"subjects");
	
}

function substitudes(){

$post=$_POST;
unset($post["save"]);
print_r($post);
$data=array("ID" => "","move" => "","lessonFK" => "","subjectFK" => "","teacherFK" => "","time" => "","roomFK" => "","startHourFK" => "","endHourFK" => "","hidden" => "","display" => "","comment" => "");


$day = weekday($post["time"]);
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM subjects WHERE short='".$post["suShort"]."'"));
$data["subjectFK"]= $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$data["teacherFK"]=$temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".$post["roName"]."'"));
$data["roomFK"]=$temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["startHour"]."'"));
$startHour=$temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["endHour"]."'"));
$endHour=$temp["ID"];
$data["time"]=$post["time"];
$data["comment"]=$post["comment"];
if($post["hidden"]=="hidden")
	$data["hidden"]=true;
if($post["move"]=="move")
{
	$data["move"]=true;
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["newStartHour"]."'"));
	$data["startHourFK"]=$temp["ID"];
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["newEndHour"]."'"));
	$data["endHourFK"]=$temp["ID"];

}
	
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".$post['clName']."'"));
$class = $temp['ID'];

$sql = "SELECT missingTeachers.teacherFK FROM missingTeachers INNER JOIN hours as hourST ON hourST.ID = missingTeachers.startHourFK INNER JOIN hours as hourEN ON hourEN.ID = missingTeachers.endHourFK INNER JOIN lessons ON missingTeachers.teacherFK = lessons.teachersFK INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE missingTeachers.startDay <='".$post['time']."' AND missingTeachers.endDay >='".$post['time']."' AND hourST.hour <='".$post['startHour']."' AND hourEN.hour >='".$post['endHour']."' AND lessonsBase.startHourFK='".$startHour."' AND lessonsBase.endHourFK='".$endHour."' AND lessonsBase.classFK='".$class."'";
$temp = mysql_query($sql);
while($missTeacher[] = mysql_fetch_array($temp)){
}
unset($missTeacher[count($missTeacher)-1]);

foreach($missTeacher as $i => $m){
	$sql = "SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.startHourFK='".$startHour."' AND lessonsBase.endHourFK='".$endHour."' AND lessonsBase.classFK='".$class."' AND lessons.teachersFK = '".$m["teacherFK"]."'";
	$temp = mysql_query($sql);
	$temp = mysql_fetch_row($temp);
	$data["lessonFK"] = $temp[0];
	
	if($i < 1)
		$data["display"]=true;
	else
		$data["display"]=false;
		
	print_r($data);
	if(empty($post["delete"]))
		saveupdate($data,"substitudes");

	
}

//print_r($data);

/*
if($post['move']=="move"){
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["newStartHour"]."'"));
	$data["newStartHourFK"]=$temp["ID"];
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["newEndHour"]."'"));
	$data["newEndHourFK"]=$temp["ID"];
}
*/


}

function teachers(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","short" => "","display" => "","sectionFK" => "","invisible" => "");

$data["ID"]=$post["ID"];
$data["name"]=$post["teName"];
$data["short"]=$post["teShort"];
$data["display"]=$post["display"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM sections WHERE short='".$post["seShort"]."'"));
$data["sectionFK"] = $temp["ID"];
if(!empty($post["invisible"]))
	$data["invisible"]=true;

if(empty($post["delete"]))
	saveupdate($data,"teachers");
	
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

function findFK($post){

print_r($post);

$day = weekday($post["time"]);
$stHour = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["startHour"]."'"));
$enHour = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".$post["endHour"]."'"));
$class = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".$post["clName"]."'"));
//echo $class["ID"];
$lessonsBaseID = mysql_fetch_array(mysql_query("SELECT lessonsBase.ID FROM lessonsBase WHERE lessonsBase.startHourFK='".$stHour["ID"]."' AND lessonsBase.endHourFK='".$enHour["ID"]."' AND lessonsBase.classFK='".$class["ID"]."'"));

print_r($lessonsBaseID["ID"]);

$sql=" SELECT lessons.teachersFK FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.ID='".$lessonsBaseID["ID"]."'";
$result = mysql_query($sql);

while($row = mysql_fetch_array($result)){

$lessons[]=end($row);

}

/*$sql=" SELECT missingTeachers.teacherFK FROM missingTeachers WHERE missingTeachers.startDay <= '".$post["time"]."' AND missingTeachers.endDay >= '".$post["time"]."' AND missingTeachers.startHourFK <= '".$stHour["ID"]."' AND missingTeachers.endHourFK >= '".$enHour["ID"]."'";
$result = mysql_query($sql);

while($row = mysql_fetch_array($result)){

$missing[]=end($row);

}

//print_r($missing);

foreach($lessons as $l){

if(array_search($l,$missing)!==false){
	$teacher=$l;
	break;
}



}*/


$sql="SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.ID='".$lessonsBaseID["ID"]."'";
//$sql="SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.ID='".$lessonsBaseID["ID"]."' AND lessons.teachersFK='".$teacher."'";
$result = mysql_fetch_array(mysql_query($sql));

if($result["ID"]=="")
	$result["ID"]=0;

//echo $result["ID"];
return $result["ID"];

}



function control($post,$select,$field)
{

if($post != "" && $select == ""){
	printf("<script> window.alert('%s nicht gefunden!');</script> ",$field);
	return 0;
}
else
	return 1;
}

?>