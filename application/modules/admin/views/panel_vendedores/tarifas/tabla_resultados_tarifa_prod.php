<?php if (sizeof($tarifas) == 0): ?>
    <div>
        <p> No se encontraron tarifas...</p>    
    </div>
<?php else: ?>
    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>                                                                  
                    <th style="width: 40%">Nombre</th>                    
                    <th style="width: 25%">Fecha creado</th>                    
                    <th style="width: 15%">Productos</th>
                    <th style="width: 15%">Clientes</th>
                    <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarifas as $tarifa): ?>
                    <tr>                                                
                        <td><?php echo $tarifa->nombre; ?></td>                        
                        <td><?php echo date('d-M-Y',strtotime($tarifa->fecha_creado)); ?></td>                        
                        <td><?php echo $tarifa->productos; ?></td>                        
                        <td><?php echo $tarifa->clientes; ?></td>                        
                        <td>
                            <div class="options">                                                               
                                <a href="<?php echo site_url('panel_vendedor/tarifas/ver-tarifa') . '/' . $tarifa->id ?>" data-toogle="tooltip"  title="Ver Detalles"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="row_action_borrar" href="<?php echo site_url('panel_vendedor/tarifas/borrar') . '/' . $tarifa->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>