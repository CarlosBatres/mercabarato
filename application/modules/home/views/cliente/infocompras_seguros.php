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
                        <h3>Solicitudes de Seguros</h3>                        
                    </div>                                       
                    <p class="lead">A continuación se muestran tus solicitudes de presupuestos para seguros y su estado actual.</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="tabla-resultados"></div>
                        </div>
                    </div>                    
                </div>                
            </div>       
            <div class="col-md-3">                       
                <?php echo $html_options; ?>                        
            </div>                    

        </div>
    </div>
    <input type="hidden" value="1" name="pagina" id="pagina"/>                                
    <div id="throbber" style="display:none;">        
        <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento." />
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">                
            </div>
        </div>
        
    </div>
</div>

