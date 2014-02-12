<?php
include_once("../config.php");	 
require_once(ROOT_LOCATION . "/modules/external/fpdf/fpdf.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
$sql = "SELECT *
FROM substitudes";
$result = mysql_query($sql);


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->Cell(10,10,'','1');
$pdf->Cell(40,10,'Klasse','1');
$pdf->Cell(40,10,'Suppl. durch','1');
$pdf->Cell(40,10,'Fach','1');
$pdf->Cell(40,10,'Bemerkung','1','1');

$pdf->Cell(10,10,'1','1');
$pdf->Cell(40,10,'','1');
$pdf->Cell(40,10,'','1');
$pdf->Cell(40,10,'','1');
$pdf->Cell(40,10,'','1','1');
$pdf->Output();



?>