<?php
class ConsultasController extends AppController
{
    var $name = 'Consultas';
    var $helpers = array('Html', 'Form', 'Ajax', 'JavaScript', 'Js');
    var $components = array('RequestHandler','Session');
    var $uses = array("Consultas","HistorialPaciente","TratamientosPaciente","OtrosServicios","OtrosServiciosPaciente");
    
    var $paginate = array('limit' => 4,
                          'order' => array('Consultas.pae_nombre' => 'asc')
                         );
    
    function index()
    {
        $_SESSION['current'] = 'consulta';
        $_SESSION['pclave'] = '';
    }
    
    function resConsulta()
    {
        //NO PERDER CONSLTA Y FUNCIONE PAGINACION
        if($this->data['Consulta']['palabra_clave']!='')
        {
             $_SESSION['pclave'] = $this->data['Consulta']['palabra_clave'];
        }
        if($_SESSION['pclave']!='')
        {
          $this->data['Consulta']['palabra_clave'] =   $_SESSION['pclave'];
        }
        //NO PERDER CONSLTA Y FUNCIONE PAGINACION
        
        if($this->data['Consulta']['palabra_clave']!='')
        { 
            $_SESSION['pclave'] = $this->data['Consulta']['palabra_clave'];
            $busqueda = explode(" ",$this->data['Consulta']['palabra_clave']);
            $arrOR = array();
            $filtro = '';
            foreach($busqueda as $palabra)
            {
                $filtro = "Consultas.folio LIKE '%$palabra%' OR ";
                $filtro.= "Consultas.nombre_estado LIKE '%$palabra%' OR ";
                $filtro.= "Consultas.muo_descripcion LIKE '%$palabra%' OR ";
                $filtro.= "Consultas.cid_descripcion LIKE '%$palabra%' OR ";
                $filtro.= "Consultas.aso_descripcion LIKE '%$palabra%'  OR ";
                //$filtro.= "Consultas.umo_descripcion LIKE '%$palabra%'  OR ";
                $filtro.= "Consultas.pae_nombre LIKE '%$palabra%'  OR ";
                if(is_numeric($palabra))
                {
                    $filtro.= "Consultas.pae_edad = $palabra  OR ";
                }
                
                $filtro.= "Consultas.pae_telefono LIKE '%$palabra%'";
                
                array_push($arrOR, array($filtro));
            }
            if($this->data['Consulta']['palabra_clave']!='')
            { 
                foreach ($arrOR as $arrPalabra)
                {
                    $conditions = array('OR' =>$arrOR);
                
                }
                $conditions = ($this->data['Consulta']['palabra_clave']=='*') ? array() : $conditions;
                
                $data = $this->paginate('Consultas',$conditions);
                $this->helpers['Paginator'] = array('ajax' => 'Ajax');
                $this->set(compact('Pacientes'));
                if(count($data)>0)
                {
                    $this->set("Pacientes",$data);
                    $this->set("nm",false);
                }else
                    {
                        $this->set("Pacientes",array());
                        $this->set("nm",true);
                        e('<div class="warning">NO SE HAN ENCONTRADO COINCIDENCIAS</div>');
                        $this->set("Pacientes",array());
                        $this->render("index");
                    }
            }else
                {
                    $this->set("nm",false);
                    $this->set("Pacientes",array());
                }
        }else
                {
                    $this->set("nm",false);
                    e('<div class="warning">NO SE HAN ENCONTRADO COINCIDENCIAS</div>');
                    $this->set("Pacientes",array());
                    $this->render("index");

                }
    }
    
