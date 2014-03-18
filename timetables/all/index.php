<?php
	/* /timetables/all/index.php
	 * Autor: Weiland Mathias
	 * Beschreibung:
	 *	Gibt Stundenplan von allen Klassen/Lehrern aus
	 */
include_once("../../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verf�gung
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verf�gung

ifNotLoggedInGotoLogin();	//Kontrolle ob angemeldet
$permission = getPermission();
if($permission !='root' && $permission != 'admin') noPermission();
pageHeader("Alle Stundenpl&auml;ne","main");


if(!empty($_GET['teacher'])){
	$name = $_GET['teacher'];
	$mode = 'teacher'; 
}
else {
	if(!empty($_GET['class'])){
		$name = $_GET['class'];
		$mode = 'class'; 
	}
	else {
 	unset($mode);
	}
}


if(isset($mode)){
	$lessons = getLessons ($name,$mode);
	$hours = orderLessons($lessons);

	$classType = isEvening($hours);	//kontrolliert ob Abendschule
	if($classType == "evening")	//nur Abendschule
	{
 		$tableBegin = 12;
	 	$tableEnd=17;}
	 
	else {	//nur erste 11 Stunden
 		if($classType == "normal"){
 			$tableBegin = 1;
 			 $tableEnd = 12;
 		}
 		else{ 	//alle Stunden 	
 			$tableBegin = 1;
 			$tableEnd = 17;
 		}
 	}

	echo "<div class ='timetable_column'>";
	echo "<table border = 1>";
	echo "<tr><th>Stunde</th><th>Mo</th><th>Di</th><th>Mi</th><th>Do</th><th>Fr</th></tr>";
	for($i = $tableBegin;$i<$tableEnd;$i++)
	{ 
	 	echo "<tr><td>".$i."</td>";
		for($j=1;$j<6;$j++)
		{
 			$weekday = dayShort($j);
			if(isset($hours[$i][dayShort($j)]))	echo "<td>".$hours[$i][dayShort($j)]->suShort."</td>";
			else echo "<td>&#160;</td>";
		}
		echo "</tr>";
		 
	}
	
	echo "</table>";
	echo "</div>";
}
else{
	echo "Sie m&uuml;ssen einen g&uuml;tigen Stundenplan ausw&auml;hlen!";

}
pageFooter();

function getLessons($name,$mode){
	if($mode == 'class') $where = "classes.name = '".mysql_real_escape_string($name) ."'";
	else $where = "teachers.short = '".mysql_real_escape_string($name)."'";

	$result = selectLesson($where,"");
	$lessons = array();
	while ($row = mysql_fetch_object($result)) {
		$lessons[] = $row;
	}
	return $lessons;
}

function orderLessons($lessons){
 $hours = array();
	for($i=0;$i <count($lessons);$i++)
	{ $countHour = $lessons[$i]->startHour;
 		if(!isset($hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort])){
			$hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort] = $lessons[$i];	

			for($countHour++; $countHour <= $lessons[$i]->endHour; $countHour++)
			{
 				$hours[$countHour][$lessons[$i]->weekdayShort] = $lessons[$i];
 			}
		}
		else{
 			if(!strpos($hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->suShort,$lessons[$i]->suShort))
			if($hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->suShort != $lessons[$i]->suShort)
 		 $hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->suShort .= " | ". $lessons[$i]->suShort;	
		}

	
	}	
return $hours;
}

function isEvening($hours)
{
 $check = 0;
 for ($i = 1; $i < 12; $i++)	//wenn erste 11 Stunden leer -> Abendschule
 	{
 	 if (!isset($hours[$i])) $check++;
	  }
	if($check == 11) return "evening";;
	
	$check = 0;
 for ($i = 12; $i < 17; $i++) //wenn erste 11 Stunden bef�llt und letzte 5 Stunden leer -> normal
 	{
 	 if (!isset($hours[$i])) $check++;
 	 }	
	if($check == 5) return "normal";
	else return "all";	//alle Stunden
}


?>