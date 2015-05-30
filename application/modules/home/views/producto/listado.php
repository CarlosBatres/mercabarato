<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Productos</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Productos</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

        <!-- *** LEFT COLUMN ***
            _________________________________________________________ -->

        <div class="col-sm-9">
            <p class="text-muted lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce quis maximus sapien, sed maximus diam. Aliquam efficitur, risus tincidunt gravida blandit, tellus nisi aliquam nisl, nec aliquam augue libero eget diam. Donec rutrum nibh lacus. Donec vitae commodo neque. Aliquam erat volutpat. Morbi a felis dolor. Sed viverra tristique erat, a imperdiet sem fermentum vitae. Vivamus convallis, quam ut pulvinar placerat, felis nisi lobortis libero, ut euismod mi urna sed lectus.</p>

            <div class="row products">

                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="product">
                            <div class="image">
                                <a href="shop-detail.html">
                                    <?php if ($producto["imagen_nombre"] === null): ?>
                                            <img src="<?php echo assets_url("imgs/imagen-no-disponible.png") ?>" alt="" class="img-responsive image1">
                                    <?php else: ?>
                                            <img src="<?php echo assets_url("uploads/imgs/".$producto["imagen_nombre"]) ?>" alt="" class="img-responsive image1">
                                    <?php endif; ?>
                                    
                                </a>
                            </div>
                            <!-- /.image -->
                            <div class="text">
                                <h3><a href="shop-detail.html"><?php echo $producto["nombre"]; ?></a></h3>
                                <p class="price"><?php echo $producto["precio_venta_publico"] . ' ' . $this->config->item('money_sign') ?></p>                            
                            </div>                        
                        </div>                    
                    </div>           

                <?php endforeach; ?>

            </div>
            <!-- /.products -->            

            <div class="pages">                
                <ul class="pagination">
                    <li><a href="#">&laquo;</a>
                    </li>
                    <li class="active"><a href="#">1</a>
                    </li>
                    <li><a href="#">2</a>
                    </li>
                    <li><a href="#">3</a>
                    </li>
                    <li><a href="#">4</a>
                    </li>
                    <li><a href="#">5</a>
                    </li>
                    <li><a href="#">&raquo;</a>
                    </li>
                </ul>
            </div>


        </div>
        <!-- /.col-md-9 -->

        <!-- *** LEFT COLUMN END *** -->

        <!-- *** RIGHT COLUMN ***
            _________________________________________________________ -->

        <div class="col-sm-3">

            <!-- *** MENUS AND FILTERS ***
_________________________________________________________ -->
            <div class="panel panel-default sidebar-menu">

                <div class="panel-heading">
                    <h3 class="panel-title">Categories</h3>
                </div>

                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked category-menu">
                        <li>
                            <a href="shop-category.html">Men <span class="badge pull-right">42</span></a>
                            <ul>
                                <li><a href="shop-category.html">T-shirts</a>
                                </li>
                                <li><a href="shop-category.html">Shirts</a>
                                </li>
                                <li><a href="shop-category.html">Pants</a>
                                </li>
                                <li><a href="shop-category.html">Accessories</a>
                                </li>
                            </ul>
                        </li>
                        <li class="active">
                            <a href="shop-category.html">Ladies  <span class="badge pull-right">123</span></a>
                            <ul>
                                <li><a href="shop-category.html">T-shirts</a>
                                </li>
                                <li><a href="shop-category.html">Skirts</a>
                                </li>
                                <li><a href="shop-category.html">Pants</a>
                                </li>
                                <li><a href="shop-category.html">Accessories</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="shop-category.html">Kids  <span class="badge pull-right">11</span></a>
                            <ul>
                                <li><a href="shop-category.html">T-shirts</a>
                                </li>
                                <li><a href="shop-category.html">Skirts</a>
                                </li>
                                <li><a href="shop-category.html">Pants</a>
                                </li>
                                <li><a href="shop-category.html">Accessories</a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </div>
            </div>

            <div class="panel panel-default sidebar-menu">

                <div class="panel-heading">
                    <h3 class="panel-title">Brands</h3>
                    <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> <span class="hidden-sm">Clear</span></a>
                </div>

                <div class="panel-body">

                    <form>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">Armani (10)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">Versace (12)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">Carlo Bruni (15)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">Jack Honey (14)
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-default btn-sm btn-template-main"><i class="fa fa-pencil"></i> Apply</button>

                    </form>

                </div>
            </div>

            <div class="panel panel-default sidebar-menu">

                <div class="panel-heading">
                    <h3 class="panel-title clearfix">Colours</h3>
                    <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> <span class="hidden-sm">Clear</span></a>
                </div>

                <div class="panel-body">

                    <form>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> <span class="colour white"></span> White (14)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> <span class="colour blue"></span> Blue (10)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> <span class="colour green"></span> Green (20)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> <span class="colour yellow"></span> Yellow (13)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> <span class="colour red"></span> Red (10)
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-default btn-sm btn-template-main"><i class="fa fa-pencil"></i> Apply</button>

                    </form>

                </div>
            </div>

            <!-- *** MENUS AND FILTERS END *** -->            

        </div>
        <!-- /.col-md-3 -->

        <!-- *** RIGHT COLUMN END *** -->

    </div>

</div>
<!-- /.container -->