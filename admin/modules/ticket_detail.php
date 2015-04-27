<?php
$Admin->chkPermisosAdmin(13);
$pk_ticket=intval($_GET["i"]);
if(isset($_POST["fk_ticket_estado_old"])){
	if(intval($_POST["pk_ticket"])==0){
		$pk_ticket= $Shop->addTicket($_POST,$_SESSION);
	}else{
		$Shop->editTicket($_POST,$_SESSION);
	}
}



if($pk_ticket==0){
	$fk_usuario = $_GET["u"];
	$fk_ticket_tipo = $_GET["t"];
	$fk_pk_relacionado = intval($_GET["r"]);
	$fk_ticket_estado=1;
	$fecha_apertura=time();

}else{
	$ticket = $Shop->busquedaTicket(array("pk_ticket" => $pk_ticket));
	$asunto=$ticket["results"][0]["asunto"];
	$historico = $Shop->getTicketHistorico($pk_ticket);
	$fk_usuario = $ticket["results"][0]["fk_usuario"];
	$fk_ticket_tipo = $ticket["results"][0]["fk_ticket_tipo"];
	$fk_pk_relacionado = $ticket["results"][0]["fk_pk_relacionado"];
	$fk_ticket_estado=$ticket["results"][0]["fk_ticket_estado"];
	$fecha_apertura=strtotime($ticket["results"][0]["fecha_apertura"]);
}

$usuario = $Shop->busquedaUsuario(array(
	"pk_usuario" => $fk_usuario
));

 

