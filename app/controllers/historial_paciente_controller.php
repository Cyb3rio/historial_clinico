<?php
class HistorialPacienteController extends AppController
{
    var $name = 'HistorialPaciente';
    var $helpers = array('Html','Form','Ajax','JavaScript','Js','Pdf');
    var $components = array('RequestHandler','Session');
    var $uses = array("Asentamiento","Ciudad","Estado","Municipio","User","TratamientosPaciente",
                      "HistorialPaciente","OtrosServicios","OtrosServiciosPaciente","Consultas");
    
    function index(){}

    function generaFolio()
    {
        $ID = $_SESSION['Auth']['User']['id'];
        $mySQL='SELECT MAX(folio) as folio FROM historial_paciente WHERE folio LIKE "UDM'.$ID.'%"';
        $maxFolio = $this->HistorialPaciente->query($mySQL);
        $mFolio = substr( $maxFolio[0][0]['folio'],7,6);
        $mFolio+=1;
        $folio = "UDM".$_SESSION['Auth']['User']['id']."-HC".str_pad($mFolio, 6, "0", STR_PAD_LEFT);
        $_SESSION['folio']=$folio;
        
        //GENERAR ARRAY PARA PACIENTES.ZIP
        $path= "files/fotos_paciente/";
        if(!isset($_SESSION['imagen_paciente']))
        {
            $_SESSION['imagen_paciente'] = array();
        }
        array_push($_SESSION['imagen_paciente'], $path.$_SESSION['folio'].'/'.$_SESSION['folio'].'.jpg');
        //pr($_SESSION['imagen_paciente']);
        return $folio;
    }
    
    function captura()
    {
        $_SESSION['current'] = 'captura';
        //ESTADO
        $Estados = $this->Estado->find("list",array("fields"=>array("id_estado","nombre_estado"),"order"=>"nombre_estado"));
        $EstadosAlterados=array();
        foreach($Estados as $id_estado=>$data)
        {
            $EstadosAlterados[$id_estado]=  utf8_encode(strtoupper($data));
        }
        $this->set("Estados",$EstadosAlterados);
        $this->set("jornadas",array());
        $folio = $this->generaFolio();
        $_SESSION['folio'] = $folio;
        unset($_SESSION['x']);
        $this->data['HistorialPaciente']['folio']=$folio;
        $this->set("otrosServicios",$this->OtrosServicios->find("all",array("fields"=>array("id_servicio","nombre_servicio"),"order"=>"nombre_servicio")));
        
    }
    
    function udm()
    {
        $unidades = $this->HistorialPaciente->query("SELECT joa_unidades FROM jornada WHERE jornada_pk = ".$this->data['HistorialPaciente']['id_jornada']);
        $udm = $this->HistorialPaciente->query(" SELECT unidad_pk,umo_descripcion FROM unidad_movil WHERE unidad_pk IN(".$unidades[0]['jornada']['joa_unidades'].")");
        $UDM = array();
        foreach($udm as $data)
        {
            $UDM[$data['unidad_movil']['unidad_pk']] =  utf8_encode($data['unidad_movil']['umo_descripcion']);
        }
        $this->set("UDM",$UDM);
        $this->render("udm","ajax");
    }    
    
    function municipios()
    {
        $_SESSION['id_estado'] = $this->data['HistorialPaciente']['id_estado'];
        $conditions = array("id_estado"=>  $this->data['HistorialPaciente']['id_estado']);
        $Municipios = $this->Municipio->find("list",array("fields"=>array("municipio_pk","muo_descripcion"),"conditions"=>$conditions,"order"=>"muo_descripcion"));
        $MunicipiosAlterados=array();
        foreach($Municipios as $id_municipio=>$data)
        {
            $MunicipiosAlterados[$id_municipio]=  utf8_encode(strtoupper($data));
        }
        $this->set("Municipios",$MunicipiosAlterados);
        $this->render("municipios","ajax");
    }
    
    function ciudades()
    {
        $_SESSION['id_municipio'] = $this->data['HistorialPaciente']['id_municipio'];
        $this->data['TratamientosPaciente']['id_municipio'] = $this->data['HistorialPaciente']['id_municipio'];
        
        if($_SESSION['id_estado']==30){
            
            $Rangos = $this->HistorialPaciente->query("SELECT muo_rango1, muo_rango2 FROM municipio WHERE municipio_pk =".
                                            $this->data['HistorialPaciente']['id_municipio']);
            $rango1 = $Rangos[0]['municipio']['muo_rango1'];
            $rango2 = $Rangos[0]['municipio']['muo_rango2'];
            $mySQL =" SELECT ciudad_pk, cid_descripcion " 
                   ." FROM ciudad "
                   ." WHERE cid_rango1 >= $rango1 AND cid_rango2 <= $rango2 "
                   ." ORDER BY cid_descripcion";
            
        }else{
            
            $mySQL=" SELECT ciudad_pk, cid_descripcion " 
                  ." FROM ciudad "
                  ." WHERE cidmuo_fk = ".$this->data['HistorialPaciente']['id_municipio']
                  ." ORDER BY cid_descripcion ";
		
        }
        $Ciudades = $this->HistorialPaciente->query($mySQL);
        $CiudadesAlteradas =array();
        foreach($Ciudades as $ciudad)
        {
            $CiudadesAlteradas[$ciudad['ciudad']['ciudad_pk']]=  utf8_encode(strtoupper($ciudad['ciudad']['cid_descripcion']));
        }
        $this->set("Ciudades",$CiudadesAlteradas);
        
        $this->render("ciudades","ajax");
    }
    
