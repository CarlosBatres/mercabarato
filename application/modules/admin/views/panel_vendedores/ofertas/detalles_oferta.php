<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Nueva Oferta
            </h1>            
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Productos Seleccionados</strong>
                </div>
                <div class="panel-body">
                    <div id="tabla-resultados-productos"></div>
                </div>
            </div>
        </div>        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Clientes Seleccionados</strong>
                </div>
                <div class="panel-body">                            
                    <div id="tabla-resultados-clientes"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="box box_registro">
                <h2 class="text-uppercase">Detalles de la Oferta</h2>                                        
                <hr>                
                <?php echo form_open('panel_vendedor/ofertas/crear' , "id='detalles_oferta'"); ?>                                 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Descuento</label>
                            <input type="text" class="form-control" name="valor">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <select class="form-control" name="tipo">                                
                                <option value="porcentaje">( % )</option>
                                <?php if (!$mas_de_uno): ?>
                                    <option value="valor">( <?php echo $this->config->item("money_sign") ?> )</option>                                
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>                                        
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Inicio</label>
                            <div class="input-group">                                                                        
                                <input type="text" id="datepicker" class="form-control" name="fecha_inicio">
                                <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Finalizacion</label>
                            <div class="input-group">                                                                        
                                <input type="text" id="datepicker2" class="form-control" name="fecha_finaliza">
                                <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <hr>                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre">                                
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Breve Descipcion</label>                    
                            <textarea class="form-control" name="descripcion" rows="5"></textarea>
                        </div>
                    </div>                 
                </div>

                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Crear Oferta</button>
                </div>
                <input type="hidden" name="accion" value="item-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

