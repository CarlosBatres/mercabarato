<h1>Tu paquete ha sido aprobado con exito!.</h1>

<p><strong>Paquete:</strong> <?php echo $paquete->nombre_paquete?></p>
<p><strong>Comprado el:</strong><?php echo $paquete->fecha_comprado?></p>
<p><strong>Expira el:</strong><?php echo $paquete->fecha_terminar?></p>
<p><strong>Monto cancelado:</strong><?php echo $paquete->monto_a_cancelar?></p>

<br>

<p>A continuacion los datos para realizar el pago:</p>
<p><strong>Cuenta:</strong> XXX</p>
<p><strong>A nombre de:</strong> XXX</p>

<br>

<p>Tu cuenta se encuentra habilitada puedes iniciar ya ingresando al siguiente link</p>

<p class="text-right"><strong><a href="http://<?php echo site_url('panel_vendedores')?>"><?php echo site_url('panel_vendedores')?></a></strong></p>                    