<div id="question" style="display:none; cursor: default">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Esta seguro que desea enviar este mensaje?.</h4>
        </div>
        <div class="modal-body">                                    
            <p class="text-center">
                <button class="btn btn-success" type="button" id="yes"><i class="fa fa-check"></i> Enviar</button>
                <button class="btn btn-danger" type="button" id="no"><i class="fa fa-close"></i> Cancelar</button>
            </p>                                            
        </div>        
    </div>
</div> 
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Listado General 
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
                            <a data-toggle="collapse" data-parent="#search-block" href="#collapse_search"><span class="pull-right glyphicon glyphicon-chevron-down"></span><span class="glyphicon glyphicon-search"></span> Busqueda</a>                                        
                        </h4>
                    </div>
                    <div id="collapse_search" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form action="<?php echo site_url('admin/productos') ?>" method="post" class="search-form" id="listado-productos">
                                <div class="row">                                    
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Nombre</label>                                            
                                            <input type="text" name="nombre" id="nombre" value="" class="form-control"/>                                
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>                                            
                                            <input type="text" name="email" id="email" value="" placeholder="email@mail.com" class="form-control"/>                                                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Tipo de Usuario</label>
                                            <select name="tipo_usuario" class="form-control">                        
                                                <option value="0">Todos</option>
                                                <option value="1">Solo Clientes</option>
                                                <option value="2">Solo Vendedores</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Ultimo Acceso</label>
                                            <select name="ultimo_acceso" class="form-control">                        
                                                <option value="0">Todo el Tiempo</option>
                                                <option value="1">Hace menos de 1 Mes</option>
                                                <option value="2">Hace menos 2 Mes</option>
                                                <option value="3">Hace menos 5 Mes</option>
                                                <option value="4">Hace mas de 1 Año</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                

                                <hr>
                                <div class="row"> 
                                    <div class="col-md-1">
                                        <div class="form-buttons">
                                            <button type="submit" id="btn-search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                                            <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Usuarios en el Sistema
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