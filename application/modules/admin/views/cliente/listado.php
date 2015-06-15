<div id="question" style="display:none; cursor: default">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Esta seguro que desea eliminar este usuario?.</h4>
        </div>
        <div class="modal-body">                                    
            <p class="text-center">
                <button class="btn btn-success" type="button" id="yes"><i class="fa fa-check"></i> Si</button>
                <button class="btn btn-danger" type="button" id="no"><i class="fa fa-close"></i> No</button>
            </p>                                            
        </div>        
    </div>
</div> 
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Usuarios
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-inbox"></i> Usuarios
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">            
            <div class="row agregar-item">
                <div class="col-md-12">            
                    <a class="btn btn-lg btn-default" href="<?php echo site_url('admin/usuarios/crear'); ?>">Nuevo Usuario</a>
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
                            <form action="<?php echo site_url('admin/cliente') ?>" method="post" class="search-form" id="listado-items">
                                <div class="row">                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="nombre">Nombre del Usuario</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nombre" id="nombre" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div>                                                                                                                                                
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listado de Usuarios
                        </div>
                        <div class="panel-body">
                            <div class="alertas">
                                <?php if ($this->session->flashdata('error')) { ?>
                                    <div class="alert alert-danger"> 
                                        <a class="close" data-dismiss="alert">×</a>
                                        <?= $this->session->flashdata('error') ?> 
                                    </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success"> 
                                        <a class="close" data-dismiss="alert">×</a>
                                        <?= $this->session->flashdata('success') ?> 
                                    </div>
                                <?php } ?>
                            </div>
                            <div id="tabla-resultados"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>