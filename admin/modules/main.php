<?php
if(!$Admin->isAdmin()){
	require("login.php");
}else{
?>
<?php
if(intval($_GET["pk_orden_estado"])==0){
	$estado=1;
}else{
	$estado=intval($_GET["pk_orden_estado"]);
}
$ordenes = $Shop->getOrders(array("pk_orden_estado" => $estado,"orderby" => "pk_orden asc"),10,$_GET["page"]);
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="brd1">
  <tr>
    <td colspan="4" class="t1">Pedidos 
      <select name="pk_orden_estado" id="pk_orden_estado" onchange="document.location='?module=<?=$GLOBALS["modulo"]?>&pk_orden_estado=' + this.value">
      <?php $Common->llenarComboDb(TBL_ORDENES_ESTADO,"pk_orden_estado","estatus","",0,$estado,"","pk_orden_estado asc"); ?>
      </select>    </td>
  </tr>
<?php if(sizeof($ordenes["results"])==0){ ?>
  <tr>
    <td colspan="4">No se encontraron pedidos</td>
  </tr>

<?php }else{ ?>
  <tr>
    <td class="t5">#Pedido</td>
    <td class="t5">Cliente</td>
    <td class="t5">Fecha</td>
    <td class="t5">Vendedor</td>
  </tr>
  <?php foreach($ordenes["results"] as $key => $value){ ?>
  <tr>
    <td><a href="?module=order_detail&i=<?=$value["pk_orden"]?>"><?=sprintf("%05d",$value["pk_orden"])?></a></td>
    <td><a href="?module=usuarios&edt=<?=$value["fk_usuario"]?>">
      <?=$value["nombres"]?> 
      <?=$value["apellidos"]?></a></td>
    <td><?=date("d/m/Y",strtotime($value["fecha"]))?></td>
    <td><a href="?module=administradores&edt=<?=$value["fk_administrador"]?>">
      <?=$value["A_nombres"]?>
    </a></td>
  </tr>
  <?php } ?>
 <tr>
    <td colspan="4" align="right"><?=$Shop->paginateResults($ordenes)?></td>
  </tr>
<?php } ?>

</table>

<p>&nbsp;</p>
<?php } ?>