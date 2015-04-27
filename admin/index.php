<?php

require_once("../includes/includes.php");
$Common = new Common;
$Admin = new Admin;
$Shop = new Shop;
$H = new Helper;
if(isset($_GET["logout"])){
	unset($_SESSION["administrator"]);
}
if(isset($_POST["cc1"])){
	$Admin->loginAdmin($_POST);
}

if(intval($_GET["fk_descarga_cli"])==1){
	$rs = $Shop->busquedaUsuario($_GET,999999,0);
	
	$Shop->exportCVS($rs,array(
						"PK"=>"pk_usuario",
						"Fecha"=>"fecha_agregado",
						"Email"=>"email",
						"Tipo"=>"tipo",
						"Persona"=>"tipo_persona_txt",
						"Cedula/RIF"=>"cedula_rif",
						"Nombres"=>"nombres",
						"Apellidos"=>"apellidos",
						"Telefono 1"=>"telefono1",
						"Telefono 2"=>"telefono2",
						"Fax"=>"fax",
						"Ultima visita"=>"fecha_lastlogin",
						"Direccion"=>"direccion",
						"Pais"=>"pais",
						"Estado"=>"estado",
						"Ciudad"=>"ciudad",
						));
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<script language="javascript" type="text/javascript" src="/includes/js/scriptaculous/prototype.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/scriptaculous/scriptaculous.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/validation.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/jscalendar/calendar.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/jscalendar/lang/calendar-es.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/jscalendar/calendar-setup.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/colorpicker/yahoo.color.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/colorpicker/colorPicker.js"></script>
<link rel="stylesheet" type="text/css" href="/includes/js/colorpicker/colorPicker.css">

<?php 
//Check user's Browser
if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE"))
	echo "<script language=JavaScript src='/includes/editor/scripts/editor.js'></script>";
else
	echo "<script language=JavaScript src='/includes/editor/scripts/moz/editor.js'></script>";
?>
<script language="javascript" type="text/javascript" src='/includes/editor/scripts/language/spanish/editor_lang.js'></script>
<script language="javascript" type="text/javascript">
function mantenerSession () {
  new Ajax.Request('/admin/ajax_resp/mantain_session.php',{method:'post',parameters: ''})
}
new PeriodicalExecuter(mantenerSession, 300);
</script>
<link href="/includes/css/styles_admin.css" rel="stylesheet" type="text/css" />
<link href="/includes/css/validation.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="/includes/js/jscalendar/calendar-win2k-cold-1.css" title="win2k-cold-1">
</head>

<body>
<?php //error_reporting(-1); ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1"><img src="/images/admin/adm-01.gif" width="19" alt="" /></td>
    <td width="1"><a href="http://www.isometrico.com/"><img src="/images/admin/adm-02.gif" alt="" width="186" border="0" /></a></td>
    <td  align="right" background="/images/admin/adm-03.gif" class="txt1"><?php echo $_SERVER['SERVER_NAME'] ?> <?php if($Admin->isAdmin()){?>| <a href="?logout=1">Salir</a><?php } ?></td>
    <td width="1"><img src="/images/admin/adm-04.gif" width="18" alt="" /></td>
  </tr>
  <tr>
    <td  background="/images/admin/adm-05.gif"></td>
    <td colspan="2" valign="top"><br />
        <table width="98%" height="100%" border="0" align="center">
        
          <tr>
            <td><?php //if($Admin->isAdmin()){?>
            <div align="center"><a href="?module=administradores" class="mnu1">Administradores</a> | <a href="?module=fabricantes" class="mnu1">Fabricantes</a> | <a href="?module=categorias" class="mnu1">Categor&iacute;as productos</a> | <a href="?module=soporte_categorias" class="mnu1">Categor&iacute;as soporte</a>  | <a href="?module=mass_products" class="mnu1">Carga masiva productos</a> | <a href="?module=productos" class="mnu1">Productos</a> |  <a href="?module=soporte_descargas" class="mnu1">Soporte descargas</a> | <a href="?module=noticias" class="mnu1">Noticias</a>   | <a href="?module=testimonios" class="mnu1">Testimonios</a><br />
              <a href="?module=banners_zonas" class="mnu1">Zonas Banners</a> | <a href="?module=banners" class="mnu1">Banners</a>  |   <a href="?module=usuarios" class="mnu1">Usuarios</a> |    <a href="?module=orders" class="mnu1">Pedidos</a> |    <a href="?module=textos" class="mnu1">Textos</a> </div>
            <?php //} ?></td>
          </tr> 
       
          <tr>
            <td><?php require("./modules/" . $GLOBALS["modulo"] . ".php")?>
            </td>
          </tr> 
        </table>
      <br />
    </td>
    <td  background="/images/admin/adm-06.gif"></td>
  </tr>
  <tr>
    <td><img src="/images/admin/adm-07.gif" width="19" alt="" /></td>
    <td><img src="/images/admin/adm-08.gif" width="186" alt="" /></td>
    <td align="right" background="/images/admin/adm-09.gif" ></td>
    <td><img src="/images/admin/adm-10.gif" width="18" alt="" /></td>
  </tr>
</table>
</body>
</html>
