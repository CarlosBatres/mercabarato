<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Usuario Comprador
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/compradores'); ?>">Compradores</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Editar Usuario - <?php echo $comprador->nombre . ' ' . $comprador->apellidos ?>
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
                <?php echo form_open('admin/comprador/editar/' . $comprador->id, 'id="admin_edit_form"'); ?>                 
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control" readonly name="id" value="<?php echo $comprador->id; ?>">
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $comprador->nombre; ?>">
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" name="apellidos" value="<?php echo $comprador->apellidos; ?>">
                </div>
                <div class="form-group">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">                        
                        <option value="X">Seleccione uno</option>
                        <option value="H" <?php echo ($comprador->sexo == 'H') ? 'selected' : '' ?>>Hombre</option>
                        <option value="M" <?php echo ($comprador->sexo == 'M') ? 'selected' : '' ?>>Mujer</option>
                    </select>
                </div> 
                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" id="datepicker" class="form-control" value="<?php echo date("d-m-Y", strtotime($comprador->fecha_nacimiento)); ?>" name="fecha_nacimiento">
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