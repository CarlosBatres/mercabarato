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
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">26</div>
                                <div>New Comments!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
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
                                <div class="huge">12</div>
                                <div>New Tasks!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
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
                                <div class="huge">124</div>
                                <div>New Orders!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
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
                                <div class="huge">13</div>
                                <div>Support Tickets!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
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
                        
                        
                        
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-table fa-fw"></i> Resumen 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <a href="<?php echo site_url('admin/vendedor_paquetes/listado_por_activar'); ?>" class="list-group-item">
                                <i class="fa fa-money fa-fw"></i> Paquetes a la espera de aprobación
                                <span class="pull-right text-muted small"><em><?php echo $paquetes_por_aprobacion ?> Paquetes</em>
                                </span>
                            </a>
                            <a href="" class="list-group-item">
                                <i class="fa fa-users fa-fw"></i> Usuarios activos en el sistema
                                <span class="pull-right text-muted small"><em><?php echo $usuarios_activos_en_sistema?> Usuarios</em>
                                </span>
                            </a>
                            <a href="" class="list-group-item">
                                <i class="fa fa-sitemap fa-fw"></i> Vendedores activos en el sistema
                                <span class="pull-right text-muted small"><em><?php echo $vendedores_activos_en_sistema?> Vendedores</em>
                                </span>
                            </a>
                            <a href="" class="list-group-item">
                                <i class="fa fa-shopping-cart fa-fw"></i> Productos activos en el sistema
                                <span class="pull-right text-muted small"><em><?php echo $productos_activos_en_sistema ?> Productos</em>
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
