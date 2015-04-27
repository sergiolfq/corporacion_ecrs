 <?php
 $fk_usuario_tipo = intval($_SESSION["user"]["fk_usuario_tipo"]);
 if($fk_usuario_tipo==0){
	 $fk_usuario_tipo=1; 
 }
 if($GLOBALS["modulo"] =='soporte_detalle'){
	 $pk_producto = $Shop->decode($_GET["t"]);
 ?>
 <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(6);?></th>
              </tr>
          </table>
            <table width="981" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th class="titulos" scope="col"><?=_("Soporte")?></th>
  </tr>
</table>
<br />
<?php } ?>
<?php


/*
if(!isset($_SESSION["user"])  ){
	require("soporte_error.php");
}else{
	*/
	//$sql = "select distinct(c.categoria". $_SESSION["LOCALE"]. ") as cat, c.pk_soporte_categoria from " . TBL_SOPORTE_CATEGORIAS . " c inner join " . TBL_SOPORTE_DESCARGAS. " d on c.pk_soporte_categoria=d.fk_soporte_categoria  where  c.fk_estatus>0 and  d.fk_estatus>0 and c.fk_usuario_tipo='" . $_SESSION["user"]["fk_usuario_tipo"]. "' and d.pk_soporte_descarga in (select fk_soporte_descarga from " . TBL_SOPORTE_DESCARGAS_VS_PRODUCTOS . " where fk_producto=" . $pk_producto . " and fk_estatus>0 ) ";
	
	$sql = "select c.* from " . TBL_SOPORTE_CATEGORIAS . " c where c.fk_estatus=1 and c.fk_usuario_tipo='" .  $fk_usuario_tipo . "' and c.pk_soporte_categoria in (select fk_soporte_categoria from " . TBL_SOPORTE_DESCARGAS_VS_CATEGORIAS . " vs1 inner join " . TBL_SOPORTE_DESCARGAS_VS_PRODUCTOS . " vs2 on vs1.fk_soporte_descarga=vs2.fk_soporte_descarga where vs1.fk_estatus=1 and vs2.fk_estatus=1 and  vs2.fk_producto=" . $pk_producto . ") group by c.pk_soporte_categoria ";
	//echo $sql;
	
	
	$cats = $Shop->Execute($sql,99); 
	
	$rs = $Shop->getProducto(array("pk_producto" => intval($pk_producto)));
	$value = $rs["results"][0];
	
?>

<?php if($GLOBALS["modulo"] =='soporte_detalle'){?>
<table width="915" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th width="680" scope="col"><table width="680" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="soporte_round_box" scope="col"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="2%" scope="col">&nbsp;</th>
            <th width="49%" valign="top" scope="col"><img src="ajax_resp/foto_soporte.php?f=<?=$value["pk_producto"]?>"alt="producto" /></th>
            <th width="49%" valign="top" scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <th height="33" align="left" valign="top" class="productodeta_titulo" scope="col"><?=$value["nombre_soporte" . $_SESSION["LOCALE"]]?></th>
              </tr>
              <tr>
                <td align="left" class="productodeta_text"><?=$value["sumario" . $_SESSION["LOCALE"]]?></td>
              </tr>
            </table></th>
          </tr>
        </table></th>
      </tr>
    </table></th>
    <th width="35" scope="col">&nbsp;</th>
    <th width="200" scope="col"><?= $Banners->showBanners(9);?></th>
  </tr>
</table>

<br />
<table width="915" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th align="left" valign="top" class="barra_productos" scope="col"><table width="68%" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <th width="49%" height="37" align="center" valign="bottom" scope="col"><?=_("Descargas")?><br />
          <img src="images/iconos/flecha_blancoarriba.png" width="12" height="6" /></th>
        <th width="51%" scope="col">&nbsp;</th>
      </tr>
    </table></th>
  </tr>
</table>
<?php } ?>

<?php if(sizeof($cats["results"])==0){ ?>
<center><strong>
<?=_("No existen descargas para este producto")?><br />
<?=_("Debe hacer login en nuestro sistema para ver las descargas especializadas")?>
</strong></center>
<?php } ?>


