<?php
$Admin->chkPermisosAdmin(12);
$ordenes = $Shop->searchOrders($_GET,10,$_GET["page"]);

?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="brd1">
  <tr>
    <td colspan="5" class="t1">Pedidos Encontrados  </td>
  </tr>
<?php if(sizeof($ordenes["results"])==0){ ?>
  <tr>
    <td colspan="5">No se encontraron pedidos</td>
  </tr>

<?php }else{ ?>
  <tr>
    <td class="t5">#Pedido</td>
    <td class="t5">Cliente</td>
    <td class="t5">Fecha</td>
    <td class="t5">Vendedor</td>
    <td class="t5">Estatus</td>
  </tr>
  <?php foreach($ordenes["results"] as $key => $value){ ?>
  <tr>
    <td><a href="?module=order_detail&i=<?=$value["pk_orden"]?>"><?=sprintf("%05d",$value["pk_orden"])?></a></td>
    <td><?=$value["nombres"]?> <?=$value["apellidos"]?></td>
    <td><?=date("d/m/Y",strtotime($value["fecha"]))?></td>
    <td><?=$value["A_nombres"]?></td>
    <td><?=$value["estatus"]?></td>
  </tr>
  <?php } ?>
 <tr>
    <td colspan="5" align="right"><?=$Shop->paginateResults($ordenes)?></td>
  </tr>
<?php } ?>
</table>
<br />
<br />

  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="brd1">
  <form id="form1" name="form1" method="get" action="">
    <tr>
      <td colspan="2" class="t1">Buscar pedido #
        <input name="pk1" type="text" id="pk1" size="6" maxlength="6" /> <input type="button" name="Button" value="&gt;&gt;" onclick="document.location='?module=order_detail&i=' + $('pk1').value" /></td>
    </tr>
    <tr>
      <td class="t3">Estatus de pedido</td>
      <td><select name="fk_orden_estado[]" size="6" multiple="multiple" id="fk_orden_estado[]">
        
          <?php $Common->llenarComboDb(TBL_ORDENES_ESTADO,"pk_orden_estado","estatus","",0,$_GET["fk_orden_estado"],"","pk_orden_estado asc"); ?>
              </select>      </td>
    </tr>
    <tr>
      <td class="t3">Fecha de pedido</td>
      <td><span class="t2">Desde 
        <input type="text" name="fecha_inia" id="fecha_inia" readonly="1" value="<?php if(isset($_GET["fecha_inia"])){ echo date("Y-m-d",strtotime($_GET["fecha_inia"])); }else{ echo date("Y-m-d",strtotime("2000/1/1")); }?>" class="required" />
            <img src="/images/admin/24px-Crystal_Clear_app_date.png" name="f_trigger_c" align="absmiddle" id="f_trigger_c" style="cursor: pointer;" title="Date selector"/>
            <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_inia",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
          </script>
        Hasta
        <input type="text" name="fecha_fina" id="fecha_fina" readonly="1" value="<?php if(isset($_GET["fecha_fina"])){ echo date("Y-m-d",strtotime($_GET["fecha_fina"])); }else{ echo date("Y-m-d",strtotime("2020/12/31")); }?>" class="required" />
        <img src="/images/admin/24px-Crystal_Clear_app_date.png" align="absmiddle" id="f_trigger_c2" style="cursor: pointer;" title="Date selector"/>
        <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_fina",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c2",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script>
      </span></td>
    </tr>
    <tr>
      <td class="t3">Vendedor</td>
      <td><select name="fk_administrador[]" size="4" multiple="multiple" id="fk_administrador[]" >
       
          <?php $Common->llenarComboDb(TBL_ADMINISTRADORES,"pk_administrador","nombres","",0,$_GET["fk_administrador"],"","nombres asc"); ?>
              </select>      </td>
    </tr>
    <tr>
      <td class="t3">Cliente</td>
      <td><input type="text" name="cliente" id="cliente" value="<?=$_GET["cliente"]?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="module" type="hidden" id="module" value="<?=$_GET["module"]?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Buscar" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	</form>
  </table>

