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
                        <h3>Paquetes</h3>
                    </div>
                    <p class="lead">Seleccione uno de los siguientes paquetes mostrados a continuación.</p>
                    <div class="row packages">
                        <?php foreach ($paquetes as $paquete): ?>
                            <!-- TODO: col-md-4 si son mas de 3 paquetes o menos hay que acomodar aqui -->
                            <div class="col-md-4">                                
                                <div class="package ">
                                    <div class="package-header">
                                        <h5><?php echo $paquete->nombre; ?></h5>
                                    </div>
                                    <div class="price">
                                        <div class="price-container">
                                            <h4><span class="currency"></span><?php echo $paquete->costo . ' ' . $this->config->item('money_sign') ?></h4>                                            
                                        </div>
                                    </div>
                                    <?php if ($paquete->infocompra == "0"): ?>
                                        <ul>
                                            <li><i class="fa fa-check"></i>
                                                <?php
                                                if ($paquete->limite_productos == -1): echo "Sin limite de Productos";
                                                else: echo $paquete->limite_productos . ' productos';
                                                endif;
                                                ?>
                                            </li>
                                            <li><i class="fa fa-check"></i>
                                                <?php
                                                if ($paquete->limite_anuncios == -1): echo "Sin limite de Anuncios";
                                                else: echo $paquete->limite_anuncios . ' anuncios';
                                                endif;
                                                ?>
                                            </li>                                        
                                        </ul>
                                    <?php else:?>
                                    <p><?php echo $paquete->descripcion; ?></p>
                                    <?php endif; ?>
                                    <a href="<?php echo site_url("usuario/paquetes/renovar_paquete/" . $paquete->id) ?>" class="btn btn-primary"> Comprar </a>
                                </div>                                
                            </div>
                        <?php endforeach; ?>                                                    
                    </div>                    
                    <hr>
                    <br>
                </div>                
            </div>       


            <div class="col-md-3">                       
                <?php echo $html_options; ?>                        
            </div>                    

        </div>
    </div>
</div>