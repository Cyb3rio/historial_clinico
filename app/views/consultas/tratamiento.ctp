<?php
e($form->input('TratamientosPaciente.id_tratamiento',array("label"=>false,"type"=>"hidden")));
?>
<br/>
<table width="100%" border="0">
        <tr class="texto_cajas">
            <td><b>FECHA</b></td>
            <td colspan="5" ><?php e($form->input('TratamientosPaciente.fecha',array("id"=>"fecha_t","label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"10")));?></td>
        </tr>
        
        <tr class="texto_cajas">
          <td width="17%" class="texto_cajas">PROFILAXIS</td>
          <td width="7%"><?php e($form->input('TratamientosPaciente.profilaxis',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td width="32%">APLICACIÓN DE FLUOR</td>
          <td width="9%" class="texto_cajas"><?php e($form->input('TratamientosPaciente.fluor',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td width="27%">FARMACOTERAPIA</td>
          <td width="8%"><?php e($form->input('TratamientosPaciente.farmacoterapia',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td class="texto_cajas">AMALGAMAS</td>
          <td><?php e($form->input('TratamientosPaciente.amalgamas',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td>RECUBRIMIENTO PULPAR</td>
          <td class="texto_cajas"><?php e($form->input('TratamientosPaciente.pulpotomia',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td>ODONTOXESIS</td>
          <td><?php e($form->input('TratamientosPaciente.odontoxesis',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td>RESINAS</td>
          <td><?php e($form->input('TratamientosPaciente.resinas',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td>OBTURACIÓN TEMPORAL</td>
          <td><?php e($form->input('TratamientosPaciente.obturacion',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td>SELLADO-FOSETAS-FISURAS</td>
          <td><?php e($form->input('TratamientosPaciente.fosetas',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td>EXTRACCIONES</td>
          <td><?php e($form->input('TratamientosPaciente.extracciones',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td>LASER POST.QUIRURGICO</td>
          <td><?php e($form->input('TratamientosPaciente.terapia_laser',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
          <td>OTROS</td>
          <td><?php e($form->input('TratamientosPaciente.otros',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td><a style='cursor: pointer;' onclick="muestra_oculta('divOtrosServicios')">OTROS</a></td>
          <td><?php e($form->checkbox('TratamientosPaciente.otros',array("id"=>"otros","label"=>false,"onclick"=>"muestra_oculta('divOtrosServicios')")));?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_cajas">
            <td colspan="6">
                <div id="divOtrosServicios">
                    <div id="nuevoServicio"></div>
                    <table width="100%" id="box-table-a" align='center'>
                        <thead>
                        <tr>
                            <th scope="col" colspan="2"><?php e($form->input('Consulta.palabra_clave',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"30","maxLenght"=>"10")));?></th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                        </thead>
                    </table>
                    <table width="100%" id="box-table-a" align='center'>
                        <thead>
                        <tr>
                            <th scope="col">SERVICIO</th>
                            <th scope="col">CANTIDAD</th>
                        </tr>
                        </thead>
                        <tbody bgcolor="#FFFFFF">
                        <?php
                        $otrosServicios = $this->data['OtrosServiciosPaciente'];
                        foreach($otrosServicios as $k=>$os)
                        {
                            e('<tr>');
                            e('<td>'
                                .$form->input('OtrosServiciosPaciente.'.$k.'.nombre_servicio',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"80","readonly"=>true))
                                .$form->input('OtrosServiciosPaciente.'.$k.'.id_x',array("label"=>false,"type"=>"hidden"))
                              .'</td>');
                            e('<td align="center">'.$form->input('OtrosServiciosPaciente.'.$k.'.cantidad',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")).'</td>');
                            e('</tr>');
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        
        
        <tr class="texto_cajas">
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr class="texto_cajas">
          <td colspan="2" ><b>OTROS: ESPECIFICAR</b></td>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6"><?php e($form->input('TratamientosPaciente.otros_especificar',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas", "cols"=>"70", "rows"=>"1")));?></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="texto_cajas">
          <td colspan="6" ><b>TRATAMIENTO QUIRURGICO (¿Cuál?)</b></td>
          
        </tr>
        <tr>
            <td colspan="6"><?php e($form->input('TratamientosPaciente.tratamiento_quirurgico',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas", "cols"=>"70", "rows"=>"1")));?></td>
            <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="1">
        <tr class="texto_cajas">
            <td><b>PRÓTESIS</b></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_cajas">
          <td colspan="2"><table width="100%" border="1">
            <tr class="texto_cajas">
              <td width="2%">&nbsp;</td>
              <td width="18%">PARCIAL SUPERIOR</td>
              <td width="5%"><?php e($form->checkbox('TratamientosPaciente.protesis_parcial_sup'));?></td>
              <td width="17%">PARCIAL INFERIOR</td>
              <td width="5%"><?php e($form->checkbox('TratamientosPaciente.protesis_parcial_inf'));?></td>
              <td width="16%">TOTAL SUPERIOR</td>
              <td width="5%"><?php e($form->checkbox('TratamientosPaciente.protesis_total_sup'));?></td>
              <td width="16%">TOTAL INFERIOR</td>
              <td width="16%"><?php e($form->checkbox('TratamientosPaciente.protesis_total_inf'));?></td>
            </tr>
          </table></td>
        </tr>
        
        <tr class="texto_cajas">
          <td><b>PRONÓSTICO</b></td>
          <td>
              <?php
                $pronostico = (isset($this->data['TratamientosPaciente']['pronostico'])) ? $this->data['TratamientosPaciente']['pronostico'] :'0' ;
                  $options = array('1' => ' BUENO','2' => ' RESERVADO', '3'=>' DESFAVORABLE');
                  $attributes = array('legend' => false,
                                      'value' => $pronostico,
                                     );
                  e($form->radio('TratamientosPaciente.pronostico',$options, $attributes));
              ?>
          </td>
        </tr>
        <tr class="texto_cajas">
          <td><FONT COLOR="red">*</font> Paciente referido a:</td>
          <td><?php e($form->input('TratamientosPaciente.referido_a',array("label"=>false,"type"=>"text","class"=>"texto_cajas", "size"=>"50")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td><FONT COLOR="red">*</font> Paciente atendido por:</td>
          <td><?php e($form->input('TratamientosPaciente.atendido_por',array("label"=>false,"type"=>"text","class"=>"texto_cajas", "size"=>"50")));?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right"><?php e($form->submit("Actualizar",array("onBlur"=>"ajaxFucntion()")));?></td>
        </tr>
    </table>
<script type="text/javascript">
//<![CDATA[
  var cal = Calendar.setup({
      onSelect: function(cal) { cal.hide() },
      showTime: true
  });
  cal.manageFields("fecha_t","fecha_t",  "%Y-%m-%d");
  
//]]>
</script>