<?php
$Admin->chkPermisosAdmin(10);
if(intval($_POST["pk_caracteristica"])==0 && trim($_POST["caracteristica"])!=""){
	$Shop->addCaracteristica($_POST,$_FILES);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_caracteristica"])>0){
	$Shop->editCaracteristica($_POST,$_FILES);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Shop->deleteCaracteristica($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_caracteristica" => intval($_GET["edt"]));
	$rs = $Shop->getCaracteristica($arr);
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
      <td width="10%" valign="top" class="t3">Caracter&iacute;stica</td>
      <td valign="top"><input name="caracteristica" type="text" id="caracteristica" value="<?=$rs["results"][0]["caracteristica"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_caracteristica" type="hidden" id="pk_caracteristica" value="<?=$rs["results"][0]["pk_caracteristica"]?>" /></td>
    </tr>
	<tr>
      <td class="t3">Icono (50 x 50 px) </td>
      <td><input name="imagen" type="file" id="imagen" <?php if(isset($_GET["edt"]) && !file_exists(SERVER_ROOT . "images/caracteristicas/car_" . $rs["results"][0]["pk_caracteristica"] . ".jpg")) { ?>class="required" <?php } ?>/><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/caracteristicas/car_" . $rs["results"][0]["pk_caracteristica"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/caracteristicas/car_<?=$rs["results"][0]["pk_caracteristica"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a>    <?php } ?></td>
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
<form id="form2" name="form2" method="post" action="?module=<?=$_GET["module"]?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
      <td colspan="2" class="t1">Caracter&iacute;stica</td>
    </tr>
    <tr>
      <td class="t5">Caracter&iacute;stica</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Shop->getCaracteristica('',$_GET["page"]);
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_caracteristica"]?>"><?=$value["caracteristica"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_caracteristica"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Shop->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
