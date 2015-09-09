<?php if (sizeof($solicitud_seguros) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> No tienes ninguna solicitud de presupuesto pendientes...</p>    
        </div>        
    </div>        
<?php else: ?>
    <ul class="tabla-resultados-principal invitaciones-list">
        <?php foreach ($solicitud_seguros as $seguro): ?>
            <?php
            if ($seguro->estado == 2) {
                $class = "contacto-invitado";
            } else {
                $class = "";
            }
            ?>

            <li class="<?php echo $class; ?>">                
                <div class="col-md-8">                                                        
                    <div class="row invitaciones">                        
                        <p><strong>( <?php echo date("d-M-Y", strtotime($seguro->fecha_solicitud)) ?> )</strong> &nbsp;&nbsp; <a href="<?php echo site_url($seguro->vendedor_slug) ?>"><strong><?php echo $seguro->nombre_vendedor ?></strong></a></p>
                        <?php if ($seguro->precio != ""): ?>
                            <p><strong>Precio</strong>&nbsp;&nbsp; <?php echo $seguro->precio . ' ' . $this->config->item('money_sign') ?></p>                        
                        <?php endif; ?>
                    </div>
                    <?php if ($seguro->ventajas != ""): ?>
                        <div class="row ventajas">
                            <p><strong>Ventajas Ofrecidas por el Vendedor:</strong></p>
                            <?php echo $seguro->ventajas ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($seguro->estado == 0): ?>
                    <div class="col-md-4">                    
                        <br>
                        <br>
                        <div class="row">
                            <div class="pull-right">
                                <button type="button" class="btn btn-info accion" data-id="<?php echo $seguro->id ?>">Esperando Respuesta</button>
                            </div>
                        </div>                        
                    </div>
                <?php elseif ($seguro->estado == 1): ?>
                    <div class="col-md-4">                    
                        <br>
                        <br>
                        <div class="row">
                            <div class="pull-right">                                    
                                <a href="<?php echo site_url('usuario/infocompras-seguros/respuesta/' . $seguro->id) ?>" class="btn btn-success" >&nbsp;&nbsp; Ver Respuesta &nbsp;&nbsp;</a>
                            </div>
                        </div>                        
                    </div>
                <?php elseif ($seguro->estado == 2): ?>
                    <div class="col-md-4">                                                                    
                        <br>
                        <div class="row">
                            <div class="pull-right">                                    
                                <a href="<?php echo site_url('usuario/infocompras-seguros/respuesta/' . $seguro->id) ?>" class="btn btn-success" >&nbsp;&nbsp; Ver Respuesta &nbsp;&nbsp;</a>
                            </div>
                        </div> 
                        <br>
                        <div class="row">
                            <div class="pull-right">
                                <button type="button" class="btn btn-danger">Cerrada por el Vendedor</button>
                            </div>
                        </div>                                                
                    </div>

                <?php endif; ?> 
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;

