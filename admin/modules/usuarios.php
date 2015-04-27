<?php 
$Admin->chkPermisosAdmin(6);
if(intval($_GET["edt"])!=0){
	if(intval($_POST["pk_direccion"])!=0){
		$Shop->addEdtDireccionesUsuario($_POST);
		$mensaje = "El elemento fue editado Direccion";
	}
	if(intval($_POST["pk_usuario"])!=0){
		$salida = $Shop->editUsuario($_POST);
		$mensaje = "El elemento fue editado PK_Usuario";
        
        
	}
	$rss = $Shop->busquedaUsuario(array("pk_usuario" => intval($_GET["edt"]))); 
    
    //var_dump($rss);
?>
<?php if(trim($mensaje)!=''){ ?><div align="center"><br /><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form id="form2" name="form2" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" class="brd1">
    <tr>
      <td colspan="2" class="t1">Detalle de usuario </td>
    </tr>
    <tr>
      <td class="t3">Email:</td>
      <td><?=$rss["results"][0]["email"]?>
          <input type="hidden" name="email" value="<?=$rss["results"][0]["email"]?>" />
          <input type="hidden" name="pk_usuario" value="<?=$rss["results"][0]["pk_usuario"]?>" />
          <input type="hidden" name="tipo_persona" value="<?=intval($rss["results"][0]["tipo_persona"])?>" />
      </td>
    </tr>
     <tr>
          <td class="t3">Tipo de usuario:</td>
          <td>
    	  <select name="fk_usuario_tipo" id="fk_usuario_tipo">
          <?php
          
          
           $Common->llenarComboDb(TBL_USUARIOS_TIPO,
                                        "pk_usuario_tipo",
                                        "tipo",
                                        "",
                                        0,
                                        intval($rss["results"][0]["fk_usuario_tipo"]),
                                        "",
                                        "pk_usuario_tipo asc"); ?>
          </select>
          
        
            
          
          
          </td>
          
    </tr>
      <tr>
          <td class="t3">Usuario Activado:</td>
          
              
              <td class="t2">
              <?php if($rss["results"][0]["fk_estatus"] == 2){  ?>
                        <input name="fk_estatus" type="radio" value="0" checked="checked" />
                                No        
                        <input name="fk_estatus" type="radio" value="1" /> 
                                Si 
                <?php }else{ ?>
                    <input name="fk_estatus" type="radio" value="0"  />
                                No        
                        <input name="fk_estatus" type="radio" checked="checked" value="1" />
                                Si
                    
                    <?php } ?>              
              </td>
            
    </tr>
    
    <tr>
      <td class="t3">Fecha de registro:</td>
      <td><?=date("d/m/Y h:i a",strtotime($rss["results"][0]["fecha_agregado"]))?></td>
    </tr>
    <tr>
      <td class="t3">&Uacute;ltimo ingreso:</td>
      <td><?=date("d/m/Y h:i a",strtotime($rss["results"][0]["fecha_lastlogin"]))?></td>
    </tr>
    <?php if(intval($rss["results"][0]["tipo_persona"])==1){?>
    <tr>
      <td class="t3">Nombres:</td>
      <td><input name="nombres" type="text" id="nombres" class="required" value="<?=$rss["results"][0]["nombres"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">Apellidos:</td>
      <td><input name="apellidos" type="text" id="apellidos" class="required" value="<?=$rss["results"][0]["apellidos"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">Cédula:</td>
      <td><input name="cedula_rif" type="text" id="cedula_rif" class="required" value="<?=$rss["results"][0]["cedula_rif"]?>" /></td>
    </tr>
    <?php }else{ ?>
    <tr>
      <td class="t3">Raz&oacute;n social:</td>
      <td><input name="nombres" type="text" id="nombres" class="required" value="<?=$rss["results"][0]["nombres"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">RIF:</td>
      <td><input name="cedula_rif" type="text" id="cedula_rif" class="required" value="<?=$rss["results"][0]["cedula_rif"]?>" /></td>
    </tr>
	<tr>
	  <td class="t3">Direcci&oacute;n fiscal:</td>
	  <td><textarea name="direccion" cols="40" rows="5" class="required" id="direccion"><?=$rss["results"][0]["direccion"]?></textarea></td>
	</tr>
    <tr>
      <td class="t3">Persona de contacto:</td>
      <td><input name="apellidos" type="text" id="apellidos" class="required" value="<?=$rss["results"][0]["apellidos"]?>" /></td>
    </tr>
    <?php } ?>
    <tr>
      <td class="t3">Teléfono principal:</td>
      <td><input name="telefono1" type="text" id="telefono1" class="required" value="<?=$rss["results"][0]["telefono1"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">Teléfono secundario:</td>
      <td><input name="telefono2" type="text" id="telefono2" value="<?=$rss["results"][0]["telefono2"]?>" /></td>
    </tr>
	<tr>
      <td class="t3">Proveniente:</td>
      <td><input name="proveniente" type="text" id="proveniente" value="<?=$rss["results"][0]["proveniente"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">Fax:</td>
      <td><input name="fax" type="text" id="fax" value="<?=$rss["results"][0]["fax"]?>" /></td>
    </tr>
    <tr>
      <td valign="top" class="t3">Pa&iacute;s:</td>
      <td valign="top"><select name="fk_pais" id="fk_pais" onchange="new Ajax.Updater('selEstado','/ajax_resp/registro_selects.php',{method:'post',evalScripts: true,parameters:'fk_pais=' + this.value}); $('contr').value=this.value">
          <option value="">Seleccione</option>
          <?php $Common->llenarComboDb(TBL_PAISES,"pk_pais","pais","",0,intval($rss["results"][0]["fk_pais"]),"","pais asc"); ?>
        </select>
          <input name="contr" type="hidden" id="contr" value="<?=intval($rss["results"][0]["fk_pais"])?>" class="required validate-number" />      </td>
    </tr>
    <tr>
      <td valign="top" class="t3">Estado:</td>
      <td valign="top"><span id="selEstado">
        <select name="fk_estado" id="fk_estado" onchange="new Ajax.Updater('selCiudad','/ajax_resp/registro_selects.php',{method:'post',parameters:'fk_estado=' + this.value}); $('edo').value=this.value">
          <option value="">Seleccione</option>
          <?php $Shop->llenarComboDb(TBL_ESTADOS,"pk_estado","estado","fk_pais",intval($rss["results"][0]["fk_pais"]),intval($rss["results"][0]["fk_estado"]),"","estado asc"); ?>
        </select>
        </span>
          <input name="edo" type="hidden" id="edo" value="<?=intval($rss["results"][0]["fk_estado"])?>" class="required validate-number" /></td>
    </tr>
    <tr>
      <td valign="top" class="t3">Ciudad:</td>
      <td valign="top"><span id="selCiudad">
        <select name="fk_ciudad" id="fk_ciudad" onchange="$('cty').value=this.value">
          <option value="">Seleccione</option>
          <?php $Shop->llenarComboDb(TBL_CIUDADES,"pk_ciudad","ciudad","fk_estado",intval($rss["results"][0]["fk_estado"]),intval($rss["results"][0]["fk_ciudad"]),"","ciudad asc"); ?>
        </select>
        </span>
          <input name="cty" type="hidden" id="cty" value="<?=intval($rss["results"][0]["fk_ciudad"])?>" class="required validate-number" /></td>
    </tr>
    
    <tr>
    <!--<td align="center"><input type="submit" id="activar" value="Activar Cuenta" /></td>-->
      <td colspan="2" align="center"><input type="submit" name="Submit2" value="Enviar" /></td>
       
    </tr>
  </table>
</form>

<br />
<?php }else{ ?>
<form id="form1" name="form1" method="get" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="2" class="brd1">
    <tr>
      <td colspan="2" class="t1">B&uacute;squeda de usuarios </td>
    </tr>
    <tr>
      <td class="t3">Nombres y/o Apellidos:</td>
      <td><input name="nomape" type="text" id="nomape" value="<?=$_GET["nomape"]?>" />
        
        <input name="module" type="hidden" id="module" value="<?=$_GET["module"]?>" />
      </td>
    </tr>
	 <tr>
      <td class="t3">Nombres</td>
      <td><input name="nombres" type="text" id="nombres" value="<?=$_GET["nombres"]?>" /></td>
    </tr>
	 <tr>
      <td class="t3">Apellidos:</td>
      <td><input name="apellidos" type="text" id="apellidos" value="<?=$_GET["apellidos"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">Email:</td>
      <td><input name="email" type="text" id="email" value="<?=$_GET["email"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">Tipo cliente:</td>
      <td class="t2"> 
      <select name="fk_usuario_tipo" id="fk_usuario_tipo">
      <option value="0">Seleccione</option>
      <?php $Common->llenarComboDb(TBL_USUARIOS_TIPO,"pk_usuario_tipo","tipo","",0,$_GET["fk_usuario_tipo"],"","pk_usuario_tipo asc"); ?>
      </select>
       </td>
    </tr>
   
    <tr>
      <td class="t3">Tipo persona:</td>
      <td class="t2"><input name="tipo_persona" type="radio" value="0" <?php if(intval($_GET["tipo_persona"])==0){  ?> checked="checked" <?php } ?>/>
Cualquiera        
  <input name="tipo_persona" type="radio" value="1" <?php if(intval($_GET["tipo_persona"])==1){  ?> checked="checked" <?php } ?>/> 
        Natural 
        <input name="tipo_persona" type="radio" value="2"  <?php if(intval($_GET["tipo_persona"])==2){ ?> checked="checked" <?php } ?>/> 
        Jur&iacute;dica </td>
    </tr>
    <tr>
      <td class="t3">Rif / Cédula:</td>
      <td><input name="cedula_rif" type="text" id="cedula_rif" value="<?=$_GET["cedula_rif"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">Fecha de registro: </td>
      <td><span class="t2">Desde
          <input type="text" name="fecha_inia" id="fecha_inia" readonly="1" value="<?php if(isset($_GET["fecha_inia"])){ echo date("Y-m-d",strtotime($_GET["fecha_inia"])); }else{ echo date("Y-m-d",strtotime("2000/1/1")); }?>" class="required" />
          <img src="/images/admin/24px-Crystal_Clear_app_date.png" name="f_trigger_c" align="absmiddle" id="f_trigger_c" style="cursor: pointer;" title="Date selector"/>
          <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_inia",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
          </script>
Hasta
<input type="text" name="fecha_fina" id="fecha_fina" readonly="1" value="<?php if(isset($_GET["fecha_fina"])){ echo date("Y-m-d",strtotime($_GET["fecha_fina"])); }else{ echo date("Y-m-d",strtotime("2020/12/31")); }?>" class="required" />
<img src="/images/admin/24px-Crystal_Clear_app_date.png" align="absmiddle" id="f_trigger_c2" style="cursor: pointer;" title="Date selector"/>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_fina",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c2",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script>
      </span></td>
    </tr>
    <tr>
      <td class="t3">Pa&iacute;s:</td>
      <td><select name="fk_pais" id="fk_pais" onchange="new Ajax.Updater('selEstado','/ajax_resp/registro_selects.php',{method:'post',evalScripts: true,parameters:'fk_pais=' + this.value}); $('contr').value=this.value">
          <option value="0">Seleccione</option>
          <?php $Shop->llenarComboDb(TBL_PAISES,"pk_pais","pais","",0,0,"","pais asc"); ?>
        </select>
          <input name="contr" type="hidden" id="contr" value="" class="" />      </td>
    </tr>
    <tr>
      <td class="t3">Estado:</td>
      <td><span id="selEstado">
        <select name="fk_estado" id="fk_estado">
          <option value="0">Seleccione</option>
        </select>
        </span>
          <input name="edo" type="hidden" id="edo" value="" class="" /></td>
    </tr>
    <tr>
      <td class="t3">Ciudad:</td>
      <td><span id="selCiudad">
        <select name="fk_ciudad" id="fk_ciudad">
          <option value="0">Seleccione</option>
        </select>
        </span>
          <input name="cty" type="hidden" id="cty" value="" class="" /></td>
    </tr>
     <tr>
      <td class="t3">Descargar:</td>
      <td class="t2"><input name="fk_descarga_cli" type="radio" value="0" checked="checked" />
No        
  <input name="fk_descarga_cli" type="radio" value="1" /> 
        Si  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" value="Buscar" /></td>
    </tr>
  </table>
</form><br />
<br />
<?php
$rss = $Shop->busquedaUsuario($_GET,15,$_GET["page"]);
?>
<table width="100%" border="0" cellpadding="4" cellspacing="0" class="brd1">
  <tr>
    <td colspan="4" class="t1">Usuarios</td>
  </tr>
  <tr>
    <td class="t5">Email</td>
    <td class="t5">Nombres y Apellidos </td>
    <td class="t5">Teléfono</td>
    <td class="t5">&Uacute;ltimo ingreso</td>
  </tr>
<?php if(sizeof($rss["results"])>0){ ?>
	<?php foreach($rss["results"] as $key => $value){ ?>
	  <tr>
		<td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_usuario"]?>" class="t2"><?=$value["email"]?></a></td>
		<td class="t3"><?=$value["nombres"]?> <?=$value["apellidos"]?></td>
		<td><?=$value["telefono1"]?></td>
		<td><?=date("d/m/Y",strtotime($value["fecha_lastlogin"]))?></td>
	  </tr>
	<?php } ?>
	<tr>
    <td colspan="4" align="right"><?=$Shop->paginateResults($rss)?></td>
  </tr>
<?php }else{ ?>
  <tr>
    <td colspan="4" class="ntf1">No se encontraron resultados</td>
  </tr>
<?php } ?>
</table>
<?php } ?>