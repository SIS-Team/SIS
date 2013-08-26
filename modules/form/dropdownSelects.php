<?php
	/* /modules/form/dropdownSelects.php
	 * Autor: Handle Marco
	 * Version: 1.0.0
	 * Beschreibung:
	 *	ERstellt die Dropdown Einträge
	 *
	 * Changelog:
	 * 	1.0.0:  26. 08. 2013, Handle Marco - Selects für die Dropdownmenüs fertiggestellt
	 */
	
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");			//Bindet die Datenbank ein


//Section
$temp =  mysql_query("SELECT short FROM sections");
$selectSections = create($temp);

//Teacher
$temp = mysql_query("SELECT short FROM teachers");
$selectTeachers = create($temp);

//Rooms
$temp = mysql_query("SELECT name FROM rooms");
$selectRooms = create($temp);

//Subjects
$temp = mysql_query("SELECT short FROM subjects");
$selectSubjects = create($temp);

//Classes
$temp = mysql_query("SELECT name FROM classes");
$selectClasses = create($temp);

//Days
$selectDays = array(
	array("Mo", ""),
	array("Di", ""),
	array("Mi", ""),
	array("Do", ""),
	array("Fr", ""),
	);


//Erstell aus den mysql querys die Arrays mit den Inhalten
//$result ist der mysql_query
function create($result){

$array=array();	//Array erstellen

while ($row = mysql_fetch_array($result)){	//Führt für jeden Datensatz die Schleife einmal aus
	array_push($array,array($row[0],""));		//Fügt dem Array ein neues Array hinzu mit dem Inhalt und einem leeren Feld(wenn selected wird das zweite benötigt)
}

return $array;	//gibt das Fertige array zurück

}

?>