<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                Estadisticas de visitas - Detalles Cliente
            </h1>
            <div class="alert alert-info">
                <p class="lead"><strong><?php echo $cliente->nombres.' '.$cliente->apellidos?></strong></p>
                <p class="lead"> Listado de los productos visitados y su fecha.</p>                
            </div>            
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="pull-left">                        
                <a href="<?php echo site_url('panel_vendedor/estadisticas') ?>" class="btn btn-primary"> Regresar</a>
            </div>
        </div>        
    </div>
    <br>
    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">                        
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <?php echo form_open('', 'id="listado-items" class="search-form"'); ?>
                            <input type="hidden" value="<?php echo $cliente_id ?>" name="cliente_id"/>  
                            <input type="hidden" value="1" name="pagina" id="pagina"/>  
                        <?php echo form_close(); ?>
                        <div class="panel-heading">
                            Visitas
                        </div>
                        <div class="panel-body">
                            <div id="tabla-resultados"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>