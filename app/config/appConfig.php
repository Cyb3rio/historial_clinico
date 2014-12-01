<?php
$dias = array('Domingo', 'Lunes', 'Martes', 'Miercoles',
        'Jueves', 'Viernes', 'Sabado');
     
function diasSemana($ano, $semana)
{
    $enero = mktime(1,1,1,1,1,$ano);
    $mos = (11-date('w',$enero))%7-3;
    $inicios = strtotime(($semana-1) . ' weeks '.$mos.' days', $enero);
    for ($x=0; $x<=6; $x++) {
        $dias[] = date('Y-m-d', strtotime("+ $x day", $inicios));
        $dia[] = date('w', strtotime("+ $x day", $inicios));
    }

    $res = array_combine( $dia,$dias);
    return $res;
}
    
function ultimoDia()
{
    $mes = mktime( 0, 0, 0, date("m"), 1, date("Y") ); 
    $dias = date("t",$mes);
    return $dias;
}



function fechaLetra($fecha='')
{
    //yyyy-mm-dd
    if($fecha!='')
    {
        $fechaLetra = explode('-', $fecha);
        $mes = mes($fechaLetra[1]);
        return $fechaLetra[2].' de '.$mes.' del '.$fechaLetra[0];
    }
}

function mes($mes)
{
    switch($mes)
    {
        case 1:
            $mes = 'Enero';
            break;
        case 2:
            $mes = 'Febrero';
            break;
        case 3:
            $mes = 'Marzo';
            break;
        case 4:
            $mes = 'Abril';
            break;
        case 5:
            $mes = 'Mayo';
            break;
        case 6:
            $mes = 'Junio';
            break;
        case 7:
            $mes = 'Julio';
            break;
        case 8:
            $mes = 'Agosto';
            break;
        case 9:
            $mes = 'Septiembre';
            break;
        case 10:
            $mes = 'Octubre';
            break;
        case 11:
            $mes = 'Noviembre';
            break;
        case 12:
            $mes = 'Diciembre';
            break;
    }
    return $mes;
}

function orderArray ($toOrderArray, $field,$inter='', $inverse = false) {  
    $position = array();  
    $newRow = array();  
    
    foreach ($toOrderArray as $key => $row)
    {  
        if($inter=='')
        {
            $position[$key]  = $row[$field];  
            $newRow[$key] = $row;
        }else{
             $position[$key][$inter]  = $row[$inter][$field];  
            $newRow[$key] = $row;
        }
    }  
    if ($inverse)
    {  
        arsort($position);  
    }  
    else{  
        asort($position);  
    }  
    $returnArray = array();  
    foreach ($position as $key => $pos) {       
        $returnArray[] = $newRow[$key];  
    }  
    return $returnArray;  
}

function check_email_address($email) 
{
  // Primero, checamos que solo haya un símbolo @, y que los largos sean correctos
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) 
    {
	// correo inválido por número incorrecto de caracteres en una parte, o número incorrecto de símbolos @
        return false;
    }
  // se divide en partes para hacerlo más sencillo
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) 
    {
        if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
	{
            return false;
        }
    } 
  // se revisa si el dominio es una IP. Si no, debe ser un nombre de dominio válido
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) 
    { 
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) 
	{
            return false; // No son suficientes partes o secciones para se un dominio
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) 
	{
            if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) 
            {
                return false;
            }
        }
    }
    return true;
}
?>