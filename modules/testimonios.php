<?php
$arr = array("orderby"=>"pk_testimonio desc");
if(intval($_GET["i"])>0){
	$arr["pk_testimonio"]=intval($_GET["i"]);
}
$rss = $Shop->getTestimonio($arr,$_GET["page"],5);
?>
<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(7);?></th>
              </tr>
          </table>
            <table width="987" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
              <tr>
              
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Testimonios")?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>                
              
            </tr>
        </table>
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col"> 
                <?php
					  foreach($rss["results"] as $key => $value){
					  ?>
                 <br />
                  <table width="585" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <th width="215" valign="top" scope="col"><br />
                        <table width="215" border="0" align="left" cellpadding="10" cellspacing="0" class="fotoborder">
                        <tr>
                          <th bgcolor="#efefef" scope="col"><img src="images/testimonios/<?=$value["pk_testimonio"]?>.jpg"  alt="testimonios" /></th>
                        </tr>
                      </table></th>
                      <th width="15" scope="col">&nbsp;</th>
                      <th width="360" align="left" valign="top" scope="col"><p class="testimonios_text2">&quot;<?=$value["sumario" . $_SESSION["LOCALE"]]?>&quot;</p>
                      <p class="noticias_autorizaciones"><?=$value["titulo" . $_SESSION["LOCALE"]]?><br />
                        <span class="noticiahome_fecha"><?=$Shop->month2letter(date("m",strtotime($value["fecha_modificado"])))?> <?=date("d, Y",strtotime($value["fecha_modificado"]))?></span></p></th>                        
                    </tr>
                  </table>
                  <table width="585" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <th height="33" class="productos_sumariohome" scope="col">................................................................................................................................................................................................</th>
                    </tr>
                  </table>
                  <?php } ?>
                  <br /><br />
                  <?php if(intval($_GET["i"])==0){ ?>
                  <div align="center"> <?=$Shop->paginateResults($rss)?></div>
                  <?php } ?> 
                  </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>