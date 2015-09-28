<?php

$test = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><mercabarato></mercabarato>");

$productos = $test->addChild("productos");

$producto = $productos->addChild("producto");
$producto->addChild("nombre", "Producto Prueba");
$producto->addChild("descripcion", "<p>Descripcion Producto Prueba</p><br><p> Acepta HTML</p>");
$producto->addChild("precio", "10.00");
$producto->addChild("mostrar_precio", "1");
$producto->addChild("mostrar_producto", "1");
$producto->addChild("habilitado", "1");
$producto->addChild("link_externo", "");
$producto->addChild("categoria_id", "1");

$imagen1 = file_get_contents("imagen1.jpg");
$producto->addChild("imagen_principal", base64_encode($imagen1));
$producto->addChild("imagen_principal_extension", "jpg");

$imagen2 = file_get_contents("imagen2.jpg");
$producto->addChild("imagen_extra1", base64_encode($imagen2));
$producto->addChild("imagen_extra1_extension", "jpg");

$imagen3 = file_get_contents("imagen3.jpg");
$producto->addChild("imagen_extra2", base64_encode($imagen3));
$producto->addChild("imagen_extra2_extension", "jpg");

$username = 'TU-USUARIO-EMAIL';
$password = 'TU-PASSWORD';

$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, 'www.mercabarato.com/webservice/upload_products');
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $test->asXML());

curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
$buffer = curl_exec($curl_handle);

curl_close($curl_handle);

Header('Content-type: text/xml');
echo $buffer;
