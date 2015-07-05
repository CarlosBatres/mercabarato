<?php if (sizeof($productos) == 0): ?>
    <div>
        <p> No se encontraron productos...</p>    
    </div>
<?php else: ?>

    <div class="table-responsive">
        <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('success') ?> 
                </div>
            <?php } ?>   
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('error') ?> 
                </div>
            <?php } ?>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>                
                    <th style="width: 15%">Nombre del Producto</th>
                    <th style="width: 10%">Categoria</th>                
                    <th style="width: 5%;text-align: center">Precio Venta Publico</th>                    
                    <th style="width: 5%;text-align: center">Tarifa</th>
                    <th style="width: 5%;text-align: center">&nbsp; Modificar Tarifa</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>                    
                        <td><?php echo $producto->nombre; ?></td>
                        <td><?php echo $producto->Categoria; ?></td>                    
                        <td style="text-align: center"><?php echo $producto->precio; ?></td>                                                                                        
                        <td style="text-align: center"><?php echo $producto->precio_tarifa; ?></td>                                                                                 
                        <td>
                            <div class="options">                                
                                <a href="" data-id="<?php echo $producto->id?>" data-toggle="modal" data-target="#myModal" title="Modificar Tarifa"><i class="glyphicon glyphicon-edit"></i></a>                                
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
