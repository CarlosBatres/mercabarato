<div class="container" style="margin-top:40px">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong> Inicie sesión para continuar</strong>
                </div>
                <div class="panel-body">
                    <?php echo form_open('admin/do_login', 'id="loginAdmin"'); ?>
                        <fieldset>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-10  col-md-offset-1 ">
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
                                    <br>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Iniciar">
                                    </div>
                                </div>
                            </div>                            
                        </fieldset>
                    <?php echo form_close(); ?>
                </div>
                <div class="panel-footer ">                    
                </div>
            </div>
        </div>
    </div>
</div>