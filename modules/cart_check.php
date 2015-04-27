
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
                
                
                 <table width="95%" border="0" cellpadding="5" cellspacing="2" class="tablaBgPuntos" align="center">
  <tr>
    <td bgcolor="#FFFFFF" align="left">
	<p class="titulorojo_destacado"><?=_("Revise y confirme su pedido")?></p>
	<?php if(sizeof($cart)>0){?>
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td class="azuloscuroG"><strong>SKU</strong></td>
      <td class="azuloscuroG"><strong><?=_("Producto")?></strong></td>
      <td class="azuloscuroG" align="right"><strong><?=_("Cantidad")?></strong></td>
    </tr>
    <?php 
	foreach($cart as $key => $value){
	?>
    <tr>
      <td valign="top" class="bioboton"><?=$value["sku"]?></td>
      <td valign="top" class="bioboton"><?=substr($value["nombre" . $_SESSION["LOCALE"]],0,20)?>
      <div class="variantesCart">
      <?php
      foreach($value["variantes"] as $kxv => $vxv){
	  	$vari =$Shop->getVariantesTipo(array("pk_variante_tipo"=>$vxv));
		echo $vari["results"][0]["variante"] . ": " . $vari["results"][0]["variante_tipo"] . "<br>";
	  } 
	  ?>
      </div>
      </td>
      <td align="right" valign="top" class="bioboton"><?=$value["qty"]?></td>
    </tr>
    <?php } ?>
    
    <tr>
      <td colspan="4" align="center" class="totales"><br />
<br />

	  <input name="" type="button" value="&laquo; <?=_("Deseo modificar mi pedido")?>" onclick="document.location='?module=cart'" class="botoncarrito">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	
        
        
      <input name="" type="button" value="<?=_("Mi pedido está correcto")?> &raquo;" onclick="document.location='<?php if(isset($_SESSION["user"])){ ?>?module=cart_review<?php }else{ ?>?module=ingreso&fromurl=<?=urlencode("?module=cart_review")?><?php } ?>'" class="boton_encuesta"> </td>
    </tr>
  </table>

<br />
<br />
<br />


  <?php }else{ 
  	die("error: 34290f;");
  } ?>


	
	</td>
  </tr>
</table>
                
                
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>