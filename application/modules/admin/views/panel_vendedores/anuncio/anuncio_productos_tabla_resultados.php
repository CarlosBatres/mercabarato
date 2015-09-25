<?php if (sizeof($productos) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> No tienes ningun producto disponible, o puede que no hayas seleccionado a ningun cliente en el paso anterior. </p>                
        </div>        
    </div>
<?php else: ?>

    <div class="table-responsive">
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger"> 
                <a class="close" data-dismiss="alert">×</a>
                <?= $this->session->flashdata('error') ?> 
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"> 
                <a class="close" data-dismiss="alert">×</a>
                <?= $this->session->flashdata('success') ?> 
            </div>
        <?php } ?>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>        
                    <th style="width: 1%"></th>              
                    <th style="width: 14%">Nombre del Producto</th>
                    <th style="width: 5%;text-align: center">Precio Venta Publico</th>
                    <th style="width: 10%">Categoria</th>                
                    <th style="width: 5%;text-align: center">Visible al Publico</th>                                            
                    <th style="width: 5%;text-align: center">PVP Visible</th>
                    <th style="width: 5%;text-align: center">Habilitado</th>                                        
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                    <tr data-id="<?php echo $producto->id; ?>">
                        <td><input type="checkbox" name="seleccionar" value="ON"/></td>                        
                        <td><?php echo $producto->nombre; ?></td>
                        <td style="text-align: center"><?php echo $producto->precio . ' ' . $this->config->item('money_sign'); ?></td>                                                                
                        <td><?php echo $producto->Categoria; ?></td>                    
                        <td style="text-align: center"><?php
                            if ($producto->mostrar_producto == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>                    
                        <td style="text-align: center"><?php
                            if ($producto->mostrar_precio == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>                                                                
                        <td style="text-align: center"><?php
                            if ($producto->habilitado == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>                        
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
