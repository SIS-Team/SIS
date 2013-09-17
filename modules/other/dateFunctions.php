<?php

/* /modules/other/dateFunctions.php
* Autor: Handle Marco,
* Version: 0.2.0
* Beschreibung:
* Stellt Datumsfunktionen zur VerfÃ¼gung
*
* Changelog:
* 0.1.0: 22. 07. 2013, Handle Marco - erste Version
* 0.2.0: 09. 09. 2013, Weiland Mathias - Datumsfunktion hinzugefügt
*/


function weekday($d) {
$days = array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
$x = strptime($d, "%Y-%m-%d");
return sprintf("%s", $days[$x["tm_wday"]]);
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





?>