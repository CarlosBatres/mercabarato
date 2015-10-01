<?php header('Content-Type:text/html; charset=UTF-8');?>
<style>
    .producto-img-container .frame {height: 150px;width: 100%;white-space: nowrap;text-align: center;}
    .producto-img-container .helper {display: inline-block;height: 100%;vertical-align: middle;}
    .producto-img-container .producto-img{background: #3A6F9A;vertical-align: middle;max-height: 150px;max-width: 150px;}
    a{text-decoration: none;color:#153643}
</style>
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
                                    <b>Nuevos productos en Mercabarato.com!</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Disfruta de los nuevos productos que tus vendedores estan ofreciendo en nuestro sitio.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <?php foreach ($productos as $key => $producto): ?>                                        
                                            <?php if ($key == 0): ?>
                                                <tr>
                                                    <td width="50%">
                                                        <div class="producto-img-container">
                                                            <div class="frame">
                                                                <span class="helper"></span>
                                                                <a href="<?php echo site_url("productos/" . $producto->unique_slug) ?>">                    
                                                                    <?php if ($producto->imagen_nombre === null): ?>
                                                                        <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="producto-img">
                                                                    <?php else: ?>
                                                                        <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto->imagen_nombre ?>" alt="" class="producto-img">
                                                                    <?php endif; ?>
                                                                </a>                        
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="50%" style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">                                                        
                                                        <b><a href="<?php echo site_url("productos/" . $producto->unique_slug) ?>"><?php echo truncate($producto->nombre, 50); ?></a></b>
                                                        <br><br><?php echo $producto->precio; ?> &euro;
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>                                                    
                                                    <td colspan="2" width="100%" style="padding: 25px 0 10px 50px; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                        <b><a href="<?php echo site_url("productos/" . $producto->unique_slug) ?>"><?php echo truncate($producto->nombre, 50); ?></a></b>
                                                        <br><br><?php echo $producto->precio; ?> &euro;
                                                    </td>                                                    
                                                </tr>                                                
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>                                                        
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#333" style="padding: 30px 15px 30px 15px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; text-align: center; font-family: Arial, sans-serif; font-size: 14px;" width="100%">
                                    <span style="font-weight: 600;color: #ff9933;">PRÁCTICA EL COMERCIO INTELIGENTE <br>( COMPARA PRECIOS , PRESUPUESTOS , OFERTAS)</span> <br><br>
                                    Si deseas darte de baja puedes darle click al siguiente link <a href="<?php echo site_url('usuario/eliminar-cuenta')?>" style="color: #ffffff; font-size: 16px;"> BAJA </a> <br>
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