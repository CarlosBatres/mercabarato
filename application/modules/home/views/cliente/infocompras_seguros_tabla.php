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
                        <a href="<?php echo site_url("") ?>"><p><strong><?php echo $seguro->nombre_vendedor ?></strong></p></a>                        
                        <?php if ($seguro->descripcion != ""): ?> 
                            <p><?php echo truncate($seguro->descripcion, 300) ?></p>                                                                                  
                        <?php endif; ?> 
                        <p><strong>Enviado el <?php echo date("d-m-Y", strtotime($seguro->fecha_solicitud)) ?></strong></p>

                    </div>
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
                <?php else: ?>
                    <?php if ($seguro->estado == 2): ?>                                            
                        <div class="col-md-4">                    
                            <br>
                            <br>
                            <div class="row">
                                <div class="pull-right">                                    
                                    <a href="<?php echo site_url('usuario/infocompras-seguros/respuesta/' . $seguro->id) ?>" data-toggle="modal" data-target="#myModal" class="btn btn-success" >&nbsp;&nbsp; Ver Respuesta &nbsp;&nbsp;</a>
                                </div>
                            </div>                        
                        </div>
                    <?php endif; ?>                
                <?php endif; ?> 
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;

