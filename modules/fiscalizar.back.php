<?php
    include("dal/db.php");
    include("dal/queries.php");
    include("dal/sql_helper.php");
    include("services/functions_enaj.php");  
    
    if (!isset($_SESSION)) { 
        session_start();               
    }    
    
    die("entra aqui");
    $allow = sql_helper::get_permissions(isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '','fiscalizar.php');
    
    if($allow['authenticated'] || $allow['non-registered'])
    {
        $valid = array('-', '_',' '); 
        $mensaje = "";
        $edicion = true;
        $tecnico_agente_retencion_IVA = "";
        $tecnico_contribuyente_IVA = "";
        $cliente_agente_retencion_IVA = "";
        $cliente_contribuyente_IVA = "";
        //----
        $rif_proveedor = 'J313222798';
        $rif_usuario = $_SESSION['id_usuario'];
        $serial_maquina = trim(strtoupper($_POST['numeroRegistroMaquina']));
        $letra_rif_tecnico = $_POST['letraRifTecnico'];
        $rif_tecnico = trim($_POST['rifTecnico']);
        $rif_tecnico_full = isset($_POST['rifTecnico']) ? $letra_rif_tecnico.$rif_tecnico : "";
        $nbr_tecnico = trim($_POST['nbrTecnico']);
        $letra_rif_cliente = $_POST['letraRifCliente'];
        $rif_cliente = trim($_POST['rifCliente']);
        $rif_cliente_full = isset($_POST['rifCliente']) ? $letra_rif_cliente.$rif_cliente : "";   
        $nbr_cliente = trim($_POST['nbrCliente']);
        $nombre_tipo_cliente = $_POST['nombreTipoCliente'];
        $sistema_administrativo = trim(strtoupper($_POST['sistemaAdministrativo']));
        $numero_factura = trim(strtoupper($_POST['numeroFactura']));
        $fecha_factura = trim($_POST['fechaFactura']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {    
            if($_POST['dispatchAction'] === 'enviar')
            {                           
                if(!ereg("^XW[a-zA-Z0-9][0-9]{7}$",$serial_maquina)) $mensaje .= "&nbsp;&nbsp; El registro de la m&aacute;quina es invalido<br />";
                if(!ereg("^[V,E,P][0-9]{9}$",$rif_tecnico_full)) $mensaje .= "&nbsp;&nbsp; El RIF del t&eacute;cnico es inv&aacute;lido<br />";
                if(!ereg("^[J,G,V,E,P][0-9]{9}$",$rif_cliente_full)) $mensaje .= "&nbsp;&nbsp; El RIF del cliente es inv&aacute;lido<br />";
                if(!ereg("^[a-zA-Z0-9 _\-]*$",$sistema_administrativo)) $mensaje .= "&nbsp;&nbsp; El nombre del sistema administrativo tiene caracteres inv&aacute;lidos<br />";
                else $sistema_administrativo .= "                                   "; 
                if(!ctype_alnum(str_replace($valid,'',$numero_factura))) $mensaje .= "&nbsp;&nbsp; El n&uacute;mero de factura tiene caracteres inv&aacute;lidos<br />";
                else $numero_factura .= "               ";
                if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$fecha_factura)) $mensaje .= "&nbsp;&nbsp; El formato de la fecha es inv&aacute;lido<br />";
                        
                @$retval_tecnico = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$rif_tecnico_full); 
                if($retval_tecnico !== FALSE) {
                    $data = trim(filter_var(stripslashes($retval_tecnico), FILTER_SANITIZE_STRING));
                    $limite = strlen($data)-4;
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

                @$retval_cliente = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$rif_cliente_full); 
                if($retval_cliente !== FALSE) {
                    $data = trim(filter_var(stripslashes($retval_cliente), FILTER_SANITIZE_STRING));
                    $limite = strlen($data)-4;
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
                
                if($mensaje == "") $edicion = false;
            }
            
            if($_POST['dispatchAction'] === 'finalizar')
            {              
                $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_cliente_full."','".$nbr_cliente."',".strval(1));   
                $retval = sql_helper::exec_query(queries::fnc_add_user,"'".$rif_tecnico_full."','".$nbr_tecnico."',".strval(4));  
                 
                $link=db::get_mysql()->conn(); 
                $sql=queries::fnc_add_fiscalizacion."('$rif_proveedor','$rif_usuario','$rif_cliente_full','$rif_tecnico_full','$serial_maquina',1,'$rif_usuario','$nombre_tipo_cliente','$sistema_administrativo','$numero_factura','$fecha_factura')";
                $result=mysql_query($sql,$link);
                $retval=mysql_result($result, 0);            
                
                if($retval < 0) {
                    $indexes .= $i." ";
                    if($retval == -2)
                    {                
                        $mensaje .= "&nbsp;&nbsp; La impresora fiscal ".$serial." ya se encuentra registrada por Desincorporacion<br />";
                    }
                    else if($retval == -3)
                    {
                        $mensaje .= "&nbsp;&nbsp; La impresora fiscal ".$serial." ya se encuentra registrada por Fiscalizaci&oacute;n<br />";
                    }
                    else
                    {
                        $mensaje .= "&nbsp;&nbsp; No se pudo registrar en base de datos la impresora fiscal ".$serial."<br />";
                    }            
                }
                else if($retval > 0)
                {
                    $serial_maquina = '';
                    $letra_rif_tecnico = '';
                    $rif_tecnico = '';
                    $nbr_tecnico = '';
                    $letra_rif_cliente = '';
                    $rif_cliente = '';
                    $nbr_cliente = '';
                    $nombre_tipo_cliente = '';
                    $sistema_administrativo = '';
                    $numero_factura = '';
                    $fecha_factura = '';
                }                
                else if($retval === FALSE)
                {
                     $mensaje .= "&nbsp;&nbsp; No se pudo registrar en base de datos la impresora fiscal ".$serial."<br />";
                }
                
                mysql_free_result($result);
                mysql_close($link);
            }            
        }
        
        $_SESSION['enaj'] = sql_helper::exec_query(queries::prc_get_enajs_by_pending);
                                                                                    
        $data = 'var data = [];';                
        $max=count($_SESSION['enaj']);
        for($i = 0; $i < $max; $i++) {
            $data .= '
            data['.$i.'] = {
            id: "'.$_SESSION['enaj'][$i][0].'",
            rif_proveedor: "'.$_SESSION['enaj'][$i][1].'",
            rs_proveedor: "'.$_SESSION['enaj'][$i][9].'",
            rif_distribuidor: "'.$_SESSION['enaj'][$i][2].'",
            rs_distribuidor: "'.$_SESSION['enaj'][$i][10].'",
            rif_cliente: "'.$_SESSION['enaj'][$i][3].'",
            rs_cliente: "'.$_SESSION['enaj'][$i][11].'",
            rif_tecnico: "'.$_SESSION['enaj'][$i][4].'",
            rs_tecnico: "'.$_SESSION['enaj'][$i][12].'",
            serial: "'.$_SESSION['enaj'][$i][5].'",
            tipo_op: "'.$_SESSION['enaj'][$i][6].'",
            rs_tipo_op: "'.$_SESSION['enaj'][$i][13].'",
            fecha: ""                    
            };
            ';            
        }          
    }    
?>
