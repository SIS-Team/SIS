<?php
	/* /modules/general/Main.php
	 * Autor: Buchberger Florian
	 * Beschreibung:
	 *	Bindet alle grundlegenden Module ein.
	 *
	 */
	include_once(ROOT_LOCATION . "/modules/general/CheckCookies.php");
	include_once(ROOT_LOCATION . "/modules/general/ForceHTTPS.php");
	include_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
	include_once(ROOT_LOCATION . "/modules/general/Connect.php");
	include_once(ROOT_LOCATION . "/modules/general/Site.php");

?>
