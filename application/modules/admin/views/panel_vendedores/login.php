<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <strong> Inicie sesión para continuar</strong>
                </div>
                <div class="panel-body">
                    <?php echo form_open('panel_vendedor/login', 'id="loginAdmin"'); ?>
                    <fieldset>                       
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span> 
                                <input class="form-control" placeholder="E-mail" name="email" type="text" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </span>
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Iniciar">
                        </div>
                    </fieldset>
                    <?php echo form_close(); ?>
                </div>                
            </div>
        </div>
    </div>
</div>