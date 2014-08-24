<?php

 	require("../../config.php");
    require(ROOT_LOCATION . "/modules/database/selects.php");		//Stellt die select-Befehle zur Verfügung

    require(ROOT_LOCATION . "/modules/general/Connect.php");		//Stellt Verbindung mit der Datenbank her
    require(ROOT_LOCATION . "/modules/general/SessionManager.php");	//SessionManager um Sessions für die App-Nutzung zu verwenden


	header('Content-Type: application/javascript; charset=UTF-8');	
	

	//Die Session und die Klasse des Nutzers werden bestimmt 
	$class = $_SESSION['class'];
	$id = $_SESSION['id'];
	$name = $_SESSION['name'];
	//$classes = $_GET['classes'];
	$where = "";

	echo "var actualClass = 0;\n";
	echo "var teacher = 0;\n";
	//echo "var classes = '".$classes."';\n";
	$date = strftime("%Y-%m-%d");



	if(!$_SESSION['isTeacher'])	//Wenn Schüler dann alle Einträge der selben Klasse
	{
		echo "alert('Sie sind nicht als Lehrer angemeldet!!!getClasses');\n";
	}
	else	//ansonsten(also Lehrer) alle Einträge des selben Lehrers
	{
		$where = "";
	}


	//Einträge werden aus Datenbank ausgelesen
	$classes_sql = selectClass($where,"clName");	
	$classes = array();
	while($classes = mysql_fetch_array($classes_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
		$allClasses[]=$classes;
	}
	$allClasses = json_encode($allClasses);	//die Daten aus der Datenbank werden in ein JSON-Objekt umgewandelt, um die Nutzung der Daten mit JS zu vereinfachen
	
	echo "var allClassesObject = JSON.parse('" . $allClasses . "');\n";	//echo damit diese Zeile in der geladenen JS-Skript Datei auch dasteht

?>

$( document ).ready(function() {

	var j = 0;	
	var i = 0;
	var iOld;
	var timeOld=0;
	var i = 0;

	for(aLesson in allClassesObject){	
		var lesson = allClassesObject[aLesson];		

		var newOption = document.createElement("option");
		newOption.id = "option" + i;
		newOption.value = lesson.clName;
		document.getElementById("classes").appendChild(newOption);

		document.getElementById("option" + i).innerHTML=lesson.clName;
		
		if(classes == lesson.clName)
			newOption.selected="selected";

		i++;
	}

});