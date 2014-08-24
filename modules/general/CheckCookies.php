<?php
	/* /modules/general/CheckCookies.php
	 * Autor: Buchberger Florian
	 * Beschreibung:
	 *	Prüft, ob Cookies erlaubt sind und leitet um
	 *	Erneuert Allowed-Cookie
	 */

	if(!isset($_COOKIE['allowed']) || (!$_COOKIE['allowed'])) {
		header("LOCATION: " . RELATIVE_ROOT . "/cookies/?return=" . urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	setcookie("allowed", true, time() + (60 * 60 * 24 * 100), "/"); // cookie wieder für 100 Tage speichern
?>
