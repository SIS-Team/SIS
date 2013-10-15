<?php



	/* /news/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Supplierplan aus
	 *
	 * Changelog:
	 * 	0.1.0:  12. 10. 2013, Weiland Mathias  - erste Version
	 */
	 
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung


//Seitenheader
pageHeader("Formular","main");

$result = selectAll("news");	//gesamte News-Tabelle abfragen
while ($row = mysql_fetch_object($result)) {
		$array[] = $row;}
//print_r($array);
$date = CaptureDate();  //aktuelles Datum abfragen
echo "<h1><u> NEWS vom ".$date."</u></h1> </br>"; 
$date = preg_replace('![^0-9]!', '', $date); 	//Nur Zahlen zulassen


for($i = 0;$i < count($array);$i++)
{ //echo $i ;
 $startDate = $array[$i]->startDay;		//Startdatum abfragen
 $startDate = preg_replace('![^0-9]!', '', $startDate);	//Nur Zahlen zulassen
 //echo $newDate ."</br>";
 
  $endDate = $array[$i]->endDay;		//Enddatum abfragen
  $endDate = preg_replace('![^0-9]!', '', $endDate); //Nur Zahlen zulassen
 
 if(($startDate <= $date) && ($endDate >= $date)) //nur anzeigen wenn aktuelles Datum zwischen Satrt- und Enddatum liegt
 {echo "<h2>" . $array[$i]->title . "</h2></br>";
  echo $array[$i]->text;
  echo "</br></br></br></br></br>";
}

 }


	
//print_r($array);
pageFooter();
?>
