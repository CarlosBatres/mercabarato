<div id="question" style="display:none; cursor: default">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Eliminar Vendedor.</h4>
        </div>
        <div class="modal-body">                                    
            <p class="content"> Estas seguro que deseas eliminar este vendedor? , ten en cuenta que se eliminara todo lo asociado a el</p>
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
                Vendedores / Empresas
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li class="active">
                    <i class="fa fa-inbox"></i> Vendedores
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('success') ?> 
                </div>
            <?php } ?>            
            <div class="panel-group search-block" id="search-block">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#search-block" href="#collapse_search"><span class="pull-right glyphicon glyphicon-chevron-down"></span><span class="glyphicon glyphicon-search"></span> Busqueda</a>                                        
                        </h4>
                    </div>
                    <div id="collapse_search" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form action="<?php echo site_url('admin/vendedor') ?>" method="post" class="search-form" id="listado-items">
                                <div class="row">                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="nombre">Nombre de Empresa o Vendedor</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nombre" id="nombre" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="actividad">Actividad</label>
                                            <div class="col-md-12">                                                
                                                <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), null, 'id="actividad" class="form-control"') ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="email">Email</label>
                                            <div class="col-md-12">
                                                <input type="text" name="email" id="email" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="sitioweb">Sitio Web</label>
                                            <div class="col-md-12">
                                                <input type="text" name="sitioweb" id="sitioweb" value="" class="form-control"/>                                
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>                                
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
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
                            Listado de Usuarios Vendedores
                        </div>
                        <div class="panel-body">
                            <?php if ($pais): ?>
                                <div class="alert alert-danger">                                                                 
                                    <p> Estas restringido a la siguiente zona:</p>
                                    <p> <strong><?php echo $pais->nombre; ?><?php echo ($provincia)? " / ".$provincia->nombre:""?><?php echo ($poblacion)? " / ".$poblacion->nombre:""?></strong></p>                                
                                </div>
                            <?php endif; ?>
                            <div id="tabla-resultados"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>