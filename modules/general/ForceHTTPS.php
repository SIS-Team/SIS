<?php
	/* /modules/general/ForceHTTPS.php
	 * Autor: Buchberger Florian
	 * Beschreibung:
	 *	Zwingt den Browser HTTPS zu verwenden.
	 */
	
	if(!isset($_SERVER['HTTPS']) || ($_SERVER['HTTPS'] != "on")) {
		header("LOCATION: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit();
	}
?>
