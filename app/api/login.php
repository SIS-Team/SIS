<?php
	include("../../config.php");
	include(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
	//die nächste datei würde dei db connect ersetzen
	include(ROOT_LOCATION . "/modules/general/Connect.php");
	include(ROOT_LOCATION . "/modules/general/SessionManager.php");			//Stellt die select-Befehle zur Verfügung

	header('Content-Type: application/javascript; charset=UTF-8');	
	

	if (isset($_GET['username'])) {
		try {
				login($_GET['username'],$_GET['password']);
				echo "window.location.href = 'stundenplan.html';";
			} catch (Exception $e) {
				echo "document.body.innerHTML += '<h1 style=\"color: red;\">Benutzername oder Passwort falsch!</h1>';";
			}
			die();
	}
?>
