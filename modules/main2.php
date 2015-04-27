



<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="middle" class="fondoanima" scope="col"><table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <th height="385" bgcolor="#FFFFFF" scope="col" align="left">
                    <?php require("top_banner.php") ?></th>
                  </tr>
                </table></th>
              </tr>
          </table>
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="327" height="345" scope="col"><table width="290" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_shadow">
                  <tr>
                    <th height="290" valign="top" scope="col"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th height="50" align="left" valign="middle" scope="col">
                        
                        <?php
                        $Textos = new Textos;
            $rs = $Textos->getTexto(array("pk_texto" => 8));
            ?>
                        <span class="eras rojo20"><?=$rs["results"][0]["titulo" . $_SESSION["LOCALE"]]?></span></th>
                      </tr>
                      
                      <tr>
                        <th align="left" scope="col"><?=$rs["results"][0]["texto" . $_SESSION["LOCALE"]]?></th>
                      </tr>
                    </table></th>
                  </tr>
                </table></th>
                <th width="326" scope="col"><table width="290" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_shadow">
                  <tr>
                    <th height="290" valign="top" scope="col"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th height="50" align="left" valign="middle" scope="col">
                        <?php
                        $rs = $Banners->getBannerbyZonas(15);
            ?>
                        <span class="eras rojo20"><?=_("Producto Destacado")?></span></th>
                      </tr>
                      <tr>
                        <th align="left" valign="top" scope="col" style="text-align:justify">
            <center><?= $Banners->showBanners(15);?></center><br />
                        <?=nl2br($rs["results"][0]["texto" . $_SESSION["LOCALE"]])?>
                        </th>
                      </tr>
                      
                    </table></th>
                  </tr>
                </table></th>
                <th width="326" scope="col"><table width="290" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_shadow">
                  <tr>
                    <th height="290" valign="top" scope="col"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th height="50" align="left" valign="middle" scope="col"><span class="eras rojo20"><?=_("Noticias & Novedades")?></span></th>
                      </tr>
                      <tr>
                        <th align="left" valign="top" scope="col">
                         <marquee  onmouseover="stop()" onmouseout="start()"  behavior="scroll" direction="up" scrollamount="2" style="margin-bottom:10px;">

<?php
$rss = $Shop->getNoticia(array("fk_tipo"=>1,"fk_destacada"=>1,"orderby"=>"pk_noticia desc"),$_GET["page"],3);
foreach($rss["results"] as $key => $value){


?>
                    <p><a href="?module=noticias_detalle&t=<?=$value["fk_tipo"]?>&i=<?=$value["pk_noticia"]?>"><span class="noticiahome_titulares"><?=$value["titulo" . $_SESSION["LOCALE"]]?></span></a><br />
                        <span class="noticiahome_resumen"><?=$Shop->makeSumario($value["sumario" . $_SESSION["LOCALE"]],70)?>&hellip;</span><br />
                        <span class="noticiahome_fecha"><?=$Shop->month2letter(date("n",strtotime($value["fecha_agregado"])))?> <?=date("d, Y",strtotime($value["fecha_agregado"]))?></span></p>
                        
                        
 <?php
}
 ?>                       
</marquee>                        
                        <br />
                        <a href="?module=noticias_home"><?=_("Ver todas")?> &raquo;</a>
                        </th>
                      </tr>
                      <tr>
                        <th height="15" align="left" valign="bottom" scope="col"></th>
                      </tr>
                    </table></th>
                  </tr>
                </table></th>
              </tr>
          </table>




          























<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="middle" class="fondoanima" scope="col"><table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <th height="385" bgcolor="#FFFFFF" scope="col" align="left">
                    <?php require("top_banner.php") ?></th>
                  </tr>
                </table></th>
              </tr>
          </table>
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="327" height="345" scope="col"><table width="290" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_shadow">
                  <tr>
                    <th height="290" valign="top" scope="col"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th height="50" align="left" valign="middle" scope="col">
                        
                        <?php
                        $Textos = new Textos;
            $rs = $Textos->getTexto(array("pk_texto" => 8));
            ?>
                        <span class="eras rojo20"><?=$rs["results"][0]["titulo" . $_SESSION["LOCALE"]]?></span></th>
                      </tr>
                      
                      <tr>
                        <th align="left" scope="col"><?=$rs["results"][0]["texto" . $_SESSION["LOCALE"]]?></th>
                      </tr>
                    </table></th>
                  </tr>
                </table></th>
                <th width="326" scope="col"><table width="290" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_shadow">
                  <tr>
                    <th height="290" valign="top" scope="col"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th height="50" align="left" valign="middle" scope="col">
                        <?php
                        $rs = $Banners->getBannerbyZonas(15);
            ?>
                        <span class="eras rojo20"><?=_("Producto Destacado")?></span></th>
                      </tr>
                      <tr>
                        <th align="left" valign="top" scope="col" style="text-align:justify">
            <center><?= $Banners->showBanners(15);?></center><br />
                        <?=nl2br($rs["results"][0]["texto" . $_SESSION["LOCALE"]])?>
                        </th>
                      </tr>
                      
                    </table></th>
                  </tr>
                </table></th>
                <th width="326" scope="col"><table width="290" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_shadow">
                  <tr>
                    <th height="290" valign="top" scope="col"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th height="50" align="left" valign="middle" scope="col"><span class="eras rojo20"><?=_("Noticias & Novedades")?></span></th>
                      </tr>
                      <tr>
                        <th align="left" valign="top" scope="col">
                         <marquee  onmouseover="stop()" onmouseout="start()"  behavior="scroll" direction="up" scrollamount="2" style="margin-bottom:10px;">

<?php
$rss = $Shop->getNoticia(array("fk_tipo"=>1,"fk_destacada"=>1,"orderby"=>"pk_noticia desc"),$_GET["page"],3);
foreach($rss["results"] as $key => $value){


?>
                    <p><a href="?module=noticias_detalle&t=<?=$value["fk_tipo"]?>&i=<?=$value["pk_noticia"]?>"><span class="noticiahome_titulares"><?=$value["titulo" . $_SESSION["LOCALE"]]?></span></a><br />
                        <span class="noticiahome_resumen"><?=$Shop->makeSumario($value["sumario" . $_SESSION["LOCALE"]],70)?>&hellip;</span><br />
                        <span class="noticiahome_fecha"><?=$Shop->month2letter(date("n",strtotime($value["fecha_agregado"])))?> <?=date("d, Y",strtotime($value["fecha_agregado"]))?></span></p>
                        
                        
 <?php
}
 ?>                       
</marquee>                        
                        <br />
                        <a href="?module=noticias_home"><?=_("Ver todas")?> &raquo;</a>
                        </th>
                      </tr>
                      <tr>
                        <th height="15" align="left" valign="bottom" scope="col"></th>
                      </tr>
                    </table></th>
                  </tr>
                </table></th>
              </tr>
          </table>