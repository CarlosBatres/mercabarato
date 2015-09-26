<div id="content-auth">
    <div class="container">        
        <div class="col-md-5 col-md-offset-3 login-auth">
            <h3 class="text-center">Iniciar Sesión</h3>
            <?php echo form_open('login', 'id="loginAuth"'); ?>
            <div class="row">
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email ?>" autocomplete="off">                                    
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">                    
                        <div class="input-group">                   
                            <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Contraseña" autocomplete="off">                                    
                        </div>
                    </div>
                </div>                
                <input type="hidden" name="continue" value="<?php echo $continue ?>">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden" role="alert">
                        El usuario y/o la contraseña son incorrectas
                    </div>
                </div>
                <div class="col-xs-12">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar</button>
                </div>
            </div>            
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
</div>
