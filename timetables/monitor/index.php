<?php

//	error_reporting(E_ALL);

	/* /timetables/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Raum-Stundenplan aus
	 *
	 * Changelog:
	 * 	0.1.0:  24. 09. 2013, Weiland Mathias  - erste Version
	 *  0.2.0:  01. 10. 2013, Weiland Mathias  - zweite Version
	 */
	 
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung


$roName =$_GET['name'];
if(!isset($roName))die("Kein Raumname vorhanden");

pageHeader("Formular","main");


//Tabellenkopfausgabe
		echo "<table border = 1>";
		echo "<tr>";
		echo "<th>Stunde</th>";
		echo "<th colspan = 2>Mo</th>";
		echo "<th colspan = 2>Di</th>";
		echo "<th colspan = 2>Mi</th>";
		echo "<th colspan = 2>Do</th>";
		echo "<th colspan = 2>Fr</th>";
		echo "</tr>";
		


$array = ngetLessons($roName);  //fragt Studen ab, die in der gesuchten Klasse stattfinden
$hours = array();			   //ertellt ein leeres Array
/*for ($i = 0; $i < count($array); $i++) {	
 	$index = $array[$i]->startHour;
	if (!$hours[$index])
		$hours[$index] = array();
		if(isset($hours[$index][$array[$i]->weekdayShort]))
		{
		 if($hours[$index][$array[$i]->weekdayShort]->clName != $array[$i]->clName)
		    $hours[$index][$array[$i]->weekdayShort]->clName .= " | " .$array[$i]->clName;
		}
		
	else	$hours[$index][$array[$i]->weekdayShort] = $array[$i];
}*/

//--------------------------------------------------------------------------------------------------------------------
//$hours[startStunde][Tag]
for($i=0; $i < count($array);$i++) {
 for($j = $array[$i]->startHour; $j <= $array[$i]->endHour;$j++) {
  
  if(isset($hours[$j][$array[$i]->weekdayShort][1]))  $hours[$j][$array[$i]->weekdayShort][1] .= " | " .$array[$i]->clName;
  else $hours[$j][$array[$i]->weekdayShort][1] = $array[$i]->clName;
  if($hours[$j][$array[$i]->weekdayShort][2] != $array[$i]->teShort) $hours[$j][$array[$i]->weekdayShort][2] .= $array[$i]->teShort;
  $hours[$j][$array[$i]->weekdayShort][3] .= $array[$i]->roName;
 }}


//--------------------------------------------------------------------------------------------------------------------



//print_r($array[21]);
 

for ($i = 1; $i < 12; $i++) {
 	echo "<tr>";
 	echo "<td style=\"width:50px\">".$i."</td>";			//gibt Stundennummer an
 	if (!$hours[$i]){// echo "check";
		for ($j = 0; $j < 5; $j++) 
			echo "<td class ='timetable_classes'>&#160;</td><td class ='timetable_teachers'>&#160;</td>"; //Ausgabe eines leeren Feldes, wenn keine Stunde vorhanden
	} else {// echo "checkv2";
		for ($j = 0; $j < 5; $j++) {
			switch($j) {
			case 0:	//Montag
			
					echo "<td class ='timetable_classes'>" . $hours[$i]['Mo'][1] ."&#160;</td><td class ='timetable_teachers'>" . $hours[$i]['Mo'][2].	"&#160;  </td>";	//gibt 	Klasse und Lehrer aus
				break;
				
			case 1:	//Dienstag
			
					echo "<td class ='timetable_classes'>" . $hours[$i]['Di'][1] ."&#160;</td><td class ='timetable_teachers'>" . $hours[$i]['Di'][2].	"&#160;  </td>";	
				
				break;
				
			case 2: //Mittwoch
					echo "<td class ='timetable_classes'>" . $hours[$i]['Mi'][1] ."&#160;</td><td class ='timetable_teachers'>" . $hours[$i]['Mi'][2].	"&#160;  </td>";	

				break;
				
			case 3: //Donnerstag
					echo "<td class ='timetable_classes'>" . $hours[$i]['Do'][1] ."&#160;</td><td class ='timetable_teachers'>" . $hours[$i]['Do'][2].	"&#160;  </td>";		

				break;
				
			case 4: //Freitag
					echo "<td class ='timetable_classes'>" . $hours[$i]['Fr'][1] ."&#160;</td><td class ='timetable_teachers'>" . $hours[$i]['Fr'][2].	"&#160;  </td>";	
			
				break;
				
			default: //Fehler
				echo "Error";
				break;
			}
		}
	}
	echo "</tr>";
}		
		echo "</table>";


function ngetLessons($roomName) {		//Abfrage von Stunden im vorgegebenen Raum
	if ($roomName) 
		$where = "rooms.name = '" . mysql_real_escape_string($roomName) . "'";
	$result = selectLesson($where, "");
	$array = array();
	echo mysql_error();
	while ($row = mysql_fetch_object($result)) {
		$array[] = $row;
	}
	return $array;
}

pageFooter();
?>