<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Informacion del producto</h1>
            </div>            
        </div>
    </div>
</div>

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
                    <?php if ($tarifa): ?>                    
                        <p class="price"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                        <p class="price"><?php echo number_format($tarifa, '2') . ' ' . $this->config->item('money_sign') ?></p>
                    <?php else: ?>
                        <p class="price"><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></p>
                    <?php endif; ?>                                                        
                <?php endif; ?>                                                        
            </div>            
        </div>

    </div>

    <div class="box social" id="product-social">
        <h4>Compartelo con tus amigos</h4>
        <p>
            <a href="#" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
            <a href="#" class="external gplus" data-animate-hover="pulse"><i class="fa fa-google-plus"></i></a>
            <a href="#" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
            <a href="#" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
        </p>
    </div>
</div>