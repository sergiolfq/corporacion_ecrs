<?php
//var_dump($_GET["module"]);
if(eregi('cart',$_GET["module"]) || eregi('account',$_GET["module"]) || eregi('registro',$_GET["module"])){
	$z =16;
}elseif($_GET["module"]=='nosotros'){
	$z =8;
}elseif($_GET["module"]=='destacados'){
	$z =23;
}elseif($_GET["module"]=='categoria'){
	$z =17;
	$y=intval($_GET["i"]);
	if($y==0){
		$z=23;	
	}
}elseif($_GET["module"]=='product_detail'){
	$z =18;
	$y=intval($_GET["pkcat"]);
}elseif(eregi('ingreso',$_GET["module"])){
    $z =19;
}elseif(eregi('soporte',$_GET["module"])){
	$z =19;
}elseif(eregi('enajenaciones',$_GET["module"])){
    $z =19;  
}elseif(eregi('destacados',$_GET["module"])){
	$z =28;
}elseif($_GET["module"]=='contacto'){
	$z =20;
}elseif(eregi('noticias',$_GET["module"]) || eregi('testimonios',$_GET["module"])){
	$z =21;
}elseif(eregi('accesorios',$_GET["module"])){
    $z =29;
}elseif(eregi('Cotizacion',$_GET["module"])){
    $z =30; 
}
?>
                <table width="219" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="col"><?= $Banners->showBanners($z,intval($y));?></th>
                  </tr>
              </table>

<table width="220" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th height="32" valign="top" scope="col">
                    <div class="barra3"><?=_("Noticias & Novedades")?></div>
                    </th>
                  </tr>
                  <tr>
                    <td valign="top" class="noticias_round_box">
                    <marquee  onmouseover="stop()" onmouseout="start()"  behavior="scroll" direction="up" scrollamount="2">

<?php
$rss = $Shop->getNoticia(array("fk_tipo"=>1,"fk_destacada"=>1,"orderby"=>"pk_noticia desc"),0,3);
foreach($rss["results"] as $key => $value){


?>
                    <p><a href="?module=noticias_detalle&t=<?=$value["fk_tipo"]?>&i=<?=$value["pk_noticia"]?>"><span class="noticiahome_titulares"><?=$value["titulo" . $_SESSION["LOCALE"]]?></span></a><br />
                        <span class="noticiahome_resumen"><?=$Shop->makeSumario($value["sumario" . $_SESSION["LOCALE"]],70)?>&hellip;</span><br />
                        <span class="noticiahome_fecha"><?=$Shop->month2letter(date("n",strtotime($value["fecha_noticia"])))?> <?=date("d, Y",strtotime($value["fecha_noticia"]))?></span></p>
                        
                        
 <?php
}
 ?>                       
</marquee>                        <br />
                        <br />
                        <a href="?module=noticias_home"><?=_("Ver todas")?>...</a>
                        
                        </td>
                  </tr>
                </table>
                <br />
                <table width="219" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th height="32" valign="top" scope="col"><div class="barra3"><?=_("Testimonios")?></div></th>
                  </tr>
                  <tr>
                    <td valign="top" class="noticias_round_box">
                     
                     <?php
                     $rss = $Shop->getTestimonio(array("fk_destacada"=>1,"orderby"=>"pk_testimonio desc"),0,5);
					 foreach($rss["results"] as $key => $value){
					 ?>
                    <table width="180" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th align="left" scope="col"><table width="160" border="0" align="right" cellpadding="0" cellspacing="0">
                          <tr>
                            <th class="testimoniofoto_peq" scope="col"><a href="?module=testimonios&i=<?=$value["pk_testimonio"]?>"><img src="images/testimonios/<?=$value["pk_testimonio"]?>_tb.jpg" alt="Testimonios" class="fotoborder" /></a></th>
                          </tr>
                        </table></th>
                      </tr>
                    </table>
                      <table width="180" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th align="left" scope="col">&nbsp;</th>
                        </tr>
                        <tr>
                          <th align="left" scope="col"><span class="testimonios_text"><?=$Shop->makeSumario($value["sumario" . $_SESSION["LOCALE"]],50)?> ...</span><br />
                            <span class="testimonios_nombre"><?=$value["titulo" . $_SESSION["LOCALE"]]?></span></th>
                        </tr>
                      </table>
                      <?php } ?><br />
                        <a href="?module=testimonios"><?=_("Ver todos")?>...</a></td>
                  </tr>
                </table>
                <br />

<table width="219" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">
    <div class="conectese"><?=_("Conéctese")?></div></th>
  </tr>
  <tr>
    <th scope="col">
    <img src="images/spacer.gif" width="4" height="10" />
    </th>
  </tr>
</table>             
<table width="219" border="0" cellspacing="0" cellpadding="0">  
  <tr>    
    <td align="center"><a href="https://www.facebook.com/pages/Corporacion-ECRS-CA/150266835098197" target="_blank"><img src="images/iconos/conecta_facebook.png" alt="Haga Me gusta en Facebook" border="0" /></a></td>
  </tr>
</table><br />
<table width="219" border="0" cellspacing="0" cellpadding="0">
  <tr>    
    <td align="center"><a href="https://twitter.com/corp_ecrs" target="_blank"><img src="images/iconos/conecta_twitter.png" alt="S&iacute;ganos en Twitter" border="0" /></a></td>
  </tr>
</table>