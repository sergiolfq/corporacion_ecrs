
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(4);?></th>
              </tr>
          </table>
            <table width="981" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
              <th class="titulos" scope="col"><?=_("Registro de usuario")?> </th>
            </tr>
        </table>
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col"> 
                
                 							
<hr>
<div align="center"><br><br>
<?php
$resultado = $Shop->activateMember($_GET);
if(intval($resultado)<=0){
?>
<?=_("Ocurrió un error al tratar de activar su usuario, asegurese de copiar completamente el link suministrado por correo")?>
<?php }else{ ?>

<?=_("El usuario fue activado, con éxito.")?><br />
<br />
<?=_(" Será redirigido de esta página en 5 segundos")?>. 
 <script language="JavaScript" type="text/JavaScript">
function goexp(){	
	<?php if(trim($_GET["fromurl"])==''){ ?>
	document.location = '?module=account' 
	<?php }else{ ?>
		document.location = '<?=urldecode($_GET["fromurl"])?>' 
	<?php } ?>
}
setTimeout("goexp();", 5000);
</script>



<?php } ?>
</div>

                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>