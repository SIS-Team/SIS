<?php
	/* /modules/general/SessionManager.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	initialisiert Session; stellt Funktionen zur Verwanltung der Session zur Verfügung
	 *	deklariert global $loggedIn, $userid
	 *
	 * Changelog:
	 * 	0.1.0:  22. 06. 2013, Buchberger Florian - erste Version
	 */
	
	@session_start();

	if (!isset($_SESSION['active']) || !$_SESSION['active']) {
		$_SESSION['active'] = true;
		$_SESSION['loggedIn'] = false;
		$_SESSION['userid'] = 0;
	}

	/*
	 * true, wenn der Benutzer eingelogt ist
	 */
	$loggedIn = $_SESSION['loggedIn'];

	/*
	 * beinhaltet die Benutzerid des eingeloggten Benutzers
	 * vorausgesetzt $loggedIn ist true
	 */
	$userid = $_SESSION['userid'];
	
	/*
	 * beendet die Session, setzt $loggedIn zurück
	 */
	function killSession() {
		global $_SESSION, $logeedIn;
		$_SESSION['active'] = false;
		$loggedIn = false;
	}
?>
