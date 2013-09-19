<?php
	/* /modules/general/Main.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.1
	 * Beschreibung:
	 *	Bindet alle grundlegenden Module ein.
	 *
	 * Changelog:
	 *	0.1.1:	19. 09. 2013, Buchberger Florian - Cookie check
	 * 	0.1.0:  22. 06. 2013, Buchberger Florian - erste Version
	 */

	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/CheckCookies.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/ForceHTTPS.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/SessionManager.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Site.php");

?>
