<?php if (sizeof($requisitos) == 0): ?>
    <div>
        <p> No tienes ningun requisito asociado a esta oferta.</p>    
    </div>
<?php else: ?>
    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>   
                    <?php if ($show_checkboxes): ?>
                        <th style="width: 1%"> <input type="checkbox" name="select_all" value="ON" /></th>              
                    <?php endif; ?>
                    <th style="width: 39%">Requisito</th>                                            
                    <th style="width: 69%">Nombre Producto</th>                                            
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisitos as $requisito): ?>
                    <tr data-id="<?php echo $requisito->id; ?>">                                           
                        <?php if ($show_checkboxes): ?>
                            <td><input type="checkbox" name="mover" value="ON" /></td>
                        <?php endif; ?>
                        <td><strong>Visitar el producto</strong></td>
                        <td><?php echo $requisito->nombre; ?></td>                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>
