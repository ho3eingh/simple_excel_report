<!DOCTYPE html>
<html lang="en">
    <body>
        <form>
<?php
session_start();
require_once('tcpdf/tcpdf.php'); 
$content=$_SESSION['content'];


$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
$obj_pdf->SetCreator(PDF_CREATOR);  
$obj_pdf->SetTitle("Data");  
$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
$obj_pdf->SetDefaultMonospacedFont('helvetica');  
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);  
$obj_pdf->setPrintHeader(false);  
$obj_pdf->setPrintFooter(false);  
$obj_pdf->SetAutoPageBreak(TRUE, 10);  
$font_path 	= 'fonts/Tahoma Regular font.ttf';
$fontname = TCPDF_FONTS::addTTFfont($font_path, 'TrueTypeUnicode');
$obj_pdf->SetFont($fontname, '', 11);  
$obj_pdf->AddPage();
 
$obj_pdf->writeHTML($content);
 

$file_name=rand(5000,9999999);
$file_name.=".pdf";
ob_end_clean();

$obj_pdf->Output($file_name, 'I');


?>
</form>
</body>
</html>