function M() {
    var boton = document.getElementById("mercabarato-boton");
    var URL="http://localhost/freelancer/mercabarato_new";
    if (typeof boton.dataset.vendedor != 'undefined') {
        var headID = document.getElementsByTagName("head")[0];
        var cssNode = document.createElement('link');
        cssNode.type = 'text/css';
        cssNode.rel = 'stylesheet';
        cssNode.href = URL+'/assets/css/sdk.css';
        cssNode.media = 'screen';
        headID.appendChild(cssNode);

        var para = document.createElement("a");
        para.href = URL+ "/" + boton.dataset.vendedor;
        boton.appendChild(para);

        for (var i = 0; i < boton.attributes.length; i++)
            if (/^data-/i.test(boton.attributes[i].name))
                boton.removeAttribute(boton.attributes[i].name);
    } else {
        console.log("ERROR: No se encontro el atributo data vendedor < data-vendedor='XXX' >");
    }
}