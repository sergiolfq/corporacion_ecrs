<?php    
    if (!isset($_SESSION)) { 
        
        
        session_start();               
    } 
   
    /*
    $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
    $password = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
    $iframe_auth = !empty($_REQUEST['iframe_auth']) ? $_REQUEST['iframe_auth'] : '';
    //echo $username."\n";
    //echo $password."\n";
    //echo $iframe_auth;
    */
?>

    <link href="styles/default/bootstrap.css" rel="stylesheet">
    <link href="styles/default/font-awesome.css" rel="stylesheet">
    <link href="styles/default/fontello.css" rel="stylesheet">
    <link href="styles/default/settings.css" media="screen" rel="stylesheet">
    <link href="styles/default/extralayers.css" media="screen" rel="stylesheet">
    <link href="styles/default/magnific-popup.css" rel="stylesheet">
    <link href="styles/default/animations.css" rel="stylesheet">
    <link href="styles/default/owl.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/default/normalize-1.css" />
    <link href="styles/default/demo-1.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/default/demo-1.css" />
    <link rel="stylesheet" type="text/css" href="styles/default/tabs.css" />
    <link rel="stylesheet" type="text/css" href="styles/default/tabstyles.css" />
    <!--<link href="/styles/style.css" rel="stylesheet">-->
    <link href="styles/default/style-switcher.css" rel="stylesheet">
    <link href="styles/default/custom.css" rel="stylesheet">


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<img src="images/imagen_enajenacion.jpg" width="975" height="210"><br><br>

    <body style="background: white;">
        <form name="default_form">
            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center">                    
                <tr>   
                    <h2 class="page-title">DIMAFI</h2>
                    <div class="separator-2"></div>
                    <br>
                        <div class="row">
                            <center><div class="col-md-12">


                                    <div class="col-md-12 " style="padding-left: 25px; padding-top: 10px;">



                                        <section>
                                            <div style="padding-bottom: 54px;">
                                                
                                                <?php 
                                                    $permisos = '';
                                                    $tipo_usuario = '';
                                                    $permiso_usuario = '';
                                                    $permiso_vacio = '';
                                                    $link_bloqueado = '';
                                                    $link_desabilitado = '';
                                                    $nombre_usuario = '';
                                                    
                                                    $tipo_usuario = $_SESSION["user"]["fk_usuario_tipo"]; 
                                                
                                                    // Escenario N° 1 Proveedor - Usuario
                                                    if($tipo_usuario == 8){
                                                        $permiso_usuario = 'enajenar_prove_usuario.php';
                                                        $permiso_vacio = 'enajenar_prove_vacio.php';
                                                        $link_desabilitado = 'a-disable';
                                                    }
                                                    // Escenario N° 2 Proveedor - Distribuidor
                                                    if($tipo_usuario == 6){
                                                        $permiso_usuario = 'enajenar_provee_dist.php';
                                                        $permiso_vacio = 'enajenar_prove_vacio.php';
                                                        $link_desabilitado = 'a-disable';
                                                    }
                                                    // Escenario N° 3 Distribuidor - Usuario
                                                    if($tipo_usuario == 2){
                                                        $nombre_usuario = 'para los Distribuidores';
                                                        $permiso_usuario = 'enajenar.php';
                                                        $permiso_vacio = 'enagenaciones_vacias.php';
                                                        $link_desabilitado = 'a-disable';
                                                    }
                                                    // Escenario N° 4 Proveedor - Tecnico
                                                    if($tipo_usuario == 4){
                                                        $permiso_usuario = 'enajenar_prove_tecnico.php';
                                                        $permiso_vacio = 'enajenar_prove_vacio.php';
                                                        $link_desabilitado = 'a-disable';
                                                    }
                                                    
                                                    if($tipo_usuario == 7){
                                                        $permisos = 'historial.php';
                                                        $link_bloqueado = 'a-disable';
                                                    }else{
                                                        $permisos = '';
                                                    }
                                                    
                                                    
                                                    
                                                ?>

                                                <a href="<?php echo $permiso_usuario; ?>" id="enajenar" class="btn btn-white-2 <?php echo $link_bloqueado; ?>" style="background: white;"><img src="images/portfolio1.png" style="padding-left: 32px;"><br><b> Declarar <br>Enajenaciones </b><br><br></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                
                                                <a href="<?php echo $permiso_vacio; ?>" id="enajenar_vacio" class="btn btn-white-2 <?php echo $link_bloqueado; ?>" style="background: white;"><img src="images/portfolio2.png" style="padding-left: 24px;"><br> <b>Declarar<br> Enajenaciones Vacias</b><br><br></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                
                                                <a href="<?php echo $permisos; ?>" id="consulta_admin" class="btn btn-white-2 <?php echo $link_desabilitado; ?>" bloqued style="background: white;"><img src="images/portfolio3.png" style="padding-left: 24px;"><br><b> Consultas</b><br><br><br></a>

                                                
                                            </div><!-- /tabs -->
                                            
                                            <?php if($tipo_usuario == 7){ ?>
                                                <div class="alert alert-error" id="error_permiso" style="margin-right: 75px; margin-left: 75px;">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <center>Las Opciones para Enajenar se encuantran Inhabilitada para los Administradores</center>
                                                </div>
                                            <?php } ?>
                                            
                                            <?php if($tipo_usuario == 2 || $tipo_usuario == 4 || $tipo_usuario == 6 || $tipo_usuario == 8){ ?>
                                                <div class="alert alert-error" id="error_permiso" style="margin-right: 75px; margin-left: 75px;">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <center>La Opción de Consultas se encuantra Inhabilitada <?php echo $nombre_usuario; ?></center>
                                                </div>
                                            <?php } ?>
                                            
                                        </section>
                                    </div>

                                </div><!-- /container -->
                                <div class="separator-2"></div>


                        </div></center>
                </tr>
            </table>
        </form>
    </body>
</html>


<script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/default/bootstrap.js"></script>
<script type="text/javascript" src="javascript/default/modernizr.js"></script>  
<script type="text/javascript" src="javascript/default/isotope.pkgd.js"></script>
<script type="text/javascript" src="javascript/default/owl.js"></script>
<script type="text/javascript" src="javascript/default/jquery.magnific-popup.js"></script>
<script type="text/javascript" src="javascript/default/jquery (1).js"></script>
<script type="text/javascript" src="javascript/default/jquery (2).js"></script>
<script type="text/javascript" src="javascript/default/jquery.parallax-1.1.js"></script>
<script type="text/javascript" src="javascript/default/jquery (3).js"></script>
<script type="text/javascript" src="javascript/default/template.js"></script>
<script type="text/javascript" src="javascript/default/custom.js"></script>
<script type="text/javascript" src="javascript/default/permisos.js"></script>
