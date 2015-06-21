<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Usuario
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/usuarios'); ?>">Usuarios</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Editar Usuario - <?php echo $usuario['email'] ?>
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
                <?php echo form_open('admin/cliente/editar/' . $cliente->id, 'id="admin_edit_form"'); ?>                 

                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control" readonly name="id" value="<?php echo $cliente->id; ?>">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres" value="<?php echo $cliente->nombres; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" value="<?php echo $cliente->apellidos; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input type="text" id="datepicker" class="form-control" value="<?php echo ($cliente->fecha_nacimiento!=null)?date("d-m-Y", strtotime($cliente->fecha_nacimiento)):''; ?>" name="fecha_nacimiento">
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Codigo Postal</label>
                            <input type="text" class="form-control" name="codigo_postal" value="<?php echo $cliente->codigo_postal; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sexo</label>
                            <select name="sexo" class="form-control">                        
                                <option value="X">Seleccione uno</option>
                                <option value="H" <?php echo ($cliente->sexo == 'H') ? 'selected' : '' ?>>Hombre</option>
                                <option value="M" <?php echo ($cliente->sexo == 'M') ? 'selected' : '' ?>>Mujer</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="<?php echo $cliente->direccion; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" class="form-control" name="telefono_fijo" value="<?php echo $cliente->telefono_fijo; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefono Movil</label>
                            <input type="text" class="form-control" name="telefono_movil" value="<?php echo $cliente->telefono_movil; ?>">
                        </div>
                    </div>
                </div>                
                <hr>
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong>                    
                    <p> No se deberian modificar el campo email, solo de ser totalmente necesario.</p>
                    <p> El email es el <strong>username</strong> de la cuenta si lo modificas puede que la persona no pueda acceder de nuevo.</p>
                </div>                                
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">                        
                        <span class="input-group-addon">*</span>
                        <input type="text" class="form-control" name="email" disabled value="<?php echo $usuario['email']; ?>">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" id="admin_form_submit" class="btn btn-lg btn-primary"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="form-editar">
                <input type="hidden" name="usuario_id" value="<?php echo $usuario['id'] ?>">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>