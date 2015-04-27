<?php
if(isset($_GET["buscar"])){
    $productos= $Shop->searchProducto($_GET["buscar"],"relevancia desc",0,999);
    $rscch2["results"]  = array('');
}else{
    //$rscch = $Shop->getCategoria(array("pk_categoria"=>intval($_GET["k"])));
    //$rscch2 = $Shop->getCategoria(array("fk_categoria_padre"=>intval($_GET["i"])));
    $rscch = $Shop->getCategoria(array("fk_categoria_padre"=>intval($_GET["i"])));
    $rscch2 = $Shop->getCategoria(array("pk_categoria"=>intval($_GET["k"])));
    $jj = intval($_GET["j"]);
}
?>
<style type="text/css">
td modules/img {display: block;}.texto11 {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 11px;
    color: #666;
    text-align: justify;
}
.titulo1 {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-weight: bold;
    color: #333;
}
.titulo21 {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    color: #a30327;
    font-weight: bold;
}
.Mapa {font-size: 24px;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: normal;
}
.texto2 {font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
    color: #666;
    text-align: left;
    vertical-align: top;
}
</style>
<script type="text/javascript">
function shtb(id,t,n){
    //alert("shtb: " + document.getElementById('trng').value);   
    
    $$('.tabGen'+t).each(function(element) {
          element.className='tab' + n + 'prods tabGen'+t;          
     });
    $$('div.tabcontenido'+t).each(function(element) {
         element.style.display='none'
     }); 
     Effect.toggle('ctb'+id + t,'BLIND') 
     $('lnk'+id+t).className='tab' + n + 'prodssel tabGen'+t;
}

function redireccionar(value,id)
{
    //alert("redireccionar: " + document.getElementById('trng').value);   
    document.location="/?module=accesorios&i=25&k="+value+"&j="+id;
}

