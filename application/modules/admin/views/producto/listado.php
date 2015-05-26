<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3 id="myModalLabel">Delete</h3>
    </div>
    <div class="modal-body">
        <p></p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button data-dismiss="modal" class="btn red" id="btnYes">Confirm</button>
    </div>
</div>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Productos <small>Listado de productos actualmente en el sistema</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-inbox"></i> Productos
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">            
            <div class="row agregar_producto">
                <div class="col-md-12">            
                    <a class="btn btn-lg btn-default" href="<?php echo site_url('admin/productos/nuevo'); ?>">Crear Producto</a>
                </div>                
            </div>

            <div class="panel-group search-block" id="search-block">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#search-block" href="#collapse_search" class="collapsed"><span class="pull-right glyphicon glyphicon-chevron-down"></span><span class="glyphicon glyphicon-search"></span> Busqueda</a>                                        
                        </h4>
                    </div>
                    <div id="collapse_search" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <form action="<?php echo site_url('admin/productos') ?>" method="post" class="search-form" id="listado-productos">
                                <div class="row">                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="nombre">Nombre del Producto</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nombre" id="nombre" value="<?php echo $search_params["nombre"]; ?>" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div>                                                                                                                                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="categoria">Categoria</label>
                                            <div class="col-md-12">
                                                <select name="categoria" class="form-control">
                                                    <option value="0">Seleccione una Categoria</option>
                                                    <?php foreach ($categorias as $categoria): ?>
                                                        <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                     
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="vendedor">Vendedor / Empresa</label>
                                            <div class="col-md-12">
                                                <input type="text" name="vendedor" id="vendedor" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div> 
                                </div>                                
                                <hr>
                                <div class="row"> 
                                    <div class="form-buttons text-right">
                                        <button type="submit" id="btn-search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                                        <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tabla-resultados"></div>
        </div>
    </div>    
</div>