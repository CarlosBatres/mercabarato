<?php if (sizeof($productos) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> De momento no existe ningún producto que se ajuste a estos parámetros, puedes intentar lo siguiente: </p>    
            <ul>
                <li> Selecciona un lugar diferente ( <strong>Provincia o población </strong> ).</li>
                <li> Prueba con un nombre o palabras claves diferentes.</li>
                <li> Ingresa un rango de precios diferente.</li>
                <li> Selecciona una categoría diferente.</li>
            </ul>
        </div>        
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($productos as $key => $producto): ?>
            <li>
                <div class="row productos">
                    <div class="col-sm-12 col-md-4 producto-img-container">
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
                    <div class="col-sm-12 col-md-8">
                        <div class="row">
                            <div class="col-xs-12">
                                <a class="nombre-productos" href="<?php echo site_url("productos/" . $producto->unique_slug) ?>"><?php echo truncate($producto->nombre, 100); ?></a>
                                <p><?php echo truncate_html($producto->descripcion, 100); ?></p>                            
                            </div>
                        </div>

                        <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="precio">Consulte con el vendedor </p>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php if ($producto->tipo == 'tarifa' && $producto->nuevo_costo < $producto->precio): ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php if ($producto->precio_anterior == null || ($producto->precio_anterior != null && diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) < 5)): ?>
                                            <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del></p>
                                        <?php elseif (diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) >= 5): ?>
                                            <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del>  &nbsp;&nbsp;&nbsp; <del><?php echo $producto->precio_anterior . ' ' . $this->config->item('money_sign') ?></del></p>
                                        <?php endif; ?>                                                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                        </div>
                                    </div>                                                                        
                                <?php elseif ($producto->tipo == 'oferta' && $producto->nuevo_costo < $producto->precio): ?>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <?php if ($producto->precio_anterior == null || ($producto->precio_anterior != null && diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) < 5)): ?>
                                                <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del></p>
                                            <?php elseif (diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) >= 5): ?>
                                                <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del>  &nbsp;&nbsp;&nbsp; <del><?php echo $producto->precio_anterior . ' ' . $this->config->item('money_sign') ?></del></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?> <br>
                                                <span class="hidden-sm hidden-xs">OFERTA PROMOCIONAL hasta el <?php echo date("d-m-Y", strtotime($producto->fecha_finaliza)) ?></span>
                                                <span class="hidden-md hidden-lg">OFERTA <?php echo date("d-m-Y", strtotime($producto->fecha_finaliza)) ?></span>
                                            </p>
                                        </div>
                                    </div> 
                                <?php else: ?>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <?php if ($producto->precio_anterior == null || ($producto->precio_anterior != null && diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) < 5)): ?>
                                                <p class="precio"><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></p>
                                            <?php elseif (diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) >= 5): ?>
                                                <p class="precio"><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?>  &nbsp;&nbsp;&nbsp; <del><?php echo $producto->precio_anterior . ' ' . $this->config->item('money_sign') ?></del></p>                                    
                                            <?php endif; ?>
                                        </div>
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