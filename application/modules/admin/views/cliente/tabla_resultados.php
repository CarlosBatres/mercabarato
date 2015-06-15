<?php if ($search_params['total_paginas'] < 1): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>

    <div class="table-responsive">
        <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('error') ?> 
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('success') ?> 
                </div>
            <?php } ?>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 5%">ID</th>
                    <th style="width: 15%">Nombre Completo</th>                
                    <th style="width: 5%">Sexo</th>
                    <th style="width: 10%">Fecha de Nacimiento</th>
                    <th style="width: 15%">Email</th>
                    <th style="width: 15%">Ultimo Acceso</th>                
                    <th style="width: 5%">&nbsp;</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente->id; ?></td>                    
                        <?php if ($cliente->nombres != null): ?>
                            <td><?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?></td>                                                                                    
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>

                        <?php if ($cliente->sexo != null): ?>
                            <td><?php echo ($cliente->sexo == 'H') ? 'Hombre' : 'Mujer'; ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>

                        <?php if ($cliente->fecha_nacimiento != null): ?>
                            <td><?php echo date('d-M-Y', strtotime($cliente->fecha_nacimiento)); ?></td>
                        <?php else: ?>   
                            <td class="warning"></td>
                        <?php endif; ?>

                        <td><?php echo $cliente->email; ?></td>
                        <td><?php echo $cliente->ultimo_acceso; ?></td>                    
                        <td>
                            <div class="options">
                                <a href="<?php echo site_url('admin/usuarios/editar') . '/' . $cliente->id ?>" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="item_borrar" href="<?php echo site_url('admin/usuarios/borrar') . '/' . $cliente->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($search_params['total_paginas'] > 1): ?>
            <div class="col-md-6"> Mostrando 
                <?php echo ($search_params['desde'] < $search_params['hasta']) ? $search_params['desde'] . ' a ' . $search_params['hasta'] : ' el ' . $search_params['desde']; ?> 
                de <?php echo $search_params['total']; ?> resultados</div>
            <div class="col-md-6">
                <div class="paginacion-listado">
                    <ul class="pagination">
                        <?php if ($search_params['anterior'] != -1): ?>
                            <li>
                                <a data-id="<?php echo $search_params['anterior']; ?>" href="<?php echo site_url('admin/usuarios/') . '/' . $search_params['anterior'] ?>">Anterior</a>
                            </li>
                        <?php endif; ?>
                        <?php
                        for ($i = 1; $i <= $search_params['total_paginas']; $i++) {
                            $class = "";
                            if ($i == $search_params['pagina']) {
                                $class = "active";
                            }
                            ?>
                            <li class="<?php echo $class; ?>">
                                <a data-id="<?php echo $i; ?>" href="<?php echo site_url('admin/usuarios/') . '/' . $i ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($search_params['siguiente'] != -1): ?>
                            <li>
                                <a data-id="<?php echo $search_params['siguiente']; ?>" href="<?php echo site_url('admin/usuarios/') . '/' . $search_params['siguiente'] ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div> 
<?php endif; ?>
