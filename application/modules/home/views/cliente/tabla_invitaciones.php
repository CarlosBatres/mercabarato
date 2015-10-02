<?php if (sizeof($invitaciones) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> Todavía no tienes contactos ni invitaciones pendientes. </p>                
        </div>        
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal invitaciones-list">
        <?php foreach ($invitaciones as $invitacion): ?>
            <?php
            if ($invitacion->estado == 2) {
                $class = "contacto-invitado";
            } else {
                $class = "";
            }
            ?>

            <li class="<?php echo $class; ?>">                
                <div class="col-md-8">                                                        
                    <div class="row invitaciones">                    
                        <a href="<?php echo site_url($invitacion->unique_slug) ?>"><p><strong><?php echo $invitacion->nombre ?></strong></p></a>
                        <?php if ($invitacion->estado == 1): ?>
                            <?php if ($invitacion->titulo != ""): ?> 
                                <p><strong><?php echo truncate($invitacion->titulo, 300) ?></strong></p>                                                      
                            <?php else: ?>
                                <p><strong>Tienes una invitación pendiente de este vendedor.</strong></p>
                            <?php endif; ?>                            
                            <?php if ($invitacion->comentario != ""): ?> 
                                <p><?php echo truncate_html($invitacion->comentario, 350) ?></p>                                                                                  
                            <?php endif; ?>                            
                        <?php else: ?>
                            <?php if ($invitacion->descripcion != ""): ?> 
                                <p><?php echo truncate_html($invitacion->descripcion, 350) ?></p>                                                      
                            <?php endif; ?>

                        <?php endif; ?>                

                    </div>
                </div>
                <?php if ($invitacion->enviado == 1 && $invitacion->estado == 1): ?>
                    <div class="col-md-4">                    
                        <br>
                        <br>
                        <div class="row">
                            <div class="pull-right">
                                <button type="button" class="btn btn-info accion" data-id="<?php echo $invitacion->id ?>">Esperando Respuesta</button>
                            </div>
                        </div>                        
                    </div>
                <?php else: ?>
                    <?php if ($invitacion->estado == 1): ?>
                        <div class="col-md-4">
                            <br>
                            <div class="row">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-success accion aceptar" data-id="<?php echo $invitacion->id ?>"> &nbsp;Aceptar&nbsp;</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-danger accion rechazar" data-id="<?php echo $invitacion->id ?>"> Rechazar</button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>                        
                        <div class="col-md-4">                                                                          
                            <br>
                            <div class="row">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-warning accion eliminar" data-id="<?php echo $invitacion->id ?>">Eliminar Contacto</button>
                                </div>
                            </div>                        
                            <br>  
                            <div class="row">
                                <?php if ($invitacion->recibir_notificaciones == 1): ?>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-success accion recibir" data-id="<?php echo $invitacion->id ?>">Recibir Notificaciones</button>
                                    </div>
                                <?php else: ?>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-danger accion no_recibir" data-id="<?php echo $invitacion->id ?>">Sin Notificaciones</button>
                                    </div>
                                <?php endif; ?>
                            </div>                        
                        </div>
                    <?php endif; ?>                
                <?php endif; ?> 
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;

