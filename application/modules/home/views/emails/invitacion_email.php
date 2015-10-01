<?php header('Content-Type:text/html; charset=UTF-8');?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">	
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                <tr>
                    <td align="center" bgcolor="#d99327" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                        <img src="<?php echo assets_url('imgs/logo.png') ?>" alt="Mercabarato.com" width="340" height="76" style="display: block;" />
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <?php if ($titulo != "" && $comentario != ""): ?>
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b><?php echo $titulo; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <?php echo $comentario; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Puede ingresar al sitio y proceder a <a href="<?php echo site_url("registro"); ?>"><strong>registrarse</strong></a>.</p>
                                        
                                    </td>
                                </tr>
                                <?php if($link):?>
                                <tr>
                                    <td style="padding: 0 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Si ya estas registrado en el sitio pero con un email diferente puedes seguir el link a continuacion:</p>
                                        <a href="<?php echo $link ?>">Link para continuar...</a>
                                    </td>
                                </tr>
                                <?php endif;?>
                            <?php else: ?>
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>Invitacion desde Mercabarato.com</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Tienes una nueva invitacion de <strong><?php echo $identidad?></strong> en nuestro sitio , si deseas interactuar con este Vendedor sigue las instrucciones a continuacion.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Puede ingresar al sitio y proceder a <a href="<?php echo site_url("registro"); ?>"><strong>registrarse</strong></a>.</p>
                                        
                                    </td>
                                </tr>
                                <?php if($link):?>
                                <tr>
                                    <td style="padding: 0 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Si ya estas registrado en el sitio pero con un email diferente puedes seguir el link a continuacion:</p>
                                        <a href="<?php echo $link ?>">Link para continuar...</a>
                                    </td>
                                </tr>
                                <?php endif;?>
                            <?php endif; ?>                            
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#333" style="padding: 30px 15px 30px 15px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; text-align: center; font-family: Arial, sans-serif; font-size: 14px;" width="100%">
                                    <span style="font-weight: 600;color: #ff9933;">PRÁCTICA EL COMERCIO INTELIGENTE <br>( COMPARA PRECIOS , PRESUPUESTOS , OFERTAS)</span> <br><br>
                                    Copyright &copy; 2015. Mercabarato.com Todos los derechos reservados.                                    
                                </td>                                
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>