<?php

	include("../../config.php");
    include(ROOT_LOCATION . "/modules/database/selects.php");		//Stellt die select-Befehle zur Verfügung

    include(ROOT_LOCATION . "/modules/general/Connect.php");		//Stellt Verbindung mit der Datenbank her
    include(ROOT_LOCATION . "/modules/general/SessionManager.php");	//SessionManager um Sessions für die App-Nutzung zu verwenden

	header('Content-Type: application/javascript; charset=UTF-8');	
	

	
	

	//echo "console.log(".print_r($_SESSION).");";
	$class = $_SESSION['class'];
	$id = $_SESSION['id'];
	$name = $_SESSION['name'];

	
	/*************************
	Einlesen der Supplierungen
	*************************/

	echo "var actualClass = 0;\n";
	echo "var teacher = 0;\n";
	$date = strftime("%Y-%m-%d");


	if(!$_SESSION['isTeacher'])
	{
		$where = "classes.name='".$class."' AND time >='".$date."'";
		echo "var actualClass = '$class';\n";
	}
	else
	{
		$where = "teachers.short='".$id."' AND time >='".$date."'";
		echo "var teacher = '$name';\n";
	}

	$substitude_sql = selectSubstitude($where,"substitudes.time, hoursStart.hour");	
	$substitude = array();
	while($substitude = mysql_fetch_array($substitude_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
		$substitudes[]=$substitude;
	}
	$substitudes = json_encode($substitudes);


	echo "var subsObject = JSON.parse('" . $substitudes . "');\n";



	/********************
	Einlesen der Stunden
	********************/


?>


$( document ).ready(function() {

	var j;	
	var i;
	var iOld;
	var Lesson;


for(aSubstitude in subsObject){					
		var substitude = subsObject[aSubstitude];
		substitude.substitude = "1";
		console.log(substitude.subject);
		
		switch(substitude.weekdayShort)
		{
		case "Mo":
		  var day = 1;
		  break;
		case "Di":
		  var day = 2;
		  break;
		  case "Mi":
		  var day = 3;
		  break;
		case "Do":
		  var day = 4;
		  break;
		  case "Fr":
		  var day = 5;
		  break;		
		}

		var oldStart = substitude.oldStartHour;
		var newStart = substitude.startHour;
		var oldCell = "" + day + oldStart;
		var newCell = "" + day + newStart;

		for(;parseInt(oldStart) <= substitude.oldEndHour; oldStart=parseInt(oldStart) + 1)
		{
			
			var oldCell = "" + day + oldStart;	//Variable wird aus Zahl in String umgewandelt
			console.log(oldCell);
			console.log(substitude.suShort);

			if(substitude.remove == "1")
			{				
				document.getElementById(oldCell).style.color="red";
			}
			else if(substitude.move == "1")
			{
				document.getElementById(oldCell).style.color="red";
			}
			else if(substitude.remove != "1" && substitude.move != "1" && substitude.newSub != "1")
			{
				document.getElementById(oldCell).style.color="yellow";
			}
			
			
		}

		for(;parseInt(newStart) <= substitude.oldEndHour; newStart=parseInt(newStart) + 1)
		{
			
			var newCell = "" + day + newStart;	//Variable wird aus Zahl in String umgewandelt
			console.log(newCell);
			console.log(substitude.suShort);

			else if(substitude.move == "1")
			{
				document.getElementById(newCell).style.color="green";
				var Lesson = lesson.suShort;
				document.getElementById(newCell).innerHTML=Lesson;
			}
			else if(substitude.newSub == "1")
			{
				document.getElementById(newCell).style.color="yellow";
				var Lesson = lesson.suShort;
				document.getElementById(newCell).innerHTML=Lesson;
			}
			
			
		}



	




	}
				
});