<div id="divConsulta">
    <?php
    e($ajax->form(array("type"=>"post",
                        "options"=>array("model"=>"Consultas",
                        "update"=>"divConsulta",
                        "url"=>array("controller"=>'Consultas',"action"=>"resConsulta"),
                                        )
                       )
                 )
     );
    ?>
    <div align="center">
        <table id="box-table-b">
            <tr>
                <td>PALABRA CLAVE:</td>
                <td><?php e($form->input('Consulta.palabra_clave',array("label"=>false,"type"=>"text","class"=>"texto_cajas","size"=>"30","maxLenght"=>"25")));?></td>
                <td><?php e($form->submit("Consultar"))?></td>
            </tr>
        </table>
    </div>
    <?php
    e($form->end());
    ?>
</div>