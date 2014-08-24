<?php
	require("../../config.php");
	require(ROOT_LOCATION . "/modules/general/SessionManager.php");
	if ($_SESSION['loggedIn']) {
		echo "window.location.href='menu.html';";
		//echo "window.location.replace('menu.html');";
		
	}
	
?>