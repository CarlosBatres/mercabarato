<div id="question" style="display:none; cursor: default">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Esta seguro que desea eliminar esta categoria?.</h4>
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
                Categorias
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/categorias'); ?>">Categorias</a>
                </li>
                <?php foreach ($categorias_arbol as $var): ?>
                    <li>
                        <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/categoria') . '/' . $var->slug ?>"><?php echo $var->nombre ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="active">
                    <i class="fa fa-inbox"></i> <?php echo $categoria->nombre; ?>
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
                            <?php echo form_open('admin/categoria', 'id="listado-items" class="search-form"'); ?>                                                        
                                <div class="row">                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-12" for="nombre">Nombre</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nombre" id="nombre" value="" class="form-control"/>                                
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
                                            <input type="hidden" value="sub" name="tipo"/>
                                            <input type="hidden" value="<?php echo $categoria->id; ?>" name="categoria_id"/>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row agregar-item">
                <div class="col-md-6">
                    <ul class="categorias-listado">
                        <?php echo $categorias_arbol_html; ?>                        
                    </ul>
                </div>
                <div class="col-md-6">            
                    <a class="btn btn-lg btn-primary pull-right" href="<?php echo site_url('admin/categorias/crear') . '/' . $categoria->id; ?>">Nueva Categoria</a>
                </div>                
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listado de sub-categorias de <strong><?php echo $categoria->nombre ?></strong>
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