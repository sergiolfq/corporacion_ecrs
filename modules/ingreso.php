<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(31);?></th>
              </tr>
          </table>
            <table width="991" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
              <tr>

              
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Ingreso")?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>
              
                            
            </tr>
        </table>
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col" align="left"> 
                 
<script language="javascript" type="text/javascript">
function dologin2(){
    new Ajax.Request('ajax_resp/login.php',{method:'post',parameters: 'email=' + $('email').value + '&pass=' + $('pass').value.md5(),onComplete: function(obj) {
        respuesta = obj.responseText;
        if(respuesta == "2") {
        <?php if(isset($_GET["fromurl"])){ ?>
            document.location='<?=urldecode($_GET["fromurl"])?>';
        <?php }else{ ?>
            document.location='/?module=account';
        <?php }?>
            return false;
        // condición else if agregada por Luis Jiménez    
        } else if(respuesta == "3") {            
            document.location='/?module=account';
        } else {
            $('warning2').innerHTML = "<div id='dclave'>" + respuesta + "</div>";
             Effect.Appear('warning2');
             return false;
        }
    }});
    return false;
}</script> 
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td class="tablaBgPuntos">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF" class="registroTabla">
      <tr>
        <td width="50%" valign="top" bgcolor="#FFFFFF" class="registroTabla_borde"><p class="titulorojo_destacado"><?=_("Cliente registrado")?></p>
          
          <form action="" name="form_login" id="form_login" method="post" onSubmit="dologin2(); return false">
      <table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
	  <tr>
          <td colspan="2" id="mensaje_alerta"><div id="warning2" style="display:none; background-color:#FFFF00; color:#990000; padding:3px;"></div></td>
        </tr>
        <tr>
          <td width="30%" class="bioboton"><?=_("Email")?>:</td>
          <td><input name="email" type="text" class="box" id="email" size="20" /></td>
        </tr>
        <tr>
          <td class="bioboton"><?=_("Contraseña")?>:</td>
          <td><input name="pass" type="password" class="box" id="pass" size="10" maxlength="10" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="30"><input name="Submit" type="submit" id="submit" value="<?=_("Ingresar")?>" class="botoncot" /></td>
        </tr>
        <tr>
          <td height="60" colspan="2"><a href="?module=forgot" class="azuloscuro"><?=_("Ha olvidado su contraseña?")?> <br />
            <?=_("Siga este enlace y se la enviamos")?></a> </td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>  
	  </form>    
		  </td>
        <td width="50%" valign="top" bgcolor="#FFFFFF"><p class="titulorojo_destacado"><?=_("Nuevo Cliente")?></p>
          
		  <p ><?=_("Soy un cliente nuevo")?>.

<?=_(" Al crear una cuenta podrá solicitar sus pedidos y cotizaciones, además, si es usted un Distribuidor, CSA y/o Técnico Autorizado podrá encontrar manuales, tutoriales, drivers, material de mercadeo, soporte y mucho más, regístrese ahora haciendo")?> <a href="?module=registro&fromurl=<?=$_GET["fromurl"]?>" class="rojosubrayado"><?=_("click aquí")?></a>. </td>
      </tr>
    </table></td>
  </tr>
</table>

                
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>