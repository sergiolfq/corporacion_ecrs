<br />
  <br />
  <?php
    //require_once ("../soporte/email.php");
 /* require 'includes/PHPMailer/PHPMailerAutoload.php';
  $mail = new PHPMailer();
  
  $mail->IsSMTP();*/
  

  
	if($_POST["registroForm"]==1){
		require_once(dirname(dirname(__FILE__)) . "/includes/includes.php");
		$Shop = new Shop; 
		$post = $_POST;
		$arr=$Shop->searchEmail($post);

		if(!$Shop->searchEmail($post) ){ //error mail ya registrado
?>
  

<table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td class="txt_registro_bold"><div align="center"><span class="txt_warning">Ha ocurrido un error:</span><br />
                  <br />
                La direcci&oacute;n de email o la cedula ya se encuentra registrada en nuestra base de datos </div></td>
              </tr>
            </table>
		<?php
		}else{
			$post["fk_usuario_tipo"]=1;
			if($Shop->addUsuario($post)){
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td class="txt_registro_bold"><div align="center">Le enviamos un email de confirmaci&oacute;n. Revise su cuenta email para confirmar el registro.
<br />
<br />
El env&iacute;o de este email puede tardar unos minutos, si despues de 10 minutos a&uacute;n no lo recibe, revise la carpeta de SPAM o BULK de su proveedor de correo.<br />
<br />
<br />
</div></td>
          </tr>
        </table>
		<?php	
			}else{ // ha ocurrido un error
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td class="txt_registro_bold"><div align="center"><span class="txt_warning">Ha ocurrido un error:</span><br />
              <br />
              Si es la primera vez que recibe este mensaje intente registrarte nuevamente en unos minutos, de lo contrario cont&aacute;ctenos.</div></td>
          </tr>
        </table>
		<br />
		<?php
			}
		}
	}
?> <br />
<br />
<br />
<br />