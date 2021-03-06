<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Detalles de la Tarifa
            </h1>                        
        </div>
    </div>  
    <div class="row">
        <div class="col-md-6">
            <div class="pull-left">                        
                <a href="<?php echo site_url('panel_vendedor/tarifas/listado/') ?>" class="btn btn-primary"> Regresar</a>
            </div>
        </div>        
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    &nbsp;
                </div>
                <div class="panel-body">
                    <p class="lead"> <strong><?php echo $tarifa_general->nombre ?></strong></p>
                    <?php if ($tarifa_general->descripcion != ""): ?>
                        <p> <?php echo $tarifa_general->descripcion ?></p>
                    <?php else: ?>
                        <p> No hay mas informacion disponible.</p>
                    <?php endif; ?>

                    <?php if ($tarifa_general->condicion_particular != ""): ?>
                        <p> <strong>Condiciones Particulares: </strong></p>
                        <p> <?php echo $tarifa_general->condicion_particular ?></p>                    
                    <?php endif; ?>

                    <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                    <input type="hidden" value="1" name="pagina_tab2" id="pagina_tab2"/>                                        
                    <input type="hidden" value="<?php echo $tarifa_general->id ?>" name="tg_id" id="tg_id"/>                                        
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="text-center">                        
                <a href="<?php echo site_url('panel_vendedor/tarifas/modificar-productos/' . $tarifa_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Productos</a>
            </div>
        </div>        
        <div class="col-sm-12 col-md-4">
            <div class="text-center">                        
                <a href="<?php echo site_url('panel_vendedor/tarifas/modificar-datos/' . $tarifa_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Datos</a>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="text-center">                        
                <a href="<?php echo site_url('panel_vendedor/tarifas/modificar-clientes/' . $tarifa_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Clientes</a>
            </div>
        </div>
    </div>            
    <br>
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
</div>
