 <?php
if(!isset($_SESSION["user"])){
	echo "<script> document.location='/' </script>";
	exit;
}

$rsTmp = $Shop->getDireccionesUsuario(array("fk_usuario" => $_SESSION["user"]["pk_usuario"]));
?>
<script language="javascript" type="text/javascript">

	function $RF(el, radioGroup) {
	if($(el).type == 'radio') {
		var el = $(el).form;
		var radioGroup = $(el).name;
	} else if ($(el).tagName.toLowerCase() != 'form') {
		return false;
	}
	return $F($(el).getInputs('radio', radioGroup).find(
		function(re) {return re.checked;}
	));
}
	
	function chkaddr(){
		var shipaddr = $RF('cartAddr','shipaddr');
		var billaddr = $RF('cartAddr','billaddr');
		if(shipaddr!='' && billaddr!=''){
			$('cartAddr').action='?module=cart_review';
			$('cartAddr').submit();
		}else{
			return false;
		}
	}
</script>
<table width="100%" border="0" cellpadding="20" cellspacing="10" class="tablaBgPuntos">
  <tr>
    <td bgcolor="#FFFFFF">
	<form id="cartAddr" name="cartAddr" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="4"><span class="titulorojo_destacado"><?=_("Seleccione las direcciones de envío de tu pedido y de tu factura")?> </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><br />
<a href="?module=account_address_adtedt&fromurl=<?=urlencode("?module=cart_addr")?>" class="btnvercesta"><?=_("Agregar una nueva dirección")?></a><br /><br />

</td>
    </tr>
    <?php if(sizeof($rsTmp["results"])>0){?>
    <tr>
      <td><a name="tope" id="tope"></a></td>
      <td class="azuloscuroG" id="shiptop"><strong><?=_("Envienme el pedido a")?>: </strong></td>
      <td>&nbsp;</td>
      <td id="billtop"><strong class="azuloscuroG"><?=_("Envienme la factura a")?>: </strong></td>
    </tr>
    <?php foreach($rsTmp["results"] as $key=>$results){?>
    <tr>
      <td valign="top"><input name="shipaddr" id="shipaddr" type="radio" value="<?=md5(HASH . $results["pk_direccion"])?><?=$results["pk_direccion"]?>"<?php if($key==0){ ?> checked="checked"<?php } ?> /></td>
      <td valign="top" class="bioboton">
       <?=_("Persona de contacto")?>:
        <?=$results["persona_contacto"]?>
        <br />
        <?=_("Teléfono")?>:
        <?=$results["telefono"]?>
        <br />
        <?=_("Dirección")?>:
        <?=$results["direccion"]?>
        <br />
        <?=_("Urbanización")?>:
        <?=$results["urbanizacion"]?>
        <br />
        <?=_("Ciudad")?>:
        <?=utf8_decode($results["ciudad"])?>
        <br />
       <?=_("Estado")?>:
        <?=utf8_decode($results["estado"])?>
        <br />
        <?=_("País")?>:
        <?=utf8_decode($results["pais"])?></td>
      <td valign="top"><input name="billaddr" id="billaddr" type="radio" value="<?=md5(HASH . $results["pk_direccion"])?><?=$results["pk_direccion"]?>"<?php if($key==0){ ?> checked="checked"<?php } ?>/></td>
      <td valign="top" class="bioboton"> 
      <?=_("Persona de contacto")?>:
        <?=$results["persona_contacto"]?>
        <br />
        <?=_("Teléfono")?>:
        <?=$results["telefono"]?>
        <br />
        <?=_("Dirección")?>:
        <?=$results["direccion"]?>
        <br />
        <?=_("Urbanización")?>:
        <?=$results["urbanizacion"]?>
        <br />
        <?=_("Ciudad")?>:
        <?=utf8_decode($results["ciudad"])?>
        <br />
        <?=_("Estado")?>:
        <?=utf8_decode($results["estado"])?>
        <br />
       <?=_("País")?>:
        <?=utf8_decode($results["pais"])?>
		<p>&nbsp;</p>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="4" align="center">
      <input name="" type="button" value="<?=_("Siguiente")?> &raquo;" onclick="chkaddr()" class="boton_encuesta">
      </td>
    </tr>
    <?php }else{ ?>
    <tr>
      <td colspan="4" class="bioboton"><?=_("Su cuenta no tiene ninguna dirección asociada, para continuar debe ingresar el menos una dirección haciendo click en el botón &quot;Agregar una nueva dirección&quot;")?></td>
    </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
	</td>
  </tr>
</table>