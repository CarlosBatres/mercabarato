<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Pagina del Usuario</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Mi Cuenta</li>                    
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content" class="clearfix">

    <div class="container">
        <div class="row">

            <!-- *** LEFT COLUMN ***
                 _________________________________________________________ -->

            <div class="col-md-9 clearfix">                                                
                <div class="col-md-12">
                    <div class="heading">
                        <h3>Paquetes</h3>
                    </div>
                    <p class="lead">Seleccione uno de los siguientes paquetes mostrados a continuacion, si lo desea puede saltar este paso y completarlo en otro momento.</p>
                    <div class="row packages">

                        <?php foreach ($paquetes as $paquete): ?>
                            <!-- TODO: col-md-4 si son mas de 3 paquetes o menos hay que acomodar aqui -->
                            <div class="col-md-4">                                
                                <div class="package ">
                                    <div class="package-header">
                                        <h5><?php echo $paquete->nombre; ?></h5>
                                    </div>
                                    <div class="price">
                                        <div class="price-container">
                                            <h4><span class="currency"></span><?php echo $paquete->costo . ' ' . $this->config->item('money_sign') ?></h4>                                            
                                        </div>
                                    </div>
                                    <ul>
                                        <li><i class="fa fa-check"></i>
                                            <?php
                                            if ($paquete->limite_productos == -1): echo "Sin limite de Productos";
                                            else: echo $paquete->limite_productos .' productos';
                                            endif;
                                            ?>
                                        </li>
                                        <li><i class="fa fa-check"></i>
                                            <?php
                                            if ($paquete->limite_anuncios == -1): echo "Sin limite de Anuncios";
                                            else: echo $paquete->limite_anuncios .' anuncios';
                                            endif;
                                            ?>
                                        </li>                                        
                                    </ul>
                                    <a href="<?php echo site_url("usuario/afiliacion-final/".$paquete->id) ?>" class="btn btn-template-main"> Comprar </a>
                                </div>                                
                            </div>
                        <?php endforeach; ?>                        

                    </div>
                    <div class="box clearfix">
                        <div class="box-footer">
                            <div class="pull-left">
                                <a href="<?php echo site_url("usuario/afiliacion") ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i>Regresar</a>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-template-main">Saltar este paso y Terminar<i class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>       


            <div class="col-md-3">                       
                <div class="panel panel-default sidebar-menu">
                    <div class="panel-heading">
                        <h3 class="panel-title">Panel Opciones</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li>
                                <a href="<?php echo site_url('usuario/perfil') ?>"><i class="fa fa-user"></i> Datos Personales</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-lock"></i> Contraseña</a>
                            </li>                                    
                            <li class='active'>
                                <a href="<?php echo site_url('usuario/afiliacion') ?>"><i class="fa fa-money"></i> Afiliación</a>
                            </li>                                    
                        </ul>
                    </div>
                </div>                        
            </div>                    

        </div>
    </div>
</div>