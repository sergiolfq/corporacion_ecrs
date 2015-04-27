<?php
$Admin->chkPermisosAdmin(2);
$Textos = new Textos;
if(intval($_POST["pk_texto"])==0 && trim($_POST["texto"])!=""){
	$Textos->addTexto($_POST,$_FILES);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_texto"])>0){
	$Textos->editTexto($_POST,$_FILES);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Textos->deleteTexto($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_texto" => intval($_GET["edt"]));
	$rs = $Textos->getTexto($arr);
}

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" name="form1" id="form1" onsubmit="comprueba(); return false">
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
      <td width="10%" valign="top" class="t3">T&iacute;tulo espa&ntilde;ol</td>
      <td valign="top"><input name="titulo" type="text" id="titulo" value="<?=$rs["results"][0]["titulo"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_texto" type="hidden" id="pk_texto" value="<?=$rs["results"][0]["pk_texto"]?>" /></td>
    </tr>
     <tr>
      <td width="10%" valign="top" class="t3">T&iacute;tulo ingl&eacute;s</td>
      <td valign="top"><input name="titulo_en" type="text" id="titulo_en" value="<?=$rs["results"][0]["titulo_en"]?>" size="50" maxlength="255" class="required" /></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" class="t3">Espa&ntilde;ol</td>
    </tr>
	<tr>
      <td colspan="2" valign="top" class="t3"><pre id="idTemporary" name="idTemporary" style="display:none"><?=trim($rs["results"][0]["texto"])?></pre>
	  <script>
	  
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

		oEdit1.RENDER(document.getElementById("idTemporary").innerHTML);
	</script>

	<input name="texto" type="hidden" id="texto" value=""></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" class="t3">Ingl&eacute;s</td>
    </tr>
    <tr>
      <td colspan="2" valign="top" class="t3"><pre id="idTemporary_en" name="idTemporary_en" style="display:none"><?=trim($rs["results"][0]["texto_en"])?></pre>
	  <script>
	  
		var oEdit2 = new InnovaEditor("oEdit2");
		oEdit2.width="100%"
		oEdit2.cmdAssetManager="modalDialogShow('/includes/editor/assetmanager/assetmanager.php?lang=spanish',640,465)";
oEdit2.features=["FullScreen","Preview","Print","Search",
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

		oEdit2.RENDER(document.getElementById("idTemporary_en").innerHTML);
	</script>

	<input name="texto_en" type="hidden" id="texto_en" value=""></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
  <script type="text/javascript">
  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  	function comprueba(){
			document.getElementById("texto").value=oEdit1.getHTMLBody();
			document.getElementById("texto_en").value=oEdit2.getHTMLBody();
			if(valid.validate())  form1.submit();

			return false;
		}
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="?module=<?=$_GET["module"]?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
    <td class="t1">Textos</tr>
<?php
$rss = $Textos->getTexto('',$_GET["page"]);
foreach($rss["results"] as $key => $value){

?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_texto"]?>"><?=$value["titulo"]?></a></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Textos->paginateResults($rss)?></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
