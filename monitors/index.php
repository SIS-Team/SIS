<?php
	/* /monitors/index.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Start-Seite für Monitore
	 * 	GET-Parameter Name identifiziert den Monitor
	 *
	 * Changelog:
	 * 	0.1.0:  22. 08. 2013, Buchberger Florian - erste Version
	 */
		
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
	
	if (!isset($_GET['name']) || empty($_GET['name'])) 
		die("no name given");

	pageHeader($_GET['name'], "monitors");
	pageFooter();
?>
