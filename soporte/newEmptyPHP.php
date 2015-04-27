<?php  require_once("../includes/includes.php"); include("services/fiscalizar.back.php"); 



$Common = new Common;

//unset($_SESSION["cart"]);
if(!isset($_SESSION["fk_pais_seleccionado"])){
		$_SESSION["fk_pais_seleccionado"]=1;
}

if(isset($_COOKIE["prt"]) && intval($_COOKIE["prt"])>=0 && $_COOKIE["prt"]<=3){
	$_SESSION["fk_pais_seleccionado"] = intval($_COOKIE["prt"]);
}

        if(isset($_GET["prt"]) && intval($_GET["prt"])>=0 && $_GET["prt"]<=3){
	$_SESSION["fk_pais_seleccionado"] = intval($_GET["prt"]);
	if(trim($_GET["r"])=="true"){
		setcookie("prt",  intval($_GET["prt"]), time()+3600*24*365); 
	}else{
		setcookie ("prt", "", time() - 3600);
	}
}

$p_banda = intval($_SESSION["user"]["fk_banda_precios"]);

if($_SESSION["fk_pais_seleccionado"]==2){
	$p_precio =  '2' . $p_banda;
	$_SESSION["LOCALE"]= "_en";
	$_SESSION["LOCALE_IMG"]= "_en";
	$_SESSION["LOCALE_PRICE"]= "_en";
	$l = setlocale(LC_MESSAGES, "en_US");
	bindtextdomain('messages', SERVER_ROOT.'locale');

}else{
	$p_precio =  intval($_SESSION["fk_pais_seleccionado"]) . $p_banda;
	$_SESSION["LOCALE"]="";
	$_SESSION["LOCALE_IMG"]="";
	$_SESSION["LOCALE_PRICE"]="";
}


$Banners = new Banners;
$Banners->sumaBanner($_GET["bannerid"]);
$Shop = new Shop;
$Shop->manageCart($_POST,$_GET);


$cart = $Shop->getCart($_SESSION);
if(sizeof($cart)>0){
	foreach($cart as $key => $value){
		$totEfec += $value["precio" . intval($_SESSION["user"]["fk_banda_precios"])] * $value["qty"];
		$totTdc  += $value["preciotdc" . intval($_SESSION["user"]["fk_banda_precios"])] * $value["qty"];
	}
}


if(isset($_POST["dologin"]) && intval($_POST["dologin"])==1){
	echo $Shop->loginUsuario($_POST);
}

if(isset($_GET["logout"])){
	unset($_SESSION["user"]);
}

if(isset($_GET["flog"]) || isset($_GET["etpv"])){ //es un login forzado desde un link!
	if(isset($_GET["flog"])){
		$pk_usuario_force = substr($_GET["flog"],32,strlen($_GET["flog"]));
	}else{
		$arretpv = split("\|",$Shop->decode($_GET["etpv"]));
		$pk_usuario_force=intval($arretpv[2]);
	}
	if(md5(HASH . $pk_usuario_force) != substr($_GET["flog"],0,32) && isset($_GET["flog"])){
		die("error: #df34gg4");
	}else{
		$Shop->login('',$pk_usuario_force);
	}
}

//esto viene de /modules/product_detail.php para aumentar el SEO
if(isset($_GET["pro"])){ //lo esta agregando via link
	$pk_pro = intval(substr($_GET["pro"],32,strlen($_GET["pro"])));
	if(md5(HASH . $pk_pro) == substr($_GET["pro"],0,32)){
		$rs = $Shop->getProducto(array("pk_producto" => intval($pk_pro)));
	}
}

if(isset($_GET["dw"])){
	$pk =  intval($Shop->decode($_GET["dw"]));
	$rsn = $Shop->getNoticia(array("pk_noticia"=>$pk));
	$fileD = SERVER_ROOT . "images/noticias/" . $Shop->decode($_GET["dw"]) . ".pdf";
	$fname = rawurlencode($rsn["results"][0]["pdf_name"]);
	if(!is_file($fileD)){  exit; } 
	$fsize = filesize($fileD);
	header("HTTP/1.1 200 OK");     
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header('Date: ' . date("D M j G:i:s T Y"));
	header('Last-Modified: ' . date("D M j G:i:s T Y"));
	header("Content-Length: $fsize");
	header("Content-type: application/pdf");
	//header("Content-type: application/octet-stream\n");
	//header("Content-Disposition: attachment; filename=$fname");
	header("Content-Transfer-Encoding: binary");
	readfile($fileD);	
	exit;
}

if(isset($_GET["dws"])){
	$H = new Helper;
	$pk =  intval($Shop->decode($_GET["dws"]));

	$rsn = $H->getSoporte_Descargas(array("pk_soporte_descarga"=>$pk),0,1); 
	
	$fileD = SERVER_ROOT . "descargas/" . $Shop->decode($_GET["dws"]) . ".dat";
	$fname = rawurlencode($rsn["results"][0]["file_name"]);
	
	if(!is_file($fileD)){  exit; } 
	$fsize = filesize($fileD);
	header("HTTP/1.1 200 OK");     
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header('Date: ' . date("D M j G:i:s T Y"));
	header('Last-Modified: ' . date("D M j G:i:s T Y"));
	header("Content-Length: $fsize");
	if(substr($fname,-3)=='pdf'){
		header("Content-type: application/pdf");
	}else{
		header("Content-type: application/octet-stream\n");
		header("Content-Disposition: attachment; filename=$fname");	
	}
	
	header("Content-Transfer-Encoding: binary");
	readfile($fileD);	
	exit;
}
?>











