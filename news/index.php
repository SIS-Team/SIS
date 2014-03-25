<?php
	/* /news/index.php
	 * Autor: Weiland Mathias
	 * Beschreibung:
	 *	Gibt News aus
	 */	 
include("../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung
require_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stell Verschiedenes zur Verfügung

ifNotLoggedInGotoLogin(); //Kontrolle ob angemeldet
//Seitenheader
pageHeader("News vom ".date("d."). month(date("n")) . date(" Y"),"main");
$sql ="SELECT `ID` FROM sections WHERE `short` = '".$_SESSION['section']."'";
$section_result  = mysql_query($sql);
while ($row = mysql_fetch_object($section_result)) {
		$section = $row;
}
if(isset($section)) $where  = " sectionFK = '".$section->ID."' OR sectionFK = '0'" ;
else $where = "";
$result = selectAll("news",$where,"");	//gesamte News-Tabelle abfragen wo die Abteilung des Benutzers oder alle Abteilungen eingetragen ist
while ($row = mysql_fetch_object($result)) {
		$news[] = $row;
}
$date = date("Y-m-d");  //aktuelles Datum abfragen
if(isset($news)){
	for($i = 0;$i < count($news);$i++)
	{ 
		$startDate = $news[$i]->startDay;		//Startdatum abfragen
		$endDate = $news[$i]->endDay;		//Enddatum abfragen
	 	if(($startDate <= $date) && ($endDate >= $date) && ($news[$i]->display ==1)){ //nur wenn aktuelles Datum zwischen Start- und Enddatum 
			echo "<h2>" . $news[$i]->title . "</h2>";
	  		echo str_replace("\n","<br />",$news[$i]->text);
	  		echo "</br></br>";
		}
	}
}
pageFooter();
?>