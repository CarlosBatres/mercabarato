<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Datos de la Tarifa
            </h1>            
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Detalles de la Tarifa</h2>                                        
                <hr>                
                <?php echo form_open('panel_vendedor/tarifas/modificar-datos/'.$tarifa_general->id, 'id="detalles_tarifa" rel="preventDoubleSubmission"'); ?>                                                                 
                <hr>
                <div class="row">                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Titulo</label>                    
                            <input type="text" class="form-control" name="nombre" value="<?php echo $tarifa_general->nombre?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripcion</label>                    
                            <textarea class="form-control" name="descripcion" rows="10"><?php echo $tarifa_general->descripcion?></textarea>
                        </div>
                    </div> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Condiciones particulares ( Este texto sera visible a los clientes )</label>                    
                            <input type="text" class="form-control" name="condicion_particular" value="<?php echo $tarifa_general->condicion_particular?>">
                        </div>
                    </div>                 
                </div>
                <hr>
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Modificar Tarifa</button>
                </div>
                <input type="hidden" name="accion" value="item-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    
</div>

