<?php
require_once("../includes/includes.php");
$Common=new Common();
?>
<?php
if(isset($_POST["fk_pais"])){
?>
<select name="fk_estado" id="fk_estado" onChange="new Ajax.Updater('selCiudad','/ajax_resp/registro_selects.php',{method:'post',parameters:'fk_estado=' + this.value}); $('edo').value=this.value"> 
<option value="0"><?=_("Seleccione")?></option>
      <?php $Common->llenarComboDb(TBL_ESTADOS,"pk_estado","estado","fk_pais",intval($_POST["fk_pais"]),intval($_POST["sel"]),"","estado asc"); ?>
</select>
<script language="javascript" type="text/javascript">
new Ajax.Updater('selCiudad','/ajax_resp/registro_selects.php',{method:'post',parameters:'fk_estado=' + $("fk_estado").value})
</script>
<?php }else if(isset($_POST["fk_estado"])){ ?>
<select name="fk_ciudad" id="fk_ciudad" onchange="$('cty').value=this.value">
<option value="0"><?=_("Seleccione")?></option>
      <?php $Common->llenarComboDb(TBL_CIUDADES,"pk_ciudad","ciudad","fk_estado",intval($_POST["fk_estado"]),intval($_POST["sel"]),"","ciudad asc"); ?>
</select>
<?php 
}else{

}
?>