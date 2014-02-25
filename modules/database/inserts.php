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
include(ROOT_LOCATION . "/modules/other/dateFunctions.php");					//Stell Datumfunktionen zur VerfÃ¼gung


function classes(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","sectionFK" => "","teacherFK" => "","roomFK" => "","invisible" => "");

$data["ID"]=$post["ID"];
$data["name"]=htmlentities($post["clName"]);

$temp = mysql_fetch_array(mysql_query("SELECT ID FROM sections WHERE short='".mysql_real_escape_string(htmlspecialchars($post["seShort"]))."'"));
$ok1 = control($post["seShort"],$temp["ID"],"Abteilung");
$data["sectionFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
$ok2 = control($post["teShort"],$temp["ID"],"Lehrer");
$data["teacherFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".mysql_real_escape_string(htmlspecialchars($post["roName"]))."'"));
$ok3 = control($post["roName"],$temp["ID"],"Raum");
$data["roomFK"] = $temp["ID"];

if(!empty($post["invisible"]))
	$data["invisible"]=true;

if(empty($post["delete"]) && ($ok1*$ok2*$ok3) == 1)
	saveupdate($data,"classes");
}

function hours(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","weekday" => "","weekdayShort" => "","hour" => "","startTime" => "","endTime" => "");

$data["ID"]=$post["ID"];
$data["weekday"]=$post["weekday"];
$data["weekdayShort"]=$post["weekdayShort"];
$data["hour"]=$post["hour"];
$data["startTime"]=$post["startTime"];
$data["endTime"]=$post["endTime"];


if(empty($post["delete"]))
	saveupdate($data,"hours");
else
	deleteID($data["ID"],"hours");

}

function lessons(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$lessonsInsert=array("ID" => "","lessonBaseFK" => "","roomFK" => "","teachersFK" => "","subjectFK" => "","comment"=>"");
$lessonsBaseInsert=array("ID" => "","startHourFK" => "","endHourFK" => "","classFK" => "");

$lessonsInsert["ID"]=$post["ID"];

$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE hour='".intval($post["hour"])."' AND weekdayShort='".mysql_real_escape_string(htmlspecialchars($post["day"]))."'"));
$lessonsBaseInsert["startHourFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE hour='".intval($post["hour"]+$post["length"]-1)."' AND weekdayShort='".mysql_real_escape_string(htmlspecialchars($post["day"]))."'"));
$lessonsBaseInsert["endHourFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".mysql_real_escape_string(htmlspecialchars($post["class"]))."'"));
$lessonsBaseInsert["classFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM lessonsBase WHERE startHourFK='".$lessonsBaseInsert["startHourFK"]."' AND classFK='".$lessonsBaseInsert["classFK"]."'"));
$lessonsBaseInsert["ID"] = $temp["ID"];


$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
$ok1 = control($post["seShort"],$temp["ID"],"Lehrer");
$lessonsInsert["teachersFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".mysql_real_escape_string(htmlspecialchars($post["roName"]))."'"));
$ok2 = control($post["roName"],$temp["ID"],"Raum");
$lessonsInsert["roomFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM subjects WHERE short = '".mysql_real_escape_string(htmlspecialchars($post["suShort"]))."'"));
$ok3 = control($post["suShort"],$temp["ID"],"Fach");
$lessonsInsert["subjectFK"]=$temp["ID"];
$lessonsInsert["comment"]=htmlspecialchars($post["comment"]);


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

$data=array("ID" => "","classFK" => "","startDay" => "","startHourFK" => "","endDay" => "","endHourFK" => "","reason" => "");

