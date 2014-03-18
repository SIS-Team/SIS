<?php
include_once("../../config.php");	 
require_once(ROOT_LOCATION . "/modules/external/fpdf/fpdf.php");
include_once(ROOT_LOCATION . "/modules/general/Connect.php");			
include_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");	

ifNotLoggedInGotoLogin();	

$permission = getPermission();
if($permission == "root" or $permission == "admin") {
	$mode ="admin";
	if(isset($_GET['class'])) $class =$_GET['class'];
	else {
 		if(isset($_GET['teacher'])) $teacher =$_GET['teacher'];
		else $teacher =$_SESSION['id'];
	}
	
}
else{
 	if(!getPermission() and !empty($_SESSION['isTeacher'])) $mode = 'teacher'; 
	else $mode = 'student';
}

if($mode == 'teacher') $teacher = $_SESSION['id'];

if($mode == 'student') {
	$class = $_SESSION['class'];
	$teacher = "";
}
$sql ="SELECT 
		`su`.`short` AS `suShort`,
		`sH`.`hour` AS `startHour`,
		`eH`.`hour` AS `endHour`,
		`sH`.`weekdayShort` AS `weekday` 
	  	FROM lessons AS `l`
		INNER JOIN subjects AS `su` ON `l`.`subjectFK` = `su`.`ID`
		INNER JOIN lessonsBase AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
		INNER JOIN classes AS `c` ON `lb`.`classFK` = `c`.`ID`
		INNER JOIN hours AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
		INNER JOIN hours AS `eH` ON `lb`.`endHourFK` = `eH`.`ID`
		INNER JOIN teachers AS `t` ON `l`.`teachersFK`=`t`.`ID`
";
if(!empty($teacher)) $sql .= "WHERE `t`.`short` = '".$teacher."'";
else $sql .= "WHERE `c`.`name` = '".$class."'";
$sql_result  = mysql_query($sql);
echo mysql_error();
while($result = mysql_fetch_array($sql_result)) {    
	$results[]=$result;
}
$hours = array();
if(isset($results)){
	for($j=0;$j<count($results);$j++){
	 	$startHour =$results[$j]['startHour'];
	
		while($startHour <= $results[$j]['endHour'])
		{	
	 		if(isset($hours[$startHour][$results[$j]['weekday']]) && $hours[$startHour][$results[$j]['weekday']] != $results[$j]['suShort'])
			{
	 			if(!strpos($hours[$startHour][$results[$j]['weekday']],$results[$j]['suShort']))
				$hours[$startHour][$results[$j]['weekday']] .= " |  ".$results[$j]['suShort'];
			}
			else $hours[$startHour][$results[$j]['weekday']] = $results[$j]['suShort'];
		$startHour++;
		}
}
}

$day = array(1=>'Mo',2=>'Di',3=>'Mi',4=>'Do',5=>'Fr');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->AddFont('gothic');
$pdf->AddFont('gothic','B');
$pdf->SetFont('gothic','B',20);
$pdf->Cell('130','25','HTL Anichstraße');
if(!empty($teacher)) $pdf->Cell('10','25','Lehrer: '.$teacher,'','1');
else $pdf->Cell('10','25','Klasse: '.$class,'','1');
$pdf->SetFont('gothic','B',16);
$pdf->Cell('25','10','Stunde','1');
$pdf->Cell('30','10','Mo','1');
$pdf->Cell('30','10','Di','1');
$pdf->Cell('30','10','Mi','1');
$pdf->Cell('30','10','Do','1');
$pdf->Cell('30','10','Fr','1','1');
$pdf->SetFont('gothic','',12);
$type = isEvening($hours);
if($type == "evening"){
	$end = 17;
	$start = 12;
}
else if($type == "normal"){
 	$end = 12;
	$start = 1;
}
else {
	$end = 17;
	$start = 1;
}

for($i=$start;$i<$end;$i++){
 	$newY = 0;
	$pdf->Cell('25','10',$i,'RLT');
	for($j=1;$j<6;$j++){
		if(isset($hours[$i][$day[$j]])){
 			$y = $pdf->GetY();
			$x = $pdf->GetX();
 			$pdf->MultiCell('30','10',$hours[$i][$day[$j]],'RLT');
			if($pdf->GetY() > $newY)$newY=$pdf->GetY();
			$pdf->SetY($y);
			$pdf->SetX($x+30);
			
		}
		else {
 			$y = $pdf->GetY();
 			$pdf->Cell('30','10','','RLT');	
			if($pdf->GetY() > $newY)$newY=$pdf->GetY();
		}
	}
	$pdf->SetY($y);

 	$otherY = $newY-$y;
	if($otherY== 0) $otherY+= 10;
	$pdf->Cell('25',$otherY,'','RLB');
	for($j=1;$j<6;$j++)
	{
		$pdf->Cell('30',$otherY,'','RLB');
	}

	$pdf->Cell('1','10','','','1');
	$pdf->SetY($newY);
}
$pdf->Output();

function isEvening($hours){
$check = 0;
for($i=1;$i<12;$i++){
	if(!isset($hours[$i])) $check++;
}
if($check == 11) return "evening";
else $check = 0;

for($i=12;$i<17;$i++){
	if(!isset($hours[$i])) $check++;
}
if($check == 5) return "normal";
else return "all";

}

?>