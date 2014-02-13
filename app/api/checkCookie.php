<?php
	include("../../config.php");
	include(ROOT_LOCATION . "/modules/general/SessionManager.php");
	if ($_SESSION['loggedIn']) {
		echo "window.location.href=\"menu.html\";";	//Wenn ein Cookie gesetzt ist wirder Nutzer direkt auf den Stundenplan weitergeleitet
	}
?>