?>
<form id="form1" name="form1" method="post" action=""  onsubmit="comprueba(); return false">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" class="brd1">
    <tr>
      <td colspan="2" class="t1"><?php if($pk_ticket==0){ ?>
        Creaci&oacute;n de nueva comunicaci&oacute;n
        <?php }else{ ?>
        Detalle de comunicaci&oacute;n
        <?=sprintf("%05d",$_GET["i"])?>
        <?php } ?></td>
    </tr>
    <tr>
      <td class="t3">Fecha de apertura:</td>
      <td><?=date("d/m/Y H:i",$fecha_apertura)?><input type="hidden" name="pk_ticket" value="<?=$pk_ticket?>" /></td>
    </tr>
    <tr>
      <td class="t3">Estatus:</td>
      <td><span class="t2">
        <select name="fk_ticket_estado" id="fk_ticket_estado">
          <?php $Common->llenarComboDb(TBL_TICKETS_ESTADOS,"pk_ticket_estado","estado","",0,$fk_ticket_estado,"","pk_ticket_estado asc"); ?>
        </select>
      </span>
	  <input type="hidden" name="fk_ticket_estado_old" value="<?=$fk_ticket_estado?>" /><input type="hidden" name="fk_pk_relacionado" value="<?=$fk_pk_relacionado?>"/></td>
    </tr>
    <tr>
      <td class="t3">Tipo:</td>
      <td><span class="t2">
        <select name="fk_ticket_tipo" id="fk_ticket_tipo">
          <?php $Common->llenarComboDb(TBL_TICKETS_TIPO,"pk_ticket_tipo","tipo","",0,$fk_ticket_tipo,"","pk_ticket_tipo asc"); ?>
        </select>
      </span></td>
    </tr>
	<tr>
      <td class="t3">Asunto:</td>
      <td><?php if($pk_ticket==0){ ?><input name="asunto" type="text" id="asunto" maxlength="50" class="required" />
        <?php }else{ echo $asunto; } ?></td>
    </tr>
    <tr>
      <td class="t3">Relaci&oacute;n:</td>
      <td><?php if($fk_ticket_tipo==1){ ?>
          <a href="?module=order_detail&i=<?=$fk_pk_relacionado?>" target="_blank">Pedido #
            <?=sprintf("%05d",$fk_pk_relacionado)?>
        </a>
          <?php } ?></td>
    </tr>
    <tr>
      <td colspan="2" class="t5">Datos del cliente</td>
    </tr>
    <tr>
      <td class="t3">Email:</td>
      <td><?=$usuario["results"][0]["email"]?><input type="hidden" name="fk_usuario" value="<?=$fk_usuario?>" /></td>
    </tr>
    <tr>
      <td class="t3"><?php if($usuario["results"][0]["tipo_persona"]==1){?>
        Cédula:
        <?php }else{ ?>
        RIF:
        <?php } ?></td>
      <td><a href="?module=usuarios&amp;edt=<?=$usuario["results"][0]["pk_usuario"]?>" target="_blank">
        <?=$usuario["results"][0]["cedula_rif"]?>
      </a></td>
    </tr>
    <tr>
      <td class="t3"><?php if($usuario["results"][0]["tipo_persona"]==1){?>
        Nombre:
        <?php }else{ ?>
        Raz&oacute;n social:
        <?php } ?></td>
      <td><?=$usuario["results"][0]["nombres"]?></td>
    </tr>
    <tr>
      <td class="t3"><?php if($usuario["results"][0]["tipo_persona"]==1){?>
        Apellido:
        <?php }else{ ?>
        Persona de contacto:
        <?php } ?></td>
      <td><?=$usuario["results"][0]["apellidos"]?></td>
    </tr>
    <tr>
      <td class="t3">Teléfono 1:</td>
      <td><?=$usuario["results"][0]["telefono1"]?></td>
    </tr>
    <tr>
      <td class="t3">Teléfono 2:</td>
      <td><?=$usuario["results"][0]["telefono2"]?></td>
    </tr>
    <tr>
      <td class="t3">Fax:</td>
      <td><?=$usuario["results"][0]["fax"]?></td>
    </tr>
    <tr>
      <td class="t3">Ciudad / Estado / Pa&iacute;s: </td>
      <td><?=$usuario["results"][0]["ciudad"]?>
        /
        <?=$usuario["results"][0]["estado"]?>
        /
        <?=$usuario["results"][0]["pais"]?></td>
    </tr>
    <tr>
      <td colspan="2" class="t5">Historial</td>
    </tr>
    <?php if(sizeof($historico["results"])>0){ ?>
    <tr>
      <td colspan="2" class="t3"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="t1">Fecha</td>
            <td class="t1">Persona</td>
            <td class="t1">Comentario</td>
          </tr>
		  <?php foreach($historico["results"] as $key => $value){ ?>
          <tr>
            <td valign="top"><?=date("d/m/Y H:i",strtotime($value["fecha"]))?></td>
            <td valign="top"><?=$value["nombres"]?></td>
            <td valign="top"><?=nl2br($value["texto"])?></td>
          </tr>
		  <?php } ?>
      </table></td>
    </tr>
    <?php } ?>
	<tr>
      <td valign="top" class="t3">Aplicar regla:</td>
      <td>
	  
	  <?php
		 $reglas = $Shop->Execute("select titulo,pk_texto from " . TBL_TEXTOS . " where titulo like 'Regla%'");
		 foreach($reglas["results"] as $keyReg => $valueReg){
		 ?>
		 <a href="JavaScript:void(aplicaRegla(<?=$valueReg["pk_texto"]?>))"><?=$valueReg["titulo"]?></a><br />
		 <?php
		 }
		 ?>	</td>
    </tr>
	
    <tr>
      <td valign="top" class="t3">Nuevo comentario:</td>
      <td><pre id="idTemporary" name="idTemporary" style="display:none"></pre><script>
	  	function comprueba(){
			document.getElementById("texto").value=oEdit1.getHTMLBody();
			if(valid.validate())  form1.submit();

			return false;
		}
		function aplicaRegla(pk_regla){
			var myAjax = new Ajax.Updater('idTemporary', '/admin/ajax_resp/reglas.php', { method: 'post', evalScripts: true, parameters: 'i=' + pk_regla, onComplete: function(){oEdit1.loadHTML(document.getElementById("idTemporary").innerHTML);} });
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

		oEdit1.RENDER(document.getElementById("idTemporary").innerHTML);
	</script>

	<input name="texto" type="hidden" id="texto" value="" class="required"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Enviar" /></td>
    </tr>
  </table>
  <script type="text/javascript">
  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  </script>
</form>
