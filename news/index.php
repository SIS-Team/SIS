<?php
	/* /news/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt News aus
	 *
	 * Changelog:
	 * 	0.1.0:  12. 10. 2013, Weiland Mathias  - erste Version
	 */	 
include("../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung

//Seitenheader
pageHeader("Formular","main");

$result = selectAll("news","","");	//gesamte News-Tabelle abfragen
while ($row = mysql_fetch_object($result)) {
		$news[] = $row;
}
$date = CaptureDate("");  //aktuelles Datum abfragen
echo "<h1><u> NEWS vom ".$date."</u></h1> </br>"; 
for($i = 0;$i < count($news);$i++)
{ 
	$startDate = $news[$i]->startDay;		//Startdatum abfragen
	$endDate = $news[$i]->endDay;		//Enddatum abfragen
 
 	if(($startDate <= $date) && ($endDate >= $date) && ($news[$i]->display ==1)){ //nur wenn aktuelles Datum zwischen Start- und Enddatum 
		echo "<h2>" . $news[$i]->title . "</h2></br>";
  		echo $news[$i]->text;
  		echo "</br></br></br></br></br>";
	}
}
pageFooter();
?>