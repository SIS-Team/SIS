<?php
	/* /monitors/api/getContent.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 * 	GET-Parameter name identifiziert den Monitor
	 *	gibt JSON-Objekt mit Texten und Links zu Medien (Bilder, Videos) zur√ºck
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
		$sql = "SELECT 
		`su`.`short` AS `suShort`,
		`sH`.`weekdayShort` AS `weekday`,
		`sH`.`hour` AS `startHour`,
		`eH`.`hour` AS `endHour`
		FROM `lessons` AS `l`
		INNER JOIN `rooms` AS `r` ON `l`.`roomFK`=`r`.`ID`
		INNER JOIN `subjects` AS `su` ON `l`.`subjectFK` = `su`.`ID`
		INNER JOIN `lessonsBase` AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
		INNER JOIN `hours` AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
		INNER JOIN `hours` AS `eH` ON `lb`.`endHourFK` = `eH`.`ID`
		WHERE `r`.`name` = '". $monitor->room."'";
		$result = mysql_query($sql);
		$response['content'] .= "<table border=1 >";
		$response['content'] .= "<tr><th>" . "Stunde" . "</th>";
		$response['content'] .= "<th>" . "Montag" . "</th>";
		$response['content'] .= "<th>" . "Dienstag" . "</th>";
		$response['content'] .= "<th>" . "Mittwoch" . "</th>";
		$response['content'] .= "<th>" . "Donnerstag" . "</th>";
		$response['content'] .= "<th>" . "Freitag" . "</th></tr>";
		while ($row = mysql_fetch_object($result)) {
				$results[] = $row;
		}
		$lesson = array();
		for($i=0;$i<count($results);$i++){
			$lesson[$results[$i]->startHour][$results[$i]->weekday]=  $results[$i]->suShort;
			
		}
		
		$days=array(0=> "Mo",1=> "Di",2=> "Mi",3=>"Do",4=>"Fr");
		for($i = 1; $i<11 ;$i++){
		 	$response['content'] .= "<tr><td>".$i."</td>";
			for($j=0;$j<5;$j++){
			 if(isset($lesson[$i][$days[$j]])){
				$response['content'] .= "<td>". $lesson[$i][$days[$j]] ."</td>";	
			 }
			else $response['content'] .= "<td> &#160; </td>";
			}
			$response['content'] .= "</tr>";
		}
	
		$response['content'] .= "</table>";
//	for($i=0;$i =< 1 ;$i++) {$response['content'] .= "∞-∞";}
		$response['content'] .= "^-^";
		
		
		$hash .= md5($response['content']);
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
		$response['content'] .= "urs. ... urspr√ºnglicher Lehrer; ";
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


	// Ergebnis JSON codieren und zur√ºckgeben
	echo json_encode($response);

?>
