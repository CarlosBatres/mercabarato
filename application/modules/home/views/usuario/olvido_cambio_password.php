<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>&nbsp;</h1>
            </div>            
        </div>
    </div>
</div>

<div id="content">
    <div class="container">        
        <div class="col-md-6 col-md-offset-3">                                                                        
            <div class="box">
                <div class="heading">
                    <h3 class="text-uppercase">Ingrese nueva contraseña</h3>
                </div>               
                <?php echo form_open('cambio-password' ,'id="form_password"'); ?>                                
                <div class="row">
                    <div class="col-md-12 col-sm-12">                            
                        <div class="form-group">                    
                            <div class="input-group">                   
                                <input type="password" class="form-control" name="password_1" placeholder="Contraseña" autocomplete="off">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
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
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cambiar Contraseña</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="accion" value="form-editar">
                <input type="hidden" name="key" value="<?php echo $key?>">
                <?php echo form_close(); ?>
            </div>
            <!-- /.box -->                        
        </div>

        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->