<?php


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");


$filename = 'klassen_import.csv';

$file = fopen($filename , "r");		//Datei lesend öffnen
if($file !=false){ 
while (!feof($file)) {				//Datei einlesen solange Zeilen verfügbar
    $buffer = fgets($file);			//Zeile in buffer speichern
    $teile = explode(";", $buffer);
    $sql="INSERT INTO classes (name,sectionFK,teacherFK,roomFK) VALUES ('".$teile[0]."','".$teile[1]."','".$teile[2]."','".$teile[3]."');";
    print_r($sql);
   	print_r(mysql_query($sql));
}
}

pageHeader("Formular","main");


pageFooter();
?>
