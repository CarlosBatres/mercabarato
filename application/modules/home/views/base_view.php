<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <meta name="title" content="<?php echo $title; ?>">
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Extra metadata -->
        <?php echo $metadata; ?>
        <!-- / -->

        <link rel="shortcut icon" href="<?php echo assets_url('imgs/favicon.ico'); ?>" type="image/x-icon" />

        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?php echo assets_url('font-awesome/css/font-awesome.min.css'); ?>">        
        <link rel="stylesheet" href="<?php echo assets_url('css/bootstrap.min.css'); ?>">        

        <!--<link rel="stylesheet" href="<?php echo assets_url('css/owl.carousel.css'); ?>" >-->
        <!--<link rel="stylesheet" href="<?php echo assets_url('css/owl.theme.css'); ?>" >-->

        <link rel="stylesheet" href="<?php echo assets_url('css/jquery-ui.theme.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo assets_url('css/jquery-ui.structure.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo assets_url('css/jquery-ui.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo assets_url('css/metisMenu.min.css'); ?>">

        <link rel="stylesheet" href="<?php echo assets_url('css/modules/style.default.css'); ?>" id="theme-stylesheet">        
        <link rel="stylesheet" href="<?php echo assets_url('css/modules/main.css'); ?>">

        <script>
            var BASE_URL = "<?php echo base_url(); ?>";
            var SITE_URL = "<?php echo site_url(); ?>";
        </script>        

        <?php echo $css; ?>
        <!-- / -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="<?php echo assets_url('js/html5shiv.min.js'); ?>"></script>
            <script src="<?php echo assets_url('js/respond.min.js'); ?>"></script>
        <![endif]-->
        <script>
            var $buoop = {vs: {i: 8, f: 25, o: 12.1, s: 7}, c: 2,reminder: 24};
            function $buo_f() {                
                var e = document.createElement("script");
                e.src = "//browser-update.org/update.min.js";
                document.body.appendChild(e);
            };
            try {document.addEventListener("DOMContentLoaded", $buo_f, false);}
            catch (e) {window.attachEvent("onload", $buo_f);}
        </script> 
    </head>
    <body>



        <?php echo $body; ?>
        <!-- / -->

        <script>
            var csfrData = {};
            csfrData['<?php echo $this->security->get_csrf_token_name(); ?>']
                    = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>

        <script src="<?php echo assets_url('js/jquery.min.js'); ?>"></script>
        <script src="<?php echo assets_url('js/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo assets_url('js/jquery-ui.min.js'); ?>"></script>                
        <script src="<?php echo assets_url('js/bootstrap.min.js'); ?>"></script>                
        <script src="<?php echo assets_url('js/jquery.blockUI.js'); ?>"></script>
        <script src="<?php echo assets_url('js/metisMenu.min.js'); ?>"></script>                                        
        <script src="<?php echo assets_url('js/jquery.placeholder.min.js'); ?>"></script>                

        <script src="<?php echo assets_url('js/modules/home/main.js'); ?>"></script>                
        <!-- Extra javascript -->
        <?php echo $js; ?>
        <!-- / -->        

        <?php if (!empty($ga_id)): ?><!-- Google Analytics -->
            <script>
                (function(b, o, i, l, e, r) {
                    b.GoogleAnalyticsObject = l;
                    b[l] || (b[l] =
                            function() {
                                (b[l].q = b[l].q || []).push(arguments)
                            });
                    b[l].l = +new Date;
                    e = o.createElement(i);
                    r = o.getElementsByTagName(i)[0];
                    e.src = '//www.google-analytics.com/analytics.js';
                    r.parentNode.insertBefore(e, r)
                }(window, document, 'script', 'ga'));
                ga('create', '<?php echo $ga_id; ?>');
                ga('send', 'pageview');
            </script>
        <?php endif; ?><!-- / -->
    </body>
</html>