<?php
	/* /monitors/api/register.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Stellt Registrierung der Montore zur Verfügung
	 *
	 * Changelog:
	 * 	0.1.0:  24. 08. 2013, Buchberger Florian - erste Version
	 */
		
	include("../../modules/general/Main.php");
	include("../../modules/monitors/CheckIP.php");
	if (!isset($_GET['name']) || empty($_GET['name'])) {
		$response = array();
		$response['error'] = "Name not given";
		echo json_encode($response);
		exit();
	}

	$name = mysql_real_escape_string($_GET['name']);
	$sql = "INSERT IGNORE INTO `monitors` SET `name`='" . $name . "', `modeFK`=1, `file`='', `roomFK`=1";
	$result = mysql_query($sql);

	$response = array();
	$response['error'] = "";
	$response['success'] = true;
	echo json_encode($response);
?>
