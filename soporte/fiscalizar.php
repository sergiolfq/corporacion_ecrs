<?php  require_once("../includes/includes.php"); require_once("services/fiscalizar.back.php"); 

//error_reporting(-1);
//ho dirname(__FILE__); // incluirlas
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
        
        <!-- inicio parte nueva -->
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
        
        <!-- fin de parte nueva -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <link href="css/ecrs_estilos.css" rel="stylesheet" type="text/css" />       
        <link rel="stylesheet" href="controls/SlickGrid/slick.grid.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/controls/slick.pager.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/examples/enajenaciones.css" type="text/css"/>  
        <title>Fiscalizacion</title>
    </head>

    <body style="background: white;" onload="onLoad();">
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