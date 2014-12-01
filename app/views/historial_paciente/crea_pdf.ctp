<?php
App::import('Vendor','tcpdf');
$pdf = new TCPDF();

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Cyberio Lopez');
$pdf->SetTitle('CONSENTIMIENTO INFORMADO');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
//$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<h2>CONSENTIMIENTO INFORMADO</h2>
<table width="100%" border="1">
  <tr>
    <td colspan="4" valign="top"><strong>Para ser explicado y despues firmado por el paciente:</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="right" valign="top"><strong>FOLIO</strong></td>
    <td align="center">$folio</td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="top"><table width="95%" border="0">
        <tr>
          <td width="2%" align="left" valign="top"><p>&nbsp;</p></td>
          <td width="98%" align="left" valign="top">Con esta fecha el dentista de esta Unidad Movil Dental me aplico una Historia Clinica a la cual respodndi bajo promesa de decir verdad y se me informo de los riesgos posibles y complicaciones que cualquier tratamiento dental conlleva y estoy plenamente consciente de: 1.- Que entiendo por que se me explico a detalle el alcance y repercusiones en mi salud que implica cualquier procedimiento o tratamiento dental, asi como los riesgos a los que me expongo como son las reacciones alergicas, hemorragias, infecciones, reacciones secundarias y otros de naturaleza analoga al empleo de medicamentos. 2.- Tambien se me explico que durante el procedimiento que se me va aplicar, existe la posibilidad de otros riesgos y complicaciones no discutidos con anterioridad que pudieran presentarse y que requieren otros procedimientos adicionales por lo que autorizo a que se me apliquen. 3.- Una vez leida y entendida esta explicacion; autorizo con cirujano dentista a que realice los procedimientos necesarios para mi atencion odontologica.</td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
  
  <tr>
    <td colspan="4"><strong>DECLARO QUE RECIBI DE CONFORMIDAD MI TRATAMIENTO</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><p>&nbsp;</p>
    <p><small>[NOMBRE COMPLETO]</small></p></td>
  </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="42%"><p><strong>FIRMA O HUELLA PACIENTE:</strong></p></td>
    <td width="26%" rowspan="2" align="center" valign="bottom"><small>[HUELLA]</small></td>
    <td width="11%"><strong>FECHA</strong></td>
    <td width="21%" align="center">$fecha</td>
  </tr>
  <tr>
    <td align="center" valign="bottom"><p>&nbsp;</p>
    <p><small>[FIRMA]</small></p></td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output('CI-'.$folio.'.pdf', 'I');
?>