<div id="question" style="display:none; cursor: default">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Esta seguro que desea eliminar este producto?.</h4>
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
                Buscar Clientes
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12"> 
            <div class="row">
                <div class="panel-group search-block" id="search-block">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#search-block" href="#collapse_search"><span class="pull-right glyphicon glyphicon-chevron-down"></span><span class="glyphicon glyphicon-search"></span> Busqueda</a>                                        
                            </h4>
                        </div>
                        <div id="collapse_search" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <?php echo form_open('panel_vendedor/producto/listado', 'id="listado-items" class="search-form"'); ?>                                
                                    <div class="row">                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-12" for="nombre">Identificacion</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="nombre" id="nombre" value="" class="form-control"/>                                
                                                </div>
                                            </div>
                                        </div>                                                                                                                                                                                                                                                             
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-12">Palabras Clave. Ejm: Informatica,Servicios,Moda etc.</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="keywords" id="keywords" value="" class="form-control"/>                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row">                                                                               
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
                                            </div>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('success') ?> 
                </div>
            <?php } ?>   
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Clientes
                    </div>
                    <div class="panel-body">
                        <div id="tabla-resultados"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>