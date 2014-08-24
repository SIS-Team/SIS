<?php
	/* /pdf/timetables/index.php
	 * Autor: Weiland Mathias
	 * Beschreibung:
	 *	Erzeugt die PDF-Ausgabe für den Stundenplan
	 */	
require_once("../../config.php");	 
require_once(ROOT_LOCATION . "/modules/external/fpdf/fpdf.php");
require_once(ROOT_LOCATION . "/modules/general/Connect.php");			
require_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
require_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");	

ifNotLoggedInGotoLogin();	//Kontrolle ob angemeldet

$permission = getPermission();
if($permission == "root" or $permission == "admin") {  //Schüler sehen nur ihren eigenen Stundenplan
	$mode ="admin";
	if(isset($_GET['class'])) $class =$_GET['class'];
	else {
 		if(isset($_GET['teacher'])) $teacher =$_GET['teacher'];
		else $teacher =$_SESSION['id'];
	}	
}
else{
 	if(!getPermission() and !empty($_SESSION['isTeacher'])) $mode = 'teacher'; //keine Rechte und isTeacher => Lehrer
	else $mode = 'student';
}

if($mode == 'teacher') $teacher = $_SESSION['id'];	
if($mode == 'student') { //verhindert das Schüler Lehrerstundenpläne sehen
	$class = $_SESSION['class'];
	$teacher = "";
}
$sql ="SELECT 
		`su`.`short` AS `suShort`,
		`t`.`short` AS `teShort`,
		`r`.`name` AS `roName`,
		`sH`.`hour` AS `startHour`,
		`eH`.`hour` AS `endHour`,
		`sH`.`weekdayShort` AS `weekday`,
		`c`.`name` AS `clName` 
	  	FROM lessons AS `l`
		INNER JOIN subjects AS `su` ON `l`.`subjectFK` = `su`.`ID`
		INNER JOIN lessonsBase AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
		INNER JOIN classes AS `c` ON `lb`.`classFK` = `c`.`ID`
		INNER JOIN hours AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
		INNER JOIN hours AS `eH` ON `lb`.`endHourFK` = `eH`.`ID`
		INNER JOIN teachers AS `t` ON `l`.`teachersFK`=`t`.`ID`
		LEFT JOIN rooms AS `r` ON `l`.`roomFK` = `r`.`ID`
";
if(!empty($teacher)) $sql .= "WHERE `t`.`short` = '".$teacher."'"; //wenn Lehrermitgegeben Lehrerabfrage
else $sql .= "WHERE `c`.`name` = '".$class."'";
$sql_result  = mysql_query($sql);
echo mysql_error();
while($result = mysql_fetch_array($sql_result)) {    
	$results[]=$result;
}

class PDF extends FPDF
{//um individuellen Inhalt in Kopf- bzw. Fusszeile zu ermöglichen
	//Kopfzeile
	function Header()
	{
	    //Logo
		$this->Image("../../data/images/logo.png",85,3,30,30);
	    //Gothic fett 20
		$this->AddFont('gothic','B');
		$this->SetFont('gothic','B',20);
		$this->Cell('130','25','HTL Anichstraße');
	    //Zeilenumbruch
	    $this->Ln(20);
	}
	
	//Fusszeile
	function Footer()
	{
	    //Position 1,5 cm von unten
	    $this->SetY(-15);
	    //Arial kursiv 8
	    $this->SetFont('Arial','I',10);
	    //Seitenzahl
	    $this->Cell(0,10,'Diese Ausgabe wurde mittels SIS (School Information Service) generiert',0,0,'C');
	}
}


