<?php
$rss = $Shop->getNoticia(array("fk_tipo"=>$_GET["t"],"orderby"=>"fecha_noticia desc"),$_GET["page"],5);
?>
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <th valign="top" scope="col"><?= $Banners->showBanners(5);?></th>
              </tr>
          </table>
            <table width="981" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
              <th class="titulos" scope="col">
			  <?php
              $arr = array('',_("Noticias"),_("Autorizaciones"),_("Providencias y Resoluciones"));
			  echo $arr[$_GET["t"]];
			  ?>
              </th>
            </tr>
        </table>
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="680" valign="top" scope="col" align="left">
                <ul>
                      <?php
					  foreach($rss["results"] as $key => $value){
					  ?>
                        <span class="noticiahome_fecha"><?=$Shop->month2letter(date("n",strtotime($value["fecha_noticia"])))?> <?=date("d, Y",strtotime($value["fecha_noticia"]))?></span>
                        <li>
                        <?php if($_GET["t"]==1){ ?>
                        <span class="noticias_empresa">Corporaci&oacute;n ECRS</span><br />
                        <?php } ?>
                          <span class="noticias_titulo"><a href="?module=noticias_detalle&t=<?=$value["fk_tipo"]?>&i=<?=$value["pk_noticia"]?>" style="color:#3E3E3E; text-decoration:none;" class="aoverunderline"><?=$value["titulo" . $_SESSION["LOCALE"]]?></a></span><br />
                          <div class="noticiahome_resumen" style="text-align:justify !important"><?=$value["sumario" . $_SESSION["LOCALE"]]?></div><br />
                          
                          <div class="leermasdiv" >
                           <?php if($_GET["t"]==1){ ?>
                           <a href="?module=noticias_detalle&t=<?=$value["fk_tipo"]?>&i=<?=$value["pk_noticia"]?>" class="aoverunderline leermas"><?=_("Leer más")?> &raquo;</a>
                          <?php }else{ ?>
                          <a href="?dw=<?=$Shop->encode($value["pk_noticia"])?>" target="_blank" style="text-decoration:none; font-size:14px;" class="aoverunderline"><img src="../images/document-pdf-icon.png" alt="Descargar PDF" width="48" height="48" border="0" align="absmiddle" /> <?=_("Descargar Archivo PDF")?></a>
                          <?php } ?>
                          </div>
                          <br />
                          <br />
                        </li>
                       <?php
                       }
					   ?> 
                      </ul>
                      
               <div align="center"> <?=$Shop->paginateResults($rss)?></div>
                </th>
                <th width="30" align="center" valign="top" scope="col">&nbsp;</th>

                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>