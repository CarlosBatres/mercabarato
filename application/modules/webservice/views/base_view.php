<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Extra metadata -->
        <?php echo $metadata; ?>
        <!-- / -->

        <link rel="shortcut icon" href="<?php echo assets_url('imgs/favicon.ico'); ?>" type="image/x-icon" />        
        <link rel="stylesheet" href="<?php echo assets_url('css/modules/webservice.css'); ?>">

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
    </head>
    <body>        
        <?php echo $body; ?>
        <!-- / -->        
        <!-- Extra javascript -->
        <?php echo $js; ?>
        <!-- / -->
        
        <script src="<?php echo assets_url('js/jquery.min.js'); ?>"></script>
        <script src="<?php echo assets_url('js/modules/webservice/main.js'); ?>"></script>
        
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