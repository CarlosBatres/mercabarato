<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Informacion del producto</h1>
            </div>            
        </div>
    </div>
</div>
<div id="content">
    <div class="container">    
        <div class="row" id="productMain">
            <div class="col-md-4 producto-img-container">                
                <?php if ($producto_imagen): ?>
                    <div class="row">
                        <div class="frame-ficha">
                            <span class="helper"></span>
                            <a href="<?php echo site_url("") ?>">                                                                
                                <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto_imagen->filename ?>" alt="" class="producto-img-ficha">                                            
                            </a>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="gallery-container">
                            <?php foreach ($producto_imagenes as $imagen): ?>
                                <div class="col-md-4 producto-img-container">
                                    <div class="frame-ficha-thumbnail">
                                        <span class="helper"></span>
                                        <a href="" data-id="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $imagen->filename ?>">                                                                
                                            <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/thumbnail/' . $imagen->filename ?>" alt="" class="producto-img">                                            
                                        </a>                        
                                    </div>
                                </div>                                
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?> 
                    <div class="row">
                        <div class="frame-ficha">
                            <span class="helper"></span>
                            <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="producto-img-ficha">
                        </div>
                    </div>
                <?php endif; ?>

            </div>        
            <div class="col-md-7 col-md-offset-1">
                <h3><?php echo $producto->nombre ?></h3>
                <div class="box ficha-producto">
                    <div class="ficha-producto-descripcion">
                        <?php if ($producto->descripcion != ""): ?>
                            <p class="lead"><?php echo $producto->descripcion ?></p>
                        <?php else: ?>
                            <p class="lead">No hay descripcion disponible.</p>
                        <?php endif; ?>
                    </div>
                    <div class="ficha-producto-precios">
                        <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                        <?php else: ?>
                            <?php if ($tarifa == 0 && $oferta == 0): ?>                    
                                <p class="price"><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></p>
                            <?php elseif ($oferta == 0 || ($tarifa < $oferta && ($tarifa != 0 && $oferta != 0))): ?>                    
                                <p class="price"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                <p class="price"><?php echo number_format($tarifa, '2') . ' ' . $this->config->item('money_sign') ?></p>
                            <?php elseif ($tarifa == 0 || ($tarifa > $oferta && ($tarifa != 0 && $oferta != 0))): ?>
                                <p class="price"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                <p class="price"><?php echo number_format($oferta, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                <p class="price-oferta text-center">Oferta valida hasta el <?php echo $fecha_finaliza?></p>                                                    
                            <?php endif; ?>                                                        
                        <?php endif; ?>
                    </div>
                </div>            
                <?php if ($producto->link_externo != ""): ?>                        
                    <p class="text-right"><strong><a href="http://<?php echo $producto->link_externo ?>"><?php echo $producto->link_externo ?></a></strong></p>                    
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($son_contactos): ?>
                        <div class="col-md-2 pull-right">
                            <div class="text-right">                                
                                <a href="<?php echo site_url('productos/enviar_mensaje/'.$producto->id) ?>" data-toggle="modal" data-target="#myModal" class="btn btn-template-primary" > Enviar Mensaje</a>
                            </div>                
                        </div>
                    <?php endif; ?>
                    <div class="col-md-3 pull-right">
                        <div class="text-right">                        
                            <a class="btn btn-template-primary" href="<?php echo site_url($vendedor_slug) ?>">Ir a la pagina del Vendedor</a>
                        </div>                
                    </div>
                </div>
            </div>
        </div>        
        <br><br>
        <?php if ($otros_productos): ?>
            <div class="row">
                <hr>
                <h3>Otros Productos del Vendedor</h3>
                <?php foreach ($otros_productos as $key => $producto): ?>
                    <div class="col-md-3">
                        <div class="row productos">
                            <div class="producto-img-container">
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
                            <div class="text-center">
                                <div class="row">
                                    <a class="nombre-productos" href="<?php echo site_url("productos/" . $producto->unique_slug) ?>"><?php echo truncate($producto->nombre, 100); ?></a>                                    
                                </div>

                                <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                                    <div class="row">
                                        <p class="precio"></p>
                                    </div>
                                <?php else: ?>
                                    <?php if ($producto->tipo == 'tarifa'): ?>
                                        <div class="row">
                                            <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                        </div>
                                        <div class="row">                            
                                            <p class="precio"><strong><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></strong></p>
                                        </div> 
                                    <?php elseif ($producto->tipo == 'oferta'): ?>
                                        <div class="row">
                                            <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                        </div>
                                        <div class="row">                            
                                            <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                        </div>  
                                    <?php else: ?>
                                        <div class="row">
                                            <p class="precio"><strong><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>                       
        <?php endif; ?>
        <?php if ($otros_productos_categoria): ?>
            <div class="row">
                <hr>
                <h3>Otros productos de la misma categoria</h3>
                <?php foreach ($otros_productos_categoria as $key => $producto): ?>
                    <div class="col-md-3">
                        <div class="row productos">
                            <div class="producto-img-container">
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
                            <div class="text-center">
                                <div class="row">
                                    <a class="nombre-productos" href="<?php echo site_url("productos/" . $producto->unique_slug) ?>"><?php echo truncate($producto->nombre, 100); ?></a>                                    
                                </div>

                                <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                                    <div class="row">
                                        <p class="precio"></p>
                                    </div>
                                <?php else: ?>
                                    <?php if ($producto->tipo == 'tarifa'): ?>
                                        <div class="row">
                                            <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                        </div>
                                        <div class="row">                            
                                            <p class="precio"><strong><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></strong></p>
                                        </div>
                                    <?php elseif ($producto->tipo == 'oferta'): ?>
                                        <div class="row">
                                            <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                        </div>
                                        <div class="row">                            
                                            <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                        </div> 
                                    <?php else: ?>
                                        <div class="row">
                                            <p class="precio"><strong><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>            
        <?php endif; ?>
    </div>
    <div id="myModal" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">                
            </div>
        </div>
        
    </div>
</div>