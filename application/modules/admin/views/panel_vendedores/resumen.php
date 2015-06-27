<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Resumen - Estadisticas</h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $mis_productos ?></div>
                                <div>Productos</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo site_url("panel_vendedor/producto/listado"); ?>">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalles</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-newspaper-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $mis_anuncios ?></div>
                                <div>Anuncios</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo site_url("panel_vendedor/anuncio/listado"); ?>">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalles</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $mis_clientes ?></div>
                                <div>Clientes</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalles</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="col-md-8">  
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($paquete_vigente || $paquete_pendiente): ?>                                        
                            <div class="col-md-12">                                                              
                                <div class="heading">
                                    <h3 class="text-uppercase">Mis Paquetes</h3>
                                </div>                   
                                <div class="box">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Fecha Compra</th>
                                                    <th>Fecha Aprobación</th>
                                                    <th>Fecha Terminar</th>
                                                    <th>Costo</th>
                                                    <th>Estado</th>                                        
                                                </tr>
                                            </thead>
                                            <tbody>                                            
                                                <tr>
                                                    <th><?php echo $paquete->nombre_paquete ?></th>
                                                    <td><?php echo date("d-M-Y", strtotime($paquete->fecha_comprado)) ?></td>
                                                    <td><?php echo ($paquete->fecha_aprobado != null) ? date("d-M-Y", strtotime($paquete->fecha_aprobado)) : ''; ?></td>
                                                    <td><?php echo ($paquete->fecha_terminar != null) ? date("d-M-Y", strtotime($paquete->fecha_terminar)) : ''; ?></td>
                                                    <td><?php echo $paquete->monto_a_cancelar . ' ' . $this->config->item('money_sign') ?></td>
                                                    <td>
                                                        <?php if ($paquete->aprobado == 1): ?>
                                                            <?php if ($paquete->fecha_terminar < date("Y-m-d")): ?>
                                                                <span class="label label-danger">Terminado</span>
                                                            <?php else: ?>
                                                                <span class="label label-success">Aprobado / En Curso</span>
                                                            <?php endif; ?>   
                                                        <?php else: ?>
                                                            <span class="label label-warning">Esperando Aprobación</span>
                                                        <?php endif; ?>                                            
                                                    </td>                                        
                                                </tr> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                                           
                            </div>     
                        <?php else: ?>
                            <div class="">
                                <p class="text-muted lead">De momento no tienes paquetes pendientes ni aprobados..</p>                                       
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <hr>
                <br>                
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Estadisticas Mensual
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris_mensual"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Estadisticas Anuales
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris_anual"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
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

                        </div>                                                
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