$data["ID"]=$post["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".mysql_real_escape_string(htmlspecialchars($post["clName"]))."'"));
$ok1 = control($post["clName"],$temp["ID"],"Klasse");
$data["classFK"]=$temp["ID"];
$day = weekday($post["startDay"]);
$data["startDay"]=$post["startDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["startHour"])."'"));
$ok2 = control($post["startHour"],$temp["ID"],"Start-Stunde");
$data["startHourFK"]=$temp["ID"];
$day = weekday($post["endDay"]);
$data["endDay"]=$post["endDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["endHour"])."'"));
$ok3 = control($post["endHour"],$temp["ID"],"End-Stunde");
$data["endHourFK"]=$temp["ID"];
$data["reason"]=htmlspecialchars($post["reason"]);

if( ($ok1*$ok2*$ok3)==1){
	if(empty($post["delete"]))
		saveupdate($data,"missingClasses");
	else
		deleteID($data["ID"],"missingClasses");
}	
}


function missingTeachers(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","teacherFK" => "","startDay" => "","startHourFK" => "","endDay" => "","endHourFK" => "","reason" => "");

$data["ID"]=$post["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
$ok1 = control($post["teShort"],$temp["ID"],"Lehrer");
$data["teacherFK"]=$temp["ID"];
$day = weekday($post["startDay"]);
$data["startDay"]=$post["startDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["startHour"])."'"));
$ok2 = control($post["startHour"],$temp["ID"],"Start-Stunde");
$data["startHourFK"]=$temp["ID"];
$day = weekday($post["endDay"]);
$data["endDay"]=$post["endDay"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["endHour"])."'"));
$ok3 = control($post["endHour"],$temp["ID"],"End-Stunde");
$data["endHourFK"]=$temp["ID"];
$data["reason"]=htmlspecialchars($post["reason"]);

if( ($ok1*$ok2*$ok3)==1){
	if(empty($post["delete"]))
		saveupdate($data,"missingTeachers");
	else
		deleteID($data["ID"],"missingTeachers");
}
}

function rooms(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","teacherFK" => "");

$data["ID"]=$post["ID"];
$data["name"]=htmlspecialchars($post["roName"]);
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
$ok1 = control($post["teShort"],$temp["ID"],"Lehrer");
$data["teacherFK"]=$temp["ID"];

if(empty($post["delete"]) && $ok1==1)
	saveupdate($data,"rooms");
	
}

function sections(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","short" => "","teacherFK" => "");

$data["ID"]=$post["ID"];
$data["name"]=htmlspecialchars($post["seName"]);
$data["short"]=$post["seShort"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
$ok1 = control($post["teShort"],$temp["ID"],"Lehrer");
$data["teacherFK"]=$temp["ID"];

if(empty($post["delete"]) && $ok1 == 1)
	saveupdate($data,"sections");
}

function subjects(){

$post=$_POST;
//print_r($post);
unset($post["save"]);

$data=array("ID" => "","name" => "","short" => "","invisible" => "");

$data["ID"]=$post["ID"];
$data["name"]=htmlspecialchars($post["name"]);
$data["short"]=htmlspecialchars($post["short"]);
if(!empty($post["invisible"]))
	$data["invisible"]=true;


if(empty($post["delete"]))
	saveupdate($data,"subjects");
	
}

function substitudes(){

$post=$_POST;
unset($post["save"]);
//print_r($post);
$data=array("ID" => "","time" => "","newSub" => "","remove" => "","move" => "","lessonFK" => "","startHourFK" => "","endHourFK" => "","teacherFK" => "","subjectFK" => "","roomFK" => "","classFK" => "","display" => "","comment" => "");

if($post["ID"]!=""){

	$sql="SELECT move,newSub,remove,classFK,subjectFK,teacherFK,time,roomFK,startHourFK,endHourFK FROM substitudes WHERE ID = '".intval($post['ID'])."'";
	$result = mysql_query($sql);
	$result = mysql_fetch_array($result);
	
	$sql = "SELECT ID FROM substitudes WHERE remove = '".$result["remove"]."' AND newSub = '".$result["newSub"]."' AND move = '".$result["move"]."' AND classFK = '".$result["classFK"]."' AND subjectFK = '".$result["subjectFK"]."' AND teacherFK = '".$result["teacherFK"]."' AND time = '".$result["time"]."' AND roomFK = '".$result["roomFK"]."' AND startHourFK = '".$result["startHourFK"]."' AND endHourFK = '".$result["endHourFK"]."' AND display = 0";
	$temp = mysql_query($sql);
	
	while($tempIDs[] = mysql_fetch_array($temp)){
	}
	unset($tempIDs[count($tempIDs)-1]);
	
	$IDs[] = $post["ID"];
	foreach($tempIDs as $i){
		$IDs[] = $i["ID"];	
	}
	
	foreach($IDs as $i){
		$sql="DELETE FROM substitudes WHERE ID=".$i;
		mysql_query($sql);
	}
	$post["ID"]="";

}

if(!isset($post["delete"]) && $post["delete"]==""){


if($post["free"]=="free"){

	if($post["freeRadio"]=="add"){
		
		$data["lessonFK"]=0;
		$day = weekday($post["time"]);
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM subjects WHERE short='".mysql_real_escape_string(htmlspecialchars($post["suShort"]))."'"));
		$ok1 = control($post["suShort"],$temp["ID"],"Fach");		
		$data["subjectFK"]= $temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
		$ok2 = control($post["teShort"],$temp["ID"],"Lehrer");		
		$data["teacherFK"]=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".mysql_real_escape_string(htmlspecialchars($post["roName"]))."'"));
		$ok3 = control($post["roName"],$temp["ID"],"Raum");		
		$data["roomFK"]=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["startHour"])."'"));
		$ok4 = control($post["startHour"],$temp["ID"],"Start-Stunde");		
		$data["startHourFK"]=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["endHour"])."'"));
		$ok5 = control($post["endHour"],$temp["ID"],"End-Stunde");		
		$data["endHourFK"]=$temp["ID"];
		$data["time"]=$post["time"];
		$data["comment"]=htmlspecialchars($post["comment"]);
		$data["newSub"]=true;
		$data["display"]=true;
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".mysql_real_escape_string(htmlspecialchars($post['clName']))."'"));
		$ok6 = control($post["clName"],$temp["ID"],"Klasse");		
		$data["classFK"] = $temp['ID'];
		
		if(($ok1*$ok2*$ok3*$ok4*$ok5*$ok6) ==1 )
			saveupdate($data,"substitudes");
	}
	else if($post["freeRadio"]=="remove"){
		$data["comment"]=htmlspecialchars($post["comment"]);
		$data["remove"]=true;
		//$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".mysql_real_escape_string(htmlspecialchars($post['clName']))."'"));
		$day = weekday($post["time"]);
		$data["time"]=$post["time"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["oldTeShort"]))."'"));
		$ok1 = control($post["teShort"],$temp["ID"],"Lehrer");		
		$teacher=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["oldStartHour"])."'"));
		$ok2 = control($post["oldStartHour"],$temp["ID"],"Urs. Start-Stunde");		
		$startHour=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["oldEndHour"])."'"));
		$ok3 = control($post["oldEndHour"],$temp["ID"],"Urs. End-Stunde");		
		$endHour=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".mysql_real_escape_string(htmlspecialchars($post['clName']))."'"));
		$ok4 = control($post["clName"],$temp["ID"],"Klasse");		
		$class = $temp['ID'];
		$data["classFK"] = $temp['ID'];
		if(($ok1*$ok2*$ok3*$ok4)==1){
			if($teacher==""){
				$sql = "SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID=lessons.lessonBaseFK WHERE lessonsBase.startHourFK='".$startHour."' AND lessonsBase.endHourFK='".$endHour."' AND lessonsBase.classFK='".$class."'";
				$result = mysql_query($sql);			
				while($row[]=mysql_fetch_array($result)){
				}
				unset($row[count($row)-1]);

				foreach($row as $i => $r){
					$data["lessonFK"]=$r["ID"];
					if($i < 1)
						$data["display"]=true;
					else
						$data["display"]=false;

					saveupdate($data,"substitudes");
				}
				//print_r($row);
			}
			else{
				$sql = "SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID=lessons.lessonBaseFK WHERE lessonsBase.startHourFK='".$startHour."' AND lessonsBase.endHourFK='".$endHour."' AND lessonsBase.classFK='".$class."' AND lessons.teachersFK='".$teacher."'";
				$temp = mysql_fetch_array(mysql_query($sql));
				$data["display"]=true;
				$data["lessonFK"]=$temp["ID"];
				saveupdate($data,"substitudes");
			}
		}	
	}
	else{
		$day = weekday($post["time"]);
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM subjects WHERE short='".mysql_real_escape_string(htmlspecialchars($post["suShort"]))."'"));
		$ok1 = control($post["suShort"],$temp["ID"],"Fach");		
		$data["subjectFK"]= $temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
		$ok2 = control($post["teShort"],$temp["ID"],"Lehrer");
		$data["teacherFK"]=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".mysql_real_escape_string(htmlspecialchars($post["roName"]))."'"));
		$ok3 = control($post["roName"],$temp["ID"],"Raum");		
		$data["roomFK"]=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["startHour"])."'"));
		$ok4 = control($post["startHour"],$temp["ID"],"Start-Stunde");		
		$data["startHourFK"]=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["endHour"])."'"));
		$ok5 = control($post["endHour"],$temp["ID"],"End-Stunde");		
		$data["endHourFK"]=$temp["ID"];
		$data["comment"]=htmlspecialchars($post["comment"]);
		$data["move"]=true;
		$data["time"]=$post["time"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["oldTeShort"]))."'"));
		$ok6 = control($post["oldTeShort"],$temp["ID"],"Urs. Lehrer");		
		$teacher=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["oldStartHour"])."'"));
		$ok7 = control($post["oldStartHour"],$temp["ID"],"Urs. Start-Stunde");		
		$startHour=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["oldEndHour"])."'"));
		$ok8 = control($post["oldEndHour"],$temp["ID"],"Urs. End-Stunde");		
		$endHour=$temp["ID"];
		$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".mysql_real_escape_string(htmlspecialchars($post['clName']))."'"));
		$ok9 = control($post["clName"],$temp["ID"],"Klasse");		
		$class = $temp['ID'];
		$data["classFK"] = $temp['ID'];
		if(($ok1*$ok2*$ok3*$ok4*$ok5*$ok6*$ok7*$ok8*$ok9)==1){
			if($teacher==""){
				$sql = "SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID=lessons.lessonBaseFK WHERE lessonsBase.startHourFK='".$startHour."' AND lessonsBase.endHourFK='".$endHour."' AND lessonsBase.classFK='".$class."'";
				$result = mysql_query($sql);			
				while($row[]=mysql_fetch_array($result)){
				}
				unset($row[count($row)-1]);

				foreach($row as $i => $r){
					$data["lessonFK"]=$r["ID"];
					if($i < 1)
						$data["display"]=true;
					else
						$data["display"]=false;

					saveupdate($data,"substitudes");
				}
				//print_r($row);
			}
			else{
				$sql = "SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID=lessons.lessonBaseFK WHERE lessonsBase.startHourFK='".$startHour."' AND lessonsBase.endHourFK='".$endHour."' AND lessonsBase.classFK='".$class."' AND lessons.teachersFK='".$teacher."'";
				$temp = mysql_fetch_array(mysql_query($sql));
				$data["display"]=true;
				$data["lessonFK"]=$temp["ID"];
				saveupdate($data,"substitudes");
			}	
		}
		
	}
}
else{
	$day = weekday($post["time"]);
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM subjects WHERE short='".mysql_real_escape_string(htmlspecialchars($post["suShort"]))."'"));
	$ok1 = control($post["suShort"],$temp["ID"],"Fach");	
	$data["subjectFK"]= $temp["ID"];
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".mysql_real_escape_string(htmlspecialchars($post["teShort"]))."'"));
	$ok2 = control($post["teShort"],$temp["ID"],"Lehrer");
	$data["teacherFK"]=$temp["ID"];
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".mysql_real_escape_string(htmlspecialchars($post["roName"]))."'"));
	$ok3 = control($post["roName"],$temp["ID"],"Raum");	
	$data["roomFK"]=$temp["ID"];
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["startHour"])."'"));
	$ok4 = control($post["startHour"],$temp["ID"],"Start-Stunde");		
	$data["startHourFK"]=$temp["ID"];
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort='".$day."' AND hour='".intval($post["endHour"])."'"));
	$ok5 = control($post["endHour"],$temp["ID"],"End-Stunde");	
	$data["endHourFK"]=$temp["ID"];
	$data["comment"]=htmlspecialchars($post["comment"]);
	$data["time"]=$post["time"];
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name='".mysql_real_escape_string(htmlspecialchars($post['clName']))."'"));
	$ok6 = control($post["clName"],$temp["ID"],"Klasse");		
	$class = $temp['ID'];
	$data["classFK"] = $temp['ID'];

	if(($ok1*$ok2*$ok3*$ok4*$ok5*$ok6)==1){
		$sql = "SELECT missingTeachers.teacherFK FROM missingTeachers INNER JOIN hours as hourST ON hourST.ID = missingTeachers.startHourFK INNER JOIN hours as hourEN ON hourEN.ID = missingTeachers.endHourFK INNER JOIN lessons ON missingTeachers.teacherFK = lessons.teachersFK INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE missingTeachers.startDay <='".mysql_real_escape_string(htmlspecialchars($post['time']))."' AND missingTeachers.endDay >='".mysql_real_escape_string(htmlspecialchars($post['time']))."' AND hourST.hour <='".intval($post['startHour'])."' AND hourEN.hour >='".intval($post['endHour'])."' AND lessonsBase.startHourFK='".$data["startHourFK"]."' AND lessonsBase.endHourFK='".$data["endHourFK"]."' AND lessonsBase.classFK='".$class."'";
		$temp = mysql_query($sql);
		while($missTeacher[] = mysql_fetch_array($temp)){
		}
		unset($missTeacher[count($missTeacher)-1]);
	
		foreach($missTeacher as $i => $m){
			$sql = "SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.startHourFK='".$data["startHourFK"]."' AND lessonsBase.endHourFK='".$data["endHourFK"]."' AND lessonsBase.classFK='".$class."' AND lessons.teachersFK = '".$m["teacherFK"]."'";
			$temp = mysql_query($sql);
			$temp = mysql_fetch_row($temp);
			$data["lessonFK"] = $temp[0];

			if($i < 1)
				$data["display"]=true;
			else
				$data["display"]=false;
			
			if(empty($post["delete"]))
				saveupdate($data,"substitudes");
		}
		if(empty($missTeacher))
			return false;
		else
			return true;
	}	
}
}
return true;


}

function teachers(){

$post=$_POST;
unset($post["save"]);

$data=array("ID" => "","name" => "","short" => "","display" => "","sectionFK" => "","invisible" => "");

$data["ID"]=$post["ID"];
$data["name"]=htmlspecialchars($post["teName"]);
$data["short"]=$post["teShort"];
$data["display"]=htmlspecialchars($post["display"]);
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM sections WHERE short='".mysql_real_escape_string(htmlspecialchars($post["seShort"]))."'"));
$ok1 = control($post["seShort"],$temp["ID"],"Abteilung");	
$data["sectionFK"] = $temp["ID"];
if(!empty($post["invisible"]) && $ok1 == 1)
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
//mysql_error();
}

function deleteID($ID,$table){

$sql="DELETE FROM ".$table." WHERE ID = '".$ID."'";
mysql_query($sql);

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
