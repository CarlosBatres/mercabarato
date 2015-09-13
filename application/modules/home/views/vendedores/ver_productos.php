<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1> <?php echo $vendedor->nombre ?></h1>
            </div>            
        </div>
    </div>
</div>

<div id="content">
    <div class="container">          
        <input type="hidden" value="<?php echo ($grupo_txt)?$grupo_txt:'' ?>" name="grupo_txt"/>                                                          
        <input type="hidden" value="<?php echo ($familia_txt)?$familia_txt:'' ?>" name="familia_txt"/>                                                          
        <input type="hidden" value="<?php echo ($subfamilia_txt)?$subfamilia_txt:'' ?>" name="subfamilia_txt"/>                                                          
        <input type="hidden" name="vendedor_id" value="<?php echo $vendedor->id; ?>">
        <input type="hidden" value="1" name="pagina" id="pagina"/>                                
        <div class="col-xs-9">
            <div id="tabla-resultados"></div>
        </div>
        <?php if ($anuncios): ?>
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
        <?php endif; ?>
    </div>
</div>
<div id="throbber" style="display:none;">
    <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento."/>
</div>

