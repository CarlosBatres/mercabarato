<div id="all">
    <?php echo $header; ?>

    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Login">Iniciar sesión</h4>
                </div>
                <div class="modal-body">                    
                    <?php echo form_open('login', 'id="loginForm" rel="preventDoubleSubmission"'); ?>                 
                    <div class="row">  
                        <div class="col-md-12">
                            <div class="form-group">                    
                                <div class="input-group">                                                
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input type="text" class="form-control" name="email" placeholder="Email" autofocus="" autocomplete="off">                                    
                                </div>                    
                            </div>
                            <div class="form-group">                    
                                <div class="input-group">                   
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña" autocomplete="off">                                    
                                </div>
                            </div>                            
                            <div class="alert alert-danger hidden" role="alert">
                                El usuario y/o la contraseña son incorrectas
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar</button>                            
                        </div>
                    </div>                    
                    <?php echo form_close(); ?>
                    <p class="text-center text-muted"><a href="<?php echo site_url('olvido-password'); ?>"><strong>Olvidaste tu contraseña?</strong></a></p>
                    <p class="text-center text-muted"><a href="<?php echo site_url('registro'); ?>"><strong>Regístrese ahora</strong></a>!</p>
                </div>
            </div>
        </div>
    </div>    

    <?php echo $main_content; ?>

    <?php echo $footer; ?>
</div>