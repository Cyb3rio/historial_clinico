<?php
if(isset($_SESSION['Auth']['User']['id']))
{
    $_SESSION['current']='';
?>
<br/><br/><br/><br/>

    <table  align="center" height="300px" width="100%">
        <tr>
            <td align="center">Bienvenido al Sistema<br/><h3>Historial Clínico de Pacientes</h3><br/></td>
        </tr>
        <tr>
            <td align="center"><?php e($html->image("LOGO_FSF.png",array("width"=>"25%", "height"=>"25%")));?></td>
        </tr>
        <tr>
            <td align="center" valign="middle">
                <table>
                    <tr>
                        <td align="center" valign="middle"><?php e($html->image("user.png",array("width"=>"48","height"=>"48")));?></td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle"><?php e($_SESSION['Auth']['User']['first_name'].' '.$_SESSION['Auth']['User']['last_name'])?></td>
                    </tr>
                </table>
                
                
            </td>
        </tr>
    </table>
<?php
}