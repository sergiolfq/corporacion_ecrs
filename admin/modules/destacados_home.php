<?
$Admin->chkPermisosAdmin(11);
$max_pro=4;
$max_pro2=4;
$max_pro3=2;
if(isset($_POST["s"])){
	
	for($a=1;$a<=$max_pro+$max_pro2+$max_pro3;$a++){
		$path= SERVER_ROOT . "images/destacados/" . $a . ".gif";
		$rs = $Common->Execute("select pk_producto,sku from " . TBL_PRODUCTOS . " where sku='" . $Common->clearSql_S($_POST["sku_" . $a]) . "' and fk_estatus=1");
		$Common->ExecuteAlone("update " . TBL_PRODUCTOS_HOME . " set sku='" . $Common->clearSql_S($rs["results"][0]["sku"]) . "', fk_producto=" . intval($rs["results"][0]["pk_producto"]) . " where pk_producto_home=" . $a);
		
		if(is_uploaded_file($_FILES["imagen_" . $a ]['tmp_name'])){
			@unlink($path);
			move_uploaded_file($_FILES["imagen_" . $a ]["tmp_name"], $path);
			@chmod($path,0755);	
		}
		
	}
}
$rs = $Common->Execute("select * from " . TBL_PRODUCTOS_HOME);
?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0" cellpadding="4" cellspacing="0" class="brd1">
    <tr>
      <td colspan="3" class="t1">Productos destacados del home</td>
    </tr>
    <tr>
      <td width="50%" align="center" class="t5">SKU</td>
      <td align="center" class="t5">Im&aacute;gen</td>
      <td align="center" class="t5">Tipo</td>
    </tr>
    <? for($a=1;$a<=$max_pro;$a++){?>
    <tr>
      <td align="center"><input type="text" name="sku_<?=$a?>" id="sku_<?=$a?>" value="<?=trim($rs["results"][($a-1)]["sku"])?>" class="comprueba-sku" /><input type="hidden" name="fk_tipo_<?=$a?>" value="0" /></td>
      <td align="left"><input type="file" name="imagen_<?=$a?>" id="imagen_<?=$a?>" />
        ( 557px x 268px ) <? if(file_exists(SERVER_ROOT . "images/destacados/" . $a . ".gif")) { ?> 
      <a href="javascript:void(window.open('viewpic.php?foto=/images/destacados/<?=$a?>.gif' ,'foto','width=50,height=50'))">(ver foto actual)</a>      <? } ?></td>
      <td align="center">Principal</td>
    </tr>
    <? } ?>
    <? for($a=$max_pro+1;$a<=$max_pro2+$max_pro;$a++){?>
    <tr>
      <td align="center"><input type="text" name="sku_<?=$a?>" id="sku_<?=$a?>" value="<?=trim($rs["results"][($a-1)]["sku"])?>" class="comprueba-sku" /><input type="hidden" name="fk_tipo_<?=$a?>" value="1" /></td>
      <td align="left"><input type="file" name="imagen_<?=$a?>" id="imagen_<?=$a?>" />
        ( 142px x 220px ) <? if(file_exists(SERVER_ROOT . "images/destacados/" . $a . ".gif")) { ?> 
      <a href="javascript:void(window.open('viewpic.php?foto=/images/destacados/<?=$a?>.gif' ,'foto','width=50,height=50'))">(ver foto actual)</a>      <? } ?></td>
      <td align="center">Mas vendidos</td>
    </tr>
    <? } ?>
     <? for($a=$max_pro+$max_pro2+1;$a<=$max_pro3+$max_pro2+$max_pro;$a++){?>
    <tr>
      <td align="center"><input type="text" name="sku_<?=$a?>" id="sku_<?=$a?>" value="<?=trim($rs["results"][($a-1)]["sku"])?>" class="comprueba-sku" /><input type="hidden" name="fk_tipo_<?=$a?>" value="1" /></td>
      <td align="left"><input type="file" name="imagen_<?=$a?>" id="imagen_<?=$a?>" />
        ( 142px x 220px ) <? if(file_exists(SERVER_ROOT . "images/destacados/" . $a . ".gif")) { ?> 
      <a href="javascript:void(window.open('viewpic.php?foto=/images/destacados/<?=$a?>.gif' ,'foto','width=50,height=50'))">(ver foto actual)</a>      <? } ?></td>
      <td align="center">Destacados</td>
    </tr>
    <? } ?>
    <tr>
      <td colspan="3" align="center"><input type="hidden" name="s" value="1" /><input type="submit" name="button" id="button" value="Enviar" /></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
Validation.add('comprueba-sku','SKU no encontrado',function(v,elm) {
		
						if(elm._ajaxValidating && elm._hasAjaxValidateResult) {
								elm._ajaxValidating = false;
								elm._hasAjaxValidateResult = false;
								return elm._ajaxValidateResult;
						}
						var sendRequest = function() {
								new Ajax.Request('/admin/ajax_resp/chk_sku.php',{
										parameters : 'sku=' + encodeURIComponent(v),
										onSuccess : function(response) {
												if(eval(response.responseText))
													elm._ajaxValidateResult = false;
												else
													elm._ajaxValidateResult = true;
												
												elm._hasAjaxValidateResult = true;
												Validation.test('comprueba-sku',elm);
										}
								});
								elm._ajaxValidating = true;
								return true;
						}
		
						return elm._ajaxValidating || Validation.get('IsEmpty').test(v) || 
		sendRequest();
				});
  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  </script>
