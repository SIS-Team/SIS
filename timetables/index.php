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
		die("Critical Error </br> Du bist keiner Klasse zugewissen. Kl&auml;re dies bitte mit dem Systemadministrator.");
	}
	$mode = "schueler";
}

pageHeader("Stundenplan","main");
//Button zum Ausdrucken
echo "<div id=\"print\">";
	echo "<a href=\"".RELATIVE_ROOT."/pdf/timetables/\" target=\"_blank\">";
		echo "<button class =\"nonButton\">";
			include(ROOT_LOCATION . "/data/images/print.svg");
		echo "</button>";
	echo "</a>";
echo "</div>";
//Auswahl er Anzeige
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
if($displaytype =="modificated"){ //Auswahl ob diese oder nächste Woche

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
		if(strpos($hours[$index][$lessons[$i]->weekdayShort]->suShort,$lessons[$i]->suShort) === false) 
		{//Wenn neuer Eintrag nicht in altem Eintrag vorhanden -> zusammenhängen, getrennt mit |
			$hours[$index][$lessons[$i]->weekdayShort]->suShort .= " | " .$lessons[$i]->suShort;
			$popup = "&#xD;".$lessons[$i]->suShort.": ".$lessons[$i]->teShort." ".$lessons[$i]->roName;
			if(isset($lessons[$i]->comment)) $popup.="&#xD;" . $lessons[$i]; 
			$hours[$index][$lessons[$i]->weekdayShort]->popup .=  $popup;
		}
		else{ //wenn bereits vorhanden -> Popup erweitern
 			$popup = "&#xD;".$lessons[$i]->suShort.": ".$lessons[$i]->teShort." ".$lessons[$i]->roName;
			if(isset($lessons[$i]->comment)) $popup.="&#xD;" . $lessons[$i]->comment;
			$hours[$index][$lessons[$i]->weekdayShort]->popup .=  $popup;
		}
		
		
	}
	else {
		$hours[$index][$lessons[$i]->weekdayShort] = $lessons[$i] ; //erstellen eines Eintrages wenn keiner vorhanden

		if($mode == 'schueler')$popup = $lessons[$i]->suShort.": ".$lessons[$i]->teShort." ".$lessons[$i]->roName;
		else $popup = $lessons[$i]->clName." ".$lessons[$i]->roName;
		if(isset($lessons[$i]->comment)) $popup.="&#xD;" . $lessons[$i]->comment;
		$hours[$index][$lessons[$i]->weekdayShort]->popup = $popup;
	}
	
}
$offset = 0;
$dayShort= array(1=>'Mo',2=>'Di',3=>'Mi',4=>'Do',5=>'Fr');
if(date("N")<6) $offset = 1-date("N");
else $offset = 8-date("N");
if(isset($week) && $week == "next") $offset+=7;
if($displaytype == "modificated" ){
echo "Dieser Stundenplan ist g&uuml;ltig: ". date("Y.m.d",time()+24*60*60*$offset) ."-".date("Y.m.d",time()+24*60*60*($offset+4));

	for($j=0;$j<5;$j++)
	{	//fehlende Klassen abfragen
 		$missingClasses= getMissingClasses(date("Y-m-d",time()+24*60*60*$offset) ); 
		if(isset($missingClasses))
		{	
			for($i=0;$i<17;$i++)
			{
 			
 				if(isset($missingClasses[$i])&& isset($hours[$i][$dayShort[$j+1]]))
				{
 					
					if(array_key_exists($hours[$i][$dayShort[$j+1]]->clName,$missingClasses[$i])) 
					{
 						$className= $hours[$i][$dayShort[$j+1]]->clName;
 						$hours[$i][$dayShort[$j+1]]->suShort = "&#160;";
						$hours[$i][$dayShort[$j+1]]->popup = $missingClasses[$i][$className];
 					}
 				}
			}		
		}
		//Supplierungen abfragen
		$substitudes = getSubstitude(date("Y-m-d",time()+24*60*60*$offset),$name,$mode);
		$offset++;
		
		if(isset($substitudes)){
			for($i=0; $i <count($substitudes); $i++)
			{
 				$dayName =  $dayShort[date("N",strtotime($substitudes[$i]['time']))];
				if($substitudes[$i]['newSub']){ //wenn Stunde hinzugefügt wurde
 					$popup = $substitudes[$i]['suShort']. ": " . $substitudes[$i]['teShort'] . " ". $substitudes[$i]['roName'];
					$popup .= "&#xD;" . $substitudes[$i]['comment'];
 				 	$hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "<td class ='changed' title='".$popup."'>".$substitudes[$i]['suShort'];
					$hours[$substitudes[$i]['startHour']][$dayName]->startHour = $substitudes[$i]['startHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->endHour = $substitudes[$i]['endHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->teShort = $substitudes[$i]['teShort'];
					$hours[$substitudes[$i]['startHour']][$dayName]->popup = "" ;
				}


				if($substitudes[$i]['remove']){ //wenn Stunde gelöscht wurde
					$temp = $hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort;
					$temp = str_replace($substitudes[$i]['oldSuShort'],"",$temp);
					$temp = str_replace("|","",$temp);
					if(isset($hours[$substitudes[$i]['startHour']][$dayName]->popup)) $temp2=$hours[$substitudes[$i]['startHour']][$dayName]->popup . $substitudes[$i]['comment'];
					else $temp2=$substitudes[$i]['comment'];
					$hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort = "<td class ='changed' title='".$temp2."'>".$temp;
				}


				if(!$substitudes[$i]['newSub'] and !$substitudes[$i]['remove'])
				{ //wenn Stunde verschoben wurde
					if(isset($hours[$substitudes[$i]['oldStartHour']][$dayName])){
						$temp = $hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort;
						$temp = str_replace($substitudes[$i]['oldSuShort'],"",$temp);
						$temp = str_replace("|","",$temp);
						$hours[$substitudes[$i]['oldStartHour']][$dayName]->suShort = $temp;
					}
					if(isset($substitudes[$i]['suShort'])){
 						if(isset($hours[$substitudes[$i]['startHour']][$dayName]->popup))
						{
							$title = $hours[$substitudes[$i]['startHour']][$dayName]->popup;
						}
						else{ 
 							if($mode =='schueler')
							{
 								$title = $substitudes[$i]['suShort'].":". $substitudes[$i]['teShort']." ".$substitudes[$i]['roName'];
								$title .= "&#xD;" . $substitudes[$i]['comment'];
							}
							else
							{
 								$title = $substitudes[$i]['clName']."    ".$substitudes[$i]['roName'];
							}
						}
 				 		$hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "<td class ='changed' title='".$title."'>".$substitudes[$i]['suShort'];
					}
					else
					{
 						$hours[$substitudes[$i]['startHour']][$dayName]->suShort =  "<td class ='changed' title='".$title."'>".$substitudes[$i]['oldSuShort'];
					}
					$hours[$substitudes[$i]['startHour']][$dayName]->startHour = $substitudes[$i]['startHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->endHour = $substitudes[$i]['endHour'];
					$hours[$substitudes[$i]['startHour']][$dayName]->teShort = $substitudes[$i]['teShort'];
					$hours[$substitudes[$i]['startHour']][$dayName]->popup = $substitudes[$i]['comment'];
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
		{ 
			echo "<td></td>"; //Ausgabe eines leeren Feldes, wenn keine Stunde vorhanden
		}
	} 
	else {
		for ($j = 0; $j < 5; $j++) {
			if(isset($hours[$i][$days[$j]])){
					 if(strpos($hours[$i][$days[$j]]->suShort,"<td") === false){
					 echo "<td title=\"".$hours[$i][$days[$j]]->popup."\">";					 
					}

					echo $hours[$i][$days[$j]]->suShort;
			
			
			echo "</td>";
					if(($hours[$i][$days[$j]]->endHour) > $i) {
 						//kopiert aktuelle Stunde in nächste Stunde, wenn mehr als eine Stunde nacheinander stattfindet
						$hours[$i+1][$days[$j]] = NULL;
						$hours[$i+1][$days[$j]]->suShort = $hours[$i][$days[$j]]->suShort;
						$hours[$i+1][$days[$j]]->teShort = $hours[$i][$days[$j]]->teShort;
						$hours[$i+1][$days[$j]]->endHour = $hours[$i][$days[$j]]->endHour;	
						$hours[$i+1][$days[$j]]->popup = $hours[$i][$days[$j]]->popup;	 	
					}
				
			}
			else {
				echo "<td></td>";
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

function isEvening($hours) //Abfrage ob Abendschule,normal oder alle Stunden
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
function getMissingClasses($date){ //fehlende Klassen abrufen

	$where = "startDay <= '". $date."' and endDay >= '".$date ."'";
 	$missingClasses_sql = selectMissingClass($where,"");
	while($result = mysql_fetch_array($missingClasses_sql)) {    
		 		$results[]=$result;
			
			}	
	if(isset($results))	//umordnen in Array $missinClasses[Stunde][Klasse] = Grund
	{
		for($i=0; $i <count($results);$i++)
		{
 			$hour = $results[$i]['startHour'];
			$endHour = $results[$i]['endHour'];
			if($date != $results[$i]['endDay']) $endHour = 16;
			while($hour <= $endHour)
			{
 				$missingClasses[$hour][$results[$i]['clName']] = $results[$i]['reason'];
				$hour++;
 			}
 			
 		} 
		return $missingClasses;
	}
	else return Array();
}
pageFooter();
?>