<?php
	/* /modules/general/ForceHTTPS.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.1
	 * Beschreibung:
	 *	Zwingt den Browser HTTPS zu verwenden.
	 *
	 * Changelog:
	 *	1.0.1:  22.06.2013, Buchberger Florian - Ausführung nach dem Ändern des Headers abbrechen.
	 * 	1.0.0:  22.06.2013, Buchberger Florian - erste Version
	 */
	
	if(!isset($_SERVER['HTTPS']) || ($_SERVER['HTTPS'] != "on")) {
		header("LOCATION: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		die();
	}
?>