</script>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<input type="hidden" name="trng" id="trng" value="<?= $jj ?>" />
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(10,5);?></th>  <!-- $Banners->showBanners(10,intval($_GET["i"])); -->
              </tr>
          </table>
            <table width="984" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
              <tr>
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Productos")?> &gt;&gt; <?php if(isset($_GET["buscar"])){ echo _("Búsqueda"); }else{ echo $rscch2["results"][0]["categoria" .$_SESSION["LOCALE"]]; }?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>
            </tr>            
        </table>
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col"><table width="676" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <th scope="col">
                   
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th style="text-align: left;" align="left" valign="top" scope="col">
                           <?php if(!isset($_GET["buscar"])){ ?>
                          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <th scope="col"><p class="productodeta_text"><?=$rscch2["results"][0]["texto" .$_SESSION["LOCALE"]]?>
                                </p></th>
                            </tr>
                          </table>
                          
                          
                          
      <table width="680" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th align="left" valign="bottom" class="barra_productos" scope="col">
          <table  border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:20px;">
            <tr>
              <th scope="col" align="left">
              <a href="JavaScript:void(shtb(1,'b',2))" <?php if($jj == 1) { ?> class="tab2prodssel tabGenb" <?php } else { ?> class="tab2prods tabGenb" <?php } ?> id="lnk1b" onclick="javascript:redireccionar(30,1)"><div style="margin-right:30px; margin-left: 15px;"><?=_("Q-Dispositivos")?></div></a>
              </th>
              <th  scope="col" align="left">
              <a href="JavaScript:void(shtb(2,'b',2))" <?php if($jj == 2) { ?> class="tab2prodssel tabGenb" <?php } else { ?> class="tab2prods tabGenb" <?php } ?> id="lnk2b" onclick="javascript:redireccionar(26,2)"><div style="margin-right:30px"><?=_("Visores")?></div></a>
              </th>
              <th  scope="col" align="left">
              <a href="JavaScript:void(shtb(3,'b',2))" <?php if($jj == 3) { ?> class="tab2prodssel tabGenb" <?php } else { ?> class="tab2prods tabGenb" <?php } ?> id="lnk3b" onclick="javascript:redireccionar(27,3)"><div style="margin-right:30px"><?=_("Scanners")?></div></a>
              </th>
              <th scope="col" align="left">
              <a href="JavaScript:void(shtb(4,'b',2))" <?php if($jj == 4) { ?> class="tab2prodssel tabGenb" <?php } else { ?> class="tab2prods tabGenb" <?php } ?> id="lnk4b" onclick="javascript:redireccionar(28,4)"><div style="margin-right:30px"><?=_("Balanzas")?></div></a>
              </th>
              <th  scope="col" align="left">
              <a href="JavaScript:void(shtb(5,'b',2))" <?php if($jj == 5) { ?> class="tab2prodssel tabGenb" <?php } else { ?> class="tab2prods tabGenb" <?php } ?> id="lnk5b" onclick="javascript:redireccionar(29,5)"><div style="margin-right:30px"><?=_("Impresoras")?></div></a>
              </th>
              <th align="left" scope="col">
              <a href="JavaScript:void(shtb(6,'b',2))" <?php if($jj == 6) { ?> class="tab2prodssel tabGenb" <?php } else { ?> class="tab2prods tabGenb" <?php } ?> id="lnk6b" onclick="javascript:redireccionar(25,6)"><div ><?=_("Accesorios")?></div></a>
              </th>              
            </tr>
          </table>
          </th>
        </tr>
      </table>                            
                              
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">              
              <tr>
                <td>
                <div id="ctb1b" class="tabcontenidob" style="display:none;" ><?=$value["Accesorios" . $_SESSION["LOCALE"]]?></div>
                <div id="ctb2b" class="tabcontenidob" style="display:none;" ><?=$value["Q-Dispositivos" . $_SESSION["LOCALE"]]?></div>    
                <div id="ctb3b" class="tabcontenidob" style="display:none;" ><?=$value["Visores" . $_SESSION["LOCALE"]]?></div>
                <div id="ctb4b" class="tabcontenidob" style="display:none;" ><?=$value["Scanners" . $_SESSION["LOCALE"]]?></div>                          
                <div id="ctb5b" class="tabcontenidob" style="display:none;" ><?=$value["Balanzas" . $_SESSION["LOCALE"]]?></div>
                <div id="ctb6b" class="tabcontenidob" style="display:none;" ><?=$value["Impresoras" . $_SESSION["LOCALE"]]?></div>
                </td>
              </tr>
            </table>                      
                          
                          
                          
                          <br />
                          <?php } ?>
                          <?php foreach($rscch2["results"] as $k=>$v ){ ?>


                            <table width="662" border="0" align="center" cellpadding="4" cellspacing="0">
                            <tr>
                            <th  scope="col">
                                                    
                            <?php     
                            if(trim($_GET["buscar"])==''){
                                 $params = array(
                                 TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_categoria" => $v["pk_categoria"],                                 
                                 TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_estatus" => 1,
                                 TBL_PRODUCTOS . ".fk_estatus" => 1
                                );
                                $productos=$Shop->getProducto($params,0,99); 
                            }
                             
                            //echo sizeof($productos["results"]);
                            
                            if(sizeof($productos["results"])>0)
                                for($a=0; $a<sizeof($productos["results"]);$a=$a+1){                            
                            ?>                            
                            
                            

                                        
                      
                            
   <div style="float:left; margin-bottom:20px; margin-right: 10px; margin-left: 10px;">
  <table width="680" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="1"><img src="images/new/tau_tl.png" width="11" height="36" /></td>
    <td background="images/new/tauf_top.png" style="text-align:left;"><span class="titulo21"><?=$productos["results"][$a]["nombre" . $_SESSION["LOCALE"]]?></span></td>
    <td width="1"><img src="images/new/tauf_tr.png" width="11" height="36" /></td>
  </tr>
  <tr>
    <td background="images/new/tauf_left.png">&nbsp;</td>
    <td>    
    <table>
    <tr>
    <td align="left" valign="top">   
     
    <?php if(isset($productos["results"][$a])){ ?>   
    <!-- <a href="?module=product_detail&pkcat=<?=$_GET["i"]?>&pro=<?=md5( HASH . $productos["results"][$a]["pk_producto"])?><?=$productos["results"][$a]["pk_producto"]?>">
    <img src="/images/products/tb2_<?=$productos["results"][$a]["pk_producto"]?>.jpg" alt="" width="128" height="93" align="right" border="0" style="margin-left:8px" /></a> -->
    <img src="/images/products/tb2_<?=$productos["results"][$a]["pk_producto"]?>.jpg" alt="" width="128" height="93" align="right" border="0" style="margin-left:8px" />
    <?php } ?>
    
    </td>
    <td align="right" valign="top">  
      
    <div style="float:left; font-weight:normal; font-size:11px"> 
    <p style="margin-top:10px; text-align: left;"><?=$productos["results"][$a]["sumario" . $_SESSION["LOCALE"]]?></p>
    </div>
    
    </td>
    </tr>
    </table>        
    </td>
    <td background="images/new/tauf_right.png">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="images/new/tauf_bl.png" width="11" height="10" /></td>
    <td background="images/new/tauf_bot.png"></td>
    <td><img src="images/new/tauf_br.png" width="11" height="10" /></td>
  </tr>
</table>
 </div>
 

                            
                            
                            
                            
                            
                              
                                <?php } ?>   
                                </th>
                              </tr>
                            </table>
                            <?php } ?>
                           </th>
                        </tr>
                      </table></th>
                  </tr>
                </table>
                
                  </th>
                 
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>
          <script type="text/javascript">
swfobject.registerObject("FlashID");
</script>