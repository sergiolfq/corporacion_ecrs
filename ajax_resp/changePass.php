<?php
require("../includes/includes.php");
$Shop = new Shop; 

	if($_SESSION["fk_pais_seleccionado"]==2){
		$_SESSION["LOCALE"]= "_en";
		$_SESSION["LOCALE_IMG"]= "_en"; 
		$l = setlocale(LC_MESSAGES, "en_US");
		bindtextdomain('messages', SERVER_ROOT.'locale');
	}else{
		$_SESSION["LOCALE"]="";
		$_SESSION["LOCALE_IMG"]="";
	}
	
$msgid = $Shop->changePassUsuario($_POST);
if($msgid==1){
	echo _("La Contrase&ntilde;a fue cambiada");
}else{
	echo _("Contrase&ntilde;a actual err&oacute;nea");
}
?>
