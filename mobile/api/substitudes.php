
<!-------------------------------------------------->
<!--Zuerst wird der PHP-Teil vom Server ausgeführt-->
<!-------------------------------------------------->

<?php

 	include("../../config.php");
    include(ROOT_LOCATION . "/modules/database/selects.php");		//Stellt die select-Befehle zur Verfügung

    include(ROOT_LOCATION . "/modules/general/Connect.php");		//Stellt Verbindung mit der Datenbank her
    include(ROOT_LOCATION . "/modules/general/SessionManager.php");	//SessionManager um Sessions für die App-Nutzung zu verwenden


	header('Content-Type: application/javascript; charset=UTF-8');	
	

	//Die Session und die Klasse des Nutzers werden bestimmt 
	$class = $_SESSION['class'];
	$id = $_SESSION['id'];
	$name = $_SESSION['name'];

	echo "var actualClass = 0;\n";
	echo "var teacher = 0;\n";
	$date = strftime("%Y-%m-%d");



	if(!$_SESSION['isTeacher'])	//Wenn Schüler dann alle Einträge der selben Klasse
	{
		$where = "classes.name='".$class."' AND time >='".$date."'";
		echo "var actualClass = '$class';\n";
	}
	else	//ansonsten(also Lehrer) alle Einträge des selben Lehrers
	{
		$where = "(teachers.short='".$id."' OR oldTeacher.short='".$id."') AND time >='".$date."'";

		echo "var teacher = '$name';\n";
	}

	//Einträge werden aus Datenbank ausgelesen
	$substitude_sql = selectSubstitude($where,"substitudes.time, hoursStart.hour");	
	$substitude = array();
	while($substitude = mysql_fetch_array($substitude_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
		$substitudes[]=$substitude;
	}
	$substitudes = json_encode($substitudes);	//die Daten aus der Datenbank werden in ein JSON-Objekt umgewandelt, um die Nutzung der Daten mit JS zu vereinfachen
	
	echo "var subsObject = JSON.parse('" . $substitudes . "');\n";	//echo damit diese Zeile in der geladenen JS-Skript Datei auch dasteht

?>

<!---------------------------------------------------------------------->
<!--Danach wird der JS-Teil geladen und lokal auf dem Gerät ausgeführt-->
<!---------------------------------------------------------------------->

$( document ).ready(function() {

	var j = 0;	
	var i = 0;
	var iOld;
	var timeOld=0;

	for(aSubstitude in subsObject){					
		var substitude = subsObject[aSubstitude];

		console.log(substitude.subject);	//Darstellung der Daten in der Browserkonsole zur Überprüfung
		

		
		var start = substitude.oldStartHour;

		for(;parseInt(start) <= substitude.oldEndHour; start=parseInt(start) + 1)
		{	

			j = start;
			j = 1;
			i++;

			var newTR = document.createElement("tr");
			newTR.id = "Supplierung";
			document.getElementById("Tabelle").appendChild(newTR);

			if(substitude.time != timeOld && timeOld != 0){
			
				//Eine Zeile aus der Supplierplantabelle wird erzeugt und dargestellt						
				var newTD = document.createElement("td");
				newTD.id = i + j + "1";
				newTD.style.borderTop = "7px solid white";
				newTR.appendChild(newTD);

				var newTD = document.createElement("td");
				newTD.id = i + j + "2";
				newTD.style.borderTop = "7px solid white";
				newTR.appendChild(newTD);

				var newTD = document.createElement("td");
				newTD.id = i + j + "3";
				newTD.style.borderTop = "7px solid white";
				newTR.appendChild(newTD);
				/*
				if(teacher != 0){
					var newTD = document.createElement("td");
					newTD.id = i + j + "4";
					newTD.style.borderTop = "7px solid white";
					newTR.appendChild(newTD);
				}
				*/
				var newTD = document.createElement("td");
				newTD.id = i + j + "5";
				newTD.style.borderTop = "7px solid white";
				newTR.appendChild(newTD);

				var newTD = document.createElement("td");
				newTD.id = i + j + "6";
				newTD.style.borderTop = "7px solid white";
				newTR.appendChild(newTD);
			}
			else{
				//Eine Zeile aus der Supplierplantabelle wird erzeugt und dargestellt						
				var newTD = document.createElement("td");
				newTD.id = i + j + "1";
				newTR.appendChild(newTD);

				var newTD = document.createElement("td");
				newTD.id = i + j + "2";
				newTR.appendChild(newTD);

				var newTD = document.createElement("td");
				newTD.id = i + j + "3";
				newTR.appendChild(newTD);
				/*
				if(teacher != 0){
					var newTD = document.createElement("td");
					newTD.id = i + j + "4";
					newTR.appendChild(newTD);
				}
				*/
				var newTD = document.createElement("td");
				newTD.id = i + j + "5";
				newTR.appendChild(newTD);

				var newTD = document.createElement("td");
				newTD.id = i + j + "6";
				newTR.appendChild(newTD);
			}
			
			//Der Inhalt wird in die Zeile eingetragen
			document.getElementById(i + j + "1").innerHTML=substitude.time;
			document.getElementById(i + j + "2").innerHTML=start;
			document.getElementById(i + j + "3").innerHTML=substitude.oldSuShort;
			/*if(teacher != 0){
				document.getElementById(i + j + "4").innerHTML=substitude.clName;
			}*/
			document.getElementById(i + j + "5").innerHTML=substitude.teShort;
			document.getElementById(i + j + "6").innerHTML=substitude.comment;
			j++;

			timeOld=substitude.time;
		}
	}

});