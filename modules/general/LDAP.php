<?php
	/* /modules/general/LDAP.php
	 * Autor: Buchberger Florian
         * Beschreibung:
         *      Managed LDAP - Verbindungen
         */

	function LDAP_getDN($ent) {
		$dn = $ent[0]["dn"];
		if ($dn == "") {
			return false;
		}
		return $dn;
	}

	function LDAP_login($dn, $pass) {
		include(ROOT_LOCATION . "/modules/general/LDAPpassword.php");
		if (!isset($host)) {
			$fh = fopen(ROOT_LOCATION . "/logs/ldap-fails", "a");
			fwrite($fh, time() . ": no host, login, user: " . urlencode($dn) . "\n");
			fclose($fh);
			return ($dn == "cn=123345678,ou=STUDENTS,o=HTLinn") && ($pass == "sister");
		}
		$con = ldap_connect($host);
		$ok  = ldap_bind($con, $dn, $pass);
		ldap_unbind($con);
		return $ok;
	}

	function LDAP_getUser($cn) {
		include(ROOT_LOCATION . "/modules/general/LDAPpassword.php");

		if (!isset($host)) {
			$fh = fopen(ROOT_LOCATION . "/logs/ldap-fails", "a");
			fwrite($fh, time() . ": no host, get user, cn: " . urlencode($cn) . " ::::\n");
			fclose($fh);
			$ent = array();
			$ent[0] = array();
			$ent[0]["dn"] = "cn=123345678,ou=STUDENTS,o=HTLinn";
			$ent[0]["groupmembership"] = array();
			$ent[0]["groupmembership"][0] = "cn=5YHELT,ou=" . SECTION_N . ",ou=GROUPS,ou=PUBLIC,o=HTLinn";
			$ent[0]["ou"] = array();
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
		
		if (!($ok)) {
			$fh = fopen(ROOT_LOCATION . "/logs/ldap-fails", "a");
			fwrite($fh, time() . ": fatal bind: " . $user . " ::::\n");
			fwrite($fh, print_r($con, true));
			fwrite($fh, "- ::::");
			fclose($fh);
			die("Kritischer Fehler: Bitte melde diese Meldung an SIS-Team@htlinn.ac.at<br />Zusätzliche Informationen: fatal:bIn" . time() . "cffZcZ" . $con. "==");
		}
		
		$res = ldap_search($con, "o=SIS", "cn=" . $cn, 
			array("groupmembership", "ou", "givenname", "sn", "initials"), 0, 0, 0, LDAP_DEREF_ALWAYS);
		$ent = ldap_get_entries($con, $res);	
	
		ldap_unbind($con);
	
		if (!isset($ent[0])) {
			return false;
		}
		return $ent;
	}
	
	function getRights($ent) {
		$rightArray = array();
		$rightArray["news"] = false;
		$rightArray["root"] = false;
		$rightArray[SECTION_N] = false;
		$rightArray[SECTION_W] = false;
		$rightArray[SECTION_E] = false;
		$rightArray[SECTION_M] = false;
		$groups = $ent[0]["groupmembership"];
		for ($i = 0; $i < $groups['count']; $i++) {
			$split = split(",", $groups[$i]);
			if (!(isset($split[2]) && $split[2] == "o=HTL1" && $split[1] == "ou=SIS"))
				continue;
			$split = split("=", $split[0]);
			$split = split("-", $split[1]);
			if ($split[0] != "SIS")
				continue;
			if ($split[1] == "Admin") {
				if (strlen($split[2]) > 1)
					$rightArray[$split[2]] = true;
				else
					switch($split[2]) {
					case "W":
						$rightArray[SECTION_W] = true;
						break;
					case "N":
						$rightArray[SECTION_N] = true;
						break;
					case "E":
						$rightArray[SECTION_E] = true;
						break;
					case "M":
						$rightArray[SECTION_M] = true;
						break;
					default:
						break;
					}
			}
			if ($split[1] == "SuperUser") {
				$rightArray["root"] = true;
			}
			if ($split[1] == "News") {
				$rightArray["news"] = true;
			}
		}
		
		// Backdoor; REMOVE THIS AFTER BETA
		/*if (BETA) {
			$dn = $ent[0]['dn'];
			$dn = explode(",", $dn);
			$cn = $dn[0];
			$cn = explode("=", $cn);
			$cn = $cn[1];
			//         Buchberger           Handle               Klotz                Weiland              Machac
			if ($cn == "20090319" || $cn == "20090334" || $cn == "20090340" || $cn == "20090396" || $cn == "20090359")
				$rightArray['root'] = true;
		}*/
		return $rightArray;
	}

	function isTeacher($ent) {
		$dn = $ent[0]["dn"];
		$isTeacher = explode(",", $dn);
		$isTeacher = $isTeacher[1];
		$isTeacher = explode("=", $isTeacher);
		$isTeacher = $isTeacher[1];
		return ($isTeacher == "LEHRER");
	}

	function getClass($ent) {
		$group = $ent[0]["groupmembership"];
		$i = 0;
		for (; $i < count($group); $i++) {
			$path = explode(",", $group[$i]);
			if ($path[2] == "ou=GROUPS" && $path[3] == "ou=PUBLIC" && $path[4] == "o=HTLinn" && strlen($path[0]) > 3)
				break;
		}
		$group = $group[$i];
		$group = explode(",", $group);
		$group = explode("=", $group[0]);
		return $group[1];
	}

	function getSection($ent) {
		$group = $ent[0]["groupmembership"];
		$i = 0;
		for (; $i < count($group); $i++) {
			$path = explode(",", $group[$i]);
			if ($path[2] == "ou=GROUPS" && $path[3] == "ou=PUBLIC" && $path[4] == "o=HTLinn" && strlen($path[0]) > 3)
				break;
		}
		$group = $group[$i];
		$group = explode(",", $group);
		$group = explode("=", $group[1]);
		return $group[1];
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
