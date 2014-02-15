<?php
	/* /news/index.php
	 * Autor: Weiland Mathias
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Gibt News aus
	 * Changelog:
	 * 	0.1.0:  12. 10. 2013, Weiland Mathias  - erste Version
	 */	 
include("../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung

if(!($_SESSION['loggedIn'])) header("Location: ".RELATIVE_ROOT."/"); //Kontrolle ob angemeldet

//Seitenheader
pageHeader("News","main");
$sql ="SELECT `ID` FROM sections WHERE `short` = '".$_SESSION['section']."'";
$section_result  = mysql_query($sql);
while ($row = mysql_fetch_object($section_result)) {
		$section = $row;
}
$where  = " sectionFK = '".$section->ID."' OR sectionFK = '0'" ;
$result = selectAll("news",$where,"");	//gesamte News-Tabelle abfragen wo die Abteilung des Bnutzers oder all Abteilungen eingetragen ist
while ($row = mysql_fetch_object($result)) {
		$news[] = $row;
}
$date = date("Y-m-d");  //aktuelles Datum abfragen
echo "<h1><u> ".str_replace("-",".",$date)."</u></h1> </br>"; 
if(isset($news)){
	for($i = 0;$i < count($news);$i++)
	{ 
		$startDate = $news[$i]->startDay;		//Startdatum abfragen
		$endDate = $news[$i]->endDay;		//Enddatum abfragen
	 	if(($startDate <= $date) && ($endDate >= $date) && ($news[$i]->display ==1)){ //nur wenn aktuelles Datum zwischen Start- und Enddatum 
			echo "<h2>" . $news[$i]->title . "</h2>";
	  		echo $news[$i]->text;
	  		echo "</br></br></br>";
		}
	}
}
pageFooter();
?>