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
	 
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung


if(!($_SESSION['loggedIn']))die("Critical Error </br> Bist du sicher, dass du angemeldet bist?"); //Kontrolle ob angemeldet

$substitudes = array();

//Seitenheader
pageHeader("Formular","main");

echo "<div class ='keys'>";
echo "St. ... supplierte Stunde; ";
echo "Sup. ...Supplierlehrer; ";
echo "urs. ... ursprünglicher Lehrer; ";
echo "</div>";
for($counter = 0; $counter <=2; $counter++)
{
	echo "<div id='d" . $counter . "' class='column background'>";
		$day = captureDate($counter);		//aktuelles Datum abfragen
		echo "Supplierungen vom ".$day;
		 
		//Tabellenkopfausgabe
		echo "<table>";
		echo "<tr>";
		echo "<th>Klasse</th>";
		echo "<th>St.</th>";
		echo "<th>Sup</th>";
		echo "<th>Fach</th>";
		echo "<th>urs.</th>";
		echo "<th>Bemerkung</th>";
		echo "</tr>";
		
		
		getSubstitude($day);		//Supplierungen des gewählten Datums abrufen
		
		for($count = 0;; $count++)	//Supplierungen ausgeben
		{
		  if(empty($substitudes[$count][2]) == true) break;		//Abbruch wenn keine weiteren Einträge
		 echo "<tr>";
		 echo "<td>".$substitudes[$count][2]."</td>";	//Klassenname
		 echo "<td>".$substitudes[$count][7]."</td>";	//supplierte Stunde
		 echo "<td>".$substitudes[$count][4]."</td>";	//supplierender Lehrer
		 echo "<td>".$substitudes[$count][3]."</td>";	//Fach
	 	 echo "<td>".$substitudes[$count][15]."</td>";	//ursprünglicher Lehrer
		 echo "<td class='comment background'>".$substitudes[$count][11]."</td>";	//Bemerkung
		 echo "</tr>";
		
		}
		$substitudes = array();
		
		echo "</table>";
	echo "</div>";
}

function getSubstitude($date){	//Supplierungen des gewählten Datums abrufen
	global $substitudes;
			$where = "time = '".$date."'";
				
			$substitude_sql = selectSubstitude($where,"clName")	
			or die("MySQL-Error: ".mysql_error());
			while($substitude = mysql_fetch_array($substitude_sql)) {    
		 	$substitudes[]=$substitude;
			 
			//print_r($substitudes);  //Kontrolle des Ergebnis-Arrays
			}	
}



pageFooter();
?>