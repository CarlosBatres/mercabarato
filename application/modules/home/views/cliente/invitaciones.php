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

            <!-- *** LEFT COLUMN ***
                 _________________________________________________________ -->

            <div class="col-md-9 clearfix">                                                
                <div class="col-md-12">
                    <div class="heading">
                        <h3>Invitaciones</h3>                        
                    </div>                                       
                    <p class="lead">A continuacion se muestran las invitaciones pendientes de parte de los Vendedores.</p>

                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <?php if ($invitaciones): ?>
                                <?php foreach ($invitaciones as $invitacion): ?> 
                                    <div class="row">
                                        <div class="col-md-12">                                
                                            <p class="">Tienes una invitacion pendiente de:</p>               
                                            <p><strong><?php echo $invitacion->nombre ?></strong></p>
                                            <p><?php echo $invitacion->titulo ?></p>
                                            <p><?php echo $invitacion->comentario ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="pull-left">
                                                <button type="button" class="btn btn-template-main accion aceptar" data-id="<?php echo $invitacion->id ?>"> Aceptar</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="pull-left">
                                                <button type="button" class="btn btn-template-main accion rechazar" data-id="<?php echo $invitacion->id ?>"> Rechazar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>                    
                </div>                
            </div>       
            <div class="col-md-3">                       
                <?php echo $html_options; ?>                        
            </div>                    

        </div>
    </div>
</div>

