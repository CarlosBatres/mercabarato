<?php if (sizeof($clientes) == 0): ?>
    <div>
        <p> De momento nadie a cumplido los requisitos de esta oferta...</p>    
    </div>
<?php else: ?>
    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>                                  
                    <th style="width: 30%">Identificacion</th>                                                         
                    <th style="width: 20%">Miembro Desde</th>                    
                    <th style="width: 29%">Ultima Actividad</th>                      
                    <th style="width: 20%">Codigo</th>                      
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>                                           
                        <?php if ($cliente->nombre_vendedor != null): ?>
                            <td><?php echo $cliente->nombre_vendedor; ?></td>
                        <?php else: ?>   
                            <td><?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?></td>
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
                        <td><?php echo $cliente->codigo; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div>
<?php endif; ?>

