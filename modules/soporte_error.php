<br>
<br>
<?php if(!isset($_SESSION["user"])){ ?>
<h2 style="text-align:center"><?=_("Lo sentimos, usted no tiene permisos para ingresar a esta sección")?></h2>
<div style="text-align:center"><?=_("Para ingresar, debe identificarse haciendo click en el siguiente link:")?> <a href="/?module=ingreso&fromurl=<?=urlencode("?module=soporte")?>"><?=_("Login")?></a> </div>
<?php }else{ ?>
<h2 style="text-align:center"><?=_("Lo sentimos, usted no tiene permisos para ingresar a esta sección")?></h2>
<div style="text-align:center"><?=_("Esta sección es sólo para Técnicos autorizados y distribuidores, si usted es uno de ellos por favor escríbanos a:")?> <a href="mailto:soporte@ecrs.com.ve">soporte@ecrs.com.ve</a> <?=_("para solicitar acceso.")?></div>
<?php } ?>