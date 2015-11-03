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
        <div class="row" id="productMain">
            <div class="col-md-4 producto-img-container">                
                <?php if ($producto_imagen): ?>
                    <div class="row">
                        <div class="frame-ficha">
                            <span class="helper"></span>
                            <a href="">                                                                
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
                <?php elseif ($vendedor->filename != null): ?> 
                    <div class="row">
                        <div class="frame-ficha">
                            <span class="helper"></span>
                            <a href="<?php echo site_url("") ?>">                                                                
                                <img src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $vendedor->filename ?>" alt="" class="producto-img-ficha">                                            
                            </a>                        
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
                            <p class="lead">No hay descripción disponible.</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-12 text-center">    
                        <?php if ($producto->grupo_txt != ""): ?>
                            <a href="<?php echo site_url($vendedor->unique_slug . '/productos/' . $producto->grupo_txt) ?>" class="btn btn-success" > <?php echo $producto->grupo_txt; ?></a>                    
                        <?php endif; ?>
                        <?php if ($producto->familia_txt != ""): ?>
                            <a href="<?php echo site_url($vendedor->unique_slug . '/productos/' . $producto->grupo_txt . '/' . $producto->familia_txt) ?>" class="btn btn-success" > <?php echo $producto->familia_txt; ?></a>
                        <?php endif; ?>
                        <?php if ($producto->subfamilia_txt != ""): ?>
                            <a href="<?php echo site_url($vendedor->unique_slug . '/productos/' . $producto->grupo_txt . '/' . $producto->familia_txt . '/' . $producto->subfamilia_txt) ?>" class="btn btn-success" > <?php echo $producto->subfamilia_txt; ?></a>
                        <?php endif; ?>
                    </div>
                    <br>
                    <div class="ficha-producto-precios">
                        <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                            <br><br>
                            <p class="lead text-center"><strong> Precio a consultar con el vendedor.</strong></p>
                        <?php elseif ($producto->mostrar_precio == 0 && $this->authentication->is_loggedin() && !$son_contactos): ?>
                            <br><br>
                            <p class="lead text-center"><strong> Precio a consultar con el vendedor.</strong></p>
                        <?php else: ?>                            
                            <?php if ($tarifa < $oferta): ?>                                

                                <?php echo print_precio('price', $producto->precio, true, $producto->precio_anterior, true); ?>
                            
                                <?php if ($tarifa <= 0): ?>
                                    <?php echo print_tarifa("price-sm", $tarifa); ?>
                                <?php else: ?>
                                    <?php echo print_tarifa("price", $tarifa); ?>
                                <?php endif; ?>

                                <p class="price-tarifa-resaltado text-center"><?php echo ($tarifa_texto) ? $tarifa_texto : "" ?></p> 
                            <?php elseif ($oferta < $tarifa): ?>
                                
                                <?php echo print_precio('price', $producto->precio, true, $producto->precio_anterior, true); ?>

                                <?php if ($oferta_id): ?>
                                    <a href="<?php echo site_url('productos/ver-oferta-requisitos/' . $oferta_id) ?>" data-toggle="modal" data-target="#ofertaModal">
                                        <p class="price"><?php echo number_format($oferta, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                        <p class="price-oferta text-center">OFERTA PROMOCIONAL valida hasta el <?php echo $fecha_finaliza ?></p>                                                    
                                    </a>
                                <?php else: ?>
                                    <div class="price-oferta-sinrequisitos-link">
                                        <p class="price"><?php echo number_format($oferta, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                        <p class="price-oferta text-center">OFERTA PROMOCIONAL valida hasta el <?php echo $fecha_finaliza ?></p>                                                    
                                    </div>
                                <?php endif; ?>        
                            <?php else: ?> 
                                
                                <?php echo print_precio('price', $producto->precio, false, $producto->precio_anterior, true); ?>                                

                            <?php endif; ?>                                                        
                        <?php endif; ?>
                    </div>
                    <div class="ficha-producto-extra text-right">
                        <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>                            
                        <?php else: ?>  
                            <?php foreach ($producto_extras as $ext): ?>
                                <p class="destacado"><?php echo $ext->value . ' por ' . $ext->nombre . ' unidades' ?></p>                        
                            <?php endforeach; ?>
                            <br>
                        <?php endif; ?>

                        <?php if ($producto->transporte == 1): ?>
                            <p><strong>Transporte gratuito </strong><br><?php echo ($producto->transporte_txt != '') ? $producto->transporte_txt : '' ?></p>                        
                        <?php endif; ?>
                        <?php if ($producto->impuesto != null): ?>
                            <p>
                                <?php if ($producto->impuesto == 1): ?>
                                    <strong>Impuestos incluidos </strong><br>
                                <?php elseif ($producto->impuesto == 0 && ($producto->impuesto_txt == '' || $producto->impuesto_txt == null)): ?>
                                    <strong>Impuestos sin incluir </strong><br>
                                <?php elseif ($producto->impuesto == 0 && $producto->impuesto != ''): ?>
                                    <strong>Impuestos sin incluir </strong><br>
                                    <?php echo $producto->impuesto_txt ?>
                                <?php endif; ?>                                
                            </p>
                        <?php endif; ?>
                    </div>                                        
                </div>                 
                <?php if ($producto->link_externo != ""): ?>                        
                    <p class="text-right"><strong><a href="http://<?php echo $producto->link_externo ?>"><?php echo $producto->link_externo ?></a></strong></p>                    
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6 pull-right">
                        <div class="text-right">                        
                            <!--<a class="btn btn-template-primary" href="<?php echo site_url($vendedor->unique_slug) ?>">Ir a la pagina del Vendedor</a>-->                            
                            <a href="<?php echo site_url($vendedor->unique_slug) ?>"><strong><?php echo $vendedor->nombre ?></strong></a>
                            <?php if ($vendedor->direccion != ""): ?>                        
                                <p class="text-right"><i class="fa fa-map-marker fa-fw"></i><strong><?php echo $vendedor->direccion ?></strong></p>
                            <?php endif; ?>
                            <p class="text-right">
                                <?php
                                echo (isset($localizacion->poblacion)) ? $localizacion->poblacion . ' , ' : '';
                                echo (isset($localizacion->provincia)) ? $localizacion->provincia . ' , ' : '';
                                echo (isset($localizacion->pais)) ? $localizacion->pais : '';
                                ?>
                            </p>

                        </div>                
                    </div>
                    <?php if ($son_contactos): ?>
                        <div class="col-md-12 pull-right">
                            <div class="text-right">                                
                                <a href="<?php echo site_url('productos/enviar_mensaje/' . $producto->id) ?>" data-toggle="modal" data-target="#myModal" class="btn btn-template-primary" > Enviar Mensaje</a>
                            </div>                
                        </div>
                    <?php elseif (!$invitacion && !$mi_pagina): ?>
                        <div class="col-md-12 pull-right">
                            <div class="text-right">
                                <button type="button" class="btn btn-template-primary" data-id="<?php echo $producto->vendedor_id ?>" data-toggle="modal" data-target="#sendInviteModal"> Solicitar Invitación</button>
                            </div>
                        </div>
                    <?php endif; ?>                    
                </div>
            </div>
        </div>        
        <br><br>
        <?php if ($otros_productos): ?>            
            <br>
            <hr>
            <div class="row sub-productos">                
                <h3>Otros Productos del Vendedor</h3>
                <?php foreach ($otros_productos as $key => $producto): ?>
                    <div class="col-md-3">
                        <div class="row productos">
                            <div class="producto-img-container">
                                <div class="frame">
                                    <span class="helper"></span>
                                    <a href="<?php echo site_url("productos/" . $producto->unique_slug) ?>">                    
                                        <?php if ($producto->imagen_nombre === null && $producto->imagen_vendedor === null): ?>
                                            <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="producto-img">
                                        <?php elseif ($producto->imagen_nombre === null): ?>                                    
                                            <img src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $producto->imagen_vendedor ?>" alt="" class="producto-img">
                                        <?php else: ?>    
                                            <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto->imagen_nombre ?>" alt="" class="producto-img">
                                        <?php endif; ?>
                                    </a>                        
                                </div>
                            </div>
                            <div class="col-xs-11">
                                <div class="text-center">
                                    <div class="row">
                                        <a class="nombre-productos" href="<?php echo site_url("productos/" . $producto->unique_slug) ?>"><?php echo truncate($producto->nombre, 100); ?></a>                                    
                                    </div>

                                    <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                                        <div class="row">
                                            <p class="precio"></p>
                                        </div>
                                    <?php elseif ($producto->mostrar_precio == 0 && $this->authentication->is_loggedin() && !$producto->invitacion): ?>
                                        <div class="row">
                                            <p class="precio"></p>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($producto->tipo == 'tarifa'): ?>
                                            <div class="row">                                                
                                                <?php echo print_precio('precio', $producto->precio, true, $producto->precio_anterior, true); ?>                                                
                                            </div>
                                            <div class="row">                            
                                                <?php echo print_tarifa("precio", $producto->nuevo_costo); ?>
                                            </div> 
                                        <?php elseif ($producto->tipo == 'oferta' && $producto->nuevo_costo < $producto->precio): ?>
                                            <div class="row">
                                                <?php echo print_precio('precio', $producto->precio, true, $producto->precio_anterior, true); ?>                                                
                                            </div>
                                            <div class="row">                            
                                                <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></p>                                                
                                            </div>  
                                        <?php else: ?>
                                            <div class="row">
                                                <?php echo print_precio('precio', $producto->precio, false, $producto->precio_anterior, true); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>                    
                <?php endforeach; ?>
                <div class="col-xs-6 pull-right">
                    <div class="text-right">
                        <a href="<?php echo site_url($vendedor->unique_slug . "/productos"); ?>" class="btn btn-template-primary"> Ver Mas</a>
                    </div>
                </div>
            </div>                       
        <?php endif; ?>
        <?php if ($otros_productos_categoria): ?>
            <div class="row sub-productos">
                <hr>
                <h3>Otros productos de la misma categoria</h3>
                <?php foreach ($otros_productos_categoria as $key => $producto): ?>
                    <div class="col-md-3">
                        <div class="row productos">
                            <div class="producto-img-container">
                                <div class="frame">
                                    <span class="helper"></span>
                                    <a href="<?php echo site_url("productos/" . $producto->unique_slug) ?>">                    
                                        <?php if ($producto->imagen_nombre === null && $producto->imagen_vendedor === null): ?>
                                            <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="producto-img">
                                        <?php elseif ($producto->imagen_nombre === null): ?>                                    
                                            <img src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $producto->imagen_vendedor ?>" alt="" class="producto-img">
                                        <?php else: ?>    
                                            <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto->imagen_nombre ?>" alt="" class="producto-img">
                                        <?php endif; ?>
                                    </a>                        
                                </div>
                            </div>
                            <div class="col-xs-11">
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
                                                <?php echo print_precio('precio', $producto->precio, true, $producto->precio_anterior, true); ?>
                                            </div>
                                            <div class="row">                            
                                                <?php echo print_tarifa("precio", $producto->nuevo_costo); ?>
                                            </div>
                                        <?php elseif ($producto->tipo == 'oferta' && $producto->nuevo_costo < $producto->precio): ?>
                                            <div class="row">
                                                <?php echo print_precio('precio', $producto->precio, true, $producto->precio_anterior, true); ?>
                                            </div>
                                            <div class="row">                            
                                                <p class="precio"><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></p>
                                            </div> 
                                        <?php else: ?>
                                            <div class="row">
                                                <?php echo print_precio('precio', $producto->precio, false, $producto->precio_anterior, true); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
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
    <div id="sendInviteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Invitación a Vendedor</h4>
                </div>
                <?php echo form_open('usuario/enviar_invitacion', "rel='preventDoubleSubmission'"); ?>
                <div class="modal-body">                    
                    <div class="row">  
                        <div class="col-md-12">                            
                            <div class="form-group">                                                                
                                <label><strong>Titulo</strong></label>                                
                                <input type="text" class="form-control" name="titulo">                                
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label><strong>Mensaje</strong></label>
                                <textarea class="form-control" name="mensaje" rows="5" cols="20"></textarea>                    
                            </div>                                                        
                        </div>
                    </div>
                    <input type="hidden" name="vendedor_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>                    
                </div>
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>
    <div id="ofertaModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">                
            </div>
        </div>

    </div>
</div>