<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Detalles de la Oferta
            </h1>                        
        </div>
    </div>  
    <div class="row">
        <div class="col-md-6">
            <div class="pull-left">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/listado/') ?>" class="btn btn-primary"> Regresar</a>
            </div>
        </div>        
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    &nbsp;
                </div>
                <div class="panel-body">
                    <p class="lead"> <strong><?php echo $oferta_general->nombre ?></strong></p>
                    <p> <?php echo $oferta_general->descripcion ?></p>
                    <hr>
                    <p> <strong>Fecha de Inicio:</strong> <?php echo date("d-m-Y", strtotime($oferta_general->fecha_inicio)) ?></p>
                    <p> <strong>Fecha de Finalizacion:</strong> <?php echo date("d-m-Y", strtotime($oferta_general->fecha_finaliza)) ?></p>
                    <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                    <input type="hidden" value="1" name="pagina_tab2" id="pagina_tab2"/>                                        
                    <input type="hidden" value="<?php echo $oferta_general->id ?>" name="og_id" id="og_id"/>                                        

                    <div class="col-md-6">
                        <div class="">                        
                            <a href="<?php echo site_url('panel_vendedor/ofertas/modificar-datos/' . $oferta_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Datos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Productos</strong>
                </div>
                <div class="panel-body">
                    <div id="tabla-resultados-productos"></div>
                </div>
            </div>
        </div>        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Clientes</strong>
                </div>
                <div class="panel-body">                            
                    <div id="tabla-resultados-clientes"></div>
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6">
            <div class="text-center">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/modificar-productos/' . $oferta_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Productos</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-center">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/modificar-clientes/' . $oferta_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Clientes</a>
            </div>
        </div>
    </div>            
</div>
