<?php if (sizeof($vendedor_paquetes)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 5%">ID</th>
                    <th style="width: 15%">Identificacion</th>                                                        
                    <th style="width: 15%">Email</th>
                    <th style="width: 15%">Paquete</th>                                    
                    <th style="width: 15%">Costo</th>                                    
                    <th style="width: 15%">Fecha Aprobacion</th>                                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendedor_paquetes as $vendedor): ?>
                    <tr>
                        <td><?php echo $vendedor->id; ?></td>                    
                        <?php if ($vendedor->vendedor_nombre != null): ?>
                            <td><?php echo $vendedor->vendedor_nombre; ?></td>                                                                                    
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>                                                

                        <td><?php echo $vendedor->email; ?></td>
                        <td><?php echo $vendedor->nombre_paquete; ?></td>
                        <td><?php echo $vendedor->monto_a_cancelar.' '.$this->config->item('money_sign'); ?></td>
                        <td><?php echo date('d-M-Y', strtotime($vendedor->fecha_aprobado)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php echo $pagination;?>
</div> 
<?php endif; ?>
