<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1><?php echo $producto->nombre ?></h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url('') ?>">Inicio</a>
                    </li>
                    <li><a href="<?php echo site_url('productos') ?>">Productos</a>
                    </li>                    
                    <li><?php echo $producto->nombre ?></li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="container">    
    <div class="row" id="productMain">
        <div class="col-sm-6">
            <div id="mainImage">
                <img src="<?php echo assets_url("/uploads/imgs/".$producto_imagen->url_path)?>" alt="" class="img-responsive">
            </div>            
        </div>
        <div class="col-sm-6">
            <div class="box">
                <p class="lead"><?php echo $producto->descripcion ?></p>
                <form>                                        
                    <p class="price"><?php echo $producto->precio_venta_publico . ' ' . $this->config->item('money_sign') ?></p>
                    <p class="text-center">
                        <button type="submit" class="btn btn-template-main"><i class="fa fa-phone"></i> Solicitar Producto</button>                        
                    </p>

                </form>
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