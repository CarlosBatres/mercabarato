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
                    <th style="width: 5%">ID</th>
                    <th style="width: 15%">Nombre Completo</th>                                    
                    <th style="width: 15%">Email</th>
                    <th style="width: 5%;text-align: center">Activo</th>
                    <th style="width: 15%">Ultimo Acceso</th>                
                    <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente->id; ?></td>                    
                        <?php if ($cliente->nombres != null): ?>
                            <td><?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?></td>                                                                                    
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>                      
                        <td><?php echo $cliente->email; ?></td>
                        <td style="text-align: center"><?php
                            if ($cliente->activo == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>
                        <?php if ($cliente->ultimo_acceso != null): ?>
                            <td><?php echo time_elapsed_string($cliente->ultimo_acceso); ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>
                        <td>
                            <div class="options">
        <!--                                <a href="<?php echo site_url('admin/usuarios/editar') . '/' . $cliente->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>-->
                                <?php if ($cliente->activo == 0): ?>
                                    <a class="action habilitar" href="<?php echo site_url('admin/usuarios/habilitar') . '/' . $cliente->id ?>" title="Habilitar"><i class="glyphicon glyphicon-check"></i></a>
                                <?php else: ?>
                                    <a class="action inhabilitar" href="<?php echo site_url('admin/usuarios/inhabilitar') . '/' . $cliente->id ?>" title="Inhabilitar"><i class="glyphicon glyphicon-remove"></i></a>
                                <?php endif; ?>                            
                                <a class="action borrar" href="<?php echo site_url('admin/usuarios/borrar') . '/' . $cliente->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
