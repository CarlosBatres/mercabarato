<?php if ($search_params['total_paginas'] < 1): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($productos as $key => $producto): ?>
            <li>
                <div class="row productos">
                    <div class="col-md-4">
                        <a href="<?php echo site_url("productos/ficha/" . $producto->id) ?>">                    
                            <?php if ($producto->imagen_nombre === null): ?>
                            <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" width="120" height="120">
                            <?php else: ?>
                                <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto->imagen_nombre ?>" alt="" width="120" height="120">
                            <?php endif; ?>

                        </a>
                    </div>
                    <div class="col-md-5">
                        <a class="nombre-productos" href="<?php echo site_url("productos/ficha/" . $producto->id) ?>"><?php echo $producto->nombre; ?></a>
                    </div>
                    <div class="col-md-3">
                        <p class="precio text-right"><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></p>
                    </div>
                </div>
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php if ($search_params['total_paginas'] > 1): ?>
        <div class="col-md-6"><p> Mostrando 
                <?php echo ($search_params['desde'] < $search_params['hasta']) ? $search_params['desde'] . ' a ' . $search_params['hasta'] : ' el ' . $search_params['desde']; ?> 
                de <?php echo $search_params['total']; ?> resultados</p></div>
        <div class="col-md-6">
            <div class="paginacion-listado">
                <ul class="pagination">
                    <?php if ($search_params['anterior'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['anterior']; ?>" href="<?php echo site_url('productos/') . '/' . $search_params['anterior'] ?>">Anterior</a>
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
                            <a data-id="<?php echo $i; ?>" href="<?php echo site_url('productos/') . '/' . $i ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($search_params['siguiente'] != -1): ?>
                        <li>
                            <a data-id="<?php echo $search_params['siguiente']; ?>" href="<?php echo site_url('productos/') . '/' . $search_params['siguiente'] ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?> 
<?php endif; ?>