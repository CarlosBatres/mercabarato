<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Información del producto</h1>
            </div>            
        </div>
    </div>
</div>
<div id="content">
    <div class="container">    
        <div class="row">            
            <div class="col-md-8 col-md-offset-2">
                <h3><?php echo $anuncio->titulo ?></h3>                
                <?php echo $anuncio->contenido ?>
            </div>  
        </div>   
        <br>
        <?php if ($otros_productos): ?>
            <div class="row">
                <hr>
                <h3>Productos del Vendedor</h3>
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
    </div>
</div>