<?php
	/* /modules/monitors/Main.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 * 	definiert Funktionen, etc zum Abrufen von Informationen der Monitore
	 *
	 * Changelog:
	 * 	0.1.0: 09. 09. 2013, Buchberger Florian - erste Version
	 */

	include_once("../../config.php");
	include_once(ROOT_LOCATION . "/modules/general/Connect.php");

	// gibt den Monitor als MySQL Objekt zurück
	// Spalten: id, name, file, type, room, roomID
	function getMonitorByName($name) {
		$name = mysql_real_escape_string($name);
		$sql = "SELECT `monitors`.`ID` AS `id`, `monitors`.`name`, `monitors`.`text` AS `text`, `monitors`.`file` AS `file`, `mod`.`name` AS `type`, `ro`.`name` AS `room`, `ro`.`ID` AS `roomID`, `monitors`.`ip` AS `ip`, `dm`.`name` AS `displayMode`, `monitors`.`displayStartDaytime` AS `startTime`, `monitors`.`displayEndDaytime` AS endTime, `monitors`.`time` AS `regTime`, `s`.`name` AS `section` 
			FROM `monitors` 
			LEFT JOIN `monitorMode` AS `mod` ON `monitors`.`modeFK`=`mod`.`ID` 
			LEFT JOIN `rooms` AS `ro` ON `monitors`.`roomFK`=`ro`.`ID` 
			LEFT JOIN `displayMode` AS `dm` ON `monitors`.`displayModeFK`=`dm`.`ID` 
			LEFT JOIN `sections` AS `s` ON `monitors`.`sectionFK`=`s`.`ID`
			WHERE `monitors`.`name`='" . $name . "'";
		$result = mysql_query($sql);
		echo mysql_error();
		if (!mysql_num_rows($result))
			return false;
		return mysql_fetch_object($result);
	}
	
	// gibt result für alle Monitors zurück
	// Spalten: id, name, file, type, room, roomID
	function getAllMonitors() {
		$sql = "SELECT `monitors`.`ID` AS `id`, `monitors`.`name`, `monitors`.`text` AS `text`, `monitors`.`file` AS `file`, `mod`.`name` AS `type`, `ro`.`name` AS `room`, `ro`.`ID` AS `roomID`, `monitors`.`ip` AS `ip`, `dm`.`name` AS `displayMode`, `monitors`.`displayStartDaytime` AS `startTime`, `monitors`.`displayEndDaytime` AS endTime, `monitors`.`time` AS `regTime`, `s`.`short` AS `sectionShort`, `s`.`name` AS `section` 
			FROM `monitors` 
			LEFT JOIN `monitorMode` AS `mod` ON `monitors`.`modeFK`=`mod`.`ID` 
			LEFT JOIN `rooms` AS `ro` ON `monitors`.`roomFK`=`ro`.`ID` 
			LEFT JOIN `displayMode` AS `dm` ON `monitors`.`displayModeFK`=`dm`.`ID`
			LEFT JOIN `sections` AS `s` ON `monitors`.`sectionFK`=`s`.`ID`";
		return mysql_query($sql);
	}

?>