    function detalle($id_historial=null)
    {
        $this->Consultas->id = $id_historial;
        $this->data = $this->Consultas->read();
        
        $this->data['HistorialPaciente'] = $this->data['Consultas'];
        //pr($this->data);
        
        $Tratamientos = $this->TratamientosPaciente->find("list",array("fields"=>array("id_tratamiento","atendido_por"),"conditions"=>array("id_paciente"=>$id_historial)));
        $x=1;
        $TratamientosAlterados = array();
        foreach ($Tratamientos as $id=>$tratamiento)
        {
            $TratamientosAlterados[$id] = 'TRATAMIENTO '.$x.' ['.$tratamiento.']';
            $x++;
        }
        $this->set("Tratamientos",$TratamientosAlterados);
    }
    
    function muestraTratamiento()
    {
        //e($this->data['HistorialPaciente']['id_tratamiento']);
        //pr($this->data);exit();
        if($this->data['HistorialPaciente']['id_tratamiento']=='')
        {
            e('<div class="warning">DEBE SELECCIONAR UN TRATAMIENTO</div>');
            exit();
        }else
            {
                if($this->data['HistorialPaciente']['id_tratamiento']!='00')
                {
                    $this->TratamientosPaciente->id = $this->data['HistorialPaciente']['id_tratamiento'];
                    $this->data = $this->TratamientosPaciente->read();
        
                    $mySQL = (" SELECT osp.id_x, nombre_servicio, cantidad, osp.id_tratamiento, osp.id_municipio "
                             ." FROM otros_servicios_paciente AS osp " 
                             ." INNER JOIN otros_servicios AS os ON osp.id_servicio = os.id_servicio"
                             ." WHERE osp.id_tratamiento = ".$this->data['TratamientosPaciente']['id_tratamiento']
                             );
                   $OSP = $this->OtrosServiciosPaciente->query($mySQL);
                   $OtrosServiciosPaciente = array();
                   foreach($OSP as $k=>$os)
                   {
                      $OtrosServiciosPaciente[$k]['id_x'] = $os['osp']['id_x']; 
                      $OtrosServiciosPaciente[$k]['id_tratamiento'] = $os['osp']['id_tratamiento']; 
                      $OtrosServiciosPaciente[$k]['id_municipio'] = $os['osp']['id_municipio']; 
                      $OtrosServiciosPaciente[$k]['nombre_servicio'] = $os['os']['nombre_servicio']; 
                      $OtrosServiciosPaciente[$k]['cantidad'] = $os['osp']['cantidad'];
                   }
                   $this->data['OtrosServiciosPaciente']=$OtrosServiciosPaciente;
                    
                }else
                    {
                        pr($this->data);
                    }
            }
        $this->render("tratamiento","ajax");
    }
    
    function guardaHistorial()
    {
        $HistorialPaciente = array_map("strtoupper",$this->data['HistorialPaciente']);
        //pr($this->data);exit();
        $this->HistorialPaciente->set($HistorialPaciente);
        if($this->HistorialPaciente->save())
        {
            e('<div class="success">HISTORIA CLÍNICA DEL PACIENTE <b>'.$HistorialPaciente['pae_nombre'].'</b> ACTUALIZADA</div>');
            if(isset($this->data['TratamientosPaciente']))
            {
                $this->data['TratamientosPaciente']['id_paciente'] = $this->data['HistorialPaciente']['id_historial'];
                $this->data['TratamientosPaciente']['fecha'] = date("Y-m-d"); 
                $TratamientosPaciente = array_map("strtoupper",$this->data['TratamientosPaciente']);
                $this->TratamientosPaciente->set($TratamientosPaciente);
                if($this->TratamientosPaciente->save())
                {
                    e('<div class="success">TRATAMIENTO(S) DEL PACIENTE <b>'.$HistorialPaciente['pae_nombre'].'</b> SE HA(N) ACTUALIZADO</div>');
                }
            }
            
            if(isset($this->data['OtrosServiciosPaciente']))
            {
                $this->OtrosServiciosPaciente->set($this->data['OtrosServiciosPaciente']);
                if($this->OtrosServiciosPaciente->saveAll())
                {
                    e('<div class="success">OTROS SERVICIOS DEL PACIENTE <b>'.$HistorialPaciente['pae_nombre'].'</b> SE HA(N) ACTUALIZADO</div>');
                }
            }
                $log = $this->TratamientosPaciente->getDataSource()->getLog(false, false);
                //debug($log);
                //GENERA ARCHIVO ACTUALIZACIONES DE PACIENTES
                $path= "/localhost/www/historial_clinico/app/webroot/files/import";
                $filename= "PACIENTES_ACT-".date("d.m.y")."-".$_SESSION['Auth']['User']['username'].".udm";
                //if($_SESSION['Auth']['User']['id']!=0)
                //{
                     $ar=fopen($path."/".$filename,"a") or die("Ocurrió un error al crear el archivo");
                     foreach($log['log'] as $sql)
                     {
                        $query = substr($sql['query'], 0, 6);
                        if($query=='UPDATE')
                        {
                             fputs($ar,$sql['query'].";");
                             fputs($ar,"\n");
                        }
                         
                        $query = substr($sql['query'], 0, 11);
                        if($query=='INSERT INTO')
                        {
                             fputs($ar,$sql['query'].";");
                             fputs($ar,"\n");
                        }
                     }
                     fclose($ar);
                //}
                exit();

        }else
            {
                e('<div class="warning">HA OCURRIDO UN ERROR AL ACTUALIZAR LOS DATOS DEL PACIENTE</div>');
                    //$this->redirect("Consultas/detalle/".$this->data['HistorialPaciente']['id_historial']);
                    exit();
            }
            exit();
    }
    
