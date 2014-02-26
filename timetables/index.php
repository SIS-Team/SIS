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
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verf�gung

ifNotLoggedInGotoLogin();	//Kontrolle ob angemeldet
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

echo "<form  method = \"get\">";
if(!isset($_GET['displaytype'])) $displaytype = "modificated";
else $displaytype = $_GET['displaytype'];
if($displaytype == "normal"){
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"normal\" checked>normal";
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"modificated\">modifiziert";
}
else {
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"normal\">normal";
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"modificated\" checked>modifiziert";
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
	
}
$offset = 0;
$dayShort= array(1=>'Mo',2=>'Di',3=>'Mi',4=>'Do',5=>'Fr');
if(date("N")<6) $offset = 1-date("N");
else $offset = 8-date("N");
if($displaytype == "modificated" ){
 //---------------------------------------------------------------------------------------------------------------------------
echo "Dieser Stundenplan ist g&uuml;ltig: ". date("Y.m.d",time()+24*60*60*$offset) ."-".date("Y.m.d",time()+24*60*60*($offset+5));

	for($j=0;$j<5;$j++)
	{
		$substitudes = getSubstitude(date("Y-m-d",time()+24*60*60*$offset),$name,$mode);
		$offset++;
	//	print_r($substitudes);
		
		if(isset($substitudes)){
			for($i=0; $i <count($substitudes); $i++)
			{
 				$dayName =  $dayShort[date("N",strtotime($substitudes[$i]['time']))];
				if($substitudes[$i]['newSub']){
 				 	$hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "<span style=\" color:#00FF00\">".$substitudes[$i]['suShort']."</span>";
					$hours[$substitudes[$i]['startHour']][$dayName]->startHour = $substitudes[$i]['startHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->endHour = $substitudes[$i]['endHour'];
				}
				if($substitudes[$i]['remove']){
					$temp = $hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort;
					$temp = str_replace($substitudes[$i]['oldSuShort'],"",$temp);
					$temp = str_replace("|","",$temp);
					$hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort = $temp;
				}
				if(!$substitudes[$i]['newSub'] and !$substitudes[$i]['remove']){
					if(isset($hours[$substitudes[$i]['oldStartHour']][$dayName])){
						$temp = $hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort;
						$temp = str_replace($substitudes[$i]['oldSuShort'],"",$temp);
						$temp = str_replace("|","",$temp);
						$hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort = $temp;
					}

 				 	$hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "<span style=\" color: yellow\">".$substitudes[$i]['suShort']."</span>";
					$hours[$substitudes[$i]['startHour']][$dayName]->startHour = $substitudes[$i]['startHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->endHour = $substitudes[$i]['endHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->teShort = $substitudes[$i]['teShort'];
				}
			}
		}
	}
//----------------------------------------------------------------------------------------------------------------------------
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
				
					 echo "<td>";					 
				
					echo $hours[$i][$days[$j]]->suShort;
				
			
			echo "</td>";
					if(($hours[$i][$days[$j]]->endHour) > $i) {//kopiert aktuelle Stunde in n�chste Stunde, wenn mehr als eine Stunde nacheinander stattfindet
						$hours[$i+1][$days[$j]] = NULL;
						
						
						$hours[$i+1][$days[$j]]->suShort = $hours[$i][$days[$j]]->suShort;
						 $hours[$i+1][$days[$j]]->teShort = $hours[$i][$days[$j]]->teShort;
						 $hours[$i+1][$days[$j]]->endHour = $hours[$i][$days[$j]]->endHour;	 	
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
if ($displaytype == "modificated"){
	echo "normale Stunde <span style=\"color:#00FF00\"> hinzugef&uuml;gte Stunde</span><span style=\"color:yellow\"> ver&auml;nderte Stunde</span>";
}

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
	 
		
		if($mode == "schueler"){
		 	$where = "time = '".mysql_real_escape_string($date)."' and classes.name = '" . mysql_real_escape_string($name) . "'";	
		}
		else {
			$where = "time = '".mysql_real_escape_string($date)."' and teachers.short = '" . mysql_real_escape_string($name) . "'";
		}	
			$substitude_sql = selectSubstitude($where,"")	
			or die("MySQL-Error: ".mysql_error());
			while($substitude = mysql_fetch_array($substitude_sql)) {    
		 	$substitudes[]=$substitude;
			}	
			
			if(isset($substitudes))	return $substitudes;
}

pageFooter();
?>