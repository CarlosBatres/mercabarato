<div id="all">
    <header>    
        <div id="top">
            <div class="container">
                            
            </div>
        </div>   

        <div class="navbar navbar-default yamm navbar-custom" role="navigation" id="navbar">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand home" href="<?php echo site_url(); ?>">                        
                        <img class="hidden-xs hidden-sm" src="<?php echo assets_url('imgs/logo.png') ?>" alt="mercabarato logo" >
                        <img class="hidden-md hidden-lg logo_header_small" src="<?php echo assets_url('imgs/logo_small.png') ?>" alt="mercabarato logo" >                    
                    </a>
                    <div class="navbar-buttons">
                        <p class="navbar-text visible-xs-inline-block" id="navbar-menu-principal-text">Menu Principal &nbsp;&nbsp;</p>
                        <button type="button" class="navbar-toggle btn-template-main" data-toggle="collapse" data-target="#navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="fa fa-align-justify"></i>
                        </button>
                    </div>
                </div>            

                <div class="navbar-collapse collapse" id="navigation">
                    <ul class="nav navbar-nav navbar-right">                                                                                           
                    </ul>
                </div>            
            </div>
        </div>    
    </header>


    <?php echo $main_content; ?>

    <?php echo $footer; ?>
</div>