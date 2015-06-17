<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Pagina del Usuario</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Mi Cuenta</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content" class="clearfix">

    <div class="container">

        <div class="row">

            <!-- *** LEFT COLUMN ***
                 _________________________________________________________ -->

            <div class="col-md-9 clearfix" id="customer-account">                                                
                <div class="box clearfix">

                    <div class="heading">
                        <h3 class="text-uppercase">Productos</h3>
                    </div>

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
                                <?php echo form_open('admin/productos/crear', 'id="admin_producto_form"'); ?>                 
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" name="nombre">
                                </div>
                                <div class="form-group">
                                    <label>Descripcion</label>                    
                                    <textarea class="form-control" name="descripcion" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select name="categoria" class="form-control">                        
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Imagen del Producto</label>                    
                                    <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('admin/producto_resource/upload_image') ?>">
                                    <input type="hidden" name="file_name" id="file_name" value="">                                                            
                                </div>                
                                <div class="form-group">
                                    <label>Precio Venta Publico</label>
                                    <input type="text" class="form-control" name="precio">
                                </div>
                                <div class="form-group">
                                    <label>Mostrar al Publico</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="mostrar_producto" id="mostrar_si" value="1" checked> Si
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="mostrar_producto" id="mostrar_no" value="0"> No
                                        </label>
                                    </div>                    
                                </div>
                                <div class="form-group">
                                    <label>Mostrar Precio al Publico</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="mostrar_precio" id="mostrar_precio_si" value="1" checked> Si
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="mostrar_precio" id="mostrar_precio_no" value="0"> No
                                        </label>
                                    </div>                    
                                </div>
                                <hr>
                                <div class="alert alert-warning">
                                    <strong>Advertencia:</strong>                    
                                    <p> Para poder agregar un nuevo producto al sistema por esta via debe existir al menos un Usuario Vendedor para asociar con este producto.</p>                    
                                </div>
                                <div class="form-group">
                                    <label>Vendedor / Empresa</label>
                                    <input type="text" class="form-control" name="vendedor">                                        
                                    <input type="hidden" name="vendedor_id" id="vendedor_id" value="">                                        
                                </div>
                                <hr>
                                <div class="text-center">
                                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-default"> Crear Producto</button>
                                </div>
                                <input type="hidden" name="accion" value="producto-crear">
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>









                </div>                 
            </div>                    

            <div class="col-md-3">                       
                <?php echo $html_options; ?>                                                                     
            </div>                    

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->