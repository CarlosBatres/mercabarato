<?php if (sizeof($vendedores) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($vendedores as $key => $vendedor): ?>
            <li>
                <div class="row">
                    <div class="col-md-4">
                        <a class="thumbnail" href="<?php echo site_url("vendedor/ficha/" . $vendedor->id) ?>">                                                
                            <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <a href="<?php echo site_url("vendedor/ficha/" . $vendedor->id) ?>"><?php echo $vendedor->nombre; ?></a>
                        <?php if ($vendedor->descripcion != ""): ?>                         
                        <p><?php echo truncate($vendedor->descripcion,300) ?></p>                        
                        <?php endif; ?>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-4">                        
                        <?php if ($vendedor->direccion != ""): ?>                        
                            <p class="text-left"><i class="fa fa-map-marker fa-fw"></i><strong><?php echo $vendedor->direccion ?></strong></p>
                        <?php endif; ?>
                        <?php if ($vendedor->telefono_fijo != ""): ?>                        
                            <p class="text-left"><i class="fa fa-phone fa-fw"></i><strong><?php echo $vendedor->telefono_fijo ?></strong></p>
                                <?php endif; ?>
                    </div>                    
                </div>
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;