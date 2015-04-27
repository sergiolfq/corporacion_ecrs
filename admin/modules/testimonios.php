<?php
$Admin->chkPermisosAdmin(4);
if(isset($_GET["delpic"]) && !isset($_POST["pk_testimonio"])){
        @unlink(SERVER_ROOT . "images/testimonios/" . $_GET["delpic"]);
        $mensaje ="Foto eliminada";
}
if(intval($_POST["pk_testimonio"])==0 && trim($_POST["titulo"])!=""){
        $Shop->addTestimonio($_POST,$_FILES);
        unset($_POST);
        $mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_testimonio"])>0){
        $Shop->editTestimonio($_POST,$_FILES);
        unset($_POST);
        $mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
        $Shop->deleteTestimonio($_POST);
        $mensaje="Los elementos selecionados fueron eliminados";
}

if(intval($_GET["edt"])>0){
        $arr = array("pk_testimonio" => intval($_GET["edt"]));
        $rs = $Shop->getTestimonio($arr);
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
                 Testimonio
        </span>
          <?php if(isset($_GET["edt"])){?>
        <span style="float:right;"><a href="?module=<?=$_GET["module"]?>" class="t1">Nuevo</a></span>
        <?php } ?></td>
    </tr>
      
     <tr>
      <td width="15%" valign="top" class="t3">Destacado</td>
      <td valign="top"><select name="fk_destacada" id="fk_destacada">
	  <option value="0" <?php if($rs["results"][0]["fk_destacada"]==0){ ?>selected="selected"<?php } ?>>No</option>
	  <option value="1" <?php if($rs["results"][0]["fk_destacada"]==1){ ?>selected="selected"<?php } ?>>Si</option>
      </select>    </td>
    </tr>
        <tr>
      <td width="15%" valign="top" class="t3">Persona / Compañia  espa&ntilde;ol</td>
      <td valign="top"><input name="titulo" type="text"  id="titulo" value="<?=$rs["results"][0]["titulo"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_testimonio" type="hidden" id="pk_testimonio" value="<?=$rs["results"][0]["pk_testimonio"]?>" /></td>
    </tr>
     <tr>
      <td width="15%" valign="top" class="t3">Persona / Compañia inglés</td>
      <td valign="top"><input name="titulo_en" type="text"  id="titulo_en" value="<?=$rs["results"][0]["titulo_en"]?>" size="50" maxlength="255" class="required" />
      </td>
    </tr>
        <tr>
      <td valign="top" class="t3">Sumario  espa&ntilde;ol<br />
        Max (370 Caracteres) </td>
      <td valign="top">
      <pre id="idTemporary" name="idTemporary" style="display:none"><?=trim($rs["results"][0]["sumario"])?></pre>
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
        
      <input name="sumario" type="hidden" id="sumario" value="">
     
     <!--
      <textarea name="sumario" cols="50" rows="5" id="sumario" class="required" onkeyup="cuentaCaracteres('sumario','nfttxt1')"><?=$rs["results"][0]["sumario"]?></textarea> <span id="nfttxt1"><script>cuentaCaracteres('sumario','nfttxt1')</script>
     </span> --></td>
    </tr>
     <tr>
      <td valign="top" class="t3">Sumario inglés<br />
        Max (370 Caracteres) </td>
      <td valign="top">
      
      <pre id="idTemporary_en" name="idTemporary_en" style="display:none"><?=trim($rs["results"][0]["sumario_en"])?></pre>
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
        
      <input name="sumario_en" type="hidden" id="sumario_en" value="">
     <!--
      <textarea name="sumario_en" cols="50" rows="5" id="sumario_en" class="required" onkeyup="cuentaCaracteres('sumario_en','nfttxt1')"><?=$rs["results"][0]["sumario_en"]?></textarea> <span id="nfttxt3"><script>cuentaCaracteres('sumario_en','nfttxt3')</script></span>--></td>
    </tr>
 
         <tr>
      <td valign="top" class="t3">Foto (200x81pixeles)</td>
      <td valign="top"><input name="pic_1" type="file" id="pic_1" /><?php if(isset($_GET["edt"]) && file_exists(SERVER_ROOT . "images/testimonios/" . $rs["results"][0]["pk_testimonio"] . ".jpg")) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/testimonios/<?=$rs["results"][0]["pk_testimonio"]?>.jpg' ,'foto','width=50,height=50'))">(ver foto actual)</a> <!--<a href="?module=<?=$_GET["module"]?>&delpic=pic_1_<?=$rs["results"][0]["pk_testimonio"]?>.jpg&edt=<?=$rs["results"][0]["pk_testimonio"]?>">Eliminar foto actual</a>  -->   <?php } ?></td>
    </tr>
   
      
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
 
</form>
<script>
 var valid = new Validation('form1', {immediate : true,focusOnError : true});
                function comprueba(){
						document.getElementById("sumario").value=oEdit1.getHTMLBody();
						document.getElementById("sumario_en").value=oEdit2.getHTMLBody();
                        var result = valid.validate();
                        if(result) {
                                form1.submit();
                        }else{
                                return false;
                        }
                }
                function cuentaCaracteres(idTestimonio,idNotificador){
                        $(idNotificador).innerHTML=$(idTestimonio).value.length + " chars"
                }
</script>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="?module=<?=$_GET["module"]?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
      <td colspan="3" class="t1"><a name="bupro" id="bupro"></a>Testimonios      </td>
       
    </tr>
    <tr>
         <td class="t5">Titulo</td>
      <td class="t5">Modificado</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Shop->getTestimonio('',$_GET["page"]);

foreach($rss["results"] as $key => $value){
?>
    <tr>
        <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_testimonio"]?>">
          <?=$value["titulo"]?>
        </a></td>
      <td><?=date("d/m/Y H:i",strtotime($value["fecha_modificado"]))?></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_testimonio"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td align="right" colspan="2"><?=$Shop->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>