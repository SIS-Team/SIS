<?php
include_once("../../config.php");	 
require_once(ROOT_LOCATION . "/modules/external/fpdf/fpdf.php");
include_once(ROOT_LOCATION . "/modules/general/Connect.php");			
include_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");	

ifNotLoggedInGotoLogin();	

$permission = getPermission();
if($permission != "root" && $permission != "admin") noPermission();
if(isset($_GET['date']) && check_date($_GET['date']))$date = $_GET['date'];
else $date = date("Y-m-d");
if(isset($_GET['section'])) $section =$_GET['section'];
else $section = 'N';
		$sql = "SELECT `time`,
						`newSub`,
						`remove`,
						`move`,
						`s`.`comment`,
						IFNULL(`nC`.`name`,`c`.`name`) AS `className`,
						`nT`.`short` AS `newTeacher`,
						`t`.`short` AS `oldTeacher`,
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
				LEFT JOIN `rooms` AS `nR` ON `s`.`roomFK` = `nR`.`ID`
				LEFT JOIN `classes` AS `nC` ON `s`.`classFK` = `nC`.`ID`
				LEFT JOIN `sections` AS `sec` ON `c`.`sectionFK` = `sec`.`ID`
				LEFT JOIN `sections` AS `nSec` ON `nC`.`sectionFK`=`nSec`.`ID`
			WHERE time = '". mysql_real_escape_string($date) . "' and (`sec`.`short` = '".mysql_real_escape_string($section)."' or `nSec`.`short` = '".mysql_real_escape_string($section)."') 
			ORDER BY `className`, `startHour`		
		";
$result = mysql_query($sql);
while($substitude = mysql_fetch_object($result)) {    
 	$substitudes[]=$substitude;
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->AddFont('gothic');
$pdf->AddFont('gothic','B');
$pdf->SetFont('gothic','B',20);
$pdf->Cell('75','25','HTL Anichstraße');
$pdf->Cell('75','25',weekday($date).". ". $date);
$pdf->Cell('','25','Abteilung '.$section,'','1');
$pdf->SetFont('gothic','',12);
$pdf->Cell(30,10,'Klasse','1');
$pdf->Cell(16,10,'Stunde','1');
$pdf->Cell(15,10,'s.L.','1');
$pdf->Cell(15,10,'u.L.','1');
$pdf->Cell(30,10,'Fach','1');
$pdf->Cell(85,10,'Bemerkung','1','1');
$count = 0;
$oldClass = 0;
if(isset($substitudes)){
	for($i = 0;$i<count($substitudes);$i++){
	 	$start = $substitudes[$i]->startHour;
	    $end = $substitudes[$i]->endHour; 
			if($oldClass != $substitudes[$i]->className) {
 				$pdf->Cell(30,10,$substitudes[$i]->className,'RTL');
				$oldClass = $substitudes[$i]->className;
			}
			else $pdf->Cell(30,10,"",'RL');
			if($end != $start) $pdf->Cell(16,10,$start."-".$end,'1');
			else $pdf->Cell(16,10,$start,'1');
			$pdf->Cell(15,10,$substitudes[$i]->newTeacher,'1');
			$pdf->Cell(15,10,$substitudes[$i]->oldTeacher,'1');
			$pdf->Cell(30,10,$substitudes[$i]->suShort,'1');
			$pdf->Cell(85,10,utf8_decode($substitudes[$i]->comment),'1','1');
			$count++;
		
	}
}
$count2 = 0;
while($count<12 or $count2 <1){
 	$pdf->Cell(30,10,'','1');
	$pdf->Cell(16,10,'','1');
	$pdf->Cell(15,10,'','1');
	$pdf->Cell(15,10,'','1');
	$pdf->Cell(30,10,'','1');
	$pdf->Cell(85,10,'','1','1');
	$count++;
	$count2++;
 }
$pdf->Cell('',10,'s.L. ... supplierender Lehrer, u.L. ... ursprünglicher Lehrer');
$pdf->Output();

function check_date($date)
{
	$date_parts = array();
 	$date_parts =  explode('-',$date,3);
	return checkdate($date_parts[1],$date_parts[2],$date_parts[0]);
}


?>