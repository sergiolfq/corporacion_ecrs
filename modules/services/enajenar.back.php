<?php
    /*
    $delrow = isset($_POST['DelRow']) ? explode(" ",$_POST['DelRow']) : null;   
    
    if(isset($delrow)) 
    {
        if (!isset($_SESSION)) { 
            session_start();               
        }  
        //var_dump($delrow);
        $count = 0;
        $max=count($_SESSION['echk']);
        for($i = 0; $i < $max; $i++) {
            $count = $max-$i-1;
            if(in_array(strval($count), $delrow))
            {
                unset($_SESSION['echk'][$i--]);
                continue;
            }
        }        
        echo "Filas eliminadas correctamente";                
        return;
    }
    */
    //------------------------------------------------------------------------------------------//
    
    include("dal/db.php");
    include("dal/queries.php");
    include("dal/sql_helper.php");
    include("services/functions_enaj.php");   

    if (!isset($_SESSION)) { 
        session_start();    
        if(!isset($_SESSION['echk'])) {
            $_SESSION['echk'] = array();
        }
    }
    
    $allow = sql_helper::get_permissions(isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '','enajenar.php');
    
    if($allow['authenticated'] || $allow['non-registered'])
    {
        $valid = array('-', '_',' '); 
        $mensaje = "";
        $edicion = true;
        $distribuidor_agente_retencion_IVA = "";
        $distribuidor_contribuyente_IVA = "";        
        $tecnico_agente_retencion_IVA = "";
        $tecnico_contribuyente_IVA = "";
        $cliente_agente_retencion_IVA = "";
        $cliente_contribuyente_IVA = "";
        $rif_distribuidor_ant = "";
        $rif_tecnico_full_ant = "";
        $rif_cliente_full_ant = "";
        //----
        $rif_proveedor = trim($_POST['rifProveedor']);
        $nbr_proveedor = 'CORPORACION ECRS';
        $rif_distribuidor_ant = $rif_distribuidor;
        $rif_distribuidor = trim($_POST['rifDistribuidor']);
        $nbr_distribuidor = trim($_POST['nbrDistribuidor']);
        $letra_rif_cliente = $_POST['letraRifCliente'];
        $rif_cliente = trim($_POST['rifCliente']);
        $rif_cliente_full_ant = $rif_cliente_full;
        $rif_cliente_full = isset($_POST['rifCliente']) ? $letra_rif_cliente.$rif_cliente : "";
        $nbr_cliente = trim($_POST['nbrCliente']);
        $letra_rif_tecnico = $_POST['letraRifTecnico'];
        $rif_tecnico = trim($_POST['rifTecnico']);
        $rif_tecnico_full_ant = $rif_tecnico_full;
        $rif_tecnico_full = isset($_POST['rifTecnico']) ? $letra_rif_tecnico.$rif_tecnico : "";
        $nbr_tecnico = trim($_POST['nbrTecnico']);
        $serial_maquina = trim(strtoupper($_POST['numeroRegistroMaquina']));  
        $tipo_op = $_POST['tipoOperacion'];     
        $fecha = $_POST['fechaOperacion'];
        $contacto_cliente = $_POST['contactoCliente'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {    
            if($_POST['dispatchAction'] === 'enviar')
            {
                if(!ereg("^J[0-9]{9}$",$rif_distribuidor)) $mensaje .= "&nbsp;&nbsp; El RIF del distribuidor es inv&aacute;lido<br />";
                if(!ereg("^[J,G,V,E,P][0-9]{9}$",$rif_cliente_full)) $mensaje .= "&nbsp;&nbsp; El RIF del cliente es inv&aacute;lido<br />";
                if(!ereg("^[V,E,P][0-9]{9}$",$rif_tecnico_full)) $mensaje .= "&nbsp;&nbsp; El RIF del t&eacute;cnico es inv&aacute;lido<br />";
                if(!ereg("^XW[a-zA-Z0-9][0-9]{7}$",$serial_maquina)) $mensaje .= "&nbsp;&nbsp; El registro de la m&aacute;quina es invalido<br />";   
                if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$fecha)) $mensaje .= "&nbsp;&nbsp; El formato de la fecha es inv&aacute;lido<br />";

                usleep(200000); //quinta parte de 1 seg
                
                // distribuidor
                if($rif_distribuidor_ant != $rif_distribuidor)
                {
                    @$retval_distribuidor = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$rif_distribuidor); 
                    if($retval_distribuidor !== FALSE) {
                        $data = trim(filter_var(stripslashes($retval_distribuidor), FILTER_SANITIZE_STRING));
                        $limite = strlen($data)-6; //-4
                        $nbr_distribuidor = substr($data, 0, $limite);
                        $retval_distribuidor = preg_replace('/[^a-z0-9 _\.\,\(\)]/i', '', $nbr_distribuidor);
                        $distribuidor_agente_retencion_IVA = substr($data, $limite, 2);
                        $distribuidor_contribuyente_IVA = substr($data, $limite+2, 2);    
                    }
                    else 
                    {
                        $nbr_distribuidor = "";      
                        $mensaje .= "&nbsp;&nbsp; El RIF del distribuidor es inv&aacute;lido<br />";
                    }
                }      
                
                usleep(200000); //quinta parte de 1 seg
                
                // cliente
                if($rif_cliente_full_ant != $rif_cliente_full)
                {
                    @$retval_cliente = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$rif_cliente_full); 
                    if($retval_cliente !== FALSE) {
                        $data = trim(filter_var(stripslashes($retval_cliente), FILTER_SANITIZE_STRING));
                        $limite = strlen($data)-6; //-4
                        $nbr_cliente = substr($data, 0, $limite);
                        $retval_cliente = preg_replace('/[^a-z0-9 _\.\,\(\)]/i', '', $nbr_cliente);
                        $cliente_agente_retencion_IVA = substr($data, $limite, 2);
                        $cliente_contribuyente_IVA = substr($data, $limite+2, 2);    
                    }
                    else 
                    {
                        $nbr_cliente = "";      
                        $mensaje .= "&nbsp;&nbsp; El RIF del cliente es inv&aacute;lido<br />";
                    }
                }     
                
                usleep(200000); //quinta parte de 1 seg

                // tecnico
                if($rif_tecnico_full_ant != $rif_tecnico_full)
                {
                    @$retval_tecnico = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$rif_tecnico_full); 
                    if($retval_tecnico !== FALSE) {
                        $data = trim(filter_var(stripslashes($retval_tecnico), FILTER_SANITIZE_STRING));
                        $limite = strlen($data)-7; //-4
                        $nbr_tecnico = substr($data, 0, $limite);
                        $retval_tecnico = preg_replace('/[^a-z0-9 _\.\,\(\)]/i', '', $nbr_tecnico);
                        $tecnico_agente_retencion_IVA = substr($data, $limite, 2);
                        $tecnico_contribuyente_IVA = substr($data, $limite+2, 2);    
                    }
                    else 
                    {
                        $nbr_tecnico = "";      
                        $mensaje .= "&nbsp;&nbsp; El RIF del t&eacute;cnico es inv&aacute;lido<br />";
                    }
                }
                
                if($mensaje == "") $edicion = false;
            }         
            
            if($_POST['dispatchAction'] === 'aceptar')
            {
                $max=count($_SESSION['echk']);                    
                $_SESSION['echk'][$max][0]=$max;                            //id
                $_SESSION['echk'][$max][1]=strtoupper($rif_proveedor);      //rif_proveedor
                $_SESSION['echk'][$max][2]=strtoupper($rif_distribuidor);   //rif_distribuidor
                $_SESSION['echk'][$max][3]=strtoupper($rif_cliente_full);   //rif_cliente
                $_SESSION['echk'][$max][4]=strtoupper($rif_tecnico_full);   //rif_tecnico
                $_SESSION['echk'][$max][5]=strtoupper($serial_maquina);     //numero registro maquina
                $_SESSION['echk'][$max][6]=$tipo_op;                        //tipo_op
                $_SESSION['echk'][$max][7]=$fecha;                          //fecha            
                $_SESSION['echk'][$max][8]='';                              //fecha_registro - asignado por BD
                $_SESSION['echk'][$max][9]=$nbr_proveedor;                  //razon social proveedor
                $_SESSION['echk'][$max][10]=$nbr_distribuidor;              //razon social distribuidor
                $_SESSION['echk'][$max][11]=$nbr_cliente;                   //razon social cliente
                $_SESSION['echk'][$max][12]=$nbr_tecnico;                   //razon social tecnico
                $_SESSION['echk'][$max][13]=descripcion_de_enaj($tipo_op);  //nombre_tipo_op
                $_SESSION['echk'][$max][14]=$_SESSION['id_usuario'];        //id_usuario  
                
                $serial_maquina = '';
            }
            
            //$("#form").validate().cancelSubmit = true;
            if($_POST['dispatchAction'] === 'Finalizar')
            {
                $ctrl = 0;
                $indexes = '';
                $max = count($_SESSION['echk']);    
                for($i = 0; $i < $max; $i++) 
                {
                    $rif_proveedor = $_SESSION['echk'][$i-$ctrl][1];
                    $rif_distribuidor = $_SESSION['echk'][$i-$ctrl][2];
                    $rif_cliente_full = $_SESSION['echk'][$i-$ctrl][3];
                    $rif_tecnico_full = $_SESSION['echk'][$i-$ctrl][4];
                    $serial_maquina = $_SESSION['echk'][$i-$ctrl][5];  
                    $tipo_op = $_SESSION['echk'][$i-$ctrl][6]; 
                    $fecha = $_SESSION['echk'][$i-$ctrl][7]; 
                    $nbr_proveedor = $_SESSION['echk'][$i-$ctrl][9];                    
                    $nbr_distribuidor = $_SESSION['echk'][$i-$ctrl][10];                    
                    $nbr_cliente = $_SESSION['echk'][$i-$ctrl][11];                    
                    $nbr_tecnico = $_SESSION['echk'][$i-$ctrl][12];                                        
                    $nbr_tipo_op = $_SESSION['echk'][$i-$ctrl][13];                        
                    $rif_usuario = $_SESSION['echk'][$i-$ctrl][14];  
                    
                    //El proveedor es Corporacion ECRS y se encuentra predeterminado en BD
                    $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_distribuidor."','".$nbr_distribuidor."',".strval(2));       
                    $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_cliente_full."','".$nbr_cliente."',".strval(1));   
                    $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_tecnico_full."','".$nbr_tecnico."',".strval(4));          
                    
                    $link=db::get_mysql()->conn(); 
                    $sql=queries::fnc_add_enaj."('$rif_proveedor','$rif_distribuidor','$rif_cliente_full','$rif_tecnico_full','$serial_maquina',".$tipo_op.",'$fecha','$rif_usuario')";
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
                            $mensaje .= "&nbsp;&nbsp; La impresora fiscal ".$serial_maquina." ya se encuentra registrada por Desincorporacion<br />"; 
                        }
                        else if($retval == -3)
                        {
                            $mensaje .= "&nbsp;&nbsp; La impresora fiscal ".$serial_maquina." ya se encuentra registrada por concepto de Venta<br />"; 
                        }
                        else
                        {
                            $mensaje .= "&nbsp;&nbsp; No se pudo registrar en base de datos la impresora fiscal ".$serial_maquina."<br />";
                        }            
                    }
                    
                    mysql_free_result($result);
                    mysql_close($link);
                } 
                
                if($mensaje == "")          
                {                    
                    $rif_distribuidor = "";
                    $rif_cliente_full = "";
                    $rif_tecnico_full = "";
                    $serial_maquina = "";  
                    $tipo_op = "1"; 
                    $fecha = "";                    
                    $nbr_distribuidor = "";                    
                    $nbr_cliente = "";                    
                    $nbr_tecnico = "";   
                    $nbr_tipo_op = "";
                    unset($_SESSION['echk']);
                }
            }            
        }         
        
        $count = 0;
        $datachk = '';
        $max=count($_SESSION['echk']);
        for($i = 0; $i < $max; $i++) {
            $count = $max-$i-1;
            $datachk .= '
            data['.$count.'] = {
            id: "'.$_SESSION['echk'][$i][0].'",
            rif_proveedor: "'.$_SESSION['echk'][$i][1].'",
            rs_proveedor: "'.$_SESSION['echk'][$i][9].'",
            rif_distribuidor: "'.$_SESSION['echk'][$i][2].'",
            rs_distribuidor: "'.$_SESSION['echk'][$i][10].'",
            rif_cliente: "'.$_SESSION['echk'][$i][3].'",
            rs_cliente: "'.$_SESSION['echk'][$i][11].'",
            rif_tecnico: "'.$_SESSION['echk'][$i][4].'",
            rs_tecnico: "'.$_SESSION['echk'][$i][12].'",
            serial: "'.$_SESSION['echk'][$i][5].'",
            tipo_op: "'.$_SESSION['echk'][$i][6].'",
            rs_tipo_op: "'.$_SESSION['echk'][$i][13].'",
            fecha: "'.$_SESSION['echk'][$i][7].'"                    
            };
            ';            
        }             
        $datachk = 'var data = [];'.$datachk;                                   
    }                      
    else {
        header("location:default.php");      
    }  
    
    function descripcion_de_enaj($eid){
        $retval = '';
        switch($eid)
        {
            case '1':  $retval = 'Enajenacion'; break;
            case '2':  $retval = 'Inspeccion anual'; break;
            case '3':  $retval = 'Reparacion'; break;
            case '4':  $retval = 'Adaptacion'; break;
            case '5':  $retval = 'Sustitucion de memoria fiscal'; break;
            case '6':  $retval = 'Sustitucion de memoria de auditoria'; break;
            case '7':  $retval = 'Alteracion o remocion de dispositivos de seguridad'; break;
            case '8':  $retval = 'Reporte de perdida o robo por parte del distribuidor, centros, personal tecnico o proveedor'; break;
            case '9':  $retval = 'Reporte de perdida o robo por parte del usuario'; break;
            case '10': $retval = 'Desincorporacion'; break;
        }
        return $retval;
    }
    
    function razon_social($rif)
    {
        try {
            @$retval = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$rif); 
            if($retval != FALSE) {
                $data = trim(filter_var(stripslashes($retval), FILTER_SANITIZE_STRING));
                $limite = strlen($data)-4;
                $nombre_user = substr($data, 0, $limite);
                $retval = preg_replace('/[^a-z0-9 _\.\,\(\)]/i', '', $nombre_user);
                $agente_retencion_IVA = substr($data, $limite, 2);
                $contribuyente_IVA = substr($data, $limite+2, 2);    
            }
            else throw new Exception("Failed to read page");
            return $retval;
        } catch(Exception $e) {
            //$e->getMessage();
            return FALSE;            
        }
    }    
?>
