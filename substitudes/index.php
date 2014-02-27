<?php
	/* /substitutes/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Supplierplan aus
	 *
	 * Changelog:
	 * 	0.1.0:  09. 09. 2013, Weiland Mathias  - erste Version
	 */
include_once("../config.php");	 
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verfügung

ifNotLoggedInGotoLogin();	//Kontrolle ob angemeldet
$permission = getPermission();
if($permission == "root") $mode = "root";
else{
	if($permission == "admin") $mode = "admin";
	else {
		if(!empty($_SESSION['isTeacher'])) $mode = "teacher";
		else $mode = "student";
	}
}
$substitudes = array();

//Seitenheader
pageHeader("Supplierplan","main");

echo "<div class ='keys'>";
echo "St. ... supplierte Stunde; ";
echo "Sup. ...Supplierlehrer; ";
echo "urs. ... urspr&uumlnglicher Lehrer; ";
echo "</div>";
$day_counter = 0;

for($counter = 0; $counter <=2; $counter++)
{   
	if(date("w", time() + 24 * 60 * 60 * $day_counter)==0) $day_counter++;
	if(date("w", time() + 24 * 60 * 60 * $day_counter)==6) $day_counter+=2;
	echo "<div id='d" . $counter . "' class='column background'>";
	$day = captureDate($day_counter);		//aktuelles Datum abfragen
	echo "Supplierungen vom ". weekday(date("Y-m-d",time() + 24*60*60*$day_counter)) ." ". date("d.",time() + 24*60*60*$day_counter). month(date("n",time() + 24*60*60*$day_counter)) ;
		 
	//Tabellenkopfausgabe
	echo "<table style =\"border-collapse:collapse\">";
	echo "<tr>";
	echo "<th>Klasse</th>";
	echo "<th>St.</th>";
	echo "<th>Sup</th>";
	echo "<th>Fach</th>";
	echo "<th>urs.</th>";
	echo "<th>Bemerkung</th>";
	echo "</tr>";
		
		
	$substitudes = getSubstitude($day,$mode);		//Supplierungen des gewählten Datums abrufen
		
	for($count = 0;$count<count($substitudes); $count++)	//Supplierungen ausgeben
		{
			echo "<tr>";
			echo "<td>".$substitudes[$count]['clName']."</td>";	//Klassenname
			if(!empty($substitudes[$count]['newStartHour'])){
				echo "<td>".$substitudes[$count]['newStartHour']." - ".$substitudes[$count]['newEndHour']."</td>";	//supplierte Stunde
			}
			else {
				echo "<td>".$substitudes[$count]['startHour']." - ".$substitudes[$count]['endHour']."</td>";
			}
			if(!empty($substitudes[$count]['teShort'])){
				echo "<td>".$substitudes[$count]['teShort']."</td>";	//supplierender Lehrer
			}
			else {
				echo "<td>&#160;</td>";
			}
			echo "<td>".$substitudes[$count]['suShort']."</td>";	//Fach
			echo "<td>".$substitudes[$count]['oldTeShort']."</td>";	//ursprünglicher Lehrer
			if(!empty($substitudes[$count]['comment'])){
 				echo "<td class='comment background'>".$substitudes[$count]['comment']."</td>";	//Bemerkung
			}
			else {
 				echo "<td>&#160;</td>";
			}
			echo "</tr>";
		}
	if(count($substitudes) == 0) echo "<tr><td colspan = 6 align = center> F&uuml;r diesen Tag sind keine Supplierungen vorgesehen</td></tr>";
	$substitudes = array();
	echo "</table>";
	echo "</div>";
	$day_counter++;
}

function getSubstitude($date,$mode){	//Supplierungen des gewählten Datums abrufen
	
	$section = getAdminSection();
	if($mode == "student"){
		$where = "time = '".mysql_real_escape_string($date)."' and classes.name = '" . mysql_real_escape_string($_SESSION['class']) . "'";	
	}
	if($mode == "admin"){
  		$where = "time = '".mysql_real_escape_string($date)."' and sections.short = '". mysql_real_escape_string($section)."'";
	}
	if($mode == "teacher"){
 		$where = "time = '".mysql_real_escape_string($date)."' and (teachers.short = '".mysql_real_escape_string($_SESSION['id'])."' or oldTeacher.short ='".mysql_real_escape_string($_SESSION['id'])."')";
 	}
	if($mode == "root"){
 		$where = "time = '".mysql_real_escape_string($date)."'";
	}
	$substitude_sql = selectSubstitude($where,"startHour")	
	or die("MySQL-Error: ".mysql_error());
	while($substitude = mysql_fetch_array($substitude_sql)) {    
 	$substitudes[]=$substitude;
	}
	if(isset($substitudes))	return $substitudes;	
}

pageFooter();
?>
