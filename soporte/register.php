<?php include("services/register_check.php"); ?>
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
        <title>Registro</title>

        <link href="css/estilos.css" type="text/css" rel="stylesheet" />  
        <link href="css/ecrs_estilos.css" rel="stylesheet" type="text/css" />      
        <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>        
        <script src="js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>        
        <script src="js/jquery.jCombo.min.js" type="text/javascript"></script>
        <script src="js/mascaras.js" type="text/javascript"></script>
        <script src="js/md5-min.js" type="text/javascript"></script>
    </head>
    <body oncontextmenu="return false;" style="margin-top: 0px; background: white;">
        <script type="text/javascript">
            $(document).ready(function() {
                    jQuery(function($) {
                            $("#pais").jCombo("services/get_countries.php", { 
                                    selected_value: "<?php echo $id_pais; ?>"
                            });
                            //-
                            $("#estado").jCombo("services/get_states.php?id=", { 
                                    parent: "#pais", 
                                    parent_value: "<?php echo $id_pais; ?>", 
                                    selected_value: "<?php echo $id_estado; ?>" 
                            });   
                            //-
                            $.validator.addMethod("valueNotEquals", function(value, element, arg){
                                    return arg != value;
                                }, "Value must not equal arg.");     
                            //-
                            $("#register_form").validate({
                                    rules: {
                                        rif: {
                                            required: true
                                        },
                                        razonsocial: {
                                            required: true
                                        },
                                        email: {
                                            required: true,
                                            email: true
                                        },
                                        password1: {
                                            required: true,
                                            minlength: 8
                                        },
                                        password2: {
                                            required: true,
                                            minlength: 8,
                                            equalTo: "#password1"
                                        },
                                        pais: { 
                                            valueNotEquals: 0 
                                        },
                                        estado: { 
                                            valueNotEquals: 0 
                                        },                                        
                                        telf1: "required"                                        
                                    },
                                    messages: {
                                        rif: " *",
                                        razonsocial: " *",
                                        email: {
                                            required: " *",
                                            email: " Coloque una direcci&oacute;n de correo v&aacute;lida"
                                        },
                                        password1: {
                                            required: " *",
                                            minlength: " La contrase&ntilde;a debe tener m&iacute;nimo 8 caracteres"
                                        },
                                        password2: {
                                            required: " *",
                                            minlength: " La contrase&ntilde;a debe tener m&iacute;nimo 8 caracteres",
                                            equalTo: " Los campos de contrase&ntilde;a no son iguales"
                                        },               
                                        pais: { 
                                            valueNotEquals: " *" 
                                        },                 
                                        estado: { 
                                            valueNotEquals: " *" 
                                        },                 
                                        telf1: " *"
                                    }
                            });  
                            //-
                            $("#rif").mask("J999999999");
                            //-
                            $("#telf1").mask("(999) 999-9999");  
                            $("#telf1").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });                                         
                            //-
                            $("#telf2").mask("(999) 999-9999");
                            $("#telf2").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });                              
                            //-
                            $("#telf3").mask("(999) 999-9999");
                            $("#telf3").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });                              
                            //-
                            $.mask.definitions['~'] = '[VEve]';
                            $("#text_ci").mask("~99.999.999");                   
                            //-
                            $("#razonsocial").keypress(function(event) {
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
                                        if (!nombres(String.fromCharCode(code)))
                                            event.preventDefault()
                                    }
                            });      
                            $("#razonsocial").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });  
                            //-
                            $("#ciudad").keypress(function(event) {
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
                                        if (!nombres(String.fromCharCode(code)))
                                            event.preventDefault()
                                    }                                
                            });
                            $("#ciudad").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });                             
                            //-
                            $("#email").blur(function(event) {
                                    //email(this)
                            });        
                            $("#email").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });  
                            //-
                            $("#password1").keydown(function(event) {       
                                    var clave = document.getElementById('password1');               
                                    if(clave.value.length > 12) {
                                        $("#aviso").html("* La clave debe tener una longitud m&aacute;xima de 12 caracteres"); 
                                    }
                                    else {
                                        $("#aviso").html(""); 
                                    }
                            });                             
                            $("#password1").keypress(function(event) {
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
                                            event.preventDefault()
                                    }
                            });  
                            $("#password1").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });                                           
                            //-
                            $("#password2").keydown(function(event) {       
                                    var clave = document.getElementById('password2');
                                    if(clave.value.length > 12) {
                                        $("#aviso").html("* La clave debe tener una longitud m&aacute;xima de 12 caracteres"); 
                                    }
                                    else {
                                        $("#aviso").html(""); 
                                    }
                            });                             
                            $("#password2").keypress(function(event) {
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
                                            event.preventDefault()
                                    }
                            });    
                            $("#password2").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });                                    
                            $("#password2").keydown(function(event) {
                                    //list all CTRL + key combinations you want to disable
                                    var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j');

                                    //if ctrl is pressed check if other key is in forbidenKeys array
                                    if (event.ctrlKey) {
                                        for (i = 0; i < forbiddenKeys.length; i++) {
                                            //case-insensitive comparation
                                            if (forbiddenKeys[i].toLowerCase() == String.fromCharCode(event.keyCode).toLowerCase()) {
                                                alert('Combinacion de teclas CTRL + '
                                                    + String.fromCharCode(event.keyCode)
                                                    + ' ha sido deshabilitada.');
                                                event.preventDefault()
                                            }
                                        }
                                    }
                            }); 
                            //-    
                            $("#pais").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });  
                            //-
                            $("#estado").keyup(function(event) {
                                    if(event.keyCode == 13){
                                        $("#ingresar").click();
                                    }
                            });                              
                            /*$("#pais").change(function(event) {
                            if(document.getElementById('pais').selectedIndex == 0){
                            $("#chk_pais").html("&nbsp;*");
                            event.preventDefault()
                            }
                            else $("#chk_pais").html("");                            
                            });
                            //-
                            $("#estado").change(function(event) {
                            if(document.getElementById('estado').selectedIndex == 0){
                            $("#chk_estado").html("&nbsp;*");
                            event.preventDefault()
                            }
                            else $("#chk_estado").html("");                            
                            });*/
                    });                 
            }); 

            function verify(){
                var pwfield = document.getElementById('password1');
                if(pwfield.value.length >= 8 && pwfield.value.length <= 12) {
                    var pwfield1 = document.getElementById('password1');
                    var pwfield2 = document.getElementById('password2');
                    pwfield1.value = rstr2hex(rstr_md5(rstr_md5(str2rstr_utf8(pwfield1.value))));
                    pwfield2.value = pwfield1.value;
                    return true;
                }                
                return false;                                                
            }
        </script>

        <form id="register_form" name="register_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table width="620" border="0" cellpadding="0" cellspacing="4" align="center">
                <tr>
                    <td>
                        <table class="TablaNormal" border="0" cellspacing="0" cellpadding="0" width="97%" align="left" id="Table1" style="z-index:102; text-align:left">
                            <tr>
                                <td>
                                    <?php include("controls/access.inc"); ?>                                                                                                
                                </td>
                            </tr>
                        </table>    
                    </td>
                </tr>              
                <tr>
                    <td>
                        <div align="center"> 
                            <table width="620" border="0" align="center" cellpadding="0" cellspacing="1">
                                <tr>               
                                    <th class="productos_round_box">
                                        
                                        <table class="TablaNormal" align="left" id="Table1" style="z-index:102; text-align:left" cellspacing="1" cellpadding="1" width="100%" border="0">
                                            <tr>
                                                <th colspan="3" height="48" align="left" scope="col"><span class="trebuchet_rojo20">Actualizar Datos del <?php echo $enaj_update; ?></span></th>
                                            </tr>                                                                                    
                                            <tr align="left">
                                                <td width="120">
                                                    &nbsp; RIF:&nbsp;</td>
                                                <td style="color: red;">
                                                    <input id="rif" name="rif" type="text" class="TextoCajaNormal" style="width:216px" maxlength="40" required="true" value="<?php echo $rif; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp; Raz&oacute;n Social:&nbsp;</td>
                                                <td style="color: red;">
                                                    <input id="razonsocial" name="razonsocial" type="text" class="TextoCajaNormal" style="width:216px" maxlength="100" required="true" value="<?php echo $razon_social1; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp; Email:&nbsp;</td>
                                                <td style="color: red;">
                                                    <input id="email" name="email" type="text" class="TextoCajaNormal" style="width:216px" maxlength="40" required="true"/>
                                                </td>
                                            </tr>
                                            <tr style="visibility: hidden; display: none;">
                                                <td>
                                                    &nbsp; Contrase&ntilde;a:&nbsp;</td>
                                                <td style="color: red;">
                                                    <input id="password1" name="password1" type="password" class="TextoCajaNormal" style="width:216px" maxlength="50" required="true"/>
                                                </td>
                                            </tr>
                                            <tr style="visibility: hidden; display: none;">
                                                <td>
                                                    &nbsp; Repetir Contrase&ntilde;a:&nbsp;</td>
                                                <td style="color: red;">
                                                    <input id="password2" name="password2" type="password" class="TextoCajaNormal" style="width:216px" maxlength="50" required="true"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp; Pa&iacute;s:&nbsp;</td>
                                                <td style="color: red;">
                                                    <select id="pais" name="pais" class="ComboNormal"></select><span id="chk_pais" name="chk_pais" style="color: red;"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp; Estado:&nbsp;</td>
                                                <td style="color: red;">
                                                    <select id="estado" name="estado" class="ComboNormal"></select><span id="chk_estado" name="chk_estado" style="color: red;"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp; Ciudad:&nbsp;</td>
                                                <td>
                                                    <input id="ciudad" name="ciudad" type="text" class="TextoCajaNormal" style="width:216px" maxlength="40" value="<?php echo $ciudad; ?>"/>
                                                </td>
                                            </tr>     
                                            <tr valign="top">
                                                <td>
                                                    &nbsp; Direcci&oacute;n:&nbsp;</td>
                                                <td>
                                                    <textarea id="direccion" name="direccion" class="TextoCajaNormal" rows="3" cols="1" style="width:216px; border: 1px solid #666666;" maxlength="40"></textarea>                                                        
                                                </td>
                                            </tr>                                                                                                 
                                            <tr>
                                                <td>
                                                    &nbsp; Telf. Casa:&nbsp;</td>
                                                <td style="color: red;">
                                                    <input id="telf1" name="telf1" type="text" class="TextoCajaNormal" style="width:216px" required="true" value="<?php echo $telefono1; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp; Telf. Celular:&nbsp;</td>
                                                <td>
                                                    <input id="telf2" name="telf2" type="text" class="TextoCajaNormal" style="width:216px" value="<?php echo $telefono2; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp; Telf. Trab.:&nbsp;</td>
                                                <td>
                                                    <input id="telf3" name="telf3" type="text" class="TextoCajaNormal" style="width:216px" value="<?php echo $telefono3; ?>"/>
                                                </td>
                                            </tr>                                    
                                            <tr>
                                                <td>
                                                    &nbsp;</td>
                                                <td>
                                                    <input id="ingresar" name="ingresar" type="submit" value="Actualizar Datos" class="BotonNormal" height="23px" onclick="return verify();" />
                                                </td>
                                            </tr>                                       
                                            <tr>
                                                <td>
                                                    &nbsp;</td>
                                                <td style="color: red;">
                                                    <label id="aviso"><?php echo $aviso; ?></label>
                                                </td>
                                            </tr>                                       
                                        </table>
                                        
                                    </th>        
                                </tr>
                            </table>            
                        </div>    
                    </td>
                </tr>
            </table>            
        </form>
    </body>
</html>
