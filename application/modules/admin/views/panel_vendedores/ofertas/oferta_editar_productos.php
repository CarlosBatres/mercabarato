<div class="container-fluid">    
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Productos de la Oferta
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
    <input type="hidden" value="1" name="pagina_tab2" id="pagina_tab2"/>                                        
    <input type="hidden" value="<?php echo $oferta_general->id ?>" name="og_id" id="og_id"/>                                        
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>PRODUCTOS EN LA OFERTA</strong>
                </div>
                <div class="panel-body">
                    <div id="tabla-resultados-productos-ofertados"></div>
                </div>
            </div>
        </div>        
        <div class="col-md-2 text-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">                         
                        <p> Selecciona y utiliza los botones para mover productos dentro y fuera de tu oferta</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="btn-remover" class="btn btn-danger"> Remover <span class="glyphicon glyphicon-arrow-right"></span></button>
                </div>
            </div>
            <br>                        
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="btn-agregar" class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span> Agregar</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="btn-modificar" class="btn btn-info"> <span class="glyphicon glyphicon-check"></span> Modificar Importe</button>
                </div>
            </div>
            
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">                         
                        <p> Cuando este satisfecho con los cambios presiona <strong>Terminar</strong></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">                    
                    <a href="<?php echo site_url('panel_vendedor/ofertas/ver-oferta/' . $oferta_general->id) ?>" class="btn btn-success">Terminar <span class="glyphicon glyphicon-ok"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>PRODUCTOS DISPONIBLES</strong>
                </div>
                <div class="panel-body">                            
                    <div id="tabla-resultados-productos-disponibles"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">                
            </div>
        </div>        
    </div>
</div>
