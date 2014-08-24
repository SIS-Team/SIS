<?php
	require("../../config.php");
	require(ROOT_LOCATION . "/modules/general/SessionManager.php");
	if ($_SESSION['loggedIn']) {
		logout();	//Das Session-Cookie wird gelöscht
	}
	echo "window.location.href=\"index.html\"";
?>