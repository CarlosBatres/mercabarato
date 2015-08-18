<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>&nbsp;</h1>
            </div>            
        </div>
    </div>
</div>
<div id="content" class="clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-9">                        
                <div class="col-md-4 hidden-xs hidden-sm">
                    <div class="panel panel-default sidebar-menu principal-sidebar">
                        <div class="panel-heading">
                            <h3 class="panel-title">Precios</h3>                            
                        </div>
                        <div class="panel-body">                        
                            <div class="precios-productos">                                
                                <div class="input-group pull-left">                                                
                                    <input type="text" class="form-control" name="precio_desde" placeholder="Desde">                                    
                                    <span class="input-group-addon"><i class="fa fa-euro fa-fw"></i></span>
                                </div>                           

                                <div class="input-group pull-right">                                                                                    
                                    <input type="text" class="form-control" name="precio_hasta" placeholder="Hasta">                                    
                                    <span class="input-group-addon"><i class="fa fa-euro fa-fw"></i></span>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default sidebar-menu principal-sidebar">
                        <div class="panel-heading">
                            <h3 class="panel-title">Categorias</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked metismenu" id="producto-principal-categorias">                        
                                <?php echo ($subcategorias) ? $subcategorias : "No hay categorias disponibles"; ?>                        
                            </ul>
                        </div>
                    </div>               
                </div>
                <div class="col-md-8">
                    <div class="box-simple">                                
                        <form id="form_buscar">
                            <div class="row hidden-xs hidden-sm">
                                <div class="col-md-4 row-less-padding-r">
                                    <div class="form-group">                                
                                        <select name="pais" class="form-control">
                                            <option value="0">País</option>
                                            <?php
                                            foreach ($paises as $pais):
                                                $class = "";
                                                if ($pais->nombre == "España") {
                                                    $class = "selected";
                                                }
                                                ?>                                        
                                                <option value="<?php echo $pais->id ?>" <?php echo $class ?>><?php echo $pais->nombre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>   
                                </div> 
                                <div class="col-md-4 row-less-padding-l row-less-padding-r">
                                    <div class="form-group">                                
                                        <select name="provincia" class="form-control">
                                            <option value="0">Todas las Provincias</option>                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 row-less-padding-l">
                                    <div class="form-group">                        
                                        <select name="poblacion" class="form-control">
                                            <option value="0">Todas las Poblaciónes</option>                        
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
                                    <button class="btn btn-template-main" id="search_button" type="button"><i class="fa fa-search"></i><span class="hidden-xs">Buscar</span></button>
                                </span>
                            </div>                            
                            <?php if ($this->authentication->is_loggedin()): ?>
                                <div class="col-md-12 text-right">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="mostrar_mis_tarifas" value="1"> Solo mostrar mis tarifas 
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                    <br>

                    <div id="tabla-resultados"></div>
                </div>

            </div> 

            <div class="col-md-3">
                <div class="box box-anuncios">
                    <div class="box-header">
                        <h4 class="text-center">Anuncios</h4>                
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <?php
                                if (sizeof($anuncios) > 0):
                                    foreach ($anuncios as $anuncio):
                                        ?>
                                        <tr>
                                            <td>                                                
                                                <div class="anuncio-contenido">
                                                    <p class="text-right"><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong></p>
                                                    <p><a href="<?php echo site_url("anuncios/" . $anuncio->id) ?>"><strong><?php echo $anuncio->titulo; ?></strong></a></p>                                                
                                                    <p><?php echo strip_tags(truncate($anuncio->contenido, 300)); ?></p>
                                                </div>
                                            </td>                                
                                        </tr>
                                        <?php
                                    endforeach;
                                else:
                                    echo "<tr><td> <p> No hay novedades..</p></td></tr>";
                                endif;
                                ?>                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
        <div id="throbber" style="display:none;">
            <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento."/>
        </div>
    </div>
</div>
