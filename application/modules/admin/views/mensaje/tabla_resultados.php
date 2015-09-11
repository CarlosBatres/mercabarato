<?php if (sizeof($usuarios) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> No se encontro ningun usuario que se ajuste a estos parametros.</p>                
        </div>        
    </div>
<?php else: ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 1%"> <input type="checkbox" name="select_all" value="ON" /></th>
                    <th style="width: 5%">ID</th>          
                    <th style="width: 20%">Email</th>                                                                        
                    <th style="width: 10%;text-align: center;">Tipo Usuario</th>                
                    <th style="width: 10%">Ultimo Acceso</th>                
                    <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr data-id="<?php echo $usuario->usuario_id; ?>">
                        <td><input type="checkbox" name="enviar" value="ON" /></td>
                        <td><?php echo $usuario->id; ?></td>                        
                        <td><?php echo $usuario->email; ?></td>
                        <td style="text-align: center"><?php
                            if ($usuario->es_vendedor == 1): echo "<span class='label label-success'>Vendedor</span>";
                            else: echo "<span class='label label-info'>Cliente</span>";
                            endif;
                            ?>
                        </td>
                        <?php if ($usuario->ultimo_acceso != null): ?>
                            <td><?php echo time_elapsed_string($usuario->ultimo_acceso); ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>
                        <td>
                            <div class="options">                                                                
                                <a href="<?php echo site_url('admin/mensajes/enviar-mensaje')?>" class="btn-enviar" title="Enviar Mensaje"><i class="fa fa-arrow-right"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
        <button type="button" id="btn-enviar-seleccionados" class="btn btn-info"><i class="fa fa-check-square"></i> Enviar a Seleccionados</button>        
        <button type="button" id="btn-enviar-todos" class="btn btn-success"><i class="fa fa-users"></i> Enviar a Todos</button>        
    </div> 
<?php endif; ?>
