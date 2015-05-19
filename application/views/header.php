<!--<header class="navbar navbar-inverse navbar-static-top navbar-custom">
    <div class="container">
        <div class="navbar-header">            
            <a href="<?php echo site_url(); ?>" class="navbar-brand"> <img src="<?php echo assets_url('imgs/logo.png') ?>"/> </a>
        </div>
        <nav class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo site_url(); ?>">Subastas</a></li>
                <li><a href="<?php echo site_url(); ?>">Productos</a></li>                
                <li><a href="<?php echo site_url(); ?>">Vendedores</a></li>                
                <li><a href="<?php echo site_url(); ?>">Seguros</a></li>                
            </ul>            
        </nav>
    </div>
</header>-->

<header>
    <!-- *** TOP ***
    _________________________________________________________ -->
    <div id="top">
        <div class="container">
            <div class="row">
                <div class="col-xs-5 contact">
                    <p class="hidden-sm hidden-xs">Contactenos en +420 777 555 333  o  mail@mercabarato.com.</p>
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

                    <div class="login">
                        <a href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-sign-in"></i> <span class="hidden-xs text-uppercase">Acceso</span></a>
                        <a href="customer-register.html"><i class="fa fa-user"></i> <span class="hidden-xs text-uppercase">Registro</span></a>
                    </div>

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
                        <li class="dropdown active">
                            <a href="<?php echo site_url(); ?>">Inicio <b class="caret"></b></a>                            
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo site_url(); ?>">Subastas <b class="caret"></b></a>                            
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo site_url(); ?>">Productos <b class="caret"></b></a>                            
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo site_url(); ?>">Vendedores <b class="caret"></b></a>                            
                        </li>
                        <li class="dropdown">
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
                <form action="customer-orders.html" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="email_modal" placeholder="email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password_modal" placeholder="password">
                    </div>

                    <p class="text-center">
                        <button class="btn btn-template-main"><i class="fa fa-sign-in"></i> Log in</button>
                    </p>

                </form>

                <p class="text-center text-muted">Not registered yet?</p>
                <p class="text-center text-muted"><a href="customer-register.html"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>

            </div>
        </div>
    </div>
</div>

<!-- *** LOGIN MODAL END *** -->