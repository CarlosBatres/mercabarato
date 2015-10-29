<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Producto
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box_registro">
                <h2 class="text-uppercase">Información del producto</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('panel_vendedor/producto/editar/' . $producto->id, 'id="admin_producto_form"'); ?>                                 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="<?php echo $producto->nombre; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción</label>                                                
                            <textarea class="form-control" id="content" name="descripcion" rows="10"><?php echo $producto->descripcion; ?></textarea>                                                                    
                            <?php echo display_ckeditor($ckeditor); ?>
                        </div>
                    </div>
                </div> 
                <div class="row" id="grupo-imagenes">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione varias imágenes para el producto ( Limite 3 y solo JPG , GIF y PNG )</label>
                            <br><br>                            
                            <?php if ($producto_imagenes): ?>
                                <?php foreach ($producto_imagenes as $image):
                                    ?>                                    
                                    <div class="col-md-4 producto-img-container">
                                        <div class="frame">
                                            <span class="helper"></span>
                                            <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $image->filename ?>" class="producto-img"/>
                                        </div>
                                    </div>
                                <?php endforeach; ?> 

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" id="cambiar_imagen" class="btn btn-lg btn-primary"> Reemplazar todas las imágenes</button>                                
                                        <div class='fileupload_button' style='display:none'>
                                            <input id="fileupload" type="file" name="files[]" multiple data-url="<?php echo site_url('panel_vendedor/producto/upload_image') ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <input id="fileupload" type="file" name="files[]" multiple data-url="<?php echo site_url('panel_vendedor/producto/upload_image') ?>">                                
                            <?php endif; ?>
                            <input type="hidden" name="file_name" id="file_name" value="">                    
                        </div> 
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-danger" id="fileupload_alert" style="display:none;"> 
                            <a class="close" data-dismiss="alert">×</a>
                            <span>Debe seleccionar un máximo de 3 imágenes.</span>
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">                                
                                <span class="titulo">Precio según el número de artículos comprados</span>                                
                            </div>
                            <div class="panel-body"> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">                            
                                            <label>Precio Venta Publico ( por unidad )</label>
                                            <input type="text" class="form-control" name="precio" value="<?php echo $producto->precio; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                            
                                            <label>Precio Venta Publico anterior</label>
                                            <input type="text" class="form-control" disabled="" name="precio_anterior" value="<?php echo $producto->precio_anterior; ?>">
                                        </div>
                                    </div>                                    
                                    <div class="col-md-4">
                                        <div class="form-group">                            
                                            <label>Fecha ultima modificación</label>
                                            <input type="text" class="form-control" disabled="" name="fecha_anterior" value="<?php echo ($producto->fecha_precio_modificar==null)?"Sin modificar":date('d-m-Y',strtotime($producto->fecha_precio_modificar)); ?>">
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-5">                                        
                                        <div class="form-group">                            
                                            <label>Precio Venta ( precio o texto descriptivo )</label>
                                            <input type="text" class="form-control" name="precio_extra1" value="<?php echo (isset($producto_extras["0"])) ? $producto_extras["0"]->value : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <br><p class="lead"><strong>x</strong></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Cantidad de artículos ( solo numero )</label>
                                        <input type="text" class="form-control" name="precio_extra1_cantidad" value="<?php echo (isset($producto_extras["0"])) ? $producto_extras["0"]->nombre : "" ?>">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">                                                                        
                                            <input type="text" class="form-control" name="precio_extra2" value="<?php echo (isset($producto_extras["1"])) ? $producto_extras["1"]->value : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <p class="lead"><strong>x</strong></p>
                                    </div>
                                    <div class="col-md-6">                                        
                                        <input type="text" class="form-control" name="precio_extra2_cantidad" value="<?php echo (isset($producto_extras["1"])) ? $producto_extras["1"]->nombre : "" ?>">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">                                                                        
                                            <input type="text" class="form-control" name="precio_extra3" value="<?php echo (isset($producto_extras["2"])) ? $producto_extras["2"]->value : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <p class="lead"><strong>x</strong></p>
                                    </div>
                                    <div class="col-md-6">                                        
                                        <input type="text" class="form-control" name="precio_extra3_cantidad" value="<?php echo (isset($producto_extras["2"])) ? $producto_extras["2"]->nombre : "" ?>">
                                    </div>
                                </div>

                            </div>                
                        </div> 
                    </div>
                </div>
                <br>                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">                                
                                <span class="titulo">Opciones adicionales</span>                                
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group">                            
                                        <label>Enlace externo al producto</label>
                                        <input type="text" class="form-control" name="link_externo" value="<?php echo $producto->link_externo; ?>">
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br>
                                        <label>Desea mostrar el producto al publico general?</label><br>
                                        <label>Si<input type="radio" name="mostrar_producto" id="mostrar_si" value="1" class="radioInput" <?php echo ($producto->mostrar_producto == 1) ? "checked" : ""; ?>></label>
                                        <label>No<input type="radio" name="mostrar_producto" id="mostrar_no" value="0" class="radioInput" <?php echo ($producto->mostrar_producto == 0) ? "checked" : ""; ?>></label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br>
                                        <label>Desea mostrar el precio al publico general?</label><br>
                                        <label>Si<input type="radio" name="mostrar_precio" id="mostrar_precio_si" value="1" class="radioInput" <?php echo ($producto->mostrar_precio == 1) ? "checked" : ""; ?>></label>
                                        <label>No<input type="radio" name="mostrar_precio" id="mostrar_precio_no" value="0" class="radioInput" <?php echo ($producto->mostrar_precio == 0) ? "checked" : ""; ?>></label>

                                    </div>                                                                        
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br>
                                        <label>Transporte es gratuito?</label><br>                                                                                
                                        <label><input type="radio" name="transporte" value="1" class="radioInput" <?php echo ($producto->transporte == '1') ? "checked" : ""; ?>>Si</label><br>
                                        <label><input type="radio" name="transporte" value="0" class="radioInput" <?php echo ($producto->transporte == '0') ? "checked" : ""; ?>>No</label><br>
                                        <input type="text" name="transporte_txt" value="<?php echo $producto->transporte_txt ?>" style='width: 80%;<?php echo ($producto->transporte == '0' || $producto->transporte == null) ? "display:none" : ""; ?>'>
                                    </div>
                                </div>
                                <div class="col-md-6">                        
                                    <div class="form-group">
                                        <br>
                                        <label>Impuesto incluido?</label><br>                                                                                
                                        <label><input type="radio" name="impuesto" value="1" class="radioInput" <?php echo ($producto->impuesto == '1') ? "checked" : ""; ?>>Si</label><br>                                            
                                        <label><input type="radio" name="impuesto" value="0" class="radioInput" <?php echo ($producto->impuesto == '0') ? "checked" : ""; ?>>No</label><br>
                                        <input type="text" name="impuesto_txt" value="<?php echo $producto->impuesto_txt ?>" style='width: 80%;<?php echo ($producto->impuesto == '1' || $producto->impuesto == null) ? "display:none" : ""; ?>'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                                                
                <br>                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">                                
                                <span class="titulo">Categoría y Clasificación del Producto</span>                                
                            </div>
                            <div class="panel-body">                                                                                              
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="lead"> Puedes usar los valores a continuación para organizar tus productos a tu gusto, los clientes podrán buscar otros productos según el grupo o familia que tengan.</p>                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Grupo</label>
                                            <input type="text" class="form-control" name="grupo_txt" value="<?php echo $producto->grupo_txt; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Familia</label>
                                            <input type="text" class="form-control" name="familia_txt" value="<?php echo $producto->familia_txt; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sub-familia</label>
                                            <input type="text" class="form-control" name="subfamilia_txt" value="<?php echo $producto->subfamilia_txt; ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="lead"> La categoría se usa para clasificar tu producto en el buscador del sitio.</p>
                                        <label>Seleccione una categoría:</label>
                                        <div class="alert alert-danger" id="seleccionar-categoria_alert" style="display:none;"> 
                                            <a class="close" data-dismiss="alert">×</a>
                                            Debe seleccionar una categoría.
                                        </div>
                                        <div id="categorias_jtree">                
                                            <?php echo $categorias_tree_html; ?>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                                
                <hr>                
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="producto-editar">                
                <input type="hidden" name="categoria_id" value="<?php echo $producto->categoria_id; ?>">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>
    <div id="throbber" style="display:none;">
        <img src="<?php echo assets_url('imgs/small-ajax-loader.gif'); ?>" />
    </div>
</div>