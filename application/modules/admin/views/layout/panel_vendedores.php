<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top nav-custom" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url(''); ?>">
                <img height="52" class="hidden-xs" src="<?php echo assets_url('/imgs/logo.png') ?>"/>
            </a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">                        
            <li class="dropdown">                
                <a id="cerrar-sesion" href="<?php echo site_url('panel_vendedor/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
            </li>            
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Buscar...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="<?php echo site_url('panel_vendedor/resumen'); ?>"><i class="fa fa-fw fa-dashboard"></i> Resumen</a>
                    </li>                                                                                                
                    <li>
                        <a href="#"><i class="fa fa-user-plus fa-fw"></i> Mis Clientes<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/invitaciones/buscar'); ?>"><i class="fa fa-plus fa-fw"></i> Buscar Clientes</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/invitaciones/aceptadas'); ?>"><i class="fa fa-fw fa-user"></i> Clientes Actuales</a>
                            </li>                                                        
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/invitaciones/pendientes'); ?>"><i class="fa fa-fw fa-mail-forward"></i> Invitaciones Pendientes</a>
                            </li>                             
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/invitaciones/recibidas'); ?>"><i class="fa fa-fw fa-mail-reply"></i> Invitaciones Recibidas</a>
                            </li> 
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/invitaciones/envio_email'); ?>"><i class="fa fa-fw fa-envelope-o"></i> Enviar Invitacion a Email</a>
                            </li>                            
                        </ul>                         
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Mis Productos<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/producto/agregar'); ?>"> Agregar un producto</a>
                            </li>                            
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/producto/listado'); ?>"> Listado de Productos</a>
                            </li>                            
                        </ul>                         
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-newspaper-o fa-fw"></i> Mis Anuncios<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/anuncio/agregar'); ?>"> Agregar un anuncio</a>
                            </li>                            
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/anuncio/listado'); ?>"> Listado de anuncios</a>
                            </li>                            
                        </ul>                         
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-money fa-fw"></i> Mis Tarifas<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/tarifas/nueva'); ?>"> Nueva Tarifa</a>
                            </li>                                                        
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/tarifas/listado'); ?>"> Listado de Tarifas</a>
                            </li>                                                        
                        </ul>                         
                    </li>  
                    <li>
                        <a href="#"><i class="fa fa-area-chart fa-fw"></i> Mis Ofertas<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/ofertas/nueva'); ?>"> Nueva Oferta</a>
                            </li>                            
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/ofertas/listado'); ?>"> Listado de Ofertas</a>
                            </li>                            
                        </ul>                         
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-tasks fa-fw"></i> Infocompras<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('panel_vendedor/infocompras/seguros'); ?>"> Seguros</a>
                            </li>                                                        
                        </ul>                         
                    </li>
                    <li>
                        <a href="<?php echo site_url('panel_vendedor/regresar'); ?>"><i class="fa fa-fw fa-arrow-left"></i> Regresar al Sitio</a>
                    </li> 

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <?php echo $main_content; ?>
    </div>
    <!-- /#page-wrapper -->

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="text-center">Copyright &copy; 2015. Mercabarato.com Todos los derechos reservados.</p>
                </div>                        
            </div>
        </div>
        <!-- /.container -->    
    </footer>
</div>