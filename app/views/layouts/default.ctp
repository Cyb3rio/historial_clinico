<!doctype html>
<html class="no-js">
    <head>
    <meta charset="utf-8"/>
    <title>HISTORIAL CLÍNICO</title>
    <!--[if lt IE 9]>
            <script src="js/css3-mediaqueries.js"></script>
    <![endif]-->
    <?php 
    //
        ini_set('display_errors','0');  
        e($this->Html->css('style'));
        e($this->Html->script('funciones'));
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
    
    
    <!-- superfish -->
    <?php
        e($this->Html->css('superfish'));
        e($this->Html->script('superfish-1.4.8/js/hoverIntent'));
        e($this->Html->script('superfish-1.4.8/js/superfish'));
        e($this->Html->script('superfish-1.4.8/js/supersubs'));
    ?>
    <!-- ENDS superfish -->
    <!-- prettyPhoto -->
    <?php
        e($this->Html->script('prettyPhoto/js/jquery.prettyPhoto'));
        e($this->Html->css('prettyPhoto/css/prettyPhoto'));
    ?>
    <!-- ENDS prettyPhoto -->
    
    <!--[if IE 6]>
    <link rel="stylesheet" href="css/ie6-hacks.css" media="screen" />
    <script type="text/javascript" src="js/DD_belatedPNG.js"></script>
            <script>
            /* EXAMPLE */
            DD_belatedPNG.fix('*');
    </script>
    <![endif]-->
    <!-- Lessgrid -->
    <?php
        e($this->Html->css('lessgrid'));
    ?>
    <!-- modernizr -->
    <?php 
        e($this->Html->script('modernizr'));
        e($this->Html->script('modernizr.custom.04022'));

    ?>
    <!-- Ajax -->
    <?php
        e($this->Html->script('prototype'));
        e($this->Html->script('scriptaculous.js?load=effects'));
        e($this->Html->script('funciones'));
    ?>
    <!-- End Ajax -->
     
    <!-- Tabs -->
   <?php
        e($this->Html->css('styleTab'));
        e($this->Html->script('tabcontent'));
        //e($this->Html->script('jquery-ui'));
    ?>
  
    <!-- End Tabs-->
    
    <!-- Calendar -->
    <?php
        e($this->Html->css('jscal2', 'stylesheet'));
        e($this->Html->css('border-radius', 'stylesheet'));
        e($this->Html->css('steel/steel', 'stylesheet'));
        e($this->Html->script(array('jscal2', 'lang/es')));
        e($this->Html->css('table'));
    ?>
    
    <!-- WebCam -->
    <?php
        e($this->Html->script('webcam'));
    ?>
    <!-- End WebCam-->
    
    
    <style type="text/css">
    div.disabled {
            display: inline;
            float: none;
            clear: none;
            color: #C0C0C0;
    }
    </style>
    
    <!-- End Calendar -->
    
   
		<!--[if lt IE 9]>
			<style>
				.content{
					height: auto;
					margin: 0;
				}
				.content div {
					position: relative;
				}
			</style>
		<![endif]-->
        
        
    </head>
    <body lang="en">
        <?php
            if(!isset($_SESSION['current']))$_SESSION['current']='';
            $class_captura = ($_SESSION['current']=='captura')? 'class="current-menu-item"' : '';
            $class_consulta = ($_SESSION['current']=='consulta')? 'class="current-menu-item"' : '';
            $class_admin =  ($_SESSION['current']=='admin')? 'class="current-menu-item"' : '';
            $class_reporte =  ($_SESSION['current']=='reporte')? 'class="current-menu-item"' : '';
        ?>
        <header>
            <div class="wrapper">
              <nav>
                    <ul id="nav" class="sf-menu">
                    <?php
                        if(isset($_SESSION['Auth']['User'])){
                    ?>
                        
                        <li <?php e($class_consulta)?>><a href="<?php e($this->webroot.'Consultas/index')?>">Historial<span class="subheader">Búsqueda Pacientes</span></a></li>
                        <li <?php e($class_captura) ?>><a href="<?php e($this->webroot.'HistorialPaciente/captura')?>">Captura<span class="subheader">Historial Clínico</span></a></li>
                        <li <?php e($class_reporte) ?>><a href="<?php e($this->webroot.'Consultas/reporteGeneral')?>">Reporte<span class="subheader">General</span></a></li>
                        <?php
                        if($_SESSION['Auth']['User']['id']==0)
                        {
                        ?>
                        <li <?php e($class_admin)?>><a href="<?php e($this->webroot.'Administracion/index')?>">Administracion<span class="subheader">Sincronizar Infornación</span></a></li>
                        <?php
                        }
                        ?>
                        <li ><a href="<?php e($this->webroot.'Users/logout')?>">Salir<span class="subheader">Cerrar Sesión</span></a></li>
                        <li ><a href="<?php e($this->webroot.'files/manual.rtf')?>">Manual<span class="subheader">de Usuario</span></a></li>
                    <?php
                        }
                    ?>
                    </ul>
                </nav>
                <div class="clearfix"></div>
            </div>
        </header>

        <!-- MAIN -->
        <div id="main">
                <!-- social -->
                <div id="social-bar"></div>
                <!-- ENDS social -->
                <!-- Content -->
                <div id="content">
                <!-- masthead -->
                    <div id="masthead">
                        <span class="head">UDM</span><span class="subhead">Historial Clínico de Pacientes</span>
                    </div>
                <!-- ENDS masthead -->
                    <div id="subContent">
                        <div id="contentLayout">
                            <div id="spinner" style="display: none; float: right;">
                                <?php e($html->image('spinner.gif')); ?>
                            </div>
                            <?php
                              e($content_for_layout);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                </div>
                <!-- ENDS content -->
                <div class="clearfix"></div>
                <div class="shadow-main"></div>
        </div>
        <!-- ENDS MAIN -->
        <footer>
            <div class="wrapper">
                <div class="clearfix"></div>
            </div>
            <div id="to-top"></div>
        </footer>
    </body>
</html>