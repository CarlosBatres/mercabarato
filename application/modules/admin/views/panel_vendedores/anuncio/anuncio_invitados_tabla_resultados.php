<?php if (sizeof($clientes) == 0): ?>
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
                    <th style="width: 1%"><input type="checkbox" name="select_all" value="ON" /></th>              
                    <th style="width: 49%">Identificacion</th>                                    
                    <th style="width: 25%">Miembro Desde</th>                    
                    <th style="width: 25%">Ultima Actividad</th>                                        
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                    <tr data-id="<?php echo $cliente->id; ?>">
                        <td><input type="checkbox" name="seleccionar" value="ON"/></td>
                        <?php if ($cliente->nombre_vendedor != null): ?>
                            <td><?php echo $cliente->nombre_vendedor; ?></td>
                        <?php else: ?>   
                            <td><?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?></td>
                        <?php endif; ?>                                              
                        <?php if ($cliente->fecha_creado != null): ?>
                            <td><?php echo mdate('%d %F %Y', strtotime($cliente->fecha_creado)); ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>                         
                        <?php if ($cliente->ultimo_acceso != null): ?>
                            <td><?php echo time_elapsed_string($cliente->ultimo_acceso); ?></td>
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
