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

	if (file_exists(ROOT_LOCATION . "/tmp/reload.ex")) {
	 	$response = array();
	 	$response['script'] = "window.setTimeout(function() { location.href = location.href; }, 1000);";
	 	$response['hash'] = rand();
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
	$response['modus'] = "";
	
	$response['changes'] = true;

	if ($monitor->type == "Supplierplan & News") {
		if (!isset($_GET['submode']) || ($_GET['submode'] == "0")) {
			$monitor->type = "Supplierplan";
			$response['submode'] = 0;
		} else {
			$monitor->type = "News";
			$response['submode'] = 1;
		}
		if (!isset($_GET['submodeChange'])) {
			$response['submodeChange'] = time();
		} else {
			if (intval($_GET['submodeChange']) > time() - 5) {
				$response['submodeChange'] = time();
				$response['submode'] = !$response['submode'];
			}
		}
	}

	// Seitentyp-Switch
	switch($monitor->type) {
	case "News":
		$response['modus'] = "News";
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
	//Supplierplan wegen Entwicklung hier	
	/*	$response['modus'] = "Supplierplan";
		$response['content'] = "Wegen eines Tests des Supplierplans wird hier nicht der Stundenplan angezeigt";
		$sql = "SELECT 
		`su`.`short` AS suShort,
		`c`.`name` AS className,
		`s`.`time`,
		`s`.`comment`,
 		`sH`.`hour` AS `startHour`,
 		`nsH`.`hour` AS `newStartHour`
		FROM `substitudes` AS `s`
		INNER JOIN `subjects` AS `su` ON `s`.`subjectFK` = `su`.`ID`
		INNER JOIN `lessons` AS `l` ON `s`.`lessonFK` = `l`.`ID`
		INNER JOIN `lessonsBase` AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
		INNER JOIN `classes` AS `c` ON `lb`.`classFK` = `c`.`ID`
		INNER JOIN `hours` AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
		INNER JOIN `hours` AS `nsH` ON `s`.`startHourFK` = `nsH`.`ID` 
		WHERE `s`.`time` >= '" . date("Y.m.d")."'";
		$result = mysql_query($sql);
		//Fehler bei LEFT JOIN `hours` AS `nsH` ON `s`.`startHourFK` = `nsH`.`ID`
		while ($row = mysql_fetch_object($result)) {
			$results[] = $row;
		}		
		for($j = 0; $j<3;$j++){
			$response['content'] .= "<div id='t".$j."'>";
			$response['content'] .= "Supplierungen vom ". date("d.M",time() + 24*60*60*$j);
			$response['content'] .= "<table>"; 
			$response['content'] .= "<tr><th>Klasse</th><th>Stunde</th><th>Fach</th><th>Kommentar</th></tr>";
			if(isset($results)){
				for ($i = 0; $i<count($results);$i++){
				 	$response['content'] .= "<tr>";
					$response['content'] .= "<td> ". $results[$i]->className ."</td>";
					if(empty($results[$i]->newStartHour)){ $response['content'] .= "<td> ". $results[$i]->startHour ."</td>";}
					else {$response['content'] .= "<td> ". $results[$i]->newStartHour ."</td>";}
					$response['content'] .= "<td> ". $results[$i]->suShort ."</td>";
					$response['content'] .= "<td> ". $results[$i]->comment ."</td>";
					$response['content'] .= "</tr>";
				}
			}
			$response['content'] .= "</table></div>";
		}	
		$hash .= md5($response['content']);
		break; */
		
		
		$response['modus'] = "Stundenplan";
		$sql = "SELECT 
		`su`.`short` AS `suShort`,
		`sH`.`weekdayShort` AS `weekday`,
		`sH`.`hour` AS `startHour`,
		`eH`.`hour` AS `endHour`,
		`t`.`short` AS `teShort`,
		`c`.`name` AS `className`
		FROM `lessons` AS `l`
		INNER JOIN `rooms` AS `r` ON `l`.`roomFK`=`r`.`ID`
		INNER JOIN `subjects` AS `su` ON `l`.`subjectFK` = `su`.`ID`
		INNER JOIN `lessonsBase` AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
		INNER JOIN `hours` AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
		INNER JOIN `hours` AS `eH` ON `lb`.`endHourFK` = `eH`.`ID`
		INNER JOIN `teachers` AS `t` ON `l`.`teachersFK` = `t`.`ID`
		INNER JOIN `classes` AS `c` ON `lb`.`classFK` = `c`.`ID`
		WHERE `r`.`name` = '". $monitor->room."'";
		$result = mysql_query($sql);
		$response['content'] .= "<table border=1 class = \"timetable\">";
		$response['content'] .= "<tr><th>" . "Stunde" . "</th>";
		$response['content'] .= "<th colspan =2>" . "Montag" . "</th>";
		$response['content'] .= "<th colspan =2>" . "Dienstag" . "</th>";
		$response['content'] .= "<th colspan =2>" . "Mittwoch" . "</th>";
		$response['content'] .= "<th colspan =2>" . "Donnerstag" . "</th>";
		$response['content'] .= "<th colspan =2>" . "Freitag" . "</th></tr>";
		while ($row = mysql_fetch_object($result)) {
				$results[] = $row;
		}
		$lesson = array();
		for($i=0;$i<count($results);$i++){
		 $index = $results[$i]->startHour;
		 $day = $results[$i]->weekday;
		 $lesson[$index][$day] =  array('suShort'=> $results[$i]->suShort,'endHour'=> $results[$i]->endHour,'startHour'=> $index,'teShort'=> $results[$i]->teShort,'className'=> $results[$i]->className);
			
		}
		
		$days=array(0=> "Mo",1=> "Di",2=> "Mi",3=>"Do",4=>"Fr");
		for($i = 1; $i<12 ;$i++){
		 	$response['content'] .= "<tr><td>".$i."</td>";
			for($j=0;$j<5;$j++){
			 if(isset($lesson[$i][$days[$j]])){
				$response['content'] .= "<td>". $lesson[$i][$days[$j]]['suShort'] ."</td>";	
				$response['content'] .= "<td>". $lesson[$i][$days[$j]]['className'] ."</td>";
				if($lesson[$i][$days[$j]]['endHour']> $i){
				   $lesson[$i+1][$days[$j]] = $lesson[$i][$days[$j]];
				}
				
			 }
			else $response['content'] .= "<td> &#160; </td><td> &#160; </td>";
			}
			$response['content'] .= "</tr>";
		}
	
		$response['content'] .= "</table>";
		
		
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
		
		/*$response['content'] .= "<div class='keys'>";
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
		$response['content'] .= "</table>";*/
	
		$response['script'] = 'window.setTimeout(function() {window.location.href="http://web.htlinn.ac.at/~suppla/ftklschnitzel/www/supplierplan.php"; }, 100)';
		
		$hash .= rand();
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
