<?php
	include("../../config.php");
    include(ROOT_LOCATION . "/modules/database/selects.php");		//Stellt die select-Befehle zur Verfügung

    include(ROOT_LOCATION . "/modules/general/Connect.php");		//Stellt Verbindung mit der Datenbank her
    include(ROOT_LOCATION . "/modules/general/SessionManager.php");	//SessionManager um Sessions für die App-Nutzung zu verwenden


	header('Content-Type: application/javascript; charset=UTF-8');	
	echo "string";
	
	if (isset($_POST['username']) && isset($_POST['password'])) {
		try {
				login($_POST['username'],$_POST['password']);
				echo "window.location.href = 'menu.html';";	//Nach dem Login wird der Nutzer direkt weitergeleitet(stundenplan.html)
			} catch (Exception $e) {
				echo "document.body.innerHTML += '<h1 style=\"color: red;\">Benutzername oder Passwort falsch!</h1>';";
			}
			die();
	}
	
?>