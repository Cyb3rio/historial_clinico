<div id="divCapaturaa">
<?php
e($ajax->form(array("type"=>"post",
                    "options"=>array("model"=>"HistorialPaciente",
                    "update"=>"divCaptura",
                    "url"=>array("controller"=>'HistorialPaciente',"action"=>"guardaHistorial"),
			            )
                   )
             )
 );
?>
<script>
window.onload = function()
{
    muestra_oculta('divOtrosServicios');
}
</script>

<div style="width: 795px; float: left;">
    <ul class="tabs"> 
        <li><a href="#view1">PACIENTE</a></li> 
        <li><a href="#view2">VALORACIÓN</a></li> 
        <li><a href="#view3">CAVIDAD ORAL</a></li>
        <li><a href="#view4">ODONTOGRAMA</a></li>
        <li><a href="#view5">TRATAMIENTO</a></li>
         
    </ul> 
    <div class="tabcontents"> 
    <div id="view1">
  <table width="100%" border="0" >
  <tr  class="texto_cajas">
    <td align="left"><b><FONT COLOR="red">*</font>FOLIO</b></td>
    <td width="26%" align="left"><?php e($form->input('HistorialPaciente.folio',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"15","maxLenght"=>"5","readonly"=>true)));?></td>
    <td width="15%" align="left"><b><font color="red">*</font> FECHA</b></td>
    <td width="15%" align="left"><?php e($form->input('HistorialPaciente.fecha',array("id"=>"fecha","label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"10","value"=>date("Y-m-d"))));?></td>
    <td width="33%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2"><b><FONT COLOR="red">*</font> ESTADO</b></td>
    <td colspan="2"><b><FONT COLOR="red">*</font> MUNICIPIO</b></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2"><?php 
                              e($form->input('HistorialPaciente.id_estado',
                                              array("id"=>"id_estado",
                                                    "label"=>false,
                                                    "type"=>"select",
                                                    "options"=>$Estados,
                                                    "empty"=>"SELECCIONAR",
                                                    "class"=>"texto_cajas"
                                                   )
                                            )
                               );

                      ?></td>
    <td colspan="3"><div id="divMunicipios">
      <?php e($form->input('HistorialPaciente.id_municipio',array("id"=>"id_municipio","label"=>false,"type"=>"select","empty"=>"SELECCIONAR","class"=>"texto_cajas")));?>
    </div></td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2"><b><FONT COLOR="red">*</font> CIUDAD</b></td>
    <td colspan="2"><b><FONT COLOR="red">*</font> LOCALIDAD</b></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2">
        <div id="divCiudades">
            <?php e($form->input('HistorialPaciente.id_ciudad',array("id"=>"id_ciudad","label"=>false,"type"=>"select","empty"=>"SELECCIONAR","class"=>"texto_cajas")));?>        
        </div>
    </td>
    <td colspan="3">
        <div id="divAsentamientos">
            <?php e($form->input('HistorialPaciente.id_asentamiento',array("id"=>"id_asentamiento","label"=>false,"type"=>"select","empty"=>"SELECCIONAR","class"=>"texto_cajas")));?>
        </div>
    </td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2"><b>CIUDAD [OTRA]</b></td>
    <td colspan="2"><b>LOCALIDAD [OTRA]</b></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2">
        <div id="divCiudad">
              <?php e($form->input('HistorialPaciente.ciudad',array("id"=>"otra_ciudad","label"=>false,"type"=>"text","class"=>"texto_cajas")));?>
        </div>
    </td>
    <td colspan="3">
        <div id="divAsentamiento">
              <?php e($form->input('HistorialPaciente.asentamiento',array("id"=>"otra_asentamiento","label"=>false,"type"=>"text","class"=>"texto_cajas")));?>
        </div>
    </td>
  </tr>
  
  <tr class="texto_cajas">
    <td colspan="2"><b><FONT COLOR="red">*</font> NOMBRE PACIENTE</b></td>
    <td colspan="2"><b>TELÉFONO</b></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2" valign="top"><?php e($form->input('HistorialPaciente.pae_nombre',array("label"=>false,"type"=>"text","size"=>"30","class"=>"texto_cajas")));?></td>
    <td colspan="2" valign="top"><?php e($form->input('HistorialPaciente.pae_telefono',array("label"=>false,"type"=>"text","class"=>"texto_cajas")));?></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td height="23"><b>FEC. NAC.</b></td>
    <td><b><font color="red">*</font> EDAD</b></td>
    <td colspan="2"><b><font color="red">*</font> GÉNERO</b></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td><?php e($form->input('HistorialPaciente.fecha_nac',array("id"=>"fecha_nac","label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"10","placeholder"=>"aaaa-mm-dd","onkeyup"=>"mascara(this,'-',patron,true)","onBlur"=>"calcular_edad(this.value);")));?></td>
    <td><?php e($form->input('HistorialPaciente.pae_edad',array("id"=>"pae_edad","label"=>false,"type"=>"text","size"=>"3","class"=>"texto_cajas","onkeydown"=>"javascript:return validanumeros(event)","maxLength"=>"3")));?></td>
    <td colspan="2"><?php e($form->input('HistorialPaciente.pae_sexo',array("id"=>"pae_sexo","label"=>false,"type"=>"select","options"=>array("1"=>"M","2"=>"F"),"empty"=>"","class"=>"texto_cajas")));?></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td width="11%" valign="top"><b><font color="red">*</font>DOMICILIO</b></td>
    <td colspan="3" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="4" valign="top"><?php e($form->input('HistorialPaciente.pae_direccion',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas","rows"=>"3")));?></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>
           
        </div> 
        <div id="view2">
            <table width="100%" border="1">
  <tr class="texto_cajas">
    <td width="2%">1.-</td>
    <td colspan="2">¿Ha estado hopitalizado(a) alguna vez en los últimos dos años?</td>
    <td colspan="5" align="left">
        <?php 
            $options = array('1' => ' SI','0' => ' NO');
            $attributes = array('legend' => false,
                                'value' => false,
                                'id' => 'hospitalizado'
                               );
            e($form->radio('hospitalizado',$options, $attributes));
        ?>
    </td>
  </tr>
  <tr class="texto_cajas">
    <td>2.-</td>
    <td colspan="2">¿Ha estado en tratamiento médico en los últimos dos años?</td>
    <td colspan="5" align="left">
        <?php 
            $options = array('1' => ' SI','0' => ' NO');
            $attributes = array('legend' => false,
                                'value' => false,
                                'id' => 'tratamiento_medico'
                               );
            e($form->radio('tratamiento_medico',$options, $attributes));
        ?>
    </td>
  </tr>
  <tr class="texto_cajas">
    <td>3.-</td>
    <td colspan="2">¿Ha tomado algún medicamento en el último año?</td>
    <td colspan="5" align="left">
        <?php 
            $options = array('1' => ' SI','0' => ' NO');
            $attributes = array('legend' => false,
                                'value' => false,
                                'id' => 'tomado_medicamento'
                               );
            e($form->radio('tomado_medicamento',$options, $attributes));
        ?>
    </td>
  </tr>
  <tr class="texto_cajas">
    <td>4.-</td>
    <td colspan="2">¿Es alergico(a) a algún medicamento?</td>
    <td colspan="5" align="left">
        <?php 
            $options = array('1' => ' SI','0' => ' NO');
            $attributes = array('legend' => false,
                                'value' => false,
                                'id' => 'alergico_medicamento'
                               );
            e($form->radio('alergico_medicamento',$options, $attributes));
        ?>
    </td>
  </tr>
  <tr class="texto_cajas">
    <td>&nbsp;</td>
    <td colspan="2">¿Cuál?</td>
    <td colspan="5" align="left"><?php e($form->input('HistorialPaciente.alergico_a',array("label"=>false,"type"=>"text","class"=>"texto_cajas")));?></td>
  </tr>
  <tr class="texto_cajas">
    <td>5.-</td>
    <td colspan="2">¿Ha tenido alguna hemorragia que requirió tratamiento especial?</td>
    <td colspan="5" align="left">
        <?php 
            $options = array('1' => ' SI','0' => ' NO');
            $attributes = array('legend' => false,
                                'value' => false,
                                'id' => 'hemorragia'
                               );
            e($form->radio('hemorragia',$options, $attributes));
        ?>
    </td>
  </tr>
  <tr class="texto_cajas">
    <td>6.-</td>
    <td colspan="2">¿Ha padecido o padece alguna de las siguientes efermedades?</td>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8"><table width="90%" align="center">
      <tr class="texto_cajas">
        <td width="5%">&nbsp;</td>
        <td width="30%">PROBLEMAS CARDIACOS</td>
        <td width="2%"><?php e($form->checkbox('cardiacos'));?></td>
        <td width="5%">&nbsp;</td>
        <td width="26%">TRANSTORNOS PSQUIAT</td>
        <td width="2%"><?php e($form->checkbox('transtornos_psiche'));?></td>
        <td width="5%">&nbsp;</td>
        <td width="25%">ÚLCERAS GÁSTRICAS</td>
        <td width="4%"><?php e($form->checkbox('ulceras'));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>PRESIÓN ARTERIAL ALTA</td>
        <td><?php e($form->checkbox('presion_alta'));?></td>
        <td>&nbsp;</td>
        <td>ASMA</td>
        <td><?php e($form->checkbox('asma'));?></td>
        <td>&nbsp;</td>
        <td>HERNIA HIATAL</td>
        <td><?php e($form->checkbox('hernia'));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>PRESIÓN ARTERIAL BAJA</td>
        <td><?php e($form->checkbox('presion_baja'));?></td>
        <td>&nbsp;</td>
        <td>ASFIXIA</td>
        <td><?php e($form->checkbox('asfixia'));?></td>
        <td>&nbsp;</td>
        <td>HEPTATITIS</td>
        <td><?php e($form->checkbox('hepatitis'));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>ANEMIA</td>
        <td><?php e($form->checkbox('anemia'));?></td>
        <td>&nbsp;</td>
        <td>TUBERCULOSIS</td>
        <td><?php e($form->checkbox('tuberculosis'));?></td>
        <td>&nbsp;</td>
        <td>CIRROSIS HEPÁTICA</td>
        <td><?php e($form->checkbox('cirrosis'));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>FIEBRE REUMÁTICA</td>
        <td><?php e($form->checkbox('fiebre_reumatica'));?></td>
        <td>&nbsp;</td>
        <td>GASTRITIS</td>
        <td><?php e($form->checkbox('gastritis'));?></td>
        <td>&nbsp;</td>
        <td>DIABETES</td>
        <td><?php e($form->checkbox('diabetes'));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>ARTRITIS / REUMATISMO</td>
        <td><?php e($form->checkbox('artitis_reumatismo'));?></td>
        <td>&nbsp;</td>
        <td>DESMAYOS</td>
        <td><?php e($form->checkbox('desmayos'));?></td>
        <td>&nbsp;</td>
        <td>ENFERM. RIÑONES</td>
        <td><?php e($form->checkbox('rinhon'));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>ATAQUES / CONVULSIONES</td>
        <td><?php e($form->checkbox('ataques_convulsiones'));?></td>
        <td>&nbsp;</td>
        <td>CANCER</td>
        <td><?php e($form->checkbox('cancer'));?></td>
        <td>&nbsp;</td>
        <td>EPILEPSIA</td>
        <td><?php e($form->checkbox('epilepsia'));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>OSTEOPOROSIS</td>
        <td><?php e($form->checkbox('osteoporosis'));?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>SIDA</td>
        <td><?php e($form->checkbox('sida'));?></td>
      </tr>
    </table></td>
  </tr>
  <tr class="texto_cajas">
    <td>7.-</td>
    <td colspan="2">¿Padece alguna enfermedad importante?</td>
    <td colspan="5"><?php 
            $options = array('1' => ' SI','0' => ' NO');
            $attributes = array('legend' => false,
                                'value' => false,
                                'id' => 'otra_enfermedad'
                               );
            e($form->radio('otra_enfermedad',$options, $attributes));
        ?></td>
  </tr>
  <tr class="texto_cajas">
    <td>&nbsp;</td>
    <td colspan="2">¿Cuál?</td>
    <td colspan="5"><?php e($form->input('HistorialPaciente.cual_enfermedad',array("label"=>false,"type"=>"text","class"=>"texto_cajas")));?></td>
    
  </tr>
</table>
            
        </div> 
        <div id="view3"> 
        
            <table width="100%" border="1">
  <tr class="texto_cajas">
      <td width="19%"><b>TEJIDOS BLANDOS</b></td>
    <td colspan="5">Anote las anormalidades que encuentre en labios/Carrillos/Paladar/Lengua/Piso de Boca/ Zonas Yugales/ Rebordes Alveolares, Etc.</td>
  </tr>
  <tr class="texto_cajas">
      <td>&nbsp;</td>
      <td colspan="5"><?php e($form->input('HistorialPaciente.tejidos_blandos',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas", "cols"=>"75", "rows"=>"1")));?>
  </tr>
  <tr class="texto_cajas">
    <td valing="top"><b>TEJIDOS DUROS</b></td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td>&nbsp;</td>
    <td colspan="5"><?php e($form->input('HistorialPaciente.tejidos_duros',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas", "cols"=>"75", "rows"=>"1")));?></td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="3"><b>ARTICULACIONES TEMPOROMANDIBULARES</b></td>
    <td colspan="3">&nbsp;</td>
    
  </tr>
  <tr class="texto_cajas">
      <td>&nbsp;</td>
      <td colspan="5"><?php e($form->input('HistorialPaciente.articulaciones',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas", "cols"=>"75", "rows"=>"1")));?></td>
  </tr>
  <tr class="texto_cajas">
    <td><b>EXA. PERIODONTAL</b></td>
    <td colspan="5">Encias / Defecto mucogingivales / bolsas Periodontales / etc.)</td>
  </tr>
  <tr class="texto_cajas">
      <td>&nbsp;</td>
      <td colspan="5"><?php e($form->input('HistorialPaciente.periodontal',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas", "cols"=>"75", "rows"=>"1")));?></td>
  </tr>
  <tr class="texto_cajas">
      <td><b>PDB </b></td>
      <td width="25%"><b>DESORGANIZADA</b></td>
      <td><b>ORGANIZADA</b></td>
      <td colspan="3"><b>HIGIENE ORAL</b></td>
  </tr>
  <tr class="texto_cajas">
    <td>&nbsp;</td>
    <td><?php e($form->input('HistorialPaciente.pdb_desorganizada',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"10","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
    <td><?php e($form->input('HistorialPaciente.pdb_organizada',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"10","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
    <td colspan="3"><?php
            $options = array('1' => ' Buena','2' => ' Regular', '3'=>' Mala');
            $attributes = array('legend' => false,
                                'value' => false,
                               );
            e($form->radio('higiene_oral',$options, $attributes));
        ?></td>
  </tr>
  <tr class="texto_cajas">
    <td rowspan="2"><b>TOTAL DE O.D.:</b></td>
    <td width="11%"><b>ADULTOS</b></td>
    <td width="24%"><b>INFANTILES</b></td>
    <td rowspan="2">&nbsp;</td>
    <td colspan="2" rowspan="2">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td><?php e($form->input('HistorialPaciente.total_od_adulto',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"10","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
    <td><?php e($form->input('HistorialPaciente.total_od_infantil',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"10","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
  </tr>
  <tr class="texto_cajas">
    <td><b>MUSCULATURA</b></td>
    <td colspan="3">(Maceteros / Temporales / Pterigoideos internos y externos)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td>&nbsp;</td>
    <td colspan="3"><?php e($form->input('HistorialPaciente.musculatura',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas","cols"=>"75","rows"=>"1")));?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
    <td><b>OCLUSIÓN</b></td>
    <td colspan="3">
    <?php
            $options = array('1' => ' I','2' => ' II', '3'=>' III','4'=>' Traumática');
            $attributes = array('legend' => false,
                                'value' => false,
                               );
            e($form->radio('oclusion',$options, $attributes));
        ?>
    </td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
        
        </div>
        <div id="view4" style="text-align: center">
            <p>
            <?php e($html->image("odontograma.jpg",array("width"=>"75%", "height"=>"75%")));?>
            </p>
            <p>
                <?php
                    $host = $_SERVER['HTTP_HOST'];
                    $folio = $_SESSION['folio'];
                ?>
                <iframe SCROLLING=NO frameborder="0" src="http://localhost/webcam/index.php?folio=<?php e($_SESSION['folio']);?>" height='400px'></iframe>
            </p>
            
        </div> 
        <div id="view5">
            <table width="100%" border="0">
                <tr class="texto_cajas">
                    <td colspan="6"><b>TIPO DE TRATAMIENTO</b></td>
                </tr>
        <tr class="texto_cajas">
          <td width="17%" class="texto_cajas">PROFILAXIS</td>
          <td width="7%"><?php e($form->input('TratamientosPaciente.profilaxis',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
          <td width="32%">APLICACIÓN DE FLUOR</td>
          <td width="9%" class="texto_cajas"><?php e($form->input('TratamientosPaciente.fluor',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onClick"=>"this.select()","placeHolder"=>"0")));?></td>
          <td width="27%">FARMACOTERAPIA</td>
          <td width="8%"><?php e($form->input('TratamientosPaciente.farmacoterapia',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onClick"=>"this.select()","placeHolder"=>"0")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td class="texto_cajas">AMALGAMAS</td>
          <td><?php e($form->input('TratamientosPaciente.amalgamas',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
          <td>RECUBRIMIENTO PULPAR</td>
          <td class="texto_cajas"><?php e($form->input('TratamientosPaciente.pulpotomia',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
          <td>ODONTOXESIS</td>
          <td><?php e($form->input('TratamientosPaciente.odontoxesis',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td>RESINAS</td>
          <td><?php e($form->input('TratamientosPaciente.resinas',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
          <td>OBTURACIÓN TEMPORAL</td>
          <td><?php e($form->input('TratamientosPaciente.obturacion',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
          <td>SELLADO-FOSETAS-FISURAS</td>
          <td><?php e($form->input('TratamientosPaciente.fosetas',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td>EXTRACCIONES</td>
          <td><?php e($form->input('TratamientosPaciente.extracciones',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
          <td>LASER POST.QUIRURGICO</td>
          <td><?php e($form->input('TratamientosPaciente.terapia_laser',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
          <td>REMOCION Q-M CARIES</td>
          <td><?php e($form->input('TratamientosPaciente.remocion_caries',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));?></td>
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
                            <th scope="col">AGREGAR</th>
                            <th scope="col">CANTIDAD</th>
                        </tr>
                        </thead>
                        <tbody bgcolor="#FFFFFF">
                        <?php
                        foreach($otrosServicios as $os)
                        {
                            e('<tr>');
                            e('<td>'.$os['OtrosServicios']['nombre_servicio'].'</td>');
                            e('<td>');
                            e($ajax->link('Agregar',array('controller' => 'HistorialPaciente', 'action' => 'OtroServicio/'.$os['OtrosServicios']['id_servicio']),array( 'update' => 'nuevoServicio_'.$os['OtrosServicios']['id_servicio'])));
                            e('</td>');
                            e('<td><div id="nuevoServicio_'.$os['OtrosServicios']['id_servicio'].'"></div></td>');
                            e('</tr>');
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </td>
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
                  $options = array('1' => ' BUENO','2' => ' RESERVADO', '3'=>' DESFAVORABLE');
                  $attributes = array('legend' => false,
                                      'value' => false,
                                     );
                  e($form->radio('TratamientosPaciente.pronostico',$options, $attributes));
              ?>
          </td>
        </tr>
        <tr class="texto_cajas">
          <td>Paciente referido a:</td>
          <td><?php e($form->input('TratamientosPaciente.referido_a',array("label"=>false,"type"=>"text","class"=>"texto_cajas", "size"=>"50")));?></td>
        </tr>
        <tr class="texto_cajas">
          <td><FONT COLOR="red">*</font> Paciente atendido por:</td>
          <td><?php e($form->input('TratamientosPaciente.atendido_por',array("label"=>false,"type"=>"text","class"=>"texto_cajas", "size"=>"50")));?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right"><?php e($form->submit("Registrar"));?></td>
        </tr>
    </table>
        </div> 
    </div>
    <div id="divCaptura"></div>
</div>
<?php 
e($form->end()); 

e($ajax->observeField('id_jornada',
    array("url"=>array("controller"=>"HistorialPaciente",
                       "action"=>"udm"
                       ),
          "update" => "divUDM"
         )
  ));

e($ajax->observeField('id_estado',
    array("url"=>array("controller"=>"HistorialPaciente",
                       "action"=>"municipios"
                       ),
          "update" => "divMunicipios"
         )
  ));



?>
<script type="text/javascript">
//<![CDATA[
  var cal = Calendar.setup({
      onSelect: function(cal) { cal.hide() },
      showTime: true
  });
  cal.manageFields("fecha","fecha",  "%Y-%m-%d");
  
//]]>
</script>
</div>
<div id="divCaptura"></div>