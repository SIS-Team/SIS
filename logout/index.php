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
	require("../config.php");
	require(ROOT_LOCATION . "/modules/general/Main.php");

	logout();

	header("LOCATION: " . RELATIVE_ROOT . "/");

?>
