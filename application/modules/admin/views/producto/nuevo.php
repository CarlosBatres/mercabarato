<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Producto
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/productos'); ?>">Productos</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Producto Nuevo
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del producto</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('admin/productos/crear', 'id="admin_nuevo_producto"'); ?>                 
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
                </div>
                <div class="form-group">
                    <label>Vendedor / Empresa</label>
                    <input type="text" class="form-control" name="vendedor">                                        
                    <input type="hidden" name="vendedor_id" id="vendedor_id" value="">                                        
                </div>


                <div class="form-group">
                    <label>Precio Venta Publico</label>
                    <input type="text" class="form-control" name="precio_venta_publico">
                </div>
                <div class="form-group">
                    <label>Mostrar al Publico</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="mostrar_publico" id="mostrar_si" value="1" checked> Si
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="mostrar_publico" id="mostrar_no" value="0"> No
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
                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-default"> Crear Producto</button>
                </div>
                <input type="hidden" name="accion" value="producto-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>