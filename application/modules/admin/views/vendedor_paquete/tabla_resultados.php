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
                <th style="width: 15%">Vendedor / Empresa</th>
                <th style="width: 15%">Email</th>
                <th style="width: 15%">Monto a Cancelar</th>
                <th style="width: 15%">Paquete</th>
                <th style="width: 15%">Fecha de Compra</th>
                <th style="width: 5%;text-align: center;">Aprobar</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendedor_paquetes as $vendedor_paquete): ?>
                <tr>
                    <td><?php echo $vendedor_paquete->id; ?></td>                    
                    <td><?php echo $vendedor_paquete->Vendedor; ?></td>
                    <td><?php echo $vendedor_paquete->email; ?></td>
                    <td><?php echo $vendedor_paquete->monto_a_cancelar .' '.$this->config->item('money_sign'); ?></td>                    
                    <td><?php echo $vendedor_paquete->nombre_paquete; ?></td>
                    <td><?php echo date("d-M-Y",strtotime($vendedor_paquete->fecha_comprado)); ?></td>
                    <td>
                        <div class="options">                            
                            <a class="item_aprobar" data-id="<?php echo $vendedor_paquete->id?>" href="<?php echo site_url('admin/vendedor_paquetes/aprobar') . '/' . $vendedor_paquete->id ?>" data-toogle="tooltip"  title="Aprobar este Paquete"><i class="glyphicon glyphicon-ok"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo $pagination;?>
</div> 
<?php endif; ?>
