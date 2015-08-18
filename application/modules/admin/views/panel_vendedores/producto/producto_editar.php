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
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del producto</h2>                                        
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
                            <label>Descripcion</label>                                                
                            <textarea class="form-control" id="content" name="descripcion" rows="10"><?php echo $producto->descripcion; ?></textarea>                                                                    
                            <?php echo display_ckeditor($ckeditor); ?>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Imagenes del producto</label>
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
                                        <button type="button" id="cambiar_imagen" class="btn btn-lg btn-primary"> Reemplazar todas las Imagenes</button>                                
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
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Precio Venta Publico</label>
                            <input type="text" class="form-control" name="precio" value="<?php echo $producto->precio; ?>">
                        </div>
                    </div>    
                    <div class="col-md-8">
                        <div class="form-group">                            
                            <label>Enlace externo al producto</label>
                            <input type="text" class="form-control" name="link_externo" value="<?php echo $producto->link_externo; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <br>
                            <label>Desea mostrar el producto al publico general?</label><br>
                            <label>Si<input type="radio" name="mostrar_producto" id="mostrar_si" value="1" class="radioInput" <?php echo ($producto->mostrar_producto == 1) ? "checked" : ""; ?>></label>
                            <label>No<input type="radio" name="mostrar_producto" id="mostrar_no" value="0" class="radioInput" <?php echo ($producto->mostrar_producto == 0) ? "checked" : ""; ?>></label>

                        </div>
                    </div>   
                    <div class="col-md-4">
                        <div class="form-group">
                            <br>
                            <label>Desea mostrar el precio al publico general?</label><br>
                            <label>Si<input type="radio" name="mostrar_precio" id="mostrar_precio_si" value="1" class="radioInput" <?php echo ($producto->mostrar_precio == 1) ? "checked" : ""; ?>></label>
                            <label>No<input type="radio" name="mostrar_precio" id="mostrar_precio_no" value="0" class="radioInput" <?php echo ($producto->mostrar_precio == 0) ? "checked" : ""; ?>></label>

                        </div>                                                                       
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>Seleccione una Categoria:</label>
                        <div class="alert alert-danger" id="seleccionar-categoria_alert" style="display:none;"> 
                            <a class="close" data-dismiss="alert">×</a>
                            Debe seleccionar una categoria.
                        </div>
                        <div id="categorias_jtree">                
                            <?php echo $categorias_tree_html; ?>
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