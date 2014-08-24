<?php
	require($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
	//die nächste datei würde dei db connect ersetzen
	require($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");			//Bindet die Datenbank ein

	require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/SessionManager.php");

	header('Content-Type: application/javascript; charset=UTF-8');					//setzt den Content-Type auf application/javascript damit die JSON-Übertragung funktioniert
			
		
	//call the passed in functions
	if(isset($_GET['method'])&& !empty($_GET['method'])) {
		if(function_exists($_GET['method'])){
			$_GET['method']();
		}

	}

	function loginApp(){
		try {
			login($_GET['username'],$_GET['password']);
		} catch (Exception $e) {
			echo $_GET['jsoncallback'] . '({"error": "Benutzername oder Passwort falsch!"})';
			die();
		}
		getLessonsByClass();
	}

	//methods
	function getLessonsByClass(){
		$class = $_GET['class'];
		//$class = $_SESSION['class'];

		$where = "classes.name='".$class."'";
		$lesson_sql = selectLesson($where,"");	
		$lesson = array();
		while($lesson = mysql_fetch_array($lesson_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
			$lessons[]=$section;
		}
		$lessons = json_encode($lessons);
		echo $_GET['jsoncallback'] . '(' . $lessons . ')';
	}


	function getLessonsByTeacher(){
		$teacher = $_GET['teacher'];

		$where = "teachers.short='".$teacher."'";
		$section_sql = selectLesson($where,"");	
		$sections = array();
		while($section = mysql_fetch_array($section_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
			$sections[]=$section;
		}
		$sections = json_encode($sections);
		echo $_GET['jsoncallback'] . '(' . $sections . ')';
	}


	function getSubstitude(){
		$class = $_GET['class'];
		$start = $_GET['startHour'];

		

		$where = "classes.name='".$class."'";
		$section_sql = selectSubstitude($where,"substitudes.time, hoursStart.hour");	
		$sections = array();
		while($section = mysql_fetch_array($section_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
			$sections[]=$section;
		}
		$sections = json_encode($sections);
		echo $_GET['jsoncallback'] . '(' . $sections . ')';
	}
	

?>
