<?php

/* 
 * #Autor: I.S.C Carlos López Ortíz.
 * #CYBERIA
 */
e($form->input('HistorialPaciente.id_municipio',array("id"=>"id_municipio","label"=>false,"type"=>"select","options"=>$Municipios,"empty"=>"SELECCIONAR","class"=>"texto_cajas")));
e($ajax->observeField('id_municipio',
    array("url"=>array("controller"=>"HistorialPaciente",
                       "action"=>"ciudades"
                       ),
          "update" => "divCiudades",
         // "complete" => "alert('ajaxPatita')"
         )
  ));
