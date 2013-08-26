<?php
	/* /modules/general/Main.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Bindet alle grundlegenden Module ein.
	 *
	 * Changelog:
	 * 	0.1.0:  22. 06. 2013, Buchberger Florian - erste Version
	 */
		
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/ForceHTTPS.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/SessionManager.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Site.php");

?>
