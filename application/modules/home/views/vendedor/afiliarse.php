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
                        <h3 class="text-uppercase">Datos del Vendedor</h3>
                    </div>
                    <p class="lead">Complete el formulario a continuación, esta informacion sera la que veran los clientes que visiten sus productos y su apartado personal.</p>                    
                    <?php echo form_open('usuario/afiliacion/registrar'); ?>                 
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label>Nombre de la Empresa</label>
                                <input type="text" class="form-control" name="nombre_empresa">
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
                                <label>Sitio Web</label>
                                <input type="text" class="form-control" name="sitio_web">
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" name="direccion" value='<?php echo $cliente->direccion?>'>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" class="form-control" name="telefono_fijo" value='<?php echo $cliente->telefono_fijo?>'>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telefono Movil</label>
                                <input type="text" class="form-control" name="telefono_movil" value='<?php echo $cliente->telefono_movil?>'>
                            </div>
                        </div>
                    </div>                    
                    <div class="box-footer">
                        <div class="pull-left">
                            
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-template-main">Registrar Informacion y Continuar<i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="accion" value="form-editar">
                    <?php echo form_close(); ?>
                    <hr>                    
                </div>                 
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
                            <li>
                                <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-lock"></i> Contraseña</a>
                            </li>                                    
                            <li class='active'>
                                <a href="<?php echo site_url('usuario/afiliacion') ?>"><i class="fa fa-money"></i> Afiliación</a>
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