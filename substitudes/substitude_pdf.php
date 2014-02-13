<?php
include_once("../config.php");	 
require_once(ROOT_LOCATION . "/modules/external/fpdf/fpdf.php");
include_once(ROOT_LOCATION . "/modules/general/Connect.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
if(!($_SESSION['loggedIn']))  exit();//die("Critical Error </br> Bist du sicher, dass du angemeldet bist?"); //Kontrolle ob angemeldet

$sql = "SELECT 
`su`.`short` AS suShort,
`c`.`name` AS className,
`s`.`time`,
`s`.`comment`,
`sH`.`hour` AS `startHour`,
`nsH`.`hour` AS `newStartHour`,
`t`.`display` AS `newTeacher`
FROM `substitudes` AS `s`
INNER JOIN `subjects` AS `su` ON `s`.`subjectFK` = `su`.`ID`
INNER JOIN `lessons` AS `l` ON `s`.`lessonFK` = `l`.`ID`
INNER JOIN `lessonsBase` AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
INNER JOIN `classes` AS `c` ON `lb`.`classFK` = `c`.`ID`
INNER JOIN `hours` AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
LEFT JOIN `hours` AS `nsH` ON `s`.`startHourFK` = `nsH`.`ID`
LEFT JOIN `teachers` AS `t` ON `s`.`teacherFK` = `t`.`ID`
ORDER BY `startHour`";
		
$result = mysql_query($sql);
	while($substitude = mysql_fetch_object($result)) {    
 	$substitudes[]=$substitude;
	}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->Cell(10,10,'','1');
$pdf->Cell(40,10,'Klasse','1');
$pdf->Cell(40,10,'Suppl. durch','1');
$pdf->Cell(40,10,'Fach','1');
$pdf->Cell(40,10,'Bemerkung','1','1');
for($i = 0;$i<count($substitudes);$i++){
	$pdf->Cell(10,10,$substitudes[$i]->startHour,'1');
	$pdf->Cell(40,10,$substitudes[$i]->className,'1');
	$pdf->Cell(40,10,$substitudes[$i]->newTeacher,'1');
	$pdf->Cell(40,10,$substitudes[$i]->suShort,'1');
	$pdf->Cell(40,10,$substitudes[$i]->comment,'1','1');
}
$pdf->Output();



?>