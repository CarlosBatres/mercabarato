<?php if ($left_panel): ?>
    <?php if (sizeof($productos) == 0): ?>
        <div>
            <p> No se encontraron mas productos...</p>    
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
                        <tr class="producto-ofertado" data-id="<?php echo $producto->id; ?>">                                                
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

<?php else: ?>
    <?php if (sizeof($ofertas) == 0): ?>
        <div>
            <p> Seleccione un producto primero...</p>    
        </div>
    <?php else: ?>
        <div class="table-responsive">        
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>                                                                  
                        <th style="width: 20%;text-align: center;">P.V.P.</th>
                        <th style="width: 20%;text-align: center;">Nueva Oferta</th>
                        <th style="width: 20%;text-align: center;">Total Clientes</th>                                        
                        <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ofertas as $oferta): ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $oferta->viejo_costo. ' ' . $this->config->item('money_sign') ?></td>
                            <td style="text-align: center;"><?php echo $oferta->nuevo_costo. ' ' . $this->config->item('money_sign'); ?></td>
                            <td style="text-align: center;"><?php echo $oferta->total_clientes; ?></td>                                                
                            <td>
                            <div class="options">                                                                
                                <a class="row_action_borrar" href="<?php echo site_url('panel_vendedor/ofertas/borrar') . '/' . $oferta->id ?>" data-toogle="tooltip"  title="Eliminar Oferta"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $pagination; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>


