<header>    
    <div id="top">
        <div class="container">
            <div class="row">
                <div class="col-xs-7 contact">
                    <div class="input-group">
                        <input type="text" name="search_query_header" class="form-control" placeholder="Ingrese un producto a buscar...">                                                        
                        <span class="input-group-btn">
                            <button class="btn btn-template-main" id="search_button_header" type="button"><i class="fa fa-search"></i></button>
                        </span>
                    </div> 
                </div>
                <div class="col-xs-5">                   
                    <?php if ($this->authentication->is_loggedin()) { ?>
                        <div class="login">
                            <a href="<?php echo site_url('usuario/perfil') ?>" class="" data-toggle=""><i class="fa fa-user"></i> MI PERFIL</a>
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

    <div class="navbar navbar-default yamm navbar-custom" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand home" href="<?php echo site_url(); ?>">                        
                    <img class="hidden-xs hidden-sm" src="<?php echo assets_url('imgs/logo.png') ?>" alt="mercabarato logo" >
                </a>
                <div class="navbar-buttons">
                    <button type="button" class="navbar-toggle btn-template-main" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-align-justify"></i>
                    </button>
                </div>
            </div>            

            <div class="navbar-collapse collapse" id="navigation">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown <?php
                    if ($this->uri->uri_string() == ''): echo "active";
                    endif;
                    ?>" >
                        <a href="<?php echo site_url(); ?>">Inicio</a>                            
                    </li>                    
                    <li class="dropdown <?php
                    if ($this->uri->uri_string() == 'vendedores'): echo "active";
                    endif;
                    ?>" >
                        <a href="<?php echo site_url('vendedores'); ?>">Vendedores</a>                            
                    </li>
                    <li class="dropdown <?php
                    if ($this->uri->uri_string() == 'seguros'): echo "active";
                    endif;
                    ?>" >
                        <a href="javascript: void(0)" class="dropdown-toggle" data-toggle="dropdown">Infocompras <b class="caret"></b></a>                           
                        <ul class="dropdown-menu">
                            <li class="sub-opcion-menu"><a href="<?php echo site_url('seguros'); ?>"> Seguros</a></li>                     
                        </ul>
                    </li>                                                
                </ul>
            </div>            
        </div>
    </div>    
</header>