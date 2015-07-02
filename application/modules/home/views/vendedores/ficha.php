<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php echo $vendedor->nombre ?></h1>
            </div>            
        </div>
    </div>
</div>

<div class="container">    
    <div class="row" id="productMain">
        <div class="col-sm-4">
            <div id="mainImage">
                <?php if ($vendedor_image): ?>
                    <img src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $vendedor_image->filename ?>" alt="" class="img-responsive">
                <?php else: ?>   
                    <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="img-responsive">
                <?php endif; ?>
            </div>            
        </div>
        <div class="col-sm-8">
            <div class="box">
                <p class="lead"><?php echo $vendedor->descripcion ?></p>                                    
                <?php if ($vendedor->sitio_web != ""): ?>                        
                <p class="text-left"><strong><a href="http://<?php echo $vendedor->sitio_web ?>"><?php echo $vendedor->sitio_web ?></a></strong></p>
                    <br>
                <?php endif; ?>
                <?php if ($vendedor->direccion != ""): ?>                        
                    <p class="text-left"><i class="fa fa-map-marker fa-fw"></i><strong><?php echo $vendedor->direccion ?></strong></p>
                <?php endif; ?>
                <?php if ($vendedor->telefono_fijo != ""): ?>                        
                    <p class="text-left"><i class="fa fa-phone fa-fw"></i><strong><?php echo $vendedor->telefono_fijo ?></strong></p>
                <?php endif; ?>
                <p class="text-left">
                    <?php
                    echo (isset($localizacion->poblacion)) ? $localizacion->poblacion . ' , ' : '';
                    echo (isset($localizacion->provincia)) ? $localizacion->provincia . ' , ' : '';
                    echo (isset($localizacion->pais)) ? $localizacion->pais : '';
                    ?>
                </p>
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