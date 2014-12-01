<div align="center">
<table id="box-table-a" >
    <thead>
    	<tr  align='center'>
            <th scope="col"  width="70%">ARCHIVO</th>
            <th scope="col">IMPORTAR</th>
        </tr>
    </thead>
    <tbody>

<?php
    $directorio = opendir("files/import");
    $x=1;$i=0;
    while ($archivo = readdir($directorio))
    {
        if (!is_dir($archivo))
        {
            $arc = substr($archivo, 0,10);
            if($arc=='PACIENTES-')
            {
                e("<tr>");
                e("<td><div id='divImport_$x'>".$archivo."</div></td>");
                e("<td align='center'><div id='lnk_$x'>".$ajax->link($html->image('import.png',array("width"=>"28","height"=>"28")),array( 'controller' => 'Administracion', 'action' => 'import',$archivo ),array( 'update' => 'divImport_'.$x,'escape'=>false,'complete'=>' document.getElementById("lnk_'.$x.'").innerHTML="";'))."</td>");
                e("</tr>");
                $x++;
                $i++;
            }
        }
    }
    if($i==0){e("<tr><td><div class='warning'>NO EXISTEN DATOS PARA IMPORTAR</div></td><td><div class='warning'>&nbsp;</div></td></tr>");}
?>
</tbody>
</table>
<br/>
<table id="box-table-a" >
    <thead>
    	<tr  align='center'>
            <th scope="col" width="70%">ARCHIVO</th>
            <th scope="col">ACTUALIZAR</th>
        </tr>
    </thead>
    <tbody>

<?php
    closedir($directorio);
    $directorio = opendir("files/import");
    $a=0;
    while ($archivo = readdir($directorio))
    {
        if (!is_dir($archivo))
        {
            $arc = substr($archivo, 0,13);
            if($arc=='PACIENTES_ACT')
            {
                e("<tr>");
                e("<td><div id='divImport_$x'>".$archivo."</div></td>");
                e("<td align='center'><div id='lnk_$x'>".$ajax->link($html->image('import.png',array("width"=>"28","height"=>"28")),array( 'controller' => 'Administracion', 'action' => 'import',$archivo ),array( 'update' => 'divImport_'.$x,'escape'=>false,'complete'=>' document.getElementById("lnk_'.$x.'").innerHTML="";'))."</td>");
                e("</tr>");
                $x++;
                $a++;
            }                
        }
    }
    if($a==0){e("<tr><td ><div class='warning'>NO EXISTEN DATOS PARA ACTUALIZAR</div></td><td><div class='warning'>&nbsp;</div></td></tr>");}
?>
</tbody>
</table>
<br/>
<table id="box-table-a" >
    <thead>
    	<tr  align='center'>
            <th scope="col" width="70%">FOTOS PACIENTES</th>
            <th scope="col">IMPORTAR</th>
        </tr>
    </thead>
    <tbody>

<?php
    closedir($directorio);
    $directorio = opendir("files/fotos_zip");
    $f=0;
    while ($archivo = readdir($directorio))
    {
        if (!is_dir($archivo))
        {
                e("<tr>");
                e("<td><div id='divImport_$x'>".$archivo."</div></td>");
                e("<td align='center'><div id='lnk_$x'>".$ajax->link($html->image('import.png',array("width"=>"28","height"=>"28")),array( 'controller' => 'Administracion', 'action' => 'unZIP',$archivo ),array( 'update' => 'divImport_'.$x,'escape'=>false,'complete'=>' document.getElementById("lnk_'.$x.'").innerHTML="";'))."</td>");
                e("</tr>");
                $x++;
                $f++;
        }
    }
    if($f==0){e("<tr><td ><div class='warning'>NO EXISTEN FOTOS PARA IMPORTAR</div></td><td><div class='warning'>&nbsp;</div></td></tr>");}
?>
</tbody>
</table>

</div>