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
                            <textarea class="form-control" name="descripcion" rows="3"><?php echo $producto->descripcion; ?></textarea>
                        </div>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Precio Venta Publico</label>
                            <input type="text" class="form-control" name="precio" value="<?php echo $producto->precio; ?>">
                        </div>
                    </div>                    
                    <div class="col-md-3 pull-right">
                        <div class="form-group">
                            <br>
                            <label>Mostrar producto al Publico</label><br>
                            <label>Si<input type="radio" name="mostrar_producto" id="mostrar_si" value="1" class="radioInput" <?php echo ($producto->mostrar_producto == 1)?"checked":"";?>></label>
                            <label>No<input type="radio" name="mostrar_producto" id="mostrar_no" value="0" class="radioInput" <?php echo ($producto->mostrar_producto == 0)?"checked":"";?>></label>

                        </div>
                    </div>   
                    <div class="col-md-3 pull-right">
                        <div class="form-group">
                            <br>
                            <label>Mostrar Precio al Publico</label><br>
                            <label>Si<input type="radio" name="mostrar_precio" id="mostrar_precio_si" value="1" class="radioInput" <?php echo ($producto->mostrar_precio == 1)?"checked":"";?>></label>
                            <label>No<input type="radio" name="mostrar_precio" id="mostrar_precio_no" value="0" class="radioInput" <?php echo ($producto->mostrar_precio == 0)?"checked":"";?>></label>

                        </div>                                                                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="categoria" class="form-control">                        
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->id ?>" <?php
                            if ($producto->categoria_id == $categoria->id): echo "selected";
                            endif;
                            ?>><?php echo $categoria->nombre ?></option>
                                <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Imagen del Producto</label>
                            <?php if ($producto_imagen): ?>
                                <div class="preview_imagen">                        
                                    <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto_imagen->filename ?>" width="250"/>
                                </div>
                                <br>
                            <?php endif; ?>
                            <button type="button" id="cambiar_imagen" class="btn btn-lg btn-primary"> Cambiar Imagen</button>
                            <div class='fileupload_button' style='display:none'>
                                <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('panel_vendedor/producto/upload_image') ?>">
                            </div>
                            <input type="hidden" name="file_name" id="file_name" value="">                    
                        </div> 
                    </div>
                </div>
                <hr>                
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="producto-editar">                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>