<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <!-- inicio parte nueva  --> 
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="SKYPE_TOOLBAR" content ="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
<title><?php if(isset($_GET["pro"])){ ?>Comprar <?=$rs["results"][0]["nombre"]?> / <?=$rs["results"][0]["sku"]?> - Corporaci&oacute;n ECRS - Cajas Registradoras Alemanas QUORION -<?php }elseif($_GET["module"]=='categoria'){ ?> - Corporaci&oacute;n ECRS - Cajas Registradoras Alemanas QUORION - <?=str_replace('&raquo;','-',strip_tags($Shop->migas($_GET)))?> <?php }else{ ?> - Corporaci&oacute;n ECRS - Cajas Registradoras Alemanas QUORION -<?php } ?></title>
<meta name="Keywords" content="Corporaci&oacute;n ECRS, Corporaci&oacute;n, ECRS, QUORiON, Quorion, Cajas Registradoras, Cajas Registradoras Fiscales, Impresoras Fiscales, Equipos Fiscales, Soluciones Fiscales, Sistemas Fiscales, Punto de Venta, Sistemas de Punto de Venta, Impresora de Punto de Venta, Impresora de Loter&iacute;a, Impresora de Asar, Impresor de Cocina, Impresor de Barra, Comanderas, CR 20, CR 28, QPrint MF, QPrint, QMP 5000, QMP 5040, QMP 5140, QMP 5286, SERIE 5000, SERIE 3000, QMP 3226, QMP 1120, QTouch 2, QTouch 15 PC, POS Concerto, QKeyboard, QOrder, Integradores de Software,  Sistemas POS, Terminal de Mano, Venezuela, Caracas, EL Para&iacute;so, Colombia, Bogot&aacute;, M&eacute;xico, DF, Cajas Registradoras, Cajas Registradoras Alemanas,  Cajas Registradoras Homologadas por el SENIAT, M&aacute;quinas Fiscales Aprobadas por el SENIAT, Proveedores de M&aacute;quinas Fiscales, Proveedores de M&aacute;quinas Fiscales en Venezuela, Proveedores de Impresoras Fiscales, Proveedores de Impresoras Fiscales en Venezuela, Importador de Cajas Registradoras Fiscales, Distribuidores de Cajas Registradoras Fiscales, Distribuidores de Impresoras Fiscales, Lectores de C&oacute;digo de Barra, Verificadores de Precio, Sistemas de Facturaci&oacute;n, Sistemas de Facturaci&oacute;n para Restaurantes, Sistemas de Facturaci&oacute;n para Supermercados, Sistemas de Facturaci&oacute;n para Farmacias, Software Administrativos, Balanzas Electr&oacute;nicas, Servicio de Cajas Registradoras Fiscales, Centro de Servicio de Cajas Registradoras Fiscales, Servicio T&eacute;cnico de Cajas Registradoras Fiscales, Contador de Billetes, Contadora de Billetes, Consumibles, Rollos de Papel, Rollos de Etiqueta, Gavetas de Dinero, Display de Clientes, Cash Drawer, Customer Display, Display LCD, External Display, Bar Code, Check Price, Hand Terminal, Fiscal Cash Register, Fiscal Printer, Roll Paper, Scale, POS Terminal, Keyboard,  Kitchen Printer, QUORION POS Systems, QMP POS Software, Beverage Dispensers, Currency counter, Dirección: Av. De Los Samanes, Calle Madariaga, Edif. EURO, Nivel Mezzanina, Local 19 y 20 El Paraíso. Caracas – VenezTeléfonos: +58 212-481.9721 / +58 212-482.8803" />
<link rel="shortcut icon" href="favicon.ico" >
<link href="/includes/css/ecrs_estilos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/includes/css/fonts.css" type="text/css" charset="utf-8" />
<style type="text/css">

#poplala {display:block; bottom:0px; right:30px; width:184px; position:fixed; padding:0px; text-align:center; font-weight:bold; color:#fff; }
* html #poplala {position:absolute;}
</style>

<!--[if IE]>
<style type="text/css" media="screen"> 
.menudep2  div{ padding-top:5px; background-position:left
}

</style> 
<![endif]-->


<link href="/includes/css/validation.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript">
function tratarError(){ 
   return true; 
} 
//window.onerror = tratarError;
</script>
<script language="javascript" type="text/javascript" src="../includes/js/scriptaculous/prototype.js"></script>
<script language="javascript" type="text/javascript" src="../includes/js/scriptaculous/scriptaculous.js"></script>
<script language="javascript" type="text/javascript" src="../includes/js/validation.js"></script>
<script language="javascript" type="text/javascript" src="../includes/js/comunes.js"></script>
<script language="javascript" type="text/javascript" src="../includes/js/prototype.maskedinput.js"></script>
<script language="javascript" type="text/javascript" src="../includes/js/md5-0.9.js"></script>



<script language="javascript" type="text/javascript">
function mantenerSession () {
  new Ajax.Request('../ajax_resp/mantain_session.php',{method:'post',parameters: ''})
}
new PeriodicalExecuter(mantenerSession, 300000);

new PeriodicalExecuter(function(pe) {
  	if($('poplala')){
		$('poplala').style.display='';
		Effect.Pulsate('poplala');
	}
    pe.stop();
}, 15);


