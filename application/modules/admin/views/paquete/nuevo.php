<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Paquete
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/paquetes'); ?>">Paquetes</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Paquete Nuevo
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del Paquete</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('admin/paquetes/crear', 'id="admin_crear_form"'); ?>                 
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>                    
                    <textarea class="form-control" name="descripcion" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label>Costo</label>
                    <input type="text" class="form-control" name="costo">
                </div>
                <div class="form-group">
                    <label>Orden en la que se presentan</label>
                    <input type="text" class="form-control" name="orden">
                </div>
                <div class="form-group">
                    <label>Desea que se muestre el paquete o quede oculto ( Ideal para paquetes especiales )</label>
                    <select class="form-control" name="mostrar">
                        <option value="0">Oculto</option>
                        <option value="1">Mostrar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Duracion ( En meses )</label>
                    <input type="text" class="form-control" name="duracion">
                </div>
                <hr>
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong>                    
                    <p> Si deseas que estos valores sean ilimitados dejalos vacios o en 0 de lo contrario ingresa un valor.</p>                    
                </div>
                <div class="form-group">
                    <label>Limite Productos</label>
                    <input type="text" class="form-control" name="limite_productos">
                </div>
                <div class="form-group">
                    <label>Limite Anuncios</label>
                    <input type="text" class="form-control" name="limite_anuncios">
                </div>                
                <hr>
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-default"> Crear Paquete</button>
                </div>
                <input type="hidden" name="accion" value="item-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>