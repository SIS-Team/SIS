<?php

/* /modules/other/dateFunctions.php
* Autor: Handle Marco,
* Version: 0.2.0
* Beschreibung:
* Stellt Datumsfunktionen zur Verf�gung
*
*/


function weekday($d) {
	$days = array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
	$x = strptime($d, "%Y-%m-%d");

	return $days[$x["tm_wday"]];
}


function captureDate($offset)	{
	if (!isset($offset))
		$offset = 0;
	return date("Y.m.d", time() + 24 * 60 * 60 * $offset);
}

function prevNextDay($d) {
	$days = array("Mo", "Di", "Mi", "Do", "Fr");
	$arr=array_keys($days,$d);
	
	$key=implode($arr);
	
	if($key>0 && $key<4){
		$prev=$days[$key-1];
		$next=$days[$key+1];
	}
	else if($key==0){
		$prev="";
		$next=$days[$key+1];
	}
	else if($key==4){
		$next="";
		$prev=$days[$key-1];
	}

	$array['prev']=$prev;
	$array['next']=$next;
	
	return $array;
}

//Datum um eins erh�hen
function date_increase($d) {
	do{
		$x = strptime($d, "%Y-%m-%d");
		$y = mktime($x["tm_hour"], $x["tm_min"], $x["tm_sec"], 
				$x["tm_mon"]+1, $x["tm_mday"]+1, 1900+$x["tm_year"] );
		$d = strftime("%Y-%m-%d", $y);		
	}while(date("N",strtotime($d))>=6);
	
	return $d;
}

//Datum um eins zur�ckstellen
function date_decrease($d) {
	do{
		$x = strptime($d, "%Y-%m-%d");
		$y = mktime($x["tm_hour"], $x["tm_min"], $x["tm_sec"], 
				$x["tm_mon"]+1, $x["tm_mday"]-1, 1900+$x["tm_year"] );
		$d = strftime("%Y-%m-%d", $y);		
	}while(date("N",strtotime($d))>=6);
	
	return $d;
}

//Erh�t so lange, bis das Datum kein Wochenende ist
function no_weekend($d) {
	while(date("N",strtotime($d))>=6){
		$x = strptime($d, "%Y-%m-%d");
		$y = mktime($x["tm_hour"], $x["tm_min"], $x["tm_sec"], 
				$x["tm_mon"]+1, $x["tm_mday"]+1, 1900+$x["tm_year"] );
		$d = strftime("%Y-%m-%d", $y);		
	}	
	return $d;
}

function month($number) {
$month = array(1=>'J&auml;nner',2=>'Februar',3=>'M&auml;rz',4=>'April',5=>'Mai',6=>'Juni',7=>'Juli',8=>'August',9=>'September',10=>'Oktober',11=>'November',12=>'Dezember');

return $month[$number];
}

function dayShort($number) {
$dayShort = array(1=>'Mo',2=>'Di',3=>'Mi',4=>'Do',5=>'Fr');

return $dayShort[$number];
}


?>
