<?php if (sizeof($solicitud_seguros)==0): ?>
<div>
    <p> No se encontraron resultados...</p>    
</div>
<?php else: ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>                
                <th style="width: 30%">Nombre Solicitante</th>
                <th style="width: 30%">Fecha Solicitud</th>
                <th style="width: 30%;text-align: center">Respuesta</th>
                <th style="width: 5%;text-align: center">&nbsp; Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitud_seguros as $solicitud): ?>
                <tr>                    
                    <td><?php echo $solicitud->nombres .' '.$solicitud->apellidos; ?></td>                    
                    <td><?php echo date('d-m-Y',strtotime($solicitud->fecha_solicitud)); ?></td>                    
                    <td style="text-align: center"><?php
                        if ($solicitud->fecha_respuesta == null): echo "<span class='label label-danger'>Sin Respuesta</span>";
                        else: echo "<span class='label label-success'>Respondido</span>";
                        endif;
                        ?>
                    </td>
                    <td>
                        <div class="options">
                            <a href="<?php echo site_url('panel_vendedor/infocompras/seguros/responder') . '/' . $solicitud->id ?>" data-toogle="tooltip"  title="Responder"><i class="glyphicon glyphicon-forward"></i></a>
                            <!--<a class="item_borrar" href="<?php echo site_url('admin/anuncios/borrar') . '/' . $solicitud->id ?>" data-toogle="tooltip"  title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>-->
                        </div>                           
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $pagination; ?>
</div> 
<?php endif; ?>
