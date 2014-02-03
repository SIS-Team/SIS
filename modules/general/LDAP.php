<?php
	/* /modules/general/LDAP.php
	 * Autor: Buchberger Florian
         * Version: 0.1.0
         * Beschreibung:
         *      Managed LDAP - Verbindungen
         *
         * Changelog:
         *      0.1.0:  15. 10. 2013, Buchberger Florian - erste Version
         */
	

	function LDAP_getDN($ent) {
		$dn = $ent[0]["dn"];
		if ($dn == "") {
			return false;
		}
		return $dn;
	}

	function LDAP_login($dn, $pass) {
		include_once(ROOT_LOCATION . "/modules/general/LDAPpassword.php");
		if (!isset($host)) {
			return ($dn == "test") && ($pass == "sister");
		}
		$con = ldap_connect($host);
		$ok  = ldap_bind($con, $dn, $pass);
		return $ok;
	}

	function LDAP_getUser($cn) {
		include_once(ROOT_LOCATION . "/modules/general/LDAPpassword.php");

		if (!isset($host)) {
			$ent = array();
			$ent[0] = array();
			$ent[0]["dn"] = "cn=123345678,ou=STUDENTS,o=HTLinn";
			$ent[0]["groupmembership"] = array();
			$ent[0]["groupmembership"][0] = "cn=5YHELT,ou=GROUPS,ou=PUBLIC,o=HTLinn";
			$ent[0]["ou"] = array();
			$ent[0]["ou"][0] = "N";
			$ent[0]["givenname"] = array();
			$ent[0]["givenname"][0] = "Sister";
			$ent[0]["sn"] = array();
			$ent[0]["sn"][0] = "Anich";
			$ent[0]["initials"] = array();
			$ent[0]["initials"][0] = "SA";
			return $ent;
		}
		$con = ldap_connect($host);
		$ok  = ldap_bind($con, $user, $passwd);
		$res = ldap_search($con, "o=HTLinn", "cn=" . $cn);
		$ent = ldap_get_entries($con, $res);	
	
		if (!isset($ent[0])) {
			return false;
		}
		
		ldap_unbind($con);
		return $ent;
	}
	
	function getRights($ent) {
		$rightArray = array();
		$rightArray["news"] = false;
		$rightArray["root"] = false;
		$rightArray["N"] = false;
		$rightArray["W"] = false;
		$rightArray["E"] = false;
		$rightArray["M"] = false;
		$groups = $ent[0]["groupmembership"];
		for ($i = 0; $i < count($groups); $i++) {
			$split = split(",", $groups[$i]);
			if (!($split[2] == "o=HTL1" && $split[1] == "ou=SIS"))
				continue;
			$split = split("=", $split[0]);
			$split = split("-", $split[1]);
			if ($split[0] != "SIS")
				continue;
			if ($split[1] == "Admin") {
				$rightArray[$split[2]] = true;
			}
			if ($split[1] == "SuperUser") {
				$rightArray["root"] = true;
			}
			if ($split[1] == "News") {
				$rightArray["news"] = true;
			}
		}
		return $rightArray;
	}

	function isTeacher($ent) {
		$dn = $ent[0]["dn"];
		$isTeacher = split(",", $dn);
		$isTeacher = $isTeacher[1];
		$isTeacher = split("=", $isTeacher);
		$isTeacher = $isTeacher[1];
		return ($isTeacher == "LEHRER");
	}

	function getClass($ent) {
		$group = $ent[0]["groupmembership"];
		$i = 0;
		for (; $i < count($group); $i++) {
			$path = split(",", $group[$i]);
			if ($path[1] == "ou=GROUPS" && $path[2] == "ou=PUBLIC" && $path[3] == "o=HTLinn" && strlen($path[0]) > 3)
				break;
		}
		$group = $group[$i];
		$group = split(",", $group);
		$group = split("=", $group[0]);
		return $group[1];
	}

	function getSection($ent) {
		return $ent[0]["ou"][0];
	}

	function getFullName($ent) {
		$fn =  $ent[0]["givenname"][0];
		$array = explode(" ", $fn);
		return $array[0] . " " . $ent[0]["sn"][0];
	}
	
	function getInitials($ent) {
		return $ent[0]["initials"][0];
	}	
?>
