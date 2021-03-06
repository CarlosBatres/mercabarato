<?php if (sizeof($vendedores) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> De momento no existe ningún vendedor que se ajuste a estos parámetros, puedes intentar lo siguiente: </p>    
            <ul>
                <li> Selecciona un lugar diferente ( <strong>Provincia o población </strong> ).</li>
                <li> Prueba con un nombre o palabras claves diferentes.</li>
            </ul>
        </div>        
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($vendedores as $key => $vendedor): ?>
            <li>
                <div class="row vendedores">
                    <div class="col-sm-12 col-md-4 vendedor-img-container">
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
                    <div class="col-md-8 col-sm-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?php echo site_url($vendedor->unique_slug) ?>"><?php echo $vendedor->nombre; ?></a>
                                <?php if ($vendedor->descripcion != ""): ?>                         
                                    <p><?php echo truncate($vendedor->descripcion, 300) ?></p>  
                                <?php else: ?>
                                    <br>
                                    <p></p>
                                    <br>
                                <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
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
                        </div>
                        <?php if ($logged_in): ?>                                                
                            <?php if ($vendedor->invitacion_id1 == null && $vendedor->invitacion_id2 == null && $vendedor_id_logged != $vendedor->id): ?>
                                <div class="row">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-template-primary" data-id="<?php echo $vendedor->id ?>" data-toggle="modal" data-target="#myModal"> Solicitar Invitación</button>
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