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
    
	$week = $_GET['week'];
	
	/*************************
	Einlesen der Supplierungen
	*************************/
	echo "var week = 1;\n";
	echo "var week =". $week . ";\n";
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
		$where = "(teachers.short='".$id."' OR oldTeacher.short='".$id."') AND time >='".$date."'";
		echo "var teacher = '$name';\n";
	}

	$substitude_sql = selectSubstitude($where,"substitudes.time, hoursStart.hour");	
	$substitude = array();
	$substitudes = array();
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
	var oldCell = "";
	var newCell = "";
	var today = new Date();
	var today2 = new Date();

	var d = new Date();
	var weekDay = d.getDay();
	var diff = d.getDate() - weekDay;
	var displayDate = new Date(d.setDate(diff));
	var displ_date = displayDate.getDate();
	var displ_month = displayDate.getMonth();
	var displ_year = displayDate.getFullYear();


	//if(week==1)
	//	document.getElementById("weekDate").innerHTML= displ_date + 1 + "-" + displ_month + "-" + displ_year ;
	//else if(week==2)
	//	document.getElementById("weekDate").innerHTML= displ_date + 8 + "-" + displ_month + "-" + displ_year;


for(aSubstitude in subsObject){					
		var substitude = subsObject[aSubstitude];
		substitude.substitude = "1";
		var date = new Date(substitude.time);
		console.log(substitude.subject);
		var weekday = date.getDay();
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
		var oldCell = "" + weekday + oldStart;
		var newCell = "" + weekday + newStart;


		if(week == 1){
			
			today.setDate(today.getDate() - today.getDay() + 6);
			
			if(today >= date){
				console.log("do her a nu");
				for(;parseInt(oldStart) <= substitude.oldEndHour; oldStart=parseInt(oldStart) + 1)
				{
					
					var oldCell = "" + weekday + oldStart;	//Variable wird aus Zahl in String umgewandelt
					console.log(oldCell + "des is Woche 1");
					console.log(substitude.suShort);

					if(substitude.remove == "1" && document.getElementById(oldCell).style.color!="green")
					{				
						document.getElementById(oldCell).style.color="red";
						document.getElementById(oldCell).innerHTML="";
					}
					else if(substitude.move == "1")
					{
						document.getElementById(oldCell).style.color="red";
						document.getElementById(oldCell).innerHTML="";
					}
					else if(substitude.remove != "1" && substitude.move != "1" && substitude.newSub != "1")
					{
						document.getElementById(oldCell).style.color="yellow";
						document.getElementById(oldCell).setAttribute("data-substitude", aSubstitude);
						if(!document.getElementById(oldCell).innerHTML)
							document.getElementById(oldCell).innerHTML = substitude.suShort;

					}
					
					
				}

				for(;parseInt(newStart) <= substitude.endHour; newStart=parseInt(newStart) + 1)
				{
					
					var newCell = "" + day + newStart;	//Variable wird aus Zahl in String umgewandelt
					console.log(newCell);
					console.log(substitude.suShort);

					if(substitude.move == "1")
					{
						document.getElementById(newCell).style.color="green";
						var Lesson = substitude.suShort;
						document.getElementById(newCell).innerHTML=Lesson;
						document.getElementById(newCell).setAttribute("data-substitude", aSubstitude);
					}
					else if(substitude.newSub == "1")
					{
						document.getElementById(newCell).style.color="green";
						var Lesson = substitude.suShort;
						document.getElementById(newCell).innerHTML=Lesson;
						document.getElementById(newCell).setAttribute("data-substitude", aSubstitude);
					}
									
				}
			}
		}
		else if(week = 2){
			today2.setDate(today2.getDate() - today2.getDay() + 13);
			today.setDate(today.getDate() - today.getDay() + 6);

			if(today2 >= date && today < date){
				
				for(;parseInt(oldStart) <= substitude.oldEndHour; oldStart=parseInt(oldStart) + 1)
				{
					
					var oldCell = "" + weekday + oldStart;	//Variable wird aus Zahl in String umgewandelt
					console.log(oldCell);
					console.log(substitude.suShort);

					if(substitude.remove == "1" && document.getElementById(oldCell).style.color!="green")
					{				
						document.getElementById(oldCell).style.color="red";
						document.getElementById(oldCell).innerHTML="";
					}
					else if(substitude.move == "1")
					{
						document.getElementById(oldCell).style.color="red";
						document.getElementById(oldCell).innerHTML="";
					}
					else if(substitude.remove != "1" && substitude.move != "1" && substitude.newSub != "1")
					{
						document.getElementById(oldCell).style.color="yellow";
						document.getElementById(oldCell).setAttribute("data-substitude", aSubstitude);

					}
					
					
				}

				for(;parseInt(newStart) <= substitude.endHour; newStart=parseInt(newStart) + 1)
				{
					
					var newCell = "" + day + newStart;	//Variable wird aus Zahl in String umgewandelt
					console.log(newCell);
					console.log(substitude.suShort);

					if(substitude.move == "1")
					{
						document.getElementById(newCell).style.color="green";
						var Lesson = substitude.suShort;
						document.getElementById(newCell).innerHTML=Lesson;
						document.getElementById(newCell).setAttribute("data-substitude", aSubstitude);
					}
					else if(substitude.newSub == "1")
					{
						document.getElementById(newCell).style.color="green";
						var Lesson = substitude.suShort;
						document.getElementById(newCell).innerHTML=Lesson;
						document.getElementById(newCell).setAttribute("data-substitude", aSubstitude);
					}
									
				}
			}
		}

	}
				
});