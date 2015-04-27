<?php
$Textos = new Textos;
$rs = $Textos->getTexto(array("pk_texto" => intval($_GET["i"])));
?>
<table width="979" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th height="217" valign="top" scope="col"><?= $Banners->showBanners(2);?></th>
              </tr>
          </table>
            <table width="983" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 6px;">
              <tr>
                            
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Sobre Nosotros")?> &gt;&gt; <?=$rs["results"][0]["titulo" . $_SESSION["LOCALE"]]?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>              
              
            </tr>
        </table>
            <br /> 
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col">    <?php if(intval($_GET["i"]) == 2) { ?> <br /> <?php } ?>     <?=($rs["results"][0]["texto" . $_SESSION["LOCALE"]])?>    </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>