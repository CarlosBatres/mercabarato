<?php if (sizeof($categorias)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 30%">Nombre Categoria</th>                
                <th style="width: 40%">Descripcion</th>                
                <th style="width: 10%;text-align: center">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php echo $categoria->id; ?></td>
                    <td><?php echo $categoria->nombre; ?></td>        
                    <td><?php echo $categoria->descripcion; ?></td>        
                    <td>
                        <div class="options">
                            <a href="<?php echo site_url('admin/categoria') . '/' . $categoria->slug ?>" data-toogle="tooltip"  title="Sub-Categorias"><i class="glyphicon glyphicon-expand"></i></a>
                            <a href="<?php echo site_url('admin/categorias/editar') . '/' . $categoria->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                            <a class="categoria_borrar" href="<?php echo site_url('admin/categorias/borrar') . '/' . $categoria->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo $pagination; ?>
</div> 
<?php endif; ?>
