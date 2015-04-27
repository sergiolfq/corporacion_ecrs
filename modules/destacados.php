<script language="javascript" type="text/javascript" src="includes/js/jquery-1.4.2.min.js"></script>
<script>
    //jQuery.noConflict();
    jQuery(document).ready(function() {
        jQuery('#mycarousel').jcarousel({
            vertical: true,
            scroll: 2
        });
        jQuery('#mycarousel2').jcarousel({
            vertical: true,
            scroll: 2
        });        
    });       
</script>
<script language="javascript" type="text/javascript" src="includes/js/jquery.jcarousel.min.js"></script>

<style type="text/css">

.jcarousel-skin-tango .jcarousel-container {
   
}

.jcarousel-skin-tango .jcarousel-direction-rtl {
    direction: rtl;
}



.jcarousel-skin-tango .jcarousel-container-vertical {
    width: 310px;
    height: 490px;
}

.jcarousel-skin-tango .jcarousel-clip {
    overflow: hidden;
}



.jcarousel-skin-tango .jcarousel-clip-vertical {
     width: 310px;
    height: 490px;
}

.jcarousel-skin-tango .jcarousel-item {
    width: 310px;
    height: 155px;
}

.jcarousel-skin-tango .jcarousel-item-vertical {
    margin-bottom: 10px;
}

.jcarousel-skin-tango .jcarousel-item-placeholder {
    background: #fff;
    color: #000;
}




/**
 *  Vertical Buttons
 */
.jcarousel-skin-tango .jcarousel-next-vertical {
    position: relative;
    left: 256px;
    width: 20px;
    height: 20px;
    top:0px;
    cursor: pointer;
    background: transparent url(images/new/btatras.jpg) no-repeat 0 0;
}

.jcarousel-skin-tango .jcarousel-next-vertical:hover,
.jcarousel-skin-tango .jcarousel-next-vertical:focus {
}

.jcarousel-skin-tango .jcarousel-next-vertical:active {
}

.jcarousel-skin-tango .jcarousel-next-disabled-vertical,
.jcarousel-skin-tango .jcarousel-next-disabled-vertical:hover,
.jcarousel-skin-tango .jcarousel-next-disabled-vertical:focus,
.jcarousel-skin-tango .jcarousel-next-disabled-vertical:active {
    cursor: default;
    background-position:-100px -100px
}

.jcarousel-skin-tango .jcarousel-prev-vertical {
    position: relative;
    left: 280px;
    top:20px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    background: transparent url(images/new/btalante.jpg) no-repeat 0 0;
    
}

.jcarousel-skin-tango .jcarousel-prev-vertical:hover,
.jcarousel-skin-tango .jcarousel-prev-vertical:focus {
}


.jcarousel-skin-tango .jcarousel-prev-vertical:active {
}

.jcarousel-skin-tango .jcarousel-prev-disabled-vertical,
.jcarousel-skin-tango .jcarousel-prev-disabled-vertical:hover,
.jcarousel-skin-tango .jcarousel-prev-disabled-vertical:focus,
.jcarousel-skin-tango .jcarousel-prev-disabled-vertical:active {
    cursor: default;
    background-position:-100px -100px
}
</style>

