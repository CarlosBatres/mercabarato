<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1> <?php echo $vendedor->nombre ?></h1>
            </div>            
        </div>
    </div>
</div>

<div id="content">
    <div class="container">  
        <div class="<?php echo ($anuncios) ? "col-md-9" : "col-md-12"; ?>">
            <div class="row" id="productMain">
                <div class="row">
                    <div class="col-md-4">
                        <div id="mainImage">
                            <?php if ($vendedor->filename != null): ?>
                                <img src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $vendedor->filename ?>" alt="" class="img-responsive center-block">
                            <?php else: ?>   
                                <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="img-responsive center-block">
                            <?php endif; ?>
                        </div>            
                        <br>
                        <hr>
                        <?php if ($vendedor->sitio_web != ""): ?>                        
                            <p class="text-right"><strong><a href="http://<?php echo $vendedor->sitio_web ?>"><?php echo $vendedor->sitio_web ?></a></strong></p>                    
                        <?php endif; ?>
                        <?php if ($vendedor->direccion != ""): ?>                        
                            <p class="text-right"><i class="fa fa-map-marker fa-fw"></i><strong><?php echo $vendedor->direccion ?></strong></p>
                        <?php endif; ?>
                        <?php if ($vendedor->telefono_fijo != ""): ?>                        
                            <p class="text-right"><i class="fa fa-phone fa-fw"></i><strong><?php echo $vendedor->telefono_fijo ?></strong></p>
                        <?php endif; ?>
                        <?php if ($vendedor->telefono_movil != ""): ?>                        
                            <p class="text-right"><i class="fa fa-mobile fa-fw"></i><strong><?php echo $vendedor->telefono_movil ?></strong></p>
                        <?php endif; ?>
                        <p class="text-right">
                            <?php
                            echo (isset($localizacion->poblacion)) ? $localizacion->poblacion . ' , ' : '';
                            echo (isset($localizacion->provincia)) ? $localizacion->provincia . ' , ' : '';
                            echo (isset($localizacion->pais)) ? $localizacion->pais : '';
                            ?>
                        </p>
                    </div>
                    <div class="col-md-8">
<!--                        <h3><?php echo $vendedor->nombre ?></h3>-->
                        <div class="">
                            <?php if ($vendedor->descripcion != ""): ?> 
                                <p class="lead"><?php echo $vendedor->descripcion ?></p>                                    
                            <?php else: ?>    
                                <p>No hay información adicional disponible.</p>
                            <?php endif; ?>                            
                        </div>            
                    </div>
                </div>                
            </div>
            <?php if (!$invitacion && !$son_contactos): ?>
                <div class="row">
                    <div class="col-md-12 pull-right">
                        <div class="text-right">
                            <button type="button" class="btn btn-template-primary" data-id="<?php echo $vendedor->id ?>" data-toggle="modal" data-target="#sendInviteModal"> Solicitar Invitación</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($productos): ?>
                <div class="row">
                    <hr>
                    <h3>Productos del Vendedor</h3>
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

                                    <?php if ($producto->mostrar_precio == 0 && !$this->authentication->is_loggedin()): ?>
                                        <div class="row">
                                            <p class="precio"></p>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($producto->tipo == 'tarifa' && $producto->nuevo_costo < $producto->precio): ?>
                                            <div class="row">
                                                <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                            </div>
                                            <div class="row">                            
                                                <p class="precio"><strong><?php echo number_format($producto->nuevo_costo, '2') . ' ' . $this->config->item('money_sign') ?></strong></p>
                                            </div>     
                                        <?php elseif ($producto->tipo == 'oferta' && $producto->nuevo_costo < $producto->precio): ?>
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
                <div class="col-xs-6 pull-right">
                    <div class="text-right">
                        <a href="<?php echo site_url($vendedor->unique_slug . "/productos"); ?>" class="btn btn-template-primary"> Ver Mas</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($infocompras): ?>                            
                <div class="col-xs-6 pull-left">
                    <div class="text-left">
                        <button type="button" class="btn btn-template-primary" id="enviar-solicitud-seguros"> Enviar Solicitud Seguros</button>
                    </div>
                </div>                
                <div class="row formularios-seguros" style="display:none;">
                    <div class="col-md-12">
                        <?php echo $formularios; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>        

        <?php if ($anuncios): ?>
            <div class="col-sm-12 col-md-3">
                <div class="row anuncios-header">
                    <h3 class="text-center">Anuncios</h3>
                </div>
                <?php
                if (sizeof($anuncios) > 0):
                    foreach ($anuncios as $anuncio):
                        ?>

                        <div class="row">
                            <div class="col-xs-12">                                
                                <div class="anuncio-contenido">
                                    <p class="text-right"><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong></p>
                                    <p><a href="<?php echo site_url("anuncios/" . $anuncio->id) ?>"><strong><?php echo $anuncio->titulo; ?></strong></a></p>                                                
                                    <p><?php echo strip_tags(truncate($anuncio->contenido, 300)); ?></p>
                                </div>
                                <hr>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <p> No hay novedades...</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Invitacion a Vendedor</h4>
            </div>
            <?php echo form_open('home/cliente/enviar_invitacion', 'rel="preventDoubleSubmission"'); ?>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label><strong>Titulo</strong></label>                        
                    <input type="text" class="form-control" name="titulo" autofocus="" autocomplete="off">                                    
                </div>                            

                <div class="form-group">                    
                    <label><strong>Mensaje</strong></label>
                    <textarea class="form-control" name="mensaje" rows="5" cols="20" style="resize: none;"></textarea>                    
                </div> 
                <input type="hidden" name="vendedor_id" value="<?php echo $vendedor->id ?>">                                

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-template-primary">Enviar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>                
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div id="sendInviteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Invitacion a Vendedor</h4>
            </div>
            <?php echo form_open('usuario/enviar_invitacion', 'rel="preventDoubleSubmission"'); ?>
            <div class="modal-body">                
                <div class="form-group">                    
                    <label><strong>Titulo</strong></label>                        
                    <input type="text" class="form-control" name="titulo" autofocus="" autocomplete="off">                                    
                </div>                            

                <div class="form-group">                    
                    <label><strong>Mensaje</strong></label>
                    <textarea class="form-control" name="mensaje" rows="5" cols="20" style="resize: none;"></textarea>                    
                </div> 
                <input type="hidden" name="vendedor_id" value="">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-template-primary">Enviar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>                
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>