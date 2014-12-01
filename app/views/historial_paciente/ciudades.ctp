<?php

/* 
 * #Autor: I.S.C Carlos López Ortíz.
 * #CYBERIA
 */
e($form->input('HistorialPaciente.id_ciudad',array("id"=>"id_ciudad","label"=>false,"type"=>"select","options"=>$Ciudades,"empty"=>"SELECCIONAR","class"=>"texto_cajas")));
e($ajax->observeField('id_ciudad',
    array("url"=>array("controller"=>"HistorialPaciente",
                       "action"=>"asentamientos"
                       ),
          "update" => "divAsentamientos",
         )
  ));