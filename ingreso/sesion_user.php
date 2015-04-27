<?php 
session_start();
require_once("../soporte/dal/conexion.php");  

    $email = '';
    $password = '';
    $valores = '';
    $params = array();
    
    if($_POST["email"] != '' && $_POST["password"] != '')
    {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        //var_dump($password);
       
        $query_es ="SELECT *
                    FROM tbl_usuarios 
                    WHERE email = '{$email}' 
                    AND pass = '{$password}' 
                    AND fk_estatus = '1'";         
                    
       $result = mysql_query($query_es) or die('Consulta fallida sesion: ' . mysql_error());
       
        if($row = mysql_fetch_array($result)){
            foreach($row as $key => $value){
                $_SESSION["user"][(string) $key]=$value;
            }
            $valores = 'sesion cargada';
        }
        $params['valores'] = $valores;
        echo json_encode($params);
        
    }
    
    


?>

