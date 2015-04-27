<?php

require_once("dal/conexion.php");  

    $opciones = '';
    if(isset($_POST["idPais"]))
    {
       $idPais = $_POST["idPais"];
       var_dump($idPais);
       $query_es = "SELECT pk_estado,estado FROM tbl_estados WHERE fk_pais = {$idPais} ORDER BY estado";
       $result = mysql_query($query_es) or die('Consulta fallida 1: ' . mysql_error());
       while($estados = mysql_fetch_array($result,MYSQL_ASSOC))
       {
          $opciones.= "<option value='".$estados['pk_estado']."'>".$estados['estado']."</option>";
       }
       echo $opciones;
    }
    
    $alternativas = '';
    if(isset($_POST["idEstado"]))
    {
       $idEstado = $_POST["idEstado"];
       var_dump($idPais);
       $query_ci = "SELECT pk_ciudad, ciudad FROM tbl_ciudades WHERE fk_estado = {$idEstado} ORDER BY ciudad";
       $result_ci = mysql_query($query_ci) or die('Consulta fallida 1: ' . mysql_error());
       while($paises = mysql_fetch_array($result_ci,MYSQL_ASSOC))
       {
          $alternativas.= "<option value='".$paises['pk_ciudad']."'>".$paises['ciudad']."</option>";
       }
       echo $alternativas;
    }
    
    
//    $query_es = "SELECT * FROM `tbl_estados` WHERE fk_pais={$idPais}  ORDER BY estado";
//    $result = mysql_query($query_es);
//    echo '<option value="">Seleccione</option>';
//    while($row_es=mysql_fetch_array($result, MYSQL_ASSOC)){
//        echo "<option value='".$row_es['pk_estado']."' >".$row_es['estado']."</option>";
//    } 
    
    
?>
