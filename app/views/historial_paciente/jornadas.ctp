<?php

/* 
 * #Autor: I.S.C Carlos López Ortíz.
 * #CYBERIA
 */
e($form->input('HistorialPaciente.id_jornada',array("id"=>"id_jornada","label"=>false,"type"=>"select","options"=>$Jornadas,"empty"=>"SELECCIONAR","class"=>"texto_cajas")));
e($ajax->observeField('id_jornada',
    array("url"=>array("controller"=>"HistorialPaciente",
                       "action"=>"udm"
                       ),
          "update" => "divUDM"
         )
  ));
?>