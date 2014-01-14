<?php
session_start();
//	error_reporting(E_ALL);

// TODO für klasse oder lehrer -> done

	/* /timetables/class/index.php
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
// TODO formatting
if(!($_SESSION['loggedIn'])){
	die("Critical Error </br> Bist du sicher, dass du angemeldet bist?"); //Kontrolle ob angemeldet
}
$isTeacher =$_SESSION['isTeacher'];

if($isTeacher) {
	$name=$_SESSION['id'];	//Kontrolle ob Lehrer
// TODO benannte konstante "lehrer" anstatt 1 -> done
	$mode = "lehrer" ;
}
else {
	$name =$_SESSION['class'];
	if(!isset($name)) { 	//abbruch wenn kein Klassenname übergeben
		die("Critical Error </br> Bist du sicher, dass du einer Klasse zugeordnet bist?");
	}
	$mode = "schueler";
}

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
		
// TODO why nget ->done
$lessons = getLessons($name,$mode);  //fragt Stunden ab, die in der gesuchten Klasse stattfinden
$hours = array();
for ($i = 0; $i < count($lessons); $i++) {	
 	$index = $lessons[$i]->startHour; //Als Index wird die Startstunde verwendet
	if (!$hours[$index])	
		$hours[$index] = array(); //Wenn für die betreffende Startstunde kein Eintrag vorhanden -> leeres Array erstellen
	if(isset($hours[$index][$lessons[$i]->weekdayShort])) //Kontrolle ob bereits ein Eintag vorhanden
	{ 
		 if($hours[$index][$lessons[$i]->weekdayShort]->suShort != $lessons[$i]->suShort) //Kontrolle ob  neuer Eintrag und vorhandener Eintrag unterschiedlich
		 	if(!strpos($hours[$index][$lessons[$i]->weekdayShort]->suShort,$lessons[$i]->suShort)) //Wenn neuer Eintrag nicht in altem Eintrag vorhanden -> zusammenhängen, getrennt mit |
			{
				$hours[$index][$lessons[$i]->weekdayShort]->suShort .= " | " .$lessons[$i]->suShort;
			}
	}
	else {
		$hours[$index][$lessons[$i]->weekdayShort] = $lessons[$i] ; //erstellen eines Eintrages wenn keiner vorhanden
	}
}
//hours[Stunde][Tag]
//print_r($hours);
//-------------------------------------------------------------------------------------------------------
$offset = 0;
//Setzen des ersten Tags der Woche
// TODO date wochentag verwenden ->done 
if(date("N", time())>5) { 
 	$offset = date("N",time())-8;
 }
else {
 	$offset = date("N",time())-1;
 }

for($j = 0; $j<=4; $j++)
{
//Supplierungen des Tages abrufen
	getSubstitude(date("Y.m.d",time() + 24 * 60 * 60 * $offset),$name,$mode);
	$offset++;
 //echo $hours[1][$substitudes[0]['weekdayShort']]->suShort."--------------";	
}
//-------------------------------------------------------------------------------------------------------
$classType = isEvening($hours);	//kontrolliert ob Abendschule
if($classType == "evening")	//nur Abendschule
	{$tableBegin = 12;
	 $tableEnd=17;}
	 
else {	//nur erste 11 Stunden
 		if($classType == "normal")
 			{$tableBegin = 1;
 			 $tableEnd = 12;
 			 }
 		else 	//alle Stunden
		 	{$tableBegin = 1;
 			 $tableEnd = 17;
 			 }
 	}
$days=array(0=> "Mo",1=> "Di",2=> "Mi",3=>"Do",4=>"Fr");
for ($i = $tableBegin; $i < $tableEnd; $i++) {
 	echo "<tr>";
 	echo "<td style=\"width:50px\">".$i."</td>";			//gibt Stundennummer an
 	if (!$hours[$i]){ //echo "check";
		for ($j = 0; $j < 5; $j++) 
			echo "<td>&#160;</td>"; //Ausgabe eines leeren Feldes, wenn keine Stunde vorhanden
	} else {// echo "checkv2";
		for ($j = 0; $j < 5; $j++) {
		 
		 echo "<td>" . $hours[$i][$days[$j]]->suShort ."&#160;</td>";	//gibt 	Fach aus
					if(($hours[$i][$days[$j]]->endHour) > $i) //kopiert aktuelle Stunde in nächste Stunde, wenn mehr als eine Stunde nacheinander stattfindet
					{$hours[$i+1][$days[$j]]->suShort = $hours[$i][$days[$j]]->suShort;
					 $hours[$i+1][$days[$j]]->teShort = $hours[$i][$days[$j]]->teShort;
					 $hours[$i+1][$days[$j]]->endHour = $hours[$i][$days[$j]]->endHour;	
					}
		}
	}
	echo "</tr>";
}		
echo "</div>";
		echo "</table>";


function getLessons($name,$mode) {		//Abfrage von Stunden von vorgegebener Klasse/vorgegebenem Lehrer
	if($mode == "schueler" ){
		if ($name){
				$where = "classes.name = '" . mysql_real_escape_string($name) . "'";
		}
	}
	else{
	 	if ($name) {
		  		$where = "teachers.short = '" . mysql_real_escape_string($name) . "'";
		}
	}
	$result = selectLesson($where, "");
	$lessons = array();
	echo mysql_error();
	while ($row = mysql_fetch_object($result)) {
		$lessons[] = $row;
	}
	return $lessons;
}

function isEvening($hours)
{
 $check = 0;
 for ($i = 1; $i < 12; $i++)	//wenn erste 11 Stunden leer -> Abendschule
 	{
 	 if (!$hours[$i]) $check++;
	  }
	if($check == 11) return "evening";;
	
	$check = 0;
 for ($i = 12; $i < 17; $i++) //wenn erste 11 Stunden befüllt und letzte 5 Stunden leer -> normal
 	{
 	 if (!$hours[$i]) $check++;
 	 }	
	if($check == 5) return "normal";
	else return "all";	//alle Stunden
}

function getSubstitude($date,$name,$mode){	//Supplierungen des gewählten Datums abrufen
	global $substitudes;
		
		if($mode == "schueler"){
		 	$where = "time = '".mysql_real_escape_string($date)."' and classes.name = '" . mysql_real_escape_string($name) . "'";	
		}
		else {
			$where = "time = '".mysql_real_escape_string($date)."' and newTeacher.short = '" . mysql_real_escape_string($name) . "'";
		}	
			$substitude_sql = selectSubstitude($where)	
			or die("MySQL-Error: ".mysql_error());
			while($substitude = mysql_fetch_array($substitude_sql)) {    
		 	$substitudes[]=$substitude;
	//		print_r($substitudes);  //Kontrolle des Ergebnis-Arrays
			}	
}

pageFooter();
?>