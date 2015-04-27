
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(31);?></th>
              </tr>
          </table>
        
            <table width="985" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
              <tr>                            
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Registro de Usuario")?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>                                              
            </tr>
        </table>        
        
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col" align="left"> 
                <div id="registroForm"  class="tablaBgPuntos">
	<?php
	if(!isset($_POST["tipo_persona"])){
	?>
		<form action="" method="post" name="registro" id="registro">
		  <table width="100%" border="0" cellspacing="2" cellpadding="8">
			<tr>
			  <td height="30" class="azuloscuroG"><?=_("Seleccione tipo de persona a registrar")?>: </td>
			</tr>
			<tr>
			  <td height="30"><input name="tipo_persona" type="radio" value="1" checked="checked" /> 
				<strong class="titRojo"><?=_("Persona Natural  / Particular")?></strong><br /><br />

				 <?=_(" Este  registro es para cualquier persona que no pertenezca a alguna empresa o  corporación. (Ejemplo: amas de casa, estudiantes, o particular)")?> <br />
				  <br /><br />

				  <input name="tipo_persona" type="radio" value="2" /> 
			      <strong class="titRojo"><?=_("Persona Jurídica / Empresa")?> </strong>
			      <input type="hidden" name="fromurl" value="<?=$_GET["fromurl"]?>" />
			  <br /><br />

			 <?=_("Si  Ud. va a registrar a su Empresa y es Ud. el contacto de la misma, esta  opción es la correcta. (Ejemplo: administrador, contacto del  departamento de compras etc.)")?></td>
			</tr>
			<tr>
			  <td height="30" align="center"><input type="submit" name="Submit" value="<?=_("Siguente")?>"  class="botoncot"/></td>
			</tr>
		  </table>
		</form>
	<?php
	}else{
	?>
		<form action="" method="post" name="registro" id="registro" onSubmit="registrar(); return false">
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
			<tr>
			  <td width="40%" valign="top" class="bioboton"><?=_("Email")?>:</td>
			  <td width="60%"><input name="email" type="text" class=" validate-email comprueba-mail" id="email" size="30">
			  <input type="hidden" name="registroForm" value="1" />
			  <input type="hidden" name="tipo_persona" value="<?=intval($_POST["tipo_persona"])?>" /><input type="hidden" name="fromurl" value="<?=$_POST["fromurl"]?>" /></td>
			</tr>
			<tr>
			  <td valign="top" class="bioboton"><?=_("Contraseña")?>:</td>
			  <td><input name="pass" type="password" class=" pass1" id="pass" size="30" /></td>
			</tr>
	<?php if(intval($_POST["tipo_persona"])==1){?>
			<tr>
			  <td valign="top" class="bioboton"><?=_("Nombres")?>:</td>
			  <td><input name="nombres" type="text" id="nombres" size="30" /></td>
			</tr>
			<tr>
			  <td valign="top" class="bioboton"><?=_("Apellidos")?>:</td>
			  <td><input name="apellidos" type="text" id="apellidos" size="30" /></td>
			</tr>
			<tr>
			  <td valign="top" class="bioboton">
			   <?php if($_SESSION["fk_pais_seleccionado"]!=2 && $_SESSION["fk_pais_seleccionado"]!=3){ ?>
			  <?=_("Cédula")?>:
              <?php }else{ ?>
              ID:
              <?php } ?>
              </td>
			  <td><input name="cedula_rif" type="text" style="text-transform: uppercase;" id="cedula_rif" size="30" />&nbsp;<label><i>(ej: V01234567)</i></label></td>
			</tr>
            <script>
            MaskedInput.definitions['a'] = '[VEve]'; 
            new MaskedInput('#cedula_rif', 'a99999999');
            </script>                          
	<?php }else{ ?>
		<tr>
			  <td valign="top" class="bioboton"><?=_("Razón social")?>:</td>
			  <td><input name="nombres" type="text" id="nombres" size="30" /></td>
			</tr>
            <?php if($_SESSION["fk_pais_seleccionado"]!=2 && $_SESSION["fk_pais_seleccionado"]!=3){ ?>
			<tr>
			  <td valign="top" class="bioboton">RIF:</td>
			  <td><input name="cedula_rif" type="text" style="text-transform: uppercase;" id="cedula_rif" size="30" />&nbsp;<label><i>(ej: J123456789)</i></label></td>
			</tr>
            <script>
			MaskedInput.definitions['a'] = '[JGjg]'; 
            new MaskedInput('#cedula_rif', 'a999999999');
            </script>
            <?php } ?>
			<tr>
			  <td valign="top" class="bioboton"><?=_("Dirección fiscal")?>:</td>
			  <td><textarea name="direccion" cols="30" rows="5" id="direccion"></textarea></td>
			</tr>
			<tr>
			  <td valign="top" class="bioboton"><?=_("Persona de contacto")?>:</td>
			  <td><input name="apellidos" type="text" id="apellidos" size="30" /></td>
			</tr>
			
		
	<?php } ?>
        <tr>
			  <td valign="top" class="bioboton"><?=_("Tipo de cliente")?>:</td>
			  <td>
              <select disabled="true" name="fk_usuario_tipo" id="fk_usuario_tipo" onChange="$('tblusu').value=this.value">
              <option value="1" selected=""><?=_("Cliente Final")?></option>
             
              <?php $salida =  $Common->llenarComboDb(TBL_USUARIOS_TIPO,"pk_usuario_tipo","tipo","",0,0,"","pk_usuario_tipo asc");
              //class="required validate-number"
              
              
              ?> 
             
              
              </select><input name="tblusu" type="hidden" id="tblusu" value="1" class=" validate-number" />
              </td>
              
			</tr>
         
			<tr>
			  <td valign="top" class="bioboton"><?=_("Teléfono principal")?>:</td>
			  <td><input name="telefono1" type="text" id="telefono1" size="30" /></td>
			</tr>
			<tr>
			  <td valign="top" class="bioboton"><?=_("Teléfono secundario")?>:</td>
			  <td><input name="telefono2" type="text" id="telefono2" size="30" /></td>
			</tr>
			<tr>
			  <td valign="top" class="bioboton"><?=_("Fax")?>:</td>
			  <td><input name="fax" type="text" id="fax" size="30" /></td>
			</tr>
			 <tr>
							<td valign="top" class="bioboton"><?=_("País")?>:</td>
				<td valign="top"><select name="fk_pais" id="fk_pais" onChange="new Ajax.Updater('selEstado','ajax_resp/registro_selects.php',{method:'post',evalScripts: true,parameters:'fk_pais=' + this.value}); $('contr').value=this.value">
							<option value="0"><?=_("Seleccione")?></option>
							  <?php $Common->llenarComboDb(TBL_PAISES,"pk_pais","pais","",0,0,"","pais asc"); ?>
								</select><input name="contr" type="hidden" id="contr" value="" class="validate-number" /> </td>
			</tr>
						  <tr>
							<td valign="top" class="bioboton"><?=_("Estado")?>:</td>
						  <td valign="top"><span id="selEstado">
							  <select name="fk_estado" id="fk_estado">
							<option value="0"><?=_("Seleccione")?></option></select></span><input name="edo" type="hidden" id="edo" value="" class="validate-number" /></td>
						  </tr>
						  <tr>
							<td valign="top" class="bioboton"><?=_("Ciudad")?>:</td>
						  <td valign="top"><span id="selCiudad">
							  <select name="fk_ciudad" id="fk_ciudad">
							<option value="0"><?=_("Seleccione")?></option></select></span><input name="cty" type="hidden" id="cty" value="" class="validate-number" /></td>
						  </tr>
						  <tr>
							<td valign="top" class="bioboton"><?=_("¿Cómo conoció esta página?")?></td>
						  <td valign="top"><input name="proveniente" type="text" id="proveniente" size="40" /></td>
						  </tr>
						  <tr>
			  <td colspan="2">
			    <div class="azulclaro" id="daceptar">
					  <input name="envios" type="checkbox" id="envios" value="true"/>
					  <a id="linkbase"></a>
<?=_("Al marcar esta casilla Ud. acepta las <a href='?module=nosotros&i=6' target='_blank'>Políticas de privacidad</a> y las <a href='?module=nosotros&i=7' target='_blank'>Condiciones de uso</a> del presente website.")?> </div>
</td>
			</tr>
			<tr>
			  <td colspan="2" align="center"><input type="submit" name="Submit2" value="<?=_("Siguiente")?>" id="envia"  class="botoncot" /></td>
			</tr>
		  </table>
  </form>
</div>
			
			
			<script type="text/javascript">
			
			function registrar(){
		if($('envios').checked) {
			var result = valid.validate();
			if(result){
				$('envia').disabled=true;
				new Ajax.Updater('registroForm','ajax_resp/registro.php',{method:'post',evalScripts: true, parameters:Form.serialize("registro")});
			}else{
				return false;
			}
		} else {
			$('linkbase').focus()
			new Effect.Highlight($('daceptar'),{duration: 10,startcolor: '#FFFF00'});
			return false;
		}
	}
	
		  var valid = new Validation('registro', {immediate : true,focusOnError : true});
		
		//////////////////////////		
		Validation.add('comprueba-mail','<?=_("El email ya se encuentra registrado")?>',function(v,elm) {
		
						if(elm._ajaxValidating && elm._hasAjaxValidateResult) {
								elm._ajaxValidating = false;
								elm._hasAjaxValidateResult = false;
								return elm._ajaxValidateResult;
						}
						var sendRequest = function() {
								new Ajax.Request('/ajax_resp/registro_chk_mail.php',{
										parameters : 'email=' + v,
										onSuccess : function(response) {
												elm._ajaxValidateResult = eval(response.responseText);
												elm._hasAjaxValidateResult = true;
												Validation.test('comprueba-mail',elm);
										}
								});
								elm._ajaxValidating = true;
								return true;
						}
		
						return elm._ajaxValidating || Validation.get('IsEmpty').test(v) || 
		sendRequest();
				}); 
				
		Validation.add('pass1', '<?=_("Su clave debe tener al menos 6 caracteres")?>', {
			 minLength : 5, 
			 maxLength : 20
		});	
		
		Validation.add('rif', '<?=_("El RIF debe tener 9 digitos")?>', {
			 minLength : 11, 
			 maxLength : 11
		});		
		</script>
		
	<?php } ?>
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>