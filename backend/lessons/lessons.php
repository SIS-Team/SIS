<script type="text/javascript">
function Visibility(hour) {
	
var temp = parseInt(document.getElementById('visibilityText'+hour).value);	

switch(temp){
	case 2: 
		var zahl = 2; 
		break;
	case 3: 
		var zahl = 3;
		break; 
	case 4: 
		var zahl = 4; 
		break;
	case 5: 
		var zahl = 5; 
		break;
	default: 
		var zahl = 1;
		break;
}

var i=2;

document.getElementById('visibleRow2'+hour).style.visibility="collapse";
document.getElementById('visibleRow3'+hour).style.visibility="collapse";
document.getElementById('visibleRow4'+hour).style.visibility="collapse";
document.getElementById('visibleRow5'+hour).style.visibility="collapse";


while(i<=zahl){

document.getElementById('visibleRow'+i+hour).style.visibility="visible";

i++;
}

}

function text(text,hour){

document.getElementById('visibilityText'+hour).value = text;

document.getElementsByName('visibilityText'+hour)[1].value=text;
document.getElementsByName('visibilityText'+hour)[2].value=text;
document.getElementsByName('visibilityText'+hour)[3].value=text;
document.getElementsByName('visibilityText'+hour)[4].value=text;

}

function changeText(hour){

var text;
text=document.getElementById('visibilityText'+hour).value;

document.getElementsByName('visibilityText'+hour)[1].value=text;
document.getElementsByName('visibilityText'+hour)[2].value=text;
document.getElementsByName('visibilityText'+hour)[3].value=text;
document.getElementsByName('visibilityText'+hour)[4].value=text;

}

function visibleHours(hour){


var length=parseInt(document.getElementById('visibleHour'+hour).value);
var endHour = hour + length -1;
var ii = hour+1;

while(ii<=16){

if(parseInt(document.getElementById('visibleHour'+ii).value)==1){
	document.getElementById('visibleRow1'+ii).style.visibility="visible";
	ii+=1;
}
else
	ii+=parseInt(document.getElementById('visibleHour'+ii).value);

}

ii=hour+1;

while(ii<=endHour){

document.getElementById('visibleRow1'+ii).style.visibility="collapse";
document.getElementById('visibleRow2'+ii).style.visibility="collapse";
document.getElementById('visibleRow3'+ii).style.visibility="collapse";
document.getElementById('visibleRow4'+ii).style.visibility="collapse";
document.getElementById('visibleRow5'+ii).style.visibility="collapse";
ii+=1;

}

}


</script>



<?php

	/* /backend/lessons.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Unterrichtsstunden
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */

include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verf�gung

if(empty($_POST['class'])){
	header('Location: index.php');
	exit();
}else if(empty($_POST['day']))
	$_POST['day']="Mo";
	
if($_POST['save']!="")
	lessons();


//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "roName",	"Raum: ", 			"dropdown", "8",	"",		$selectRooms,		""),
	array( "teShort", 	"Lehrer: ",	 		"dropdown",	"5",	"",		$selectTeachers,	""),
	array( "suShort", 	"Fach: ", 			"dropdown",	"5",	"",		$selectSubjects,	""),
	);

//Seitenheader
pageHeader("Formular","main");
printf("Klasse: <a href=\"index.php\" >%s</a> und der Tag: %s",$_POST['class'],$_POST['day']);
$days=prevNextDay($_POST['day']);

printf("<form action=\"lessons.php\" method=\"post\">\n");
printf("<table width=\"100%%\"><tr>");

if($days['prev']!="")
	printf("<td><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['prev']);
	
printf("<td><input type=\"hidden\" name=\"class\" value=\"%s\"</td>\n",$_POST['class']);

if($days['next']!="")
	printf("<td style=\"text-align:right\"><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['next']);
printf("</tr></table></form>\n");


$where="classes.name='".$_POST['class']."' AND hoursStart.weekdayShort='".$_POST['day']."'";
$sort="hoursStart.hour ASC";
$result = selectLesson($where,"");	//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht

  	$sql= "SELECT COUNT(*) FROM lessons INNER JOIN rooms ON rooms.ID = lessons.roomFK INNER JOIN teachers ON teachers.ID = lessons.teachersFK INNER JOIN subjects ON subjects.ID = lessons.subjectFK INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK INNER JOIN classes ON classes.ID = lessonsBase.classFK INNER JOIN hours as hoursStart ON hoursStart.ID = lessonsBase.startHourFK INNER JOIN hours as hoursEnd ON hoursEnd.ID = lessonsBase.endHourFK";	//Stamm sql-Befehl
	$where2 = " AND " . "hoursStart.hour='".$row['startHour']."' AND hoursEnd.hour='".$row['endHour']."'";
	$sql .= " WHERE " . $where.$where2; 
	
	$same = mysql_result(mysql_query($sql),0);
	//print_r($same);
	$row['same']=$same;
	$content[] = $row;
}
	$sql= "SELECT COUNT(*) FROM lessons INNER JOIN rooms ON rooms.ID = lessons.roomFK INNER JOIN teachers ON teachers.ID = lessons.teachersFK INNER JOIN subjects ON subjects.ID = lessons.subjectFK INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK INNER JOIN classes ON classes.ID = lessonsBase.classFK INNER JOIN hours as hoursStart ON hoursStart.ID = lessonsBase.startHourFK INNER JOIN hours as hoursEnd ON hoursEnd.ID = lessonsBase.endHourFK";	//Stamm sql-Befehl
	$sql .= " WHERE " . $where; 
	//$content[] = mysql_result(mysql_query($sql),0);

//print_r(end($content));
form_lesson($fields,$content);		//Formular wird erstellt



if(!empty($_POST['hour'])){

	
	printf("<script type=\"text/javascript\">text(%s,%s); Visibility(%s);</script>",$_POST['visibilityText'.$_POST['hour']],$_POST['hour'],$_POST['hour']);
}
//Seitenfooter
pageFooter();
?>
