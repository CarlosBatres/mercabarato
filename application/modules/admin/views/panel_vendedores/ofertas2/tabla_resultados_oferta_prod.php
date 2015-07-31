<?php if (sizeof($ofertas) == 0): ?>
    <div>
        <p> No se encontraron ofertas...</p>    
    </div>
<?php else: ?>
    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>                                                                  
                    <th style="width: 40%">Nombre</th>                    
                    <th style="width: 25%">Fecha Inicio</th>                    
                    <th style="width: 25%">Fecha Fin</th>                    
                    <th style="width: 15%">Productos</th>                    
                    <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ofertas as $oferta): ?>
                    <tr>                                                
                        <td><?php echo $oferta->nombre; ?></td>                        
                        <td><?php echo date('d-M-Y',strtotime($oferta->fecha_inicio)); ?></td>                        
                        <td><?php echo date('d-M-Y',strtotime($oferta->fecha_finaliza)); ?></td>                        
                        <td><?php echo $oferta->productos; ?></td>                                                
                        <td>
                            <div class="options">                                                               
                                <a href="<?php echo site_url('panel_vendedor/ofertas/ver-oferta') . '/' . $oferta->id ?>" data-toogle="tooltip"  title="Ver Detalles"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="row_action_borrar" href="<?php echo site_url('panel_vendedor/ofertas/borrar') . '/' . $oferta->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>