</script>
        
        <!-- fin parte nueva  --> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <link href="css/ecrs_estilos.css" rel="stylesheet" type="text/css" />       
        <link rel="stylesheet" href="/controls/SlickGrid/slick.grid.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/controls/slick.pager.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/examples/enajenaciones.css" type="text/css"/>  
        <title>Fiscalizacion</title>
    </head>

    <body style="background: white;" onload="onLoad();">
        
        
        <!-- inicio parte nueva -->
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="franja_top" scope="col"><table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th width="763" align="left" scope="col">
        <marquee  behavior="scroll" direction="left" scrollamount="5" class="eras"  >
<?php
                        $Textos = new Textos;
						$rs = $Textos->getTexto(array("pk_texto" => 10));
						echo $rs["results"][0]["texto" . $_SESSION["LOCALE"]]
						?>

        </marquee></th>
        <th width="151" scope="col"><a href="http://www.quorion.de/" target="_blank"><img src="images/tope/quorion-logo.png" alt="Quorion Data System- Cajas registradoras" width="151" height="45" border="0" /></a></th>
        <th width="66" scope="col"><div style="position:absolute; float:left; z-index:10; top:0px"><a href="http://www.quorion.de/" target="_blank"><img src="images/iconos/Made-in-Alemania.png" width="71" height="70" alt="Hecho en Alemania" border="0" /></a></div></th>
      </tr>
    </table></th>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th align="center" scope="col"><table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th scope="col"><table width="980" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="160" height="130" align="left" valign="middle" scope="col"><a href="/"><img src="images/tope/corporacion-ECRS.png" alt="Corporaci&oacute;n ECRS" width="160" height="81" border="0" /></a></th>
            <th width="480" scope="col"><table width="150" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>  
                <th scope="col" align="left" ><span class="eras rojo17"><?=_("¡Llámenos hoy!")?></span></th>
              </tr>
              <tr> 
                <td align="center" class="textgris15">+58 212-481.9721</td>
              </tr>
              <tr>
                <td height="26" align="center" valign="bottom"><span class="eras rojo17"><?=_("Horarios")?></span></td>
              </tr>
              <tr>
                <td align="center" class="textgris15"><?=_("Lunes a Viernes")?><br />
                 <?=_("8:00 am a 5:00 pm")?></td>
              </tr>
            </table></th>
            <th width="340" align="right" valign="bottom" scope="col"><table width="261" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th height="55" scope="col"><table width="261" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <th align="right" valign="middle" class="buscador" scope="col">
                    <form action="?" method="get" id="buscador" name="frmBuscar">
                    <table width="190" border="0" align="right" cellpadding="0" cellspacing="0">
                      <tr>
                        <th width="158" align="right" scope="col">
                        
                        
                        
      <input type="text" name="buscar" id="buscador3" class="texto" size="22" onfocus="this.value=''" value="<?php if(trim($_GET["buscar"])!=''){ echo strip_tags($_GET["buscar"]); }else{ echo _("Buscar");}?>" style="border:0px;"><input type="hidden" name="module" value="categoria" />
   
    
                       </th>
                        <th width="32" align="center" valign="middle" scope="col">
                          <input type="image" name="imageField" id="imageField" src="images/iconos/boton.png" style="background-color:transparent; border:0px;" /></th>
                      </tr>
                    </table>
                     </form>
    
                    </th>
                  </tr>
                </table></th>
              </tr>
              <tr>
                <td height="41" valign="top"><table width="261" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th width="185" align="left" scope="col">
                    
                    <?php if(!isset($_SESSION["user"])){ ?>
                    &iquest;<?=_("Nuevo usuario")?>? <a href="?module=registro" class="rojosubrayado"><?=_("Regístrese")?></a>
                    <?php }else{ ?>
                    <?=$_SESSION["user"]["nombres"]." ".$_SESSION["user"]["apellidos"]?>  <a href="?logout=1" class="rojosubrayado"><?=_("Salir")?></a>
                    <?php } ?>
                    </th>
                    <th width="42" scope="col"><a href="?prt=0"><img src="images/iconos/espanol-idioma.png" alt="Espa&ntilde;ol" width="29" height="29" border="0" /></a></th>
                    <th width="34" scope="col"><a href="?prt=2"><img src="images/iconos/USA_lenguaje.png" alt="English" width="29" height="29" border="0" /></a></th>
                  </tr>
                </table></td>
              </tr>
            </table></th>
          </tr>
        </table></th>
      </tr>
    </table>
      <table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th valign="top" class="container" scope="col"><table width="980" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th align="center" valign="middle" class="botonerafond" scope="col"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <th width="878" scope="col">
                  <div id="containermnu">
                  <div class="menudep2">
                  
