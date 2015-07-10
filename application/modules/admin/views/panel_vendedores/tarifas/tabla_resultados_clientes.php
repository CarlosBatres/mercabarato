<?php if (sizeof($clientes) == 0): ?>
    <div>
        <p> No se encontraron mas clientes...</p>    
    </div>
<?php else: ?>

    <?php if ($left_panel): ?>
        <div class="table-responsive">        
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>              
                        <th style="width: 1%"> <input type="checkbox" name="select_all" value="ON" /></th>              
                        <th style="width: 35%">Nombre Completo</th>                
                        <th style="width: 9%">Sexo</th>                    
                        <th style="width: 20%">Miembro Desde</th>                    
                        <th style="width: 15%">Ultima Actividad</th>                      
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr data-id="<?php echo $cliente->id; ?>">                    
                            <td><input type="checkbox" name="mover" value="ON" /></td>
                            <?php if ($cliente->nombres != null): ?>
                                <td><?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?></td>                                                                                    
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>

                            <?php if ($cliente->sexo != null): ?>
                                <td><?php echo ($cliente->sexo == 'H') ? 'Hombre' : 'Mujer'; ?></td>
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>                        
                            <?php if ($cliente->fecha_creado != null): ?>
                                <td><?php echo mdate('%d %F %Y', strtotime($cliente->fecha_creado)); ?></td>
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>                         
                            <?php if ($cliente->ultimo_acceso != null): ?>
                                <td><?php echo time_elapsed_string($cliente->ultimo_acceso); ?></td>
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>                                                 
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php echo $pagination; ?>
        </div> 
    <?php else: ?>
        <div class="table-responsive">        
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>                                      
                        <th style="width: 35%">Nombre Completo</th>                
                        <th style="width: 9%">Sexo</th>                    
                        <th style="width: 20%">Miembro Desde</th>                    
                        <th style="width: 15%">Ultima Actividad</th>                      
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr data-id="<?php echo $cliente->id; ?>">                    
                            <?php if ($cliente->nombres != null): ?>
                                <td><?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?></td>                                                                                    
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>

                            <?php if ($cliente->sexo != null): ?>
                                <td><?php echo ($cliente->sexo == 'H') ? 'Hombre' : 'Mujer'; ?></td>
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>                        
                            <?php if ($cliente->fecha_creado != null): ?>
                                <td><?php echo mdate('%d %F %Y', strtotime($cliente->fecha_creado)); ?></td>
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>                         
                            <?php if ($cliente->ultimo_acceso != null): ?>
                                <td><?php echo time_elapsed_string($cliente->ultimo_acceso); ?></td>
                            <?php else: ?>   
                                <td class="warning"></td>
                            <?php endif; ?>                                                 
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php echo $pagination; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
