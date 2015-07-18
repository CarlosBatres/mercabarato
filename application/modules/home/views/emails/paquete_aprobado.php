<h1>Tu paquete ha sido aprobado con exito!.</h1>

<p><strong>Paquete:</strong> <?php echo $paquete->nombre_paquete?></p>
<p><strong>Comprado el:</strong><?php echo date("d-m-Y",strtotime($paquete->fecha_comprado))?></p>
<p><strong>Expira el:</strong><?php echo date("d-m-Y",strtotime($paquete->fecha_terminar))?></p>
<p><strong>Monto cancelado:</strong><?php echo $paquete->monto_a_cancelar?></p>

<br>

<p>Tu cuenta se encuentra habilitada puedes iniciar ya ingresando al siguiente link</p>

<p class="text-right"><strong><a href="<?php echo site_url('panel_vendedores')?>"><?php echo site_url('panel_vendedores')?></a></strong></p>                    