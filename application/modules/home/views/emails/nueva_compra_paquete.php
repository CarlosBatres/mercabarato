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
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>Informacion de compra de nuevo paquete</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    A continuacion se muestra los datos.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td width="40%" valign="top" style="text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <strong>Nombre del vendedor</strong>
                                            </td>  
                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                &nbsp;
                                            </td>
                                            <td width="40%" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <?php echo $vendedor->nombre ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40%" valign="top" style="text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <strong>NIF - CIF</strong>
                                            </td>  
                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                &nbsp;
                                            </td>
                                            <td width="40%" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <?php echo $vendedor->nif_cif ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40%" valign="top" style="text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <strong>Direccion</strong>
                                            </td>  
                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                &nbsp;
                                            </td>
                                            <td width="40%" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <?php echo $vendedor->direccion ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40%" valign="top" style="text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <strong>Paquete</strong>
                                            </td>  
                                            <td width="10%" style="font-size: 0; line-height: 0;" width="20">
                                                &nbsp;
                                            </td>
                                            <td width="40%" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <?php echo $paquete["nombre_paquete"] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40%" valign="top" style="text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <strong>Comprado el</strong>
                                            </td>  
                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                &nbsp;
                                            </td>
                                            <td width="40%" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <?php echo date("d-m-Y", strtotime($paquete["fecha_comprado"])) ?>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td width="40%" valign="top" style="text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <strong>Monto a cancelar</strong>
                                            </td>  
                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                &nbsp;
                                            </td>
                                            <td width="40%" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                <?php echo $paquete["monto_a_cancelar"] ?> &euro;
                                            </td>
                                        </tr>                                                                                
                                    </table>
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
                                    Práctica el comercio inteligente ( compara precios, presupuestos, ofertas...) <br><br>
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