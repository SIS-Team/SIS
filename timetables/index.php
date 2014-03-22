<?php
session_start();
	/* /timetables/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Stundenplan von Klasse aus
	 */
include_once("../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verfügung

ifNotLoggedInGotoLogin();	//Kontrolle ob angemeldet
$isTeacher =$_SESSION['isTeacher'];

if($isTeacher) {
	$name=$_SESSION['id'];	//Kontrolle ob Lehrer
	$mode = "lehrer" ;
}
else {
	$name =$_SESSION['class'];
	if(!isset($name)) { 	//abbruch wenn kein Klassenname übergeben
		die("Critical Error </br> Bist du sicher, dass du einer Klasse zugeordnet bist?");
	}
	$mode = "schueler";
}

pageHeader("Stundenplan","main");

echo "<div id=\"print\">";
echo "<a href=\"".RELATIVE_ROOT."/pdf/timetables/\" target=\"_blank\">";
echo "<button class =\"nonButton\">";
include(ROOT_LOCATION . "/data/images/print.svg");
echo "</button>";
echo "</a>";
echo "</div>";

echo "<form  method = \"get\" style=\" float:left\">";
if(!isset($_GET['displaytype'])) $displaytype = "modificated";
else $displaytype = $_GET['displaytype'];
if($displaytype == "normal"){
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"normal\" checked>normal";
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"modificated\">modifiziert";
}
else {
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"normal\">normal";
	echo "<input type =\"radio\" name = \"displaytype\" onclick= \"this.form.submit()\" value = \"modificated\" checked>modifiziert  ";
} 
echo "<noscript><input type =\"submit\" value=\"Anzeige &auml;ndern\"></noscript>"; 
echo "</form>";
if($displaytype == "normal") echo "</br>";
if($displaytype =="modificated"){

	if(!isset($_GET['week'])) $week = "actual";
	else $week = $_GET['week'];
	echo "<form method=\"get\">";
	echo "|";
	if($week == "actual"){
		echo "<input type =\"radio\" name = \"week\" onclick= \"this.form.submit()\" value = \"actual\" checked>aktuelle Woche";
		echo "<input type =\"radio\" name = \"week\" onclick= \"this.form.submit()\" value = \"next\" >n&auml;chste Woche";
	}
	else {
		echo "<input type =\"radio\" name = \"week\" onclick= \"this.form.submit()\" value = \"actual\">aktuelle Woche";
		echo "<input type =\"radio\" name = \"week\" onclick= \"this.form.submit()\" value = \"next\" checked>n&auml;chste Woche"; 
	}
	echo "<noscript><input type =\"submit\" value=\"Anzeige &auml;ndern\"></noscript>"; 
	echo "</form>";
}
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
		
$lessons = getLessons($name,$mode);  //fragt Stunden ab, die in der gesuchten Klasse stattfinden
$hours = array();
for ($i = 0; $i < count($lessons); $i++) {	
 	$index = $lessons[$i]->startHour; //Als Index wird die Startstunde verwendet
	if (!isset($hours[$index]))	
		$hours[$index] = array(); //Wenn für die betreffende Startstunde kein Eintrag vorhanden -> leeres Array erstellen
	if(isset($hours[$index][$lessons[$i]->weekdayShort])) //Kontrolle ob bereits ein Eintag vorhanden
	{ 
		 if($hours[$index][$lessons[$i]->weekdayShort]->suShort != $lessons[$i]->suShort){ //Kontrolle ob  neuer Eintrag und vorhandener Eintrag unterschiedlich
		 	if(!strpos($hours[$index][$lessons[$i]->weekdayShort]->suShort,$lessons[$i]->suShort)) //Wenn neuer Eintrag nicht in altem Eintrag vorhanden -> zusammenhängen, getrennt mit |
			{
				$hours[$index][$lessons[$i]->weekdayShort]->suShort .= " | " .$lessons[$i]->suShort;
				$popup = "&#xD;".$lessons[$i]->suShort.": ".$lessons[$i]->teShort." ".$lessons[$i]->roName;
				$hours[$index][$lessons[$i]->weekdayShort]->popup .=  $popup;
			}
			else{
 				$popup = "&#xD;".$lessons[$i]->suShort.": ".$lessons[$i]->teShort." ".$lessons[$i]->roName;
				$hours[$index][$lessons[$i]->weekdayShort]->popup .=  $popup;
			}
		}
		else{
 				$popup = "&#xD;".$lessons[$i]->suShort.": ".$lessons[$i]->teShort." ".$lessons[$i]->roName;
				$hours[$index][$lessons[$i]->weekdayShort]->popup .=  $popup;
		}
	}
	else {
		$hours[$index][$lessons[$i]->weekdayShort] = $lessons[$i] ; //erstellen eines Eintrages wenn keiner vorhanden

		if($mode == 'schueler')$popup = $lessons[$i]->suShort.": ".$lessons[$i]->teShort." ".$lessons[$i]->roName;
		else $popup = $lessons[$i]->clName." ".$lessons[$i]->roName;
		$hours[$index][$lessons[$i]->weekdayShort]->popup = $popup;
	}
	
}

//if($_SESSION['id'] == '20090396') print_r($hours);
$offset = 0;
$dayShort= array(1=>'Mo',2=>'Di',3=>'Mi',4=>'Do',5=>'Fr');
if(date("N")<6) $offset = 1-date("N");
else $offset = 8-date("N");
if(isset($week) && $week == "next") $offset+=7;
if($displaytype == "modificated" ){
echo "Dieser Stundenplan ist g&uuml;ltig: ". date("Y.m.d",time()+24*60*60*$offset) ."-".date("Y.m.d",time()+24*60*60*($offset+4));
	for($j=0;$j<5;$j++)
	{
		$substitudes = getSubstitude(date("Y-m-d",time()+24*60*60*$offset),$name,$mode);
		$offset++;
		
		if(isset($substitudes)){
			for($i=0; $i <count($substitudes); $i++)
			{
 				$dayName =  $dayShort[date("N",strtotime($substitudes[$i]['time']))];
				if($substitudes[$i]['newSub']){
 					$popup = "sdfjhl";
 				 	$hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "</td><td class ='changed' title='".$popup."'>".$substitudes[$i]['suShort'];
					$hours[$substitudes[$i]['startHour']][$dayName]->startHour = $substitudes[$i]['startHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->endHour = $substitudes[$i]['endHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->popup = "entf&aumll;t";
				}
				if($substitudes[$i]['remove']){
					$temp = $hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort;
					$temp = str_replace($substitudes[$i]['oldSuShort'],"",$temp);
					$temp = str_replace("|","",$temp);
					if(isset($hours[$substitudes[$i]['startHour']][$dayName]->popup)) $temp2=$hours[$substitudes[$i]['startHour']][$dayName]->popup;
					else $temp2="";
					$hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort = "</td><td class ='changed' title='".$temp2."'>".$temp;
				}
				if(!$substitudes[$i]['newSub'] and !$substitudes[$i]['remove']){
					if(isset($hours[$substitudes[$i]['oldStartHour']][$dayName])){
						$temp = $hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort;
						$temp = str_replace($substitudes[$i]['oldSuShort'],"",$temp);
						$temp = str_replace("|","",$temp);
						$hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort = $temp;
					}
					if(isset($substitudes[$i]['suShort'])){
 					if(isset($hours[$substitudes[$i]['startHour']][$dayName]->popup)) $title = $hours[$substitudes[$i]['startHour']][$dayName]->popup;
					else{ 
 					if($mode =='schueler')$title = $substitudes[$i]['suShort'].":". $substitudes[$i]['teShort']." ".$substitudes[$i]['roName'];
					else $title = $substitudes[$i]['clName']."    ".$substitudes[$i]['roName'];
					}
 				 	$hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "</td><td class ='changed' title='".$title."'>".$substitudes[$i]['suShort'];
					}
					else $hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "</td><td class ='changed' title='".$title."'>".$substitudes[$i]['oldSuShort'];
					
					$hours[$substitudes[$i]['startHour']][$dayName]->startHour = $substitudes[$i]['startHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->endHour = $substitudes[$i]['endHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->teShort = $substitudes[$i]['teShort'];
					$hours[$substitudes[$i]['startHour']][$dayName]->popup = "siehe Supplierplan";
				}
			}
		}
	}
}
else echo "</br>";
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
 	if (!isset($hours[$i])){ 
		for ($j = 0; $j < 5; $j++) 
			echo "<td>&#160;</td>"; //Ausgabe eines leeren Feldes, wenn keine Stunde vorhanden
	} 
	else {
		for ($j = 0; $j < 5; $j++) {
			if(isset($hours[$i][$days[$j]])){
					 if(!strpos($hours[$i][$days[$j]]->suShort,"<td")){
					 echo "<td>";					 
					}

					echo "<span title=\"".$hours[$i][$days[$j]]->popup."\">" . $hours[$i][$days[$j]]->suShort ."</span>";
			
			
			echo "</td>";
					if(($hours[$i][$days[$j]]->endHour) > $i) {//kopiert aktuelle Stunde in nächste Stunde, wenn mehr als eine Stunde nacheinander stattfindet
						$hours[$i+1][$days[$j]] = NULL;
						
						
						$hours[$i+1][$days[$j]]->suShort = $hours[$i][$days[$j]]->suShort;
						 $hours[$i+1][$days[$j]]->teShort = $hours[$i][$days[$j]]->teShort;
						 $hours[$i+1][$days[$j]]->endHour = $hours[$i][$days[$j]]->endHour;	
						 $hours[$i+1][$days[$j]]->popup = $hours[$i][$days[$j]]->popup;	 	
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

echo "Dieser Stundenplan wurde generiert: ". date("d.m.Y H:i:s");

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
 for ($i = 12; $i < 17; $i++) //wenn erste 11 Stunden befüllt und letzte 5 Stunden leer -> normal
 	{
 	 if (!isset($hours[$i])) $check++;
 	 }	
	if($check == 5) return "normal";
	else return "all";	//alle Stunden
}

function getSubstitude($date,$name,$mode){	//Supplierungen des gewählten Datums abrufen
	 
		
		if($mode == "schueler"){
		 	$where = "time = '".mysql_real_escape_string($date)."' and classes.name = '" . mysql_real_escape_string($name) . "'";	
		}
		else {
			$where = "time = '".mysql_real_escape_string($date)."' and teachers.short = '" . mysql_real_escape_string($name) . "'";
		}	
			$substitude_sql = selectSubstitude($where,"");
			while($substitude = mysql_fetch_array($substitude_sql)) {    
		 		$substitudes[]=$substitude;
			}	
			
			if(isset($substitudes))	return $substitudes;
}

pageFooter();
?>