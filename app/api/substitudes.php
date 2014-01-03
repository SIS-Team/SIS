<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
	//die nächste datei würde dei db connect ersetzen
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/SessionManager.php");			//Stellt die select-Befehle zur Verfügung

	header('Content-Type: application/javascript; charset=UTF-8');	
	

	
	

	//echo "console.log(".print_r($_SESSION).");";
	$class = $_SESSION['class'];
	$id = $_SESSION['id'];
	$name = $_SESSION['name'];

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
		$where = "teachers.short='".$id."'";
		echo "var teacher = '$name';\n";
	}


	$substitude_sql = selectSubstitude($where,"substitudes.time, hoursStart.hour");	
	$substitudes = array();
	while($substitude = mysql_fetch_array($substitude_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
		$substitudes[]=$substitude;
	}
	$substitudes = json_encode($substitudes);

	//echo "alert($lessons);";
	echo "var subsObject = JSON.parse('" . $substitudes . "');\n";

?>


$( document ).ready(function() {

	var j;	
	var i;
	var iOld;

	for(aSubstitude in subsObject){					
		var substitude = subsObject[aSubstitude];

		/*console.log("startHour: " + substitude.startHour);
		console.log("Hour: " + j)*/
		i = substitude.startHour;
		if(j == 1)
			iOld = i;

		var newTR = document.createElement("tr");
		newTR.id = "Supplierung";
		document.getElementById("Tabelle").appendChild(newTR);
								
		var newTD = document.createElement("td");
		newTD.id = i + j + "1";
		newTR.appendChild(newTD);
		var newTD = document.createElement("td");
		newTD.id = i + j + "2";
		newTR.appendChild(newTD);
		var newTD = document.createElement("td");
		newTD.id = i + j + "3";
		newTR.appendChild(newTD);
		var newTD = document.createElement("td");
		newTD.id = i + j + "4";
		newTR.appendChild(newTD);
		var newTD = document.createElement("td");
		newTD.id = i + j + "5";
		newTR.appendChild(newTD);
		
		
		//var i = lesson.startHour + j;			
		//sdocument.write(lesson.seName);
		console.log(i + j + "1");
		document.getElementById(i + j + "1").innerHTML=substitude.time;
		document.getElementById(i + j + "2").innerHTML=substitude.startHour;
		document.getElementById(i + j + "3").innerHTML=substitude.suShort;
		document.getElementById(i + j + "4").innerHTML=substitude.teShort;
		document.getElementById(i + j + "5").innerHTML=substitude.comment;
		j++;
		if(i != iOld)
			j = 1;
	}
				
});