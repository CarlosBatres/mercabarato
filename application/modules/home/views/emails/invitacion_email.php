<?php if (isset($sin_registro)): ?>
    <?php if ($titulo != "" && $comentario != ""): ?>
        <h1><?php echo $titulo; ?></h1>        
        <?php echo $comentario; ?>
        <br>
        <p>Puedes ingresar al siguiente link y aceptar la invitacion.</p>
        <a href="<?php echo site_url("usuario/contactos"); ?>"><?php echo site_url("usuario/contactos"); ?></a>
    <?php else: ?>    
        <h1>Invitacion desde Mercabarato.com</h1>        
        <p>Puedes ingresar al siguiente link y aceptar la invitacion.</p>
        <a href="<?php echo site_url("usuario/contactos"); ?>"><?php echo site_url("usuario/contactos"); ?></a>
    <?php endif; ?>
<?php else: ?>    
    <?php if ($titulo != "" && $comentario != ""): ?>
        <h1><?php echo $titulo; ?></h1>        
        <?php echo $comentario; ?>
    <?php else: ?>    
        <h1>Invitacion desde Mercabarato.com</h1>
        <br>
        <p>Tienes una nueva invitacion</p>
    <?php endif; ?>
    <br>
    <p>Puede ingresar al sitio mediante el siguiente link y proceder a registrarse.</p>
    <a href="<?php echo site_url("registro"); ?>"><?php echo site_url("registro"); ?></a>
<?php endif; ?>




