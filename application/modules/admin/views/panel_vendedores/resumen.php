<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="page-header">Resumen - Estadisticas</h1>
        </div>
    </div>  


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
                <a href="<?php echo site_url("panel_vendedor/invitaciones/aceptadas"); ?>">
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
        <div class="col-md-12">  
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <?php if ($paquete_vigente || $paquete_pendiente): ?>                                        
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
                                            <th>Precio</th>
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
                                                    <?php elseif ($paquete->fecha_terminar == date("Y-m-d")): ?>
                                                        <span class="label label-danger">Ultimo Dia</span>   
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
                    <?php else: ?>
                        <div class="">
                            <p class="text-muted lead">De momento no tienes paquetes pendientes ni aprobados..</p>                                       
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 col-lg-8">                                                
                    <div class="panel panel-default">
                        <div class="panel-body">  
                            <div class="col-md-12">
                                <div class="panel panel-default">                                
                                    <div class="panel-body">
                                        <p class="lead">Bienvenido a tu apartado personal desde donde puedes controlar todo lo relacionado con tu cuenta.</p> 
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <?php if ($info->vendedor->filename != null): ?>
                                    <img src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $info->vendedor->filename ?>" alt="" class="img-responsive center-block">
                                <?php else: ?>   
                                    <img src="<?php echo assets_url('imgs/avatar1.gif') ?>" class="img-responsive"/>
                                <?php endif; ?>

                            </div>

                            <div class="col-md-8">
                                <ul class="list-group">
                                    <li class="list-group-item text-muted" contenteditable="false">Perfil</li>
                                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Miembro desde</strong></span> <?php echo date("d-m-Y", strtotime($info->usuario->fecha_creado)); ?></li>                                
                                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Nombre</strong></span> 
                                        <?php
                                        if ($info->es_vendedor_habilitado()):
                                            echo $info->vendedor->nombre;
                                        elseif ($info->cliente->nombres != ''):
                                            echo $info->cliente->nombres . ' ' . $info->cliente->apellidos;
                                        else:
                                            echo "Sin nombre";
                                        endif;
                                        ?>                                

                                    </li>
                                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Email: </strong></span> <?php echo $info->usuario->email; ?>                                        
                                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Pais: </strong></span> <?php echo ($full_localizacion["pais"] != null) ? $full_localizacion["pais"]->nombre : "No especificado"; ?>                                    
                                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Provincia: </strong></span> <?php echo ($full_localizacion["provincia"] != null) ? $full_localizacion["provincia"]->nombre : "No especificado"; ?>                                    
                                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Poblacion: </strong></span> <?php echo ($full_localizacion["poblacion"] != null) ? $full_localizacion["poblacion"]->nombre : "No especificado"; ?>                                    
                                    </li>
                                </ul>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <br>                
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Estadistica General
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">No disponible</a></li>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris_general"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>                    
                </div> 
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Estadisticas - Clientes Afiliados
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">No disponible</a></li>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris_general_afiliados"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>                    
                </div>
                <form action="#" method="post" class="search-form" id="listado-productos">
                    <input type="hidden" value="1" name="pagina" id="pagina"/>
                </form>    
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Estadisticas - Productos                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="tabla-productos"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div> <!-- container-fluid -->

