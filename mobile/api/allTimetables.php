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

	if(!$_SESSION['isTeacher'])//Wenn Schüler dann alle Einträge der selben Klasse
	{
		echo "alert("Du bist nicht als Lehrer angemeldet!!!");";
	}
	else 	//ansonsten(also Lehrer) alle Einträge des selben Lehrers
	{
		$where = $_POST['classes'];
		echo "var teacher = '$name';\n";
	}
	
	//Einträge werden aus Datenbank ausgelesen
	$lesson_sql = selectLesson($where,"");	
	$lesson = array();
	while($lesson = mysql_fetch_array($lesson_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
		$lessons[]=$lesson;
	}
	$lessons = json_encode($lessons);	//die Daten aus der Datenbank werden in ein JSON-Objekt umgewandelt, um die Nutzung der Daten mit JS zu vereinfachen

	echo "var timetObject = JSON.parse('" . $lessons . "');\n";

	
?>


<!---------------------------------------------------------------------->
<!--Danach wird der JS-Teil geladen und lokal auf dem Gerät ausgeführt-->
<!---------------------------------------------------------------------->

$( document ).ready(function() {
	



	for(aLesson in timetObject){					
		var lesson = timetObject[aLesson];
		switch(lesson.weekdayShort)
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
		
		var start = lesson.startHour;
		var cell = day + start;	//Festlegen in welcher Zelle die Stunde eingetragen werden soll	
		//sdocument.write(lesson.seName);
		timetObject[aLesson].cellid = "";

		for(;parseInt(start) <= lesson.endHour; start=parseInt(start) + 1)
		{
			
			var cell = "" + day + start;	//Variable wird aus Zahl in String umgewandelt
			console.log(cell);
			timetObject[aLesson].cellid = timetObject[aLesson].cellid + cell  + "/";	//Zell-ID wird gespeichert, fuer weitere Verwendung bei Popups(popup.js)
			console.log(lesson.suShort);
			console.log(timetObject[aLesson].cellid)
			if(document.getElementById(cell).innerHTML.indexOf(lesson.suShort) == -1 )
			{
				if(document.getElementById(cell).innerHTML == "")  //Übeprüfen ob bereits eine Stunde eingetragen
					var Lesson = lesson.suShort;
				else
					var Lesson = document.getElementById(cell).innerHTML + " | " + lesson.suShort;
				
				document.getElementById(cell).innerHTML=Lesson;
			}
			
			
		}

		start = start - 1;//start ist um 1 zu groß wegen for-Schleife
		//Wenn ein Eintrag nach der 11. Stunde existiert --> Abendschule --> nur Abend einblenden
		if(start >= 12 && actualClass != 0){
			$( document ).ready(function() {
				$('.normal').css('display', 'none');
				$('.evening').css('display', 'table-row');
			});
		}
		else if(start >= 12 && actualClass == 0){		//Wenn ein Eintrag nach der 11.Stunde existiert und es sich um keine Klasse handelt(also Lehrer) --> ganzen Tag einblenden
			$( document ).ready(function() {
				$('.normal').css('display', 'table-row');
				$('.evening').css('display', 'table-row');
			});
		}
		//Wenn kein Eintrage nach der 11. Stunde --> normaler Unterricht --> Abend ausblenden
		else{
			$( document ).ready(function() {
				$('.evening').css('display', 'none');
			});
		}		

	}
});

$.get("./css/main.css", function(css) {
$("head").append("<style type='text/css'>"+css+"</style>");
});