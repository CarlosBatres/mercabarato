<div id="heading-breadcrumbs" class="no-mb">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>&nbsp;</h1>
            </div>            
        </div>
    </div>
</div>

<div id="content">
    <div class="container" id="contact">

        <section>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <br>
                    <div class="heading">
                        <h2>¿Olvidaste tu Contraseña?</h2>
                    </div>                    
                    <?php if (!$enviado): ?>
                        <form action="<?php echo site_url('olvido-password') ?>" method="POST" id="olvido_password">
                            <div class="row">                            
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                    </div>
                                    <?php if ($this->session->flashdata('error')) { ?>
                                        <div class="alert alert-danger"> 
                                            <a class="close" data-dismiss="alert">×</a>
                                            <?= $this->session->flashdata('error') ?> 
                                        </div>
                                    <?php } ?>
                                    <br>
                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Aceptar</button>                            
                                </div>                                                        
                            </div>
                            <!-- /.row -->
                        </form>
                    <?php else:?>                    
                        <p class="lead"> Se han enviado instrucciones a tu correo de como cambiar tu contraseña.</p>
                        <br>
                    <?php endif; ?>
                </div>                
            </div>
        </section>
    </div>
    <!-- /#contact.container -->
</div>

