<?php
	/* /timetables/all/index.php
	 * Autor: Weiland Mathias
	 * Beschreibung:
	 *	Gibt Stundenplan von allen Klassen/Lehrern aus
	 */
include_once("../../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verfügung

ifNotLoggedInGotoLogin();	//Kontrolle ob angemeldet
$permission = getPermission();
if($permission !='root' && $permission != 'admin') noPermission();
pageHeader("Alle Stundenpl&auml;ne","main");
echo "<div class ='timetable_column'>";
echo "<table border = 1>";
echo "<tr><th>Stunde</th><th>Mo</th><th>Di</th><th>Mi</th><th>Do</th><th>Fr</th></tr>";
for($i = 1;$i<17;$i++)
{ 
 	echo "<tr><td>".$i."</td>";
	for($j=1;$j<6;$j++)
	{
 		echo "<td>".$i*$i*$j*$j."</td>";
	}
	echo "</tr>";
	 
}

echo "</table>";
echo "</div>";

?>