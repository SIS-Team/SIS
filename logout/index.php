<?php
	/* /login/index.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Logout-Frontend
	 *
	 * Changelog:
	 * 	0.1.0:  15. 10. 2013, Buchberger Florian - erste Version
	 */
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");

	logout();

	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Menu.php");
	generateDefaultMenu();


	pageHeader("Logout", "main");
?>
<h1>Sie sind nun abgemeldet... : )</h1>
<?php
	pageFooter();
?>
