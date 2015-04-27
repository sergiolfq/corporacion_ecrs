<?php
$Admin->chkPermisosAdmin(5);
if(intval($_POST["pk_categoria"])==0 && trim($_POST["categoria"])!=""){
	$Shop->addCategoria($_POST,$_FILES);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_categoria"])>0){
	$Shop->editCategoria($_POST,$_FILES);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Shop->deleteCategoria($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}
if(intval($_GET["edt"])>0){
	$arr = array("pk_categoria" => intval($_GET["edt"]));
	$rs = $Shop->getCategoria($arr);
	
	
}

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="comprueba();">
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
      <td width="12%" valign="top" class="t3">Categor&iacute;a Espa&ntilde;ol</td>
      <td width="88%" valign="top"><input name="categoria" type="text" id="categoria" value="<?=$rs["results"][0]["categoria"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_categoria" type="hidden" id="pk_categoria" value="<?=$rs["results"][0]["pk_categoria"]?>" /></td>
    </tr>
    <tr>
      <td width="12%" valign="top" class="t3">Descripcion Espa&ntilde;ol</td>
      <td width="88%" valign="top"><pre id="idTemporary" name="idTemporary" style="display:none"><?=trim($rs["results"][0]["texto"])?></pre>
          <script language="javascript" type="text/javascript">
               
       
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

        <input name="texto" type="hidden" id="texto" value=""></td>
    </tr>
    <tr>
      <td width="12%" valign="top" class="t3">Categor&iacute;a Ingl&eacute;s</td>
      <td width="88%" valign="top"><input name="categoria_en" type="text" id="categoria_en" value="<?=$rs["results"][0]["categoria_en"]?>" size="50" maxlength="255" class="required" /></td>
    </tr>
       <tr>
      <td width="12%" valign="top" class="t3">Descripcion Ingl&eacute;s</td>
      <td width="88%" valign="top"><pre id="idTemporary_en" name="idTemporary_en" style="display:none"><?=trim($rs["results"][0]["texto_en"])?></pre>
          <script language="javascript" type="text/javascript">
               
       
                var oEdit2 = new InnovaEditor("oEdit2");
                oEdit2.width="100%"
                oEdit2.cmdAssetManager="modalDialogShow('/includes/editor/assetmanager/assetmanager.php?lang=spanish',640,465)";
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
                        oEdit2.css='/style/style.css';
                oEdit2.RENDER(document.getElementById("idTemporary_en").innerHTML);
        </script>

        <input name="texto_en" type="hidden" id="texto_en" value=""></td>
    </tr>
    <tr>
      <td width="12%" valign="top" class="t3">Orden</td>
      <td width="88%" valign="top"><input name="fk_orden" type="text" id="fk_orden" value="<?=intval($rs["results"][0]["fk_orden"])?>" size="2" maxlength="255" class="required validate-digits" /></td>
    </tr>
	<tr>
      <td width="12%" valign="top" class="t3">Sub Categor&iacute;a<br />
      Espa&ntilde;ol</td>
      <td valign="top"><input name="categoria2" type="text" id="categoria2" value="" size="50" maxlength="255" /></td>
    </tr>
    <tr>
      <td width="12%" valign="top" class="t3">Sub Categor&iacute;a<br />
Ingl&eacute;s</td>
      <td valign="top"><input name="categoria2_en" type="text" id="categoria2_en" value="" size="50" maxlength="255" /> <br />
		<?php
			$subcats = $Shop->getCategoriaTree($rs["results"][0]["pk_categoria"],'down');
			if(sizeof($subcats)>0){
				foreach($subcats as $keysub => $valuesub){
					
				?>
				<?php
	  $padres = $Shop->getCategoriaTree($valuesub["pk_categoria"]);
	  if(sizeof($padres)>0)
		  foreach($padres as $keycat => $valuecat){
			echo $valuecat["categoria"] . " &raquo; ";
		  }
	  ?><strong>[<?=$valuesub["pk_categoria"]?>]</strong> <a href="?module=<?=$_GET["module"]?>&edt=<?=$valuesub["pk_categoria"]?>"><?=$valuesub["categoria"]?></a><br />
				<?php
				}
			}
		?>      </td>
    </tr>
    
    <?php if(intval($rs["results"][0]["fk_categoria_padre"])>0){ ?>
     <!--
     <tr>
      <td width="12%" valign="top" class="t3">Foto Sub Categor&iacute;a<br />
        (150 x 150 px)</td>
      <td valign="top"><input type="file" name="imagen" id="imagen" /><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/categorias/cat_" . $rs["results"][0]["pk_categoria"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/categorias/cat_<?=$rs["results"][0]["pk_categoria"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a>    <?php } ?></td>
    </tr>
   
    <tr>
      <td width="12%" valign="top" class="t3">Destacar</td>
      <td valign="top"><input name="fk_destacado" type="radio" value="0" <?php if(intval($rs["results"][0]["fk_destacado"])==0){?> checked="checked"<?php } ?> />
No
  <input name="fk_destacado" type="radio" value="1" <?php if(intval($rs["results"][0]["fk_destacado"])==1){?> checked="checked"<?php } ?> />
Si </td>
    </tr>
    -->
    <?php } ?>
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
                        var result = valid.validate();
                        if(result) {
                                form1.submit();
                        }else{
                                return false;
                        }
                }
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="?module=<?=$_GET["module"]?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
      <td colspan="2" class="t1">Categor&iacute;as</td>
    </tr>
    <tr>
      <td class="t5">Categor&iacute;a</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Shop->getCategoria('',$_GET["page"]);
foreach($rss["results"] as $key => $value){
?>
    <tr <?php if($key%2==0){ ?>bgcolor="#FFFFCC"<?php } ?>>
      <td><?php 
	  $padres = $Shop->getCategoriaTree($value["pk_categoria"]);
	  if(sizeof($padres)>0)
		  foreach($padres as $keycat => $valuecat){
			echo $valuecat["categoria"] . " &raquo; ";
		  }
	  ?><strong>[<?=$value["pk_categoria"]?>]</strong> <a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_categoria"]?>"><?=$value["categoria"]?></a></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_categoria"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right"><?=$Shop->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