<?php 
foreach($cats["results"] as $k=>$v){ 
	$sql = "select * from " . TBL_SOPORTE_DESCARGAS. " d inner join  " . TBL_SOPORTE_DESCARGAS_VS_PRODUCTOS . " vs1 on d.pk_soporte_descarga=vs1.fk_soporte_descarga inner join  " . TBL_SOPORTE_DESCARGAS_VS_CATEGORIAS . " vs2 on pk_soporte_descarga=vs2.fk_soporte_descarga inner join " . TBL_SOPORTE_CATEGORIAS . " c on c.pk_soporte_categoria=vs2.fk_soporte_categoria where  c.pk_soporte_categoria=" . $v ["pk_soporte_categoria"]. " and  c.fk_usuario_tipo='" .  $fk_usuario_tipo  . "' and d.fk_estatus=1 and vs1.fk_estatus=1 and vs2.fk_estatus=1 and  c.fk_estatus=1 group by d.pk_soporte_descarga order by d.fecha_version desc  ";

//echo $sql;
	$file = $Shop->Execute($sql,999);
    //var_dump($file);
?>
<br />
<table width="915" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th height="22" scope="col"><img src="images/iconos/separador2.gif" width="905" height="15" /></th>
  </tr>
</table>
<table width="890" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th width="41" scope="col"><img src="images/iconos/circle_reddown.jpg" width="32" height="33" alt="circle" /></th>
    <th width="849" align="left" class="trebuchet_gris16bold" scope="col"><?=$v["categoria"]?> (<?=sizeof($file["results"])?>)</th>
  </tr>
</table>
<table width="890" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <th width="152" height="25" align="left" valign="top" class="trebuchet_gris12" scope="col"><strong><?=_("Nombre Archivo")?></strong></th>
    <th width="120" align="left" valign="top" scope="col"><?=_("Importancia")?></th>
    <th width="166" align="left" valign="top" class="trebuchet_gris12" scope="col"><strong><?=_("Ultima Actualización")?></strong></th>
    <th width="178" align="left" valign="top" scope="col"><?=_("Versión")?></th>
    <th width="174" align="left" valign="top" scope="col"><?=_("Acción")?></th>
  </tr>
</table>
<table width="890" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col"><img src="images/iconos/carac_separacion.gif" width="888" height="6" /></th>
  </tr>
</table>
<table width="890" border="0" align="center" cellpadding="8" cellspacing="0">
<?php foreach($file["results"] as $kf=>$vf){ ?>
  <tr>
    <th width="152" height="25" align="left" valign="top" class="productodeta_caract1" scope="col"><span class="productodeta_caract4"><strong><?=$vf["descarga". $_SESSION["LOCALE"]]?> </strong></span><br />
      <span class="productodeta_caract2">(<?=$Shop->_format_bytes(filesize(SERVER_ROOT . "descargas/" . $vf["pk_soporte_descarga"] . ".dat"))?>)</span></th>
    <th width="120" align="left" valign="top" scope="col"><span class="productodeta_caract2"><?=$vf["importancia"]?></span></th>
    <th width="166" align="left" valign="top" class="productodeta_caract2" scope="col"><?=$Shop->month2letter(date("n",strtotime($vf["fecha_version"])))?> <?=date("d, Y",strtotime($vf["fecha_version"]))?></th>
    <th width="178" align="left" valign="top" class="productodeta_caract2" scope="col"><?=$vf["version"]?></th>
    <th width="174" align="left" valign="top" scope="col"><input type="button" name="Button" id="button" value="<?=_("Descargar")?>" class="botoncot" onclick="<?php if(!isset($_SESSION["user"])){ ?>alert('<?=_("Debe estar registrado / autentificado para descargar este archivo")?>')<?php }else{ ?>document.location='?dws=<?=$Shop->encode($vf["pk_soporte_descarga"] )?>'<?php }?>"   /></th>
  </tr>
  
<?php } ?>
  
 
</table>
<?php } ?>
<br />
<br />
<table width="915" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th height="22" scope="col"><img src="images/iconos/separador2.gif" width="905" height="15" /></th>
  </tr>
</table>
<?php
// }
?>
<p></p>
