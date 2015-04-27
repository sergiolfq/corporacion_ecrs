<?php

require_once("../soporte/dal/conexion.php");  

    $counter = '';
    $headers = '';

    if (isset($_POST))
    {
        $correo = $_POST["correo"];
        $rif_user = $_POST["rif_user"];
        
        
        $sql_clave ="SELECT pass, nombres
                    FROM tbl_usuarios 
                    WHERE email = '{$correo}'
                    AND cedula_rif = '{$rif_user}'
                    AND id_distribuidor = '{$rif_user}'";         
           
        $result_clave = mysql_query($sql_clave) or die('Consulta fallida: ' . mysql_error());
        $num_clave = mysql_num_rows($result_clave);

        if ($num_clave > 0) {
            while($row_clave= mysql_fetch_array($result_clave)) {
                $nombre_cliente = $row_clave["nombres"];
            }
             //genero una clave de 5 caracteres: 
            $clave_provisional = generar_clave(5); 
            
            $update="UPDATE tbl_usuarios SET pass='$clave_provisional' WHERE email = '{$correo}'";
            $resul_update = mysql_query($update) or die('Consulta fallida: ' . mysql_error());
            
            if($resul_update == true){
                
                $mensaje = 1;
                //envio de mail al usuario para notificarle su contraseña temporal
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
                }
                
            }else{
                $mensaje = -1;
            }
            
            
        }else{
            $mensaje = 0;
        }
        
        echo $mensaje;
        
    }
    
    // funcion que genera una clave aleatoria
    function generar_clave($longitud){ 
        $cadena="[^A-Z0-9]"; 
        return substr(eregi_replace($cadena, "", md5(rand())) . 
        eregi_replace($cadena, "", md5(rand())) . 
        eregi_replace($cadena, "", md5(rand())), 
        0, $longitud); 
    }
