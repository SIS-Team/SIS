<?php

//	error_reporting(E_ALL);

	/* /timetables/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Stundenplan aus
	 *
	 * Changelog:
	 * 	0.1.0:  24. 09. 2013, Weiland Mathias  - erste Version
	 */
	 
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung



pageHeader("Formular","main");

//Tabellenkopfausgabe
		echo "<table border = 1>";
		echo "<tr>";
		echo "<th>Stunde</th>";
		echo "<th></th>";
		echo "<th>Mo</th>";
		echo "<th>Di</th>";
		echo "<th>Mi</th>";
		echo "<th>Do</th>";
		echo "<th>Fr</th>";
		echo "</tr>";
		
/*		
		
		for($count = 1;$count <= 16; $count++)	//Supplierungen ausgeben
		{
		 
		getLessons("I310",$count);
		 echo "<tr>";
		 echo "<td>".$count."</td>";
		 echo "<td>08:00 - 08:50</td>";
		 echo "<td>".$lessons[0][5]."</td>";	//Fach Montag
		 echo "<td>".$lessons[1][5]."</td>";	//Fach Dienstag
	 	 echo "<td>".$lessons[2][5]."</td>";	//Fach Mittwoch
		 echo "<td>".$lessons[3][5]."</td>";	//Fach Donnerstag
		 echo "<td>".$lessons[4][5]."</td>";	//Fach Freitag
		 echo "</tr>";
		$lessons = array();
		}
		echo "</table>";    */

$array = ngetLessons("I310");
$hours = array();
for ($i = 0; $i < count($array); $i++) {
 	$index = $array[$i]->startHour;
	if (!$hours[$index])
		$hours[$index] = array();
	$hours[$index][$array[$i]->weekdayShort] = $array[$i];
}

	print_r($hours);

for ($i = 1; $i < 17; $i++) {
 	echo "<tr>";
 	if (!$hours[$i]){ echo "check";
		for ($j = 0; $j < 5; $j++) 
			echo "<td></td>";
	} else { echo "checkv2";
		for ($j = 0; $j < 5; $j++) {
			switch($j) {
			case 0:
				echo " (CASE0)". $i;
				if ($array[$i]['Mo'])
					echo "<td>" . $array[$i]['Mo']->teShort . "</td>";
				echo " (ENDE VON CASE0)";
				break;
			case 1:
				if ($array[$i]['Di'])
					echo "<td>" . $array[$i]['Di']->suShort . "</td>";
				break;
			case 2:
				if ($array[$i]['Mi'])
						echo "<td>" . $array[$i]['Mi']->suShort . "</td>";
				break;
			case 3:
				if ($array[$i]['Do'])
					echo "<td>" . $array[$i]['Do']->suShort . "</td>";
				break;
			case 4:
				if ($array[$i]['Fr'])
					echo "<td>" . $array[$i]['Fr']->suShort . "</td>";
				break;
			default:
				echo "blublub";
				break;
			}
		}
	}
	echo "</tr>";
}		
		echo "</table>";

	echo "All over your faces!";

function ngetLessons($roomName) {		//Abfrgae von Stunden im vorgegebenen Raum
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
/*
function getLessons($roomName,$hour)
{
	global $lessons; 
			$where = ""; 
 			if(!empty($roomName)) $where = "rooms.Name = '".$roomName . "'"; 
			if(!empty($roomName) && !empty($hour)) $where .= " AND "; 
			if(!empty($hour)) $where .= " hoursStart.hour <= '" . $hour . "' AND '" . $hour . "' <=hoursEnd.hour "; 
			$lessons_sql = selectLesson($where,"")	
			or die("MySQL-Error: ".mysql_error());
			while($lesson = mysql_fetch_array($lessons_sql)) {    
		 		$lessons[]=$lesson;
			}
			print_r($lessons[0]);	//Kontrolle des Ergebnisses 
}*/


pageFooter();
?>