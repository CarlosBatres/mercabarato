<?php if (sizeof($vendedores) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($vendedores as $key => $vendedor): ?>
            <li>
                <div class="row vendedores">
                    <div class="col-md-4 vendedor-img-container">
                        <div class="frame">
                            <span class="helper"></span>
                            <a href="<?php echo site_url($vendedor->unique_slug) ?>">                                                
                                <?php if ($vendedor->filename == null): ?>
                                    <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="vendedor-img">
                                <?php else: ?>
                                    <img src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $vendedor->filename ?>" alt="" class="vendedor-img">
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <a href="<?php echo site_url($vendedor->unique_slug) ?>"><?php echo $vendedor->nombre; ?></a>
                            <?php if ($vendedor->descripcion != ""): ?>                         
                                <p><?php echo truncate($vendedor->descripcion, 300) ?></p>  
                            <?php else: ?>
                                <br>
                                <p></p>
                                <br>
                            <?php endif; ?>
                        </div>
                        <hr>
                        <div class="row">
                            <?php if ($vendedor->direccion != ""): ?>                        
                                <p class="text-left"><i class="fa fa-map-marker fa-fw"></i><strong><?php echo $vendedor->direccion ?></strong></p>
                            <?php endif; ?>
                            <?php if ($vendedor->telefono_fijo != ""): ?>                        
                                <p class="text-left"><i class="fa fa-phone fa-fw"></i><strong><?php echo $vendedor->telefono_fijo ?></strong></p>
                            <?php endif; ?>
                            <p class="text-left">
                                <?php
                                echo ($vendedor->poblacion != null) ? $vendedor->poblacion . ' , ' : '';
                                echo ($vendedor->provincia != null) ? $vendedor->provincia . ' , ' : '';
                                echo ($vendedor->pais != null) ? $vendedor->pais : '';
                                ?>
                            </p>
                        </div>
                        <?php if (!isset($vendedor->invitacion_cliente_id) && $logged_in):  ?>
                        <div class="row">
                            <div class="text-center">
                                <button type="button" class="btn btn-template-primary" data-id="<?php echo $vendedor->id ?>" data-toggle="modal" data-target="#myModal"> Solicitar Invitación</button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>                    
                </div>

            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;