<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Enviar Anuncio
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">                                  
            <div class="row">
                <div class="col-xs-12">
                    <p class="lead">Selecciona a continuación los productos ( Maximo 10 ) que deseas enviar con este anuncio, luego presiona <strong>Enviar y Finalizar</strong>.</p>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listado de Productos
                        </div>
                        <?php echo form_open('panel_vendedor/anuncio/listado', 'id="listado-items" class="search-form"'); ?>
                        <input type="hidden" value="<?php echo $anuncio_id ?>" name="anuncio_id" id="anuncio_id"/>                                        
                        <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                        <?php echo form_close(); ?>
                        <div class="panel-body">
                            <div id="tabla-resultados"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-center">                    
                    <button type="button" id="siguiente" class="btn btn-lg btn-primary"> Enviar y Finalizar</button>                    
                </div>
            </div>
        </div>
    </div>    
</div>