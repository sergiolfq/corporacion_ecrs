
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
 	/*
	$billaddr = substr($_POST["billaddr"],32,strlen($_POST["billaddr"]));
	$shipaddr = substr($_POST["shipaddr"],32,strlen($_POST["shipaddr"]));
	if(md5(HASH . $billaddr) == substr($_POST["billaddr"],0,32) && md5(HASH . $shipaddr) == substr($_POST["shipaddr"],0,32) && isset($_SESSION["user"])){
		$_SESSION["cart"]["billaddr"]=$billaddr;
		$_billaddr = $Shop->getDireccionesUsuario(array(
		"pk_direccion"=>intval($billaddr),
		"fk_usuario"=>$_SESSION["user"]["pk_usuario"]
		));
		$_billaddr =$_billaddr["results"][0];
		
		$_SESSION["cart"]["shipaddr"]=$shipaddr;
		$_shipaddr = $Shop->getDireccionesUsuario(array(
		"pk_direccion"=>intval($shipaddr),
		"fk_usuario"=>$_SESSION["user"]["pk_usuario"]
		));
		$_shipaddr =$_shipaddr["results"][0];
		
	}else{
		die("Ocurrio un error:  #32498");
	}
	*/
?>

<?php if(sizeof($cart)>0){?>

<table width="95%" border="0" align="center" cellpadding="5" cellspacing="2" class="tablaBgPuntos">
  <tr>
    <td bgcolor="#FFFFFF">

<div class="titulorojo_destacado" ><?=_("Su pedido")?> </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
   <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td class="azuloscuroG"><strong>SKU</strong></td>
      <td class="azuloscuroG"><strong><?=_("Producto")?></strong></td>
     
      <td align="right" class="azuloscuroG"><strong><?=_("Cant.")?></strong></td>
     
    </tr>
    <?php 
	foreach($cart as $key => $value){
	?>
    <tr>
      <td valign="top"><?=$value["sku"]?></td>
      <td valign="top"><?=$value["nombre" . $_SESSION["LOCALE"]]?>
      <div class="variantesCart">
      <?php
      foreach($value["variantes"] as $kxv => $vxv){
	  	$vari =$Shop->getVariantesTipo(array("pk_variante_tipo"=>$vxv));
		echo $vari["results"][0]["variante"] . ": " . $vari["results"][0]["variante_tipo"] . "<br>";
	  } 
	  ?>
      </div>
      </td>
     
      <td align="right" valign="top"><?=$value["qty"]?></td>
    </tr>
    <?php } ?>
   
    <tr>
      <td colspan="4" align="center" class="totales"><br /><br /><br />

	  <a href="?module=cart" class="btnvercesta">&laquo; <?=_("Deseo modificar este pedido")?></a>      </td>
    </tr>
  </table>

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center">
    <input name="" type="button" value="<?=_("Toda la información está correcta, finalizar")?> &raquo;" onclick="document.location='?module=cart_end'" class="boton_encuesta">
    </td>
  </tr>
</table>
<br />
<br />
	</td>
  </tr>
</table>




    <?php }else{ 
  	die("error: 34290f;");
  } ?>

                
                
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>