<?php if (sizeof($productos) == 0): ?>
    <div>        
        <div class="alert alert-warning">             
            <p> No se encontro ningun producto que se ajuste a estos parametros, puedes intentar lo siguiente: </p>    
            <ul>                
                <li> Prueba con un nombre o palabras claves diferentes.</li>
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
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"> 
            <a class="close" data-dismiss="alert">×</a>
            <?= $this->session->flashdata('error') ?> 
        </div>
    <?php } ?>

    <?php if ($ilimitado): ?>
        <div class="alert alert-info">                 
            <p> Puedes insertar productos sin limites</p>
        </div>
    <?php else: ?>
        <div class="alert alert-info">                 
            <?php $diff = $limite_productos - $productos_total; ?>
            <?php if ($diff < 0): ?>
                <p> Tienes un exceso de <?php echo $diff * -1 ?> productos de un maximo de <?php echo $limite_productos ?> productos.</p>
            <?php else: ?>
                <p> Puedes insertar <?php echo $diff ?> productos mas de un maximo de <?php echo $limite_productos ?> productos.</p>
            <?php endif; ?>                
        </div>
    <?php endif; ?>

    <div class="table-responsive">        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>    
                    <th style="width: 1%"><input type="checkbox" name="select_all" value="ON" /></th>              
                    <th style="width: 14%">Nombre del Producto</th>
                    <th style="width: 5%;text-align: center">Precio Venta Publico</th>
                    <th style="width: 10%">Categoria</th>                
                    <th style="width: 5%;text-align: center">Visible al Publico</th>                                            
                    <th style="width: 5%;text-align: center">PVP Visible</th>
                    <th style="width: 5%;text-align: center">Habilitado</th>
                    <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr data-id="<?php echo $producto->id; ?>">
                        <td><input type="checkbox" name="eliminar" value="ON"/></td>
                        <td><?php echo $producto->nombre; ?></td>
                        <td style="text-align: center"><?php echo $producto->precio . ' ' . $this->config->item('money_sign'); ?></td>                                                                
                        <td><?php echo $producto->Categoria; ?></td>                    
                        <td style="text-align: center"><?php
                            if ($producto->mostrar_producto == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>                    
                        <td style="text-align: center"><?php
                            if ($producto->mostrar_precio == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>                                                                
                        <td style="text-align: center"><?php
                            if ($producto->habilitado == 1): echo "<span class='label label-success'>Si</span>";
                            else: echo "<span class='label label-danger'>No</span>";
                            endif;
                            ?>
                        </td>                                                                
                        <td>
                            <div class="options">
                                <?php if ($producto->habilitado == 0): ?>
                                    <a class="row_action habilitar" href="<?php echo site_url('panel_vendedor/producto/habilitar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Habilitar"><i class="glyphicon glyphicon-ok"></i></a>
                                <?php else: ?>
                                    <a class="row_action inhabilitar" href="<?php echo site_url('panel_vendedor/producto/inhabilitar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Inhabilitar"><i class="glyphicon glyphicon-remove"></i></a>
                                <?php endif; ?>
                                <a href="<?php echo site_url('panel_vendedor/producto/editar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="row_action borrar" href="<?php echo site_url('panel_vendedor/producto/borrar') . '/' . $producto->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>        
        <?php echo $pagination; ?>                        
    </div> 
    <button type="button" id="btn-eliminar-seleccionados" class="btn btn-danger">Eliminar Seleccionados</button>
<?php endif; ?>
