<?php
e($form->create('Consultas', array('action' => 'reportePacientes')));
?>
<div align="center">
<table  id="box-table-b" >
    <tr>
        <td>FECHA INICIO</td>
        <td>FECHA FIN</td>
    </tr>
    <tr>
        <td><?php e($form->input('TratamientoPaciente.fecha_ini',array("id"=>"fecha_ini","label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"15")));?></td>
        <td><?php e($form->input('TratamientoPaciente.fecha_fin',array("id"=>"fecha_fin","label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"15")));?></td>  
    </tr>
    <tr>
        <td colspan="2"><?php e($form->submit("Generar"));?></td>
    </tr>
</table>
 </div>
<script type="text/javascript">
//<![CDATA[
  var cal = Calendar.setup({
      onSelect: function(cal) { cal.hide() },
      showTime: true
  });
  cal.manageFields("fecha_ini","fecha_ini",  "%Y-%m-%d");
  cal.manageFields("fecha_fin","fecha_fin",  "%Y-%m-%d");
  
//]]>
</script>
<div id="divReporteGral"></div>