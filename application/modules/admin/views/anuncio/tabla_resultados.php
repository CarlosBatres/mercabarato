<?php if (sizeof($anuncios)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 15%">Titulo</th>                
                <th style="width: 50%">Contenido</th>                
                <th style="width: 15%">Vendedor / Empresa</th>                                            
                <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($anuncios as $anuncio): ?>
                <tr>
                    <td><?php echo $anuncio->id; ?></td>
                    <td><?php echo $anuncio->titulo; ?></td>                    
                    <td><?php echo strip_tags(truncate($anuncio->contenido, 300)) ?></td>                    
                    <td><?php echo $anuncio->Vendedor; ?></td>                                                                                   
                    <td>
                        <div class="options">
                            <!--<a href="<?php echo site_url('admin/anuncios/editar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>-->
                            <a class="item_borrar" href="<?php echo site_url('admin/anuncios/borrar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $pagination; ?>
</div> 
<?php endif; ?>
