<?php header('Content-Type:text/html; charset=UTF-8'); ?>
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
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    <?php echo $contenido; ?>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <?php if ($productos): ?>                                    
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">                        
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">                                                        
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td width="65%" valign="top" style="text-align: left;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <a href="<?php echo site_url('productos/' . $producto->unique_slug) ?>"><strong><?php echo truncate_simple($producto->nombre, 35) ?></strong></a>
                                        </td>  
                                        <td width="5%" style="font-size: 0; line-height: 0;">
                                            &nbsp;
                                        </td>
                                        <?php if ($producto->tipo == "normal"): ?>
                                            <?php if ($producto->precio_anterior == null): ?>
                                                <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                    <?php echo number_format($producto->precio, 2) . ' ' . $this->config->item("money_sign"); ?>                                            
                                                </td>
                                                <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            

                                                </td>
                                            <?php elseif ($producto->precio_anterior != null && diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) < 5): ?>    
                                                <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                    <?php echo number_format($producto->precio_anterior, 2) . ' ' . $this->config->item("money_sign"); ?>                                            
                                                </td>
                                                <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            

                                                </td>
                                            <?php elseif (diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) >= 5): ?>
                                                <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                    <?php echo number_format($producto->precio, 2) . ' ' . $this->config->item("money_sign"); ?>                                            
                                                </td>
                                                <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                    <del><?php echo number_format($producto->precio_anterior, 2) . ' ' . $this->config->item("money_sign"); ?></del>
                                                </td>
                                            <?php endif; ?>

                                        <?php elseif ($producto->tipo == "tarifa"): ?>

                                            <?php if ($producto->nuevo_costo <= 0): ?>
                                                <?php if ($producto->precio_anterior == null): ?>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        ...
                                                    </td>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <del><?php echo number_format($producto->precio, 2) . ' ' . $this->config->item("money_sign"); ?></del>
                                                    </td>
                                                <?php elseif ($producto->precio_anterior != null && diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) < 5): ?>    
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        ...
                                                    </td>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <del><?php echo number_format($producto->precio, 2) . ' ' . $this->config->item("money_sign"); ?></del>
                                                    </td>
                                                <?php elseif (diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) >= 5): ?>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        ...
                                                    </td>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <del><?php echo number_format($producto->precio_anterior, 2) . ' ' . $this->config->item("money_sign"); ?></del>
                                                    </td>
                                                <?php endif; ?> 
                                            <?php else: ?>
                                                <?php if ($producto->precio_anterior == null): ?>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <?php echo number_format($producto->nuevo_costo, 2) . ' ' . $this->config->item("money_sign"); ?>                                            
                                                    </td>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <del><?php echo number_format($producto->precio, 2) . ' ' . $this->config->item("money_sign"); ?></del>
                                                    </td>
                                                <?php elseif ($producto->precio_anterior != null && diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) < 5): ?>    
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <?php echo number_format($producto->nuevo_costo, 2) . ' ' . $this->config->item("money_sign"); ?>                                            
                                                    </td>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <del><?php echo number_format($producto->precio, 2) . ' ' . $this->config->item("money_sign"); ?></del>
                                                    </td>
                                                <?php elseif (diferencia_dias($producto->fecha_precio_modificar, date("Y-m-d")) >= 5): ?>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <?php echo number_format($producto->nuevo_costo, 2) . ' ' . $this->config->item("money_sign"); ?>
                                                    </td>
                                                    <td width="15%" valign="top" style="font-weight: 600;text-align: right;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                            
                                                        <del><?php echo number_format($producto->precio_anterior, 2) . ' ' . $this->config->item("money_sign"); ?></del>
                                                    </td>
                                                <?php endif; ?> 
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td bgcolor="#333" style="padding: 30px 15px 30px 15px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; text-align: center; font-family: Arial, sans-serif; font-size: 14px;" width="100%">
                                    <span style="font-weight: 600;color: #ff9933;">PRÁCTICA EL COMERCIO INTELIGENTE <br>(Compara precios , presupuestos , ofertas...)</span> <br><br>
                                    Si deseas darte de baja puedes darle click al siguiente link <a href="<?php echo site_url('usuario/eliminar-cuenta') ?>" style="color: #ffffff; font-size: 16px;"> BAJA </a> <br>
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