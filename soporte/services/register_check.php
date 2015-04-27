<?php
    // connect database    
    include("dal/queries.php");  
    include("dal/db.php");
    
    $enaj_update = isset($_GET['persona']) ? $_GET['persona'] : ''; 
    
    $rif = isset($_POST['rif']) ? $_POST['rif'] : null; //la mascara evita los espacios en blanco
    $razon_social1 = isset($_POST['razonsocial']) ? trim($_POST['razonsocial']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null; //la mascara evita los espacios en blanco solo a la izq 
    $password1 = isset($_POST['password1']) ? $_POST['password1'] : null; //la mascara evita los espacios en blanco
    $id_pais = isset($_POST['pais']) ? $_POST['pais'] : 1; //saca es un número
    $id_estado = isset($_POST['estado']) ? $_POST['estado'] : 1; //saca es un número
    $ciudad = isset($_POST['ciudad']) ? trim($_POST['ciudad']) : null;
    $telefono1 = isset($_POST['telf1']) ? $_POST['telf1'] : null; //la mascara evita los espacios en blanco
    $telefono2 = isset($_POST['telf2']) ? $_POST['telf2'] : null; //la mascara evita los espacios en blanco
    $telefono3 = isset($_POST['telf3']) ? $_POST['telf3'] : null; //la mascara evita los espacios en blanco
    $direccion = '';
    $razon_social2 = '';
    $id_rol = 2; //2 es Distribuidor
    $aviso = null;
    
    if (!isset($_SESSION)) { 
        session_start(); 
    }
    
    if(!empty($_SESSION['id_usuario']))
    { 
        if($email != null) //IsPostBack
        {
            $link=db::get_mysql()->conn();            
            $sql=queries::fnc_register_check."('$rif','$razon_social1','$razon_social2',$id_rol,'$email',".(int)$id_estado.",'$ciudad','$direccion','$telefono1','$telefono2','$telefono3','".md5($password1)."')";
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
                header("location:default.php");
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
        }
    }
    else {
        header("location:default.php");
    }
?>
