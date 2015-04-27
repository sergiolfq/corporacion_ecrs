<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(4);?></th>
              </tr>
            <table width="991" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
              <tr>              
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Ingreso")?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>                                         
              </tr>
            </table>        
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col" align="left"> 
                
                <div class="tablaBgPuntos">
                 <form id="frm_fotgotpass" name="frm_fotgotpass" method="post" action="" onsubmit="new Ajax.Updater('fpass','ajax_resp/forgot_pass.php',{method:'post',evalScripts: true,parameters:'email=' + $('email').value}); return false">
					
						
					  <div class="titulorojo_destacado" id="fpass" align="center"></div>
						


<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td height="25" colspan="3" align="center" valign="top" class="title"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr class="sepline">
                <td width="100%" height="10">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td height="25" colspan="3" valign="top" class="texto"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr class="sepline">
                <td width="100%" height="10">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td width="387" valign="middle" class="bioboton"><div align="right">E-mail:</div></td>
            <td width="307" valign="middle"><input name="email" type="text" id="email" size="25" class="required validate-email" /></td>
            <td width="510" valign="middle"><input type="submit" name="Submit" value="<?=_("Enviar")?>" class="botoncot" /></td>
          </tr>
          
          <tr>
            <td height="25" colspan="3" align="center" valign="top" class="texto">&nbsp;</td>
          </tr>
          <tr>
            <td height="10" colspan="3" align="center" valign="top" class="texto"><img src="images/spacer.gif" width="1" height="10" /></td>
          </tr>
          
        </table>
          <br>
        <br></td>
    </tr>
  </table>

						
						
					
<script type="text/javascript">
formCallback = function(result, form) {
	window.status = "valiation callback for form '" + form.id + "': result = " + result;
}

var valid = new Validation('frm_fotgotpass', {immediate : true, onFormValidate : formCallback});

</script>
</form></div></th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>