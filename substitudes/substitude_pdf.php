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

		$sql = "SELECT `time`,
						`newSub`,
						`remove`,
						`move`,
						`s`.`display`,
						`s`.`comment`,
						IFNULL(`nC`.`name`,`c`.`name`) AS `className`,
						IFNULL(`nT`.`display`,`t`.`display`) AS `teacher`,
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
			WHERE time = '". $date . "'
			ORDER BY `className`, `startHour`		
		";
$result = mysql_query($sql);
echo mysql_error();
	while($substitude = mysql_fetch_object($result)) {    
 	$substitudes[]=$substitude;
	}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','UI',20);
$pdf->Cell('75','25','HTL Anichstra�e');
$pdf->Cell('75','25',$date);
$pdf->Cell('','25','Abteilung '.$_SESSION['section'],'','1');
$pdf->SetFont('Arial','',12);
$pdf->Cell(15,10,'Stunde','1');
$pdf->Cell(30,10,'Klasse','1');
$pdf->Cell(40,10,'Suppl. durch','1');
$pdf->Cell(20,10,'Fach','1');
$pdf->Cell(70,10,'Bemerkung','1','1');
$count = 0;
if(isset($substitudes)){
	for($i = 0;$i<count($substitudes);$i++){
	 	$lessons_count = $substitudes[$i]->startHour;
	    $lessons_end = $substitudes[$i]->endHour; 
		while($lessons_count <= $lessons_end){
			$pdf->Cell(15,10,$lessons_count,'1');
			$pdf->Cell(30,10,$substitudes[$i]->className,'1');
			$pdf->Cell(40,10,$substitudes[$i]->teacher,'1');
			$pdf->Cell(20,10,$substitudes[$i]->suShort,'1');
			$pdf->Cell(70,10,$substitudes[$i]->comment,'1','1');
			$count++;
			$lessons_count++;
		}
	}
}
while($count<12){
 		$pdf->Cell(15,10,'','1');
		$pdf->Cell(30,10,'','1');
		$pdf->Cell(40,10,'','1');
		$pdf->Cell(20,10,'','1');
		$pdf->Cell(70,10,'','1','1');
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