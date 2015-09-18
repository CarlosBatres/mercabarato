<?php if (sizeof($productos) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
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
                    <th style="width: 40%">Nombre</th>                                                        
                    <th style="width: 40%">Fecha</th>                                                        
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>                        
                        <td><?php echo $producto->nombre ?></td>
                        <?php if ($producto->fecha_visita != null): ?>
                            <td><?php echo mdate('%d %F %Y', strtotime($producto->fecha_visita)); ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>                                                 
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
