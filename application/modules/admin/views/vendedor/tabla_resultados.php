<?php if (sizeof($vendedores)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 10%">Nombre Empresa</th>                
                <th style="width: 10%">Actividad</th>
                <th style="width: 10%">Sitio Web</th>                
                <th style="width: 10%">Email</th>                
                <th style="width: 10%">Ultimo Acceso</th>                
                <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre;?></td>                                                                                    
                    <td><?php echo $vendedor->actividad;?></td> 
                    <td><?php echo $vendedor->sitio_web;?></td>                    
                    <td><?php echo $vendedor->email; ?></td>
                    <td><?php echo $vendedor->ultimo_acceso; ?></td>                    
                    <td>
                        <div class="options">
                            <a href="<?php echo site_url('admin/vendedores/editar') . '/' . $vendedor->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                            <a class="vendedor_borrar" href="<?php echo site_url('admin/vendedores/borrar') . '/' . $vendedor->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo $pagination;?>
</div> 
<?php endif; ?>
