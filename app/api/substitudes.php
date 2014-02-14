
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
		$where = "newTeacher.short='".$id."' AND time >='".$date."'";

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

	var j;	
	var i;
	var iOld;

	for(aSubstitude in subsObject){					
		var substitude = subsObject[aSubstitude];

		console.log(substitude.subject);	//Darstellung der Daten in der Browserkonsole zur Überprüfung
		
		i = substitude.startHour;
		if(j == 1)	//Falls mehrere Stunden mit der selben Startstunde(z.B. Doppelstunden) auftreten
			iOld = i;
		
		var start = substitude.startHour;

		for(;parseInt(start) <= substitude.endHour; start=parseInt(start) + 1)
		{
			var newTR = document.createElement("tr");
			newTRid = "Supplierung";
			document.getElementById("Tabelle").appendChild(newTR);
			
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
			var newTD = document.createElement("td");
			newTD.id = i + j + "4";
			newTR.appendChild(newTD);
			var newTD = document.createElement("td");
			newTD.id = i + j + "5";
			newTR.appendChild(newTD);
			
			
			//Der Inhalt wird in die Zeile eingetragen
			document.getElementById(i + j + "1").innerHTML=substitude.time;
			document.getElementById(i + j + "2").innerHTML=start;
			document.getElementById(i + j + "3").innerHTML=substitude.suShort;
			document.getElementById(i + j + "4").innerHTML=substitude.teShort;
			document.getElementById(i + j + "5").innerHTML=substitude.comment;
			j++;
			if(i != iOld)
				j = 1;
		}
	}

});