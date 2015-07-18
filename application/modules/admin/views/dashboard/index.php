<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Resumen - Estadisticas</h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $usuarios_activos_en_sistema?></div>
                                <div>Usuarios en Sistema</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo site_url('admin/usuarios')?>">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalles</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $vendedores_activos_en_sistema?></div>
                                <div>Vendedores Registrados</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo site_url('admin/vendedores')?>">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalles</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $productos_activos_en_sistema ?></div>
                                <div>Productos en Sistema</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo site_url('admin/productos')?>">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalles</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $paquetes_comprados ?></div>
                                <div>Paquetes Vendidos</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"></span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa- fa-fw"></i> 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <p class="lead">Bienvenido al panel de administracion del sitio Mercabarato.com</p>                        
                        <div class="col-md-8">
                            <ul class="list-group">
                                <li class="list-group-item text-muted" contenteditable="false">Perfil</li>
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Email</strong></span> <?php echo $vendedor_logged->usuario->email; ?></li>                                                                
                                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Miembro desde</strong></span> <?php echo date("d-m-Y", strtotime($vendedor_logged->usuario->fecha_creado)); ?></li>                                                                
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-table fa-fw"></i> Ultimos Mensajes 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <a href="<?php echo site_url('admin/vendedor_paquetes/listado_por_activar'); ?>" class="list-group-item">
                                <i class="fa fa-money fa-fw"></i> Paquetes a la espera de aprobación
                                <span class="pull-right text-muted small"><em><?php echo $paquetes_por_aprobacion ?> Paquetes</em>
                                </span>
                            </a>                                                       
                        </div>                                                
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
