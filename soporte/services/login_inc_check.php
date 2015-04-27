<?php
    // connect database    
    require_once("dal/db.php");
    require_once("dal/queries.php");    
    require_once("dal/sql_helper.php");    
                             
    // username and password sent from form 
    $login_inc_rif = isset($_REQUEST['rif']) ? strtoupper(trim($_REQUEST['rif'])) : null; //la mascara evita los espacios en blanco solo a la izq
    $login_inc_clave = isset($_REQUEST['clave']) ? $_REQUEST['clave'] : null; //la mascara evita los espacios en blanco
    $login_inc_aviso = null;                    

    if (!isset($_SESSION)) { 
        session_start(); 
    }     
    
    if(isset($_SESSION["user"])) {
        $_SESSION['id_usuario'] = $_SESSION["user"]["cedula_rif"];
        $_SESSION['nombre'] = $_SESSION["user"]["nombres"]." ".$_SESSION["user"]["apellidos"];
        $_SESSION['email'] = $_SESSION["user"]["email"];        
        $_SESSION['timeout'] = time();                           
        header("location:default.php");
        //if(isset($_GET["logout"])) {
        //    unset($_SESSION["user"]);
        //}
    }    
    else {
       // header("location:default.php");
        header("location:index.php");          
    } 

    /*    
    if(empty($_SESSION['id_usuario']))
    { 
        if($login_inc_rif != null) //IsPostBack
        {            
            // To protect MySQL injection (more detail about MySQL injection)
            //$login_inc_email = stripslashes($login_inc_email);
            //$login_inc_clave = stripslashes($login_inc_clave);
            //$login_inc_email = mysql_real_escape_string($login_inc_email);
            //$login_inc_clave = mysql_real_escape_string($login_inc_clave);
                     
            $user = sql_helper::exec_query(queries::prc_login_check, "'$login_inc_rif','".md5($login_inc_clave)."'");
            $count=count($user);
            if($count == 1) {                   
                $_SESSION['id_usuario'] = $user[0][0];
                $_SESSION['nombre'] = $user[0][1]." ".$user[0][2];
                $_SESSION['email'] = $user[0][3];
                $_SESSION['timeout'] = time();                                         
                header("location:default.php");
            }
            else if($count == 0) {
                $login_inc_aviso = "* No se encontr&oacute; la combinaci&oacute;n de email y password";
            }
            else {
                $login_inc_aviso = "* No se encontr&oacute; el registro en la base de datos";
            }
        }
    }
    else {
        header("location:default.php");      
    }
    */       
?>