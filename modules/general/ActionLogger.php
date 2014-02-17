<?php
	/* /modules/general/ActionLogger.php
	 * Autor: Edward Snowden
	 * Version: 0.1.0
	 * Beschreibung:
	 *	NSA Muahahahahaha...
	 */
	 
	if ($_SESSION['loggedIn'])
		generateLog();
		
	function generateLog () {
		$id = $_SESSION['id'];
		$isTeacher = $_SESSION['isTeacher'];
		if ($isTeacher)
			$isTeacher = 1;
		else
			$isTeacher = 0;
			
		$class = $_SESSION['class'];
		$section = $_SESSION['section'];
		if ($isTeacher) {
			$class = 0;
			$section = 0;
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$site = $_SERVER['REQUEST_URI'];
		$site = explode("?", $site);
		$params = isset($site[1]) ? $site[1] : "";
		$site = $site[0];
		$phpsessid = session_id();
		$phpsessidorg = $_SESSION['originalID'];
		$creatingTime = $_SESSION['time'];
		$loggedInTime = $_SESSION['loggedIn'];
		
		$sql = "SELECT ID FROM logsSessions WHERE PhpSessIDOrig='" . 
			mysql_real_escape_string(htmlspecialchars($phpsessidorg)) . "' AND userAgent='" . 
			mysql_real_escape_string(htmlspecialchars($userAgent)) . "' AND `time`=" .
			$creatingTime;
		$result = mysql_query($sql);
		if (!mysql_num_rows($result)) {
			$sql = "INSERT INTO logsSessions (userAgent, PhpSessIDOrig, `time`) VALUES ('" . 
				mysql_real_escape_string(htmlspecialchars($userAgent)) . "', '" .
				mysql_real_escape_string(htmlspecialchars($phpsessidorg)) . "', " .
				$creatingTime . ")";
			$result = mysql_query($sql);
			$sql = "SELECT ID FROM logsSessions WHERE PhpSessIDOrig='" . 
				mysql_real_escape_string(htmlspecialchars($phpsessidorg)) . "' AND userAgent='" . 
				mysql_real_escape_string(htmlspecialchars($userAgent)) . "' AND `time`=" .
				$creatingTime;
			$result = mysql_query($sql);
		}
		$sessionId = mysql_fetch_object($result);
		$sessionId = $sessionId->ID;
		
		$sql = "UPDATE logsSessions SET PhpSessIDAct='" . 
			mysql_real_escape_string(htmlspecialchars($phpsessid)) . "' WHERE ID=" . 
			$sessionId;
		$result = mysql_query($sql);
		
		if (!$isTeacher) {
			$sql = "SELECT ID FROM classes WHERE `name`='" . 
				mysql_real_escape_string(htmlspecialchars($class)) . "'";
			$result = mysql_query($sql);
			$class = mysql_fetch_object($result);
			$class = $class->ID;
			
			$sql = "SELECT ID FROM sections WHERE `short`='" . 
				mysql_real_escape_string(htmlspecialchars($section)) . "'";
			$result = mysql_query($sql);
			$section = mysql_fetch_object($result);
			$section = $section->ID;
		}
		
		$sql = "SELECT ID 
			FROM logsUsers 
			WHERE LDAP='" . 
			mysql_real_escape_string(htmlspecialchars($id)) . "' AND classesFK=" .
			$class . " AND sectionsFK=" . $section;
		$result = mysql_query($sql);
		if (!mysql_num_rows($result)) {
			$sql = "INSERT INTO logsUsers (LDAP, classesFK, sectionsFK, isTeacher) VALUES ('" .
				mysql_real_escape_string(htmlspecialchars($id)) . "', " . $class . ", " . $section . ", " .
				$isTeacher . ")";
			$result = mysql_query($sql);
			$sql = "SELECT ID 
				FROM logsUsers 
				WHERE LDAP='" . 
				mysql_real_escape_string(htmlspecialchars($id)) . "' AND classesFK=" .
				$class . " AND sectionsFK=" . $section;
			$result = mysql_query($sql);
		}
		$userId = mysql_fetch_object($result);
		$userId = $userId->ID;
		
		$sql = "SELECT ID FROM logsUSConn WHERE `time`=" .
			$loggedInTime . " AND sessionFK=" . 
			$sessionId . " AND userFK=" .
			$userId . " AND `ip`='" .
			mysql_real_escape_string(htmlspecialchars($ip)) . "'";
		$result = mysql_query($sql);
		if (!mysql_num_rows($result)) {
			$sql = "INSERT INTO logsUSConn (`time`, sessionFK, userFK, `ip`) VALUES (" .
				$loggedInTime . ", " . 
				$sessionId . ", " .
				$userId . ", '" .
				mysql_real_escape_string(htmlspecialchars($ip)) . "')";
			$result = mysql_query($sql);
			$sql = "SELECT ID FROM logsUSConn WHERE `time`=" .
				$loggedInTime . " AND sessionFK=" . 
				$sessionId . " AND userFK=" .
				$userId . " AND `ip`='" .
				mysql_real_escape_string(htmlspecialchars($ip)) . "'";
			$result = mysql_query($sql);
		}
		$connectId = mysql_fetch_object($result);
		$connectId = $connectId->ID;
		
		// und zum Schluss: Logs eintragen
		
		$sql = "INSERT INTO logsMain (`time`, connFK, `site`, `params`) VALUES (" .
			time() . ", " .
			$connectId . ", '" .
			mysql_real_escape_string(htmlspecialchars($site)) . "', '" .
			mysql_real_escape_string(htmlspecialchars($params)) . "')";
		$result = mysql_query($sql);
	}
?>