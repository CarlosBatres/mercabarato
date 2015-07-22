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
            <div class="col-sm-4">
                <div id="mainImage">
                    <?php if ($producto_imagen): ?>
                        <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto_imagen->filename ?>" alt="" class="img-responsive center-block">
                    <?php else: ?>   
                        <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="img-responsive center-block">
                    <?php endif; ?>
                </div>            
            </div>
            <div class="col-sm-8">
                <h3><?php echo $producto->nombre ?></h3>
                <div class="box">
                    <p class="lead"><?php echo $producto->descripcion ?></p>
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
                        <?php endif; ?>                                                        
                    <?php endif; ?>                                                        
                </div>            
                <?php if ($producto->link_externo != ""): ?>                        
                    <p class="text-right"><strong><a href="http://<?php echo $producto->link_externo ?>"><?php echo $producto->link_externo ?></a></strong></p>                    
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3 pull-right">
                        <div class="">
                            <button type="button" class="btn btn-template-primary" data-id="<?php echo $producto->vendedor_id ?>" data-toggle="modal" data-target="#myModal"> Enviar Mensaje</button>
                        </div>                
                    </div>
                    <div class="col-md-3 pull-right">
                        <div class="">                        
                            <a class="btn btn-template-primary" href="<?php echo site_url($vendedor_slug) ?>">Ir a la pagina del Vendedor</a>
                        </div>                
                    </div>
                </div>
            </div>
        </div>        
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
</div>