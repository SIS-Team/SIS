<?php
	/* /modules/general/SessionManager.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.1
	 * Beschreibung:
	 *	initialisiert Session; stellt Funktionen zur Verwanltung der Session zur Verfügung
	 *
	 * Changelog:
	 * 	0.1.0:  22. 06. 2013, Buchberger Florian - erste Version
	 *	0.1.1:	15. 10. 2013, Buchberger Florian - login, logout
	 */
	
	include_once(ROOT_LOCATION . "/modules/general/ActionLogger.php");
	
	if (isset($_SESSION))
		if ($_SESSION['keep'])
				session_set_cookie_params(60 * 60 * 24 * 7); // behält das session cookie für 1 Woche.
	
	@session_start();

	if (!isset($_SESSION['active']) || !$_SESSION['active']) {
		$_SESSION['time'] = time();
		$_SESSION['originalID'] = session_id();  
		$_SESSION['active'] = true;
		$_SESSION['keep'] = false;
		$_SESSION['loggedIn'] = false;
		$_SESSION['rights'] = array();
		$_SESSION['id'] = "";
		$_SESSION['name'] = "";
		$_SESSION['isTeacher'] = false;
		$_SESSION['class'] = "";
		$_SESSION['section'] = "";
	}
	
	session_regenerate_id();
	
	/*
	 * beendet die Session, setzt $loggedIn zurück
	 */
	function killSession() {
		global $_SESSION, $logeedIn;
		$_SESSION['active'] = false;
		$_SESSION['loggedIn'] = false;
		$_SESSION['rights']['N'] = false;
		$_SESSION['rights']['W'] = false;
		$_SESSION['rights']['M'] = false;
		$_SESSION['rights']['E'] = false;
		$_SESSION['rights']['root'] = false;
		$_SESSION['rights']['news'] = false;
	}

	function login($username, $password) {
		include_once(ROOT_LOCATION . "/modules/general/LDAP.php");
		$ent = LDAP_getUser($username);
		$dn = LDAP_getDN($ent);
		if (!$ent)
			throw new Exception("unknown user");
		if (empty($password))
			throw new Exception("no password given");
		if (!LDAP_login($dn, $password))
			throw new Exception("wrong password");
		$_SESSION['loggedIn'] = time();
		$_SESSION['name'] = getFullName($ent);
		$_SESSION['isTeacher'] = isTeacher($ent);
		if ($_SESSION['isTeacher'])
			$_SESSION['id'] = getInitials($ent);
		else
			$_SESSION['id'] = $username;
		$_SESSION['class'] = getClass($ent);
		$_SESSION['section'] = getSection($ent);
		$_SESSION['rights'] = getRights($ent);
		
		generateLog();
	}

	function logout() {
		killSession();
	}
?>
