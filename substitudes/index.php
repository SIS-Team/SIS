<?php



	/* /backend/substitutesplan/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt Supplierplan aus
	 *
	 * Changelog:
	 * 	0.1.0:  09. 09. 2013, Weiland Mathias  - erste Version
	 */
	 
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung


$substitudes = array();

//Seitenheader
pageHeader("Formular","main");

printf("<table>");
printf("<tr>");
for($counter = 0; $counter <=2; $counter++)
{
	printf("<td>"); 
		$day = captureDate($counter);		//aktuelles Datum abfragen
		printf("Supplierungen vom ".$day);
		 
		//Tabellenkopfausgabe
		printf("<table border = 1 frame = void >");
		printf("<tr>");
		printf("<td>Klasse</td>");
		printf("<td>Stunde</td>");
		printf("<td>Zu supplieren durch</td>");
		printf("<td>Fach</td>");
		printf("<td>Bemerkung</td>");
		printf("</tr>");
		
		
		getSubstitude($day);		//Supplierungen des gewählten Datums abrufen
		
		for($count = 0;; $count++)	//Supplierungen ausgeben
		{
		  if(empty($substitudes[$count][2]) == true) break;		//Abbruch wenn keine weiteren Einträge
		printf("<tr>");
		 printf( "<td>".$substitudes[$count][2]."</td>");	//Klassenname
		 printf( "<td>".$substitudes[$count][7]."</td>");	//supplierte Stunde
		 printf( "<td>".$substitudes[$count][4]."</td>");	//supplierender Lehrer
		 printf( "<td>".$substitudes[$count][3]."</td>");	//Fach
		 printf( "<td>".$substitudes[$count][11]."</td>");	//Bemerkung
		 printf( "</tr>");
		
		}
		$substitudes = array();
	
	printf("</td>");
}
printf("</tr>");
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