<?php

/* 
 * #Autor: I.S.C Carlos López Ortíz.
 * #CYBERIA
 */
e($form->input('HistorialPaciente.id_asentamiento',array("id"=>"id_asentamiento","label"=>false,"type"=>"select","options"=>$Asentamientos,"empty"=>"SELECCIONAR","class"=>"texto_cajas")));
/*e($ajax->observeField('id_asentamiento',
    array("url"=>array("controller"=>"HistorialPaciente",
                       "action"=>"muestraJornadas"
                       ),
          "update" => "divJornadas"
         )
  ));*/
?>