<?php
	/* /monitors/api/getContent.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 * 	GET-Parameter name identifiziert den Monitor
	 *	gibt JSON-Objekt mit Texten und Links zu Medien (Bilder, Videos) zurück
	 *
	 * Changelog:
	 *	0.2.0: 20. 09. 2013, Buchberger Florian - Bilder und Videos funktionsfertig
	 * 	0.1.0: 09. 09. 2013, Buchberger Florian - erste Version
	 */
	
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/monitors/Main.php");

	// Wenn Monitor nicht gefunden -> Fehlermeldung ausgeben
	$monitor = getMonitorByName($_GET['name']);
	if (!$monitor) {
		$response = array();
		$response['error'] = "Monitor nicht gefunden.<br />Klicken Sie <a href=\"?register&name=" . $_GET['name'] . "\">hier</a> um den Monitor zu registrieren.";
		echo json_encode($response);
		die();
	}

	// Hash generieren
	$hash = md5($monitor->file) . md5($monitor->type) . md5($monitor->room);

	$response = array();
	$response['error'] = "";
	$response['success'] = true;
	$response['content'] = "";
	$response['media'] = array();

	// Wenn der Hash mit dem Client-Hash übereinstimmt -> keine Änderung
	if ($hash == $_GET['hash']) {
		$response['changes'] = false;
	} else {
		$response['changes'] = true;
		// neuen Hash mitgeben
		$response['hash'] = $hash;
	
		// Seitentyp-Switch
		switch($monitor->type) {
		case "News":
			$response['hash'] = 0;
			$today = date("Y-m-d");
			$sql = "SELECT * FROM `news` WHERE `startDay` <= '" . $today . "' AND `endDay` >= '" . $today . "' AND `display` = 1";
			$result = mysql_query($sql);
			$response['content'] .= "<table class=\"news\">";
			while ($row = mysql_fetch_object($result)) {
				$response['content'] .= "<tr><th>" . $row->title . "</th></tr>";
				$response['content'] .= "<tr><td>" . $row->text  . "</td></tr>";
			}
			$response['content'] .= "</table>";
			break;
		case "Stundenplan":
			break;
		case "Supplierplan":
			break;
		case "Bild":
			$response['content'] = "<img src=\"&media:img;\" />";
			$response['media']['img'] = $monitor->file;
			break;
		case "Video":
			$response['content'] = "<video autoplay=\"autoplay\" loop=\"true\"><source src=\"&media:vid;\" type=\"video/mp4\" /></video>";
			$response['media']['vid'] = $monitor->file;
			break;
		}
	}

	// Ergebnis JSON codieren und zurückgeben
	echo json_encode($response);

?>
