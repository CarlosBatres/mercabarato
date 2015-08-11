<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Requisitos de la oferta</h4>    
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">                                                
            <p> Visita los siguientes productos:</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">                                                
            <?php foreach ($productos as $key => $producto): ?>
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
                            <div class="row">
                                <p class="precio"><strong><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>              
    </div>
</div>
<div class="modal-footer">
    <!--                    <button type="submit" class="btn btn-template-main">Enviar</button>-->
    <button type="button" class="btn btn-template-main" data-dismiss="modal">Volver</button>                    
</div>

