<?php if (sizeof($productos) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($productos as $key => $producto): ?>
            <li>
                <div class="row productos">
                    <div class="col-md-4 producto-img-container">
                        <div class="frame">
                            <span class="helper"></span>
                            <a href="<?php echo site_url("productos/" . $producto->unique_slug) ?>">                    
                                <?php if ($producto->imagen_nombre === null): ?>
                                    <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="producto-img">
                                <?php else: ?>
                                    <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto->imagen_nombre ?>" alt="" class="producto-img">
                                <?php endif; ?>
                            </a>                        
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <a class="nombre-productos" href="<?php echo site_url("productos/" . $producto->unique_slug) ?>"><?php echo truncate($producto->nombre, 100); ?></a>
                            <p><?php echo truncate(($producto->descripcion), 100); ?></p>
                        </div>

                        <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                            <div class="row">
                                <p class="precio">Consulte con el vendedor </p>
                            </div>
                        <?php else: ?>
                            <?php if ($producto->tipo == 'tarifa'): ?>
                                <div class="row">
                                    <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                </div>
                                <div class="row">                            
                                    <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                </div>                                                                        
                            <?php elseif ($producto->tipo == 'oferta'): ?>
                                <div class="row">
                                    <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                </div>
                                <div class="row">                            
                                    <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?> <span>Oferta hasta el <?php echo date("d-m-Y",strtotime($producto->fecha_finaliza))?></span></p>
                                    
                                </div> 
                            <?php else: ?>
                                <div class="row">
                                    <p class="precio"><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;