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
var ii = 1;

do{

document.getElementById('visibleRow1'+ii).style.visibility="visible";
ii+=1;

}while(ii<="16");

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


print_r($_POST);





//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "roName",	"Raum: ", 			"dropdown", "8",	"",		$selectRooms,		""),
	array( "teShort", 	"Lehrer: ",	 		"dropdown",	"5",	"",		$selectTeachers,	""),
	array( "suShort", 	"Fach: ", 			"dropdown",	"5",	"",		$selectSubjects,	""),
	);

//Seitenheader
pageHeader("Formular","main");

$where="classes.name='".$_POST['class']."' AND hoursStart.weekdayShort='".$_POST['day']."'";
$result = selectLesson($where,"");	//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	print_r($row);
}
form_lesson($fields,false);		//Formular wird erstellt



if(!empty($_POST['hour'])){

	
	printf("<script type=\"text/javascript\">text(%s,%s); Visibility(%s);</script>",$_POST['visibilityText'.$_POST['hour']],$_POST['hour'],$_POST['hour']);
}
//Seitenfooter
pageFooter();
?>
