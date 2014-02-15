<?php
session_start();
//	error_reporting(E_ALL);

// TODO f�r klasse oder lehrer -> done

	/* /timetables/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Stundenplan von Klasse aus
	 *
	 * Changelog:
	 * 	0.1.0:  08. 10. 2013, Weiland Mathias  - erste Version
	 */
include_once("../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung
// TODO formatting
if(!($_SESSION['loggedIn'])) header("Location: ".RELATIVE_ROOT."/"); //Kontrolle ob angemeldet

$isTeacher =$_SESSION['isTeacher'];

if($isTeacher) {
	$name=$_SESSION['id'];	//Kontrolle ob Lehrer
// TODO benannte konstante "lehrer" anstatt 1 -> done
	$mode = "lehrer" ;
}
else {
	$name =$_SESSION['class'];
	if(!isset($name)) { 	//abbruch wenn kein Klassenname �bergeben
		die("Critical Error </br> Bist du sicher, dass du einer Klasse zugeordnet bist?");
	}
	$mode = "schueler";
}

pageHeader("Stundenplan","main");

echo "<form  method = \"post\">";
if(!isset($_POST['displaytyp'])) $displaytyp = "modificated";
else $displaytyp = $_POST['displaytyp'];
if($displaytyp == "normal"){
	echo "<input type =\"radio\" name = \"displaytyp\" onclick= \"this.form.submit()\" value = \"normal\" checked>normal";
	echo "<input type =\"radio\" name = \"displaytyp\" onclick= \"this.form.submit()\" value = \"modificated\">modifiziert";
}
else {
	echo "<input type =\"radio\" name = \"displaytyp\" onclick= \"this.form.submit()\" value = \"normal\">normal";
	echo "<input type =\"radio\" name = \"displaytyp\" onclick= \"this.form.submit()\" value = \"modificated\" checked>modifiziert";
} 
echo "<noscript><input type =\"submit\" value=\"Anzeige &auml;ndern\"></noscript>"; 
echo "</form>";

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
	if (!isset($hours[$index]))	
		$hours[$index] = array(); //Wenn f�r die betreffende Startstunde kein Eintrag vorhanden -> leeres Array erstellen
	if(isset($hours[$index][$lessons[$i]->weekdayShort])) //Kontrolle ob bereits ein Eintag vorhanden
	{ 
		 if($hours[$index][$lessons[$i]->weekdayShort]->suShort != $lessons[$i]->suShort) //Kontrolle ob  neuer Eintrag und vorhandener Eintrag unterschiedlich
		 	if(!strpos($hours[$index][$lessons[$i]->weekdayShort]->suShort,$lessons[$i]->suShort)) //Wenn neuer Eintrag nicht in altem Eintrag vorhanden -> zusammenh�ngen, getrennt mit |
			{
				$hours[$index][$lessons[$i]->weekdayShort]->suShort .= " | " .$lessons[$i]->suShort;
			}
	}
	else {
		$hours[$index][$lessons[$i]->weekdayShort] = $lessons[$i] ; //erstellen eines Eintrages wenn keiner vorhanden
	}
	
	$hours[$index][$lessons[$i]->weekdayShort] = (array) $hours[$index][$lessons[$i]->weekdayShort];
	$hours[$index][$lessons[$i]->weekdayShort]['moved'] = "";
	$hours[$index][$lessons[$i]->weekdayShort]['deleted'] = "";
	$hours[$index][$lessons[$i]->weekdayShort] = (object) $hours[$index][$lessons[$i]->weekdayShort];
}

