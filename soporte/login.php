<?php include("services/login_inc_check.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Lang" content="es" />
        <meta name="author" content="" />
        <meta http-equiv="Reply-to" content="@.com" />
        <meta name="generator" content="PhpED 6.0" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="creation-date" content="06/01/2011" />
        <meta name="revisit-after" content="15 days" />      
        <title>Ingresar</title>         
    </head>
    <body style="margin-top: 0px;">                                        
        <link href="css/ecrs_estilos.css" type="text/css" rel="stylesheet" />
        <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>        
        <script src="js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
        <script src="js/md5-min.js" type="text/javascript"></script>
        <script src="js/mascaras.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                    jQuery(function($) {
                            $("#login_inc_form").validate({
                                    rules: {
                                        rif: {
                                            required: true
                                        },
                                        clave: {
                                            required: true,
                                            minlength: 8
                                        }    
                                    },
                                    messages: {
                                        rif: {
                                            required: " *"
                                        },
                                        clave: {
                                            required: " *",
                                            minlength: " x"
                                        }   
                                    }
                            });  
                            //-                    
                            $.mask.definitions['~'] = '[JGVEPjgvep]';
                            $("#rif").mask("~999999999");                       
                            //-                     
                            $("#rif").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });  
                            //-    
                            $("#clave").keydown(function(event) {       
                                    var clave = document.getElementById('clave');               
                                    if(clave.value.length > 12) {
                                        $("#aviso").html("* La clave debe tener una longitud m&aacute;xima de 12 caracteres"); 
                                    }
                                    else {
                                        $("#aviso").html(""); 
                                    }
                            }); 
                            $("#clave").keypress(function(event) {   
                                    // Allow: backspace, delete, tab, escape, and enter
                                    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                                        // Allow: Ctrl+A
                                        (event.keyCode == 65 && event.ctrlKey === true) || 
                                        // Allow: home, end, left, right
                                        (event.keyCode >= 35 && event.keyCode <= 39)) {
                                        // let it happen, don't do anything
                                        return;
                                    }
                                    else {
                                        code = event.charCode || event.keyCode; // keyCode devuelve 0 en FF 
                                        if (!identificador(String.fromCharCode(code)))
                                            event.preventDefault();
                                    }                                       

                            });  
                            $("#clave").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            }); 
                    });                 
            });
        </script>

        <form id="login_inc_form" name="login_inc_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
                <tr>
                    <td class="tablaBgPuntos">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF" class="registroTabla">
                            <tr>
                                <td width="50%" valign="top" bgcolor="#FFFFFF" class="registroTabla_borde"><p class="titulorojo_destacado"><b>Cliente registrado</b></p>
                                    <table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
                                        <tr>
                                            <td colspan="2" id="mensaje_alerta"><div id="warning2" style="display:none; background-color:#FFFF00; color:#990000; padding:3px;"></div></td>
                                        </tr>
                                        <tr>
                                            <td width="30%" class="bioboton"><b>RIF:</b></td>
                                            <td><input name="rif" style="text-transform:uppercase;" type="text" class="box" id="rif" size="20" /></td>
                                        </tr>
                                        <tr>
                                            <td class="bioboton"><b>Contrase&ntilde;a:</b></td>
                                            <td><input name="clave" type="password" class="box" id="clave" size="10" /></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td height="30"><input name="ingresar" type="submit" id="ingresar" value="Ingresar" class="botoncot" onclick="return verify('clave');"/></td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td height="60" colspan="2"><a href="#?module=forgot" class="azuloscuro"><b>Ha olvidado su contraseña? </b>
                                                <br />
                                                <b>Siga este enlace y se la enviamos</b></a></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2" style="color: red;">
                                                <label id="aviso"><?php echo $login_inc_aviso; ?></label>
                                            </td>
                                        </tr>
                                    </table>  
                                </td>
                                <td width="50%" valign="top" bgcolor="#FFFFFF"><p class="titulorojo_destacado"><b>Nuevo Cliente</b></p>
                                    <p><b>Soy un nuevo cliente. Al crear una cuenta podrá solicitar sus cotizaciones, Además, si es un técnico o un distribuidor autorizado podrá encontrar Manuales, tutoriales, drivers, material de mercadeo, soporte y mucho más, regístrese ahora.</b></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>            
        </form>

    </body>
</html>