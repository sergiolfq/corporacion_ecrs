<?php
$Admin->chkPermisosAdmin(3);

$Banners = new Banners;
if(intval($_POST["pk_banner_zona"])==0 && trim($_POST["zona"])!=""){
	$Banners->addBannerZona($_POST);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_banner_zona"])>0){
	$Banners->editBannerZona($_POST);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Banners->deleteBannerZona($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_banner_zona" => intval($_GET["edt"]));
	$rs = $Banners->getBannerZona($arr);
}

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<style type="text/css" media="screen">


  ul.sortabledemo li {
    padding:5px;
    margin:5px;
  }
  li.green {
    background-color: #ECF3E1;
    border:1px solid #C5DEA1;
    cursor: move;
	width:40%;

  }

  </style>
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
      <td width="20%" valign="top" class="t3">Zona:</td>
      <td valign="top"><input name="zona" type="text" id="zona" value="<?=$rs["results"][0]["zona"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_banner_zona" type="hidden" id="pk_banner_zona" value="<?=$rs["results"][0]["pk_banner_zona"]?>" /></td>
    </tr>
	<tr>
      <td width="30%" valign="top" class="t3">Max banners:<br />
(Cero para ilimitado)</td>
      <td valign="top"><input name="max_display" type="text"  id="max_display" value="<?=$rs["results"][0]["max_display"]?>" size="20" maxlength="255" class="required validate-digits" /></td>
    </tr>
	<tr>
      <td width="30%" valign="top" class="t3">Separador inicio: </td>
      <td valign="top"><input name="separador_ini" type="text" id="separador_ini" value="<?=$rs["results"][0]["separador_ini"]?>" size="20" maxlength="255"/></td>
    </tr>
  <tr>
      <td  class="t3">Separador final: </td>
      <td><input name="seperador_fin" type="text" id="seperador_fin" value="<?=$rs["results"][0]["seperador_fin"]?>" size="20" maxlength="255" /></td>
	 </tr>
	  <tr>
      <td  class="t3">Ordenamiento:</td>
      <td><input name="ordenamiento" type="radio" value="0" <?php if(intval($rs["results"][0]["ordenamiento"])==0){?> checked="checked"<?php } ?> />
Ordenados
  <input name="ordenamiento" type="radio" value="1" <?php if(intval($rs["results"][0]["ordenamiento"])==1){?> checked="checked"<?php } ?> />
Aleatorio </td>
	  </tr>
	  <td valign="top"  class="t3">Banners en esta zona:<br />
	    (Ordenamiento)</td>
      <td>
	  <?php
	  $bannZona = $Banners->getBannerbyZonas($rs["results"][0]["pk_banner_zona"]);
	  if(sizeof($bannZona["results"])==0){
	  ?>
	  No hay banners en esta zona
	  <?php }else{ ?>
	  <ul class="sortabledemo" id="firstlist">
	  <?php foreach($bannZona["results"] as $kk1 => $vv1){ ?>
	  <li class="green" id="firstlist_firstlist<?=($kk1+1)?>"><?=$vv1["banner"]?><input type="hidden" name="bannerorden[]" value="<?=$vv1["pk_banner"]?>" /></li>
	  
	  <?php } ?>
	</ul>
	<script type="text/javascript">
  Sortable.create("firstlist",
     {dropOnEmpty:true,containment:["firstlist"],constraint:false,
      onChange:function(){$('firstlist_debug').innerHTML = Sortable.serialize('firstlist') }});
 </script>
 <pre id="firstlist_debug" style="display:none;"></pre>

	<?php } ?>
	  </td>
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
      <td colspan="2" class="t1">Zonas</td>
    </tr>
    <tr>
      <td class="t5">Zonas</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Banners->getBannerZona(array("orderby"=>"pk_banner_zona desc"),$_GET["page"],10);
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_banner_zona"]?>"><?=$value["zona"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_banner_zona"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Banners->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
