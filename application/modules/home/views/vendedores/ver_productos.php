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
        <input type="hidden" name="vendedor_id" value="<?php echo $vendedor->id; ?>">
        <input type="hidden" value="1" name="pagina" id="pagina"/>                                
        <div class="col-xs-9">
            <div id="tabla-resultados"></div>
        </div>
        <?php if ($anuncios): ?>
            <div class="col-xs-3">

                <div class="box box-anuncios">            
                    <div class="box-header">
                        <h4 class="text-center">Anuncios</h4>                
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <?php foreach ($anuncios as $anuncio): ?>
                                    <tr>
                                        <td>
                                            <p class="text-right"><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong></p>
                                            <p><a href="<?php echo site_url("anuncios/" . $anuncio->id) ?>"><strong><?php echo $anuncio->titulo; ?></strong></a></p>
                                            <p><?php echo strip_tags(truncate($anuncio->contenido, 300)); ?></p>
                                        </td>                                
                                    </tr>
                                <?php endforeach; ?>                            
                            </tbody>
                        </table>
                    </div>
                </div>            
            </div>
        <?php endif; ?>
    </div>
</div>
<div id="throbber" style="display:none;">
    <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento."/>
</div>

