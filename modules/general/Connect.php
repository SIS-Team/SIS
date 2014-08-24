<?php
	/* /modules/general/Connect.php
	 * Autor: Buchberger Florian
	 * Beschreibung:
	 *	Stellt Verbindung zum MySQL-Server her.
	 */
	require_once(ROOT_LOCATION . "/modules/general/MySQLpassword.php");
	$connection = mysql_connect($host, $user, $passwd);
	mysql_select_db('sis');
	echo mysql_error();
?>
