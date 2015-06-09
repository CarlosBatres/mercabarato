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
                        <h3 class="text-uppercase">Datos Personales</h3>
                    </div>
                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success"> 
                            <a class="close" data-dismiss="alert">×</a>
                            <?= $this->session->flashdata('success') ?> 
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> 
                            <a class="close" data-dismiss="alert">×</a>
                            <?= $this->session->flashdata('error') ?> 
                        </div>
                    <?php } ?>
                    <?php echo form_open('usuario/perfil/modificar'); ?>                 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="firstname">Nombres</label>
                                <input type="text" name="nombres" class="form-control" value="<?php echo $cliente->nombres ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" value="<?php echo $cliente->apellidos ?>">
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="row">                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                <input type="text" id="datepicker" class="form-control" value="<?php echo date("d-m-Y", strtotime($cliente->fecha_nacimiento)); ?>" name="fecha_nacimiento">
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
                    <!-- /.row -->

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
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-template-main"><i class="fa fa-save"></i> Guardar Cambios</button>
                        </div>
                    </div>  
                    <input type="hidden" name="accion" value="form-editar">
                    <?php echo form_close(); ?>
                </div>                                                
            </div>                    

            <div class="col-md-3">                       
                <div class="panel panel-default sidebar-menu">
                    <div class="panel-heading">
                        <h3 class="panel-title">Panel Opciones</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active">
                                <a href="<?php echo site_url('usuario/perfil') ?>"><i class="fa fa-user"></i> Datos Personales</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-list"></i> Contraseña</a>
                            </li>                                    
                        </ul>
                    </div>
                </div>                        
            </div>                    

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->