<?php
//var_dump($_POST);
if(!isset($productos)){
	require_once("../../includes/includes.php");
	$Common = new Common;
	$Shop = new Shop;
	$productos = unserialize(urldecode($_POST["productos_ser"]));
}

if(isset($_POST["ajax"]) && isset($_POST["del_pro"])){
	unset($productos["results"][intval($_POST["del_pro"])]);
}

if(isset($_POST["ajax"]) && isset($_POST["recalcula"])){

	if(sizeof($productos["results"])>0){
		foreach($productos["results"] as $key => $value){
			if(intval($_POST["cantidad"][$key])==0){
				unset($productos["results"][$key]);
			}else{
				$productos["results"][$key]["precio"]=$_POST["precio"][$key];
				$productos["results"][$key]["cantidad"]=$_POST["cantidad"][$key];
			}
		}
	}
}

if(isset($_POST["ajax"]) && isset($_POST["add_pro"])){
	$rs = $Shop->getProducto(array("sku" => trim($_POST["add_pro"])));
	if(sizeof($rs["results"])>0){
		$productos["results"][] = array(
		"sku" =>$rs["results"][0]["sku"],
		"fk_producto" =>$rs["results"][0]["pk_producto"],
		"nombre" =>$rs["results"][0]["nombre"],
		"precio" =>$rs["results"][0]["precio" . intval($_POST["fk_moneda"]) . intval($_POST["fk_banda_precio"])],
		"cantidad" =>"1"
		);
	}
}
if(sizeof($productos["results"])>0){
	foreach($productos["results"] as $key => $value){ //FIX cuando elimino un producto se eliminan los correlativos KEYS del array, so los areglo again porsia
		$arrtmp[] = $value; // se que parece loco pero es necesario!
	}
}
	$productos["results"] = $arrtmp;


$productos_ser = urlencode(serialize($productos));
?>

<?php if(isset($_POST["productos_ser"]) && isset($_POST["ajax"]) && !isset($orden)){ ?>
<div style="color:#FF0000; font-weight:bold; background-color:#FFFF00; padding:3px">ATENCI&Oacute;N: Ha eliminado o agregado uno o varios productos de este pedido, estos cambios no surtir&aacute;n efecto hasta salvar los cambios en el pedido</div><input type="hidden" name="ajax" value="1" />
<?php } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="td1">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td class="td1"><strong>SKU</strong></td>
    <td class="td1"><strong>Producto</strong></td>
    <td align="right" class="td1">&nbsp;</td>
    <td align="right" class="td1">&nbsp;</td>
    <td align="right" class="td1"><strong>Cant.</strong></td>
    <td align="right" class="td1">&nbsp;</td>
    <td align="right" class="td1">&nbsp;</td>
  </tr>
  <?php 
  	$totEfec =0;
	$totTdc =0;
	if(sizeof($productos["results"])>0){
		foreach($productos["results"] as $key => $value){
			$variantes = $Shop->getOrdersProductsVariantes(array("fk_orden_detalle"=>$value["pk_orden_detalle"]));
			$totEfec +=$value["precio"]*$value["cantidad"];
			$totTdc +=$value["preciotdc"]*$value["cantidad"];
?>
  <tr>
    <td valign="top"><a href="?module=productos&edt=<?=$value["fk_producto"]?>" target="_blank"><?=$value["sku"]?></a>
    <input name="fk_producto[]" type="hidden" id="fk_producto_<?=$key?>" value="<?=$value["fk_producto"]?>" /></td>
    <td valign="top"><?=$value["nombre"]?>
    <div>
    <?php
     foreach($variantes["results"] as $kxv => $vxv){
		echo $vxv["variante"] . ": " . $vxv["variante_tipo"] . "<br>";
	  } 
	?>
    </div>
    </td>
    <td align="right" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
    <td align="right" valign="top"><input name="cantidad[]" type="text" class="required validate-digits" id="cantidad_<?=$key?>" style="text-align:right" value="<?=$value["cantidad"]?>" size="3"/></td>
    <td align="right" valign="top">&nbsp;</td>
    <td align="right" valign="top"><a href="JavaScript:void(delProducto(<?=$key?>))"><img src="../images/admin/action_stop.gif" width="16" height="16" border="0" /></a></td>
  </tr>
  <?php } ?>
 <?php } ?>

  <tr>
    <td colspan="7" align="center"><input type="button" name="button2" id="button2" value="Recalcular" onclick="recalculaProducto()" />
    <input name="productos_ser" type="hidden" id="productos_ser" value="<?=$productos_ser?>" /></td>
  </tr>
</table>


