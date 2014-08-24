<?php
	/* /modules/general/Main.php
	 * Autor: Buchberger Florian
	 * Beschreibung:
	 *	Bindet alle grundlegenden Module ein.
	 *
	 */
	require_once(ROOT_LOCATION . "/modules/general/CheckCookies.php");
	require_once(ROOT_LOCATION . "/modules/general/ForceHTTPS.php");
	require_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
	require_once(ROOT_LOCATION . "/modules/general/Connect.php");
	require_once(ROOT_LOCATION . "/modules/general/Site.php");

?>