<ul style="width:41px;">
<li class="top"> <a href="/" class="menuppal"><?=_("home")?></a></li>
</ul>
<ul style="width:117px">
<li class="top"> <a href="#" class="menuppal"><?=_("sobre nosotros")?></a></li>
<li class="item minus25"><a href="/?module=nosotros&i=1"><div><?=_("Perfil de la empresa")?></div></a></li>
<li class="item minus25"><a href="/?module=nosotros&i=2" ><div><?=_("Canales de distribución")?></div></a></li>
<li class="item minus25"><a href="/?module=nosotros&i=3"><div><?=_("Compromiso de Excelencia")?></div></a></li>
<li class="item minus25"><a href="/?module=nosotros&i=4" style="text-transform:none !important"><div><?=_("QUORiON Data Systems GmbH")?></div></a></li>
<li class="item minus25"><a href="/?module=nosotros&i=5" ><div><?=_("Productos & Servicios")?></div></a></li>
<li class="item minus25"><a href="/?module=testimonios" ><div><?=_("Testimonios")?></div></a></li>
</ul>
<ul style="width:80px">
<li class="top"> <a href="#" class="menuppal"><?=_("productos")?></a></li>
<li class="item minus25"><a href="/?module=destacados"><div><?=_("Destacados & Promociones")?></div></a></li>
<?php
$rsscategoria_padre = $Shop->getCategoria(array("fk_categoria_padre"=>0));
foreach($rsscategoria_padre["results"] as $keyserf => $valueserf){
    if($valueserf["pk_categoria"]==5) continue;
?> 
<li class="item minus25"><a href="/?module=categoria&i=<?=$valueserf["pk_categoria"]?>"><div><?=$valueserf["categoria" .$_SESSION["LOCALE"]]?></div></a></li>
<?php
}
?>
<li class="item minus25"><a href="/?module=accesorios&i=5&k=30&j=1"><div><?=_("Accesorios & Perifericos")?></div></a></li>
</ul>
<ul style="width:159px">
<li class="top"> <a href="/?module=noticias_home" class="menuppal"><?=_("noticias & novedades")?></a></li>
</ul>
<ul style="width:60px">
<li class="top"> <a href="#" class="menuppal"><?=_("soporte")?></a></li>
<li class="item minus25"><a href="/<?php if(isset($_SESSION["user"])){ ?>?module=soporte<?php }else{ ?>?module=ingreso&fromurl=<?=urlencode("?module=soporte")?><?php } ?>" ><div><?=_("Descarga & Documentación")?></div></a></li>
<li class="item minus25"><a href="/<?php if(isset($_SESSION["user"])){ ?>?module=enajenaciones<?php }else{ ?>?module=ingreso&fromurl=<?=urlencode("?module=enajenaciones")?><?php } ?>"><div><?=_("DIMAFI")?></div></a></li>
<li class="item minus25"><a href="<?php if(isset($_SESSION["user"])){ ?>soporte/fiscalizar.php<?php }else{ ?>?module=ingreso&fromurl=<?=urlencode("?module=enajenaciones")?><?php } ?>"><div><?=_("Servicio T&eacute;cnico")?></div></a></li>-->
</ul>
<ul style="width:97px">
<li class="top"> <a href="/?module=contacto" class="menuppal"><?=_("contactenos")?></a></li>
</ul>
                  </div></div>
                 
                  </th>
                  <th width="10" height="32" scope="col"><img src="images/iconos/bot-separa.png" width="1" height="26" /></th>
                  <th width="72" align="right" scope="col"><a href="?module=ingreso" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('login','','images/iconos/login_boton.png',1)"><img src="images/iconos/login_botoff.png" alt="Usuario Registrado" name="login" width="59" height="24" border="0" id="login" /></a></th>
                </tr>
              </table></th>
            </tr>
          </table>
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col"><img src="images/spacer.gif" width="8" height="8" /></th>
              </tr>
            </table>
            <?php require("./modules/" . $GLOBALS["modulo"] . ".php"); ?>
          <br />
          <br />
          <br />
          <br />
          <br /></th>
        </tr>
    </table></th>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th align="center" valign="middle" class="footer" scope="col"><table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th width="628" scope="col"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="33%" valign="top" scope="col"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="left" valign="top" scope="col"><strong><?=_("SOBRE NOSOTROS")?></strong><br />
                    <a href="?module=nosotros&i=1" class="footerlnk"><?=_("Perfil de la empresa")?></a><br />
                    <a href="?module=nosotros&i=2" class="footerlnk"><?=_("Canales de distribución")?></a><br />
                    <a href="/?module=nosotros&i=3" class="footerlnk"><?=_("Compromiso de excelencia")?></a><br />
                    <a href="/?module=nosotros&i=4" class="footerlnk"><?=_("Quorion Data Systems GmbH")?></a></th>
                </tr>
              </table></th>
              <th width="33%" align="left" valign="top" scope="col"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="left" valign="top" scope="col"><?=_("PRODUCTOS")?><br />
                  
                  <?php
$rsscategoria_padre = $Shop->getCategoria(array("fk_categoria_padre"=>0));
foreach($rsscategoria_padre["results"] as $keyserf => $valueserf){
    if($valueserf["pk_categoria"]==5) continue;
?> 
<a href="/?module=categoria&i=<?=$valueserf["pk_categoria"]?>" class="footerlnk"><?=$valueserf["categoria" .$_SESSION["LOCALE"]]?></a><br />
<?php
}
?>

