<?php
if(isset($_GET["pro"])){ //lo esta agregando via link
	$pk_pro = intval(substr($_GET["pro"],32,strlen($_GET["pro"])));
	if(md5(HASH . $pk_pro) == substr($_GET["pro"],0,32)){
		$rs = $Shop->getProducto(array("pk_producto" => intval($pk_pro)));
		$rsRelacionados = $Shop->getProductoRelacionado($pk_pro);
		$value =$rs["results"][0];    
        //var_dump($value);
		$picW = 290;
		$picH=185;
		$picN=0;
		for($a=1;$a<=3;$a++){ 
			if(file_exists(SERVER_ROOT . "images/products/pic_" . $a . "_" . $value["pk_producto"] . ".jpg")){
				$picN++;
			}
		}
	}else{
		die("Ocurrio un error:  #03294235");
	}
}	
?>
<script language="javascript" type="text/javascript" src="/includes/js/jqzoom/js/jquery-1.6.js"></script>
<script language="javascript" type="text/javascript" src="/includes/js/jqzoom/js/jquery.jqzoom-core.js"></script>
<script>
function add2cart(){
	loc = '?module=cart&ctr=<?=md5( HASH . $value["pk_producto"])?><?=$value["pk_producto"]?>' ;
	<?php
	foreach($variantes["results"] as $kv => $vv){
		$variantesproducto = $Shop->getVariantesTipoByProducto(array("fk_producto"=>$value["pk_producto"],"fk_variante"=>$vv["pk_variante"]));	
		if(sizeof($variantesproducto["results"])>0){
	?>
	loc += '&v[]=' + $F('variantes_<?=$vv["pk_variante"]?>');
	<?php 
		}
	}  
	?>
	document.location = loc
}
</script>
<link rel="stylesheet" href="/includes/js/jqzoom/css/jquery.jqzoom.css" type="text/css">
<script>
$.noConflict();

jQuery(document).ready(function($) {
	$('.jqzoom').jqzoom({
			zoomType: 'reverse',
			lens:true,
			preloadImages: false,
			alwaysOn:false
		});
});

</script>