    function asentamientos()
    {
        $_SESSION['id_ciudad'] = $this->data['HistorialPaciente']['id_ciudad'];
        $id_estado   = $_SESSION['id_estado'];
        $id_municipio = $_SESSION['id_municipio'];
        $id_ciudad = $this->data['HistorialPaciente']['id_ciudad'];
        
        if($id_estado == 30)
        {
            $mySQL =" SELECT muo_rango1, muo_rango2 "
                   ." FROM municipio "
                   ." WHERE municipio_pk = $id_municipio ";
            $Rangos = $this->HistorialPaciente->query($mySQL);
            $rango1 = $Rangos[0]['municipio']['muo_rango1']; 
            $rango2 = $Rangos[0]['municipio']['muo_rango2'];
            if($id_ciudad>=1)
            {
                $sqlciudad  = " AND  asocid_fk = $id_ciudad ";
            }
            else
            {
                $sqlciudad =" AND asocid_fk IS NULL ";
            }
                $mySQL = "SELECT asentamiento_pk,
                        aso_descripcion
                        FROM asentamiento			
                        WHERE aso_codigo >= $rango1 AND aso_codigo <= $rango2 			
                        $sqlciudad
                        ORDER BY aso_descripcion
                        ";
        }else{
                $sqlciudad = ($id_ciudad==0) ? " asocid_fk IS NULL AND asomuo_fk = $id_municipio " :  " asocid_fk = $id_ciudad ";
                $mySQL = "SELECT asentamiento_pk,
                        aso_descripcion
                        FROM asentamiento			
                        WHERE $sqlciudad
                        ORDER BY aso_descripcion ";
            }
        $Asentamientos = $this->HistorialPaciente->query($mySQL);
        $AsentamientosAlterados =array();
        foreach($Asentamientos as $asentamiento)
        {
            $AsentamientosAlterados[$asentamiento['asentamiento']['asentamiento_pk']]=  utf8_encode(strtoupper($asentamiento['asentamiento']['aso_descripcion']));
        }
        $this->set("Asentamientos",$AsentamientosAlterados);
        $this->render("asentamientos","ajax");
    }
        
