<?php if ($search_params['total_paginas'] < 1): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>
<div class="row products">
    <?php foreach ($productos as $key=>$producto): ?>
        <div class="col-xs-3">
            <div class="product">
                <div class="image">
                    <a href="#">
                        <?php if ($producto["imagen_nombre"] === null): ?>
                            <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="img-responsive">
                        <?php else: ?>
                            <img src="<?php echo assets_url("uploads/imgs/" . $producto["imagen_nombre"]) ?>" alt="" class="img-responsive">
                        <?php endif; ?>

                    </a>
                </div>
                <!-- /.image -->
                <div class="text">
                    <h3><a href="#"><?php echo $producto["nombre"]; ?></a></h3>
                    <p class="price"><?php echo $producto["precio_venta_publico"] . ' ' . $this->config->item('money_sign') ?></p>                            
                </div>                        
            </div>                    
        </div>        
    <?php endforeach; ?>
</div>

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