<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th valign="top" class="container" scope="col">
      <table width="980" border="0" cellspacing="0" cellpadding="0">
        <tr><td>                       
        <?php if(file_exists(SERVER_ROOT . "images/products/ban" . $_SESSION["LOCALE"] . "_" . $value["pk_producto"] . ".jpg")) { ?>
          <img src="/images/products/ban<?=$_SESSION["LOCALE"]?>_<?=$value["pk_producto"]?>.jpg" border="0" />
        <?php } ?>        
        </td></tr>
      </table>      
      <table width="982" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
        <tr>
          <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=$value["nombre" . $_SESSION["LOCALE"]]?></span></span></th>
          <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>
        </tr>
      </table>
      <br />
      <table width="888" border="0" align="center" cellpadding="0" cellspacing="0"> 
        <tr> 
          <th width="455" align="center" valign="top" scope="col">
          <a href="/images/products/pic_1_<?=$value["pk_producto"]?>big.jpg" class="jqzoom" rel='gal1'  title="<?=_("Detalle")?>" >
          <img src="/images/products/pic_1_<?=$value["pk_producto"]?>big.jpg" width="455" height="390" alt="producto" border="0" />
          </a>
          </th>
          <th width="38" scope="col">&nbsp;</th>
          <th width="395" scope="col" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="productodeta_boxgris">
            <tr>
              <th height="33" align="center" valign="bottom" scope="col"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th width="30%" height="22" align="center" class="productodeta_redtext" scope="col">
                
                  <a href="JavaScript:void(shtb(1,'t',1))" class="tab1prodssel tabGent" id="lnk1t"><div><?=_("General")?></div></a>
                  
                  </th>
                  <th width="30%" height="22" align="center" class="productodeta_redtext" scope="col">
                  	<a href="JavaScript:void(shtb(2,'t',1))" class="tab1prods tabGent" id="lnk2t"><div><?=_("Valor")?></div></a>
                  </th>
                  <th width="30%" height="22" align="center" class="productodeta_redtext" scope="col">
                  	<a href="JavaScript:void(shtb(3,'t',1))" class="tab1prods tabGent" id="lnk3t"><div><?=_("Referencias")?></div></a>
                  </th>
                </tr>
              </table></th>
            </tr>
          </table>
            <br />
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
              
              <tr>
                <td align="left" class="productodeta_text" valign="top">
                <div id="ctb1t" class="tabcontenidot"><?=$value["general" . $_SESSION["LOCALE"]]?></div>
           		<div id="ctb2t" class="tabcontenidot" style="display:none;"><?=$value["valor" . $_SESSION["LOCALE"]]?></div>
                <div id="ctb3t" class="tabcontenidot" style="display:none;"><?=$value["referencias" . $_SESSION["LOCALE"]]?></div>
                
         <script>
        function shtb(id,t,n){
			$$('.tabGen'+t).each(function(element) {
				  element.className='tab' + n + 'prods tabGen'+t;
				  
			 });
			$$('div.tabcontenido'+t).each(function(element) {
				 element.style.display='none'
			 }); 
			 Effect.toggle('ctb'+id + t,'BLIND') 
			 $('lnk'+id+t).className='tab' + n + 'prodssel tabGen'+t;
		}
        </script>
                
                </td>
              </tr>
              <tr>
                <td height="43" align="left" valign="bottom">
                
                <input type="submit" name="button" id="button" value="<?=_("Solicitar cotización")?>" class="botoncot"  onclick="add2cart()" />
                </td>
              </tr>
            </table></th>
        </tr>
      </table><br /><br />
      <table width="890" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th align="left" valign="bottom" class="barra_productos" scope="col">
          <table  border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:20px;">
            <tr>
              <th align="left" scope="col">
              <a href="JavaScript:void(shtb(1,'b',2))" class="tab2prodssel tabGenb" id="lnk1b"><div style=" margin-right:30px"><?=_("Especificaciones")?></div></a>
              </th>
              <?php if($value["fk_categoria"] != 5) { ?>
              <th  scope="col" align="left">
              <a href="JavaScript:void(shtb(2,'b',2))" class="tab2prods tabGenb" id="lnk2b"><div style=" margin-right:30px"><?=_("Características")?></div></a>
              </th>
              <?php } ?>
              <th  scope="col" align="left">
              <a href="JavaScript:void(shtb(3,'b',2))" class="tab2prods tabGenb" id="lnk3b"><div style=" margin-right:30px"><?=_("Accesorios")?></div></a>
              </th>
              <th scope="col" align="left">
              <a href="JavaScript:void(shtb(4,'b',2))" class="tab2prods tabGenb" id="lnk4b"><div><?=_("Descargas")?></div></a>
              </th>
            </tr>
          </table></th>
        </tr>
      </table>
      <br />
      <table width="890" border="0" align="center" cellpadding="0" cellspacing="0" id="contenido_detalle_b">
        
        <tr><td style="text-align:left">
        <div id="ctb1b" class="tabcontenidob"><?=$value["especificaciones" . $_SESSION["LOCALE"]]?></div>
        <div id="ctb2b" class="tabcontenidob" style="display:none;"><?=$value["caracteristicas" . $_SESSION["LOCALE"]]?></div>
        <div id="ctb3b" class="tabcontenidob" style="display:none;">
		<?=$value["accesorios" . $_SESSION["LOCALE"]]?>
        <div>
        <?php
        for($a=0; $a<=sizeof($rsRelacionados["results"]);$a=$a+2){
									
							?>
                            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <th width="45%" align="left" scope="col">
                                <?php if(isset($rsRelacionados["results"][$a])){ 
                                    //var_dump($rsRelacionados["results"][$a]);
                                    //if(intval($rsRelacionados["results"][$a]["fk_categoria"]) < 25 or intval($rsRelacionados["results"][$a]["fk_categoria"]) > 30) {
                                    if(false){
                                    ?>
                                    <a href="?module=product_detail&pkcat=<?=$_GET["i"]?>&pro=<?=md5( HASH . $rsRelacionados["results"][$a]["pk_producto"])?><?=$rsRelacionados["results"][$a]["pk_producto"]?>"><img src="/images/products/tb2_<?=$rsRelacionados["results"][$a]["pk_producto"]?>.jpg" alt="" width="120" align="left" border="0" /></a>
                                <?php } else { ?>
                                    <img src="/images/products/tb2_<?=$rsRelacionados["results"][$a]["pk_producto"]?>.jpg" alt="" width="120" align="left" border="0" />
                                <?php }} ?>
                                </th>
                                <th width="10%" scope="col">&nbsp;</th>
                                <th width="45%" align="left" scope="col">
                                <?php if(isset($rsRelacionados["results"][$a+1])){ 
                                    //if(intval($rsRelacionados["results"][$a]["fk_categoria"]) < 25 or intval($rsRelacionados["results"][$a]["fk_categoria"]) > 30) {
                                    if(false){
                                    ?>
                                    <a href="?module=product_detail&pkcat=<?=$_GET["i"]?>&pro=<?=md5( HASH . $rsRelacionados["results"][$a+1]["pk_producto"])?><?=$rsRelacionados["results"][$a+1]["pk_producto"]?>"><img src="/images/products/tb2_<?=$rsRelacionados["results"][$a+1]["pk_producto"]?>.jpg" alt="" width="120" align="left" border="0" /></a>
                                <?php } else { ?>
                                    <img src="/images/products/tb2_<?=$rsRelacionados["results"][$a+1]["pk_producto"]?>.jpg" alt="" width="120" align="left" border="0" /> 
                                <?php }} ?>
                                </th>
                              </tr>
                              <tr>
                                <th height="22" align="left" class="productos_titulosred" scope="col"><?=$rsRelacionados["results"][$a]["nombre" . $_SESSION["LOCALE"]]?></th>
                                <th align="left" scope="col">&nbsp;</th>
                                <th align="left" scope="col"><span class="productos_titulosred"><?=$rsRelacionados["results"][$a+1]["nombre" . $_SESSION["LOCALE"]]?></span></th>
                              </tr>
                              <tr>
                                <th align="left" class="productos_sumariohome" scope="col"><?=$rsRelacionados["results"][$a]["sumario" . $_SESSION["LOCALE"]]?></th>
                                <th align="left" scope="col">&nbsp;</th>
                                <th align="left" class="productos_sumariohome" scope="col"><?=$rsRelacionados["results"][$a+1]["sumario" . $_SESSION["LOCALE"]]?></th>
                              </tr>
                            </table>
                    
        
        <?php } ?>
        </div>
        </div>
        <div id="ctb4b" class="tabcontenidob" style="display:none;">
<!--comienza descargas -->        	
<?php 
$pk_producto =$value["pk_producto"];
require("soporte_detalle.php");
?>
	
	
	
	
            
<!--termina descargas -->        

        </div>
        
        </td></tr>
      </table>
      <p>&nbsp;</p>
      <p><br />
      </p></th>
  </tr>
</table>
