<?php
	/* /modules/general/CheckCookies.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.0
	 * Beschreibung:
	 *	Prüft, ob Cookies erlaubt sind und leitet um
	 *	Erneuert Allowed-Cookie
	 *
	 * Changelog:
	 * 	1.0.0:  19. 09. 2013, Buchberger Florian - erste Version
	 */

	if(!isset($_COOKIE['allowed']) || (!$_COOKIE['allowed'])) {
		header("LOCATION: " . RELATIVE_ROOT . "/cookies/?return=" . urlencode($_SERVER['REQUEST_URI']));
		die();
	}
	setcookie("allowed", true, time() + (60 * 60 * 24 * 100), "/"); // cookie wieder für 100 Tage speichern
?>
