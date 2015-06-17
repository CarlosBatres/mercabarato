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
                                        <th>Fecha Aprobación</th>
                                        <th>Fecha Terminar</th>
                                        <th>Costo</th>
                                        <th>Estado</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vendedor_paquetes as $paquete): ?>                                    
                                        <tr>
                                            <th><?php echo $paquete->nombre_paquete ?></th>
                                            <td><?php echo date("d-M-Y", strtotime($paquete->fecha_comprado)) ?></td>
                                            <td><?php echo ($paquete->fecha_aprobado!=null)?date("d-m-Y", strtotime($paquete->fecha_aprobado)):''; ?></td>
                                            <td><?php echo ($paquete->fecha_terminar!=null)?date("d-m-Y", strtotime($paquete->fecha_terminar)):''; ?></td>
                                            <td><?php echo $paquete->monto_a_cancelar . ' ' . $this->config->item('money_sign') ?></td>
                                            <td>
                                                <?php if ($paquete->aprobado == 1): ?>
                                                    <span class="label label-success">Aprobado</span>
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
                    
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <h3>Le interesa comprar un nuevo paquete?</h3>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a href="<?php echo site_url('usuario/paquetes/comprar') ?>" id="boton-perfil" class="btn btn-template-primary"> Comprar Paquetes</a>
                    </div>
                </div>
                    
            </div>                    

            <div class="col-md-3">                       
                <?php echo $html_options;?>                                                                      
            </div>                    

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->