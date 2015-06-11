<?php if ($search_params['total_paginas'] < 1): ?>
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
                            <a class="item_aprobar" href="<?php echo site_url('admin/vendedor_paquetes/aprobar') . '/' . $vendedor_paquete->id ?>" data-toogle="tooltip"  title="Aprobar este Paquete"><i class="glyphicon glyphicon-ok"></i></a>
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($search_params['total_paginas'] > 1): ?>
        <div class="col-md-6"> Mostrando 
            <?php echo ($search_params['desde'] < $search_params['hasta']) ? $search_params['desde'] . ' a ' . $search_params['hasta'] : ' el ' . $search_params['desde']; ?> 
            de <?php echo $search_params['total']; ?> resultados</div>
        <div class="col-md-6">
            <div class="paginacion-listado">
                <ul class="pagination">
                    <?php if ($search_params['anterior'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['anterior']; ?>" href="<?php echo site_url('admin/vendedor_paquetes/') . '/' . $search_params['anterior'] ?>">Anterior</a>
                        </li>
                    <?php endif; ?>
                    <?php
                    for ($i = 1; $i <= $search_params['total_paginas']; $i++) {
                        $class = "";
                        if ($i == $search_params['pagina']) {
                            $class = "active";
                        }
                        ?>
                        <li class="<?php echo $class; ?>">
                            <a data-id="<?php echo $i; ?>" href="<?php echo site_url('admin/vendedor_paquetes/') . '/' . $i ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($search_params['siguiente'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['siguiente']; ?>" href="<?php echo site_url('admin/vendedor_paquetes/') . '/' . $search_params['siguiente'] ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div> 
<?php endif; ?>
