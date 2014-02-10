<?php
	/* /modules/general/Main.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.1
	 * Beschreibung:
	 *	Bindet alle grundlegenden Module ein.
	 *
	 * Changelog:
	 *	0.1.2:	20. 09.	2013, Buchberger Florian - ascii-Zeichen-Filter-Funktion
	 *	0.1.1:	19. 09. 2013, Buchberger Florian - Cookie check
	 * 	0.1.0:  22. 06. 2013, Buchberger Florian - erste Version
	 */
	include_once("/home/sis/config.php");
	include_once(ROOT_LOCATION . "/modules/general/CheckCookies.php");
	include_once(ROOT_LOCATION . "/modules/general/ForceHTTPS.php");
	include_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
	include_once(ROOT_LOCATION . "/modules/general/Connect.php");
	include_once(ROOT_LOCATION . "/modules/general/Site.php");

	// maskiert alle nicht-ascii-Zeichen im Parameter 
	function sanitize($s) {
       		return preg_replace('/[^a-zA-Z0-9_.]/', '_', $s);
	}

?>
