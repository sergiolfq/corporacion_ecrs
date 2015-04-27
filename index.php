<?php
require_once("includes/includes.php");

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

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0">    
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="SKYPE_TOOLBAR" content ="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
<title><?php if(isset($_GET["pro"])){ ?>Comprar <?=$rs["results"][0]["nombre"]?> / <?=$rs["results"][0]["sku"]?> - Corporaci&oacute;n ECRS - Cajas Registradoras Alemanas QUORION -<?php }elseif($_GET["module"]=='categoria'){ ?> - Corporaci&oacute;n ECRS - Cajas Registradoras Alemanas QUORION - <?=str_replace('&raquo;','-',strip_tags($Shop->migas($_GET)))?> <?php }else{ ?> - Corporaci&oacute;n ECRS - Cajas Registradoras Alemanas QUORION -<?php } ?></title>
<meta name="Keywords" content="Corporaci&oacute;n ECRS, Corporaci&oacute;n, ECRS, QUORiON, Quorion, Cajas Registradoras, Cajas Registradoras Fiscales, Impresoras Fiscales, Equipos Fiscales, Soluciones Fiscales, Sistemas Fiscales, Punto de Venta, Sistemas de Punto de Venta, Impresora de Punto de Venta, Impresora de Loter&iacute;a, Impresora de Asar, Impresor de Cocina, Impresor de Barra, Comanderas, CR 20, CR 28, QPrint MF, QPrint, QMP 5000, QMP 5040, QMP 5140, QMP 5286, SERIE 5000, SERIE 3000, QMP 3226, QMP 1120, QTouch 2, QTouch 15 PC, POS Concerto, QKeyboard, QOrder, Integradores de Software,  Sistemas POS, Terminal de Mano, Venezuela, Caracas, EL Para&iacute;so, Colombia, Bogot&aacute;, M&eacute;xico, DF, Cajas Registradoras, Cajas Registradoras Alemanas,  Cajas Registradoras Homologadas por el SENIAT, M&aacute;quinas Fiscales Aprobadas por el SENIAT, Proveedores de M&aacute;quinas Fiscales, Proveedores de M&aacute;quinas Fiscales en Venezuela, Proveedores de Impresoras Fiscales, Proveedores de Impresoras Fiscales en Venezuela, Importador de Cajas Registradoras Fiscales, Distribuidores de Cajas Registradoras Fiscales, Distribuidores de Impresoras Fiscales, Lectores de C&oacute;digo de Barra, Verificadores de Precio, Sistemas de Facturaci&oacute;n, Sistemas de Facturaci&oacute;n para Restaurantes, Sistemas de Facturaci&oacute;n para Supermercados, Sistemas de Facturaci&oacute;n para Farmacias, Software Administrativos, Balanzas Electr&oacute;nicas, Servicio de Cajas Registradoras Fiscales, Centro de Servicio de Cajas Registradoras Fiscales, Servicio T&eacute;cnico de Cajas Registradoras Fiscales, Contador de Billetes, Contadora de Billetes, Consumibles, Rollos de Papel, Rollos de Etiqueta, Gavetas de Dinero, Display de Clientes, Cash Drawer, Customer Display, Display LCD, External Display, Bar Code, Check Price, Hand Terminal, Fiscal Cash Register, Fiscal Printer, Roll Paper, Scale, POS Terminal, Keyboard,  Kitchen Printer, QUORION POS Systems, QMP POS Software, Beverage Dispensers, Currency counter, Dirección: Av. De Los Samanes, Calle Madariaga, Edif. EURO, Nivel Mezzanina, Local 19 y 20 El Paraíso. Caracas – VenezTeléfonos: +58 212-481.9721 / +58 212-482.8803" />
<link rel="shortcut icon" href="favicon.ico" >
<link href="/includes/css/ecrs_estilos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/includes/css/fonts.css" type="text/css" charset="utf-8" />

