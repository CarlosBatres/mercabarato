<?php if (sizeof($productos) == 0): ?>
    <div>
        <p> No tienes mas productos...</p>    
    </div>
<?php else: ?>

    <?php if ($left_panel): ?>
        <div class="table-responsive">        
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>                                          
                        <th style="width: 1%"><input type="checkbox" name="select_all" value="ON" /></th>              
                        <th style="width: 40%">Nombre del Producto</th>
                        <th style="width: 30%">Categoria</th>                
                        <th style="width: 19%;text-align: center">P.V.P.</th>                                                             
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr data-id="<?php echo $producto->id; ?>">                    
                            <td><input type="checkbox" name="mover" value="ON" /></td>
                            <td><?php echo $producto->nombre; ?></td>
                            <td><?php echo $producto->Categoria; ?></td>                    
                            <td style="text-align: center"><?php echo $producto->precio. ' ' . $this->config->item('money_sign'); ?></td>                                                                                                                                        
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
                        <th style="width: 40%">Nombre del Producto</th>
                        <th style="width: 30%">Categoria</th>                
                        <th style="width: 19%;text-align: center">P.V.P.</th>                                                             
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr data-id="<?php echo $producto->id; ?>">                                                
                            <td><?php echo $producto->nombre; ?></td>
                            <td><?php echo $producto->Categoria; ?></td>                    
                            <td style="text-align: center"><?php echo $producto->precio. ' ' . $this->config->item('money_sign'); ?></td>                                                                                                                                        
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $pagination; ?>
        </div>

    <?php endif; ?>

<?php endif; ?>
