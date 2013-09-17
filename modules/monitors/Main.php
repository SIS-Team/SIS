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

	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");

	// gibt den Monitor als MySQL Objekt zurück
	// Spalten: id, file, type, room, roomID
	function getMonitorByName($name) {
		$name = mysql_real_escape_string($name);
		$sql = "SELECT mo.ID AS id, mo.file AS file, mod.name AS type, ro.name AS room, ro.ID AS roomID FROM monitors AS mo INNER JOIN monitorMode AS mod ON mo.modeFK=mod.ID AND INNER JOIN rooms AS ro ON mo.roomFK=ro.ID WHERE `name`='" . $name . "'";
		$result = mysql_query($sql);
		return mysql_fetch_object($result);
	}
	
	// gibt result für alle Monitors zurück
	// Spalten: id, name, file, type, room, roomID
	function getAllMonitors() {
		$sql = "SELECT `monitors`.`ID` AS `id`, `monitors`.`name`, `monitors`.`file` AS `file`, `mod`.`name` AS `type`, `ro`.`name` AS `room`, `ro`.`ID` AS `roomID` FROM `monitors` INNER JOIN `monitorMode` AS `mod` ON `monitors`.`modeFK`=`mod`.`ID` INNER JOIN `rooms` AS `ro` ON `monitors`.`roomFK`=`ro`.`ID`";
		return mysql_query($sql);
	}

?>
