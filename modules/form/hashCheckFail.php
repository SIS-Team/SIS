<?php

	/* /modules/form/hashCeckFail.php
	 * Autor: Handle Marco
	 * Version: 0.a.0
	 * Beschreibung:
	 *	Stellt Funktionen bereit um den Hasch zu checken und bei Fehler eine Fehlermeldung auszugeben
	 *
	 */

function check(){
	try {
		$hashGenerator->check();
	} catch (Exception $e) {
		header("LOCATION: ?error");
		exit();
	}
}

function fail(){
	if(isset($_GET['fail']))
		echo "<div><br>Es ist ein Fehler aufgetreten. Bitte das Formular neu laden.<br><br><div>";
}




?>