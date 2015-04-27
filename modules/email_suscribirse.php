<?php 

require_once("../soporte/dal/conexion.php");  

    $email = '';
    $rsp = '';
    
    if(isset($_POST["email"]) && $_POST["email"])
    {
        $email = $_POST["email"];
        //var_dump($email);
       
        $query_es ="INSERT INTO tbl_correo (correo)
                    VALUES ('".$email."')";         
                    
       $result = mysql_query($query_es) or die('Consulta fallida login: ' . mysql_error());
       $num_registro = mysql_query($query_es) or die('Consulta fallida tecnico: ' . mysql_error());
       
        if ($num_registro){ 	
            $rsp = 1;
        }else { 
            $rsp = 0;
        }
        
        echo $rsp;
        
    }
    
    


?>
