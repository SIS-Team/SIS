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
for ($i = 0; $i < count($array); $i++) {	
 	$index = $array[$i]->startHour;
	if (!$hours[$index])
		$hours[$index] = array();
	$hours[$index][$array[$i]->weekdayShort] = $array[$i];
}

//	print_r($array);
//print_r($hours[5]["Fr"]);
//echo "<br><br>Hihi: ".$hours[1]["Mo"]->suShort."<br><br>";

for ($i = 1; $i < 17; $i++) {
 	echo "<tr>";
 	echo "<td>".$i."</td>";			//gibt Stundennummer an
 	if (!$hours[$i]){// echo "check";
		for ($j = 0; $j < 5; $j++) 
			echo "<td>&#160;</td><td>&#160;</td>"; //Ausgabe eines leeren Feldes, wenn keine Stunde vorhanden
	} else {// echo "checkv2";
		for ($j = 0; $j < 5; $j++) {
			switch($j) {
			case 0:	//Montag
					echo "<td>" . $hours[$i]['Mo']->suShort ."&#160;</td><td>" . $hours[$i]['Mo']->clName.	"&#160;  </td>";	//gibt 	Fach und Stunde aus
					
					if(($hours[$i]['Mo']->endHour) > $i) //kopiert aktuelle Stunde in nächste Stunde, wenn mehr als eine Stunde nacheinander stattfindet
					{$hours[$i+1]['Mo']->suShort = $hours[$i]['Mo']->suShort;
					 $hours[$i+1]['Mo']->clName = $hours[$i]['Mo']->clName;
					 $hours[$i+1]['Mo']->endHour = $hours[$i]['Mo']->endHour;	
					}
				break;
				
			case 1:	//Dienstag
					echo "<td>" . $hours[$i]['Di']->suShort ."&#160;</td><td>". $hours[$i]['Di']->clName . "&#160;  </td>";
					
					if(($hours[$i]['Di']->endHour) > $i) 
					{$hours[$i+1]['Di']->suShort = $hours[$i]['Di']->suShort;
					 $hours[$i+1]['Di']->clName = $hours[$i]['Di']->clName;
					 $hours[$i+1]['Di']->endHour = $hours[$i]['Di']->endHour;	
					}
				break;
				
			case 2: //Mittwoch
					echo "<td>" . $hours[$i]['Mi']->suShort ."&#160;</td><td>". $hours[$i]['Mi']->clName . "&#160;  </td>";
					if(($hours[$i]['Mi']->endHour) > $i)
					{$hours[$i+1]['Mi']->suShort = $hours[$i]['Mi']->suShort;
					 $hours[$i+1]['Mi']->clName = $hours[$i]['Mi']->clName;
					 $hours[$i+1]['Mi']->endHour = $hours[$i]['Mi']->endHour;	
					}
				break;
				
			case 3: //Donnerstag
					echo "<td>" . $hours[$i]['Do']->suShort ."&#160;</td><td>". $hours[$i]['Do']->clName . "&#160;  </td>";
					if(($hours[$i]['Do']->endHour) > $i) 
					{$hours[$i+1]['Do']->suShort = $hours[$i]['Do']->suShort;
					 $hours[$i+1]['Do']->clName = $hours[$i]['Do']->clName;
					 $hours[$i+1]['Do']->endHour = $hours[$i]['Do']->endHour;	
					}
				break;
				
			case 4: //Freitag
					echo "<td>" . $hours[$i]['Fr']->suShort ."&#160;</td><td>". $hours[$i]['Fr']->clName . "&#160;  </td>";
					if(($hours[$i]['Fr']->endHour) > $i)
					{$hours[$i+1]['Fr']->suShort = $hours[$i]['Fr']->suShort;
					 $hours[$i+1]['Fr']->clName = $hours[$i]['Fr']->clName;
					 $hours[$i+1]['Fr']->endHour = $hours[$i]['Fr']->endHour;	
					}
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



pageFooter();
?>