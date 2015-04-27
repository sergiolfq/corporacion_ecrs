<?php
$Admin->chkPermisosAdmin(9);
if(intval($_POST["pk_proveedor"])==0 && trim($_POST["proveedor"])!=""){
	$Shop->addProveedor($_POST,$_FILES);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_proveedor"])>0){
	$Shop->editProveedor($_POST,$_FILES);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Shop->deleteProveedor($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_proveedor" => intval($_GET["edt"]));
	$rs = $Shop->getProveedor($arr);
}

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0" class="brd1">
    <tr>
      <td colspan="2" class="t1"><span style="float:left ">
        <?php if(isset($_GET["edt"])){?>
        Editar
        <?php }else{ ?>
        Agregar
        <?php } ?>
        </span>
          <?php if(isset($_GET["edt"])){?>
        <span style="float:right;"><a href="?module=<?=$_GET["module"]?>" class="t1">Nuevo </a></span>
        <?php } ?></td>
    </tr>
    <tr>
      <td width="10%" valign="top" class="t3">Proveedor</td>
      <td valign="top"><input name="proveedor" type="text" id="proveedor" value="<?=$rs["results"][0]["proveedor"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_proveedor" type="hidden" id="pk_proveedor" value="<?=$rs["results"][0]["pk_proveedor"]?>" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">RIF</td>
      <td valign="top"><input name="rif" type="text"  id="rif" value="<?=$rs["results"][0]["rif"]?>" size="20" maxlength="255" class="required" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">NIT</td>
      <td valign="top"><input name="nit" type="text" id="nit" value="<?=$rs["results"][0]["nit"]?>" size="20" maxlength="255" class="validate-digits" /></td>
	 
    </tr>
  <tr>
      <td  class="t3">Pa&iacute;s:</td>
      <td><select name="fk_pais" id="fk_pais" onChange="new Ajax.Updater('selEstado','/ajax_resp/registro_selects.php',{method:'post',evalScripts: true,parameters:'fk_pais=' + this.value}); $('contr').value=this.value">
	  <option value="">Seleccione</option>
					  <?php $Shop->llenarComboDb(TBL_PAISES,"pk_pais","pais","",0,intval($rs["results"][0]["fk_pais"]),"","pais asc"); ?>
				</select><input name="contr" type="hidden" id="contr" value="<?=$rs["results"][0]["fk_pais"]?>" class="required" /> </td>
	 </tr>
	 <tr>
      <td class="t3">Estado:</td>
      <td>
	  <span id="selEstado">
		<select name="fk_estado" id="fk_estado">
	   <option value="">Seleccione</option>
	   <?php $Shop->llenarComboDb(TBL_ESTADOS,"pk_estado","estado","fk_pais",intval($rs["results"][0]["fk_pais"]),intval($rs["results"][0]["fk_estado"]),"","estado asc"); ?>
	   </select></span><input name="edo" type="hidden" id="edo" value="<?=$rs["results"][0]["fk_estado"]?>" class="required" /></td>
	 </tr>
	 <tr>
      <td  class="t3">Ciudad:</td>
      <td><span id="selCiudad">
					  <select name="fk_ciudad" id="fk_ciudad">
					<option value="0">Seleccione</option>
					<?php $Shop->llenarComboDb(TBL_CIUDADES,"pk_ciudad","ciudad","fk_estado",intval($rs["results"][0]["fk_estado"]),intval($rs["results"][0]["fk_ciudad"]),"","ciudad asc"); ?>
					</select></span><input name="cty" type="hidden" id="cty" value="<?=intval($rs["results"][0]["fk_ciudad"])?>" class="required" /></td>
	 </tr>
	 <tr>
      <td width="10%" valign="top" class="t3">Direcci&oacute;n</td>
      <td valign="top"><textarea name="direccion" cols="30" rows="4" class="required" id="direccion"><?=$rs["results"][0]["direccion"]?></textarea></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Persona de contacto</td>
      <td valign="top"><input name="contacto" type="text"  id="contacto" value="<?=$rs["results"][0]["contacto"]?>" size="30" maxlength="255" class="required" /></td>
    </tr>
	 <tr>
      <td width="10%" valign="top" class="t3">Teléfono</td>
      <td valign="top"><input name="telefono" type="text"  id="telefono" value="<?=$rs["results"][0]["telefono"]?>" size="30" maxlength="255" class="required" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Fax</td>
      <td valign="top"><input name="fax" type="text"  id="fax" value="<?=$rs["results"][0]["fax"]?>" size="30" maxlength="255"  /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Email</td>
      <td valign="top"><input name="email" type="text"  id="email" value="<?=$rs["results"][0]["email"]?>" size="30" maxlength="255" class="validate-email"  /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Website</td>
      <td valign="top"><input name="url" type="text"  id="url" value="<?=$rs["results"][0]["url"]?>" size="30" maxlength="255" class="validate-url"  /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Observaciones</td>
      <td valign="top"><textarea name="observaciones" cols="50" rows="4" id="observaciones"><?=$rs["results"][0]["observaciones"]?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
  <script type="text/javascript">
  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="get" action="#results">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
      <td colspan="2" class="t1">Proveedores 
      <input name="proveedor" type="text" id="proveedor" value="<?=$_GET["proveedor"]?>" /> <input type="submit" name="Submit3" value="Filtrar --&gt;" /><input type="hidden" name="module" value="<?=$_GET["module"]?>" /></td>
    </tr>
    <tr>
      <td class="t5"><a name="results" id="results"></a>Proveedor</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Shop->getProveedor($_GET,$_GET["page"],10);
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_proveedor"]?>"><?=$value["proveedor"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_proveedor"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Shop->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
