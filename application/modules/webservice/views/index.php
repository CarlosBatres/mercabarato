<h1>Mercabarato.com REST API</h1>
<div class="body">
    <p><strong>Nota: </strong>Los parámetros con * son requeridos.</p>
    <p><strong>Url base del servidor: </strong><?php echo base_url() . 'webservice/' ?></p>
    <p><strong>Requiere el uso las mismas credenciales usadas en el sitio para realizar las operaciones. (username | password)</p>
    <table>
        <tr>
            <th style="width: 20%">Servicio</th>
            <th style="width: 40%">Parámetros</th>            
            <th style="width: 40%">Resultados</th>
        </tr>
        <tr>
            <th class="group" colspan="4">Categorias <div class="up-down" data-target="categorias"><span class="down"></span></div></th>
        </tr>
        <tr class="categorias">
            <td><strong>Consultar Categorias: </strong>Devuelve todas las categorias base que estan en el sistema mostrando su nombre e id.
                <br><br>
                [<a href="<?php echo site_url('webservice/categorias') ?>">URL</a>]
                <p> <strong>/categorias</strong> </p>            
                <p><strong>Tipo:</strong> GET</p>
            </td>
            <td>                
                <p><strong>No requiere parametros.</strong></p>                                                
            </td>                       
            <td>
                <p><strong>Campos que retorna</strong></p>
                <ul>
                    <li>
                        categorias<small>Array</small>
                        <ul>
                            <li>id</li>
                            <li>nombre</li>                            
                        </ul>
                    </li>
                </ul>
                <br>
                <p><strong>Ejemplo XML</strong></p>
                <?php print_ejemplo('categorias', 'xml') ?>
            </td>
        </tr>        

        <tr>
            <th class="group" colspan="4">Productos <div class="up-down" data-target="productos"><span class="down"></span></div></th>
        </tr>
        <tr class="productos">
            <td>
                <strong>Subir Producto(s): </strong>Permite insertar uno o varios productos en el sistema.
                <br><br>
                [<a href="<?php echo site_url('webservice/upload_products') ?>">URL</a>]
                <p> <strong>/upload_products</strong> </p>            
                <p><strong>Tipo:</strong> POST</p>
            </td>
            <td>
                <ul>
                    <li><em>nombre:string *. </em> Nombre completo del producto.</li>
                    <li><em>descripcion:string. </em> Descripcion del producto, puede contener formato HTML.</li>
                    <li><em>precio:numeric *. </em> El precio de este producto, debe ser un numero separado por punto.</li>                    
                    <li><em>mostrar_precio:boolean *. </em> Indica si se va a mostrar el precio al publico o no (0|1).</li>                    
                    <li><em>mostrar_producto:boolean *. </em> Indica si se va a mostrar el producto al publico o no (0|1).</li>                    
                    <li><em>habilitado:boolean *. </em> Indica si el producto va a estar habilitado o no (0|1). Tomando en cuenta los limites de la cuenta.</li>                    
                    <li><em>link_externo:string. </em> La direccion externa del producto.</li>                    
                    <li><em>categoria_id:numeric *. </em> El ID de la categoria a la que va a pertenecer este producto.</li>                    
                </ul>                                
                <p><strong>Ejemplo XML</strong></p>
                <?php print_ejemplo('upload_productos', 'xml') ?>
            </td>            
            <td>
                <p><strong>Campos que retorna</strong></p>
                <ul>
                    <li><em>estado:* </em> El estado de la operacion.</li>
                    <li><em>completado:(Opcional) </em> Mensaje en caso de que la operacion devuelva completado</li>
                    <li><em>error:(Opcional) </em> Mensaje en caso de que la operacion devuelva un error</li>
                    <li><em>extra:(Opcional) </em> Array con informacion extra en caso de encontrarse algun error al insertar un producto</li>
                </ul>
                <br>
                <p><strong>Ejemplo XML</strong></p>
                <?php print_ejemplo('upload_productos_response', 'xml') ?>
                <p><strong>Ejemplo error XML</strong></p>
                <?php print_ejemplo('upload_productos_response_error2', 'xml') ?>
                <p><strong>Ejemplo extra XML</strong></p>
                <?php print_ejemplo('upload_productos_response_error', 'xml') ?>
            </td>
        </tr>        
    </table>
    <br>
</div>