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
                <div class="heading">
                    <h3 class="text-uppercase">Paquetes</h3>
                </div>                    
                <?php if ($vendedor_paquetes): ?>                                                
                    <div class="box">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha Compra</th>                                        
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Terminar</th>                                        
                                        <th>Precio</th>
                                        <th>Estado</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vendedor_paquetes as $paquete): ?>                                    
                                        <tr>
                                            <th><?php echo $paquete->nombre_paquete ?></th>
                                            <td><?php echo date("d-M-Y", strtotime($paquete->fecha_comprado)) ?></td>                                            
                                            <td><?php echo ($paquete->fecha_inicio != null) ? date("d-M-Y", strtotime($paquete->fecha_inicio)) : ''; ?></td>
                                            <td><?php echo ($paquete->fecha_terminar != null) ? date("d-M-Y", strtotime($paquete->fecha_terminar)) : ''; ?></td>
                                            <td><?php echo $paquete->monto_a_cancelar . ' ' . $this->config->item('money_sign') ?></td>
                                            <td>
                                                <?php if ($paquete->aprobado == 1): ?>
                                                    <?php if ($paquete->fecha_terminar < date("Y-m-d")): ?>
                                                        <span class="label label-danger">Terminado</span>
                                                    <?php elseif ($paquete->fecha_terminar == date("Y-m-d")): ?>
                                                        <span class="label label-danger">Ultimo día</span>
                                                    <?php elseif ($paquete->fecha_terminar <= $date5): ?>
                                                        <span class="label label-warning">Apunto de Caducar</span>
                                                    <?php elseif ($paquete->fecha_inicio > date("Y-m-d")): ?>       
                                                        <span class="label label-success">Renovación Aprobada</span>
                                                    <?php else: ?>       
                                                        <span class="label label-success">Aprobado / En Curso</span>
                                                    <?php endif; ?>   
                                                <?php else: ?>
                                                    <span class="label label-warning">Esperando Aprobación</span>
                                                <?php endif; ?>                                            
                                            </td>                                        
                                        </tr> 

                                    <?php endforeach; ?>                                                                       
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->

                    </div>                                            
                <?php else: ?>                    
                    <p class="text-muted lead">De momento no tienes paquetes pendientes ni aprobados..</p>                                       
                <?php endif; ?>                

                <?php if ($renovar): ?>    
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <h4>Tienes un paquete a punto de caducar te interesa renovarlo?</h4>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <a href="<?php echo site_url('usuario/paquetes/renovar') ?>" id="boton-perfil2" class="btn btn-template-primary"> Renovar Paquete</a>
                        </div>
                    </div>
                <?php elseif (!$nada): ?>
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <h3>Le interesa comprar un nuevo paquete?</h3>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <a href="<?php echo site_url('usuario/paquetes/comprar') ?>" id="boton-perfil" class="btn btn-template-primary"> Comprar Paquetes</a>
                        </div>
                    </div>
                <?php endif; ?>



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