<?php
error_log("forgot");
if(isset($_POST["email"])){
	require("../includes/includes.php");
	$com = new Shop;
	if($_SESSION["fk_pais_seleccionado"]==2){
		$_SESSION["LOCALE"]= "_en";
		$_SESSION["LOCALE_IMG"]= "_en"; 
		$l = setlocale(LC_MESSAGES, "en_US");
		bindtextdomain('messages', SERVER_ROOT.'locale');
	}else{
		$_SESSION["LOCALE"]="";
		$_SESSION["LOCALE_IMG"]="";
	}
	
	if($com->forgotPasswordUsuario($_POST)){
		$msg=_("Para iniciar el proceso de restablecimiento de la contraseña, por favor, siga las instrucciones que se han enviado a su dirección de correo electrónico");
	}else{
		$msg=_("El email especificado no se encuentra registrado en nuestra base de datos"); 
	};
?><br />
<br />

<span class="txt_ltitles"><strong><?=$msg?></strong></span><br /><br />
<br />

<div align="center"><input type="button" name="Button" value="<?=_("Regresar")?>" onclick="history.back();"   class="botoncot" /></div>
<?php
	exit; 
} 
?> 

