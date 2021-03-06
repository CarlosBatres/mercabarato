<div class="container-fluid">    
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Clientes de la Tarifa
            </h1>                      
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6">
            <div class="pull-left">                        
                <a href="<?php echo site_url('panel_vendedor/tarifas/ver-tarifa/' . $tarifa_general->id) ?>" class="btn btn-primary"> Regresar</a>
            </div>
        </div>        
    </div>
    <hr>
    <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
    <input type="hidden" value="1" name="pagina_tab2" id="pagina_tab2"/>                                        
    <input type="hidden" value="<?php echo $tarifa_general->id ?>" name="tg_id" id="tg_id"/>                                        
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>CLIENTES EN LA TARIFA</strong>
                </div>
                <div class="panel-body">
                    <div id="tabla-resultados-clientes-tarifados"></div>
                </div>
            </div>
        </div>        
        <div class="col-md-2 text-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">                         
                        <p> Selecciona y utiliza los botones para mover clientes dentro y fuera de tu tarifa</p>
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
                    <a href="<?php echo site_url('panel_vendedor/tarifas/ver-tarifa/' . $tarifa_general->id) ?>" class="btn btn-success">Terminar <span class="glyphicon glyphicon-ok"></span></a>
                </div>
            </div>
            <br>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>CLIENTES DISPONIBLES</strong>
                </div>
                <div class="panel-body">                            
                    <div id="tabla-resultados-clientes-disponibles"></div>
                </div>
            </div>
        </div>
    </div>               
</div>
