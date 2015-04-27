<?php 

require_once("../soporte/dal/conexion.php");  

    $email = '';
    $password = '';
    $params = array();
    
    if($_POST["email"] != '' && $_POST["password"] != '')
    {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        //var_dump($password);
       
        $query_es ="SELECT email, pass
                    FROM tbl_usuarios 
                    WHERE email = '{$email}' 
                    AND pass = '{$password}' 
                    AND fk_estatus = '1'";         
                    
       $result = mysql_query($query_es) or die('Consulta fallida login: ' . mysql_error());
       $num_registro = mysql_num_rows($result);
       
        if ($num_registro != 0){ 	
            $opciones = "Acceso correcto";
        }else { 
            //si no existe le mando otra vez a la portada 
            $opciones = "Acceso denegado";
        }
        $params['resultado'] = $opciones;
        echo json_encode($params);
        
    }
    
    


?>

