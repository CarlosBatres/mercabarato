<?php if (sizeof($invitaciones)==0): ?>
    <div>
        <p> No se encontraron invitaciones pendientes...</p>    
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($invitaciones as $invitacion): ?>
            <li>                
                <div class="row invitaciones">
                    <div class="col-md-12">                                
                        <p class="">Tienes una invitacion pendiente de:</p>               
                        <p><strong><?php echo $invitacion->nombre ?></strong></p>
                        <p><?php echo $invitacion->titulo ?></p>
                        <p><?php echo $invitacion->comentario ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="pull-left">
                            <button type="button" class="btn btn-template-main accion aceptar" data-id="<?php echo $invitacion->id ?>"> Aceptar</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="pull-left">
                            <button type="button" class="btn btn-template-main accion rechazar" data-id="<?php echo $invitacion->id ?>"> Rechazar</button>
                        </div>
                    </div>
                </div>
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;

