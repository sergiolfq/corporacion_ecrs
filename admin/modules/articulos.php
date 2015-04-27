<?php
$Admin->chkPermisosAdmin(10);
if(intval($_POST["pk_articulo"])==0 && trim($_POST["titulo"])!=""){
	$Shop->addArticulo($_POST,$_FILES);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_articulo"])>0){
	$Shop->editArticulo($_POST,$_FILES);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Shop->deleteArticulo($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_articulo" => intval($_GET["edt"]));
	$rs = $Shop->getArticulo($arr);
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
        </span>
          <?php if(isset($_GET["edt"])){?>
        <span style="float:right;"><a href="?module=<?=$_GET["module"]?>" class="t1">Nuevo </a></span>
        <?php } ?></td>
    </tr>
    <tr>
      <td width="13%" valign="top" class="t3">Titulo</td>
      <td width="87%" valign="top"><input name="titulo" type="text" id="titulo" value="<?=$rs["results"][0]["titulo"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_articulo" type="hidden" id="pk_articulo" value="<?=$rs["results"][0]["pk_articulo"]?>" /></td>
    </tr>
	<tr>
      <td class="t3">Imagen sumario </td>
      <td><input name="imagen" type="file" id="imagen" <?php if(isset($_GET["edt"]) && !file_exists(SERVER_ROOT . "images/articulos/tb_" . $rs["results"][0]["pk_articulo"] . ".jpg")) { ?>class="required" <?php } ?>/><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/articulos/tb_" . $rs["results"][0]["pk_articulo"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/articulos/tb_<?=$rs["results"][0]["pk_articulo"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a>    <?php } ?></td>
	</tr>
	<tr>
      <td class="t3">Sumario</td>
      <td><textarea name="sumario" cols="40" rows="4" id="sumario"><?=$rs["results"][0]["sumario"]?></textarea></td>
	</tr>
	<tr>
      <td class="t3">Tipo:</td>
      <td><select name="fk_articulo_tipo" id="fk_articulo_tipo">
	  <?php $Common->llenarComboDb(TBL_ARTICULOS_TIPO,"pk_articulo_tipo","tipo","",0,intval($rs["results"][0]["fk_articulo_tipo"]),"","tipo asc"); ?>
      </select> </td>
	</tr>
	 <tr>
      <td valign="top" class="t3">Categor&iacute;as</td>
      <td valign="top"><?php 
	  $AGGvars = array("versus"=>TBL_ARTICULOS_VS_CATEGORIAS,"fk"=>"fk_articulo","tabla"=>TBL_CATEGORIAS,"pk"=>"pk_categoria","fk_1"=>"fk_categoria","campo_buscar"=>"categoria");
	  include("vs_aggregator.php"); 
	  ?></td>
    </tr>
	<tr>
      <td valign="top" class="t3">Productos relacionados</td>
      <td valign="top"><?php 
	  $AGGvars = array("versus"=>TBL_ARTICULOS_VS_PRODUCTOS,"fk"=>"fk_articulo","tabla"=>TBL_PRODUCTOS,"pk"=>"pk_producto","fk_1"=>"fk_producto","campo_buscar"=>"sku");
	  include("vs_aggregator.php");  
	  ?></td>
    </tr>
	<tr>
      <td colspan="2"class="t5">Descripci&oacute;n extendida</td>
	</tr>
	<tr>
      <td colspan="2"><pre id="idTemporary" name="idTemporary" style="display:none"><?=trim($rs["results"][0]["descripcion"])?></pre>
	  <script>
	  	function comprueba(){
			document.getElementById("descripcion").value=oEdit1.getHTMLBody();
			if(valid.validate())  form1.submit();

			return false;
		}
		var oEdit1 = new InnovaEditor("oEdit1");
		oEdit1.width="100%"
		oEdit1.cmdAssetManager="modalDialogShow('/includes/editor/assetmanager/assetmanager.php?lang=spanish',640,465)";
oEdit1.features=["FullScreen","Preview","Print","Search",
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
			oEdit1.css='/style/style.css';
		oEdit1.RENDER(document.getElementById("idTemporary").innerHTML);
	</script>

	<input name="descripcion" type="hidden" id="descripcion" value=""></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
  <script type="text/javascript">
  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="?module=<?=$_GET["module"]?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
      <td colspan="2" class="t1">Art&iacute;culo</td>
    </tr>
    <tr>
      <td class="t5">Art&iacute;culo</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Shop->getArticulo('',$_GET["page"]);
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_articulo"]?>"><?=$value["titulo"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_articulo"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Shop->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
