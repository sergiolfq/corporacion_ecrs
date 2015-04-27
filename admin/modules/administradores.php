<?php
$Admin->chkPermisosAdmin(1);

if(intval($_POST["pk_administrador"])==0 && trim($_POST["login"])!=""){
	$Admin->addAdministrador($_POST);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_administrador"])>0){
	$Admin->editAdministrador($_POST);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Admin->deleteAdministrador($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_administrador" => intval($_GET["edt"]));
	$rs = $Admin->getAdministrador($arr);
}

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" name="form1" id="form1">
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
      <td width="10%" valign="top" class="t3">Nombres y apellidos</td>
      <td valign="top"><input name="nombres" type="text" id="nombres" value="<?=$rs["results"][0]["nombres"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_administrador" type="hidden" id="pk_administrador" value="<?=$rs["results"][0]["pk_administrador"]?>" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Login</td>
      <td valign="top"><input name="login" type="text" id="login" value="<?=$rs["results"][0]["login"]?>" size="32" maxlength="32" class="required" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Password</td>
      <td valign="top"><input name="password" type="text" id="password" value="" size="32" maxlength="32" <?php if(intval($_GET["edt"])==0){ ?>class="required"<?php } ?> /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Permisos</td>
      <td valign="top"><?php 
	  $AGGvars = array("versus"=>TBL_ADMINISTRADORES_VS_PERMISOS,"fk"=>"fk_administrador","tabla"=>TBL_ADMINISTRADORES_PERMISOS,"pk"=>"pk_permiso","fk_1"=>"fk_permiso","campo_buscar"=>"permiso");
	  include("vs_aggregator.php"); 
	  ?></td>
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
      <td colspan="2" class="t1">Administrador</td>
    </tr>
    <tr>
      <td class="t5">Administrador</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Admin->getAdministrador('',$_GET["page"]);
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_administrador"]?>"><?=$value["nombres"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_administrador"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Admin->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
