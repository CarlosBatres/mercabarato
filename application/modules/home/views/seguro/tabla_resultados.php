<?php if (sizeof($vendedores) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>
    <ul class="tabla-resultados-principal">
        <?php foreach ($vendedores as $key => $vendedor): ?>
            <li>                
                <div class="row">
                    <div class="col-md-8">                                        
                        <p><strong><?php echo $vendedor->nombre; ?></strong></p>
                        <?php if ($vendedor->descripcion != ""): ?>                         
                            <p><?php echo truncate($vendedor->descripcion, 300) ?></p>  
                        <?php else: ?>
                            <br>
                            <p></p>
                            <br>
                        <?php endif; ?>                        
                    </div>              
                </div>  
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="button" class="btn btn-template-primary enviar_presupuesto" data-id="<?php echo $vendedor->id ?>"> Enviar</button>
                        </div>
                    </div>
                </div> 
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;