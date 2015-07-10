<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Nueva Tarifa
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
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Detalles de la Tarifa</h2>                                        
                <hr>                
                <?php echo form_open('panel_vendedor/tarifas/crear'); ?>                                 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Porcentaje que deseas descontar</label>
                            <input type="text" class="form-control" name="porcentaje">
                        </div>
                    </div>
                    <div class="col-md-4"></div>

                    <?php if (!$mas_de_uno): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Monto especifico</label>
                                <input type="text" class="form-control" name="nuevo_costo">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comentario</label>                    
                            <textarea class="form-control" name="comentario" rows="10"></textarea>
                        </div>
                    </div>                 
                </div>
                <hr>
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Crear Tarifa</button>
                </div>
                <input type="hidden" name="accion" value="item-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

