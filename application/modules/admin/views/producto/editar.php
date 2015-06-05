<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Producto
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/productos'); ?>">Productos</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Editar Producto - <?php echo $producto->nombre ?>
                </li>
            </ol>
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
                <?php echo form_open('admin/productos/editar/' . $producto->id, 'id="admin_producto_form"'); ?>                 
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control" readonly name="id" value="<?php echo $producto->id; ?>">
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $producto->nombre; ?>">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>                    
                    <textarea class="form-control" name="descripcion" rows="3"><?php echo $producto->descripcion; ?></textarea>
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

                <div class="form-group">
                    <label>Imagen del Producto</label>
                    <?php if ($producto_imagen): ?>
                        <div class="preview_imagen">                        
                            <img src="<?php echo assets_url('uploads/imgs/' . $producto_imagen->url_path); ?>" width="250"/>
                        </div>
                        <br>
                    <?php endif; ?>
                    <button type="button" id="cambiar_imagen" class="btn btn-lg btn-default"> Cambiar Imagen</button>
                    <div class='fileupload_button' style='display:none'>
                        <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('admin/producto_resource/upload_image') ?>">
                    </div>
                    <input type="hidden" name="file_name" id="file_name" value="">                    
                </div>               
                <div class="form-group">
                    <label>Precio Venta Publico</label>
                    <input type="text" class="form-control" name="precio_venta_publico" value="<?php echo $producto->precio_venta_publico; ?>">
                </div>
                <div class="form-group">
                    <label>Mostrar al Publico</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="mostrar_publico" id="mostrar_si" value="1" <?php
                            if ($producto->mostrar_publico == 1): echo "checked";
                            endif;
                            ?>> Si
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="mostrar_publico" id="mostrar_no" value="0" <?php
                            if ($producto->mostrar_publico == 0): echo "checked";
                            endif;
                            ?>> No
                        </label>
                    </div>                    
                </div>
                <div class="form-group">
                    <label>Mostrar Precio al Publico</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="mostrar_precio" id="mostrar_precio_si" value="1" <?php
                            if ($producto->mostrar_precio_venta_publico == 1): echo "checked";
                            endif;
                            ?>> Si
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="mostrar_precio" id="mostrar_precio_no" value="0" <?php
                            if ($producto->mostrar_precio_venta_publico == 0): echo "checked";
                            endif;
                            ?>> No
                        </label>
                    </div>                    
                </div>
                <hr>
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong>                    
                    <p> Para poder agregar un nuevo producto al sistema por esta via debe existir al menos un Usuario Vendedor para asociar con este producto.</p>                    
                </div
                <div class="form-group">
                    <label>Vendedor / Empresa</label>
                    <input type="text" class="form-control" name="vendedor" value="<?php echo $vendedor->nombre; ?>">                                        
                    <input type="hidden" name="vendedor_id" id="vendedor_id" value="<?php echo $producto->vendedor_id; ?>">                                        
                </div>
                <hr>
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-default"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="producto-editar">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>