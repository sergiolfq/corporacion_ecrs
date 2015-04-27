<?php
$control =md5(HASH . microtime() * mktime());
?>
<form id="form1" name="form1" method="post" action="?">
  <table width="50%" border="0" align="center" cellpadding="5" cellspacing="0" class="brd1">
    <tr>
      <td colspan="2" class="t1">Datos de identificaci&oacute;n</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="t2">Login:</td>
      <td><input name="login" type="text" id="login" /></td>
    </tr>
    <tr>
      <td align="right" class="t2">Password:</td>
      <td><input name="<?=$control?>" type="password" id="<?=$control?>" />
      <input name="cc1" type="hidden" id="cc1" value="<?=$control?>" /></td>
    </tr>
	<tr>
      <td align="right" class="t2">Control:</td>
      <td><input name="captcha" type="text" id="captcha" size="5" maxlength="5" class="required" />
					  <img src="../ajax_resp/showCaptcha.php" border="0" align="absmiddle"/>	</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" value="Ingresar" /></td>
    </tr>
  </table>
</form><br />
<br />

