<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Detalles de la Oferta
            </h1>                        
        </div>
    </div>          
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    &nbsp;
                </div>
                <div class="panel-body">
                    <p class="lead"> <strong><?php echo $oferta_general->nombre ?></strong></p>
                    <?php if ($oferta_general->descripcion != ""): ?>
                        <p> <?php echo $oferta_general->descripcion ?></p>
                    <?php else: ?>
                        <p> No hay mas informacion disponible</p>
                    <?php endif; ?>                    
                    <hr>
                    <p> <strong>Fecha de Inicio:</strong> <?php echo date("d-m-Y", strtotime($oferta_general->fecha_inicio)) ?></p>
                    <p> <strong>Fecha de Finalizacion:</strong> <?php echo date("d-m-Y", strtotime($oferta_general->fecha_finaliza)) ?></p>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">                                                                                        
                                <label>Oferta para:</label>                    
                                <select name="grupo" class="form-control" disabled>
                                    <?php if ($oferta_general->grupo == '0'): ?>
                                        <option selected value="0">Todos</option>                        
                                        <option value="1">Tus Contactos</option>                        
                                        <option value="2">Ignorar tus Contactos</option>                        
                                    <?php elseif ($oferta_general->grupo == '1'): ?>
                                        <option value="0">Todos</option>                        
                                        <option selected value="1">Tus Contactos</option>                        
                                        <option value="2">Ignorar tus Contactos</option>                        
                                    <?php elseif ($oferta_general->grupo == '2'): ?>
                                        <option value="0">Todos</option>                        
                                        <option value="1">Tus Contactos</option>                        
                                        <option selected value="2">Ignorar tus Contactos</option>                                                            
                                    <?php endif; ?>                                
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                    <input type="hidden" value="1" name="pagina_tab2" id="pagina_tab2"/>                                        
                    <input type="hidden" value="<?php echo $oferta_general->id ?>" name="og_id" id="og_id"/>                                                            
                </div>
            </div>
        </div>        
    </div>    
    <div class="row">
        <div class="col-md-3">
            <div class="pull-right">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/modificar-productos/' . $oferta_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Productos</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pull-right">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/modificar-datos/' . $oferta_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Datos</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pull-left">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/ver-oferta-clientes/' . $oferta_general->id) ?>" class="btn btn-lg btn-primary"> Ver Clientes </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pull-left">                        
                <a href="<?php echo site_url('panel_vendedor/ofertas/modificar-requisitos/' . $oferta_general->id) ?>" class="btn btn-lg btn-primary"> Modificar Requisitos</a>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Productos</strong>
                </div>
                <div class="panel-body">
                    <div id="tabla-resultados-productos"></div>
                </div>
            </div>
        </div>        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Requisitos</strong>
                </div>
                <div class="panel-body">                            
                    <div id="tabla-resultados-requisitos"></div>
                </div>
            </div>
        </div>
    </div>                   
</div>
