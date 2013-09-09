<?php

	/* /modules/other/dateFunctions.php
	 * Autor: Handle Marco,
	 * Version: 0.2.0
	 * Beschreibung:
	 * Stellt Datumsfunktionen zur VerfÃ¼gung
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  09. 09. 2013, Weiland Mathias - Datumsfunktion hinzugefügt
	 */


function weekday($d) {
	$days = array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
	$x = strptime($d, "%Y-%m-%d");
	return sprintf("%s", $days[$x["tm_wday"]]);
}


function captureDate()	{
	$date = date("Y-m-d");
	return $date;
	}







?>
