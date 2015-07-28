<?php if (sizeof($productos) == 0): ?>
    <div>
        <p> No se encontraron mas productos...</p>    
    </div>
<?php else: ?>
    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>   
                    <?php if ($show_checkboxes): ?>
                        <th style="width: 1%"> <input type="checkbox" name="select_all" value="ON" /></th>              
                    <?php endif; ?>
                    <th style="width: 40%">Nombre del Producto</th>                        
                    <th style="width: 30%;text-align: center">P.V.P.</th>                                                             
                    <th style="width: 29%;text-align: center">Tarifa</th>                                                             
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr data-id="<?php echo $producto->id; ?>">                                           
                        <?php if ($show_checkboxes): ?>
                            <td><input type="checkbox" name="mover" value="ON" /></td>
                        <?php endif; ?>
                        <td><?php echo $producto->nombre; ?></td>                            
                        <td style="text-align: center"><?php echo $producto->precio . ' ' . $this->config->item('money_sign'); ?></td>                                                                                                                                        
                        <td style="text-align: center"><?php echo $producto->nuevo_costo . ' ' . $this->config->item('money_sign'); ?></td>                                                                                                                                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>
