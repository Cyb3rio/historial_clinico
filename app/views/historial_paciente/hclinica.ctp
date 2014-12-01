<?php
App::import('Vendor','tcpdf');
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Cyberio Lopez');
$pdf->SetTitle('CARNET PACIENTE');
$pdf->SetMargins(PDF_MARGIN_LEFT, 6, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('cid0cs', '', 8);

$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();

$pdf->AddPage();
$pdf->writeHTML($html2, true, false, true, false, '');
$pdf->lastPage();

$pdf->AddPage();
$pdf->writeHTML($consentimiento, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output('HC-'.$folio.'.pdf', 'I');
?>