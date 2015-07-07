<?php if (sizeof($productos) == 0): ?>
    <div>
        <p> No se encontraron productos...</p>    
    </div>
<?php else: ?>

    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>  
                    <th style="width: 1%"> <input type="checkbox" name="seleccion_all" value="ON" /></th>              
                    <th style="width: 40%">Nombre del Producto</th>
                    <th style="width: 30%">Categoria</th>                
                    <th style="width: 19%;text-align: center">Precio Venta Publico</th>                                        
                    <th style="width: 10%;text-align: center">&nbsp; Seleccionar</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr data-id="<?php echo $producto->id; ?>">                    
                        <td><input type="checkbox" name="seleccion" value="ON" /></td>
                        <td><?php echo $producto->nombre; ?></td>
                        <td><?php echo $producto->Categoria; ?></td>                    
                        <td style="text-align: center"><?php echo $producto->precio; ?></td>                                                                                                                
                        <td>
                            <div class="options">
                                <a href="<?php echo site_url('panel_vendedor/tarifas/producto') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Seleccionar este producto"><i class="glyphicon glyphicon-expand"></i></a>                                                        
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
