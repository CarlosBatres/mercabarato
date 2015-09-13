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
                        <div class="row pull-left hidden-sm hidden-xs">
                            <div class="col-md-12">
                                <label class="text-left"><strong>Buscar Vendedores</strong></label>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-md-12">                                                                  
                                <div class="input-group">                                    
                                    <input type="text" name="search_query" class="form-control" placeholder="Ingrese un nombre, o alguna referencia...">
                                    <input type="hidden" value="1" name="pagina" id="pagina"/>                                
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" id="search_button" type="button"><i class="fa fa-search"></i><span class="hidden-sm hidden-xs">Buscar</span></button>
                                    </span>
                                </div>                                                    
                            </div>  
                        </div>
                        <br>
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class="form-group">                                
                                    <label class="text-left"><strong>Provincia</strong></label>
                                    <select name="provincia" class="form-control">
                                        <option value="0">Todas las Provincias</option>
                                        <?php if (sizeof($provincias) > 0): ?>
                                            <?php
                                            foreach ($provincias as $provincia):
                                                $selected = "";
                                                if ($localizacion) {
                                                    if ($localizacion["provincia"] != null) {
                                                        if ($localizacion["provincia"]->id == $provincia->id) {
                                                            $selected = "selected='selected'";
                                                        }
                                                    }
                                                }
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo $provincia->id ?>"><?php echo $provincia->nombre ?></option>                                                                                    
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <label class="text-left"><strong>Población</strong></label>
                                    <select name="poblacion" class="form-control">
                                        <option value="0">Todas las Poblaciónes</option>                        
                                        <?php if (sizeof($poblaciones) > 0): ?>
                                            <?php
                                            foreach ($poblaciones as $poblacion):
                                                $selected = "";
                                                if ($localizacion) {
                                                    if ($localizacion["poblacion"] != null) {
                                                        if ($localizacion["poblacion"]->id == $poblacion->id) {
                                                            $selected = "selected='selected'";
                                                        }
                                                    }
                                                }
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo $poblacion->id ?>"><?php echo $poblacion->nombre ?></option>                                        
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>                         
                    </form>
                </div>

                <div id="tabla-resultados"></div>
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
    </div>
    <div id="throbber" style="display:none;">
        <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento."/>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Invitacion a Vendedor</h4>
                </div>
                <div class="modal-body">
                    <?php echo form_open('usuario/enviar_invitacion'); ?>
                    <div class="row">  
                        <div class="col-md-12">                            
                            <div class="form-group">                                                                
                                <label>Titulo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="titulo">                                
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label>Mensaje</label>
                                <textarea class="form-control" name="mensaje" rows="5" cols="20"></textarea>                    
                            </div>                                                        
                        </div>
                    </div>
                    <input type="hidden" name="vendedor_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-template-main">Enviar</button>
                    <button type="button" class="btn btn-template-main" data-dismiss="modal">Cancelar</button>
                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
