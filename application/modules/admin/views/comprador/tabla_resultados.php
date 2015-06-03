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
                <th style="width: 20%">Nombre Completo</th>                
                <th style="width: 10%">Sexo</th>
                <th style="width: 10%">Fecha de Nacimiento</th>
                <th style="width: 20%">Email</th>
                <th style="width: 10%">Ultimo Acceso</th>                
                <th style="width: 5%">&nbsp;</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compradores as $comprador): ?>
                <tr>
                    <td><?php echo $comprador->id; ?></td>
                    <td><?php echo $comprador->nombre.' '.$comprador->apellidos; ?></td>                                                                                    
                    <td><?php echo ($comprador->sexo=='H')?'Hombre':'Mujer'; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($comprador->fecha_nacimiento)); ?></td>
                    <td><?php echo $comprador->email; ?></td>
                    <td><?php echo $comprador->ultimo_acceso; ?></td>                    
                    <td>
                        <div class="options">
                            <a href="<?php echo site_url('admin/compradores/editar') . '/' . $comprador->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                            <a class="comprador_borrar" href="<?php echo site_url('admin/compradores/borrar') . '/' . $comprador->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
                            <a data-id="<?php echo $search_params['anterior']; ?>" href="<?php echo site_url('compradores/') . '/' . $search_params['anterior'] ?>">Anterior</a>
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
                            <a data-id="<?php echo $i; ?>" href="<?php echo site_url('admin/compradores/') . '/' . $i ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($search_params['siguiente'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['siguiente']; ?>" href="<?php echo site_url('compradores/') . '/' . $search_params['siguiente'] ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div> 
<?php endif; ?>