    function reporteGeneral()
    {
        $_SESSION['current'] = 'reporte';
    }
    
    function reportePacientes()
    {
        Configure::write('debug', 0);
        $this->layout = 'xls';
        
        //SQL REPORTE GENERAL POR RANGO DE FECHAS
        $fecha_ini = $this->data['TratamientoPaciente']['fecha_ini'];
        $fecha_fin = $this->data['TratamientoPaciente']['fecha_fin'];
        $WHERE='';
        $WHERE_OSP ='';
        if(($fecha_ini!='' &&  $fecha_fin!='') ||($fecha_fin < $fecha_ini) )
        {
            $WHERE = " WHERE tp.fecha between '$fecha_ini' AND '$fecha_fin'";
            $WHERE_OSP = " WHERE fecha between '$fecha_ini' AND '$fecha_fin'";
        }
        $mySQL =" SELECT id_municipio,COUNT(folio) AS cuantos,(SELECT muo_descripcion FROM municipio WHERE municipio_pk = tp.id_municipio) AS municipio, "
               ." SUM(profilaxis) AS profilaxis, SUM(fluor) AS fluor,SUM(fosetas) AS fosetas, SUM(amalgamas) AS amalgamas,"
               ." SUM(resinas) AS resinas, SUM(odontoxesis) AS odontoxesis,SUM(farmacoterapia) AS farmacoterapia,"
               ." SUM(pulpotomia) AS pulpotomia,SUM(obturacion) AS obturacion,SUM(extracciones) AS extracciones,SUM(terapia_laser) AS terapia_laser,SUM(remocion_caries) AS remocion_caries "
               ." FROM `tratamientos_paciente` AS tp"
               ." $WHERE "
               ." GROUP BY id_municipio";
        $ReporteGeneral = $this->HistorialPaciente->query($mySQL);
                
        $mySQL_osp = "SELECT `osp`.`id_municipio`, `os`.`nombre_servicio`, "
                    ." SUM( `osp`.`cantidad` ) AS cantidad, COUNT( `osp`.`cantidad` ) AS cuantos "
                    ." FROM `otros_servicios_paciente` AS `osp` "
                    ." INNER JOIN `otros_servicios` AS `os` ON `osp`.`id_servicio` = `os`.`id_servicio` "
                    ." $WHERE_OSP "
                    ." GROUP BY `osp`.`id_municipio` , `osp`.`id_servicio` ";
        
        $ReporteGeneral_osp = $this->HistorialPaciente->query($mySQL_osp);
        
        $ReporteGeneral_aux = $ReporteGeneral;
        $otrosTD = array();
        $x=1;
        
        foreach($ReporteGeneral as $k=>$rp)
        {
            $id_municipio = $rp['tp']['id_municipio'];   
            foreach($ReporteGeneral_osp as $rp_o)
            {
                if($rp_o['osp']['id_municipio']==$id_municipio)
                {
                    $ReporteGeneral_aux[$k][0][$rp_o['os']['nombre_servicio']] = $rp_o[0]['cantidad']; 
                    array_push($otrosTD, $rp_o['os']['nombre_servicio']);
                }else
                    {
                        if(!isset($ReporteGeneral_aux[$k][0][$rp_o['os']['nombre_servicio']]))
                        {
                            $ReporteGeneral_aux[$k][0][$rp_o['os']['nombre_servicio']] = 0;
                        }
                    }
                    
            }
        }
        
        $otrosTD = array_unique($otrosTD);
        $html ='<table>'
         .'<tr>'
         .'<td>MUNICIPIO</td>'
         .'<td>TOTAL PACIENTES ATENDIDOS</td>'
         .'<td>TOTAL ACCIONES DENTALES</td>'
         .'<td>PROFILAXIS</td>'
         .'<td>APLICACI&Oacute;N DE FLOUR</td>'
         .'<td>FOSETAS Y FISURAS</td>'
         .'<td>AMALGAMAS</td>'
         .'<td>RESINAS</td>'
         .'<td>FARMACOTERAPIA</td>'
         .'<td>PULPOTOMIA</td>'
         .'<td>OBTURACION CON IONOMERO DE VIDRIO</td>'
         .'<td>EXTRACIONES DENTALES</td>'
         .'<td>TERAPIA DE LASER</td>'
         .'<td>REMOCION QUIM-MEC DE CARIES</td>';
        foreach ($otrosTD as $otd)
        {
            $html.='<td>'.$otd.'</td>';
        }
        
        $html.='</tr>';
        
        foreach($ReporteGeneral_aux as $rg)
        {
            $ax=0;
            $html.='<tr>'
                 .'<td>'.$rg[0]['municipio'].'</td>'
                 .'<td>'.$rg[0]['cuantos'].'</td>';
                
                   
            $ax = $rg[0]['profilaxis']+$rg[0]['fluor']+$rg[0]['fosetas']+$rg[0]['amalgamas']+$rg[0]['resinas']
                 +$rg[0]['farmacoterapia']+$rg[0]['pulpotomia']+$rg[0]['obturacion']+$rg[0]['extracciones']
                 +$rg[0]['terapia_laser']+$rg[0]['remocion_caries'];
            
            foreach ($otrosTD as $otd)
            {
                $ax+=$rg[0][$otd];
            }
            
            $html.='<td>'.$ax.'</td>'
                 .'<td>'.$rg[0]['profilaxis'].'</td>'
                 .'<td>'.$rg[0]['fluor'].'</td>'
                 .'<td>'.$rg[0]['fosetas'].'</td>'
                 .'<td>'.$rg[0]['amalgamas'].'</td>'
                 .'<td>'.$rg[0]['resinas'].'</td>'
                 .'<td>'.$rg[0]['farmacoterapia'].'</td>'
                 .'<td>'.$rg[0]['pulpotomia'].'</td>'
                 .'<td>'.$rg[0]['obturacion'].'</td>'
                 .'<td>'.$rg[0]['extracciones'].'</td>'
                 .'<td>'.$rg[0]['terapia_laser'].'</td>'
                 .'<td>'.$rg[0]['remocion_caries'].'</td>';
            
            foreach ($otrosTD as $otd)
            {
                $html.='<td>'.$rg[0][$otd].'</td>';
            }
            $html.='</tr>';         
        }
        //e($html);exit();
        $this->set("html",$html);
    }
    
    function reporteResumen()
    {
        
    }
}