</th>
                </tr>
              </table></th>
              <th width="33%" valign="top" scope="col"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr>
                  <th align="left" scope="col"><?=_("SOPORTE & DOCUMENTACION")?><br />
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th width="51%" align="left" scope="col"><a href="?module=soporte" class="footerlnk"><?=_("Login")?><br />
                          <?=_("Por Producto")?><br />
                          <?=_("Documentación")?><br />
                          <?=_("Drivers")?><br />
                          <?=_("Software")?></a></th>
                        <th width="49%" align="left" valign="top" scope="col"><a href="?module=soporte" class="footerlnk"><?=_("Demos")?><br />
                          <?=_("Tutoriales")?><br />
                          <?=_("Marketing")?></a></th>
                      </tr>
                    </table></th>
                </tr>
              </table></th>
            </tr>
          </table></th>
          <th width="322" scope="col"><table width="90%" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <th scope="col"><table width="22%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
                  <th width="45%" scope="col"><a href="https://www.facebook.com/pages/Corporacion-ECRS-CA/150266835098197" target="_blank"><img src="images/iconos/icon_facebook.png" alt="H&aacute;gase fan en Facebook" width="35" height="34" border="0" /></a></th>
                  <th width="55%" scope="col"><a href="https://twitter.com/corp_ecrs" target="_blank"><img src="images/iconos/icon_twitter.png" alt="S&iacute;ganos en Twitter" width="34" height="34" border="0" /></a></th>
                </tr>
              </table></th>
            </tr>
            <tr>
              <td height="77" align="right" class="text_footer">CORPORACION ECRS, C.A. RIF: J-31322279-8<br />
                2012 &copy; <?=_("Todos los derechos reservados")?><br />
                <?=_("Politicas de privacidad")?>   |   <?=_("Condiciones de uso")?></td>
            </tr>
            <tr>
              <td><table width="77%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
                  <th width="51%" align="left" valign="top" scope="col"><a href="http://get.adobe.com/es/flashplayer/" target="_blank"><img src="images/iconos/icon_flashplayer.png" alt="Flash Player" width="103" height="32" border="0" /></a></th>
                  <th width="49%" align="right" scope="col"><img src="images/iconos/icon_certificados.png" width="90" height="43" alt="Certificados" /></th>
                </tr>
              </table></td>
            </tr>
          </table></th>
        </tr>
    </table></th>
  </tr>
</table>


<?php
$controlaboton=1;
require_once('webim/b.php');

