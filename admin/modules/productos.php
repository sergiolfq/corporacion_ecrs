<?php
$Admin->chkPermisosAdmin(7);
if(isset($_GET["delpic"]) && !isset($_POST["pk_producto"])){
	@unlink(SERVER_ROOT . "images/products/" . $_GET["delpic"]);
	$mensaje ="Foto eliminada";
}
if(intval($_POST["pk_producto"])==0 && trim($_POST["sku"])!=""){
	$Shop->addProducto($_POST,$_FILES);
	//unset($_POST);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_producto"])>0){
	$Shop->editProducto($_POST,$_FILES);
	//unset($_POST);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Shop->deleteProducto($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}

if(intval($_GET["edt"])>0){
	$arr = array("pk_producto" => intval($_GET["edt"]));
	$rs = $Shop->getProducto($arr);
}

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="comprueba(); return false">
  <table width="100%" border="0" class="brd1">
    <tr>
      <td colspan="2" class="t1"><span style="float:left ">
        <?php if(isset($_GET["edt"])){?>
        Editar
        <?php }else{ ?>
        Agregar
        <?php } ?>
		 Producto 
        </span>
          <?php if(isset($_GET["edt"])){?>
        <span style="float:right;"><a href="?module=<?=$_GET["module"]?>" class="t1">Nuevo</a></span>
        <?php } ?></td>
    </tr>
	<tr>
      <td width="15%" valign="top" class="t3">CDG</td>
      <td valign="top"><input name="sku" type="text" id="sku" size="25" maxlength="255" class="required<?php if(!isset($_GET["edt"])){?> comprueba-sku<?php } ?>" value="<?=$rs["results"][0]["sku"]?>" /><input name="pk_producto" type="hidden" id="pk_producto" value="<?=$rs["results"][0]["pk_producto"]?>" /></td>
	</tr>
	<tr>
      <td width="15%" valign="top" class="t3">Estatus</td>
      <td valign="top"><select name="fk_estatus" id="fk_estatus">
	  <?php $Common->llenarComboDb(TBL_ESTATUS,"pk_estatus","estatus","",0,intval($rs["results"][0]["fk_estatus"]),"","pk_estatus asc"); ?>
      </select>      </td>
	</tr>
  
    <tr>
      <td width="15%" valign="top" class="t3">Destacar</td>
      <td valign="top"><input name="fk_destacado" type="radio" value="0" <?php if(intval($rs["results"][0]["fk_destacado"])==0){?> checked="checked"<?php } ?> />
        No
          <input name="fk_destacado" type="radio" value="1" <?php if(intval($rs["results"][0]["fk_destacado"])==1){?> checked="checked"<?php } ?> />
Si </td>
</tr>
<tr>
      <td width="15%" valign="top" class="t3">Promocion</td>
      <td valign="top"><input name="fk_oferta" type="radio" value="0" <?php if(intval($rs["results"][0]["fk_oferta"])==0){?> checked="checked"<?php } ?> />
        No
          <input name="fk_oferta" type="radio" value="1" <?php if(intval($rs["results"][0]["fk_oferta"])==1){?> checked="checked"<?php } ?> />
Si </td>
</tr>
	<tr>
      <td width="15%" valign="top" class="t3">Disponible desde</td>
      <td valign="top"><input type="text" name="fecha_ini" id="fecha_ini" readonly="1" value="<?=date("Y-m-d",strtotime($rs["results"][0]["fecha_ini"]))?>" class="required" />
        <img id="f_trigger_c" title="Date selector" style="cursor: pointer;" src="/images/admin/24px-Crystal_Clear_app_date.png"/>
        <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_ini",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script></td>
    </tr>
	<tr>
      <td width="15%" valign="top" class="t3">Disponible hasta</td>
      <td valign="top"><input type="text" name="fecha_fin" id="fecha_fin" readonly="1" value="<?php if(isset($rs["results"][0]["fecha_fin"])){ echo date("Y-m-d",strtotime($rs["results"][0]["fecha_fin"])); }else{ echo date("Y-m-d",strtotime("2020/12/31")); }?>" class="required" />
        <img id="f_trigger_c2" title="Date selector" style="cursor: pointer;" src="/images/admin/24px-Crystal_Clear_app_date.png"/>
        <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_fin",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c2",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script></td>
    </tr>
	<tr>
      <td width="15%" valign="top" class="t3">Fabricante</td>
      <td valign="top"><select name="fk_fabricante" id="fk_fabricante">
	  <?php $Common->llenarComboDb(TBL_FABRICANTES,"pk_fabricante","fabricante","",0,intval($rs["results"][0]["fk_fabricante"]),"","fabricante asc"); ?>
      </select>      </td>
	</tr> 
	<tr>
      <td width="15%" valign="top" class="t3">Nombre Espa&ntilde;ol</td>
      <td valign="top"><input name="nombre" type="text"  id="nombre" value="<?=$rs["results"][0]["nombre"]?>" size="50" maxlength="255" class="required" /></td>
    </tr>
    <tr>
      <td width="15%" valign="top" class="t3">Nombre  Ingl&eacute;s</td>
      <td valign="top"><input name="nombre_en" type="text"  id="nombre_en" value="<?=$rs["results"][0]["nombre_en"]?>" size="50" maxlength="255" class="required" /></td>
    </tr>
    <tr>
      <td width="15%" valign="top" class="t3">Nombre soporte Espa&ntilde;ol</td>
      <td valign="top"><input name="nombre_soporte" type="text"  id="nombre_soporte" value="<?=$rs["results"][0]["nombre_soporte"]?>" size="50" maxlength="255" class="required" /></td>
    </tr>
    <tr>
      <td width="15%" valign="top" class="t3">Nombre soporte  Ingl&eacute;s</td>
      <td valign="top"><input name="nombre_soporte_en" type="text"  id="nombre_soporte_en" value="<?=$rs["results"][0]["nombre_soporte_en"]?>" size="50" maxlength="255" class="required" /></td>
    </tr>
    
	<tr>
      <td valign="top" class="t3">Sumario Espa&ntilde;ol</td>
      <td valign="top"><textarea name="sumario" cols="50" rows="5" id="sumario" class="required"><?=$rs["results"][0]["sumario"]?></textarea></td>
    </tr>
    <tr>
      <td valign="top" class="t3">Sumario  Ingl&eacute;s</td>
      <td valign="top"><textarea name="sumario_en" cols="50" rows="5" id="sumario_en" class="required"><?=$rs["results"][0]["sumario_en"]?></textarea></td>
    </tr>
   
   
    <tr>
      <td valign="top" class="t3">Foto destacado (800x686pixeles) </td>
      <td valign="top"><input name="foto_destacado" type="file" id="foto_destacado" /><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/products/foto_dest_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/products/foto_dest_<?=$rs["results"][0]["pk_producto"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a> <a href="?module=<?=$_GET["module"]?>&delpic=foto_dest_<?=$rs["results"][0]["pk_producto"]?>.jpg&edt=<?=$rs["results"][0]["pk_producto"]?>">Eliminar foto actual</a>     <?php } ?></td>
    </tr>

    <tr>
      <td valign="top" class="t3">Foto promoci&oacute;n (800x686pixeles) </td>
      <td valign="top"><input name="foto_promocion" type="file" id="foto_promocion" /><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/products/foto_promo_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/products/foto_promo_<?=$rs["results"][0]["pk_producto"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a> <a href="?module=<?=$_GET["module"]?>&delpic=foto_promo_<?=$rs["results"][0]["pk_producto"]?>.jpg&edt=<?=$rs["results"][0]["pk_producto"]?>">Eliminar foto actual</a>     <?php } ?></td>
    </tr>
    
     <tr>
      <td valign="top" class="t3">Foto sumario (300x200pixeles) </td>
      <td valign="top"><input name="foto_sumario" type="file" id="foto_sumario" <?php if(isset($_GET["edt"]) && !file_exists(SERVER_ROOT . "images/products/tb_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>class="required" <?php } ?>/><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/products/tb_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/products/tb_<?=$rs["results"][0]["pk_producto"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a> <a href="?module=<?=$_GET["module"]?>&delpic=tb_<?=$rs["results"][0]["pk_producto"]?>.jpg&edt=<?=$rs["results"][0]["pk_producto"]?>">Eliminar foto actual</a>     <?php } ?></td>
    </tr>
    
    
     <tr>
      <td valign="top" class="t3">Foto banner superior:<br>
Espa&ntilde;ol (980x215pixeles) </td>
      <td valign="top"><input name="foto_banner" type="file" id="foto_banner" <?php if(isset($_GET["edt"]) && !file_exists(SERVER_ROOT . "images/products/ban_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>class="required" <?php } ?>/><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/products/ban_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/products/ban_<?=$rs["results"][0]["pk_producto"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a> <a href="?module=<?=$_GET["module"]?>&delpic=ban_<?=$rs["results"][0]["pk_producto"]?>.jpg&edt=<?=$rs["results"][0]["pk_producto"]?>">Eliminar foto actual</a>     <?php } ?></td>
    </tr>
    <tr>
      <td valign="top" class="t3">Foto banner superior:<br>
Ingl&eacute;s  (980x215pixeles) </td>
      <td valign="top"><input name="foto_banner_en" type="file" id="foto_banner_en" <?php if(isset($_GET["edt"]) && !file_exists(SERVER_ROOT . "images/products/ban_en_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>class="required" <?php } ?>/><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/products/ban_en_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/products/ban_en_<?=$rs["results"][0]["pk_producto"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a> <a href="?module=<?=$_GET["module"]?>&delpic=ban_en_<?=$rs["results"][0]["pk_producto"]?>.jpg&edt=<?=$rs["results"][0]["pk_producto"]?>">Eliminar foto actual</a>     <?php } ?></td>
    </tr>
    
    <?php for($a=1;$a<=1;$a++){ ?>

	 <tr>
      <td valign="top" class="t3">Foto grande <?=$a?><br />
        (800x686pixeles)</td>
      <td valign="top"><input name="pic_<?=$a?>" type="file" id="pic_<?=$a?>" /><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/products/pic_" . $a . "_" . $rs["results"][0]["pk_producto"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/products/pic_<?=$a?>_<?=$rs["results"][0]["pk_producto"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a> <a href="?module=<?=$_GET["module"]?>&delpic=pic_<?=$a?>_<?=$rs["results"][0]["pk_producto"]?>.jpg&edt=<?=$rs["results"][0]["pk_producto"]?>">Eliminar foto actual</a>     <?php } ?></td>
    </tr>
    <?php } ?>
	  
    <tr>
      <td valign="top" class="t3">Categor&iacute;as</td>
      <td valign="top"><?php 
	  $AGGvars = array("versus"=>TBL_PRODUCTOS_VS_CATEGORIAS,"fk"=>"fk_producto","tabla"=>TBL_CATEGORIAS,"pk"=>"pk_categoria","fk_1"=>"fk_categoria","campo_buscar"=>"categoria");
	  include("vs_aggregator.php"); 
	  ?></td>
    </tr>
    <!--
	<tr>
      <td valign="top" class="t3">Proveedores</td>
      <td valign="top"><?php 
	  $AGGvars = array("versus"=>TBL_PRODUCTOS_VS_PROVEEDORES,"fk"=>"fk_producto","tabla"=>TBL_PROVEEDORES,"pk"=>"pk_proveedor","fk_1"=>"fk_proveedor","campo_buscar"=>"proveedor");
	  include("vs_aggregator.php");  
	  ?></td>
    </tr>
-->
    <tr>
      <td valign="top" class="t3">Productos relacionados</td>
      <td valign="top"><?php 
	  $AGGvars = array("versus"=>TBL_PRODUCTOS_RELACIONADOS,"fk"=>"fk_producto_origen","tabla"=>TBL_PRODUCTOS,"pk"=>"pk_producto","fk_1"=>"fk_producto_destino","campo_buscar"=>"nombre");
	  include("vs_aggregator.php");  
	  ?></td>
    </tr>
 
    <?php
    $variantes = $Shop->getVariantes();
	
	foreach($variantes["results"] as $kv => $vv){
		$variantesTipo=$Shop->getVariantesTipo(array("fk_variante"=>$vv["pk_variante"]));
	?>
     <tr>
      <td valign="top" class="t3"><?=$vv["variante"]?></td>
      <td valign="top">
      <div style="border:1px dotted #CCCCCC;  width:50%; "><div style="padding:5px;">
      <?php
	  		foreach($variantesTipo["results"] as $kvt => $vvt){ 
				$variantesproducto = $Shop->getVariantesTipoByProducto(array("fk_producto"=>$rs["results"][0]["pk_producto"],"pk_variante_tipo"=>$vvt["pk_variante_tipo"]));	
	  ?>
      <input name="variantes[]" type="checkbox" id="variantes_<?=$vvt["pk_variante_tipo"]?>" value="<?=$vvt["pk_variante_tipo"]?>" <?php if(sizeof($variantesproducto["results"])>0){?>checked="checked"<?php } ?> /> <?=$vvt["variante_tipo"]?><br>
      <?php 
	 		 } 
	  ?>
      </div>
      </div>
      </td>
    </tr>
    <?php
    }
	?>
    
<?php
$camposTXT = array("General","Valor","Referencias","Especificaciones","Caracteristicas","Accesorios");
foreach($camposTXT as $ktx => $vtx){
?>    
	<tr>
      <td colspan="2"class="t5">
	  <?php //foreach($camposTXT as $ktx => $vtx){ echo '"' . strtolower($vtx) . '","' . strtolower($vtx) . '_en",'; } ?>
	  <?=$vtx?>  Espa&ntilde;ol</td>
	</tr>
	<tr>
      <td colspan="2"><pre id="idTemporary<?=$ktx?>" name="idTemporary<?=$ktx?>" style="display:none"><?=trim($rs["results"][0][strtolower($vtx)])?></pre>
<input name="<?=strtolower($vtx)?>" type="hidden" id="<?=strtolower($vtx)?>" value="">
<script>
var oEdit1<?=$ktx?> = new InnovaEditor("oEdit1<?=$ktx?>");
oEdit1<?=$ktx?>.width="100%"
oEdit1<?=$ktx?>.cmdAssetManager="modalDialogShow('/includes/editor/assetmanager/assetmanager.php?lang=spanish',640,465)";
oEdit1<?=$ktx?>.features=["FullScreen","Preview","Print","Search",
			"Cut","Copy","Paste","PasteWord","PasteText","|","Undo","Redo","|",
			"ForeColor","BackColor","|","Bookmark","Hyperlink",
			"HTMLSource","BRK","Numbering","Bullets","|","Indent","Outdent","LTR","RTL","|","Image","Flash","Media","|",
			"Table","Guidelines","Absolute","|","Characters","Line",
			"Form","Clean","ClearAll","BRK",
			"StyleAndFormatting","TextFormatting","ListFormatting","BoxFormatting",
			"ParagraphFormatting","CssText","Styles","|",
			"Paragraph","FontName","FontSize","|",
			"Bold","Italic",
			"Underline","Strikethrough","|","Superscript","Subscript","|",
			"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull"];
oEdit1<?=$ktx?>.css='/style/style.css';
oEdit1<?=$ktx?>.RENDER(document.getElementById("idTemporary<?=$ktx?>").innerHTML);
</script>
</td>
    </tr>
    
    <tr>
      <td colspan="2"class="t5"><?=$vtx?>  Ingl&eacute;s</td>
	</tr>
	<tr>
      <td colspan="2"><pre id="idTemporary_en<?=$ktx?>" name="idTemporary_en<?=$ktx?>" style="display:none"><?=trim($rs["results"][0][strtolower($vtx)."_en"])?></pre>
<input name="<?=strtolower($vtx)?>_en" type="hidden" id="<?=strtolower($vtx)?>_en" value="">
<script>
var oEdit2<?=$ktx?> = new InnovaEditor("oEdit2<?=$ktx?>");
oEdit2<?=$ktx?>.width="100%"
oEdit2<?=$ktx?>.cmdAssetManager="modalDialogShow('/includes/editor/assetmanager/assetmanager.php?lang=spanish',640,465)";
oEdit2<?=$ktx?>.features=["FullScreen","Preview","Print","Search",
			"Cut","Copy","Paste","PasteWord","PasteText","|","Undo","Redo","|",
			"ForeColor","BackColor","|","Bookmark","Hyperlink",
			"HTMLSource","BRK","Numbering","Bullets","|","Indent","Outdent","LTR","RTL","|","Image","Flash","Media","|",
			"Table","Guidelines","Absolute","|","Characters","Line",
			"Form","Clean","ClearAll","BRK",
			"StyleAndFormatting","TextFormatting","ListFormatting","BoxFormatting",
			"ParagraphFormatting","CssText","Styles","|",
			"Paragraph","FontName","FontSize","|",
			"Bold","Italic",
			"Underline","Strikethrough","|","Superscript","Subscript","|",
			"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull"] ;
oEdit2<?=$ktx?>.css='/style/style.css';
oEdit2<?=$ktx?>.RENDER(document.getElementById("idTemporary_en<?=$ktx?>").innerHTML);

</script>
</td>
    </tr>
   <?php } ?>    
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
  <script type="text/javascript">
  var valid = new Validation('form1', {immediate : true,focENOnError : true});
  Validation.add('comprueba-sku','El SKU ya se encuentra registrado',function(v,elm) {
		
						if(elm._ajaxValidating && elm._hasAjaxValidateResult) {
								elm._ajaxValidating = false;
								elm._hasAjaxValidateResult = false;
								return elm._ajaxValidateResult;
						}
						var sendRequest = function() {
								new Ajax.Request('/admin/ajax_resp/chk_sku.php',{
										parameters : 'sku=' + encodeURIComponent(v),
										onSuccess : function(response) {
												elm._ajaxValidateResult = eval(response.responseText);
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
	  	function comprueba(){
			<?php foreach($camposTXT as $ktx => $vtx){ ?>
			document.getElementById("<?=strtolower($vtx)?>").value=oEdit1<?=$ktx?>.getHTMLBody();
			document.getElementById("<?=strtolower($vtx)?>_en").value=oEdit2<?=$ktx?>.getHTMLBody();
			<?php } ?>
			
			if(valid.validate())  form1.submit();

			return false;
		}
		
		
		
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="?module=<?=$_GET["module"]?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
      <td colspan="3" class="t1"><a name="bupro" id="bupro"></a>Productos 
      <input type="text" name="buscarPro" id="buscarPro" value="<?=$_GET["buscarPro"]?>" /> <input type="button" name="button" id="button" value="&raquo;&raquo;" onclick="buscarProducto()" /></td>
       <script type="text/javascript">
	  	function bENcarProducto(){
     	 	document.location='?module=<?=$_GET["module"]?>&bENcarPro=' + encodeURIComponent($('bENcarPro').value)
		}
	  </script>
    </tr>
    <tr>
	 <td class="t5">SKU</td>
      <td class="t5">Nombre</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
if(trim($_GET["buscarPro"])==''){
	$rss = $Shop->getProducto('',$_GET["page"]);
}else{
	$rss= $Shop->searchProducto($_GET["buscarPro"],"relevancia desc",$_GET["page"]);
}	
foreach($rss["results"] as $key => $value){
?>
    <tr <?php if($key%2==0){ ?>bgcolor="#FFFFCC"<?php } ?>>
	<td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_producto"]?>"><?=$value["sku"]?></a></td>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_producto"]?>"><?=$value["nombre"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_producto"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right" colspan="2"><?=$Shop->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
