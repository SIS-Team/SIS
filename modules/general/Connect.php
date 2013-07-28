<?php
	/* /modules/general/Connect.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.0
	 * Beschreibung:
	 *	Stellt Verbindung zum MySQL-Server her.
	 *
	 * Changelog:
	 * 	1.0.0:  22. 06. 2013, Buchberger Florian - erste Version
	 */
	$connection = mysql_connect('localhost', 'sisadmin', 'ahNgahng');
	mysql_select_db('sis');
?>
