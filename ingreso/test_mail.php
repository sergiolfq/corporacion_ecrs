<?php

//ejemplo
//$counter .= "En Corporación ECRS, C.A., estamos para brindarle soluciones oportunas y satisfactorias. Le informamos <br>


//Hola ANIBAL GONZALEZ.
//Nos ha informado que desconoce su contraseña. Por seguridad no almacenamos ni rehabilitamos contraseñas olvidadas. Se le asignó una clave provisional, la cual podrá cambiar en el momento que lo desee. Ingrese al siguiente enlace para iniciar sesión y modificar la  clave provisional por la contraseña de su preferencia.
//Clave provisional.: 5626bf
//http://www.ecrs.com.ve/ingreso/nuevo_ingreso.php
//Por favor, no responda ni reenvíe mensajes a esta cuenta, si desea comunicarse con nosotros utilice el formulario de contacto de nuestro website, a través del siguiente enlace.
//http://ecrs.com.ve/?module=contacto


// correo que se enviara al cliente con la clave provisional.
$nombre_cliente = 'ANIBAL GONZALEZ.';
$clave_provisional = '5626bf';
$correo = 'contactenos.ecrs@gmail.com';

$titulo = "Corporación ECRS C.A.";
$counter = "<html><head></head><body style='Calibri Light (Títulos) : Arial; font-size : 12pt;'>";
$counter .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo01.png' alt='' />"."<br><br>";
$counter .= "Hola ".$nombre_cliente."<br><br><br>";
$counter .= "Nos ha informado que desconoce su contraseña. Por seguridad no almacenamos ni rehabilitamos"."<br>";
$counter .= "contraseñas olvidadas. Se le asignó una clave provisional, la cual podrá cambiar en el momento"."<br>";
$counter .= "que lo desee. Ingrese al siguiente enlace para iniciar sesión y modificar la clave provisional por la"."<br>";
$counter .= "contraseña de su preferencia."."<br><br><br>";
$counter .= "Clave provisional.: ".$clave_provisional."<br><br><br>";
$counter .= "http://www.ecrs.com.ve/ingreso/nuevo_ingreso.php"."<br><br><br>";
$counter .= "Por favor, no responda ni reenvíe mensajes a esta cuenta, si desea comunicarse con nosotros"."<br>";
$counter .= "utilice el formulario de contacto de nuestro website, a través del siguiente enlace."."<br><br><br>";
$counter .= "http://ecrs.com.ve/?module=contacto"."<br><br><br>";
$counter .= "Saludos Cordiales."."<br><br><br>";
$counter .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo03.png' alt='' />";
$counter .= "</body></html>";
// Always set content-type when sending HTML email
$header = "MIME-Version: 1.0" . "\r\n";
$header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$header .= 'From: <contactenos@ecrs.com.ve>' . "\r\n";

if(mail($correo, $titulo, $counter, $header)){
    
    $corporacion = 'contactenos.ecrs@gmail.com';
    $subjet = "Corporación ECRS C.A.";
    $contenido = "<html><head></head><body style='Calibri Light (Títulos) : Arial; font-size : 12pt;'>";
    $contenido .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo01.png' alt='' />"."<br><br>";
    $contenido .= "El Usuario: ".$nombre_cliente."<br><br><br>";
    $contenido .= "Realizó una solicitud de recuperación de contraseña a través del módulo de ingreso, en la plataforma"."<br>";
    $contenido .= "web www.ecrs.com.ve."."<br><br><br>";
    $contenido .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo03.png' alt='' />";
    $contenido .= "</body></html>";
    // Always set content-type when sending HTML email
    $cabecera = "MIME-Version: 1.0" . "\r\n";
    $cabecera .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $cabecera .= 'From: <contactenos@ecrs.com.ve>' . "\r\n";
    
    mail($corporacion, $subjet, $contenido, $cabecera);
    
    echo 'El mail ha Sido Enviado';
}else{
    echo 'Ocurrio un Error';
}
