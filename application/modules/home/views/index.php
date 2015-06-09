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
        <div class="col-sm-9">
            <div class="box box-productos">
                <div class="box-header">
                    <h4>Ultimos Productos</h4>                
                </div>
                <?php if (sizeof($productos) < 1): ?>
                    <div>
                        <br>
                        <p style='padding-left:30px;'>No se encontraron productos...</p>    
                        <br>
                    </div>
                <?php else: ?>
                    <div class="row products">
                        <?php foreach ($productos as $key => $producto): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="product">
                                    <div class="frame">
                                        <a href="<?php echo site_url("productos/ficha/" . $producto->id) ?>">
                                            <span class="helper"></span>
                                            <?php if ($producto->imagen_nombre === null): ?>
                                                <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="producto-img">
                                            <?php else: ?>
                                                <img src="<?php echo assets_url($this->config->item('productos_img_path')) . '/' . $producto->imagen_nombre ?>" alt="" class="producto-img">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <!-- /.image -->
                                    <div class="text">
                                        <h3><a href="<?php echo site_url("productos/ficha/" . $producto->id) ?>"><?php echo $producto->nombre; ?></a></h3>
                                        <p class="price"><?php echo $producto->precio . ' ' . $this->config->item('money_sign') ?></p>                            
                                    </div>                        
                                </div>                    
                            </div>                    
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>        
        <div class="col-sm-3">
            <div class="box box-anuncios">
                <div class="box-header">
                    <h4>Ultimos Anuncios</h4>                
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
                                            <p><strong><?php echo date("d-M-Y",strtotime($anuncio->fecha_publicacion)) ?></strong>  <?php echo $anuncio->contenido;?></p>
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