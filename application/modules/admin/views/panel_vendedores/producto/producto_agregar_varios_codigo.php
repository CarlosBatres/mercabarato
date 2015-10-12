<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar grupo de productos (PHP)
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">                                                
                <br>
                <div class="row">
                    <div class="col-md-12">                        
                        <p class="lead"> A continuacion se muestra un ejemplo de como seria la subida de varios productos mediante PHP y cURL.<br>                        
                        </p>                        

                        <ul>
                            <li>Para autenticarse se usan las mismas credenciales del sitio.</li>
                            <li>Request y Response son en XML.</li>                            
                            <li>La direccion del servicio web es <a href="<?php echo site_url('webservice'); ?>"><?php echo site_url('webservice'); ?></a> </li>                            
                            <li>Se pueden insertar uno o varios en cada Request.</li>
                            <li>El servico web tiene un limite de 15 Request por hora.</li>                            
                            <li>Las imagenes se envian en base64.</li>
                        </ul>
                        
                        <p class="lead"> Por cada producto debe contener los siguientes datos:</p>
                        <div class="table-responsive">        
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo de Dato</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-weight: 600">nombre</td>
                                        <td>TEXTO ( String )</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">descripcion</td>
                                        <td>TEXTO ( String )</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">precio</td>
                                        <td>NUMERO ( Float )</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">mostrar_precio</td>
                                        <td> NUMERO ( Integer ) -  '0' si es para <strong>NO</strong> y '1' para <strong>SI</strong></td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">mostrar_producto</td>
                                        <td> NUMERO ( Integer ) -  '0' si es para <strong>NO</strong> y '1' para <strong>SI</strong></td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">habilitado</td>
                                        <td> NUMERO ( Integer ) -  '0' si es para <strong>NO</strong> y '1' para <strong>SI</strong></td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">link_externo</td>
                                        <td>TEXTO ( String )</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">categoria_id</td>
                                        <td>NUMERO ( Integer ) - Debe existir</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">imagen_principal</td>
                                        <td>Imagen a Base64</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">imagen_principal_extension</td>
                                        <td>JPG | GIF | JPEG | PNG</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">imagen_extra1</td>
                                        <td>Imagen a Base64</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">imagen_extra1_extension</td>
                                        <td>JPG | GIF | JPEG | PNG</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">imagen_extra2</td>
                                        <td>Imagen a Base64</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">imagen_extra2_extension</td>
                                        <td>JPG | GIF | JPEG | PNG</td>
                                        <td> Opcional </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>

                        <br>
                        <p><strong>Ejemplo PHP</strong></p>
                        <?php print_ejemplo('example_php', 'php') ?>
                    </div>
                </div>                
            </div>            
        </div>
    </div>
</div>