$hours = array();
if(isset($results)){
	for($j=0;$j<count($results);$j++){ //alle Lessons durchlaufen
	 	$startHour =$results[$j]['startHour'];
		while($startHour <= $results[$j]['endHour']) //für Stunden die länger als eine Stunde dauern
		{	
	 		if(isset($hours[$startHour][$results[$j]['weekday']])) //Abfrage ob bereits Eintrag vorhanden
			{
 				//Abfrage ob neuer Eintrag beriets in altem enthalten ist	
 				if(strpos($hours[$startHour][$results[$j]['weekday']]['suShort'],$results[$j]['suShort'])=== false)
				{
				$hours[$startHour][$results[$j]['weekday']]['suShort'] .= " |  ".$results[$j]['suShort'];
				}
			}
			else $hours[$startHour][$results[$j]['weekday']]['suShort'] = $results[$j]['suShort']; // sonst Eintrag überschreiben
			$hours[$startHour][$results[$j]['weekday']]['teShort'] = $results[$j]['teShort'];
			$hours[$startHour][$results[$j]['weekday']]['roName'] = $results[$j]['roName'];
			$hours[$startHour][$results[$j]['weekday']]['clName'] = $results[$j]['clName'];
		$startHour++;
		}
	}
}
//Ausgabe Tabellenkopf
$day = array(1=>'Mo',2=>'Di',3=>'Mi',4=>'Do',5=>'Fr');
$pdf = new PDF();
$pdf->AddPage();
$pdf->AddFont('gothic');
$pdf->SetXY(135,10);
if(!empty($teacher)) $pdf->Cell('10','25','Lehrer: '.$teacher,'','1');
else $pdf->Cell('10','25','Klasse: '.$class,'','1');
$pdf->SetFont('gothic','B',16);
$pdf->Cell('25','10','Stunde','1');
$pdf->Cell('32','10','Mo','1');
$pdf->Cell('32','10','Di','1');
$pdf->Cell('32','10','Mi','1');
$pdf->Cell('32','10','Do','1');
$pdf->Cell('32','10','Fr','1','1');
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

for($i=$start;$i<$end;$i++){ //Stundenplanausgabe
 	$newY = 0;
	if(($i == 12 and $type != "evening")or $pdf->GetY() >=265) { //Um Fehler zu vermeiden,wenn Seite überschritten wird
		$pdf->SetFont('gothic','B',20);
 		$pdf->AddPage();
 		$pdf->SetXY(135,10);
		if(!empty($teacher)) $pdf->Cell('10','25','Lehrer: '.$teacher,'','1');
		else $pdf->Cell('10','25','Klasse: '.$class,'','1');
		$pdf->SetFont('gothic','',12);
	}
	$pdf->Cell('25','10',$i,'RLT');	//Stundennummer ausgeben
	for($j=1;$j<6;$j++){
 		$y = $pdf->GetY();	//aktuelle Y-Position speichern
		$x = $pdf->GetX();	//aktuelle X-Position speichern
		if(isset($hours[$i][$day[$j]])){
 			$output = $hours[$i][$day[$j]]['suShort'];
			if(isset($teacher)){
 				$output .= "\n" . $hours[$i][$day[$j]]['clName'];
				if(isset($hours[$i][$day[$j]]['roName'])) $output.= " | ". $hours[$i][$day[$j]]['roName'];
			}
 			$pdf->MultiCell('32','10',$output,'RLT','C'); 
			//Multicell, da Eintrag länger als eingestellte Breite der Spalte sein kann 
			//RLT = Rand oben, links und rechts
			if($pdf->GetY() > $newY)$newY=$pdf->GetY();	//neue Y-Position speichern
			//Y-Position ändert sich, da nach Multicell automatisch in einer neuen Zeile begonnen wird
		}
		else {
 			if (isset($teacher)) $pdf->MultiCell('32','20','','RLT');	
			else $pdf->MultiCell('32','10','','RLT');	
			if($pdf->GetY() > $newY)$newY=$pdf->GetY();
		}
		//Position neben vorheriger Zelle wiederherstellen, zuerst muss Y, dann X eingestellt werden
		$pdf->SetY($y);
		$pdf->SetX($x+32);
	}
	$pdf->SetY($y);	//da bei set Y zum Zeilenbeginn zurückgesprungen wird ,muss dies nocheinmal ausgeführt werden

 	$newHeight = $newY-$y; //Höhe der zuerstellenden Zelle
	$pdf->Cell('25',$newHeight,'','RLB'); //Zelle mit neure Höhe und Rand unten, rechts und links
	for($j=1;$j<6;$j++)
	{
		$pdf->Cell('32',$newHeight,'','RLB');
	}

	$pdf->SetY($newY);	//Zeilenumbruch
}

$filename = "timetable_";
if(isset($teacher)) $filename .= $teacher;
else if(isset($class))$filename .=$class;
$filename.= ".pdf";
$pdf->Output($filename,'I'); //PDF ausgeben

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