    function muestraJornadas()
    {
        //JORNADAS
         
        $sql = $this->HistorialPaciente->query("SELECT 	jornada_pk, CONCAT_WS(' ',aso_descripcion,joa_fechainicio,' al ', joa_fechafin,
                                                        IF((joa_tipo=1), 'NORMAL', 'EXTRAORDINARIA')
                                                        ) as jornada
                                                FROM jornada
                                                JOIN municipio ON joamuo_fk = municipio_pk
                                                LEFT JOIN ciudad ON joacid_fk = ciudad_pk 
                                                LEFT JOIN asentamiento ON joaaso_fk = asentamiento_pk
                                                WHERE joaeso_fk = ".$_SESSION['id_estado']
                                                ." AND joamuo_fk = ".$_SESSION['id_municipio']
                                                ." AND joacid_fk = ".$_SESSION['id_ciudad']);
        $jornadas = array();
        foreach($sql as $id=>$data)
        {
            $jornadas[$data['jornada']['jornada_pk']]=$data['0']['jornada'];
        }
        $this->set("Jornadas",$jornadas);
        $this->render("jornadas","ajax");
    }
        
    function consulta()
    {
        $_SESSION['current'] = 'consulta';
    }
    
    function guardaHistorial()
    {
        //GUARDA CIUDAD Y ASENTAMIENTO
        if($this->data['HistorialPaciente']['ciudad']!='' && 
           $this->data['HistorialPaciente']['asentamiento']!='')
        {
            $Ciudad = array();
            $Ciudad['Ciudad']['cid_descripcion'] = strtoupper($this->data['HistorialPaciente']['ciudad']);
            
            $Ciudad['Ciudad']['cidmuo_fk'] = $this->data['HistorialPaciente']['id_municipio'];
            $Ciudad['Ciudad']['cid_rango1'] = '0000';
            $Ciudad['Ciudad']['cid_rango2'] = '0000';
            
            $this->Ciudad->set($Ciudad);
            if($this->Ciudad->save())
            {
                $id_ciudad = $this->Ciudad->getLastInsertId();
                $this->data['HistorialPaciente']['id_ciudad'] = $id_ciudad;
                
                if($this->data['HistorialPaciente']['asentamiento']!='')
                {
                    $Asentamiento = array();
                    $Asentamiento['Asentamiento']['aso_descripcion'] = strtoupper($this->data['HistorialPaciente']['asentamiento']);
                    $Asentamiento['Asentamiento']['asoeso_fk'] = $this->data['HistorialPaciente']['id_estado'];
                    $Asentamiento['Asentamiento']['asomuo_fk'] = $this->data['HistorialPaciente']['id_municipio'];
                    $Asentamiento['Asentamiento']['asocid_fk'] = $this->data['HistorialPaciente']['id_ciudad'];

                    $this->Asentamiento->set($Asentamiento);
                    if($this->Asentamiento->save())
                    {
                        $id_asentamiento = $this->Asentamiento->getLastInsertId();
                        $this->data['HistorialPaciente']['id_asentamiento'] = $id_asentamiento;
                    }
                }
                
            }
        }
        // GUARDA ASENTAMIENTO EN CASO QUE NO EXSTA Y QUE SE SELECCIONE UNA CIUDAD
        if($this->data['HistorialPaciente']['asentamiento']!='' &&
           $this->data['HistorialPaciente']['ciudad']=='' && 
           $this->data['HistorialPaciente']['id_ciudad']!= '' &&
           $this->data['HistorialPaciente']['id_asentamiento']=='' )
        {
            $Asentamiento = array();
            $Asentamiento['Asentamiento']['aso_descripcion'] = strtoupper($this->data['HistorialPaciente']['asentamiento']);
            $Asentamiento['Asentamiento']['asoeso_fk'] = $this->data['HistorialPaciente']['id_estado'];
            $Asentamiento['Asentamiento']['asomuo_fk'] = $this->data['HistorialPaciente']['id_municipio'];
            $Asentamiento['Asentamiento']['asocid_fk'] = $this->data['HistorialPaciente']['id_ciudad'];

            $this->Asentamiento->set($Asentamiento);
            if($this->Asentamiento->save())
            {
                $id_asentamiento = $this->Asentamiento->getLastInsertId();
                $this->data['HistorialPaciente']['id_asentamiento'] = $id_asentamiento;
            }
        }
        
        $HistorialPaciente = array_map("strtoupper",$this->data['HistorialPaciente']);
        if($this->data['TratamientosPaciente']['profilaxis']=='') $this->data['TratamientosPaciente']['profilaxis']= 0;
        if($this->data['TratamientosPaciente']['fluor']=='')$this->data['TratamientosPaciente']['fluor']= 0;
        if($this->data['TratamientosPaciente']['farmacoterapia']=='') $this->data['TratamientosPaciente']['farmacoterapia']= 0;
        if($this->data['TratamientosPaciente']['amalgamas']=='') $this->data['TratamientosPaciente']['amalgamas'] = 0; 
        if($this->data['TratamientosPaciente']['pulpotomia']=='') $this->data['TratamientosPaciente']['pulpotomia'] = 0;
        if($this->data['TratamientosPaciente']['odontoxesis']=='') $this->data['TratamientosPaciente']['odontoxesis'] = 0;
        if($this->data['TratamientosPaciente']['resinas']=='') $this->data['TratamientosPaciente']['resinas'] = 0; 
        if($this->data['TratamientosPaciente']['obturacion']=='') $this->data['TratamientosPaciente']['obturacion']= 0;
        if($this->data['TratamientosPaciente']['fosetas']=='') $this->data['TratamientosPaciente']['fosetas']= 0;
        if($this->data['TratamientosPaciente']['extracciones']=='') $this->data['TratamientosPaciente']['extracciones'] = 0;
        if($this->data['TratamientosPaciente']['terapia_laser']=='') $this->data['TratamientosPaciente']['terapia_laser'] = 0; 
        if($this->data['TratamientosPaciente']['remocion_caries']=='') $this->data['TratamientosPaciente']['remocion_caries'] = 0; 
        if($this->data['TratamientosPaciente']['otros']=='') $this->data['TratamientosPaciente']['otros'] = 0;
        
        $TratamientosPaciente = array_map("strtoupper",$this->data['TratamientosPaciente']);
        //pr($HistorialPaciente);exit();
        if($HistorialPaciente['pae_nombre']!='' && $HistorialPaciente['folio']!='' && 
           $HistorialPaciente['fecha']!='' && $HistorialPaciente['id_estado']!='' &&
           $HistorialPaciente['id_municipio']!='' && $HistorialPaciente['id_ciudad']!='' &&
           //$HistorialPaciente['id_asentamiento']!='' && 
           $HistorialPaciente['pae_sexo']!='' && $TratamientosPaciente['atendido_por']!=''
          )
        {
            $mySQL =" SELECT id_historial,pae_nombre,folio "
                   ." FROM historial_paciente "
                   ." WHERE "
                   ." pae_nombre = '".$HistorialPaciente['pae_nombre']."' AND "
                   ." id_asentamiento = ".$HistorialPaciente['id_asentamiento'];
            //echo $mySQL;exit();
            $existePaciente = $this->HistorialPaciente->query($mySQL);

            if(count($existePaciente)!=0)
            {
                e('<div class="warning">EL PACIENTE <b>'.$existePaciente[0]['historial_paciente']['pae_nombre']
                 .'</b> YA CUENTA CON HISTORIAL CLÍNICO <a href="'
                 .$this->webroot.'Consultas/detalle/'.$existePaciente[0]['historial_paciente']['id_historial'].'">'
                 .'<b>['.$existePaciente[0]['historial_paciente']['folio'].']</b></a></div>');
                exit();
            }else{
                    $this->HistorialPaciente->set($HistorialPaciente);
                    if($this->HistorialPaciente->save())
                    {
                       $id_historial = $this->HistorialPaciente->getLastInsertId();
                       $this->data['TratamientosPaciente']['id_paciente'] = $id_historial;
                       $this->data['TratamientosPaciente']['fecha'] = $this->data['HistorialPaciente']['fecha']; 
                       $this->data['TratamientosPaciente']['folio'] = $HistorialPaciente['folio']; 
                       $this->data['TratamientosPaciente']['id_municipio'] = $HistorialPaciente['id_municipio']; 
                       $TratamientosPaciente = array_map("strtoupper",$this->data['TratamientosPaciente']);
                       $this->TratamientosPaciente->set($TratamientosPaciente);
                       if($this->TratamientosPaciente->save())
                       {
                           e('');
                           
                           e('<p align="center">
                               <table width="100%" border="1">
                                    <tr>
                                        <td><div class="success">EL PACIENTE <b>'.$HistorialPaciente['pae_nombre'].'</b> SE HA REGISTRADO</div></td>  
                                    </tr>
                                    <tr>
                                        <td bgcolor="#C5C5C5" align="center"><a href="'.$this->webroot.'HistorialPaciente/hclinica/'.$_SESSION['folio'].'" target="_blank"><img src="'.$this->webroot.'/img/pdf.png" border="0" width="24px" height="24px" onClick="javascript:muestra_oculta(divCapturaa)">Historia Clínica</a></td>
                                    </tr>
                               </table>
                             </p>');
                           
                           if(isset($this->data['OtrosServiciosPaciente']))
                           {
                                
                               $OtrosServicios = $this->data['OtrosServiciosPaciente'];
                               foreach($OtrosServicios as $k=>$os)
                               {
                                   $this->data['OtrosServiciosPaciente'][$k]['fecha'] = $this->data['HistorialPaciente']['fecha'];
                               }
                               
                               $this->OtrosServiciosPaciente->set($this->data['OtrosServiciosPaciente']);
                                if($this->OtrosServiciosPaciente->saveAll($this->OtrosServiciosPaciente->data))
                                {
                                    //e('<div class="success">OTROS SERVICIOS AGREGADOS</div>');
                                }else
                                    {
                                         e('<div class="error">OCURRIÓ UN ERROR AL GUARDAR OTROS SERVICIOS</div>');
                                    }
                           }
                           //pr($this->data);
                           $log = $this->TratamientosPaciente->getDataSource()->getLog(false, false);
                           $x=0;
                           //debug($log);
                           $path= "/localhost/www/historial_clinico/app/webroot/files/import";
                           $filename= "PACIENTES-".date("d.m.y")."-".$_SESSION['Auth']['User']['username'].".udm";
                           if($_SESSION['Auth']['User']['id']!=0)
                           {
                                $ar=fopen($path."/".$filename,"a") or die("Ocurrió un error al crear el archivo");
                                foreach($log['log'] as $sql)
                                {
                                    $query = substr($sql['query'], 0, 11);
                                    if($query=='INSERT INTO')
                                    {
                                         fputs($ar,$sql['query'].";");
                                         fputs($ar,"\n");
                                    }
                                }
                                fclose($ar);
                           }
                           
                           exit();
                       }
                    }
                }
        }else
            {
                e("<div class='error'>DEBE INGRESAR LOS DATOS MARCADOS CON ASTERISCO <b>( * )</b></div>");
                exit();
            }
    }
    
    function OtroServicio($id_servicio=null)
    {
        $this->set("id_servicio",$id_servicio);
        $this->set("id_municipio",$_SESSION['id_municipio']);
        
        if(!isset($_SESSION['x']))
        {
           $_SESSION['x'] = 0;
        }else
             {
                $_SESSION['x'] = (int)$_SESSION['x']+1;
             }
    }
    
    function consentimiento($folio=null)
    {
        $this->set("folio",$folio);
        $this->set("fecha",date("d-m-Y"));
        $this->layout = 'pdf';
        $this->render();
    }
    
    function hclinica($folio=null)
    {
        $this->set("fecha",date("d-m-Y"));
        $HC = $this->HistorialPaciente->find("first",array("conditions"=>array("HistorialPaciente.folio"=>$folio)));
        $id_historial = $HC['HistorialPaciente']['id_historial'];
        $this->Consultas->id = $id_historial;
        $this->data = $this->Consultas->read();
        $HC = $this->data;
        $sexo = ($HC['Consultas']['pae_sexo']==1) ? 'MASCULINO' : 'FEMENINO';
        $this->set("HC",  $this->data);
        $this->set("folio",$folio);
        $this->set("fecha",date("d-m-Y"));
        $fecha = date("d-m-Y");
        
        $consentimiento = '<h2>CONSENTIMIENTO INFORMADO</h2>
                <table width="100%" border="1">
                  <tr>
                    <td colspan="4" valign="top"><strong>Para ser explicado y despues firmado por el paciente:</strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right" valign="top"><strong>FOLIO</strong></td>
                    <td align="center">'.$folio.'</td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top"><table width="95%" border="0">
                        <tr>
                          <td width="2%" align="left" valign="top"><p>&nbsp;</p></td>
                          <td width="98%" align="left" valign="top">Con esta fecha el dentista de esta Unidad Movil Dental me aplico una Historia Clinica a la cual respodndi bajo promesa de decir verdad y se me informo de los riesgos posibles y complicaciones que cualquier tratamiento dental conlleva y estoy plenamente consciente de: 1.- Que entiendo por que se me explico a detalle el alcance y repercusiones en mi salud que implica cualquier procedimiento o tratamiento dental, asi como los riesgos a los que me expongo como son las reacciones alergicas, hemorragias, infecciones, reacciones secundarias y otros de naturaleza analoga al empleo de medicamentos. 2.- Tambien se me explico que durante el procedimiento que se me va aplicar, existe la posibilidad de otros riesgos y complicaciones no discutidos con anterioridad que pudieran presentarse y que requieren otros procedimientos adicionales por lo que autorizo a que se me apliquen. 3.- Una vez leida y entendida esta explicacion; autorizo con cirujano dentista a que realice los procedimientos necesarios para mi atencion odontologica.</td>
                        </tr>
                      </table>
                      <p>&nbsp;</p></td>
                  </tr>

                  <tr>
                    <td colspan="4"><strong>DECLARO QUE RECIBI DE CONFORMIDAD MI TRATAMIENTO</strong></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center"><p>&nbsp;</p>
                    <p><small>[NOMBRE COMPLETO]</small></p></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="42%"><p><strong>FIRMA O HUELLA PACIENTE:</strong></p></td>
                    <td width="26%" rowspan="2" align="center" valign="bottom"><small>[HUELLA]</small></td>
                    <td width="11%"><strong>FECHA</strong></td>
                    <td width="21%" align="center">'.$fecha.'</td>
                  </tr>
                  <tr>
                    <td align="center" valign="bottom"><p>&nbsp;</p>
                    <p><small>[FIRMA]</small></p></td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                </table>
                ';
        
        $html = '<h2>DATOS DEL PACIENTE</h2>
            <table border="1"><tr><td>
            <table width="100%" border="0"cellspacing="3">
                <tr >
                    <td colspan="3" align="right"><b>FOLIO</b></td>
                    <td align="center">'.$HC['Consultas']['folio'].'</td>
                </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="center">';
                $path = '../webroot/files/fotos_paciente/'.$folio;
                if(is_dir($path))
                {
                    $html.='<img src="../webroot/files/fotos_paciente/'.$folio.'/'.$folio.'.jpg" alt="Foto Paciente" border="0" width="80px" heigh="60"/>';
                }else{
                    $html.='&nbsp;';
                }
                $html.='</td>
                </tr>
                <tr>
                  <td><b>ESTADO</b></td>
                  <td><b>MUNICIPIO</b></td>
                  <td align="right"><b>FECHA</b></td>
                  <td align="center">'.$HC['Consultas']['fecha'].'</td>
                </tr>
                <tr>
                  <td>'.strtoupper($HC['Consultas']['nombre_estado']).'</td>
                  <td colspan="3">'.$HC['Consultas']['muo_descripcion'].'</td>
                </tr>
                <tr>
                  <td><b>CIUDAD</b></td>
                  <td><b>LOCALIDAD</b></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>'.$HC['Consultas']['cid_descripcion'].'</td>
                    <td colspan="3">'.$HC['Consultas']['aso_descripcion'].'</td>
                </tr>
                <tr>
                  <td><b>UDM</b></td>
                  <td colspan="3">'.$_SESSION['Auth']['User']['id'].$_SESSION['Auth']['User']['username'].'</td>
                </tr>

                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><b>NOMBRE PACIENTE</b></td>
                  <td>&nbsp;</td>
                  <td width="13%"><b>EDAD</b></td>
                  <td width="37%"><b>GENERO</b></td>
                </tr>
                <tr>
                  <td colspan="2">'.$HC['Consultas']['pae_nombre'].'</td>
                  <td>'.$HC['Consultas']['pae_edad'].'</td>
                  <td>'.$sexo.'</td>
                </tr>
                <tr>
                  <td><b>DOMICILIO</b></td>
                  <td>&nbsp;</td>
                  <td><b>TELEFONO</b></td>
                  <td>'.$HC['Consultas']['pae_telefono'].'</td>
                </tr>
                <tr>
                  <td colspan="4">'.$HC['Consultas']['pae_direccion'].'</td>
                </tr>
            </table>
            </td></tr></table>
            <br><br>';
                
            $TP = $this->TratamientosPaciente->find("all",array("conditions"=>array("TratamientosPaciente.folio"=>$folio),"order"=>"fecha asc"));  
            
            $html.="<H2>PLAN DE TRATAMIENTO</H2>";
            $cantidad = 0;
            //pr($TP);exit(); $html.= '<table width="100%" border="1">
            foreach($TP as $tp)
            {
                $html.= '<table width="100%" border="1">
                            <tr >
                                <td><small><b>SERVICIOS APLICABLES EN LA FECHA DE</b></small></td>
                                <td align="right"><small>'.$tp['TratamientosPaciente']['fecha'].'</small></td>
                            </tr>';
                           if($tp['TratamientosPaciente']['profilaxis']!='' && $tp['TratamientosPaciente']['profilaxis']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>PROFILAXIS</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['profilaxis'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['profilaxis'];
                           }
                          
                           
                           if($tp['TratamientosPaciente']['fluor']!='' && $tp['TratamientosPaciente']['fluor']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>APLICACION DE FLUOR</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['fluor'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['fluor'];
                           }
                           
                           if($tp['TratamientosPaciente']['farmacoterapia']!='' && $tp['TratamientosPaciente']['farmacoterapia']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>FARMACOTERAPIA</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['farmacoterapia'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['farmacoterapia'];
                           }
                           
                           if($tp['TratamientosPaciente']['amalgamas']!='' && $tp['TratamientosPaciente']['amalgamas']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>AMALGAMAS</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['amalgamas'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['amalgamas'];
                           }
                           if($tp['TratamientosPaciente']['pulpotomia']!='' && $tp['TratamientosPaciente']['pulpotomia']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>RECUBRIMIENTO PULPAR</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['pulpotomia'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['pulpotomia'];
                           }
                           if($tp['TratamientosPaciente']['odontoxesis']!='' && $tp['TratamientosPaciente']['odontoxesis']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>ODONTOXESIS</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['odontoxesis'].'</small></td>
                               </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['profilaxis'];
                           }
                           if($tp['TratamientosPaciente']['resinas']!='' && $tp['TratamientosPaciente']['resinas']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>RESINAS</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['resinas'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['resinas'];
                           }
                           if($tp['TratamientosPaciente']['obturacion']!='' && $tp['TratamientosPaciente']['obturacion']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>OBTURACION TEMPORAL</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['obturacion'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['obturacion'];
                           }
                           if($tp['TratamientosPaciente']['fosetas']!='' && $tp['TratamientosPaciente']['fosetas']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>SELLADO-FOSETAS-FISURAS</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['fosetas'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['fosetas'];
                           }
                           if($tp['TratamientosPaciente']['extracciones']!='' && $tp['TratamientosPaciente']['extracciones']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>EXTRACCIONES</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['extracciones'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['extracciones'];
                           }
                           
                            if($tp['TratamientosPaciente']['terapia_laser']!='' && $tp['TratamientosPaciente']['terapia_laser']!=0)
                           { 
                              $html.= '<tr>
                              <td><small>LASER POST.QUIRURGICO</small></td>
                              <td align="right"><small>'.$tp['TratamientosPaciente']['terapia_laser'].'</small></td>
                              </tr>';
                              $cantidad+=$tp['TratamientosPaciente']['terapia_laser'];
                           }
                              
                           if($tp['TratamientosPaciente']['otros_especificar']!='')
                           { 
                              $html.= '<tr>
                              <td><small>OTROS</small></td>
                              <td><small>'.$tp['TratamientosPaciente']['otros_especificar'].'</small></td>
                              </tr>';
                              
                           }
                            
                           if($tp['TratamientosPaciente']['tratamiento_quirurgico']!='')
                           {  
                            $html.= '<tr>
                              <td><small>TRATAMIENTO QUIRURGICO</small></td>
                              <td><small>'.$tp['TratamientosPaciente']['tratamiento_quirurgico'].'</small></td>
                              </tr>';
                            
                           }
                          $html.='</table>';
                           //e($cantidad.'<br/>');
                          //totales
            }
            
            $mySQL = (" SELECT os.nombre_servicio, osp.cantidad "
                        ." FROM otros_servicios_paciente AS osp " 
                        ." INNER JOIN otros_servicios AS os ON osp.id_servicio = os.id_servicio"
                        ." WHERE folio = '$folio'"
                     );
            $OSP = $this->OtrosServiciosPaciente->query($mySQL);
            if(count($OSP)>0)
            {
                $html.='<br><br>'
                     . '<table width="100%" border="1">'
                     . '<tr><td><b><small>OTROS SERVICIOS</small></b></td><td>&nbsp;</td></tr>';
                foreach ($OSP as $osp)
                {
                    $html.= '<tr>
                    <td ><small>'.$osp['os']['nombre_servicio'].'</small></td>
                    <td align="right"><small>'.$osp['osp']['cantidad'].'</small></td>
                    </tr>';
                    $cantidad+=$osp['osp']['cantidad'];
                } 
                $html.='<tr><td align="right">TOTAL SERVICIOS</td><td align="right"><b>'.$cantidad.'</b></td></tr>';
                $html.='</table><br><br>';
            }
            
        //Siguiente Hoja
        $ai = date("Y")-2;
        $af = date ("Y");
        $html2 ='<h2>VALORACION DEL PACIENTE</h2>';

               $html2.='<table border="1">';
               $html2.='<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
        if($HC['Consultas']['hospitalizado']==1)
        {
            $html2 .= '<tr>
                    <td colspan="2">HA ESTADO HOSPITALIZADO ALGUNA VEZ DEL '.$ai.' AL '.$af.'</td>
                  </tr>';
        }
        
        if($HC['Consultas']['tratamiento_medico']==1)
        {
            
            $html2.='<tr>
                    <td colspan="2">HA ESTADO EN TRATAMIENTO MEDICO DEL AL</td>
                  </tr>';
        }
        
        if($HC['Consultas']['tomado_medicamento']==1)
        {
            $html2.='<tr>
                    <td colspan="2">HA TOMADO ALGUN MEDICAMENTO EN EL '.$af.'</td>
                    </tr>';
        }
        if($HC['Consultas']['alergico_medicamento']==1)
        {
        
            $html2.='<tr>
                    <td>ES ALERGICO(A) A</td>
                    <td>'.$HC['Consultas']['alergico_a'].'</td>
                  </tr>';
        }
        if($HC['Consultas']['hemorragia']==1)
        {
            $html2.='<tr>
                    <td colspan="2" >HEMORRAGIA QUE REQUIRIO TRATAMIENTO ESPECIAL</td>
                  </tr>';
        }    
        $html2.='
              <tr>
                <td colspan="2">HA PADECIDO ENFERMEDADES COMO:</td>
              </tr>'; 
        $E=0;
        $html2.='<tr>
                    <td>
                        <table width="100%" border="0">';
                        $html2.='<tr>
                                   <td>&nbsp;</td>
                                 </tr>';
                        if($HC['Consultas']['cardiacos']==1)
                        {
                            $html2.='<tr>
                                       <td>PROBLEMAS CARDIACOS</td>
                                     </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['presion_alta']==1)
                        {
                            $html2.='<tr>
                                        <td>PRESION ARTERIAL ALTA</td>
                                      </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['presion_baja']==1)
                        {
                            $html2.='<tr>
                                        <td>PRESION ARTERIAL BAJA</td>
                                      </tr>
                                      ';
                            $E+=1;
                        }
                        if($HC['Consultas']['anemia']==1)
                        {
                            $html2.='<tr>
                                        <td>ANEMIA</td>
                                    </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['fiebre_reumatica']==1)
                        {
                            $html2.='<tr>
                                        <td>FIEBRE REUMATICA</td>
                                    </tr>';
                            $E+=1;

                        }
                        if($HC['Consultas']['artitis_reumatismo']==1)
                        {
                            $html2.='<tr>
                                        <td>ARTRITIS / REUMATISMO</td>
                                    </tr>';
                            $E+=1;
                        }

                        if($HC['Consultas']['ataques_convulsiones']==1)
                        {
                            $html2.='<tr>
                                        <td>ATAQUES / CONVULSIONES</td>
                                        </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['osteoporosis']==1)
                        {
                            $html2.='<tr>
                              <td>OSTEOPOROSIS</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['transtornos_psiche']==1)
                        {
                            $html2.='<tr>
                              <td>TRANSTORNOS PSQUIAT</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['asma']==1)
                        {
                            $html2.='<tr>
                              <td>ASMA</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['asfixia']==1)
                        {
                            $html2.='<tr>
                              <td>ASFIXIA</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['tuberculosis']==1)
                        {
                            $html2.='<tr>
                              <td>TUBERCULOSIS</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['gastritis']==1)
                        {
                            $html2.='<tr>
                              <td>GASTRITIS</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['desmayos']==1)
                        {
                            $html2.='<tr>
                              <td>DESMAYOS</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['cancer']==1)
                        {
                            $html2.='<tr>
                              <td>CANCER</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['cancer']==1)
                        {
                            $html2.='<tr>
                              <td >ULCERAS GASTRICAS</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['hernia']==1)
                        {
                            $html2.='<tr>
                              <td>HERNIA HIATAL</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['hepatitis']==1)
                        {
                            $html2.='<tr>
                              <td>HEPTATITIS</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['cirrosis']==1)
                        {
                            $html2.='<tr>
                              <td>CIRROSIS HEPATICA</td>
                              </tr>';
                            $E+=1;
                        }

                        if($HC['Consultas']['diabetes']==1)
                        {
                            $html2.='<tr>
                              <td>DIABETES</td>
                              </tr>';
                            $E+=1;
                        }

                        if($HC['Consultas']['diabetes']==1)
                        {
                            $html2.='<tr>
                              <td>ENFERM. RINONES</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['epilepsia']==1)
                        {
                            $html2.='<tr>
                              <td>EPILEPSIA</td>
                              </tr>';
                            $E+=1;
                        }
                        if($HC['Consultas']['sida']==1)
                        {
                            $html2.='<tr>
                              <td>SIDA</td>
                              </tr>';
                            $E+=1;
                        }
                        if($E==0)
                        {
                            $html2.='<tr><td>NINGUNA</td></tr>';
                        }
                    $html2.='</table></td>
                    <td>&nbsp;</td>
                  </tr>';
                if($HC['Consultas']['otra_enfermedad']==1)
                {
                    $html2.='<tr>
                    <td>PADECE OTRA ENFERMEDAD IMPORTANTE</td>
                    <td>'.$HC['Consultas']['cual_enfermedad'].'</td>
                  </tr>';
                }
                $html2.='</table><br><br>';
                        
                $html2.='<h2>EXPLORACION CAVIDAD ORAL</h2>'
                        .'<table width="100%" border="1">'
                        .'<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
            if($HC['Consultas']['tejidos_blandos']!='')
            {
                $html2.='<tr>
                        <td>TEJIDOS BLANDOS</td>
                        <td>'.$HC['Consultas']['tejidos_blandos'].'</td>
                        </tr>';
            }

            if($HC['Consultas']['tejidos_duros']!='')
            {
                $html2.='<tr>
                        <td>TEJIDOS DUROS</td>
                        <td>'.$HC['Consultas']['tejidos_duros'].'</td>
                      </tr>';
            }

            if($HC['Consultas']['articulaciones']!='')
            {
                $html2.='<tr>
                        <td>ARTICULACIONES TEMPOROMANDIBULARES</td>
                        <td>'.$HC['Consultas']['articulaciones'].'</td>
                      </tr>';
            }
            
            if($HC['Consultas']['periodontal']!='')
            {
                $html2.='<tr>
                        <td>EXA. PERIODONTAL</td>
                        <td>'.$HC['Consultas']['periodontal'].'</td>
                      </tr>';
            }
          $html2.='<tr>
            <td valign="top">PDB </td>
            <td valign="top"><table width="100%" border="0">
              <tr>
                <td><small>DESORGANIZADA</small></td>
                <td><small>ORGANIZADA</small></td>
                <td><small>HIGIENE ORAL</small></td>
                </tr>';
          $ho='';
          switch ($HC['Consultas']['higiene_oral'])
          {
              case 1: $ho = 'BUENA';break;
              case 2: $ho = 'REGULAR';break;
              case 3: $ho = 'MALA';break;
          }

              $html2.='<tr>
                <td><small>'.$HC['Consultas']['pdb_desorganizada'].'</small></td>
                <td><small>'.$HC['Consultas']['pdb_organizada'].'</small></td>
                <td><small>'.$ho.'</small></td>
                </tr>
            </table></td>
          </tr>

          <tr>
            <td valign="top">TOTAL DE O.D.:</td>
            <td valign="top"><table width="100%" border="0">
              <tr>
                <td><small>ADULTOS</small></td>
                <td><small>INFANTILES</small></td>
              </tr>
              <tr>
                <td><small>'.$HC['Consultas']['total_od_adulto'].'</small></td>
                <td><small>'.$HC['Consultas']['total_od_infantil'].'</small></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>MUSCULATURA</td>
            <td>'.$HC['Consultas']['musculatura'].'</td>
          </tr>';
              $oc = '';
            switch ($HC['Consultas']['oclusion'])
            {
                case '1': $oc='I'; break;
                case '2': $oc='II'; break;
                case '3': $oc='III'; break;
                case '4': $oc='TRAUMATICA';break;
            }
          $html2.='<tr>
            <td>OCLUSION</td>
            <td>'.$oc.'</td>
          </tr>
        </table>
        <h2>EXAMEN DENTAL</h2>
        <p align="center"><small>ODONTOGRAMA</small></p>
        <p align="center"><img src="../webroot/img/odontograma.jpg" alt="Odontograma Paciente" border="0" width="454px" heigh="140px"/></p>';//e($html3);exit();
         //pr($HC);exit();
        //e($html.'<br/>'.$html2);exit();
        $this->set("html",$html);
        $this->set("html2",$html2);
        $this->set("consentimiento",$consentimiento);
        $this->layout = 'pdf';
        $this->render();
    }
      
    function leer_archivos_y_directorios($ruta="/")
    {
        if (is_dir($ruta))
        {
            if ($aux = opendir($ruta))
            {
                while (($archivo = readdir($aux)) !== false)
                {
                    if ($archivo!="." && $archivo!="..")
                    {
                        $ruta_completa = $ruta . '/' . $archivo;
                        if (is_dir($ruta_completa))
                        {
                            e("<br /><strong>Directorio:</strong> " . $ruta_completa);
                            leer_archivos_y_directorios($ruta_completa . "/");
                        }
                        else
                        {
                            e('<br />' . $archivo . '<br />');
                        }
                    }
                }

                closedir($aux);
                e("<strong>Fin Directorio:</strong>" . $ruta . "<br /><br />");
            }
        }
        else
        {
            e($ruta);
            e("<br />No es ruta valida");
        }
    }
}