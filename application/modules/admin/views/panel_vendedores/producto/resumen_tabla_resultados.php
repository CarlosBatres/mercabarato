<?php if (sizeof($productos) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> No tienes productos con visitas. </p>                
        </div>        
    </div>
<?php else: ?>    
    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>                
                    <th style="width: 70%">Nombre del Producto</th>
                    <th style="width: 10%;text-align: center">Precio Venta Publico</th>                    
                    <th style="width: 10%">Visitas Promedio / Mes</th>
                    <th style="width: 10%">Visitas Total</th>                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): 
                    $fechainicial = new DateTime($producto->fecha_insertado);
                    $fechafinal = new DateTime(date('Y-m-d'));
                    $diferencia = $fechainicial->diff($fechafinal);
                    $meses = ( $diferencia->y * 12 ) + $diferencia->m;
                    if($meses==0) $meses=1;
                    
                    ?>
                    <tr>                    
                        <td><?php echo $producto->nombre; ?></td>
                        <td style="text-align: center"><?php echo $producto->precio . ' ' . $this->config->item('money_sign'); ?></td>                                                                                       
                        <td><?php echo number_format($producto->total/$meses,2) ?></td>
                        <td><?php echo $producto->total; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
