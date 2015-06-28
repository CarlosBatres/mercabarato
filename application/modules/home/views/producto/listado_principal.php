<section>
    <!-- *** HOMEPAGE CAROUSEL ***
_________________________________________________________ -->
    <div class="home-carousel">
        <div class="dark-mask"></div>
        <div class="container">
            <div class="homepage owl-carousel">

                <div class="item">
                    <div class="row">
                        <div class="col-sm-5 right">                                                        
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sem orci, sodales condimentum nulla non, lobortis consequat quam. Proin porta dui leo. Nulla sed justo vitae diam finibus aliquet nec a justo.</p>
                        </div>
                        <div class="col-sm-7">
                            <img class="img-responsive" src="<?php echo assets_url('imgs/slider/1.jpg') ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="row">

                        <div class="col-sm-7 text-center">
                            <img class="img-responsive" src="<?php echo assets_url('imgs/slider/2.jpg') ?>" alt="">
                        </div>

                        <div class="col-sm-5">                            
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sem orci, sodales condimentum nulla non, lobortis consequat quam. Proin porta dui leo. Nulla sed justo vitae diam finibus aliquet nec a justo.</p>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.project owl-slider -->
        </div>
    </div>
    <!-- *** HOMEPAGE CAROUSEL END *** -->
</section>

<div class="container">
    <div class="row">
        <div class="col-md-9">                        
            <div class="col-md-4">
                <div class="panel panel-default sidebar-menu principal-sidebar">
                    <div class="panel-heading">
                        <h3 class="panel-title">Precios</h3>                            
                    </div>
                    <div class="panel-body">                        
                        <div class="precios-productos">
                            <?php
                            $j = 0;
                            foreach ($precios as $precio) {
                                $checked = ($precio['checked']) ? "checked='checked'" : "";
                                echo '<div class="checkbox">'
                                . '<label>'
                                . '<input type="checkbox" name="precios" value="' . $precio['value'] . '" ' . $checked . '>&nbsp;' . $precio['text'] . ''
                                . '</label>'
                                . '</div>';
                                $j++;
                            }
                            ?>                             
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
                    <form>
                        <div class="input-group">
                            <input type="text" name="search_query" class="form-control" placeholder="Ingrese un producto, o alguna referencia ...">
                            <input type="hidden" value="1" name="pagina" id="pagina"/>                                
                            <span class="input-group-btn">
                                <button class="btn btn-template-main" id="search_button" type="button"><i class="fa fa-search"></i>Buscar</button>
                            </span>
                        </div>                    
                    </form>
                </div>

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
                            if (sizeof($anuncios)>0):
                                foreach ($anuncios as $anuncio):
                                    ?>
                                    <tr>
                                        <td>
                                            <p class="text-right"><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong></p>
                                            <p><strong><?php echo $anuncio->titulo; ?></strong></p>
                                            <p><?php echo truncate($anuncio->contenido,300); ?></p>
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
        <img src="<?php echo assets_url('imgs/ajax-loader.gif'); ?>" />
    </div>
</div>
