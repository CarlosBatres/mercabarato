<?php if ($search_params['total_paginas'] < 1): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 15%">Nombre</th>                
                <th style="width: 15%">Descripcion</th>                                
                <th style="width: 10%;">Duracion</th>
                <th style="width: 5%;">Costo</th>
                <th style="width: 10%;text-align: center">Productos</th>
                <th style="width: 10%;text-align: center">Anuncios</th>                
                <th style="width: 5%;text-align: center">Orden</th>
                <th style="width: 5%;text-align: center">Activo</th>                
                <th style="width: 5%;text-align: center">Mostrar</th>                
                <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paquetes as $paquete): ?>
                <tr>
                    <td><?php echo $paquete->id; ?></td>
                    <td><?php echo $paquete->nombre; ?></td>                    
                    <td><?php echo $paquete->descripcion; ?></td>                                                            
                    <td><?php echo $paquete->duracion.' Meses' ?></td>                    
                    <td><?php echo $paquete->costo; ?></td>                    
                    <td style="text-align: center"><?php
                        if ($paquete->limite_productos == -1): echo "<span class='label label-success'>Sin limite</span>";
                        else: echo $paquete->limite_productos;
                        endif;
                        ?>
                    </td>
                    <td style="text-align: center"><?php
                        if ($paquete->limite_anuncios == -1): echo "<span class='label label-success'>Sin limite</span>";
                        else: echo $paquete->limite_anuncios;
                        endif;
                        ?>
                    </td>                    
                    <td><?php echo $paquete->orden; ?></td>                    
                    <td style="text-align: center"><?php
                        if ($paquete->activo == 1): echo "<span class='label label-success'>Si</span>";
                        else: echo "<span class='label label-danger'>No</span>";
                        endif;
                        ?>
                    </td>
                    <td style="text-align: center"><?php
                        if ($paquete->mostrar == 1): echo "<span class='label label-success'>Si</span>";
                        else: echo "<span class='label label-danger'>No</span>";
                        endif;
                        ?>
                    </td>
                    <td>
                        <div class="options">                            
                            <a class="item_borrar" href="<?php echo site_url('admin/paquetes/borrar') . '/' . $paquete->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
                            <a data-id="<?php echo $search_params['anterior']; ?>" href="<?php echo site_url('admin/paquetes/') . '/' . $search_params['anterior'] ?>">Anterior</a>
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
                            <a data-id="<?php echo $i; ?>" href="<?php echo site_url('admin/paquetes/') . '/' . $i ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($search_params['siguiente'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['siguiente']; ?>" href="<?php echo site_url('admin/paquetes/') . '/' . $search_params['siguiente'] ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div> 
<?php endif; ?>
