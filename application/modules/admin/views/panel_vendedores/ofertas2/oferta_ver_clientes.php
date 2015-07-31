<div class="container-fluid">    
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Listado de Clientes
            </h1>                      
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6">
            <div class="pull-left">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/ver-oferta/' . $oferta_general->id) ?>" class="btn btn-primary"> Regresar</a>
            </div>
        </div>        
    </div>
    <hr>
    <input type="hidden" value="1" name="pagina" id="pagina"/>                                            
    <input type="hidden" value="<?php echo $oferta_general->id ?>" name="og_id" id="og_id"/>                                        
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Clientes que cumplieron los requisitos</strong>
                </div>
                <div class="panel-body">
                    <div id="tabla-resultados-clientes"></div>
                </div>
            </div>
        </div>              
    </div>    
</div>
