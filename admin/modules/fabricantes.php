<?php
$Admin->chkPermisosAdmin(10);
if(intval($_POST["pk_fabricante"])==0 && trim($_POST["fabricante"])!=""){
	$Shop->addFabricante($_POST,$_FILES);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_fabricante"])>0){
	$Shop->editFabricante($_POST,$_FILES);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Shop->deleteFabricante($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_fabricante" => intval($_GET["edt"]));
	$rs = $Shop->getFabricante($arr);
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
      <td width="10%" valign="top" class="t3">Fabricante</td>
      <td valign="top"><input name="fabricante" type="text" id="fabricante" value="<?=$rs["results"][0]["fabricante"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_fabricante" type="hidden" id="pk_fabricante" value="<?=$rs["results"][0]["pk_fabricante"]?>" /></td>
    </tr>
    <!--
    <tr>
      <td width="10%" valign="top" class="t3">URL</td>
      <td valign="top"><input name="url" type="text" id="url" value="<?=$rs["results"][0]["url"]?>" size="50" maxlength="255" class="validate-url" /></td>
    </tr>
    <tr>
      <td class="t3">Logo (236 x 120 px) </td>
      <td><input name="imagen" type="file" id="imagen" <?php if(isset($_GET["edt"]) && !file_exists(SERVER_ROOT . "images/fabricantes/" . $rs["results"][0]["pk_fabricante"] . ".jpg")) { ?>class="required" <?php } ?>/><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/fabricantes/" . $rs["results"][0]["pk_fabricante"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/fabricantes/<?=$rs["results"][0]["pk_fabricante"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a>    <?php } ?></td>
	</tr>
    -->
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
      <td colspan="2" class="t1">Fabricante</td>
    </tr>
    <tr>
      <td class="t5">Fabricante</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Shop->getFabricante('',$_GET["page"]);
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_fabricante"]?>"><?=$value["fabricante"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_fabricante"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Shop->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
