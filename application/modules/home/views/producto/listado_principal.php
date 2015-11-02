<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Productos</h1>
            </div>            
        </div>
    </div>
</div>
<div id="content" class="clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-9">                        
                
                <div class="col-md-4 hidden-xs hidden-sm">
                    <div class="panel panel-default sidebar-menu principal-sidebar">
                        <div class="panel-heading">
                            <h3 class="panel-title">Precios</h3>                            
                        </div>
                        <div class="panel-body">                        
                            <div class="precios-productos">                                
                                <div class="input-group pull-left">                                                
                                    <input type="text" class="form-control" name="precio_desde" placeholder="Desde" value="<?php echo $precio_desde; ?>">                                    
                                    <span class="input-group-addon"><i class="fa fa-euro fa-fw"></i></span>
                                </div>                           

                                <div class="input-group pull-right">                                                                                    
                                    <input type="text" class="form-control" name="precio_hasta" placeholder="Hasta" value="<?php echo $precio_hasta; ?>">                                    
                                    <span class="input-group-addon"><i class="fa fa-euro fa-fw"></i></span>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default sidebar-menu principal-sidebar">
                        <div class="panel-heading">
                            <h3 class="panel-title">Categorías</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked metismenu" id="producto-principal-categorias">                        
                                <?php echo ($subcategorias) ? $subcategorias : "No hay categorias disponibles"; ?>                        
                            </ul>
                        </div>
                    </div>               
                </div>
                
                <div class="col-sm-12 col-md-8">
                    <div class="box-simple">
                        <?php echo form_open('', 'id="form_buscar"'); ?>                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">                                
                                        <select name="provincia" class="form-control">
                                            <option value="0">Todas las provincias</option>
                                            <?php foreach ($provincias as $provincia): ?>
                                                <?php
                                                $class = "";
                                                if ($provincia_id == $provincia->id) {
                                                    $class = "selected";
                                                }
                                                ?>
                                                <option <?php echo $class; ?> value="<?php echo $provincia->id ?>"><?php echo $provincia->nombre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">                        
                                        <select name="poblacion" class="form-control">
                                            <option value="0">Todas las poblaciones</option>                        
                                            <?php foreach ($poblaciones as $poblacion): ?>
                                                <?php
                                                $class = "";
                                                if ($poblacion_id == $poblacion->id) {
                                                    $class = "selected";
                                                }
                                                ?>
                                                <option <?php echo $class; ?> value="<?php echo $poblacion->id ?>"><?php echo $poblacion->nombre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <?php if ($search_query == ""): ?>
                                    <input type="text" name="search_query" class="form-control" placeholder="Ingrese un producto, o alguna referencia ...">
                                <?php else: ?>
                                    <input type="text" name="search_query" class="form-control" placeholder="Ingrese un producto, o alguna referencia ..." value='<?php echo $search_query; ?>'>
                                <?php endif; ?>

                                <input type="hidden" value="1" name="pagina" id="pagina"/>                                
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" id="search_button" type="button"><i class="fa fa-search"></i><span class="hidden-xs">Buscar</span></button>
                                </span>
                            </div>                            
                            <?php if ($this->authentication->is_loggedin()): ?>
                                <br>
                                <div class="col-xs-12">
                                    <div class="col-xs-6">
                                        <div class="checkbox pull-left">
                                            <label>
                                                <input type="checkbox" name="mostrar_mis_vendedores" value="1"> Solo mostrar mis vendedores 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="checkbox pull-right">
                                            <label>
                                                <input type="checkbox" name="mostrar_mis_tarifas" value="1"> Solo mostrar mis tarifas 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php echo form_close(); ?>
                    </div>
                    <br>
                    <div id="tabla-resultados"></div>
                </div>
            </div> 

            <div class="col-sm-12 col-md-3">
                <div class="row anuncios-header">
                    <h3 class="text-center">Anuncios</h3>
                </div>
                <?php
                if (sizeof($anuncios) > 0):
                    foreach ($anuncios as $anuncio):
                        ?>

                        <div class="row">
                            <div class="col-xs-12">                                
                                <div class="anuncio-contenido">
                                    <p class="text-right"><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong></p>
                                    <p><a href="<?php echo site_url("anuncios/" . $anuncio->id) ?>"><strong><?php echo $anuncio->titulo; ?></strong></a></p>                                                
                                    <p><?php echo strip_tags(truncate($anuncio->contenido, 300)); ?></p>
                                </div>
                                <hr>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <p> No hay novedades...</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

           
        </div> 
        
        <div id="throbber" style="display:none;">
            <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento."/>
        </div>
    </div>
</div>
