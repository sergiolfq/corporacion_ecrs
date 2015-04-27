
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?=$Banners->showBanners(4);?></th>
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
if(!isset($_SESSION["user"])){
	echo "<script> document.location='/' </script>";
	exit;
}
if(!isset($_SESSION["order"]["pk_orden"])){
	$_SESSION["cart"]["billaddr"]=1;
	$_SESSION["cart"]["shipaddr"]=1;
	
	$pk_orden = sprintf("%05d",$Shop->saveCartOrder($_SESSION));
	$_SESSION["order"]["pk_orden"]=$pk_orden;
	
}else{
	$pk_orden = $_SESSION["order"]["$pk_orden"];
}



if(!isset($_SESSION["order"]["pedido"])){

?><?php
ob_start();
?>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="5" class="tablaBgPuntos">
  <tr>
    <td bgcolor="#FFFFFF">
	  <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><span class="azuloscuroG"><?=_("Gracias! su solicitud se ha realizado con exito")?></span></td>
        </tr>
      </table>
	  <br />
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?=_("En pocas horas verificaremos su pedido y le enviaremos la cotización del mismo")?>.
      <br />
      <br />
     <?=_(" Si en un lapso de 24 horas, no ha recibido un aviso de respuesta de nuestra parte por e-mail, por favor verifique la carpeta de correo no deseado (SPAM) de su cuenta de correo")?>.     </td>
  </tr>
</table>
	  <p>&nbsp;</p>
	  <table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="4">
	<div class="azuloscuroG"> <?=_("Pedido # ")?>
      <?=$pk_orden?>    </div></td>
  </tr>
    <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulosTablas"><strong>SKU</strong></td>
    <td class="titulosTablas"><strong><?=_("Producto")?></strong></td>
    <td align="right" class="titulosTablas"><strong><?=_("Cantidad")?></strong></td>
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
    <td colspan="4" align="right" class="totales">&nbsp;</td>
    </tr>
</table>
	<br />


<br />


	</td>
  </tr>
</table>

<?php
	$out1 = ob_get_contents();
	ob_end_clean();
	$_SESSION["order"]["pedido"]=$out1;
	echo $out1;
	$arreglovars = $_SESSION["user"];
	$arreglovars["pedido"]=$out1;
	$Shop->enviarFormMail("order" . $_SESSION["LOCALE_IMG"],$arreglovars,_("Su pedido en ") . SITE_NAME,$arreglovars["email"]);
	$Shop->enviarFormMail("order" . $_SESSION["LOCALE_IMG"],$arreglovars,_("Nuevo pedido en ") . SITE_NAME,MAIL_PEDIDOS);
	
}else{
	echo $_SESSION["order"]["pedido"];
}

unset($_SESSION["cart"]);

?>
                
                
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>