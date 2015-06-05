<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Usuario Vendedor
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/vendedores'); ?>">Vendedores</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Nuevo Usuario
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del Usuario</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('admin/vendedores/crear', 'id="admin_nuevo_form"'); ?>                 
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>
                    <textarea class="form-control" name="descripcion" rows="4" cols="20"></textarea>                    
                </div>
                <div class="form-group">
                    <label>Actividad</label>
                    <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), null, 'id="actividad" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Direccion</label>
                    <input type="text" class="form-control" name="direccion">
                </div>
                <div class="form-group">
                    <label>Codigo Postal</label>
                    <input type="text" class="form-control" name="postal">
                </div>
                <div class="form-group">
                    <label>Telefono Principal</label>
                    <input type="text" class="form-control" name="telefono_principal">
                </div>
                <div class="form-group">
                    <label>Telefono Secundario</label>
                    <input type="text" class="form-control" name="telefono_secundario">
                </div>
                <div class="form-group">
                    <label>Sitio Web</label>
                    <input type="text" class="form-control" name="sitio_web">
                </div>
                <hr>
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong>                    
                    <p> Si se quiere crear un usuario de esta manera tienes que ingresar un email valido y un password.</p>                    
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <hr>
                <div class="text-center">
                    <button type="submit" id="admin_form_submit" class="btn btn-lg btn-default"> Crear Usuario</button>
                </div>
                <input type="hidden" name="accion" value="form-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>