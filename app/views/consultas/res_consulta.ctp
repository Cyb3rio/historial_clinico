<?php
if($nm==false && count($Pacientes)>0){
?>
<div id="divConsulta">
<?php
    e($ajax->form(array("type"=>"post",
                        "options"=>array("model"=>"Consultas",
                        "update"=>"divConsulta",
                        "url"=>array("controller"=>'Consultas',"action"=>"resConsulta"),
                                        )
                       )
                 )
     );
    ?>
    <div align="center">
        <table id="box-table-b">
            <tr>
                <td>PALABRA CLAVE:</td>
                <td><?php e($form->input('Consulta.palabra_clave',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"30","maxLenght"=>"25")));?></td>
                <td><?php e($form->submit("Consultar"))?></td>
            </tr>
        </table>
    </div>
    <?php
    e($form->end());
    ?>
<?php
    //pr($Pacientes);exit();
//$paginator->options(array('update' => 'divConsulta', 'indicator' => 'spinner'));

$this->Paginator->options(array('update'=>'divConsulta',
                                'url'=>array('controller'=>'Consultas', 
                                             'action'=>'resConsulta'
                                            )
                               )
                         );
if(count($Pacientes)>0){
?>
    <br/>
    <div align="center">
        <table id="box-table-a" align='center'>
            <thead>
                <tr>
                    <th scope="col">FOLIO</th>
                    <th scope="col">PACIENTE</th>
                    <th scope="col">EDAD</th>
                    <th scope="col">GÉNERO</th>
                    <th scope="col">CIUDAD</th>
                    <th scope="col">LOCACLIDAD</th>
                    <th scope="col">FOTO</th>
                    
                    <th scope="col">DETALLE</th>
                    <th scope="col">H.C</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($Pacientes as $paciente)
                {
                    ?>
                <tr>
                        <td><?php e(strtoupper(utf8_encode($paciente['Consultas']['folio'])));?></td>
                        <td vertical-align="middle"><?php e(strtoupper(utf8_encode($paciente['Consultas']['pae_nombre'])));?></td>
                        <td vertical-align="middle"><?php e(strtoupper(utf8_encode($paciente['Consultas']['pae_edad'])));?></td>
                        <td vertical-align="middle"><?php 
                                $sexo = ($paciente['Consultas']['pae_sexo']==1)? 'MASCULINO' : 'FEMENINO';
                                e($sexo);
                            ?>
                        </td>
                        <td><?php e(strtoupper(utf8_encode($paciente['Consultas']['cid_descripcion'])));?></td>
                        <td><?php e(strtoupper(utf8_encode($paciente['Consultas']['aso_descripcion'])));?></td>
                        <td><?php e($html->image("../files/fotos_paciente/".$paciente['Consultas']['folio']."/".$paciente['Consultas']['folio'].".jpg",array("width"=>"80","height"=>"60")));?></td>
                        <td><a href="<?php e($this->webroot.'Consultas/detalle/'.$paciente['Consultas']['id_historial'])?>"><?php e($html->image('agenda.png',array("width"=>"32","height"=>"32"))); ?></a></td>
                        <td><a href="<?php e($this->webroot.'HistorialPaciente/hclinica/'.$paciente['Consultas']['folio'])?>" target="_blank"><?php e($html->image('pdf.png',array("width"=>"32","height"=>"32"))); ?></a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
</div>
    <div align="center" class="pagination"> 
<!-- Muestra los números de página -->
<?php e($paginator->numbers()); ?>
<!-- Muestra los enlaces para Anterior y Siguiente -->
<?php
    
    e($paginator->prev('« Anterior ', null, null, array('class' => 'disabled')));
    e($paginator->next(' Siguiente »', null, null, array('class' => 'disabled')));
?>
<!-- Muestra X de Y, donde X es la página actual e Y el total del páginas -->
<?php e($paginator->counter(array('format' => 'Página %page% de %pages%'))); ?>
</div>
<?php
}
?>
</div>
<?php
}