if(eregi('on',$image_postfix)){
?>
<div id="poplala" style="display:<?='none'?>;">

 <?php if($_SESSION["fk_pais_seleccionado"]==2){ ?>
<!-- webim button --><a href="/webim/client.php?locale=en&amp;style=default" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/webim/client.php?locale=en&amp;style=default&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="images/chat-support.gif"  alt="" width="211" height="117" border="0"/></a><!-- / webim button -->
<?php }else{ ?>
<!-- webim button --><a href="/webim/client.php?locale=sp&amp;style=default" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/webim/client.php?locale=sp&amp;style=default&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="images/chatwindows.gif" border="0"  alt=""/></a><!-- / webim button -->
<?php } ?>

</div>
<?php } ?>

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <!-- parte nueva -->
        <form id="form_fiscalizar" name="form_fiscalizar" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">  
            <input type="hidden" id="dispatchAction" name="dispatchAction"/>   
            <input type="hidden" id="numeroRegistroMaquina" name="numeroRegistroMaquina"/>
            <input type="hidden" id="letraRifTecnico" name="letraRifTecnico"/>            
            <input type="hidden" id="rifTecnico" name="rifTecnico"/>
            <input type="hidden" id="letraRifCliente" name="letraRifCliente"/>            
            <input type="hidden" id="rifCliente" name="rifCliente"/>
            <input type="hidden" id="nombreTipoCliente" name="nombreTipoCliente"/>  
            <input type="hidden" id="nbrTecnico" name="nbrTecnico"/>
            <input type="hidden" id="nbrCliente" name="nbrCliente"/>
            <input type="hidden" id="sistemaAdministrativo" name="sistemaAdministrativo"/>
            <input type="hidden" id="numeroFactura" name="numeroFactura"/>
            <input type="hidden" id="fechaFactura" name="fechaFactura"/>            
                   
            <div align="center">         
                <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">                               
                    <tr>
                        <td>
                            <table class="TablaNormal" border="0" cellspacing="0" cellpadding="0" width="97%" align="left" id="Table1" style="z-index:102; text-align:left">
                                <tr>
                                    <td>
                                        <?php include("controls/access.inc"); ?>                                                                                                
                                    </td>
                                </tr>
                            </table>                            
                            <p>&nbsp;</p>
                        </td>
                    </tr>                                                                             
                    <tr>                                       
                        <th class="productos_round_box">                            
                            <table class="TablaNormal" border="0" cellspacing="1" cellpadding="0" width="97%" align="left" id="Table1" style="z-index:102; text-align:left">
                                <tr>
                                    <th colspan="2" height="48" align="left" scope="col"><span class="trebuchet_rojo20">Solicitud de Fiscalización</span></th>
                                </tr>
                                <tr>
                                    <td bgcolor="#F4F4F4"><label for="Numero_registro_maquina" class="titulorojo_destacado">Serial del Equipo</label><span style="color:#FF0000"> *</span></td>
                                    <td bgcolor="#F4F4F4"><input id="Numero_registro_maquina" name="Numero_registro_maquina" type="text" size="21" maxlength="40" style="text-transform:uppercase" class="TextoCajaNormal" required="true" tabindex="8" value="<?php echo $serial_maquina; ?>"/>
                                    &nbsp;<em>XW + Letra o N&uacute;mero + N&uacute;mero de 7 d&iacute;gitos</em></td>
                                </tr>             
                                <tr>
                                    <td bgcolor="#F4F4F4" width="250"><label for="RIF_tecnico" class="titulorojo_destacado">RIF del T&eacute;cnico</label><span style="color:#FF0000"> *</span></td>
                                    <td bgcolor="#F4F4F4">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr><td width="1%">                                    
                                    <select id="Letra_RIF_tecnico" name="Letra_RIF_tecnico" class="ComboNormal">
                                        <option value="V" <?php if($letra_rif_tecnico == "V") echo 'selected'; ?>>V</option>
                                        <option value="E" <?php if($letra_rif_tecnico == "E") echo 'selected'; ?>>E</option>
                                        <option value="P" <?php if($letra_rif_tecnico == "P") echo 'selected'; ?>>P</option>
                                    </select>               
                                    </td><td bgcolor="#F4F4F4" align="left">                     
                                    <input id="RIF_tecnico" name="RIF_tecnico" type="text" size="13" maxlength="9" style="text-transform:uppercase; margin-left: 3px;" class="TextoCajaNormal" required="true" tabindex="7" value="<?php echo $rif_tecnico; ?>"/>
                                    &nbsp;<em>Letra + N&uacute;mero de 9 d&iacute;gitos</em>
                                    </td></tr>
                                    </table>                                    
                                    </td>
                                </tr>                                
                                <tr>
                                    <td bgcolor="#F4F4F4" width="250"><label for="RIF_cliente" class="titulorojo_destacado">RIF del Cliente</label><span style="color:#FF0000"> *</span></td>
                                    <td bgcolor="#F4F4F4">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr><td width="1%">
                                    <select id="Letra_RIF_cliente" name="Letra_RIF_cliente" class="ComboNormal">
                                        <option value="J" <?php if($letra_rif_cliente == "J") echo 'selected'; ?>>J</option>
                                        <option value="G" <?php if($letra_rif_cliente == "G") echo 'selected'; ?>>G</option>
                                        <option value="V" <?php if($letra_rif_cliente == "V") echo 'selected'; ?>>V</option>
                                        <option value="E" <?php if($letra_rif_cliente == "E") echo 'selected'; ?>>E</option>
                                        <option value="P" <?php if($letra_rif_cliente == "P") echo 'selected'; ?>>P</option>
                                    </select>
                                    </td><td bgcolor="#F4F4F4" align="left">
                                    <input id="RIF_cliente" name="RIF_cliente" type="text" size="13" maxlength="9" style="text-transform:uppercase; margin-left: 3px;" class="TextoCajaNormal" required="true" tabindex="6" value="<?php echo $rif_cliente; ?>" />
                                    &nbsp;<em>Letra + N&uacute;mero de 9 d&iacute;gitos</em>
                                    </td></tr>
                                    </table>
                                    </td> 
                                </tr>
                                <tr>
                                    <td bgcolor="#F4F4F4"><label for="Tipo_cliente" class="titulorojo_destacado">Tipo de Cliente</label></td>
                                    <td bgcolor="#F4F4F4">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr><td width="1%">
                                    <select id="Nombre_Tipo_cliente" name="Nombre_Tipo_cliente" class="ComboNormal">
                                        <option value="Ordinario" <?php if($nombre_tipo_cliente == "Ordinario") echo 'selected'; ?>>Ordinario</option>
                                        <option value="Formal" <?php if($nombre_tipo_cliente == "Formal") echo 'selected'; ?>>Formal</option>
                                        <option value="No Sujeto al IVA" <?php if($nombre_tipo_cliente == "No Sujeto al IVA") echo 'selected'; ?>>No Sujeto al IVA</option>
                                    </select>
                                    </td></tr>
                                    </table>
                                    </td>                                                                                                                                                                                                         
                                </tr>                                  
                                <tr>
                                    <td bgcolor="#F4F4F4"><label for="NBR_tecnico" class="titulorojo_destacado">Nombre del T&eacute;cnico</label></td>
                                    <td bgcolor="#F4F4F4"><input id="NBR_tecnico" name="NBR_tecnico" type="text" size="60" maxlength="80" style="text-transform:uppercase; background-color: #f3f3f3;" class="TextoCajaNormal" readonly="true" tabindex="5" value="<?php echo $nbr_tecnico; ?>"/></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#F4F4F4"><label for="NBR_cliente" class="titulorojo_destacado">Nombre del Cliente</label></td>
                                    <td bgcolor="#F4F4F4"><input id="NBR_cliente" name="NBR_cliente" type="text" size="60" maxlength="80" style="text-transform:uppercase; background-color: #f3f3f3;" class="TextoCajaNormal" readonly="true" tabindex="4" value="<?php echo $nbr_cliente; ?>"/></td>
                                </tr>   
                                <tr>
                                    <td bgcolor="#F4F4F4"><label for="Sistema_administrativo" class="titulorojo_destacado">Sistema administrativo que usa el cliente</label></td>
                                    <td bgcolor="#F4F4F4"><input id="Sistema_administrativo" name="Sistema_administrativo" type="text" size="60" maxlength="80" style="text-transform:uppercase" class="TextoCajaNormal" tabindex="3" value="<?php echo $sistema_administrativo; ?>"/></td>
                                </tr>                                                                
                                <tr>
                                    <td bgcolor="#F4F4F4"><label for="Numero_factura" class="titulorojo_destacado">Número de factura del cliente</label><span style="color:#FF0000"> *</span></td>
                                    <td bgcolor="#F4F4F4" valign="top"><input id="Numero_factura" name="Numero_factura" type="text" size="21" maxlength="40" style="text-transform:uppercase" class="TextoCajaNormal" required="true" tabindex="2" value="<?php echo $numero_factura; ?>"></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#F4F4F4"><label for="Fecha_factura" class="titulorojo_destacado">Fecha de la factura</label><span style="color:#FF0000"> *</span></td>
                                    <td bgcolor="#F4F4F4"><input id="Fecha_factura" name="Fecha_factura" type="text" size="21" maxlength="10" style="text-transform:uppercase" class="TextoCajaNormal" required="true" tabindex="1" value="<?php echo $fecha_factura; ?>" />
                                    &nbsp;<em>dd / mm / yyyy</em></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#F4F4F4" valign="top" colspan="2">
                                    <br /><span style="color:#FF0000">* </span>
                                    <span><em>Los campos con asterisco son obligatorios. Luego enviar la factura digitalizada al email fiscalizacion@ecrs.com.ve, colocando en el asunto el serial de la máquina</em></span>
                                    </td>
                                </tr>
                                <tr style="background-color: yellow;">
                                    <td colspan="2" align="left" style="color:#FF0000"><span><?php echo $mensaje; ?></span></td>
                                </tr>                                   
                                <tr align="center">                                                                                                                                                
                                    <td colspan="2">
                                    <div id="div_enviar" style="display: none;">
                                    <br /><input id="enviar" name="enviar" type="submit" value="Validar"/>
                                    </div>
                                    <div id="div_editar" style="display: none;">
                                    <br /><input id="finalizar" name="finalizar" type="submit" value="Finalizar"/>&nbsp;<input id="editar" name="editar" type="button" value="Editar" onclick="onClickEditar();"/>
                                    </div>
                                    </td>                                    
                                </tr>                                                                            
                            </table>                                                        
                        </th>        
                    </tr>
                </table>
                <br />
                <div id="myGrid" style="width:690px; height:480px;"></div>
                <br />  
                <input id="Borrar" name="Borrar" type="button" value="Borrar" />     
                <input class="cancel" id="Finalizar" name="Finalizar" type="submit" value="Finalizar" />                
            </div>  
        </form>
                
        <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>        
        <script src="js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
        <script src="js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="js/datepicker-2.5.js" type="text/javascript"></script>   
        
        <script src="controls/SlickGrid/lib/jquery.event.drag-2.0.min.js"></script>
        <script src="controls/SlickGrid/slick.core.js"></script>
        <script src="controls/SlickGrid/slick.grid.js"></script>  
                    
        <script src="controls/SlickGrid/plugins/slick.checkboxselectcolumn.js"></script>
        <script src="controls/SlickGrid/plugins/slick.autotooltips.js"></script>
        <script src="controls/SlickGrid/plugins/slick.cellrangedecorator.js"></script>
        <script src="controls/SlickGrid/plugins/slick.cellrangeselector.js"></script>
        <script src="controls/SlickGrid/plugins/slick.cellcopymanager.js"></script>
        <script src="controls/SlickGrid/plugins/slick.cellselectionmodel.js"></script>
        <script src="controls/SlickGrid/plugins/slick.rowmovemanager.js"></script>
        <script src="controls/SlickGrid/plugins/slick.rowselectionmodel.js"></script>
        <script src="controls/SlickGrid/slick.formatters.js"></script>
        <script src="controls/SlickGrid/slick.editors.js"></script>
        
        <script type="text/javascript">
            function editElements(valor)
            {
                document.getElementById("Numero_registro_maquina").disabled = valor;
                document.getElementById("Letra_RIF_tecnico").disabled = valor;
                document.getElementById("RIF_tecnico").disabled = valor;
                document.getElementById("Letra_RIF_cliente").disabled = valor;
                document.getElementById("RIF_cliente").disabled = valor;
                document.getElementById("Nombre_Tipo_cliente").disabled = valor;
                document.getElementById("NBR_tecnico").disabled = valor;
                document.getElementById("NBR_cliente").disabled = valor;
                document.getElementById("Sistema_administrativo").disabled = valor;
                document.getElementById("Numero_factura").disabled = valor;
                document.getElementById("Fecha_factura").disabled = valor;            
            }        
        
            function onLoad()
            {                
                <?php if(!$edicion) { ?>
                //var limit = document.forms[0].elements.length;
                //for (i=0;i<limit;i++) {
                //  document.forms[0].elements[i].disabled = true;
                //}                
                editElements(true);
                document.getElementById("div_editar").style.display = 'block';
                <?php } else { ?>
                document.getElementById("div_enviar").style.display = 'block';
                <?php } ?>
            }
            
            function onClickEditar()
            {
                editElements(false);
                document.getElementById("div_editar").style.display = 'none';
                document.getElementById("div_enviar").style.display = 'block';
                //var limit = document.forms[0].elements.length;
                //for (i=0;i<limit;i++) {
                //  document.forms[0].elements[i].disabled = false;
                //}                
            }
        
            function updateSize() {
                if (typeof window.FileReader !== 'function') {
                    alert("The file API isn't supported on this browser yet.");
                    return;
                }                 
                                
                var nBytes = 0,
                oFiles = document.getElementById("uploadInput").files,
                nFiles = oFiles.length;
                for (var nFileId = 0; nFileId < nFiles; nFileId++) {
                    if (!oFiles[nFileId].type.match('image.*')) {
                        continue;
                    }                       
                    nBytes += oFiles[nFileId].size;  
                    
                    createReader(oFiles[nFileId], function(w, h) {
                        //alert("Hi the width is " + w + " and the height is " + h);
                        document.getElementById('rateimg').value = w / h;
                        //alert("Rate Image " + document.getElementById('rateimg').value);
                    });
                }
                var sOutput = nBytes + " bytes";
                // optional code for multiples approximation
                for (var aMultiples = ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
                    sOutput = nApprox.toFixed(3) + " " + aMultiples[nMultiple] + " (" + nBytes + " bytes)";
                }
                // end of optional code
                document.getElementById("fileNum").innerHTML = nFiles;
                document.getElementById("fileSize").innerHTML = sOutput;

                var img = document.getElementById('imageLoaded'); 
                //or however you get a handle to the IMG
                var width = img.clientWidth;
                var height = img.clientHeight;
            }              
        
            $(document).ready(function() {
                    var grid;
                    <?php echo $data; ?>  
                    
                    var checkboxSelector = new Slick.CheckboxSelectColumn({
                        cssClass: "slick-cell-checkboxsel"
                    });
                                        
                    var columns = [];
                    
                    columns.push(checkboxSelector.getColumnDefinition());                        
                    columns.push({id: "id_fecha", name: "Fecha (DD/MM/AAAA)", field: "fecha"});
                    <?php if($allow['rif_distribuidor']) { ?>
                    columns.push({id: "id_rif_distribuidor", name: "Rif del Distribuidor", field: "rif_distribuidor"});
                    columns.push({id: "id_rs_distribuidor", name: "Nombre del Distribuidor", field: "rs_distribuidor"});
                    <?php } ?>
                    columns.push({id: "id_rif_cliente", name: "Rif del Cliente", field: "rif_cliente"});
                    columns.push({id: "id_rs_cliente", name: "Nombre del Cliente", field: "rs_cliente"});
                    columns.push({id: "id_rif_tecnico", name: "Rif del Tecnico", field: "rif_tecnico"});
                    columns.push({id: "id_rs_tecnico", name: "Nombre del Tecnico", field: "rs_tecnico"});
                    columns.push({id: "id_serial", name: "Numero de Registro Fiscal", field: "serial"});
                    columns.push({id: "id_tipo_op", name: "Tipo de Operacion", field: "tipo_op"});
                    columns.push({id: "id_rs_tipo_op", name: "Nombre del Tipo de Operacion", field: "rs_tipo_op"});  
                      
                    var options = {
                        editable: false,
                        enableAddRow: false,
                        enableCellNavigation: true,
                        enableColumnReorder: false
                    };     
                    
                    grid = new Slick.Grid("#myGrid", data, columns, options);           
                                        
                    jQuery(function($) {     
                            $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                                    return arg != value;
                                }, "Value must not equal arg.");  
                                
                            $.validator.addMethod("alphanumeric", function(value, element) {
                                    return this.optional(element) || /^[a-zA-Z0-9 _\-]+$/.test(value);
                            });                                                             
                                                       
                            $("#form_fiscalizar").validate({            
                                    rules: {
                                        Numero_registro_maquina: { required: true },
                                        RIF_cliente: { required: true },
                                        RIF_tecnico: { required: true },
                                        Numero_factura: { required: true },                                              
                                        Fecha_factura: { required: true }
                                    },
                                    messages: {
                                        Numero_registro_maquina: "",
                                        RIF_cliente: "",
                                        RIF_tecnico: "",
                                        Numero_factura: "",
                                        Fecha_factura: ""
                                    }            
                            });  
                            
                            $.mask.definitions['^'] = '[a-zA-Z0-9]';
                            $("#Numero_registro_maquina").mask("XW^9999999",{placeholder:" "});  
                            
                            $("#RIF_cliente").mask("999999999",{placeholder:" "});        
                            
                            $("#RIF_tecnico").mask("999999999",{placeholder:" "});
                            
                            $.mask.definitions['~'] = '[a-zA-Z0-9 _\-]';
                            $("#Sistema_administrativo").mask("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~",{placeholder:" "});
                            
                            $.mask.definitions['h'] = '[a-zA-Z0-9 _\-]';
                            $("#Numero_factura").mask("hhhhhhhhhhhhhhh",{placeholder:" "}); 
                            
                            $("#Fecha_factura").mask("99/99/9999");                                
                            
                            $("input[type=submit]").click(function() {
                                if($("#form_fiscalizar").valid())
                                {
                                    $("#dispatchAction").val($(this).attr('name'));
                                    $("#numeroRegistroMaquina").val($("#Numero_registro_maquina").val());
                                    $("#letraRifTecnico").val($("#Letra_RIF_tecnico").val());
                                    $("#rifTecnico").val($("#RIF_tecnico").val());
                                    $("#letraRifCliente").val($("#Letra_RIF_cliente").val());
                                    $("#rifCliente").val($("#RIF_cliente").val());
                                    $("#nombreTipoCliente").val($("#Nombre_Tipo_cliente").val());
                                    $("#nbrTecnico").val($("#NBR_tecnico").val());
                                    $("#nbrCliente").val($("#NBR_cliente").val());
                                    $("#sistemaAdministrativo").val($("#Sistema_administrativo").val());
                                    $("#numeroFactura").val($("#Numero_factura").val());
                                    $("#fechaFactura").val($("#Fecha_factura").val());

                                    $(this).css("opacity", "0.4");
                                    $(this).css("filter", "alpha(opacity=40)");
                                    $(this).attr('disabled',true);                                    
                                    $("#form_fiscalizar").submit();
                                }
                            });                            
                    });
                    
                    var langEs=[["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"], 
                        [], [], ["Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado","Domingo"], [], [], "Hoy"];                        
                    
                    var cal = new DatePicker('#Fecha_factura', {
                            autoOpen:true,
                            min:"1jan2009",
                            max:new Date(),
                            format:"d/m/Y",                                
                            firstDayOfWeek:6,
                            language:"es"
                    });
                    cal.addLanguage("es",langEs);
            });                    
        </script>     
    </body>
</html>    