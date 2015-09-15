<?php if (sizeof($infocompras_generales) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> No tienes ninguna solicitud de presupuesto pendientes...</p>    
        </div>        
    </div>        
<?php else: ?>
    <ul class="tabla-resultados-principal invitaciones-list">
        <?php foreach ($infocompras_generales as $infocompra): ?>
            <?php
            if ($infocompra->estado == 2) {
                $class = "contacto-invitado";
            } else {
                $class = "";
            }
            ?>

            <li class="<?php echo $class; ?>">                
                <div class="col-md-8">                                                        
                    <div class="row invitaciones">                        
                        <p><strong>( <?php echo date("d-M-Y", strtotime($infocompra->fecha_solicitud)) ?> )</strong> &nbsp;&nbsp; <a href="<?php echo site_url($infocompra->vendedor_slug) ?>"><strong><?php echo $infocompra->nombre_vendedor ?></strong></a></p>
                        <?php if ($infocompra->precio != ""): ?>
                            <p><strong>Precio</strong>&nbsp;&nbsp; <?php echo $infocompra->precio . ' ' . $this->config->item('money_sign') ?></p>                        
                        <?php endif; ?>
                    </div>
                    <?php if ($infocompra->ventajas != ""): ?>
                        <div class="row ventajas">
                            <p><strong>Ventajas Ofrecidas por el Vendedor:</strong></p>
                            <?php echo $infocompra->ventajas ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($infocompra->estado == 0): ?>
                    <div class="col-md-4">                    
                        <br>
                        <br>
                        <div class="row">
                            <div class="pull-right">
                                <button type="button" class="btn btn-info accion" data-id="<?php echo $infocompra->id ?>">Esperando Respuesta</button>
                            </div>
                        </div>                        
                    </div>
                <?php elseif ($infocompra->estado == 1): ?>
                    <div class="col-md-4">                    
                        <br>
                        <br>
                        <div class="row">
                            <div class="pull-right">                                    
                                <a href="<?php echo site_url('usuario/infocompras-general/respuesta/' . $infocompra->id) ?>" class="btn btn-success" >&nbsp;&nbsp; Ver Respuesta &nbsp;&nbsp;</a>
                            </div>
                        </div>                        
                    </div>
                <?php elseif ($infocompra->estado == 2): ?>
                    <div class="col-md-4">                                                                    
                        <br>
                        <div class="row">
                            <div class="pull-right">                                    
                                <a href="<?php echo site_url('usuario/infocompras-general/respuesta/' . $infocompra->id) ?>" class="btn btn-success" >&nbsp;&nbsp; Ver Respuesta &nbsp;&nbsp;</a>
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

