<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
	//die nächste datei würde dei db connect ersetzen
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");			//Bindet die Datenbank ein

	header('Content-Type: application/javascript; charset=UTF-8');					//setzt den Content-Type auf application/javascript damit die JSON-Übertragung funktioniert
			
		
	//call the passed in functions
	if(isset($_GET['method'])&& !empty($_GET['method'])) {
		if(function_exists($_GET['method'])){
			$_GET['method']();
		}

	}


	//methods
	function getLessons(){
		$class = $_GET['class'];
		$start = $_GET['startHour'];

		

		$where = "classes.name='".$class."'";
		$section_sql = selectLesson($where,"");	
		$sections = array();
		while($section = mysql_fetch_array($section_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
			$sections[]=$section;
		}
		$sections = json_encode($sections);
		echo $_GET['jsoncallback'] . '(' . $sections . ')';
	}

?>