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

<div id="content">
    <div class="container">        
        <div class="col-md-9">                                                                        
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

                <?php echo form_open('usuario/password/modificar' ,'id="form_password"'); ?>
                <div class="row">
                    <div class="col-md-6 col-sm-12">                            
                        <div class="form-group">                    
                            <div class="input-group">                   
                                <input type="password" class="form-control" name="password_old" placeholder="Ingrese contraseña vieja" autocomplete="off">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-sm-12">                            
                        <div class="form-group">                    
                            <div class="input-group">                   
                                <input type="password" class="form-control" name="password_1" placeholder="Nueva contraseña" autocomplete="off">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">                    
                            <div class="input-group">                   
                                <input type="password" class="form-control" name="password_2" placeholder="Repita la contraseña" autocomplete="off">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            </div>                            
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-template-main"><i class="fa fa-save"></i> Guardar Nueva Contraseña</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="accion" value="form-editar">
                <?php echo form_close(); ?>
            </div>
            <!-- /.box -->                        
        </div>


        <div class="col-md-3">                       
            <?php echo $html_options; ?>                                              
        </div> 


        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->