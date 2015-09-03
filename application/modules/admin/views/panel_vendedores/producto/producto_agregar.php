<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Producto
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del producto</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('panel_vendedor/producto/agregar', 'id="admin_producto_form" enctype="multipart/form-data"'); ?>                 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                            
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre">
                        </div>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                                                        
                            <label>Descripcion</label>                    
                            <textarea class="form-control" id="content" name="descripcion" rows="10"></textarea>                                        
                            <?php echo display_ckeditor($ckeditor); ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione varias imagenes para el producto ( Limite 3)</label>                    
                            <input id="fileupload" type="file" name="files[]" multiple data-url="<?php echo site_url('panel_vendedor/producto/upload_image') ?>">
                            <input type="hidden" name="file_name" id="file_name" value="">                                                            
                        </div> 
                    </div> 
                </div>
                <br>                                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">                                
                                <span class="titulo">Precio según el número de articulos comprados</span>                                
                            </div>
                            <div class="panel-body"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">                            
                                            <label>Precio Venta Publico ( por unidad )</label>
                                            <input type="text" class="form-control" name="precio">
                                        </div>
                                    </div>                                    

                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">                            
                                            <label>Precio Venta ( costo o texto descriptivo )</label>
                                            <input type="text" class="form-control" name="precio_extra1" value="" placeholder="Ejm: 500 EUR">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <br><p class="lead"><strong>X</strong></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Cantidad de articulos ( solo numero )</label>
                                        <input type="text" class="form-control" name="precio_extra1_cantidad" value="" placeholder="Ejm: 100">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">                                                                        
                                            <input type="text" class="form-control" name="precio_extra2">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <p class="lead"><strong>X</strong></p>
                                    </div>
                                    <div class="col-md-6">                                        
                                        <input type="text" class="form-control" name="precio_extra2_cantidad" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">                                                                        
                                            <input type="text" class="form-control" name="precio_extra3">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <p class="lead"><strong>X</strong></p>
                                    </div>
                                    <div class="col-md-6">                                        
                                        <input type="text" class="form-control" name="precio_extra3_cantidad" value="">
                                    </div>
                                </div>

                            </div>                
                        </div> 
                    </div>
                </div>
                <br>                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">                                
                                <span class="titulo">Opciones adicionales</span>                                
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group">                            
                                        <label>Enlace externo al producto</label>
                                        <input type="text" class="form-control" name="link_externo">
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br>
                                        <label>Desea mostrar el producto al publico general?</label><br>
                                        <label>Si<input type="radio" name="mostrar_producto" id="mostrar_si" value="1" checked class="radioInput"></label>
                                        <label>No<input type="radio" name="mostrar_producto" id="mostrar_no" value="0" class="radioInput"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br>
                                        <label>Desea mostrar el precio al publico general?</label><br>
                                        <label>Si<input type="radio" name="mostrar_precio" id="mostrar_precio_si" value="1" checked class="radioInput"></label>
                                        <label>No<input type="radio" name="mostrar_precio" id="mostrar_precio_no" value="0" class="radioInput"></label>
                                    </div>                                                                       
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br>
                                        <label>Transporte es gratuito?</label><br>
                                        <?php foreach (transporte_radio() as $id => $radio): ?>
                                            <label><input type="radio" name="transporte" value="<?php echo $id ?>" class="radioInput"><?php echo $radio ?></label><br>    
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">                        
                                    <div class="form-group">
                                        <br>
                                        <label>Impuesto incluido?</label><br>
                                        <?php foreach (impuesto_radio() as $id => $radio): ?>
                                            <label><input type="radio" name="impuesto" value="<?php echo $id ?>" class="radioInput"><?php echo $radio ?></label><br>    
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                  
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>Seleccione una Categoria:</label>
                        <div class="alert alert-danger" id="seleccionar-categoria_alert" style="display:none;"> 
                            <a class="close" data-dismiss="alert">×</a>
                            Debe seleccionar una categoria.
                        </div>
                        <div id="categorias_jtree">                
                            <?php echo $categorias_tree_html; ?>
                        </div>
                    </div>
                </div>
            </div>


            <hr>                                
            <div class="text-center">
                <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Agregar</button>
            </div>
            <input type="hidden" name="categoria_id" value="">
            <input type="hidden" name="accion" value="producto-crear">
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<br>
<div id="throbber" style="display:none;">
    <img src="<?php echo assets_url('imgs/small-ajax-loader.gif'); ?>" />
</div>
</div>