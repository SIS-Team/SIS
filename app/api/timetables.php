/***************
	SCRIPT.PHP
***************/
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

	if(!$_SESSION['isTeacher'])
	{
		$where = "classes.name='".$class."'";
		echo "var actualClass = '$class';\n";
	}
	else
	{
		$where = "teachers.short='".$id."'";
		echo "var teacher = '$name';\n";
	}
	$lesson_sql = selectLesson($where,"");	
	$lesson = array();
	while($lesson = mysql_fetch_array($lesson_sql)) {	//durchlauft die Schleife so oft wie es Datensätze gibt
		$lessons[]=$lesson;
		//echo "alert($lesson);";
	}
	$lessons = json_encode($lessons);

	//echo "alert($lessons);";
	echo "var timetObject = JSON.parse('" . $lessons . "');\n";
?>



$( document ).ready(function() {

	if(actualClass != 0)
		document.getElementById("class").innerHTML="Stundenplan "+actualClass;
	else
		document.getElementById("class").innerHTML="Studnenplan "+teacher;

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
		var cell = day + start;			
		//sdocument.write(lesson.seName);
								
		for(;parseInt(start) <= lesson.endHour; start=parseInt(start) + 1)
		{
			
			var cell = "" + day + start;
			console.log(cell);
			timetObject[aLesson].cellid = timetObject[aLesson].cellid + cell  + "/";
			console.log(lesson.suShort);
			if(document.getElementById(cell).innerHTML.indexOf(lesson.suShort) == -1 )
			{
				if(document.getElementById(cell).innerHTML == "")
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
		else if(start >= 12 && actualClass == 0){
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

