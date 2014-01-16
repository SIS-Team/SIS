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

	include("../../config.php");	
	include(ROOT_LOCATION . "/modules/monitors/Main.php");

	// Wenn Monitor nicht gefunden -> Fehlermeldung ausgeben
	$monitor = getMonitorByName($_GET['name']);
	if (!$monitor) {
		$response = array();
		$response['error'] = "Monitor nicht gefunden.<br />Klicken Sie <a href=\"?register&name=" . $_GET['name'] . "\">hier</a> um den Monitor zu registrieren oder warten Sie 10 Sekunden.";
 		$response['script'] = "window.setTimeout(function() { location.href = '?register&name=" . $_GET['name'] . "'; }, 10 * 1000);";
		echo json_encode($response);
		die();
	}

	// Hash generieren
	$hash = md5($monitor->type . $monitor->text);

	$response = array();
	$response['error'] = "";
	$response['success'] = true;
	$response['content'] = "";
	$response['media'] = array();
	
	$response['changes'] = true;
	
	// Seitentyp-Switch
	switch($monitor->type) {
	case "News":
		$today = date("Y-m-d");
		$sql = "SELECT * FROM `news` WHERE `startDay` <= '" . $today . "' AND `endDay` >= '" . $today . "' AND `display` = 1";
		$result = mysql_query($sql);
		$response['content'] .= "<table class=\"news\">";
		while ($row = mysql_fetch_object($result)) {
			$response['content'] .= "<tr><th>" . $row->title . "</th></tr>";
			$response['content'] .= "<tr><td>" . $row->text  . "</td></tr>";
		}
		$response['content'] .= "</table>";
		$hash .= md5($response['content']); // ugly
		break;
	case "Stundenplan":
		$hash .= md5($monitor->room);
		break;
	case "Supplierplan":
		$sql = "SELECT 
				`hb`.`weekdayShort` AS startWeekDay, 
				`hb`.`hour` AS `startHour`,
				`he`.`weekdayShort` AS endWeekDay,
				`he`.`hour` AS `endHour`,
				`c`.`name` AS `className`,
				`su`.`short` AS `subject`,
				`t`.`display` AS `teacher`,
				`s`.`time` AS `time`,
				`s`.`comment` AS `comment`
			FROM `substitudes` AS `s` 
			INNER JOIN `lessons` AS `l` ON `s`.`lessonFK`=`l`.`ID` 
			INNER JOIN `subjects` AS `su` ON `s`.`subjectFK`=`su`.`ID`
			INNER JOIN `teachers` AS `t` ON `s`.`teacherFK`=`t`.`ID`
			INNER JOIN `rooms` AS `r` ON `s`.`roomFK`=`r`.`ID`
			INNER JOIN `hours` AS `hb` ON `s`.`startHourFK`=`hb`.`ID`
			INNER JOIN `hours` AS `he` ON `s`.`endHourFK`=`he`.`ID`
			INNER JOIN `lessonsBase` AS `lb` ON `l`.`lessonBaseFK`=`lb`.`ID`
			INNER JOIN `classes` AS `c` ON `lb`.`classFK`=`c`.`ID`
			INNER JOIN `sections` AS `se` ON `c`.`sectionFK`=`se`.`ID`
			
			WHERE `se`.`name`='" . $monitor->section . "'
			AND `s`.`time`>='" . date("Y-m-d") . "'
			AND `s`.`time`<'" . date("Y-m-d", time() +  60 * 60 * 24) . "'
			AND `s`.`display`=1";
		
		// echo $sql;
		
		$response['content'] .= "<div class='keys'>";
		$response['content'] .= "St. ... supplierte Stunde; ";
		$response['content'] .= "Sup. ...Supplierlehrer; ";
		$response['content'] .= "urs. ... ursprünglicher Lehrer; ";
		$response['content'] .= "</div>";
		
		$response['content'] .= "<table>";
		$response['content'] .= "	<tr>";
		for ($i = 0; $i < 2; $i++) {
			$response['content'] .= "<td>";
			$response['content'] .= "</td>";
		}
		$response['content'] .= "	</tr>";
		$response['content'] .= "</table>";
		
		$hash .= md5($response['content']);
		break;
	case "Bild":
		$hash .= md5($monitor->file);
		$response['content'] = "<img src=\"&media:img;\" />";
		$response['media']['img'] = $monitor->file;
		break;
	case "Video":
		$hash .= md5($monitor->file);
		$response['content'] = "<video autoplay=\"autoplay\" loop=\"true\"><source src=\"&media:vid;\" type=\"video/mp4\" /></video>";
		$response['media']['vid'] = $monitor->file;
		break;
	}
	
	if ($hash == $_GET['hash']) {
		$response['changes'] = false;
		$response['content'] = "";
		$response['media'] = "";
	} else {
		$response['info'] = $monitor->text;
	}
	
	$response['hash'] = $hash;


	// Ergebnis JSON codieren und zurückgeben
	echo json_encode($response);

?>
