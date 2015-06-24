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
                <div class="panel panel-default sidebar-menu">
                    <div class="panel-heading">
                        <h3 class="panel-title">Categorias</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked category-menu metismenu" id="producto-principal-categorias">
                            <?php echo ($subcategorias) ? $subcategorias : "No hay categorias disponibles"; ?>                        
                        </ul>                    
                    </div>
                </div>
                <div class="panel panel-default sidebar-menu">
                    <div class="panel-heading">
                        <h3 class="panel-title">Precios</h3>                            
                    </div>
                    <div class="panel-body">
                        <form>
                            <div class="form-group">                            
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
                            <button id="precios-search-aplicar" class="btn btn-default btn-sm btn-template-main"><i class="fa fa-pencil"></i> Aplicar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box-simple">                                
                    <form>
                        <div class="input-group">
                            <input type="text" name="search_query" class="form-control" placeholder="Ingrese un producto, una marca o referencia...">
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
                            if ($anuncios):
                                foreach ($anuncios as $anuncio):
                                    ?>
                                    <tr>
                                        <td>
                                            <p><strong><?php echo date("d-M-Y", strtotime($anuncio->fecha_publicacion)) ?></strong>  <?php echo $anuncio->contenido; ?></p>
                                        </td>                                
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>        
</div>