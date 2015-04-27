<?php
    include("dal/sql_helper.php");
    require_once(dirname(dirname(__FILE__)) . "/includes/includes.php");
    $Shop = new Shop;
    
    if (!isset($_SESSION)) { 
        session_start(); 
    }    

    $i = intval($_GET["index"]);
    $retval = sql_helper::exec_query(queries::prc_get_all_users);    

    if($i < count($retval))
    {
        $_POST['pk_usuario'] = $retval[$i][0];
        $_POST['email'] = $retval[$i][1];
        $_POST['pass'] = $retval[$i][2];        
        unset($_SESSION["user"]);       
        
        echo $_POST['email']."<br/>";
        
        $sql = "select * from " . TBL_USUARIOS . " where pk_usuario=" . $Shop->clearSql_s($_POST['pk_usuario']) . " and fk_estatus <> 0";
    
        echo $sql."<br/>";
        
        $rs=$Shop->Execute($sql);
        
        if(sizeof($rs["results"])==0){ //el email no se encuentra
            echo _("Email no registrado")."<br/>"; 
        }else{ //el email se encontro
            if($_POST["pass"]==$rs["results"][0]["pass"]){ // el password concuerda
                foreach($rs["results"][0] as $key => $value){ //levanto todos los datos del usuario en la session
                    $_SESSION["user"][(string) $key]=$value;
                }
            }else{ //el password NO concuerda
                echo _("Contraseña errónea")."<br/>";
            }
        }
        
        $Shop->sendActivationNote($_SESSION["user"],$_POST['pk_usuario']);
        
        var_dump($_SESSION["user"])."<br/>"; 
    }
    
    /*
    $link=db::get_mysql()->conn();
    
    $result=mysql_query($sql,$link);
    $retval=mysql_result($result, 0);

    if($retval > 0) {
        if (!isset($_SESSION)) { 
            session_start(); 
        }
        $_SESSION['id_usuario'] = $rif;
        $_SESSION['nombre'] = $razon_social1;
        $_SESSION['email'] = $email;    
        $_SESSION['timeout'] = time();  
        
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
        $_SESSION['echk'][$max][9]=razon_social($rif_proveedor);    //razon social proveedor
        $_SESSION['echk'][$max][10]=$nbr_distribuidor;              //razon social distribuidor
        $_SESSION['echk'][$max][11]=$nbr_cliente;                   //razon social cliente
        $_SESSION['echk'][$max][12]=$nbr_tecnico;                   //razon social tecnico
        $_SESSION['echk'][$max][13]=descripcion_de_enaj($tipo_op);  //nombre_tipo_op
        $_SESSION['echk'][$max][14]=$_SESSION['id_usuario'];        //id_usuario  
        
    }
    else if($retval == 0) {
        $aviso = "* El email ".$email." ya se encuentra registrado";
    }
    else {
        $aviso = "* No se pudo insertar el registro en la base de datos";
    }

    // Libere los recursos asociados con el resultset
    // Esto es ejecutado automáticamente al finalizar el script.
    mysql_free_result($result);    
    mysql_close($link);    
    */  
?>
