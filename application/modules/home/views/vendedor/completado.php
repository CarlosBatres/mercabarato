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
                        <h3>Completado</h3>
                    </div>
                    <p class="lead">Felicidades se ha recibido con exito su afilicacion, nos contactaremos via email con usted en la breveda posible.</p>                    
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
                                <a href="<?php echo site_url('usuario/completado') ?>"><i class="fa fa-money"></i> Afiliación</a>
                            </li>                                    
                        </ul>
                    </div>
                </div>                        
            </div>                    

        </div>
    </div>
</div>