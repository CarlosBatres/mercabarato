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
                    <th style="width: 15%">Identificacion</th>                                    
                    <th style="width: 10%">Miembro Desde</th>                    
                    <th style="width: 10%">Ultima Actividad</th>                                        
                    <th style="width: 5%;text-align: center">Acciones</th>                                        
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>                        
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
                        <td>
                            <div class="options">
                                <a class="action" data-id="<?php echo $cliente->invitacion_id?>" href="<?php echo site_url('panel_vendedor/invitaciones/aceptar') . '/' . $cliente->invitacion_id ?>" data-toogle="tooltip"  title="Aceptar"><i class="glyphicon glyphicon-ok"></i></a>                                
                                <a class="action" data-id="<?php echo $cliente->invitacion_id?>" href="<?php echo site_url('panel_vendedor/invitaciones/rechazar') . '/' . $cliente->invitacion_id ?>" data-toogle="tooltip"  title="Rechazar"><i class="glyphicon glyphicon-remove"></i></a>                                
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
