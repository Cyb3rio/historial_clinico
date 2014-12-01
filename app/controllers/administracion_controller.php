<?php
class AdministracionController extends AppController
{
    var $name = 'Administracion';
    var $helpers = array('Html', 'Form', 'Ajax', 'JavaScript', 'Js');
    var $components = array('RequestHandler','Session');
    var $uses = array("Consultas","HistorialPaciente");
    var $paginate = array(
        'limit' => 2,
        'order' => array(
            'Consultas.pae_nombre' => 'asc'
        )
    );
    
    function index()
    {
        $_SESSION['current'] = 'admin';
        
        if(isset($_SESSION['imagen_paciente']))
        {
            $this->crearZIP();
        }
    }
    
    function import($file)
    {
        $path= "files/import";
        $fileO= fopen($path.'/'.$file, "r") or exit("No se pudo abrir el archivo!");
        //Output a line of the file until the end is reached
        $p=0; $c=0; 
        $l=0; $o=0;
        $ap=0; $tp=0;
        $atp=0;
        $unlink = false;
        while(!feof($fileO))
        {
            $mySQL = fgets($fileO);
            if($mySQL!='')
            {
                //PACIENTES
                $cadena = substr($mySQL, 0,32);
                if($cadena=='INSERT INTO `historial_paciente`')
                    $p++;
                
                $cadena = substr($mySQL, 0,27);
                if($cadena=='UPDATE `historial_paciente`')
                    $ap++;
                
                //TRATAMIENTOS PACIENTES
                $cadena = substr($mySQL, 0,35);
                if($cadena=='INSERT INTO `tratamientos_paciente`')
                    $tp++;
                
                $cadena = substr($mySQL, 0,30);
                if($cadena=='UPDATE `tratamientos_paciente`')
                    $atp++;
                
                //CIUDADES
                $cadena = substr($mySQL, 0,20);
                if($cadena=='INSERT INTO `ciudad`')
                    $c++;
                
                //LOCALIDADES
                $cadena = substr($mySQL, 0,26);
                if($cadena=='INSERT INTO `asentamiento`')
                    $l++;
                
                //OTROS SERVICIOS
                $cadena = substr($mySQL, 0,38);
                if($cadena=='INSERT INTO `otros_servicios_paciente`')
                    $o++;
                
                
                if($this->HistorialPaciente->query($mySQL))
                {
                    $unlink = true;
                }
            }
        }
        fclose($fileO);
        if($unlink===true)
        {
            unlink($path.'/'.$file);
            if($p>0){   e('<div class="success">'.$p.' PACIENTE(S) IMPORTADO(S)</div>');}
            if($ap>0){  e('<div class="success">'.$ap.' PACIENTE(S) ACTUALIZADO(S)</div>');}
            if($tp>0){ e('<div class="success">'.$tp.' TRATAMIENTO(S) IMPORTADO(S)</div>');}
            if($atp>0){ e('<div class="success">'.$atp.' TRATAMIENTO(S) ACTUALIZADO(S)</div>');}
            if($c>0){   e('<div class="success">'.$c.' CIUDAD(ES) IMPORTADA(S)</div>');}
            if($l>0){   e('<div class="success">'.$l.' LOCALIDAD(ES) IMPORTADA(S)</div>');}
            if($o>0){   e('<div class="success">'.$o.' OTRO(S) SERVICIO(S) IMPORTADO(S)</div>');}
        }else
            {
                e('<div class="error">OCURRIÓ UN ERROR AL IMPORTAR LOS PACIENTES</div>');
            }
        //$this->render("index","ajax");
        exit();
    }
    
    function create_zip($files = array(),$destination = '',$overwrite = true)
    {
        if(file_exists($destination) && !$overwrite){ return false; }
        $valid_files = array();
        if(is_array($files))
        {
            foreach($files as $file)
            {
                if(file_exists($file))
                {
                    $valid_files[] = $file;
                }
            }
        }
        
        if(count($valid_files))
        {
            $zip = new ZipArchive();
            if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true)
            {
                return false;
            }
            
            foreach($valid_files as $file)
            {
                $zip->addFile($file,$file);
            }

            $zip->close();
            return file_exists($destination);
        }
        else
            {
                return false;
            }
    }
    
    function crearZIP()
    {
        $path= "files/fotos_zip/";
        
        $files_to_zip = $_SESSION['imagen_paciente'];
        //pr($files_to_zip);
        $date = date('m.d.y');
        $result = $this->create_zip($files_to_zip,$path.'PACIENTES_IMG-'.$date.'-'.$_SESSION['Auth']['User']['username'].'.zip');
        return $result;
    }
    
    function unZIP($input_zip)
    {
        $target_dir = "./";
        $zip = new ZipArchive;
        $res = $zip->open('files/fotos_zip/'.$input_zip);
        if ($res === TRUE)
        {
            $zip->extractTo($target_dir);
            $zip->close();
            unlink('files/fotos_zip/'.$input_zip);
            e('<div class="success">FOTO(S) DE PACIENTE(S) IMPORTADA(S)</div>');
            
        }
        else {
            die("Failed");
        }
        exit();
    }
}