<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Informacion de la Empresa / Vendedor</h1>
            </div>            
        </div>
    </div>
</div>

<div id="content">
    <div class="container">  
        <div class="col-md-9">
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
                        <h3><?php echo $vendedor->nombre ?></h3>
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
                                        <?php if (isset($producto->tarifa_costo)): ?>
                                            <div class="row">
                                                <p class="precio"><del><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></del> </p>
                                            </div>
                                            <div class="row">                            
                                                <p class="precio"><strong><?php echo number_format($producto->tarifa_costo, '2') . ' ' . $this->config->item('money_sign') ?></strong></p>
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
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-template-primary"> Ver Mas</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-3">
            <?php if ($anuncios): ?>
                <div class="box box-anuncios">            
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <?php foreach ($anuncios as $anuncio): ?>
                                    <tr>
                                        <td>
                                            <p class="text-right"><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong></p>
                                            <p><strong><?php echo $anuncio->titulo; ?></strong></p>
                                            <p><?php echo truncate($anuncio->contenido, 300); ?></p>
                                        </td>                                
                                    </tr>
                                <?php endforeach; ?>                            
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>

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
            <div class="modal-body">
                <?php echo form_open('home/cliente/enviar_invitacion'); ?>
                <div class="row">  
                    <div class="col-md-12">
                        <div class="form-group">                                
                            <label>Titulo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="titulo">                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mensaje</label>
                            <textarea class="form-control" name="mensaje" rows="5" cols="20"></textarea>                    
                        </div>                                                        
                    </div>
                </div>
                <input type="hidden" name="vendedor_id" value="<?php echo $vendedor->id ?>">                                

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-template-main">Enviar</button>
                <button type="button" class="btn btn-template-main" data-dismiss="modal">Cancelar</button>
                <?php echo form_close(); ?>
            </div>
        </div>

    </div>
</div>