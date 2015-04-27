<?php include("services/login_inc_check.php"); ?>

<link href="css/estilos.css" type="text/css" rel="stylesheet" />
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>        
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
<script src="js/mascaras.js" type="text/javascript"></script>
<script src="js/md5-min.js" type="text/javascript"></script>

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

    function verify(){
        var pwfield = document.getElementById('clave');
        if(pwfield.value.length >= 8 && pwfield.value.length <= 12) {
            pwfield.value = rstr2hex(rstr_md5(rstr_md5(str2rstr_utf8(pwfield.value))));   
            return true;
        }                
        return false;
    }
</script>

<form id="login_inc_form" name="login_inc_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table width="800" border="0" cellpadding="0" cellspacing="4" align="center">
        <tr>
            <td>
                <?php include("controls/access.inc"); ?>                                                       
                <br />
            </td>
        </tr>
        <tr>
            <td>
                <?php include("controls/menu.inc"); ?>
            </td>
        </tr>
        <tr>
            <td>
                <div align="center"> 
                    <table width="350" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#EEEEEE">
                        <tr>
                            <td>
                                <fieldset>
                                    <table class="TablaNormal" align="left" style="z-index:102; text-align:left" width="100%" border="0" cellpadding="1" cellspacing="1">
                                        <tr>
                                            <td width="70">&nbsp; RIF:&nbsp;</td>
                                            <td style="color: red;"><input id="rif" name="rif" type="text" class="TextoCajaNormal" style="text-transform:uppercase; width:216px" maxlength="40" required="true" value="<?php echo $login_inc_rif; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp; Contrase&ntilde;a:&nbsp;</td>
                                            <td style="color: red;"><input id="clave" name="clave" type="password" class="TextoCajaNormal" style="width:216px" maxlength="50" required="true"></td>
                                        </tr>
                                        <tr align="center">                           
                                            <td colspan="2"><input id="ingresar" name="ingresar" type="submit" value="Ingresar" class="BotonNormal" height="23px" onclick="return verify();"></td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="2" style="color: red;">
                                                <label id="aviso"><?php echo $login_inc_aviso; ?></label>
                                            </td>
                                        </tr>                           
                                    </table>
                                </fieldset>
                            </td>
                        </tr>
                    </table>
                </div>    
            </td>
        </tr>
    </table>
</form>