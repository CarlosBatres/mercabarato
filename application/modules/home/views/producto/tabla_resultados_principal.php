<?php if (sizeof($productos)==0): ?>
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

    <?php echo $pagination; ?>    
<?php endif;