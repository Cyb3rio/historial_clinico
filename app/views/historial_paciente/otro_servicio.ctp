<?php
    e($form->input('OtrosServiciosPaciente.'.$_SESSION['x'].'.cantidad',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"1","maxLength"=>"2","onkeydown"=>"javascript:return validanumeros(event)","onFocus"=>"this.select()","placeHolder"=>"0")));
    e($form->input('OtrosServiciosPaciente.'.$_SESSION['x'].'.folio',array("label"=>false,"type"=>"hidden","value"=>$_SESSION['folio'])));
    e($form->input('OtrosServiciosPaciente.'.$_SESSION['x'].'.id_servicio',array("label"=>false,"type"=>"hidden","value"=>$id_servicio)));
    e($form->input('OtrosServiciosPaciente.'.$_SESSION['x'].'.id_municipio',array("label"=>false,"type"=>"hidden","value"=>$id_municipio)));
    e($form->input('OtrosServiciosPaciente.'.$_SESSION['x'].'.fecha',array("label"=>false,"type"=>"hidden","value"=>date("Y-m-d"))));