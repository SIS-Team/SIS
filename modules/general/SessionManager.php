<?php
	/* /modules/general/SessionManager.php
	 * Autor: Buchberger Florian
	 * Beschreibung:
	 *	initialisiert Session; stellt Funktionen zur Verwanltung der Session zur Verfügung
	 */
	
	if (isset($_SESSION))
		if ($_SESSION['keep'])
			session_set_cookie_params(60 * 60 * 24 * 7); 
			// behält das session cookie für 1 Woche.
	
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
	
	include_once(ROOT_LOCATION . "/modules/general/ActionLogger.php");
	
	/*
	 * beendet die Session
	 */
	function killSession() {
		global $_SESSION;
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
		try {
			if (!$ent)
				throw new Exception("unknown user");
			if (empty($password))
				throw new Exception("no password given");
				
			if (!LDAP_login($dn, $password))
				throw new Exception("wrong password");
			
			logLoginAttempt($username, true);
		} catch (Exception $e) {
			logLoginAttempt($username, false);
			throw $e;
		}
		
		$_SESSION['class'] = getClass($ent);
		$_SESSION['isTeacher'] = isTeacher($ent);
		
		$_SESSION['loggedIn'] = time();
		$_SESSION['name'] = getFullName($ent);
		if ($_SESSION['isTeacher'])
			$_SESSION['id'] = getInitials($ent);
		else
			$_SESSION['id'] = $username;
		$_SESSION['section'] = getSection($ent);
		$_SESSION['rights'] = getRights($ent);
		
		generateLog();
	}

	function logout() {
		$_SESSION['loggedIn'] = false;
		$_SESSION['rights']['N'] = false;
		$_SESSION['rights']['W'] = false;
		$_SESSION['rights']['M'] = false;
		$_SESSION['rights']['E'] = false;
		$_SESSION['rights']['root'] = false;
		$_SESSION['rights']['news'] = false;
	}
?>
