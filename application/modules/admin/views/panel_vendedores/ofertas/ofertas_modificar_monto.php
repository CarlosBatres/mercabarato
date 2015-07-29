<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Indica a continuacion el nuevo monto de los productos</h4>    
</div>
<div class="modal-body">
    <div class="row box">
        <div class="col-md-10 col-md-offset-1">                                                
            <?php echo form_open('panel_vendedor/ofertas/ajax_incluir_productos','id="ofertas-modificar-monto"'); ?>                                             
            <div class="col-md-12">       
                <div class="table-responsive">        
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>                                                                          
                                <th style="width: 40%">Nombre del Producto</th>                        
                                <th style="width: 30%;text-align: center">P.V.P.</th>                                                             
                                <th style="width: 30%;text-align: center">Nuevo Costo</th>                                                             
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                                <tr data-id="<?php echo $producto->id?>">                                                        
                                    <td><?php echo $producto->nombre; ?></td>                            
                                    <td style="text-align: center"><?php echo $producto->precio . ' ' . $this->config->item('money_sign'); ?></td>                                                                                                                                        
                                    <td><input type="text" name="nuevo_costo" value="" autocomplete="off"/></td>                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>                    
                </div>                
            </div>                                        
            <?php echo form_close(); ?>
        </div>                      
    </div>
</div>
<div class="modal-footer">
    <button type="button" id="modificar-monto-submit" class="btn btn-success">Confirmar</button>    
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>                    
</div>


