<?php
$Admin->chkPermisosAdmin(12);
if(isset($_POST["pk_orden"])){
	$Shop->editOrder($_POST,$_SESSION);
	$mensaje ="El pedido fue editado";
}
$orden = $Shop->getOrders(array("pk_orden"=>intval($_GET["i"])));

$usuario = $Shop->busquedaUsuario(array(
	"pk_usuario" => intval($orden["results"][0]["fk_usuario"])
)); 
$productos= $Shop->getOrdersProducts(array(
    "fk_orden"=>intval($orden["results"][0]["pk_orden"])
));
$_billaddr = $Shop->getDireccionesUsuario(array(
	"pk_direccion"=>intval($orden["results"][0]["pk_direccion_bill"])
));
$_billaddr =$_billaddr["results"][0];
$_shipaddr = $Shop->getDireccionesUsuario(array(
	"pk_direccion"=>intval($orden["results"][0]["pk_direccion_ship"])
));
$_shipaddr =$_shipaddr["results"][0];

$tickets = $Shop->busquedaTicket(array(
"fk_ticket_tipo" =>1,
"fk_pk_relacionado" =>intval($orden["results"][0]["pk_orden"])
));

?>
<?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="brd1">
    <tr>
      <td colspan="2" class="t1">Detalle de pedido</td>
    </tr>
    <tr>
      <td colspan="2" class="t5">Datos del pedido</td>
    </tr>
    <tr>
      <td class="t3">Pedido:</td>
      <td><?=sprintf("%05d",$orden["results"][0]["pk_orden"])?><input type="hidden" name="pk_orden" value="<?=$orden["results"][0]["pk_orden"]?>" /> 
      </td>
    </tr>
    <tr>
      <td class="t3">Fecha:</td>
      <td><?=date("d/m/Y",strtotime($orden["results"][0]["fecha"]))?></td>
    </tr>
    <tr>
      <td class="t3">Estatus:</td>
      <td><select name="fk_orden_estado" id="fk_orden_estado">
          <?php $Common->llenarComboDb(TBL_ORDENES_ESTADO,"pk_orden_estado","estatus","",0,$orden["results"][0]["fk_orden_estado"],"","pk_orden_estado asc"); ?>
        </select><input type="hidden" name="fk_orden_estado_act" value="<?=$orden["results"][0]["fk_orden_estado"]?>" />      </td>
    </tr>
    <tr>
      <td class="t3">Vendedor:</td>
      <td><select name="fk_administrador" id="fk_administrador">
          <option value="0">Seleccione</option>
          <?php $Common->llenarComboDb(TBL_ADMINISTRADORES,"pk_administrador","nombres","",0,$orden["results"][0]["fk_administrador"],"","nombres asc"); ?>
        </select>      </td>
    </tr>
     <tr>
      <td valign="top" class="t3">Observaciones:</td>
      <td valign="top">
	  <div style="height:100px; width:400px; overflow:auto; border:1px solid #999999;">
	  <?=nl2br(trim($orden["results"][0]["observaciones"]))?>
	  </div>
	  <br>
       <textarea name="observaciones" id="observaciones" cols="60" rows="5"></textarea></td>
    </tr>
    <tr class="t3">
      <td colspan="2" class="t5">Datos del cliente</td>
    </tr>
    <tr>
      <td class="t3">Email:</td>
      <td><?=$usuario["results"][0]["email"]?></td>
    </tr>
    <tr>
      <td class="t3"><?php if($usuario["results"][0]["tipo_persona"]==1){?>
        Cédula:
        <?php }else{ ?>
        RIF:
        <?php } ?></td>
      <td><a href="?module=usuarios&edt=<?=$usuario["results"][0]["pk_usuario"]?>" target="_blank">
        <?=$usuario["results"][0]["cedula_rif"]?>
      </a></td>
    </tr>
    <tr>
      <td class="t3"><?php if($usuario["results"][0]["tipo_persona"]==1){?>
        Nombre:
          <?php }else{ ?>
        Raz&oacute;n social:
        <?php } ?></td>
      <td><?=$usuario["results"][0]["nombres"]?></td>
    </tr>
    <tr>
      <td class="t3"><?php if($usuario["results"][0]["tipo_persona"]==1){?>
        Apellido:
          <?php }else{ ?>
        Persona de contacto:
        <?php } ?></td>
      <td><?=$usuario["results"][0]["apellidos"]?></td>
    </tr>
	<?php if($usuario["results"][0]["tipo_persona"]!=1){?>
	<tr>
      <td class="t3">
        Direcci&oacute;n fiscal:
      </td>
      <td><?=$usuario["results"][0]["direccion"]?></td>
    </tr>
	<?php } ?>
    <tr>
      <td class="t3">Teléfono 1:</td>
      <td><?=$usuario["results"][0]["telefono1"]?></td>
    </tr>
    <tr>
      <td class="t3">Teléfono 2:</td>
      <td><?=$usuario["results"][0]["telefono2"]?></td>
    </tr>
    <tr>
      <td class="t3">Fax:</td>
      <td><?=$usuario["results"][0]["fax"]?></td>
    </tr>
    <tr>
      <td class="t3">Ciudad / Estado / Pa&iacute;s: </td>
      <td><?=utf8_decode($usuario["results"][0]["ciudad"])?>
        /
        <?=utf8_decode($usuario["results"][0]["estado"])?>
        /
        <?=utf8_decode($usuario["results"][0]["pais"])?></td>
    </tr>
    <tr>
      <td colspan="2" class="t5">Detalle del pedido</td>
    </tr>
    <tr>
      <td colspan="2" class="t3"><div id="productos">
        <?php require("./ajax_resp/order_products.php");?>
      </div>
      <script language="javascript" type="text/javascript">
	  function addProducto(){
	  	sku = encodeURIComponent($('sku').value)
		new Ajax.Request('/admin/ajax_resp/chk_sku.php',{method:'post',parameters: 'sku=' + sku,onComplete: function(obj) {
			respuesta = obj.responseText;
			if(respuesta=="true"){
				alert("El producto no existe en la base de datos")
			}else{
				var pregunta= confirm("Realmente desea agregar este producto?");
				if(pregunta){
					var myAjax = new Ajax.Updater('productos', '/admin/ajax_resp/order_products.php', { method: 'post', evalScripts: true, parameters: 'ajax=1&fk_banda_precio=<?=$usuario["results"][0]["fk_banda_precios"]?>&fk_moneda=<?=$orden["results"][0]["fk_moneda"]?>&productos_ser=' + encodeURIComponent($('productos_ser').value) + '&add_pro=' + sku, onComplete: function(){Effect.Appear('productos',{duration:0.5});} });
				}
			}
		}});
		return false;
	  }
	  
	  function delProducto(pk_producto){
	  	var pregunta= confirm("Realmente desea eliminar este producto?");
		if(pregunta){
			var myAjax = new Ajax.Updater('productos', '/admin/ajax_resp/order_products.php', { method: 'post', evalScripts: true, parameters: 'ajax=1&productos_ser=' + encodeURIComponent($('productos_ser').value) + '&del_pro=' + pk_producto, onComplete: function(){Effect.Appear('productos',{duration:0.5});} });
		}
		return false;
	  }
	  
	  function recalculaProducto(){		
	  
	  	var pregunta= confirm("Realmente desea recalcular este pedido?");
		if(pregunta){
			var myAjax = new Ajax.Updater('productos', '/admin/ajax_resp/order_products.php', { method: 'post', evalScripts: true, parameters: 'ajax=1&recalcula=1&' + $('form1').serialize(), onComplete: function(){Effect.Appear('productos',{duration:0.5});} });
		}
		return false;
	  
	  }
      </script>      </td>
    </tr>
    <tr>
      <td colspan="2" align="center"  class="t3"><input type="submit" name="button" id="button" value="Editar" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<script type="text/javascript">
  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  </script>
