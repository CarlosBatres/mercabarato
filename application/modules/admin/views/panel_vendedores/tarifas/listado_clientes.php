<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Nueva Tarifa
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group search-block" id="search-block">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#search-block" href="#collapse_search"><span class="pull-right glyphicon glyphicon-chevron-down"></span><span class="glyphicon glyphicon-search"></span> Busqueda panel Mis Clientes</a>                                        
                        </h4>
                    </div>
                    <div id="collapse_search" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form action="" method="post" class="search-form" id="listado-items">
                                <div class="row">                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="nombre">Nombre del Cliente</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nombre" id="nombre" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div>                                                                                                                                                                                                                                                             
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-12">Busqueda por Intereses Ejm: Informatica,Servicios,Moda etc.</label>
                                            <div class="col-md-12">
                                                <input type="text" name="keywords" id="keywords" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">       
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="sexo">Sexo</label>
                                            <div class="col-md-12">
                                                <select name="sexo" class="form-control">
                                                    <option value="X">Seleccione uno</option>
                                                    <option value="H">Hombre</option>
                                                    <option value="M">Mujer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                     
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="email">Email</label>
                                            <div class="col-md-12">
                                                <input type="text" name="email" id="email" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <hr>

                                <div class="row"> 
                                    <div class="col-md-1">
                                        <div class="form-buttons">
                                            <button type="submit" id="btn-search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                                            <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                                            <input type="hidden" value="1" name="pagina_tab2" id="pagina_tab2"/>                                        
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Mis Clientes</strong>
                </div>
                <div class="panel-body">
                    <div id="tabla-resultados"></div>
                </div>
            </div>
        </div>
        <div class="col-md-2 text-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">                         
                        <p> Selecciona del listado en la izquierda los clientes que desees incluir en la tarifa y presiona <strong>Mover</strong></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="btn-mover" class="btn btn-primary"> Mover <span class="glyphicon glyphicon-arrow-right"></span></button>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">                         
                        <p> Cuando este satisfecho con los clientes seleccionados presione <strong>Continuar</strong></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">                    
                    <a href="<?php echo site_url('panel_vendedor/tarifas/detalles')?>" class="btn btn-success">Continuar <span class="glyphicon glyphicon-ok"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Clientes a ofrecer la Tarifa</strong>
                </div>
                <div class="panel-body">                            
                    <div id="tabla-resultados-tarifas"></div>
                </div>
            </div>
        </div>
    </div>
</div>