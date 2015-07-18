<?php if (sizeof($clientes)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 5%">ID</th>
                    <th style="width: 15%">Nombre Completo</th>                                                        
                    <th style="width: 15%">Email</th>
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
                        <?php if ($cliente->ultimo_acceso != null): ?>
                            <td><?php echo time_elapsed_string($cliente->ultimo_acceso); ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>
                        <td>
                            <div class="options">
                                <a href="<?php echo site_url('admin/vendedores_admin/ver_informacion') . '/' . $cliente->id ?>" data-toogle="tooltip"  title="Ver Informacion"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="item_cancelar" href="<?php echo site_url('admin/vendedores_admin/cancelar') . '/' . $cliente->usuario_id ?>" data-toogle="tooltip"  title="Quitar Privilegios"><i class="glyphicon glyphicon-remove"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php echo $pagination;?>
</div> 
<?php endif; ?>
