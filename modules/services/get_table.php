<?php
    $delrow = isset($_POST['DelRow']) ? explode(" ",$_POST['DelRow']) : null;  
    
    if (!isset($_SESSION)) { 
        session_start();               
    }  

    $total = count($_SESSION['echk']);
    $max = count($delrow);
    $miarray = array();
    for($i = 0; $i < $max; $i++) 
    {
        $miarray[] = $total-intval($delrow[$i])-1;
    }
    
    $ctrl = 0;
    sort($miarray, SORT_NUMERIC);
    $max=count($miarray);            
    for($i = 0; $i < $max; $i++) 
    {
        array_splice($_SESSION['echk'], $miarray[$i]-$ctrl, 1);
        $ctrl++;
    }
    
    if(count($_SESSION['echk']) < $total) echo "Filas eliminadas correctamente";
    else echo "No se elimino ningun registro";
?>
