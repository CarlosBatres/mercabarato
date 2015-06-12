<?php if ($es_vendedor): ?>
    <div class="panel panel-default sidebar-menu">
        <div class="panel-heading">
            <h3 class="panel-title">Panel Opciones</h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/perfil') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/perfil') ?>"><i class="fa fa-user"></i> Datos Personales</a>
                </li>
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/password') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-lock"></i> Contraseña</a>
                </li>  
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/paquetes') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/paquetes') ?>"><i class="fa fa-building"></i> Paquetes</a>
                </li>         
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/comprar_paquetes') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/comprar_paquetes') ?>"><i class="fa fa-building"></i> Comprar Paquetes</a>
                </li>         
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/productos') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/productos') ?>"><i class="fa fa-credit-card"></i> Productos</a>
                </li>  
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/anuncios') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/anuncios') ?>"><i class="fa fa-columns"></i> Anuncios</a>
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
                    <a href="<?php echo site_url('usuario/perfil') ?>"><i class="fa fa-user"></i> Datos Personales</a>
                </li>
                <li class="<?php echo ($this->uri->uri_string() == 'usuario/password') ? "active" : "" ?>">
                    <a href="<?php echo site_url('usuario/password') ?>"><i class="fa fa-lock"></i> Contraseña</a>
                </li>

                <?php
                $active = "";
                if ($this->uri->uri_string() == 'usuario/afiliacion' || $this->uri->uri_string() == 'usuario/afiliacion-paso2') {
                    $active="active";
                }
                ?>
                <li class="<?php echo $active; ?>">
                    <a href="<?php echo site_url('usuario/afiliacion') ?>"><i class="fa fa-money"></i> Afiliación</a>
                </li>
            </ul>
        </div>
    </div> 
<?php endif; ?>