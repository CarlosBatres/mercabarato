<?php if (sizeof($vendedores) == 0): ?>
    <div>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"> 
                <a class="close" data-dismiss="alert">×</a>
                <?= $this->session->flashdata('success') ?> 
            </div>
        <?php } ?> 

        <div class="alert alert-warning">             
            <p> De momento no existe ningún proveedor que se ajuste a estos parámetros, puedes intentar lo siguiente: </p>    
            <ul>
                <li> Selecciona un lugar diferente ( <strong>Provincia o población </strong> ).</li>                
            </ul>
        </div>        

    </div>
<?php else: ?>
    <?php if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success"> 
            <a class="close" data-dismiss="alert">×</a>
            <?= $this->session->flashdata('success') ?> 
        </div>
    <?php } ?> 
    <ul class="tabla-resultados-principal">
        <?php foreach ($vendedores as $key => $vendedor): ?>
            <li>                
                <div class="row">
                    <div class="col-md-12">                                        
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
            </li>        
        <?php endforeach; ?>
    </ul>

    <?php echo $pagination; ?>    
<?php endif;