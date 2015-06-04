<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Usuario Comprador
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/compradores'); ?>">Compradores</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Nuevo Usuario
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del Usuario</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('admin/compradores/crear', 'id="admin_nuevo_form"'); ?>                 
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" name="apellidos">
                </div>
                <div class="form-group">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">                                                
                        <option value="X">Seleccione uno</option>
                        <option value="H">Hombre</option>
                        <option value="M">Mujer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" id="datepicker" class="form-control" name="fecha_nacimiento">
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