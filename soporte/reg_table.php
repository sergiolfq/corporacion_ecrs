<?php
    require_once("dal/sql_helper.php");
    
    if (!isset($_SESSION)) { 
        session_start(); 
    }
    
    $ctrl = 0;
    $msg = '';                  
    $indexes = '';
    $max = count($_SESSION['echk']);    
    for($i = 0; $i < $max; $i++) 
    {
        $rif_proveedor = $_SESSION['echk'][$i-$ctrl][1];
        $rs_proveedor = $_SESSION['echk'][$i-$ctrl][9];
        $rif_distribuidor = $_SESSION['echk'][$i-$ctrl][2];
        $rs_distribuidor = $_SESSION['echk'][$i-$ctrl][10];
        $rif_cliente = $_SESSION['echk'][$i-$ctrl][3];
        $rs_cliente = $_SESSION['echk'][$i-$ctrl][11];
        $rif_tecnico = $_SESSION['echk'][$i-$ctrl][4];
        $rs_tecnico = $_SESSION['echk'][$i-$ctrl][12];
        $serial = $_SESSION['echk'][$i-$ctrl][5];  
        $tipo_op = $_SESSION['echk'][$i-$ctrl][6]; 
        $rs_tipo_op = $_SESSION['echk'][$i-$ctrl][13];    
        $fecha = $_SESSION['echk'][$i-$ctrl][7]; 
        $rif_usuario = $_SESSION['echk'][$i-$ctrl][14];  
        //$current_date = date("d/m/Y");        
        
        //$retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_proveedor."','".$rs_proveedor."',".strval(6));
        $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_distribuidor."','".$rs_distribuidor."',".strval(2));       
        $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_cliente."','".$rs_cliente."',".strval(1));   
        $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_tecnico."','".$rs_tecnico."',".strval(4));          
        
        $link=db::get_mysql()->conn(); 
        $sql=queries::fnc_add_enaj."('$rif_proveedor','$rif_distribuidor','$rif_cliente','$rif_tecnico','$serial',".$tipo_op.",'$fecha','$rif_usuario')";
        $result=mysql_query($sql,$link);
        $retval=mysql_result($result, 0);            
        
        if($retval > 0) {
            array_splice($_SESSION['echk'], $i-$ctrl, 1);
            $ctrl++;
        }
        else 
        {
            $indexes .= $i." ";
            if($retval == -2)
            {                
                $msg .= "Error#1: La impresora fiscal ".$serial." ya se encuentra registrada por Desincorporacion\n"; 
            }
            else if($retval == -3)
            {
                $msg .= "Error#2: La impresora fiscal ".$serial." ya se encuentra registrada por concepto de Venta\n"; 
            }
            else
            {
                $msg .= "Error#3: No se pudo registrar en base de datos la impresora fiscal ".$serial."\n";
            }            
        }
        
        mysql_free_result($result);
        mysql_close($link);
    } 
    if($msg == '') unset($_SESSION['echk']);                        
    echo $msg;
?>
