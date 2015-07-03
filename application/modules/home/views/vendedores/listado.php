<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Vendedores o Empresas</h1>
            </div>

        </div>
    </div>
</div>

<div id="content" class="clearfix">
    <div class="container">
        <div class="row">              
            <div class="col-md-9">
                <div class="box-simple">                                
                    <form id="form_buscar">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <select name="pais" class="form-control">
                                        <option value="0">País</option>
                                        <?php foreach ($paises as $pais): 
                                            $class="";
                                            if($pais->nombre=="España"){
                                                $class="selected";
                                            }
                                            ?>                                        
                                            <option value="<?php echo $pais->id ?>" <?php echo $class?>><?php echo $pais->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>   
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <select name="provincia" class="form-control">
                                        <option value="0">Todas las Provincias</option>                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">                        
                                    <select name="poblacion" class="form-control">
                                        <option value="0">Todas las Poblaciónes</option>                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" name="search_query" class="form-control" placeholder="Ingrese un nombre, alguna referencia o palabras clave...">
                                    <input type="hidden" value="1" name="pagina" id="pagina"/>                                
                                    <span class="input-group-btn">
                                        <button class="btn btn-template-main" id="search_button" type="button"><i class="fa fa-search"></i>Buscar</button>
                                    </span>
                                </div>                    
                            </div>  
                        </div> 
                    </form>
                </div>

                <div id="tabla-resultados"></div>
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
                                            <p class="text-right"><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong></p>
                                            <p><strong><?php echo $anuncio->titulo; ?></strong></p>
                                            <p><?php echo truncate($anuncio->contenido, 300); ?></p>
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
    </div>
    <div id="throbber" style="display:none;">
        <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" />
    </div>
</div>
