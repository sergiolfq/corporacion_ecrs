
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(4);?></th>
              </tr>
          </table>
            <table width="990" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
            <tr>
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left" scope="col"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Pedido")?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" />
            </tr>  
        </table>
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col">
                
                
                    
<?php 
unset($_SESSION["order"]);
if(sizeof($cart)>0){
?>

<table width="95%" border="0" align="center" cellpadding="5" cellspacing="2" class="tablaBgPuntos">
  <tr>
    <td bgcolor="#FFFFFF" align="left">
	<form id="formcart" name="formcart" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
 
    <tr>
      <td valign="top" class="azuloscuroG"><strong>SKU</strong></td>
      <td valign="top" class="azuloscuroG"><strong><?=_("Producto")?></strong></td>
      
      <td align="right" valign="top" class="azuloscuroG"><strong><?=_("Cantidad")?></strong></td>
    
      <td valign="top" class="azuloscuroG">&nbsp;</td>
    </tr>
    <?php 
	
	foreach($cart as $key => $value){
		$rsTalla = $Shop->getTalla(array("pk_talla"=>$value["pk_talla"]));
	?>
    <tr>
      <td valign="top"><?=$value["sku"]?></td>
      <td valign="top">
	  <?=substr($value["nombre" . $_SESSION["LOCALE"]],0,20)?>
      <div class="variantesCart">
      <?php
      foreach($value["variantes"] as $kxv => $vxv){
	  	$vari =$Shop->getVariantesTipo(array("pk_variante_tipo"=>$vxv));
		echo $vari["results"][0]["variante"] . ": " . $vari["results"][0]["variante_tipo"] . "<br>";
	  } 
	  ?>
      </div>
      </td>
     
      <td align="right" valign="top"><input name="p_<?=$value["uniqueProducto"]?>" type="text" id="p_<?=$value["uniqueProducto"]?>" value="<?=$value["qty"]?>" size="3" maxlength="3" class="required validate-digits" style="text-align:right" /></td>
   
      <td valign="top"><a href="?module=<?=$_GET["module"]?>&del=<?=$value["uniqueProducto"]?>"><img src="images/action_stop.gif" alt="Eliminar" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } ?>
    
    <tr>
      <td colspan="4" align="center" ><br />
<br />

	<input name="" type="button" value="<?=_("Solicitar cotización")?> &raquo;" onclick="pedido()" class="boton_encuesta"><br /><br />
    
    <input name="" type="button" value="&laquo; <?=_("Seguir cotizando otros productos")?>" onclick="document.location='/'" class="boton_encuesta">
    
   
</td>
      </tr>
  </table>
</form>
	</td>
  </tr>
</table>


<script language="javascript" type="text/javascript">
var valid = new Validation('formcart', {immediate : true,focusOnError : true});

function pedido(){
	var result = valid.validate();
	if(result){
		$('formcart').action='?module=cart_check';
		$('formcart').submit();
	}else{
		return false;
	}

}

function recalcular(){
	var result = valid.validate();
		if(result){
			$('formcart').submit();
		}else{
			return false;
		}
}
</script>
<?php }else{ ?>

<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" class="titulocarts"><br />
      <br />
      <br />
    <?=_("No tiene ningún producto en su carrito de compras")?> <br />
    <br />
    <br />
    <br /></td>
  </tr>
</table>

  <?php } ?>

                
                
                
                
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>