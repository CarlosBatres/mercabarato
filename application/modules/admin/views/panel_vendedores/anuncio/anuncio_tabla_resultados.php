<?php if (sizeof($anuncios) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
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
                                <?php if ($anuncio->habilitado == 0): ?>
                                    <a class="row_action habilitar" href="<?php echo site_url('panel_vendedor/anuncio/habilitar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Habilitar"><i class="glyphicon glyphicon-ok"></i></a>
                                <?php else: ?>
                                    <a class="row_action inhabilitar" href="<?php echo site_url('panel_vendedor/anuncio/inhabilitar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Inhabilitar"><i class="glyphicon glyphicon-remove"></i></a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('panel_vendedor/anuncio/editar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="row_action borrar" href="<?php echo site_url('panel_vendedor/anuncio/borrar') . '/' . $anuncio->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
