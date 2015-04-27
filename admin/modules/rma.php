<?php
$Admin->chkPermisosAdmin(10);

if(is_uploaded_file($_FILES["imagen"]['tmp_name'])){	
			$path= SERVER_ROOT . "images/fabricantes/";
			$nombre = $_FILES["imagen"]["nombre"];
			if(!eregi("php",$nombre)){
        		move_uploaded_file($_FILES["imagen"]['tmp_name'], $path . "rma.pdf");
				$mensaje ="Archivo actualizado";
			}
		}

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0" class="brd1">
    <tr>
      <td colspan="2" class="t1"><span style="float:left ">RMA</span></td>
    </tr>
    <tr>
      <td width="10%" class="t3">Archivo PDF</td>
      <td><input name="imagen" type="file" id="imagen" /></td>
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
