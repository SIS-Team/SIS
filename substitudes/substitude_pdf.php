<?php
include_once("../config.php");	 
require_once(ROOT_LOCATION . "/modules/external/fpdf/fpdf.php");
include_once(ROOT_LOCATION . "/modules/general/Connect.php");			
include_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");	

ifNotLoggedInGotoLogin();	

$permission = getPermission();
if($permission != "root" && $permission != "admin") noPermission();
if(isset($_GET['date']) && check_date($_GET['date']))$date = $_GET['date'];
else $date = date("Y-m-d");
$sql = "SELECT 
`su`.`short` AS suShort,
`c`.`name` AS className,
`s`.`time`,
`s`.`comment`,
`sH`.`hour` AS `startHour`,
`nsH`.`hour` AS `newStartHour`,
`t`.`display` AS `newTeacher`,
`se`.`short` AS `section`
FROM `substitudes` AS `s`
INNER JOIN `subjects` AS `su` ON `s`.`subjectFK` = `su`.`ID`
INNER JOIN `lessons` AS `l` ON `s`.`lessonFK` = `l`.`ID`
INNER JOIN `lessonsBase` AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
INNER JOIN `classes` AS `c` ON `lb`.`classFK` = `c`.`ID`
INNER JOIN `hours` AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
LEFT JOIN `hours` AS `nsH` ON `s`.`startHourFK` = `nsH`.`ID`
LEFT JOIN `teachers` AS `t` ON `s`.`teacherFK` = `t`.`ID`
INNER JOIN `sections` AS `se` ON `c`.`sectionFK` = `se`.`ID`
WHERE `se`.`short` = '".mysql_real_escape_string($_SESSION['section'])."' AND `time` = '".mysql_real_escape_string($date)."'
ORDER BY `startHour`";
$result = mysql_query($sql);
echo mysql_error();
	while($substitude = mysql_fetch_object($result)) {    
 	$substitudes[]=$substitude;
	}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','UI',20);
$pdf->Cell('75','25','HTL Anichstraße');
$pdf->Cell('75','25',$date);
$pdf->Cell('','25','Abteilung '.$_SESSION['section'],'','1');
$pdf->SetFont('Arial','',12);
$pdf->Cell(15,10,'Stunde','1');
$pdf->Cell(40,10,'Klasse','1');
$pdf->Cell(40,10,'Suppl. durch','1');
$pdf->Cell(40,10,'Fach','1');
$pdf->Cell(40,10,'Bemerkung','1','1');
$count = 0;
if(isset($substitudes)){
	for($i = 0;$i<count($substitudes);$i++){
		$pdf->Cell(15,10,$substitudes[$i]->startHour,'1');
		$pdf->Cell(40,10,$substitudes[$i]->className,'1');
		$pdf->Cell(40,10,$substitudes[$i]->newTeacher,'1');
		$pdf->Cell(40,10,$substitudes[$i]->suShort,'1');
		$pdf->Cell(40,10,$substitudes[$i]->comment,'1','1');
		$count++;
	}
}
while($count<12){
 		$pdf->Cell(15,10,'','1');
		$pdf->Cell(40,10,'','1');
		$pdf->Cell(40,10,'','1');
		$pdf->Cell(40,10,'','1');
		$pdf->Cell(40,10,'','1','1');
		$count++;
 }
$pdf->Output();

function check_date($date)
{
	$date_parts = array();
 	$date_parts =  explode('-',$date,3);
	return checkdate($date_parts[1],$date_parts[2],$date_parts[0]);
}


?>