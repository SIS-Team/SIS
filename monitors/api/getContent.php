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
	$response['content'] = "<a id=\"top\" name=\"top\"></a>";
	$response['media'] = array();
	$response['modus'] = "";
	
	$response['changes'] = true;

	$response['req'] = $_GET;
	
	if ($monitor->type == "Supplierplan & News") {
		if (!isset($_GET['submode']) || ($_GET['submode'] == "0")) {
			$monitor->type = "Supplierplan";
			$_GET['submode'] = 0;
			$response['submode'] = 0;
		} else {
			$monitor->type = "News";
			$response['submode'] = 1;
		}

		if (!isset($_GET['submodeChange'])) {
			$_GET['submodeChange'] = time() + 20;
		}
		
		if (intval($_GET['submodeChange']) <= time()) {
			$response['submode'] = (intval($_GET['submode']) + 1) % 2;
			
			if ($response['submode'] == 0)
				$response['submodeChange'] = time() + 20;
			else
				$response['submodeChange'] = time() + 10;
		} else {
			$response['submodeChange'] = $_GET['submodeChange'];
		}
	}

	// Seitentyp-Switch
	switch($monitor->type) {
	case "News":
		$response['modus'] = "News";
		$today = date("Y-m-d");
		$sql = "SELECT * FROM `news` 
		LEFT JOIN `sections` AS `se` ON `news`.`sectionFK` = `se`.`ID`
		WHERE `startDay` <= '" . $today . "' AND `endDay` >= '" . $today . "' AND `display` = 1 AND (`se`.`name` = '".$monitor->section."' OR `news`.`sectionFK` = '0')";
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

		//Version 2 
		$response['modus'] = "Supplierplan";
		$sql = "SELECT `time`,
						`newSub`,
						`remove`,
						`move`,
						`s`.`display`,
						`s`.`comment`,
						IFNULL(`nC`.`name`,`c`.`name`) AS `className`,
						`nT`.`display` AS `teacher`,
						IFNULL(`nSu`.`short`,`su`.`short`) AS `suShort`,
						IFNULL(`nR`.`name`,`r`.`name`) AS `room`,
						IFNULL(`nsH`.`hour`,`sH`.`hour`) AS `startHour`,
						IFNULL(`neH`.`hour`,`eH`.`hour`) AS `endHour`
			FROM `substitudes` AS `s`		
				LEFT JOIN `lessons` AS `l` ON `s`.`lessonFK` = `l`.`ID` 
				LEFT JOIN `lessonsBase` AS `lb`ON `l`.`lessonBaseFK` = `lb`.`ID`
				LEFT JOIN `classes`AS `c` ON `lb`.`classFK` = `c`.`ID`
				LEFT JOIN `hours` AS `sH` ON `lb`.`startHourFK` = `sH`.`ID` 
				LEFT JOIN `hours` AS `eH` ON `lb`.`endHourFK` = `eH`.`ID` 
				LEFT JOIN `teachers` AS `t`ON `l`.`teachersFK` = `t`.`ID`
				LEFT JOIN `subjects` AS `su` ON `l`.`subjectFK`=`su`.`ID`
				LEFT JOIN `rooms` AS `r` ON `l`.`roomFK` = `r`.`ID`
				LEFT JOIN `hours` AS  `nsH` ON `s`.`startHourFK` = `nsH`.`ID`
				LEFT JOIN `hours` AS  `neH` ON `s`.`endHourFK` = `neH`.`ID`
				LEFT JOIN `teachers` AS `nT` ON `s`.`teacherFK` = `nT`.`ID`
				LEFT JOIN `subjects` AS `nSu` ON `s`.`subjectFK` = `nSu`.`ID`
				LEFT JOIN `rooms`AS `nR` ON `s`.`roomFK` = `nR`.`ID`
				LEFT JOIN `classes` AS `nC` ON `s`.`classFK` = `nC`.`ID`
				LEFT JOIN `sections` AS `sec` ON `c`.`sectionFK` = `sec`.`ID`
				LEFT JOIN `sections` AS `nSec` ON `nC`.`sectionFK`=`nSec`.`ID`
			WHERE time >= '". date("Y-m-d") . "' and (`sec`.`name` = '".$monitor->section."' or `nSec`.`name` = '".$monitor->section."')
			ORDER BY `className`, `startHour`		
		";
		//$response['content'] .= $sql;
		$result = mysql_query($sql);
		$response['content'] .= mysql_error();
		while ($row = mysql_fetch_array($result)) {
			$results[] = $row;
		}
	$day = array(1=>'MO', 2=>'DI' , 3=> 'MI', 4=>'D0', 5 =>'FR');
		$day_counter = 0;
		for($j = 0; $j<2;$j++){
 			$upperClass = 0;
		 	if(date("w", time() + 24 * 60 * 60 * $day_counter)==0) $day_counter++;
			if(date("w", time() + 24 * 60 * 60 * $day_counter)==6) $day_counter+=2;
			$response['content'] .= "<div id='t".$j."'>";
			$response['content'] .= $day[ date("N",time() + 24*60*60*$day_counter)] ." ". date("d.m.y",time() + 24*60*60*$day_counter);
			$response['content'] .= "<table class = 'substitude'>"; 
			$response['content'] .= "<tr><th>Klasse</th><th>Std.</th><th>Suppl. durch</th><th>Fach</th><th>Bemerkung</th></tr>								";
			if(isset($results)){
				for($i = 0; $i <count($results);$i++){
 					if($results[$i]['time'] >= date("Y-m-d", time()+ 24 *60 *60 * $day_counter)  and $results[$i]['time'] < date("Y-m-d", time()+ 24 *60 *60 * ($day_counter+1)) and $results[$i]['display'] == 1){
							
			 				$response['content'] .= "<tr>";
							if($results[$i]['className'] != $upperClass) {
 								$response['content'] .= "<td>".$results[$i]['className']."</td>";						 	 
								$upperClass = $results[$i]['className'];
							}
							else $response['content'] .= "<td style=\"border : 0px\"></td>";
							if($results[$i]['startHour'] == $results[$i]['endHour'] ){
 								$response['content'] .= "<td>".$results[$i]['startHour']."</td>";	
							}
							else $response['content'] .= "<td>".$results[$i]['startHour'] ." - ".$results[$i]['endHour']."</td>";
							$response['content'] .= "<td>".$results[$i]['teacher']."</td>";	
							$response['content'] .= "<td>".$results[$i]['suShort']."</td>";	
							$response['content'] .= "<td>".$results[$i]['comment']."</td>";						
							$response['content'] .= "</tr>";
						
				}
			
				}
			}
			else {
 			$response['content'] .= "<tr><th colspan = 5>F&uuml;r diesen Tag sind keine Supplierungen vorgesehen.</th></tr>";
			}

			$response['content'] .= "</table></div>";
			$day_counter++;
		}
		$hash .= md5($response['content']);
		break;
		//Version 1	
	/*	$response['modus'] = "Supplierplan";
		$sql = "SELECT 
		`su`.`short` AS `suShort`,
		`c`.`name` AS `className`,
		`s`.`time`,
		`s`.`comment`,
 		`sH`.`hour` AS `startHour`,
 		`eH`.`hour` AS `endHour`,
 		`nsH`.`hour` AS `newStartHour`,
		`neH`.`hour` AS `newEndHour`,
 		`t`.`display` AS `newTeacher`,
 		`se`.`name` AS `section`
		FROM `substitudes` AS `s`
		INNER JOIN `subjects` AS `su` ON `s`.`subjectFK` = `su`.`ID`
		INNER JOIN `lessons` AS `l` ON `s`.`lessonFK` = `l`.`ID`
		INNER JOIN `lessonsBase` AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
		INNER JOIN `classes` AS `c` ON `lb`.`classFK` = `c`.`ID`
		INNER JOIN `hours` AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
		INNER JOIN `hours` AS `eH` ON `lb`.`endHourFK` = `eH`.`ID`
		LEFT JOIN `hours` AS `nsH` ON `s`.`startHourFK` = `nsH`.`ID`
		LEFT JOIN `hours` AS `neH` ON `s`.`endHourFK` = `neH`.`ID`
		LEFT JOIN `teachers` AS `t` ON `s`.`teacherFK` = `t`.`ID`
		INNER JOIN `sections` AS `se` ON `c`.`sectionFK` = `se`.`ID`
		WHERE `s`.`time` >= '" . date("Y.m.d")."' AND `se`.`name` = '".$monitor->section."'
		ORDER BY `className`, `startHour`";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_object($result)) {
			$results[] = $row;
		}	
		$day_counter = 0;
		for($j = 0; $j<2;$j++){
		 	if(date("w", time() + 24 * 60 * 60 * $day_counter)==0) $day_counter++;
			if(date("w", time() + 24 * 60 * 60 * $day_counter)==6) $day_counter+=2;
			$response['content'] .= "<div id='t".$j."'>";
			$response['content'] .= "Supplierungen vom ". date("d.M",time() + 24*60*60*$day_counter);
			$response['content'] .= "<table class = 'substitude'>"; 
			$response['content'] .= "<tr><th>Klasse</th><th>Std.</th><th>Suppl. durch</th><th>Fach</th><th>Bemerkung</th></tr>";
			$empty = 0;
			if(isset($results)){
 				$className =0;
				for ($i = 0; $i<count($results);$i++){ 
				 	if($results[$i]->time == date("Y-m-d",time() + 24 * 60 * 60 * $day_counter)) {
	 					if(empty($results[$i]->newStartHour)){ $lesson_count = $results[$i]->startHour;}
						else $lesson_count = $results[$i]->newStartHour;
						if(empty($results[$i]->newEndHour)){ $lesson_end = $results[$i]->endHour;}
						else $lesson_end = $results[$i]->newEndHour;
						$difference = $lesson_end - $lesson_count +1 ;
						
						
						while($lesson_count <= $lesson_end){
 							$response['content'] .= "<tr>";
							if($className != $results[$i]->className) {
 								$className = $results[$i]->className;
								$response['content'] .= "<td>".$className."</td>";
							}
							else $response['content'] .= "<td class ='sub_empty'></td>";
							$response['content'] .= "<td> ". $lesson_count."</td>"; 
							if(!empty($results[$i]->newTeacher)){ $response['content'] .= "<td> ". $results[$i]->newTeacher ."</td>";}
							else {$response['content'] .= "<td> &#160;</td>";}
							$response['content'] .= "<td> ". $results[$i]->suShort ."</td>";
							if(!empty($results[$i]->comment)){ $response['content'] .= "<td> ". $results[$i]->comment ."</td>";}
							else {$response['content'] .= "<td> &#160;</td>";}
							$response['content'] .= "</tr>"; 
							$lesson_count++;
						}
					}
					else $empty++;
					
				}
				if($empty == count($results)) $response['content'] .= "<tr><th colspan = 5>F&uuml;r diesen Tag sind keine Supplierungen vorgesehen.</th></tr>" ;
			
			} 
			else $response['content'] .= "<tr><th colspan = 5>F&uuml;r diesen Tag sind keine Supplierungen vorgesehen.</th></tr>";
			$response['content'] .= "</table></div>";
		$day_counter++;
		}	
		
		$hash .= md5($response['content']);
		break;  */
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

	case "fallback":
				$response['script'] = 'window.setTimeout(function() {window.location.href="http://web.htlinn.ac.at/~suppla/ftklschnitzel/www/supplierplan.php"; }, 100)';
		
		$hash .= rand();
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
	
	$response['content'] .= "<a id=\"bottom\" name=\"bottom\"></a>";
	
	// Ergebnis JSON codieren und zurückgeben
	echo json_encode($response);

?>
