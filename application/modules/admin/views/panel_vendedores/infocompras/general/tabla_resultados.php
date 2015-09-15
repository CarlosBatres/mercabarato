<?php if (sizeof($infocompras_generales) == 0): ?>
    <div>
        <p> No se encontraron resultados...</p>    
    </div>
<?php else: ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>                
                    <th style="width: 5%">ID</th>
                    <th style="width: 35%">Nombre Solicitante</th>
                    <th style="width: 20%">Fecha Solicitud</th>
                    <th style="width: 20%;text-align: center">Estado</th>
                    <th style="width: 15%;text-align: center">&nbsp; Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($infocompras_generales as $solicitud): ?>
                    <tr>                    
                        <td><?php echo $solicitud->id; ?></td>                    
                        <td>
                            <?php if ($solicitud->nombres != ""): ?>
                                <?php echo $solicitud->nombres . ' ' . $solicitud->apellidos; ?>
                            <?php else: ?>
                                <p><strong>No especificado</strong></p>
                            <?php endif; ?>
                        </td>                    
                        <td><?php echo date('d-M-Y', strtotime($solicitud->fecha_solicitud)); ?></td>                    
                        <td style="text-align: center"><?php
                            if ($solicitud->estado == "0") {
                                if ($solicitud->enviado_por != null) {
                                    echo "<span class='label label-warning'>Nuevo Mensaje</span>";
                                } else {
                                    echo "<span class='label label-warning'>Sin Respuesta</span>";
                                }
                            } elseif ($solicitud->estado == "1") {
                                echo "<span class='label label-success'>Respondido</span>";
                            } elseif ($solicitud->estado == "2") {
                                echo "<span class='label label-danger'>Cerrada</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <div class="options">
                                <?php if ($solicitud->estado == "0"): ?>
                                    <a href="<?php echo site_url('panel_vendedor/infocompras/generales/responder') . '/' . $solicitud->id ?>" data-toogle="tooltip"  title="Responder"><i class="glyphicon glyphicon-forward"></i></a>
                                <?php endif; ?>
                                <?php if ($solicitud->estado != "2"): ?>
                                    <a class="row_action cerrar" href="<?php echo site_url('panel_vendedor/infocompras/generales/cerrar') . '/' . $solicitud->id ?>"  title="Cerrar"><i class="glyphicon glyphicon-ban-circle"></i></a>
                                <?php endif; ?>
                                <a class="row_action borrar" href="<?php echo site_url('panel_vendedor/infocompras/generales/borrar') . '/' . $solicitud->id ?>"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
    </div> 
<?php endif; ?>
