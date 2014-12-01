<?php
e($ajax->form(array("type"=>"post",
                    "options"=>array("model"=>"HistorialPaciente",
                    "update"=>"divCaptura",
                    
                    "url"=>array("controller"=>'Consultas',"action"=>"guardaHistorial"),
			            )
                   )
             )
 );

e($form->input('HistorialPaciente.id_historial',array("label"=>false,"type"=>"hidden")));
//pr($this->data);
?>
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
            <table width="100%" border="1">
                <tr  class="texto_cajas">
                    <td colspan="6" align="right"><b><FONT COLOR="red">*</font> FOLIO&nbsp;</b></td>
                    <td><b><FONT COLOR="red"><?php e($this->data['HistorialPaciente']['folio']);?></font></b></td>
                </tr>
  <tr class="texto_cajas">
    <td colspan="2"><b>ESTADO</b></td>
    <td colspan="3"><b>MUNICIPIO</b></td>
    <td align="right"><b>FECHA&nbsp;</b></td>
    <td><?php e($this->data['HistorialPaciente']['fecha']);?></td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2"><?php e($this->data['HistorialPaciente']['nombre_estado']);?></td>
    <td colspan="5"><div id="divMunicipios"><?php e($this->data['HistorialPaciente']['muo_descripcion']);?></div></td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2"><b>CIUDAD</td>
    <td colspan="3"><b>LOCALIDAD</b></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="texto_cajas">
      <td colspan="2"><div id="divCiudades"><?php e($this->data['HistorialPaciente']['cid_descripcion']);?></div></td>
      <td colspan="5"><div id="divAsentamientos"><?php e($this->data['HistorialPaciente']['aso_descripcion']);?></div></td>
  </tr>
  
  <tr class="texto_cajas">
      <td colspan="7"><div id='divUDM'><?php e(utf8_encode($this->data['HistorialPaciente']['umo_descripcion']));?></div></td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="2"><b>NOMBRE PACIENTE</td>
    <td width="4%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="13%"><b>EDAD</b></td>
    <td width="37%"><b>GÉNERO</b></td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="5"><?php e($form->input('HistorialPaciente.pae_nombre',array("label"=>false,"type"=>"text","size"=>"50","class"=>"texto_cajas")));?></td>
    <td><?php e($form->input('HistorialPaciente.pae_edad',array("label"=>false,"type"=>"text","size"=>"3","class"=>"texto_cajas","onkeydown"=>"javascript:return validanumeros(event)")));?></td>
    <td><?php e($form->input('HistorialPaciente.pae_sexo',array("id"=>"pae_sexo","label"=>false,"type"=>"select","options"=>array("1"=>"M","2"=>"F"),"empty"=>"","class"=>"texto_cajas")));?></td>
  </tr>
  <tr class="texto_cajas">
    <td width="15%"><b>DOMICILIO</b></td>
    <td width="19%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b>TELÉFONO</b></td>
    <td><?php e($form->input('HistorialPaciente.pae_telefono',array("label"=>false,"type"=>"text","class"=>"texto_cajas")));?></td>
  </tr>
  <tr class="texto_cajas">
    <td colspan="7"><?php e($form->input('HistorialPaciente.pae_direccion',array("label"=>false,"type"=>"textArea","class"=>"texto_cajas","rows"=>"3")));?></td>
    
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
                                'value' => $this->data['HistorialPaciente']['hospitalizado'],
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
                                'value' =>  $this->data['HistorialPaciente']['tratamiento_medico'],
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
                                'value' => $this->data['HistorialPaciente']['tomado_medicamento'],
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
                                'value' => $this->data['HistorialPaciente']['alergico_medicamento'],
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
                                'value' => $this->data['HistorialPaciente']['hemorragia'],
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
        <td width="2%"><?php e($form->checkbox('cardiacos',array("checked"=>$this->data['HistorialPaciente']['cardiacos'])));?></td>
        <td width="5%">&nbsp;</td>
        <td width="26%">TRANSTORNOS PSQUIAT</td>
        <td width="2%"><?php e($form->checkbox('transtornos_psiche',array("checked"=>$this->data['HistorialPaciente']['transtornos_psiche'])));?></td>
        <td width="5%">&nbsp;</td>
        <td width="25%">ÚLCERAS GÁSTRICAS</td>
        <td width="4%"><?php e($form->checkbox('ulceras',array("checked"=>$this->data['HistorialPaciente']['ulceras'])));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>PRESIÓN ARTERIAL ALTA</td>
        <td><?php e($form->checkbox('presion_alta',array("checked"=>$this->data['HistorialPaciente']['presion_alta'])));?></td>
        <td>&nbsp;</td>
        <td>ASMA</td>
        <td><?php e($form->checkbox('asma',array("checked"=>$this->data['HistorialPaciente']['asma'])));?></td>
        <td>&nbsp;</td>
        <td>HERNIA HIATAL</td>
        <td><?php e($form->checkbox('hernia',array("checked"=>$this->data['HistorialPaciente']['hernia'])));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>PRESIÓN ARTERIAL BAJA</td>
        <td><?php e($form->checkbox('presion_baja',array("checked"=>$this->data['HistorialPaciente']['presion_baja'])));?></td>
        <td>&nbsp;</td>
        <td>ASFIXIA</td>
        <td><?php e($form->checkbox('asfixia',array("checked"=>$this->data['HistorialPaciente']['asfixia'])));?></td>
        <td>&nbsp;</td>
        <td>HEPTATITIS</td>
        <td><?php e($form->checkbox('hepatitis',array("checked"=>$this->data['HistorialPaciente']['hepatitis'])));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>ANEMIA</td>
        <td><?php e($form->checkbox('anemia',array("checked"=>$this->data['HistorialPaciente']['anemia'])));?></td>
        <td>&nbsp;</td>
        <td>TUBERCULOSIS</td>
        <td><?php e($form->checkbox('tuberculosis',array("checked"=>$this->data['HistorialPaciente']['tuberculosis'])));?></td>
        <td>&nbsp;</td>
        <td>CIRROSIS HEPÁTICA</td>
        <td><?php e($form->checkbox('cirrosis',array("checked"=>$this->data['HistorialPaciente']['cirrosis'])));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>FIEBRE REUMÁTICA</td>
        <td><?php e($form->checkbox('fiebre_reumatica',array("checked"=>$this->data['HistorialPaciente']['fiebre_reumatica'])));?></td>
        <td>&nbsp;</td>
        <td>GASTRITIS</td>
        <td><?php e($form->checkbox('gastritis',array("checked"=>$this->data['HistorialPaciente']['gastritis'])));?></td>
        <td>&nbsp;</td>
        <td>DIABETES</td>
        <td><?php e($form->checkbox('diabetes',array("checked"=>$this->data['HistorialPaciente']['diabetes'])));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>ARTRITIS / REUMATISMO</td>
        <td><?php e($form->checkbox('artitis_reumatismo',array("checked"=>$this->data['HistorialPaciente']['artitis_reumatismo'])));?></td>
        <td>&nbsp;</td>
        <td>DESMAYOS</td>
        <td><?php e($form->checkbox('desmayos',array("checked"=>$this->data['HistorialPaciente']['desmayos'])));?></td>
        <td>&nbsp;</td>
        <td>ENFERM. RIÑONES</td>
        <td><?php e($form->checkbox('rinhon',array("checked"=>$this->data['HistorialPaciente']['rinhon'])));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>ATAQUES / CONVULSIONES</td>
        <td><?php e($form->checkbox('ataques_convulsiones',array("checked"=>$this->data['HistorialPaciente']['ataques_convulsiones'])));?></td>
        <td>&nbsp;</td>
        <td>CANCER</td>
        <td><?php e($form->checkbox('cancer',array("checked"=>$this->data['HistorialPaciente']['cancer'])));?></td>
        <td>&nbsp;</td>
        <td>EPILEPSIA</td>
        <td><?php e($form->checkbox('epilepsia',array("checked"=>$this->data['HistorialPaciente']['epilepsia'])));?></td>
      </tr>
      <tr class="texto_cajas">
        <td>&nbsp;</td>
        <td>OSTEOPOROSIS</td>
        <td><?php e($form->checkbox('osteoporosis',array("checked"=>$this->data['HistorialPaciente']['osteoporosis'])));?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>SIDA</td>
        <td><?php e($form->checkbox('sida',array("checked"=>$this->data['HistorialPaciente']['sida'])));?></td>
      </tr>
    </table></td>
  </tr>
  <tr class="texto_cajas">
    <td>7.-</td>
    <td colspan="2">¿Padece alguna enfermedad importante?</td>
    <td colspan="5"><?php 
            $options = array('1' => ' SI','0' => ' NO');
            $attributes = array('legend' => false,
                                'value' => $this->data['HistorialPaciente']['otra_enfermedad'],
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
      <td><b>DESORGANIZADA</b></td>
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
                                'value' => $this->data['HistorialPaciente']['higiene_oral'],
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
                                'value' => $this->data['HistorialPaciente']['oclusion'],
                               );
            e($form->radio('oclusion',$options, $attributes));
        ?>
    </td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
        
        </div>
        <div id="view4" style="text-align: center"><?php echo $html->image("odontograma.jpg",array("width"=>"75%", "height"=>"75%"));?></div> 
        
        
        
        <div id="view5">
        <?php
        /*
         * INCLUIR COMBO TRATAMIENTOS, IMPLEMENTAR AJAX PARA MOSTRAR TRATAMIENTOS
        */
        ?>
        <table width="100%" border="0">
            <tr class="texto_cajas">
                <td ><b>SELECCIONAR TRATAMIENTO</b></td>
                <td >
                    <?php
                        $Tratamientos['00']='NUEVO';
                        e($form->input('HistorialPaciente.id_tratamiento',
                            array("id"=>"id_tratamiento",
                                  "label"=>false,
                                  "type"=>"select",
                                  "options"=>$Tratamientos,
                                  "empty"=>"SELECCIONAR",
                                  "class"=>"texto_cajas"
                                 )
                          )
                        );
                    ?>
                </td>
            </tr>
            
        </table>
        <div id="divTratamiento">
            <div align="right"><?php e($form->submit("Actualizar"));?></div>
        </div> 
    </div>
    </div>
    <div id="divCaptura"></div>
</div>
<?php
e($ajax->observeField('id_tratamiento',
    array("url"=>array("controller"=>"Consultas",
                       "action"=>"muestraTratamiento"
                       ),
          "update" => "divTratamiento"
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