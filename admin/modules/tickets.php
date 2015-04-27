<?php
$Admin->chkPermisosAdmin(13);
?>

  <table width="100%" border="0" cellpadding="0" cellspacing="2" class="brd1">
    <tr>
      <td colspan="2" class="t1">Buscar comunicaciones #
        <input name="pk1" type="text" id="pk1" size="6" maxlength="6" /> <input type="button" name="Button" value="&gt;&gt;" onclick="document.location='?module=ticket_detail&i=' + $('pk1').value" /></td>
    </tr>
<form id="form1" name="form1" method="get" action="">
    <tr>
      <td class="t3">Fecha de apertura: </td>
      <td class="t2">Desde
        <input type="text" name="fecha_inia" id="fecha_inia" readonly="1" value="<?php if(isset($_GET["fecha_inia"])){ echo date("Y-m-d",strtotime($_GET["fecha_inia"])); }else{ echo "2000-01-01"; }?>" class="required" />
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
        </script></td>
    </tr>
    <tr>
      <td class="t3">Fecha de &uacute;ltima respuesta: </td>
      <td class="t2">Desde
        <input type="text" name="fecha_iniu" id="fecha_iniu" readonly="1" value="<?php if(isset($_GET["fecha_iniu"])){ echo date("Y-m-d",strtotime($_GET["fecha_iniu"])); }else{ echo "2000-01-01"; }?>" class="required" />
          <img src="/images/admin/24px-Crystal_Clear_app_date.png" align="absmiddle" id="f_trigger_c3" style="cursor: pointer;" title="Date selector"/>
          <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_iniu",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c3",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script>
        Hasta
        <input type="text" name="fecha_finu" id="fecha_finu" readonly="1" value="<?php if(isset($_GET["fecha_finu"])){ echo date("Y-m-d",strtotime($_GET["fecha_finu"])); }else{ echo date("Y-m-d",strtotime("2020/12/31")); }?>" class="required" />
        <img src="/images/admin/24px-Crystal_Clear_app_date.png" align="absmiddle" id="f_trigger_c4" style="cursor: pointer;" title="Date selector"/>
        <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_finu",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c4",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script></td>
    </tr>
	<tr>
      <td class="t3">Tipo:</td>
      <td class="t2"><select name="fk_ticket_tipo" id="fk_ticket_tipo">
	  <option value="">Cualquiera</option>
          <?php $Common->llenarComboDb(TBL_TICKETS_TIPO,"pk_ticket_tipo","tipo","",0,$_GET["fk_ticket_tipo"],"","pk_ticket_tipo asc"); ?>
      </select></td>
    </tr>
    <tr>
      <td class="t3">Estatus:</td>
      <td class="t2"><select name="fk_ticket_estado" id="fk_ticket_estado">
	   <option value="">Cualquiera</option>
          <?php $Common->llenarComboDb(TBL_TICKETS_ESTADOS,"pk_ticket_estado","estado","",0,$_GET["fk_ticket_estado"],"","pk_ticket_estado asc"); ?>
      </select></td>
    </tr>
    <tr>
      <td class="t3">Cliente:</td>
      <td class="t2"><input type="text" name="cliente" id="cliente" value="<?=$_GET["cliente"]?>" /></td>
    </tr>
    <tr>
      <td class="t3">&nbsp;</td>
      <td class="t2"><input type="submit" name="Submit" value="Buscar" />
      <input name="module" type="hidden" id="module" value="<?=$_GET["module"]?>" /></td>
    </tr>
</form>
  </table>
<br />
<br />
<?php
$tickets = $Shop->busquedaTicket($_GET,20,$_GET["page"]);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="brd1">
<tr>
    <td colspan="7" class="t1">Comunicaciones</td>
  </tr>
  <?php if(sizeof($tickets["results"])!=0){ ?>
  <tr>
    <td class="t5">Comunicaci&oacute;n</td>
    <td class="t5">Apertura</td>
    <td class="t5">Ult resp</td>
    <td class="t5">Tipo</td>
    <td class="t5">Asociaci&oacute;n</td>
    <td class="t5">Cliente</td>
    <td class="t5">Estatus</td>
  </tr>
<?php foreach($tickets["results"] as $keyT => $valueT){ ?>
  <tr>
    <td><a href="?module=ticket_detail&i=<?=$valueT["pk_ticket"]?>" target="_blank"><?=sprintf("%05d",$valueT["pk_ticket"])?></a></td>
    <td><?=date("d/m/Y H:i",strtotime($valueT["fecha_apertura"]))?></td>
    <td><?=date("d/m/Y H:i",strtotime($valueT["fecha_last_request"]))?></td>
    <td><?=$valueT["tipo"]?></td>
    <td><a href="<?php if($valueT["fk_ticket_tipo"]==1){ ?>?module=order_detail&i=<?=$valueT["fk_pk_relacionado"]?><?php }else{ ?>#<?php } ?>"><?=sprintf("%05d",$valueT["fk_pk_relacionado"])?></a></td>
    <td><a href="?module=usuarios&edt=<?=$valueT["fk_usuario"]?>" ><?=$valueT["nombres"]?></a></td>
    <td><?=$valueT["estado"]?></td>
  </tr>
<?php } ?>
<tr>
    <td colspan="7" align="right"><?=$Shop->paginateResults($tickets)?></td>
  </tr>
  <?php }else{ ?>
  <tr>
    <td colspan="7" class="ntf1">No se encontraron registros</td>
  </tr>
  <?php } ?>
</table>
