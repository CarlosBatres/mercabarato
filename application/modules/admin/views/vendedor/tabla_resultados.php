<?php if (sizeof($vendedores) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 5%">ID</th>
                    <th style="width: 20%">Nombre Empresa</th>                                
                    <th style="width: 10%">Sitio Web</th>                
                    <th style="width: 10%">Email</th>            
                    <th style="width: 5%;text-align: center">Activo</th>
                    <th style="width: 10%">Ultimo Acceso</th>                
                    <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendedores as $vendedor): ?>
                    <tr>
                        <td><?php echo $vendedor->id; ?></td>
                        <td><?php echo $vendedor->nombre; ?></td>                                                                                                        
                        <td><?php echo $vendedor->sitio_web; ?></td>                    
                        <td><?php echo $vendedor->email; ?></td>
                        <td style="text-align: center"><?php
                            if ($vendedor->activo == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>
                        <?php if ($vendedor->ultimo_acceso != null): ?>
                            <td><?php echo time_elapsed_string($vendedor->ultimo_acceso); ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>
                        <td>
                            <div class="options">
                                <!--                            <a href="<?php echo site_url('admin/vendedores/editar') . '/' . $vendedor->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>-->
                                <?php if ($vendedor->activo == 0): ?>
                                    <a class="action vendedor_habilitar" href="<?php echo site_url('admin/vendedores/habilitar') . '/' . $vendedor->id ?>" title="Habilitar"><i class="glyphicon glyphicon-check"></i></a>
                                <?php else: ?>
                                    <a class="action vendedor_inhabilitar" href="<?php echo site_url('admin/vendedores/inhabilitar') . '/' . $vendedor->id ?>" title="Inhabilitar"><i class="glyphicon glyphicon-remove"></i></a>
                                <?php endif; ?>                            
                                <a class="action vendedor_borrar" href="<?php echo site_url('admin/vendedores/borrar') . '/' . $vendedor->id ?>"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
