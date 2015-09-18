<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Estadisticas de visitas
            </h1>
            <div class="alert alert-info">
                <p class="lead"> Listado de tus clientes afiliados y la cantidad de visitas a tus productos ordenados por Mes y Año</p>
            </div>
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
                            <?php echo form_open('', 'id="listado-items" class="search-form"'); ?>                            
                            <div class="row">                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-12" for="nombre">Mes</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="mes">
                                                <?php foreach (mes_select() as $key => $mes): ?>
                                                    <option value="<?php echo $key ?>" <?php echo ($mes_actual == $key) ? 'selected' : '' ?> ><?php echo $mes ?></option>                                                    
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-12" for="nombre">Año</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="year">
                                                <?php foreach (year_select() as $key => $year): ?>
                                                    <option value="<?php echo $key ?>" <?php echo ($year_actual == $year) ? 'selected' : '' ?> ><?php echo $year ?></option>                                                    
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                                                                                                                                                                                                                                             
                            </div>                                
                            <hr>
                            <div class="row"> 
                                <div class="col-md-2">
                                    <div class="form-buttons pull-left">
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Visitas
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