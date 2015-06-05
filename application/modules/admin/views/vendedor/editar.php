<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Usuario Vendedor
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/vendedores'); ?>">Vendedores</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Editar Usuario - <?php echo $vendedor->nombre ?>
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
                <?php echo form_open('admin/vendedor/editar/' . $vendedor->id, 'id="admin_edit_form"'); ?>                 
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control" readonly name="id" value="<?php echo $vendedor->id; ?>">
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $vendedor->nombre; ?>">
                </div>
                 <div class="form-group">
                    <label>Descripcion</label>
                    <textarea class="form-control" name="descripcion" rows="4" cols="20"><?php echo $vendedor->descripcion; ?></textarea>                    
                </div>
                <div class="form-group">
                    <label>Actividad</label>
                    <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), $vendedor->actividad, 'id="actividad" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Direccion</label>
                    <input type="text" class="form-control" name="direccion" value="<?php echo $vendedor->direccion; ?>">
                </div>
                <div class="form-group">
                    <label>Codigo Postal</label>
                    <input type="text" class="form-control" name="postal" value="<?php echo $vendedor->codigo_postal; ?>">
                </div>
                <div class="form-group">
                    <label>Telefono Principal</label>
                    <input type="text" class="form-control" name="telefono_principal" value="<?php echo $vendedor->telefono1; ?>">
                </div>
                <div class="form-group">
                    <label>Telefono Secundario</label>
                    <input type="text" class="form-control" name="telefono_secundario" value="<?php echo $vendedor->telefono2; ?>">
                </div>
                <div class="form-group">
                    <label>Sitio Web</label>
                    <input type="text" class="form-control" name="sitio_web" value="<?php echo $vendedor->sitioweb; ?>">
                </div>
                <hr>                
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong>                    
                    <p> No se deberian modificar estos campos, solo de ser totalmente necesario.</p>
                    <p> El email es el username de la cuenta si lo modificas puede que la persona no pueda acceder de nuevo a la cuenta</p>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="<?php echo $usuario['email']; ?>">
                </div>
                <div class="text-center">
                    <button type="submit" id="admin_form_submit" class="btn btn-lg btn-default"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="form-editar">
                <input type="hidden" name="usuario_id" value="<?php echo $usuario['id'] ?>">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>