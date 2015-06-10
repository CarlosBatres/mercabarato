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
            <div class="col-md-9 clearfix" id="customer-account">                                                                        
                <div class="box">
                    <div class="heading">
                        <h3 class="text-uppercase">Cambiar su Contraseña</h3>
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
                    
                    <?php echo form_open('usuario/password/modificar'); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contraseña Vieja</label>
                                <input type="password" class="form-control" name="password_old">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password_1">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Repite la Contraseña</label>
                                <input type="password" class="form-control" name="password_2">
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="text-center">
                        <button type="submit" class="btn btn-template-main"><i class="fa fa-save"></i> Guardar Nueva Contraseña</button>
                    </div>
                    <input type="hidden" name="accion" value="form-editar">
                    <?php echo form_close(); ?>
                </div>
                <!-- /.box -->                        
            </div>


            <div class="col-md-3">                       
                <div class="panel panel-default sidebar-menu">
                    <div class="panel-heading">
                        <h3 class="panel-title">Panel Opciones</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li>
                                <a href="<?php echo site_url('usuario/perfil') ?>"><i class="fa fa-user"></i> Datos Personales</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-lock"></i> Contraseña</a>
                            </li>
                            <?php if (!$es_vendedor): ?>
                            <li>
                                <a href="<?php echo site_url('usuario/afiliacion') ?>"><i class="fa fa-money"></i> Afiliación</a>
                            </li>
                            <?php else: ?>
                                <li>
                                    <a href="<?php echo site_url('') ?>"><i class="fa fa-building"></i> Paquetes</a>
                                </li>         
                                <li>
                                    <a href="<?php echo site_url('') ?>"><i class="fa fa-credit-card"></i> Productos</a>
                                </li>  
                                <li>
                                    <a href="<?php echo site_url('') ?>"><i class="fa fa-columns"></i> Anuncios</a>
                                </li>  
                            <?php endif; ?>
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