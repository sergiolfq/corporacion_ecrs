<?php
    $access_inc_nombre = "";    
    $access_inc_signedin = false;
    $access_inc_logout = !empty($_GET['logout']) ? $_GET['logout'] : false;
    
    $ocultar_deberes = isset($ocultar_deberes) ? $ocultar_deberes : false;
    
    if (!isset($_SESSION)) { 
        session_start(); 
    }
    // set timeout period in seconds
    $inactive = 1800;        
    // check to see if $_SESSION['timeout'] is set
    if(isset($_SESSION['timeout'])) {
        $session_life = time() - $_SESSION['timeout'];
        if($session_life > $inactive) { 
            //$access_inc_logout = true; //comentar para que la session la lleve la página principal    
        }
    }
    $_SESSION['timeout'] = time();      
   
    if($access_inc_logout) {
        //if(!empty($_SESSION['email'])) {
        session_unset(); 
        session_destroy();                                                                                     
        echo '<script type="text/javascript">window.location.replace("login.php");</script>';            
        //}
    }        
    else {        
        if(!empty($_SESSION['email'])) {
            $access_inc_nombre = $_SESSION['nombre'];
            $access_inc_signedin = true;
        }            
    }                 
?>