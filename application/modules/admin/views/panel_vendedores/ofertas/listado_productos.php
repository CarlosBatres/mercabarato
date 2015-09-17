<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Nueva Oferta
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
                            <a data-toggle="collapse" data-parent="#search-block" href="#collapse_search"><span class="pull-right glyphicon glyphicon-chevron-down"></span><span class="glyphicon glyphicon-search"></span> Busqueda panel Mis Productos</a>                                        
                        </h4>
                    </div>
                    <div id="collapse_search" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <?php echo form_open('', 'id="listado-item" class="search-form"'); ?>                            
                                <div class="row">                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="nombre">Nombre del Producto</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nombre" id="nombre" value="" class="form-control"/>                                
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
                            <?php echo form_close(); ?>
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
                    <strong>Mis Productos</strong>
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
                        <p> Selecciona del listado en la izquierda los productos que desea Ofertar y presiona <strong>Mover</strong></p>
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
                        <p> Cuando este satisfecho con los productos seleccionados presione <strong>Continuar</strong></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">                    
                    <a href="<?php echo site_url('panel_vendedor/ofertas/seleccion_clientes')?>" class="btn btn-success">Continuar <span class="glyphicon glyphicon-ok"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Productos a Ofertar</strong>
                </div>
                <div class="panel-body">                            
                    <div id="tabla-resultados-ofertas"></div>
                </div>
            </div>
        </div>
    </div>
</div>