<xmp>
    <!-- Este sera tu boton o link -->
    <div id="mercabarato-boton" data-vendedor="apodo-vendedor"></div>
    <script type="text/javascript">
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = <?php echo site_url("/assets/js/sdk.js") ?>;
            fjs.parentNode.insertBefore(js, fjs);
            js.onload = s.onreadystatechange = function() {
                var rs = this.readyState;
                if (rs)
                    if (rs != 'complete')
                        if (rs != 'loaded')
                            return;
                try {
                    new M();
                } catch (e) {
                }
            };
        }(document, 'script', 'mercabarato-sdk'));
    </script>
</xmp>