<?php if ($titulo != "" && $comentario != ""): ?>
    <h1><?php echo $titulo; ?></h1>    
    <?php echo $comentario; ?>
    <br>
    <p>Puedes ingresar al siguiente link y aceptar la invitacion.</p>
    <a href="<?php echo site_url("panel_vendedor/invitaciones/recibidas"); ?>"><?php echo site_url("panel_vendedor/invitaciones/recibidas"); ?></a>
<?php else: ?>    
    <h1>Invitacion desde Mercabarato.com</h1>    
    <p>Puedes ingresar al siguiente link y aceptar la invitacion.</p>
    <a href="<?php echo site_url("panel_vendedor/invitaciones/recibidas"); ?>"><?php echo site_url("panel_vendedor/invitaciones/recibidas"); ?></a>
<?php endif; ?>
