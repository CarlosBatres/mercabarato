<?php if (sizeof($anuncios)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>                
                <th style="width: 15%">Titulo</th>                
                <th style="width: 50%">Contenido</th>                                
                <th style="width: 5%;text-align: center">Habilitado</th>
                <th style="width: 5%">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($anuncios as $anuncio): ?>
                <tr>                
                    <td><?php echo $anuncio->titulo; ?></td>                    
                    <td><?php echo $anuncio->contenido; ?></td>                                        
                    <td style="text-align: center"><?php
                        if ($anuncio->habilitado == 1): echo "<span class='label label-success'>Si</span>";
                        else: echo "<span class='label label-danger'>No</span>";
                        endif;
                        ?>
                    </td>                                                                
                    <td>
                        <div class="options">
                            <a href="<?php echo site_url('panel_vendedor/anuncio/editar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                            <a class="item_borrar" href="<?php echo site_url('panel_vendedor/anuncio/borrar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

   <?php echo $pagination; ?>
</div> 
<?php endif; ?>
