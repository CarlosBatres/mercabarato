<header>
    <!-- *** TOP ***
    _________________________________________________________ -->
    <div id="top">
        <div class="container">
            <div class="row">
                <div class="col-xs-5 contact">
                    <p class="hidden-sm hidden-xs">Contactenos en +00000000000  o  mail@mercabarato.com.</p>
                    <p class="hidden-md hidden-lg"><a href="#" data-animate-hover="pulse"><i class="fa fa-phone"></i></a>  <a href="#" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
                    </p>
                </div>
                <div class="col-xs-7">
                    <div class="social">
                        <a href="#" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="external gplus" data-animate-hover="pulse"><i class="fa fa-google-plus"></i></a>
                        <a href="#" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
                    </div>

                    <?php if ($this->authentication->is_loggedin()) { ?>
                        <div class="login">
                            <a href="#" class="" data-toggle=""><i class="fa fa-user"></i> <?php echo $this->authentication->read('username'); ?></a>
                            <a href="<?php echo site_url('logout'); ?>"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
                        </div>
                    <?php } else { ?>
                        <div class="login">
                            <a href="" data-toggle="modal" data-target="#login-modal"><i class="fa fa-sign-in"></i> <span class="hidden-xs text-uppercase">Acceso</span></a>
                            <a href="<?php echo site_url('registro'); ?>"><i class="fa fa-user"></i> <span class="hidden-xs text-uppercase">Registro</span></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- *** TOP END *** -->

    <!-- *** NAVBAR ***
    _________________________________________________________ -->

    <div class="navbar-affixed-top" data-spy="affix" data-offset-top="200">
        <div class="navbar navbar-default yamm navbar-custom" role="navigation" id="navbar">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand home" href="<?php echo site_url(); ?>">                        
                        <img src="<?php echo assets_url('imgs/logo.png') ?>" alt="mercabarato logo" >
                    </a>
                    <div class="navbar-buttons">
                        <button type="button" class="navbar-toggle btn-template-main" data-toggle="collapse" data-target="#navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="fa fa-align-justify"></i>
                        </button>
                    </div>
                </div>
                <!--/.navbar-header -->

                <div class="navbar-collapse collapse" id="navigation">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown <?php if ($this->uri->uri_string() == ''): echo "active"; endif;?>" >
                            <a href="<?php echo site_url(); ?>">Inicio <b class="caret"></b></a>                            
                        </li>
                        <li class="dropdown <?php if ($this->uri->uri_string() == 'productos'): echo "active"; endif;?>" >
                            <a href="<?php echo site_url('productos'); ?>">Productos<b class="caret"></b></a>
                        </li>                       

                        <li class="dropdown <?php if ($this->uri->uri_string() == 'vendedores'): echo "active"; endif;?>" >
                            <a href="<?php echo site_url(); ?>">Vendedores <b class="caret"></b></a>                            
                        </li>
                        <li class="dropdown <?php if ($this->uri->uri_string() == 'seguros'): echo "active"; endif;?>" >
                            <a href="<?php echo site_url(); ?>">Seguros <b class="caret"></b></a>                            
                        </li>                                                
                    </ul>
                </div>
                <!--/.nav-collapse -->                                
            </div>
        </div>
        <!-- /#navbar -->
    </div>
    <!-- *** NAVBAR END *** -->
</header>

<!-- *** LOGIN MODAL ***
_________________________________________________________ -->

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Login">Customer login</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger hidden" role="alert">
                    El usuario y/o la contraseña son incorrectas
                </div>
                <?php echo form_open('login', 'id="loginForm"'); ?>                 
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="E-mail" autocomplete=off>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete=off>
                </div>

                <p class="text-center">
                    <button class="btn btn-template-main" type="submit"><i class="fa fa-sign-in"></i> Iniciar</button>
                </p>                    
                <?php echo form_close(); ?>
                <p class="text-center text-muted">No esta registrado?</p>
                <p class="text-center text-muted"><a href="<?php echo site_url('registro'); ?>"><strong>Registrese ahora</strong></a>!</p>
            </div>
        </div>
    </div>
</div>
<!-- *** LOGIN MODAL END *** -->