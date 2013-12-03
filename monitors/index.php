<?php
	/* /monitors/index.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.0
	 * Beschreibung:
	 *	Start-Seite für Monitore
	 * 	GET-Parameter Name identifiziert den Monitor
	 *	übernimmt Registrierung der Monitore
	 *
	 * Changelog:
	 *	1.0.0:	24. 09. 2013, Buchberger Florian - + Registrierung (prüft IP)
	 * 	0.1.0:  22. 08. 2013, Buchberger Florian - erste Version
	 */
		
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
	
	if (!isset($_GET['name']) || empty($_GET['name'])) 
		die("no name given");

	if (isset($_GET['register'])) {
		$sql = "SELECT `ID` FROM `monitors` WHERE `ip` = '" . $_SERVER['REMOTE_ADDR'] . "'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)) {
			die("already bind to monitor");
		}
		$name = mysql_real_escape_string($_GET['name']);
		$sql = "INSERT IGNORE INTO `monitors` SET `name`='" . $name . "', `modeFK`=5, `file`='def.mp4', `roomFK`=1, `ip`='" . $_SERVER['REMOTE_ADDR'] . "'";
		$result = mysql_query($sql);
		header("LOCATION: ?name=" . $_GET['name']);
		die();
	}

	pageHeader(htmlspecialchars($_GET['name']), "monitors");
	pageFooter();
?>
