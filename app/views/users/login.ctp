<?php
e($form->create('User', array('action' => 'login')));

?>
<div align="center">
    <table width='100%' height='100px' id="box-table-b" align="center">
        <tr>
            <td align='center'>
                <table align="center">
                    <tr>
                        <td>Usuario:</td>
                        <td><?php e($form->input('username',array("label"=>false,"class"=>"txt_login")));?></td>
                    </tr>
                    <tr>
                        <td>Clave:</td>
                        <td><?php e($form->input('password',array("label"=>false,"class"=>"txt_pass")));?></td>
                    </tr>
                    <tr>
                        <td colspan="2" align='center'><?php e($form->end('Entrar',array('class'=>'button'))); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php 
e('<div align="center">'.$html->image("LOGO_FSF.png",array("width"=>"15%", "height"=>"15%")).'</div>');