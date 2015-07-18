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
                <img height="52" src="<?php echo assets_url('/imgs/logo.png') ?>"/>
            </a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">            
            <li><a id="cerrar-sesion" href="<?php echo site_url('admin/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
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
                        <a href="<?php echo site_url('admin/resumen'); ?>"><i class="fa fa-fw fa-dashboard"></i> Resumen</a>
                    </li>                                                        
                    <li>
                        <a href="<?php echo site_url('admin/vendedor_paquetes/listado_por_activar'); ?>"><i class="fa fa-money fa-fw"></i> Activación de Paquete</a>
                    </li>                     
                    <li>
                        <a href="<?php echo site_url('admin/usuarios'); ?>"><i class="fa fa-user fa-fw"></i> Ver Clientes</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/vendedores'); ?>"><i class="fa fa-money fa-fw"></i> Ver Vendedores</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/anuncios'); ?>"><i class="fa fa-fw fa-calendar"></i> Ver Anuncios</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/productos'); ?>"><i class="fa fa-fw fa-inbox"></i> Ver Productos</a>
                    </li>                    
                    <li>
                        <a href="<?php echo site_url('#'); ?>"><i class="fa fa-users fa-fw"></i> Vendedores/Administradores<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('admin/vendedores_admin/asignar_listado'); ?>"> Asignar Nuevo</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/vendedores_admin/listado_actual'); ?>"> Listado Actual</a>
                            </li>                                                        
                        </ul> 
                    </li> 
                    <li>
                        <a href="<?php echo site_url('admin/paquetes'); ?>"><i class="fa fa-fw fa-suitcase"></i> Administrar Paquetes</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/categorias'); ?>"><i class="fa fa-fw fa-tasks"></i> Administrar Categorias</a>
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
