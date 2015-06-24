<?php if (sizeof($productos)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 15%">Nombre del Producto</th>
                <th style="width: 15%">Categoria</th>
                <th style="width: 15%">Vendedor / Empresa</th>                            
                <th style="width: 5%;text-align: center">Visible al Publico</th>
                <th style="width: 5%;text-align: center">Precio Venta Publico</th>                            
                <th style="width: 5%;text-align: center">PVP Visible</th>                                                        
                <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto->id; ?></td>
                    <td><?php echo $producto->nombre; ?></td>
                    <td><?php echo $producto->Categoria; ?></td>
                    <td><?php echo $producto->Vendedor; ?></td>
                    <td style="text-align: center"><?php
                        if ($producto->mostrar_producto == 1): echo "<span class='label label-success'>Si</span>";
                        else: echo "<span class='label label-danger'>No</span>";
                        endif;
                        ?>
                    </td>
                    <td style="text-align: center"><?php echo $producto->precio; ?></td>                                                                
                    <td style="text-align: center"><?php
                        if ($producto->mostrar_precio == 1): echo "<span class='label label-success'>Si</span>";
                        else: echo "<span class='label label-danger'>No</span>";
                        endif;
                        ?>
                    </td>                                                                
                    <td>
                        <div class="options">
                            <!--<a href="<?php echo site_url('admin/productos/editar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>-->
                            <a class="producto_borrar" href="<?php echo site_url('admin/productos/borrar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo $pagination; ?>   
</div> 
<?php endif; ?>
