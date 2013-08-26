<?php
	/* /monitors/index.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Start-Seite für Monitore
	 * 	GET-Parameter Name identifiziert den Monitor
	 *
	 * Changelog:
	 * 	0.1.0:  22. 06. 2013, Buchberger Florian - erste Version
	 */
		
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
	
	$name = $_GET['name'];

	if (empty($name)) {
		die("no name given");
	}

	pageHeader($name, "monitors");
	pageFooter();
?>
