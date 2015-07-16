<div id="heading-breadcrumbs" class="no-mb">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Contacto</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php site_url('');?>">Inicio</a>
                    </li>
                    <li>Contacto</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="container" id="contact">

        <section>
            <div class="row">
                <div class="col-md-8">

                    <div class="heading">
                        <h2>Estamos aqui para ayudarte</h2>
                    </div>

                    <p class="lead">Escríbenos a través de nuestro formulario de contacto aquí debajo</p>
                    <p></p>
                    

                    <form action="<?php echo site_url('site/contacto/submit')?>" method="POST" id="formulario_contacto">
                        <div class="row">                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                            </div>                            
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="message">Mensaje</label>
                                    <textarea id="mensjae" name="mensaje" class="form-control" rows="10"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-envelope-o"></i> Enviar Mensaje</button>

                            </div>
                        </div>
                        <!-- /.row -->
                    </form>
                </div>

                <div class="col-md-4">                    
                    <h3 class="text-uppercase">Telefono de Contacto</h3>

                    <p class="text-muted">Puedes contactarnos a travez del numero a continuación.</p>
                    <p><strong>+33 555 444 333</strong>
                    </p>


                    <hr>
                    <h3 class="text-uppercase">Soporte Electronico</h3>

                    <p class="text-muted">Puedes escribirnos un correo electronico a la siguiente dirección.</p>
                    <ul>
                        <li><strong><a href="mailto:">info@mercabarato.com</a></strong>
                        </li>                        
                    </ul>


                </div>

            </div>


        </section>

    </div>
    <!-- /#contact.container -->
</div>

