<?php
	/* /substitutes/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Supplierplan aus
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

echo "<div class ='keys' >";
echo "Sup. ...Supplierlehrer; ";
echo "urs. ... urspr&uumlnglicher Lehrer; ";
echo "</div>";

	if(!isset($_GET['change'])) $change = "actual";
	else $change = $_GET['change'];
	echo "<form method=\"get\">";
	if($change == "actual"){
		echo "<input type =\"radio\" name = \"change\" onclick= \"this.form.submit()\" value = \"actual\" checked>aktuelle Eintr&auml;ge";
		echo "<input type =\"radio\" name = \"change\" onclick= \"this.form.submit()\" value = \"next\" >n&auml;chste Eintr&auml;ge";
	}
	else {
		echo "<input type =\"radio\" name = \"change\" onclick= \"this.form.submit()\" value = \"actual\">aktuelle Eintr&auml;ge";
		echo "<input type =\"radio\" name = \"change\" onclick= \"this.form.submit()\" value = \"next\" checked>n&auml;chste Eintr&auml;ge"; 
	}
	echo "<noscript><input type =\"submit\" value=\"Anzeige &auml;ndern\"></noscript>"; 
	echo "</form>"; 

$day_counter = 0;

for($counter = 0; $counter <=1; $counter++)
{   
	if(date("w", time() + 24 * 60 * 60 * $day_counter)==0) $day_counter++;
	if(date("w", time() + 24 * 60 * 60 * $day_counter)==6) $day_counter+=2;
	if($change != 'actual' && $counter == 0) $day_counter+=2;
	echo "<div id='d" . $counter . "' class='column background'>";
	$day = captureDate($day_counter);		//aktuelles Datum abfragen
	echo "Supplierungen vom ". weekday(date("Y-m-d",time() + 24*60*60*$day_counter)) .", ". date("d.",time() + 24*60*60*$day_counter). month(date("n",time() + 24*60*60*$day_counter)) ;
	$allSubstitudes = array();
	$substitudes = getSubstitude($day,$mode);		//Supplierungen des gewählten Datums abrufen
if($mode=="teacher"){
	for($i=0;$i<count($substitudes);$i++)
	{
 		
		if(!empty($substitudes[$i]['startHour'])){
 			$startHour = $substitudes[$i]['startHour'];
		}
		else {
 			$startHour = $substitudes[$i]['oldStartHour'];
		}

		 if(!empty($substitudes[$i]['endHour'])){
 			$endHour = $substitudes[$i]['endHour'];
		}
		else {
 			$endHour = $substitudes[$i]['oldEndHour'];
		}
		if(empty($allSubstitudes[$startHour])){
			$allSubstitudes[$startHour]['comment'] = $substitudes[$i]['comment'];
			$allSubstitudes[$startHour]['class'] = $substitudes[$i]['clName'];			
			$allSubstitudes[$startHour]['Subject'] = $substitudes[$i]['suShort'];
			$allSubstitudes[$startHour]['oldTeacher'] = $substitudes[$i]['oldTeShort'];
			$allSubstitudes[$startHour]['newTeacher'] = $substitudes[$i]['teShort'];
			$allSubstitudes[$startHour]['endHour'] = $endHour;
		}
		else {
 		
			$allSubstitudes[$startHour]['class'] .= "|". $substitudes[$i]['clName'];	
		
		}
		
	}
}

if($mode != "teacher"){


	//Tabellenkopfausgabe
	echo "<table>";
	echo "<tr>";
	if($mode == "teacher"){
 		echo "<th>Stunden</th>";
		echo "<th>Klasse</th>";
	}
	else{
		if($mode != "student")	echo "<th>Klasse</th>";
		echo "<th>Stunden</th>";
	}
	echo "<th>Sup</th>";
	echo "<th>Fach</th>";
	echo "<th>urs.</th>";
	echo "<th>Bemerkung</th>";
	echo "</tr>";
		
	$oldClass = "";
	for($count = 0;$count<count($substitudes); $count++)	//Supplierungen ausgeben
		{
			echo "<tr>";
			if($mode !="student"){ 
				if($oldClass != $substitudes[$count]['clName']){
		 			if($count != count($substitudes)-1) echo "<td style=\"border-bottom:0\">";
					else echo "<td>";
					echo $substitudes[$count]['clName']."</td>";	//Klassenname
					$oldClass = $substitudes[$count]['clName'];
				}
				else {
		 			if($count != count($substitudes)-1) echo "<td style=\"border-top:0; border-bottom:0\"></td>";
					else echo "<td style=\"border-top:0\"></td>";		
				}
			}
			
			if(!empty($substitudes[$count]['startHour'])){
				if($substitudes[$count]['startHour'] != $substitudes[$count]['endHour']){
					echo "<td>".$substitudes[$count]['startHour']." - ".$substitudes[$count]['endHour']."</td>";	//supplierte Stunde
				}
				else echo "<td>".$substitudes[$count]['startHour']."</td>";
			}
			else {
				if($substitudes[$count]['oldStartHour'] != $substitudes[$count]['oldEndHour']){
					echo "<td>".$substitudes[$count]['oldStartHour']." - ".$substitudes[$count]['oldEndHour']."</td>";	//supplierte Stunde
				}
				else echo "<td>".$substitudes[$count]['oldStartHour']."</td>";
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
 				echo "<td>".$substitudes[$count]['comment']."</td>";	//Bemerkung
			}
			else {
 				echo "<td>&#160;</td>";
			}
			echo "</tr>";
		}
	if(count($substitudes) == 0) echo "<tr><td colspan = 6 align = center> F&uuml;r diesen Tag sind keine Supplierungen vorgesehen</td></tr>";
	echo "</table>";
}
else{
 	$empty = 0;
	echo "<table>";
	echo "<tr><th>Stunden</th><th>Klasse</th><th>Sup</th><th>Fach</th><th>urs.</th><th>Bemerkung</th></tr>";
	for($i=1;$i<17;$i++){
	 	if(!empty($allSubstitudes[$i])){
 			echo "<tr>";
			if($i != $allSubstitudes[$i]['endHour']) echo "<td>". $i."-".$allSubstitudes[$i]['endHour']."</td>";
			else echo "<td>" . $i ."</td>";
			echo "<td>".$allSubstitudes[$i]['class']."</td>";
			echo "<td>".$allSubstitudes[$i]['newTeacher']."</td>";
			echo "<td>".$allSubstitudes[$i]['Subject']."</td>";
			echo "<td>".$allSubstitudes[$i]['oldTeacher']."</td>";
			echo "<td>".$allSubstitudes[$i]['comment']."</td>";
			echo "</tr>";
		}
		else $empty++;
	}
	if($empty == 16) echo "<tr><td colspan = 6>F&uuml;r diesen Tag sind keine Supplierungen vorhanden</td></tr>";
	echo "</table>"; 
}

	echo "</div>";
	$day_counter++;
}

function getSubstitude($date,$mode){	//Supplierungen des gewählten Datums abrufen
	
	$section = getAdminSection();
	if($mode == "student"){
		$where = "time = '".mysql_real_escape_string($date)."' and classes.name = '" . mysql_real_escape_string($_SESSION['class']) . "'";
		$order = "startHour";	
	}
	if($mode == "admin"){
  		$where = "time = '".mysql_real_escape_string($date)."' and sections.short = '". mysql_real_escape_string($section)."'";
		$order = "classes.name,startHour";
	}
	if($mode == "teacher"){
 		$where = "time = '".mysql_real_escape_string($date)."' and (teachers.short = '".mysql_real_escape_string($_SESSION['id'])."' or oldTeacher.short ='".mysql_real_escape_string($_SESSION['id'])."')";
		$order = "startHour";
 	}
	if($mode == "root"){
 		$where = "time = '".mysql_real_escape_string($date)."'";
		$order = "classes.name,startHour";
	}
	$substitude_sql = selectSubstitude($where,$order);
	while($substitude = mysql_fetch_array($substitude_sql)) {    
 		$substitudes[]=$substitude;
	}
	if(isset($substitudes))	return $substitudes;	
}

pageFooter();
?>