<style type="text/css">
<!--
a:link { color: #000000; text-decoration: none}
-->
</style>



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
<script language="javascript" type="text/javascript" src="/includes/js/scriptaculous/prototype.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/scriptaculous/scriptaculous.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/validation.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/comunes.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/prototype.maskedinput.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/md5-0.9.js"></script>



<script language="javascript" type="text/javascript">
function mantenerSession () {
  new Ajax.Request('/ajax_resp/mantain_session.php',{method:'post',parameters: ''})
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


<!-- Web Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700,300&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>

		<!-- Bootstrap core CSS -->
                <link href="estilos/bootstrap/css/bootstrap.css" rel="stylesheet">

		<!-- Font Awesome CSS -->
                <link href="estilos/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

		<!-- Fontello CSS -->
                <link href="estilos/fonts/fontello/css/fontello.css" rel="stylesheet">

		<!-- Plugins -->
                <link href="estilos/plugins/rs-plugin/css/settings.css" media="screen" rel="stylesheet">
                <link href="estilos/plugins/rs-plugin/css/extralayers.css" media="screen" rel="stylesheet">
                <link href="estilos/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
                <link href="estilos/css/animations.css" rel="stylesheet">
                <link href="estilos/plugins/owl-carousel/owl.css" rel="stylesheet">
              
                    
     
              <!--         <script type="text/javascript" src="estilos/plugins/jquery.js"></script>
              <!--         <script type="text/javascript" src="estilos/bootstrap/js/bootstrap.js"></script>

                <!-- Modernizr javascript -->
   <!--         <script type="text/javascript" src="estilos/plugins/modernizr.js"></script>

                <!-- jQuery REVOLUTION Slider  -->
                 <!--              <script type="text/javascript" src="estilos/plugins/rs-plugin/js/jquery.themepunch.tools.js"></script>
                <script type="text/javascript" src="estilos/plugins/rs-plugin/js/jquery.themepunch.revolution.js"></script>

                <!-- Isotope javascript -->
               <!--                <script type="text/javascript" src="estilos/plugins/isotope/isotope.pkgd.js"></script>    
                
                
                <!-- Owl carousel javascript -->
               <!--                <script type="text/javascript" src="estilos/plugins/owl-carousel/owl.js"></script>
                
                  <!-- Magnific Popup javascript -->
                      <!--         <script type="text/javascript" src="estilos/plugins/magnific-popup/jquery.magnific-popup.js"></script>
                         
                <!-- Appear javascript -->
                          <!--     <script type="text/javascript" src="estilos/plugins/jquery(1).js"></script>

                <!-- Count To javascript -->
             <!--   <script type="text/javascript" src="estilos/plugins/jquery(2).js"></script> -->
                            <!-- Parallax javascript -->
                          <!--     <script src="estilos/plugins/jquery.parallax-1.1.js"></script>

                <!-- Contact form -->
                          <!--     <script src="estilos/plugins/jquery(3).js"></script>  

                <!-- Initialization of Plugins -->
                          <!--     <script type="text/javascript" src="estilos/js/template.js"></script>

                <!-- Custom Scripts -->
                          <!--     <script type="text/javascript" src="estilos/js/custom.js"></script>
                
		<!-- iDea core CSS file -->
                <link href="estilos/css/style.css" rel="stylesheet">

		<!-- Style Switcher Styles (Remove these two lines) -->
		<link href="#" data-style="styles" rel="stylesheet">
                    <link href="estilos/style-switcher/style-switcher.css" rel="stylesheet">

		<!-- Custom css --> 
                <link href="estilos/css/custom.css" rel="stylesheet">
	



</head>


    <body class="front">
            <!-- scrollToTop -->
            <!-- ================ -->
            <div class="scrollToTop"><i class="icon-up-open-big"></i></div>
            
            <div class="page-wrapper">
    		    <div class="header-top">
			 <div class="container">
					<div class="row">
						<div class="col-ms-2  col-sm-6">

							 <!-- header-top-first start -->
							<!-- ================ -->
							<div class="header-top-first clearfix">
								<ul class="social-links clearfix hidden-xs">
									<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
									
									<li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
									<li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
									<li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
									<li class="facebook"><a target="_blank" href="https://www.facebook.com/CorporacionECRS"><i class="fa fa-facebook"></i></a></li>
									
								</ul>
								<div class="social-links hidden-lg hidden-md hidden-sm">

									<div class="btn-group dropdown">

									  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share-alt"></i></button>
										<ul class="dropdown-menu dropdown-animation">
											<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
											
										    <li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
											<li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
											
											
											<li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
											
										</ul>
									</div>
								</div>
							</div>
							<!-- header-top-first end -->

						</div>

							<!-- header-top-second start -->
							<!-- ================ -->
							<div id="header-top-second" class="clearfix">



								<!-- header top dropdowns start -->
								<!-- ================ -->
								<div class="header-top-dropdown">

									<div class="btn-group dropdown">

                                                                            <button type="button" >
                                                                                <?php if (!isset($_SESSION["user"])) { ?>
                                                                                    <a href="/ingreso/nuevo_ingreso.php"><i class="icon-user"></i>&nbsp;Ingrese</a>
                                                                                <?php } else { ?>
                                                                                    <a href="/" ><i class="icon-user"></i>&nbsp;<?= $_SESSION["user"]["nombres"] . " " . $_SESSION["user"]["apellidos"] ?></a>
                                                                                <?php } ?>
                                                                            </button>                                                  
                                                                      		<button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i> Buscar</button>
										<ul class="dropdown-menu dropdown-menu-right dropdown-animation">
											<li>
												<form action="?" method="get" id="buscador" name="frmBuscar">
													<div class="form-group has-feedback">
                                                                                                            <input type="text" class="form-control" name="buscar" id="buscador3" placeholder="Buscar" value="<?php if(trim($_GET["buscar"])!=''){ echo strip_tags($_GET["buscar"]); }else{ echo _("Buscar");}?>"  > 
                                                                                                                <input type="hidden" name="module" value="categoria" />
                                                                                                            <i class="fa fa-search form-control-feedback"></i>
                                                                                                            
													</div>
												</form>
											</li>
										</ul>

                                                                                <button type="button" class="btn "><i class="fa fa-bold"></i> <a href="?module=noticias_home#">Blog </button>
                                                                        
                                                                    
                                                                        
									</div>


                                                                                <?php if(!isset($_SESSION["user"])){ ?>
                                                                                &iquest;<?=_("Nuevo usuario")?>? <a href="?module=registro" class="rojosubrayado"><?=_("Ingrese")?></a>
                                                                                <?php } ?>

									<div class="btn-group dropdown">

											
										
                                                                                   


										<ul class="dropdown-menu dropdown-menu-right dropdown-animation">
											<li>
												<form class="login-form">
													<div class="form-group has-feedback">
														<label class="control-label">Username</label>
														<input type="text" class="form-control" placeholder="">
														<i class="fa fa-user form-control-feedback"></i>
													</div>
													<div class="form-group has-feedback">
														<label class="control-label">Password</label>
														<input type="password" class="form-control" placeholder="">
														<i class="fa fa-lock form-control-feedback"></i>
													</div>
													<button type="submit" class="btn btn-group btn-dark btn-sm">Log In</button>
													<span>or</span>
													<button type="submit" class="btn btn-group btn-default btn-sm">Sing Up</button>
													<ul>
														<li><a href="#">Forgot your password?</a></li>
													</ul>
													<div class="divider"></div>
													<span class="text-center">Login with</span>
													<ul class="social-links clearfix">

														<li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>

														<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>

														<li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>

													</ul>
												</form>
											</li>
										</ul>
									</div>
									<div class="btn-group dropdown">
										<button type="button" class="btn dropdown-toggl" data-toggle="#"><i class="fa fa-shopping-cart" ></i><a href="cotizacion.html"> Su cotización</a> </button>
                                                                                
                                                                                <?php if (isset($_SESSION["user"])) { ?>
                                                                                    <button type="button" >
                                                                                        <a href="?logout=1" class="rojosubrayado"><?= _("Salir") ?></a>
                                                                                    </button>
                                                                                <?php } ?>
                                                                                <ul class="dropdown-menu dropdown-menu-right dropdown-animation cart">
											<li>
												<table class="table table-hover">
													<thead>
														<tr>
															<th class="quantity">QTY</th>
															<th class="product">Product</th>
															<th class="amount">Subtotal</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="quantity">2 x</td>
															<td class="product"><a href="shop-product.html">Android 4.4 Smartphone</a><span class="small">4.7" Dual Core 1GB</span></td>
															<td class="amount">$199.00</td>
														</tr>
														<tr>
															<td class="quantity">3 x</td>
															<td class="product"><a href="shop-product.html">Android 4.2 Tablet</a><span class="small">7.3" Quad Core 2GB</span></td>
															<td class="amount">$299.00</td>
														</tr>
														<tr>
															<td class="quantity">3 x</td>
															<td class="product"><a href="shop-product.html">Desktop PC</a><span class="small">Quad Core 3.2MHz, 8GB RAM, 1TB Hard Disk</span></td>
															<td class="amount">$1499.00</td>
														</tr>
														<tr>
															<td class="total-quantity" colspan="2">Total 8 Items</td>
															<td class="total-amount">$1997.00</td>
														</tr>
													</tbody>
												</table>
												<div class="panel-body text-right">	
												<a href="shop-cart.html" class="btn btn-group btn-default btn-sm">View Cart</a>
												<a href="shop-checkout.html" class="btn btn-group btn-default btn-sm">Checkout</a>
												</div>
											</li>
										</ul>
									</div>

								</div>
								<!--  header top dropdowns end -->

							</div>
							<!-- header-top-second end -->
                                        </div>
						</div>
					</div>
				
		   
    
    <!--segunda parta del header -->
    
    <header class="header fixed clearfix">
  <div class="container">
<div class="row">
    <div class="col-md-2">

            <!-- header-left start -->
            <!-- ================ -->
            <div class="header-left clearfix">

                    <!-- logo -->
                    <div class="logo"style="margin-top: 10px;">
                        <a href="/"><img id="logo" src="estilos/images/ecrslogo.jpg" alt="iDea"></a>
                    </div>

                    <!-- name-and-slogan -->
                    <!--div class="site-slogan">
                            <small style="padding-left: 2px;"> J-31322279-8 </small> 
                    </div-->

            </div>
            <!-- header-left end -->

    </div>
    <div class="col-md-10">

            <!-- header-right start -->
            <!-- ================ -->
            <div class="header-right clearfix">

                    <!-- main-navigation start -->
                    <!-- ================ -->
                    <div class="main-navigation animated">

                            <!-- navbar start -->
                            <!-- ================ -->
                            <nav class="navbar navbar-default" role="navigation">
                                    <div class="container-fluid">

                                            <!-- Toggle get grouped for better mobile display -->
                                            <div class="navbar-header">
                                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                                            <span class="sr-only"> Toggle navigation </span>
                                                            <span class="icon-bar"></span>
                                                            <span class="icon-bar"></span>
                                                            <span class="icon-bar"></span>
                                                    </button>
                                            </div>

                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                                    <ul class="nav navbar-nav navbar-right"style="width: 980px;padding-left: 3px;">
                                                            <li>
                                                                    <a href="/" class=""  style="padding-left: 0px;">Home</a>

                                                            </li>


                                                            <li class="dropdown">
                                                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" style="margin-left: 0px;padding-left: 30px;">Productos</a>
                                                                    <ul class="dropdown-menu">

                                                                            <li class=""><a href="?module=categoria&i=16" class="dropdown-toggle" data-toggle="dropdown">Cajas Registradoras Fiscales</a></li>

                                                                            <li class="">
                                                                                    <a href="/?module=categoria&i=2" class="dropdown-toggle" data-toggle="dropdown">Impresoras Fiscales</a>

                                                                            </li>
                                                                            <li class="">
                                                                                    <a href="?module=categoria&i=3" class="dropdown-toggle" data-toggle="dropdown">Terminales POS</a>

                                                                            </li>
                                                                            <li class="">
                                                                                    <a href="/?module=accesorios&i=5&k=30&j=1" class="dropdown-toggle" data-toggle="dropdown">Accesorios y Periféricos</a>

                                                                            </li>

                                                                    </ul>
                                                            </li>
                                                            <!-- mega-menu start -->
                                                            <li >
                                                                    <a href="/?module=noticias_home" >Autorizaciones &amp; Providencias</a>
                                                                                            
                                                            </li>
                                                            <!-- mega-menu end -->
                                                            <li class="dropdown">
                                                                    <a class="dropdown-toggle" data-toggle="dropdown">Soporte</a>
                                                                    <ul class="dropdown-menu">
                                                                            <li class="">
                                                                                    <a href="/?module=soporte" >Recursos </a></li>
                                                                            <li class="">
                                                                                    <a href="/?module=enajenaciones" class="dropdown-toggle" data-toggle="dropdown">DIMAFI</a></li>
                                                                            <li class="">
                                                                                    <a href="/?module=fiscalizar" class="dropdown-toggle" data-toggle="dropdown">Servicio Técnico</a></li>

                                                                    </ul>
                                                            </li>
                                                            <li>
                                                                    <a href="/?module=contacto"  style="margin-left: 0px; padding-left: 16px;">contactenos</a>
                                                            </li>
                                                    </ul>
                                            </div>

                                    </div>
                            </nav>
                            <!-- navbar end -->

                    </div>
                    <!-- main-navigation end -->

            </div>
            <!-- header-right end -->

						</div>
					</div>
  </div>
			</header>
			<!-- header end -->
    
    
    <!-- fin de segunda parte -->
    
    
    
<!--
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="franja_top" scope="col"><table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th width="763" align="left" scope="col">
        <marquee  behavior="scroll" direction="left" scrollamount="5" class="eras"  >
<?php
                        $Textos = new Textos;
						$rs = $Textos->getTexto(array("pk_texto" => 10));
	//					echo $rs["results"][0]["texto" . $_SESSION["LOCALE"]]
						?>

        </marquee></th>
        <th width="151" scope="col"><a href="http://www.quorion.de/" target="_blank"><img src="images/tope/quorion-logo.png" alt="Quorion Data System- Cajas registradoras" width="151" height="45" border="0" /></a></th>
        <th width="66" scope="col"><div style="position:absolute; float:left; z-index:10; top:0px"><a href="http://www.quorion.de/" target="_blank"><img src="images/iconos/Made-in-Alemania.png" width="71" height="70" alt="Hecho en Alemania" border="0" /></a></div></th>
      </tr>
    </table></th>
  </tr>
</table> -->



 <!--     <table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th valign="top" class="container" scope="col"> -->
         <?php // $GLOBALS["modulo"]="fiscalizar";
          //  die();
   ?>
            
            <?php require("./modules/" . $GLOBALS["modulo"] . ".php"); ?>
      <!--   <br />
          <br />
          <br />
          <br />
          <br /></th>
        </tr>
    </table></th>
  </tr> 

-->


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


	<!-- .footer start -->
        <!-- ================ -->
        <div class="footer">

                        <div class="row" style="padding-top: 10px;">
                                <div class="col-md-6">
                                        <div class="footer-content">

                                                <div class="row" style="padding-left: 183px; padding-bottom: 40px;">
                                                    <div class="logo-footer" style=" padding-left: 15px"><img id="logo-footer" src="estilos/images/a.png" alt=""></div>
                                                        <div class="col-sm-6">
                                                                <p style=" margin-right: 0px;margin-left: 13px;">Av. De Los Samanes, Calle Madariaga,<br> Edif. EURO, Nivel Mezzanina,Local 19 y 20.<br> El Paraíso. Caracas – Venezuela</p>
                                                                <ul class="social-links circle">
                                                                        <li class="facebook"><a target="_blank" href="https://www.facebook.com/CorporacionECRS"><i class="fa fa-facebook"></i></a></li>
                                                                        <li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
                                                                        <li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                                                                        <li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
                                                                        <li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
                                                                </ul>
                                                        </div>
                                                        <div class="col-sm-6">
                                                                <ul class="list-icons">
                                                                        <li><i class="fa fa-phone pr-10"></i> +58 212-481.9721</li>
                                                                        <li><i class="fa fa-phone pr-10"></i> +58 212-482.8803</li>
                                                                        <li><i class="fa fa-fax pr-10"></i>   +58 212-482.8806</li>
                                                                        <li><i class="fa fa-envelope-o pr-10"></i> <a>contactenos@ecrs.com.ve</a></li>
                                                                </ul>
                                                        </div>
                                                </div>

                                        </div>
                                </div>
                                <div class="space-bottom hidden-lg hidden-xs"></div>
                                <center><div class="col-sm-6 col-md-3" style="margin-top: -40px;">
                                        <div class="footer-content">
                                                <br><br>


                                                <h2>Links</h2>
                                                <nav>
                                                        <ul class="nav nav-pills nav-stacked">
                                                                <li><a href="/">Home</a></li>
                                                                <li class="active"><a href="">Productos</a></li>
                                                                <li><a href="/?module=noticias_home">Autorizaciones<br>&amp;Providencias</a></li>
                                                                <li ><a href="">Soporte</a></li>
                                                                <li><a href="/?module=contacto">Contactenos</a></li>
                                                        </ul>
                                                </nav>
                                        </div>
                                </div></center>



                                <center><div class="col-sm-6 col-md-3 col-md-offset-1"style="margin-top: -40px; margin-left: 0px;">
                                        <div class="footer-content">

                                                <br><br>

                                                <h2 style="padding-right: 175px;">Categorías</h2>
                                                <div class="gallery row" style="margin-left:0px; margin-right:0px;">
                                                        <div class="gallery-item col-xs-4">
                                                                <div class="overlay-container">
                                                                        <img src="estilos/images/gallery-1 (1).jpg" alt="">
                                                                        <a href="portfolio-item (1).html" class="overlay small text-center" style="margin-top: 35px;">
                                                                                 Cajas Registradoras 
                                                                        </a>
                                                                </div>
                                                        </div>
                                                        <div class="gallery-item col-xs-4">
                                                                <div class="overlay-container">
                                                                    <img src="estilos/images/fq.jpg" alt="">
                                                                        <a href="portfolio-item (1).html" class="overlay small text-center"style="margin-top: 35px;">
                                                                                 Impresoras Fiscales

                                                                        </a>
                                                                </div>
                                                        </div>


                                                </div>

                                                <div class="gallery-item col-xs-4">
                                                                <div class="overlay-container">
                                                                        <img src="estilos/images/pos-1.jpg" alt="">
                                                                        <a href="portfolio-item (1).html" class="overlay small text-center"style="margin-top: 35px;">
                                                                                 Terminales P.O.S 
                                                                        </a>
                                                                </div>
                                                        </div>
                                                        <div class="gallery-item col-xs-4">
                                                                <div class="overlay-container">
                                                                        <img src="estilos/images/accesorios.jpg" alt="">
                                                                        <a href="portfolio-item (1).html" class="overlay small text-center"style="margin-top: 35px;">
                                                                                 Accesorios & Periféricos 
                                                                        </a>
                                                                </div>
                                                        </div>

                                                </div>




                                        </div>
                                </div></center>
                        </div>
                       

        
        
        
        <!-- .footer end -->

        <!-- .subfooter start  subfooter acomodo por que no se ajusta -->
<div class="subfooter">
                <div class="container">
                        <div class="row">
                                <center><div style="margin-top; 100px">
                                        <p class="colorfooter" >Copyright © 2015  by Corporación ECRS. Todos los Derechos Reservados</p></center>
                                </div></center>
                                <div>
                                        <nav class="navbar navbar-default" role="navigation">
                                                <!-- Toggle get grouped for better mobile display -->
                                                <div class="navbar-header">
                                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
                                                                <span class="sr-only">Toggle navigation</span>
                                                                <span class="icon-bar"></span>
                                                                <span class="icon-bar"></span>
                                                                <span class="icon-bar"></span>
                                                        </button>
                                                </div>   

                                        </nav>
                                </div>
                        </div>
                </div> 
         
                <!-- .subfooter end -->
</footer>

<!-- JavaScript files placed at the end of the document so the pages load faster
		================================================== -->
		<!-- Jquery and Bootstap core js files -->
		<script type="text/javascript" src="estilos/plugins/jquery.js"></script>
                <script type="text/javascript" src="estilos/bootstrap/js/bootstrap.js"></script>

		<!-- Modernizr javascript -->
                <script type="text/javascript" src="estilos/plugins/modernizr.js"></script>

		<!-- jQuery REVOLUTION Slider  -->
                <script type="text/javascript" src="estilos/plugins/rs-plugin/js/jquery.themepunch.tools.js"></script>
                <script type="text/javascript" src="estilos/plugins/rs-plugin/js/jquery.themepunch.revolution.js"></script>

		<!-- Isotope javascript -->
		<script type="text/javascript" src="estilos/plugins/isotope/isotope.pkgd.js"></script>

		<!-- Owl carousel javascript -->
		<script type="text/javascript" src="estilos/plugins/owl-carousel/owl.js"></script>

		<!-- Magnific Popup javascript -->
		<script type="text/javascript" src="estilos/plugins/magnific-popup/jquery.magnific-popup.js"></script>

		<!-- Appear javascript -->
		<script type="text/javascript" src="estilos/plugins/jquery(1).js"></script>

		<!-- Count To javascript -->
            <!--    <script type="text/javascript" src="estilos/plugins/jquery%%(2).js"></script> -->

		<!-- Parallax javascript -->
                <script src="estilos/plugins/jquery.parallax-1.1.js"></script>

		<!-- Contact form -->
                <script src="estilos/plugins/jquery(3).js"></script>

		<!-- Initialization of Plugins -->
                <script type="text/javascript" src="estilos/js/template.js"></script>

		<!-- Custom Scripts -->
                <script type="text/javascript" src="estilos/js/custom.js"></script>
</body>
</html>
