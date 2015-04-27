<?php
require_once("dal/conexion.php");  

        if(isset($_GET["Ope"])){
            $operacion = trim($_GET["Ope"]);
            if(strtoupper($operacion)=="ELIMINAR"){
                $id=$_GET["id"];
                $queryDelete="DELETE FROM q_enajenacion WHERE id=$id";
                $eliminado = @mysql_query($queryDelete);
                if($eliminado){
                   echo $mensaje="Los Datos se han Eliminado Correctamente";
                }
                else{
                   echo $mensaje="No se pudo eliminar el Registro";
                }
            }
        }
        
?>
