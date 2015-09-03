<? header("Content-Type: text/html; charset=UTF-8"); ?>
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
                            <tr>
                                <td style="padding: 20px 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                     	
                                    <p>Recientemente, alguien solicitó cambiar la contraseña de tu cuenta en Mercabarato.com. Si fuiste tú, haz clic aquí para definir una nueva contraseña:</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                    
                                    <p><a href="<?php echo site_url('cambio-password/'.$secret_key);?>">Restaurar Contraseña...</a></p>
                                </td>
                            </tr>  
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                     	
                                    <p>Si no deseas modificar tu contraseña o no solicitaste hacerlo, ignora y elimina este mensaje.</p>                                    
                                    <p>Para preservar la seguridad de tu cuenta, no reenvíes este mensaje a nadie.</p>                                    
                                    <p>Gracias.</p>
                                    <p>El equipo de Mercabarato.com</p>
                                </td>
                            </tr>                                                        
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#333" style="padding: 30px 30px 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; text-align: center; font-family: Arial, sans-serif; font-size: 14px;" width="100%">
                                    Si deseas darte de baja puedes darle click al siguiente link <a href="<?php echo site_url('usuario/eliminar-cuenta')?>" style="color: #ffffff; font-size: 16px;"> BAJA </a> <br><br>
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