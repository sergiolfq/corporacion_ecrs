<?php
require_once("dal/conexion.php"); 

$mensaje = '';
    //var_dump($_POST["borrar"]);
    if(isset($_POST["borrar"])){
        $id = $_POST["borrar"];
        $queryDelete="DELETE FROM q_enajenacion WHERE id={$id}";
        //var_dump($queryDelete);
        $eliminado = @mysql_query($queryDelete);
        if($eliminado){
           echo $mensaje="Los Datos se han Eliminado Correctamente";
        }else{
           echo $mensaje="No se pudo eliminar el Registro";
        }
    }
    
    
    
?>


