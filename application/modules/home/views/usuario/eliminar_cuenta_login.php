<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Eliminar Cuenta</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Eliminar Cuenta</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="container">        
        <div class="col-md-5 col-md-offset-3">                                                                                    
            <h4 class="text-center">Identifiquese a continuación</h4>
            <?php echo form_open('usuario/eliminar-cuenta'); ?>                 
            <div class="row">
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <div class="col-md-12">
                    <div class="form-group">                    
                        <div class="input-group">                                                
                            <span class="input-group-addon"></span>
                            <input type="text" class="form-control" name="email" placeholder="Email" autofocus="" autocomplete="off">                                    
                        </div>                    
                    </div>
                    <div class="form-group">                    
                        <div class="input-group">                   
                            <span class="input-group-addon"></span>
                            <input type="password" class="form-control" name="password" placeholder="Contraseña" autocomplete="off">                                    
                        </div>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar</button>                            
                </div>
            </div>
            <div class="alert alert-danger hidden" role="alert">
                El usuario y/o la contraseña son incorrectas
            </div>
            <?php echo form_close(); ?>                        



        </div>             
    </div>    
</div>