$offset = 0;
if($displaytyp == "modificated"){
	//Setzen des ersten Tags der Woche
	// TODO date wochentag verwenden ->done 
	if(date("N", time())>5) { 
	 	$offset = 8- date("N",time());
	 }
	else {
	 	$offset = 1- date("N",time());
	 }
	
	 echo "Stundenplan vom ". date("Y.m.d",time() + 24 * 60 * 60 * $offset)." - ".date("Y.m.d",time() + 24 * 60 * 60 *($offset+5));
	for($j = 0; $j<=4; $j++)
	{
	//Supplierungen des Tages abrufen
		getSubstitude(date("Y.m.d",time() + 24 * 60 * 60 * $offset),$name,$mode);
		$offset++;
	 //echo $hours[1][$substitudes[0]['weekdayShort']]->suShort."--------------";	
	}
	//print_r($substitudes[0]['suShort']);
	for($j = 0; $j < count($substitudes);$j++)
	{
		$hour = $substitudes[$j]['startHour'];
		$day =  $substitudes[$j]['weekdayShort'];
		if($substitudes[$j]['hidden'] == 1 ){
			$hours[$hour][$day]->deleted = true;
			$hours[$substitudes[$j]['startHour']][$day]->suShort = str_replace($substitudes[$j]['suShort'],"<span style=\"color:#FF0000\">".$substitudes[$j]['suShort']."</span>",$hours[$substitudes[$j]['startHour']][$day]->suShort);

		}
		else $hours[$hour][$day]->deleted = false;
		if($substitudes[$j]['startHour'] != $substitudes[$j]['newStartHour'] && !empty($substitudes[$j]['newStartHour'])){
		 	$hours[$hour][$day]->deleted  = true;
		 	$hours[$substitudes[$j]['newStartHour']][$day]->moved = true;
		 	$hours[$substitudes[$j]['newStartHour']][$day]->teShort = $hours[$hour][$day]->teShort;
		 	$hours[$substitudes[$j]['newStartHour']][$day]->suShort = $hours[$hour][$day]->suShort;
		 	$hours[$substitudes[$j]['newStartHour']][$day]->endHour = $hours[$hour][$day]->endHour;	 	
		}
		else $hours[$hour][$day]->moved = false;
	}
	//print_r($hours['7']['Mi']);
	
	//print_r($substitudes);
}
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
 	if (!isset($hours[$i])){ //echo "check";
		for ($j = 0; $j < 5; $j++) 
			echo "<td>&#160;</td>"; //Ausgabe eines leeren Feldes, wenn keine Stunde vorhanden
	} 
	else {// echo "checkv2";
		for ($j = 0; $j < 5; $j++) {
			if(isset($hours[$i][$days[$j]])){
				if($hours[$i][$days[$j]]->moved == true) {
					echo "<td style = \"color : #00FF00\">";
				}
				else{
					 echo "<td>";					 
				}
			
			
			 if(isset($hours[$i][$days[$j]]->deleted) && $hours[$i][$days[$j]]->deleted== true){
				 echo str_replace($substitudes[$j]['suShort'],"<span style=\"color:#FF0000\">".$substitudes[$j]['suShort']."</span>",$hours[$i][$days[$j]]->suShort);}
			 else { echo $hours[$i][$days[$j]]->suShort;}
			 echo "</td>";
			 	if (isset($hours[$i][$days[$j]])) {
					if(($hours[$i][$days[$j]]->endHour) > $i) {//kopiert aktuelle Stunde in n�chste Stunde, wenn mehr als eine Stunde nacheinander stattfindet
						$hours[$i+1][$days[$j]] = NULL;
						$hours[$i+1][$days[$j]] = (array) $hours[$i+1][$days[$j]];
						$hours[$i+1][$days[$j]]['moved'] = "";
						$hours[$i+1][$days[$j]]['deleted'] = "";
						$hours[$i+1][$days[$j]] = (object) $hours[$i+1][$days[$j]];
						
						
						$hours[$i+1][$days[$j]]->suShort = $hours[$i][$days[$j]]->suShort;
						 $hours[$i+1][$days[$j]]->teShort = $hours[$i][$days[$j]]->teShort;
						 $hours[$i+1][$days[$j]]->endHour = $hours[$i][$days[$j]]->endHour;	
						 $hours[$i+1][$days[$j]]->deleted = $hours[$i][$days[$j]]->deleted;		 
						 if($hours[$i][$days[$j]]->moved)  $hours[$i+1][$days[$j]]->moved = $hours[$i][$days[$j]]->moved;		
					}
				}
			}
			else {
				echo "<td>&#160;</td>";
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

function getSubstitude($date,$name,$mode){	//Supplierungen des gew�hlten Datums abrufen
	global $substitudes;
		
		if($mode == "schueler"){
		 	$where = "time = '".mysql_real_escape_string($date)."' and classes.name = '" . mysql_real_escape_string($name) . "'";	
		}
		else {
			$where = "time = '".mysql_real_escape_string($date)."' and newTeacher.short = '" . mysql_real_escape_string($name) . "'";
		}	
			$substitude_sql = selectSubstitude($where,"")	
			or die("MySQL-Error: ".mysql_error());
			while($substitude = mysql_fetch_array($substitude_sql)) {    
		 	$substitudes[]=$substitude;
			}	
			
			//print_r($substitudes);  //Kontrolle des Ergebnis-Arrays
}

pageFooter();
?>