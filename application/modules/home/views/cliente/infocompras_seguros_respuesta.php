<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>INFOCOMPRAS - SEGUROS</h1>
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
            <div class="col-md-9">                 
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Respuesta del vendedor
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">                      
                                <?php echo $mensaje->mensaje ?>
                            </div> 
                        </div>
                    </div>      
                </div>
                <?php if ($seguro->ventajas != ""): ?>                
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Ventajas Ofrecidas por el Vendedor
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">                      
                                    <?php echo $seguro->ventajas ?>
                                </div> 
                            </div>
                        </div>                
                    </div>
                <?php endif; ?>
                <?php if ($seguro->precio != null): ?>                
                    <div class="row">
                        <div class="panel panel-primary">                    
                            <div class="panel-body">
                                <div class="col-md-12">                      
                                    <strong>Precio </strong> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($seguro->precio, 2) . ' ' . $this->config->item("money_sign"); ?> 
                                </div> 
                            </div>
                        </div> 
                    </div>
                <?php endif; ?>
                <hr>
                <div class="row">
                    <div class="col-xs-4 text-left">
                        <a class="btn btn-primary" href="<?php echo site_url('usuario/infocompras-seguros/') ?>" >Regresar</a>
                    </div>
                    <?php if ($seguro->estado != 2): ?>
                        <div class="col-xs-4 text-center">
                            <a class="btn btn-primary" href="<?php echo site_url('usuario/infocompras-seguros/pregunta/' . $seguro->id) ?>" >Enviar Pregunta</a>
                        </div>
                    <?php endif; ?>
                    <?php if ($seguro->link_file != null): ?>
                        <div class="col-xs-4 text-right">
                            <a class="btn btn-primary" href="<?php echo site_url('usuario/infocompras-seguros/descargar_respuesta/') . '/' . $seguro->link_file; ?>" >Descargar Adjunto</a>
                        </div>                        
                    <?php endif; ?>                    
                </div>

            </div>
            <div class="col-md-3">                       
                <?php echo $html_options; ?>                        
            </div> 
        </div>
    </div>
</div>