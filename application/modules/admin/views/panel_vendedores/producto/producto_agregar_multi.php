<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1 class="page-header">
                Agregar grupo de productos (Excel)
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
            <?php echo form_open_multipart('panel_vendedor/producto/agregar-varios','rel="preventDoubleSubmission"'); ?>                 
            <div class="box box_registro">                
                <h2>Informacion de Productos</h2>
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>                
                <div class="row">
                    <div class="col-md-12">
                        <p> A continuacion debe seleccionar una archivo excel que contenga los datos de los productos que desea ingresar en el sistema.</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>Seleccione un archivo del formato (.xls).</label>                    
                        <input type="file" name="userfile" size="20" />
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12">                        
                        <h3> Formato del Excel:</h3>
                        <br>
                        <p> La primera fila del archivo sera ignorada ( se puede usar como referencia ).</p>
                        <p> EL formato debe contener los siguientes valores.</p>
                        <br>
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
                                        <td style="font-weight: 600">Nombre del Producto</td>
                                        <td>TEXTO ( String )</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Descripcion del Producto</td>
                                        <td>TEXTO ( String )</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Precio</td>
                                        <td>NUMERO ( Float )</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Mostrar Precio</td>
                                        <td>0 , 1</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Mostrar Producto</td>
                                        <td>0 , 1</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Habilitado</td>
                                        <td>0 , 1</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Link Externo</td>
                                        <td>TEXTO ( String )</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">ID de la Categoria</td>
                                        <td>NUMERO ( Integer ) - Debe existir</td>
                                        <td> Necesario </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Imagen Principal</td>
                                        <td>Ruta absoluta del archivo</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Imagen Extra 1</td>
                                        <td>Ruta absoluta del archivo</td>
                                        <td> Opcional </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">Imagen Extra 2</td>
                                        <td>Ruta absoluta del archivo</td>
                                        <td> Opcional </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <hr>                                
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary"> Continuar</button>
            </div>                        
            <input type="hidden" name="bulk_upload" value="true" />
            <?php echo form_close(); ?>
        </div>
    </div>
</div>