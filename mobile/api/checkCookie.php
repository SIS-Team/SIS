<?php
	include("../../config.php");
	include(ROOT_LOCATION . "/modules/general/SessionManager.php");
	if ($_SESSION['loggedIn']) {
		echo "window.location.href='menu.html';";
		//echo "window.location.replace('menu.html');";
		
	}
	
?>