<!-- <link rel="stylesheet" type="text/css" href="includes/js/skins/tango/skin.css" /> -->


      <table width="980" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th valign="top" scope="col"><?= $Banners->showBanners(22);?></th>
        </tr>
      </table>
      <table width="984" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
        <tr>
          <th colspan="7" background="images/new/titulo.jpg" style="text-align: left" scope="col"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;Productos &gt;&gt; Destacados & Promociones</span></span></th>
          <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" />
        </tr>
      </table>
      <br />
      <table width="980" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="720" valign="top" scope="col" align="center">
          
          
        <table width="677" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 0px; margin-left: 0px;">
          <tr>
            <td width="300"><table width="228" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td><img src="modules/img/bannerarribader.jpg" width="300" height="40" style="margin-right: 4px;" /></td>
              </tr>
              </table></td>
            
            <td width="300"><table width="228" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td><img src="modules/img/bannerarribaizq.jpg" width="300" height="40" style="margin-right: 5px;" /></td>
              </tr>
              </table></td>
          </tr>
        </table>          
            <table width="677" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-left: 15px;">
            <tr>
            <td height="530" width="50%" background="modules/img/fondo.jpg">
          
          
          
          
          
          <div style=" width:100%; margin-left:20px; margin-top:20px; float:left;">
            <ul id="mycarousel" class="jcarousel jcarousel-skin-tango">
          
            <?php
            $vi = 0;
            $rs = $Shop->getProductosDestacadosByCategoria();
            foreach($rs as $k=>$v){
                for($a=0; $a<sizeof($v);$a=$a+1){
                ?>           
                <li>
                    <table width="228" border="0" cellspacing="0" cellpadding="0">
                        <?php if($vi != 0) { ?>
                        <tr>
                          <td width="9"></td>
                          <td width="286" height="4" colspan="4"><img src="images/new/piso.jpg" width="280" height="2" style="margin-left: 0px; margin-bottom: 10px;" /></td>
                        </tr>
                        <?php } ?>                    
                        <tr>
                          <td width="9"></td>
                          <td width="286" colspan="4" style="text-align: left;"><span class="titulo21" style="font-size:12px;"><?=$v[$a]["nombre" . $_SESSION["LOCALE"]]?></span></td>
                        </tr>
                        <tr>
                          <td colspan="5">
                          <table width="290" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
                            <tr>
                              <td width="48%" height="100" class="texto2"><a href="?module=product_detail&pkcat=<?=$_GET["i"]?>&pro=<?=md5( HASH . $v[$a]["pk_producto"])?><?=$v[$a]["pk_producto"]?>">  <img src="/images/products/foto_dest_<?=$v[$a]["pk_producto"]?>.jpg" alt="" width="120" align="left" border="0" />       </a></td>
                              <td width="48%" style="font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; font-size: 11px; color: #666; text-align: left; vertical-align: top;"><span id="result_box9" lang="es" xml:lang="es" style="font-weight: normal;"><?=$v[$a]["sumario" . $_SESSION["LOCALE"]]?></span></td>
                            </tr>
                          </table>
                          </td>
                        </tr>
                    </table>
                </li>
                <?php $vi++; } ?>
            <?php } ?>
            </ul>
          </div>
          


          
          
          
         </td>
         <td height="530" width="50%" background="modules/img/fondo.jpg">
         
         
         
         
         
         
         
         
         <div style=" width:100%; margin-left:20px; margin-top:20px; float:left;">
            <ul id="mycarousel2" class="jcarousel jcarousel-skin-tango">
          
            <?php
            $vi = 0;
            $rs = $Shop->getProductosPromocionadosByCategoria();
            foreach($rs as $k=>$v){
                for($a=0; $a<sizeof($v);$a=$a+1){
                ?>           
                <li>
                    <table width="228" border="0" cellspacing="0" cellpadding="0">
                        <?php if($vi != 0) { ?>
                        <tr>
                          <td width="9"></td>
                          <td width="286" height="4" colspan="4"><img src="images/new/piso.jpg" width="280" height="2" style="margin-left: 0px; margin-bottom: 10px;" /></td>
                        </tr>
                        <?php } ?>                    
                        <tr>
                          <td width="9"></td>
                          <td width="286" colspan="4" style="text-align: left;"><span class="titulo21" style="font-size:12px;"><?=$v[$a]["nombre" . $_SESSION["LOCALE"]]?></span></td>
                        </tr>
                        <tr>
                          <td colspan="5">
                          <table width="290" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
                            <tr>
                              <td width="48%" height="100" class="texto2"><a href="?module=product_detail&pkcat=<?=$_GET["i"]?>&pro=<?=md5( HASH . $v[$a]["pk_producto"])?><?=$v[$a]["pk_producto"]?>">  <img src="/images/products/foto_promo_<?=$v[$a]["pk_producto"]?>.jpg" alt="" width="120" align="left" border="0" />       </a></td>
                              <td width="48%" style="font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; font-size: 11px; color: #666; text-align: left; vertical-align: top;"><span id="result_box9" lang="es" xml:lang="es" style="font-weight: normal;"><?=$v[$a]["sumario" . $_SESSION["LOCALE"]]?></span></td>
                            </tr>
                          </table>
                          </td>
                        </tr>
                    </table>
                </li>
                <?php $vi++; } ?>
            <?php } ?>
            </ul>
          </div>
         
         
         
         
         
         
         
         
         </td>
         </tr>
         </table>
         <br /><br />
         
         


                                <br />     
                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                <td width="20"></td>
                                <td>
                                <table width="650" border="0" align="left" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><img src="images/spacer.gif" width="6" height="1" /></td>
                                        <td width="448" height="4"><img src="images/separacion.gif" width="650" height="2" /></td>
                                    </tr>                                         
                                </table>
                                <br />   
                                <table width="663" border="0" align="left" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="330"><a href="/?module=contacto"><img src="images/telesistemas.jpg" style="border: none" width="330" height="100" /></a></td>
                                        <td colspan="2" rowspan="3">&nbsp;</td>
                                        <td width="329"><a href="/?module=contacto"><img src="images/nmsuministro.jpg" style="border: none" width="330" height="100" /></a></td>
                                    </tr>
                                    <tr>
                                        <td><img src="images/spacer.gif" width="54" height="4" /><a href="/?module=contacto"><img src="images/resumacentro.jpg" style="border: none" width="330" height="100" /></a></td>
                                        <td><img src="images/spacer.gif" width="54" height="4" /><a href="/?module=contacto"><img src="images/roferca.jpg" style="border: none" width="330" height="100" /></a></td>
                                    </tr>
                                    <tr>
                                        <td height="2"></td>
                                        <td height="2"></td>
                                    </tr>
                                </table>                                     
                                <table width="650" border="0" align="left" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><img src="images/spacer.gif" width="6" height="29" /></td>
                                        <td width="448" height="4"><img src="images/separacion.gif" width="650" height="2" /></td>
                                    </tr>
                                </table>
                                </td>
                                </tr>
                                </table>
                                <p>&nbsp;</p>


         
         
         
          </th>
          <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
        </tr>
        <tr>
          <th scope="col">&nbsp;</th>
          <th align="center" valign="top" scope="col">&nbsp;</th>
        </tr>
      </table>
