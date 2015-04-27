<?php

//error_reporting(-1);

if(isset($_GET["buscar"])){
    $productos= $Shop->searchProducto($_GET["buscar"],"relevancia desc",0,999);
    $rscch2["results"]  = array('');
}else{
    $rscch = $Shop->getCategoria(array("pk_categoria"=>intval($_GET["i"])));
    $rscch2 = $Shop->getCategoria(array("fk_categoria_padre"=>intval($_GET["i"])));
}
?>
<style type="text/css">
td modules img {display: block;}.texto11 {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
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
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(10,intval($_GET["i"]));?></th>
              </tr>
          </table>
            <table width="983" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
              <tr>
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Productos")?> &gt;&gt; <?php if(isset($_GET["buscar"])){ echo _("Búsqueda"); }else{ echo $rscch["results"][0]["categoria" .$_SESSION["LOCALE"]]; }?></span></span></th>
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
                              <th scope="col"><p class="productodeta_text"><?=$rscch["results"][0]["texto" .$_SESSION["LOCALE"]]?>
                                </p></th>
                            </tr>
                          </table>
                          <?php } ?>
                          <?php foreach($rscch2["results"] as $k=>$v ){ ?>
                            <?php if(!isset($_GET["buscar"])){ ?>
                            <br />
                            
                            <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <th align="left" scope="col" style="text-align:justify"><span class="trebuchet_gris15"><strong><?=$v["categoria"]?></strong></span><br />
                                 <?=$v["texto"]?></th>
                              </tr>
                            </table>
                            <br />
                            <?php } ?>
                            
                            <?php if(isset($_GET["buscar"]) && sizeof($productos["results"])==0){ ?>
                            
                            <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <th align="left" scope="col" align="center" class="producto_tituhome">Su búsqueda no arrojó resultados</th>
                              </tr>
                            </table>
                            <br />
                            <?php } ?>
                            
                            <table width="662" border="0" align="center" cellpadding="10" cellspacing="0">
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
                                for($a=0; $a<sizeof($productos["results"]);$a=$a+2){                            
                            ?>                            
                                                              
                            

                                        
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"valign="top" style="border:0px solid #e9e9e9;  <?php if(isset($productos["results"][$a-2])){ ?> border-top:0px; <?php } ?>">                            
                            
   <div style="float:left; margin-bottom:10px; margin-right: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
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
    <td valign="top">    
    <div style="float:left; font-weight:normal; font-size:11px"> 
    <p style="margin-top:10px; text-align: left;"><?=$productos["results"][$a]["sumario" . $_SESSION["LOCALE"]]?></p>
    </div>
    </td>
    <td align="right" valign="top">    
    <?php if(isset($productos["results"][$a])){ ?>   
    <a href="?module=product_detail&pkcat=<?=$_GET["i"]?>&pro=<?=md5( HASH . $productos["results"][$a]["pk_producto"])?><?=$productos["results"][$a]["pk_producto"]?>">
    <img src="/images/products/tb2_<?=$productos["results"][$a]["pk_producto"]?>.jpg" alt="" width="128" height="93" align="right" border="0" style="margin-left:8px" /></a>
    <?php } ?>
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
 
</td>           
<td width="50%" valign="top" style="border:0px solid #e9e9e9; border-left:0px; <?php if(!isset($productos["results"][$a+1])){ ?> border:0px; visibility: hidden; <?php } ?><?php if(isset($productos["results"][$a-2])){ ?> border-top:0px; <?php } ?> ">                                     

    <div style="float:left; margin-bottom:10px; margin-right: 10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="1"><img src="images/new/tau_tl.png" width="11" height="36" /></td>
    <td background="images/new/tauf_top.png" style="text-align:left;"><span class="titulo21"><?=$productos["results"][$a+1]["nombre" . $_SESSION["LOCALE"]]?></span></td>
    <td width="1"><img src="images/new/tauf_tr.png" width="11" height="36" /></td>
  </tr>
  <tr>
    <td background="images/new/tauf_left.png">&nbsp;</td>
    <td>
    <table>
    <tr>
    <td valign="top">
    <div style="float:left; font-weight:normal; font-size:11px">     
    <p style="margin-top:10px; text-align: left;"><?=$productos["results"][$a+1]["sumario" . $_SESSION["LOCALE"]]?></p>
    </div> 
    </td>
    <td align="right" valign="top">
    <?php if(isset($productos["results"][$a+1])){ ?>
    <a href="?module=product_detail&pkcat=<?=$_GET["i"]?>&pro=<?=md5( HASH . $productos["results"][$a+1]["pk_producto"])?><?=$productos["results"][$a+1]["pk_producto"]?>">
    <img src="/images/products/tb2_<?=$productos["results"][$a+1]["pk_producto"]?>.jpg" alt="" width="128" height="93" align="right" border="0" style="margin-left:8px;"/></a>                
    <?php } ?>
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
    </td>
  </tr>                                 
</table>  
                            
                            
                            
                            
                            
                              
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