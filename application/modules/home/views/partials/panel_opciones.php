<?php if ($es_vendedor): ?>
    <div class="panel panel-default sidebar-menu">
        <div class="panel-heading">
            <h3 class="panel-title">Panel Opciones</h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked metismenu" id="perfil-opciones">
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/perfil') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/perfil') ?>"><i class="fa fa-user"></i> Perfil</a>
                </li>
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/datos-personales') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/datos-personales') ?>"><i class="fa fa-user"></i> Datos Personales</a>
                </li>
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/password') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-lock"></i> Contraseña</a>
                </li> 
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/mis-paquetes') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/mis-paquetes') ?>"><i class="fa fa-money"></i> Mis Paquetes</a>
                </li>                
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/paquetes/comprar') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/paquetes/comprar') ?>"><i class="fa fa-money"></i> Adquirir Paquetes</a>
                </li>                
                <li class="<?php echo ($this->uri->uri_string() == 'panel_vendedor') ? "active" : "" ?>">
                    <a href="<?php echo site_url('panel_vendedor') ?>"><i class="fa fa-cogs"></i> Manejar tus Productos</a>
                </li>                                
            </ul>
        </div>
    </div>
<?php else: ?>
    <div class="panel panel-default sidebar-menu">
        <div class="panel-heading">
            <h3 class="panel-title">Panel Opciones</h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/perfil') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/perfil') ?>"><i class="fa fa-user"></i> Perfil</a>
                </li>
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/datos-personales') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/datos-personales') ?>"><i class="fa fa-user"></i> Datos Personales</a>
                </li>
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/password') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-lock"></i> Contraseña</a>
                </li>
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/invitaciones') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/invitaciones') ?>"><i class="fa fa-plus"></i> Invitaciónes</a>
                </li>

                <?php
                $active = "";
                if ($this->uri->uri_string() == 'usuario/afiliacion' || $this->uri->uri_string() == 'usuario/afiliacion-paso2') {
                    $active = "active";
                }
                ?>
                <li class="<?php echo $active; ?>">
                    <a href="<?php echo site_url('usuario/afiliacion') ?>"><i class="fa fa-money"></i> Afiliación</a>
                </li>
            </ul>
        </div>
    </div> 
<?php endif; ?>