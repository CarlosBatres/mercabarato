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
                <div class="panel panel-default">
                    <div class="panel-body">  
                        <div class="col-md-12">
                            <div class="panel panel-default">                                
                                <div class="panel-body">
                                    <p class="lead">Bienvenido a tu apartado personal desde donde puedes controlar todo lo relacionado con tu cuenta.</p> 
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8">
                            <ul class="list-group">
                                <li class="list-group-item text-muted" contenteditable="false">Perfil</li>
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Miembro desde</strong></span> <?php echo date("d-m-Y", strtotime($info->usuario->fecha_creado)); ?></li>                                
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Nombre</strong></span> <?php echo ($info->es_vendedor_habilitado()) ? $info->vendedor->nombre : $info->cliente->nombres . ' ' . $info->cliente->apellidos ?></li>
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tipo Cuenta: </strong></span> <?php echo ($info->es_vendedor_habilitado()) ? "Vendedor" : "Cliente"; ?>
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Pais: </strong></span> <?php echo ($full_localizacion["pais"] != null) ? $full_localizacion["pais"]->nombre : "No especificado"; ?>                                    
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Provincia: </strong></span> <?php echo ($full_localizacion["provincia"] != null) ? $full_localizacion["provincia"]->nombre : "No especificado"; ?>                                    
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Poblacion: </strong></span> <?php echo ($full_localizacion["poblacion"] != null) ? $full_localizacion["poblacion"]->nombre : "No especificado"; ?>                                    
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>                    

            <div class="col-md-3">                       
                <?php echo $html_options; ?>                       
            </div>                    

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->