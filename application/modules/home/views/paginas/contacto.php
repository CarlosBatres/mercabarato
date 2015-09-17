<div id="heading-breadcrumbs" class="no-mb">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Contacto</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php site_url(''); ?>">Inicio</a>
                    </li>
                    <li>Contacto</li>
                </ul>

            </div>
        </div>
    </div>
</div>
<br>
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

                    <?php echo form_open('site/contacto/submit', 'id="formulario_contacto" rel="preventDoubleSubmission"'); ?>                                     
                    <div class="row">                            
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="email"><strong>Email</strong></label>
                                <input type="text" class="form-control" name="el_email">
                            </div>
                        </div>                            
                    </div>                            
                    <div class="row">                                
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="message"><strong>Mensaje</strong></label>
                                <textarea name="mensaje" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> 
                            <a class="close" data-dismiss="alert">×</a>
                            <?= $this->session->flashdata('error') ?> 
                        </div>
                    <?php } ?>
                    <?php if ($spam_protection): ?>
                        <div class="row">              
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><strong><?php echo $spam_question ?></strong></label>
                                    <input type="text" class="form-control" name="spam_anwser">
                                </div>
                            </div>                     
                        </div>                     
                    <?php endif; ?>
                    <br>
                    <p class="magia">
                        <input type="text" name="email">
                    </p>
                    <div class="row">                                                                     
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-template-primary"><i class="fa fa-envelope-o"></i> Enviar Mensaje</button>
                        </div>
                    </div>                                        
                    <?php echo form_close(); ?>
                </div>

                <div class="col-md-4">                    
                    <h3 class="text-uppercase">Telefono de Contacto</h3>

                    <p class="text-muted">Puedes contactarnos a travez del numero a continuación.</p>
                    <p><strong>No disponible</strong>
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

