<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(4);?></th>
              </tr>
          </table>
        <table width="985" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
            <tr>                            
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Registro de usuario")?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>                                          
            </tr>
        </table>        
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col" align="left">  
				
<script language="javascript" type="text/javascript">                
 <?php
if(!isset($_SESSION["user"])){
	die("Error de acceso, si es la primera vez que ve este mensaje intente identificarse con su email y su password nuevamente");
}else{
	if(isset($_POST["edtregistroForm"]) && intval($_POST["edtregistroForm"])==1){ //esta editando los datos de su cuenta
		$arrTemp=$_POST;
		$arrTemp["pk_usuario"]=intval($_SESSION["user"]["pk_usuario"]);
        $arrTemp["fk_usuario_tipo"]=intval($_SESSION["user"]["fk_usuario_tipo"]);
        $arrTemp["fk_estatus"]=1; //agregado por Luis Jiménez, 1 es válido
		$Shop->editUsuario($arrTemp);
		$respuesta = $Shop->login('',intval($_SESSION["user"]["pk_usuario"]));
        if($respuesta == 2) { ?>
            document.location='<?=urldecode("/?module=enajenaciones")?>';
        <?php }        
	}	
?>
</script> 
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" class="tablaBgPuntos">
  <tr>
    <td bgcolor="#FFFFFF">
	<form id="chgpass" name="chgpass" method="post" action=""  onsubmit="changePass(); return false">

<table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
            <td colspan="2"><div class="titulorojo_destacado"><?=_("Cambiar Contraseña")?></div></td>
          </tr>
		   <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%" height="10"><div id="mensajechg" style="color:#FF0000; font-weight:bolder; background-color:#FFFF00; text-align:center; line-height:150%"></div></td>
              </tr>
            </table></td>
    </tr>
         
          <tr>
            <td width="35%" valign="top" class="bioboton"><?=_("Contraseña Anterior")?>: </td>
            <td><input name="actual" type="password" id="actual" size="15" /></td>
          </tr>
          
          <tr>
            <td valign="top" class="bioboton"><?=_("Nueva Contraseña")?>: </td>
            <td><input name="newpass1" type="password" id="newpass1" class="required" size="15" /></td>
          </tr>
          <tr>
            <td valign="top" class="bioboton"><?=_("Repetir nueva Contraseña")?></td>
            <td><input name="pass2" type="password" id="pass2" class="required pass2" size="15" /></td>
          </tr>
          
          <tr>
            <td colspan="2" align="center" valign="top">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="<?=_("Enviar")?>"  class="botoncot" /></td>
          </tr>
  </table>
  
   <script type="text/javascript">
				   var valid1 = new Validation('chgpass', {immediate : true,focusOnError : true});
					 Validation.add('pass2', '<?=_("La Contraseña no concuerda")?>', {
					 equalToField : 'newpass1' // value is equal to the form element with this ID
				
				});
				
				function changePass(){
					var result = valid1.validate();
					if(result){
						new Ajax.Updater('mensajechg','ajax_resp/changePass.php',{method:'post',evalScripts: true, parameters:Form.serialize("chgpass")});
					}
				
				}
				  </script>
</form>
	</td>
  </tr>
</table>
<br />
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" class="tablaBgPuntos">
  <tr>
    <td bgcolor="#FFFFFF">
	<form action="?module=account" method="post" name="registro" id="registro" onsubmit="registrar(); return false">
		  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="3">
		  <tr>
            <td colspan="2"><div class="titulorojo_destacado"><?=_("Cambiar datos de mi cuenta")?> </div></td>
          </tr>
		  <tr>
            <td colspan="2"  style="text-align: justify">&nbsp;</td>
          </tr>
			<tr>
			  <td width="35%" class="bioboton"><?=_("Email")?>:</td>
			  <td class="azuloscuroG"><?=$_SESSION["user"]["email"]?>
			    <input type="hidden" name="email" value="<?=$_SESSION["user"]["email"]?>" />
			    <input type="hidden" name="edtregistroForm" value="1" />
			    <input type="hidden" name="tipo_persona" value="<?=intval($_SESSION["user"]["tipo_persona"])?>" /></td>
			</tr>
		<?php if(intval($_SESSION["user"]["tipo_persona"])==1){?>
			<tr>
			  <td class="bioboton"><?=_("Nombres")?>:</td>
			  <td><input name="nombres" type="text" id="nombres" class="required" value="<?=$_SESSION["user"]["nombres"]?>" /></td>
			</tr>
			<tr>
			  <td class="bioboton"><?=_("Apellidos")?>:</td>
			  <td><input name="apellidos" type="text" id="apellidos" class="required" value="<?=$_SESSION["user"]["apellidos"]?>" /></td>
			</tr>
			<tr>
			  <td class="bioboton"><?=_("Cédula")?>:</td>
			  <td><input name="cedula_rif" type="text" id="cedula_rif" class="required" value="<?=$_SESSION["user"]["cedula_rif"]?>" /></td>
			</tr>
		<?php }else{ ?>
		<tr>
			  <td class="bioboton"><?=_("Razón social")?>:</td>
			  <td><input name="nombres" type="text" id="nombres" class="required" value="<?=$_SESSION["user"]["nombres"]?>" /></td>
			</tr>
			<tr> 
			  <td class="bioboton">RIF/RUT:</td>
			  <td><input name="cedula_rif" type="text" id="cedula_rif" class="required" value="<?=$_SESSION["user"]["cedula_rif"]?>" /></td>
			</tr>
			<tr>
			  <td class="bioboton"><?=_("Dirección fiscal")?>:</td>
			  <td><textarea name="direccion" cols="40" rows="5" class="required" id="direccion"><?=$_SESSION["user"]["direccion"]?></textarea></td>
			</tr>
			<tr>
			  <td><?=_("Persona de contacto")?>:</td>
			  <td><input name="apellidos" type="text" id="apellidos" class="required" value="<?=$_SESSION["user"]["apellidos"]?>" /></td>
			</tr>
			
		
		<?php } ?>
			<tr>
			  <td><?=_("Teléfono principal")?>:</td>
			  <td><input name="telefono1" type="text" id="telefono1" class="required" value="<?=$_SESSION["user"]["telefono1"]?>" /></td>
			</tr>
			<tr>
			  <td><?=_("Teléfono secundario")?>:</td>
			  <td><input name="telefono2" type="text" id="telefono2" value="<?=$_SESSION["user"]["telefono2"]?>" /></td>
			</tr>
			<tr>
			  <td><?=_("Fax")?>:</td>
			  <td><input name="fax" type="text" id="fax" value="<?=$_SESSION["user"]["fax"]?>" /></td>
			</tr>
			 <tr>
							<td valign="top"><?=_("País")?>:</td>
							<td valign="top"><select name="fk_pais" id="fk_pais" onChange="new Ajax.Updater('selEstado','ajax_resp/registro_selects.php',{method:'post',evalScripts: true,parameters:'fk_pais=' + this.value}); $('contr').value=this.value">
							<option value=""><?=_("Seleccione")?></option>
							  <?php $Common->llenarComboDb(TBL_PAISES,"pk_pais","pais","",0,intval($_SESSION["user"]["fk_pais"]),"","pais asc"); ?>
								</select><input name="contr" type="hidden" id="contr" value="<?=intval($_SESSION["user"]["fk_pais"])?>" class="required validate-number" /> </td>
			</tr>
						  <tr>
							<td valign="top"><?=_("Estado")?>:</td>
							<td valign="top"><span id="selEstado">
							  <select name="fk_estado" id="fk_estado" onChange="new Ajax.Updater('selCiudad','/ajax_resp/registro_selects.php',{method:'post',parameters:'fk_estado=' + this.value}); $('edo').value=this.value">
							<option value=""><?=_("Seleccione")?></option>
							<?php $Shop->llenarComboDb(TBL_ESTADOS,"pk_estado","estado","fk_pais",intval($_SESSION["user"]["fk_pais"]),intval($_SESSION["user"]["fk_estado"]),"","estado asc"); ?>
							</select></span><input name="edo" type="hidden" id="edo" value="<?=intval($_SESSION["user"]["fk_estado"])?>" class="required validate-number" /></td>
						  </tr>
						  <tr>
							<td valign="top"><?=_("Ciudad")?>:</td>
							<td valign="top"><span id="selCiudad">
							  <select name="fk_ciudad" id="fk_ciudad" onchange="$('cty').value=this.value">
							<option value=""><?=_("Seleccione")?></option>
							<?php $Shop->llenarComboDb(TBL_CIUDADES,"pk_ciudad","ciudad","fk_estado",intval($_SESSION["user"]["fk_estado"]),intval($_SESSION["user"]["fk_ciudad"]),"","ciudad asc"); ?>
							</select></span><input name="cty" type="hidden" id="cty" value="<?=intval($_SESSION["user"]["fk_ciudad"])?>" class="required validate-number" /></td>
						  </tr>
						 
			<tr>
			  <td colspan="2" align="center"><br />
			  <input type="submit" name="Submit2" value="<?=_("Enviar")?>"  class="botoncot" /></td></tr>
		  </table>
			<script type="text/javascript">
			function registrar(){
		
				var result = valid.validate();
				if(result){
					registro.submit();
				}else{
					return false;
				}
		
			}
	
		  var valid = new Validation('registro', {immediate : true,focusOnError : true});
		</script>
</form>
	</td>
  </tr>
</table>

<?php } ?>
                
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>