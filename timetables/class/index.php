<?php

//	error_reporting(E_ALL);

	/* /timetables/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Stundenplan von Klasse aus
	 *
	 * Changelog:
	 * 	0.1.0:  08. 10. 2013, Weiland Mathias  - erste Version
	 */
	 
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung


$clName =$_GET['name'];
if(!isset($clName))die("Kein Klassenname vorhanden");	//abbruch wenn kein Klassenname übergeben

pageHeader("Formular","main");
echo "<div class ='timetable_column'>";	

//Tabellenkopfausgabe
		echo "<table border = 1>";
		echo "<tr>";
		echo "<th>Stunde</th>";
		echo "<th>Mo</th>";
		echo "<th>Di</th>";
		echo "<th>Mi</th>";
		echo "<th>Do</th>";
		echo "<th>Fr</th>";
		echo "</tr>";
		


$array = ngetLessons($clName);  //fragt Studen ab, die in der gesuchten Klasse stattfinden
$hours = array();			   //ertellt ein leeres Array
for ($i = 0; $i < count($array); $i++) {	
 	$index = $array[$i]->startHour; //Als Index wird die Startstunde verwendet
	if (!$hours[$index])	
		$hours[$index] = array(); //Wenn für die betreffende Startstunde kein Eintrag vorhanden -> leeres Array erstellen
		if(isset($hours[$index][$array[$i]->weekdayShort])) //Kontrolle ob bereits ein Eintag vorhanden
		{ 
		 if($hours[$index][$array[$i]->weekdayShort]->suShort != $array[$i]->suShort) //Kontrolle ob  neuer Eintrag und vorhandener Eintrag unterschiedlich
		 		 if(!strpos($hours[$index][$array[$i]->weekdayShort]->suShort,$array[$i]->suShort)) //Wenn neuer Eintrag nicht in altem Eintrag vorhanden -> zusammenhängen, getrennt mit |
				   {$hours[$index][$array[$i]->weekdayShort]->suShort .= " | " .$array[$i]->suShort;}
		}
		else $hours[$index][$array[$i]->weekdayShort] = $array[$i] ; //erstellen eines Eintrages wenn keiner vorhanden
}

//print_r($hours[1]['Mo']);
 
$classType = checkContent($hours);	//kontrolliert ob Abendschule
if($classType == 2)	//nur Abendschule
	{$tableBegin = 12;
	 $tableEnd=17;}
	 
else {	//nur erste 11 Stunden
 		if($classType == 1)
 			{$tableBegin = 1;
 			 $tableEnd = 12;
 			 }
 		else 	//alle Stunden
		 	{$tableBegin = 1;
 			 $tableEnd = 17;
 			 }
 	}	
for ($i = $tableBegin; $i < $tableEnd; $i++) {
 	echo "<tr>";
 	echo "<td style=\"width:50px\">".$i."</td>";			//gibt Stundennummer an
 	if (!$hours[$i]){ //echo "check";
		for ($j = 0; $j < 5; $j++) 
			echo "<td>&#160;</td>"; //Ausgabe eines leeren Feldes, wenn keine Stunde vorhanden
	} else {// echo "checkv2";
		for ($j = 0; $j < 5; $j++) {
			switch($j) {
			case 0:	//Montag
			
					echo "<td>" . $hours[$i]['Mo']->suShort ."&#160;</td>";	//gibt 	Fach aus
					if(($hours[$i]['Mo']->endHour) > $i) //kopiert aktuelle Stunde in nächste Stunde, wenn mehr als eine Stunde nacheinander stattfindet
					{$hours[$i+1]['Mo']->suShort = $hours[$i]['Mo']->suShort;
					 $hours[$i+1]['Mo']->teShort = $hours[$i]['Mo']->teShort;
					 $hours[$i+1]['Mo']->endHour = $hours[$i]['Mo']->endHour;	
					}
				break;
				
			case 1:	//Dienstag
			
					echo "<td>" . $hours[$i]['Di']->suShort ."&#160;</td>";	
				
					if(($hours[$i]['Di']->endHour) > $i) 
					{$hours[$i+1]['Di']->suShort = $hours[$i]['Di']->suShort;
					 $hours[$i+1]['Di']->teShort = $hours[$i]['Di']->teShort;
					 $hours[$i+1]['Di']->endHour = $hours[$i]['Di']->endHour;
					}
				break;
				
			case 2: //Mittwoch
					echo "<td>" . $hours[$i]['Mi']->suShort ."&#160;</td>";	
			
					if(($hours[$i]['Mi']->endHour) > $i)
					{$hours[$i+1]['Mi']->suShort = $hours[$i]['Mi']->suShort;
					 $hours[$i+1]['Mi']->teShort = $hours[$i]['Mi']->teShort;
					 $hours[$i+1]['Mi']->endHour = $hours[$i]['Mi']->endHour;	
					}
				break;
				
			case 3: //Donnerstag
					echo "<td>" . $hours[$i]['Do']->suShort ."&#160;</td>";	
			
					if(($hours[$i]['Do']->endHour) > $i) 
					{$hours[$i+1]['Do']->suShort = $hours[$i]['Do']->suShort;
					 $hours[$i+1]['Do']->teShort = $hours[$i]['Do']->teShort;
					 $hours[$i+1]['Do']->endHour = $hours[$i]['Do']->endHour;	
					}
				break;
				
			case 4: //Freitag
					echo "<td>" . $hours[$i]['Fr']->suShort ."&#160;</td>";	
			
					if(($hours[$i]['Fr']->endHour) > $i)
					{$hours[$i+1]['Fr']->suShort = $hours[$i]['Fr']->suShort;
					 $hours[$i+1]['Fr']->teShort = $hours[$i]['Fr']->teShort;
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
echo "</div>";
		echo "</table>";


function ngetLessons($className) {		//Abfrage von Stunden im vorgegebenen Raum
	if ($className) 
		$where = "classes.name = '" . mysql_real_escape_string($className) . "'";
	$result = selectLesson($where, "");
	$array = array();
	echo mysql_error();
	while ($row = mysql_fetch_object($result)) {
		$array[] = $row;
	}
	return $array;
}

function checkContent($hours)
{
 $check = 0;
 for ($i = 1; $i < 12; $i++)	//wenn erste 11 Stunden leer -> Abendschule
 	{
 	 if (!$hours[$i]) $check++;
 	 }
	if($check == 11) return 2;
	
	$check = 0;
 for ($i = 12; $i < 17; $i++) //wenn erste 11 Stunden befüllt und letzte 5 Stunden leer -> normal
 	{
 	 if (!$hours[$i]) $check++;
 	 }	
	if($check == 5) return 1;
	else return 0;	//alle Stunden
}

pageFooter();
?>