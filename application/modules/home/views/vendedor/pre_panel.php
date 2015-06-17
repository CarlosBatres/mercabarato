<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Pagina del Usuario</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Mi Cuenta</li>                    
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content" class="clearfix">

    <div class="container">

        <div class="row">

            <div class="col-md-9 clearfix">                                                
                <div class="col-md-12">
                    <div class="heading">
                        <h3>Panel de Control</h3>
                    </div>
                    <p class="lead">En el apartado a continuación podras controlar todos los aspectos de tu cuenta, agregar productos, anuncios, realizar ofertas a tus clientes y manejar tus invitaciones.</p>                    
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <a href="<?php echo site_url('panel_vendedor') ?>" id="boton-perfil" class="btn btn-lg btn-template-primary"> Continuar</a>
                    </div>                    
                </div>
            </div>    


            <div class="col-md-3">                       
                <?php echo $html_options; ?>                       
            </div>                    

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->