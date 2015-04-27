<?php
require_once("dal/conexion.php"); 

    $valores = '';
    $mes_nuevo = '';
    $anio_nuevo = '';
    $mes_actual = date("n");
    $anio_actual = date("Y");
    
    if($_POST["mes_nuevo"] != '' && $_POST["anio_nuevo"] != ''){
        
        $mes_nuevo = $_POST["mes_nuevo"];
        $anio_nuevo = $_POST["anio_nuevo"];
        
        if($mes_actual == 1 && $mes_nuevo == 12 && $anio_actual > $anio_nuevo){
            //$valores = 'SI';
        }else{
            $mes_actual = $mes_actual - 1;
            if($mes_nuevo == $mes_actual && $anio_nuevo == $anio_actual){
                //$valores = 'SI';
            }else{
                echo $valores = 'Mes y/o año incorrecto. No corresponde con el período a enajenar.';
            }
        }
    }
    
?>