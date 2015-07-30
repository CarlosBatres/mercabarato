<?php if (sizeof($invitaciones) == 0): ?>
    <div>
        <p> No tienes contactos ni invitaciones pendientes...</p>    
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
                <?php if ($invitacion->enviado == 1): ?>
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
                            <br>
                            <div class="row">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-warning accion eliminar" data-id="<?php echo $invitacion->id ?>"> &nbsp;&nbsp;Eliminar Contacto&nbsp;&nbsp;</button>
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

