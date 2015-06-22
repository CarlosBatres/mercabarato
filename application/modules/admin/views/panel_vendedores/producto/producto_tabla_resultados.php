<?php if ($search_params['total_paginas'] < 1): ?>
<div>
    <p> No se encontraron productos...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>                
                <th style="width: 15%">Nombre del Producto</th>
                <th style="width: 5%;text-align: center">Precio Venta Publico</th>
                <th style="width: 10%">Categoria</th>                
                <th style="width: 5%;text-align: center">Visible al Publico</th>                                            
                <th style="width: 5%;text-align: center">PVP Visible</th>
                <th style="width: 5%;text-align: center">Habilitado</th>
                <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>                    
                    <td><?php echo $producto->nombre; ?></td>
                    <td style="text-align: center"><?php echo $producto->precio; ?></td>                                                                
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
                    <td>
                        <div class="options">
                            <a href="<?php echo site_url('panel_vendedor/producto/editar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                            <a class="producto_borrar" href="<?php echo site_url('panel_vendedor/producto/borrar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($search_params['total_paginas'] > 1): ?>
        <div class="col-md-6"> Mostrando 
            <?php echo ($search_params['desde'] < $search_params['hasta']) ? $search_params['desde'] . ' a ' . $search_params['hasta'] : ' el ' . $search_params['desde']; ?> 
            de <?php echo $search_params['total']; ?> resultados</div>
        <div class="col-md-6">
            <div class="paginacion-listado">
                <ul class="pagination">
                    <?php if ($search_params['anterior'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['anterior']; ?>" href="<?php echo site_url('panel_vendedor/producto/') . '/' . $search_params['anterior'] ?>">Anterior</a>
                        </li>
                    <?php endif; ?>
                    <?php
                    for ($i = 1; $i <= $search_params['total_paginas']; $i++) {
                        $class = "";
                        if ($i == $search_params['pagina']) {
                            $class = "active";
                        }
                        ?>
                        <li class="<?php echo $class; ?>">
                            <a data-id="<?php echo $i; ?>" href="<?php echo site_url('panel_vendedor/producto/') . '/' . $i ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($search_params['siguiente'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['siguiente']; ?>" href="<?php echo site_url('panel_vendedor/producto/') . '/' . $search_params['siguiente'] ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div> 
<?php endif; ?>
