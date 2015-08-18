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
            <div class="box box_registro">                
                <h2>Informacion de Productos</h2>
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open_multipart('panel_vendedor/producto/agregar-varios'); ?>                 
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
                    <div class="col-md-12">                        
                        <h3> Formato del Excel:</h3>
                        <br>
                        <p> La primera fila del archivo sera ignorada ( se puede usar como referencia ).</p>
                        <p> EL formato debe contener las siguientes columnas.</p>
                        <div class="table-responsive">        
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>                
                                        <th style="width: 15%">Nombre del Producto</th>
                                        <th style="width: 5%">Descripcion del Producto</th>
                                        <th style="width: 10%;text-align: center">Precio</th>                
                                        <th style="width: 5%;text-align: center">Mostrar Precio</th>                                            
                                        <th style="width: 5%;text-align: center">Mostrar Producto</th>
                                        <th style="width: 5%;text-align: center">Habilitado</th>                                    
                                        <th style="width: 5%">Link Externo</th> 
                                        <th style="width: 5%;text-align: center">ID de la Categoria</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>                    
                                        <td>TEXTO</td>
                                        <td>TEXTO OPCIONAL</td>
                                        <td style="text-align: center">NUMERO</td>
                                        <td style="text-align: center">0 , 1</td>
                                        <td style="text-align: center">0 , 1</td>
                                        <td style="text-align: center">0 , 1</td>
                                        <td>TEXTO OPCIONAL</td>
                                        <td style="text-align: center">NUMERO, VALIDO</td>
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