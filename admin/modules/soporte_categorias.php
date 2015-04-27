 <?php
$Admin->chkPermisosAdmin(5);
$Helper = new Helper; 

if(intval($_POST["pk_soporte_categoria"])==0 && trim($_POST["categoria"])!=""){
	$pk=$Helper->addSoporte_Categorias($_POST);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_soporte_categoria"])>0){
	$Helper->editSoporte_Categorias($_POST);
	$pk= intval($_POST["pk_soporte_categoria"]);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Helper->delSoporte_Categorias($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}



if(intval($_GET["edt"])>0){
	$arr = array("pk_soporte_categoria" => intval($_GET["edt"]));
	$rs = $Helper->getSoporte_Categorias($arr,0,1);
	
}


?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="comprueba(); return false">
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
      <td width="10%" valign="top" class="t3">Categoría Espa&ntilde;ol</td>
      <td valign="top"><input name="categoria" type="text" id="categoria" value="<?=$rs["results"][0]["categoria"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_soporte_categoria" type="hidden" id="pk_soporte_categoria" value="<?=$rs["results"][0]["pk_soporte_categoria"]?>" /></td>
    </tr>  
    <tr>
      <td width="10%" valign="top" class="t3">Categoría  Ingl&eacute;s</td>
      <td valign="top"><input name="categoria_en" type="text" id="categoria_en" value="<?=$rs["results"][0]["categoria_en"]?>" size="50" maxlength="255" class="required" /></td>
    </tr> 
    <tr>
      <td width="10%" valign="top" class="t3">Permisologia</td>
      <td valign="top">
      <select name="fk_usuario_tipo" id="fk_usuario_tipo">
      <?php $Common->llenarComboDb(TBL_USUARIOS_TIPO,"pk_usuario_tipo","tipo","",0,intval($rs["results"][0]["fk_usuario_tipo"]),"","pk_usuario_tipo asc"); ?>
      </select></td>
    </tr>
    
	
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
  <script>
function comprueba(){
	
	if(valid.validate())  form1.submit();

	return false;
}

  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
    <td class="t1">Categoria</td>
    <td class="t1">Permisolog&iacute;a</td>
     <td width="1%" class="t1">Eliminar</td>
    </tr>
<?php
$rss = $Helper->getSoporte_Categorias(array("orderby"=>"pk_soporte_categoria desc"),$_GET["page"],10);
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_soporte_categoria"]?>"><?=$value["categoria"]?></a></td>
      <td>
      <?php
      $rx= $Helper->getUsuarios_Tipo(array("pk_usuario_tipo"=>$value["fk_usuario_tipo"]),0,1);
	  echo $rx["results"][0]["tipo"];
	  ?>
      </td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_soporte_categoria"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="2" align="right"><?=$Helper->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
