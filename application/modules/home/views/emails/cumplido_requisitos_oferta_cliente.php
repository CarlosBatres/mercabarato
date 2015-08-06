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
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>Se han cumplido los requisitos de la oferta!</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Felicidades has cumplido todos los requisitos necesarios para optar por la oferta dada por el vendedor, a continuacion se muestra la informacion referente a la oferta.
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    <strong>CODIGO: </strong> <?php echo $codigo ?>                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b><?php echo $oferta_general->nombre ?></b>                                    
                                </td>
                            </tr>
                            <?php if ($oferta_general->descripcion != ""): ?>
                                <tr>
                                    <td style="padding: 10px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <?php echo $oferta_general->descripcion ?>
                                    </td>
                                </tr>
                            <?php endif; ?>                            
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    <strong><?php echo $producto->nombre; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Precio Original: <?php echo $producto->precio ?> &euro;
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Precio Oferta: <?php echo $oferta->nuevo_costo; ?> &euro;
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