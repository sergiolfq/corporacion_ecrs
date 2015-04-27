<?php
if(!isset($_SESSION["user"])  ){
    
	require("soporte_error.php");
}else{
	//var_dump($_SESSION["user"]);
?>




	<main>
			
			<!-- ============================================================= SECTION – PORTFOLIO ============================================================= -->
			<!--div class="row">
				<div class="banner">
					<div class="fixed-image dark-translucent-bg section" style="background-image:url('images/banners/download-banner.jpg');">
						
					</div>	
				</div>	
					
			</div-->
			<section id="circle-tabs">
				<div class="container inner">
					
					
					<div class="row">

						<div class="col-xs-12 inner-top">
							<div class="tabs tabs-services tabs-circle-top tab-container">
							     

								<h1 class="page-title">Descarga de recursos</h1>
							<div class="separator-2"></div>
							<p class="lead">Ponemos a su disposición documentos y manuales que le ayudarán con el funcionamiento y la gestión de nuestros equipos. <br>Ofreciéndole un soporte técnico permanente, además de entregarle un sinfín de recursos tecnológicos, gráficos y publicitarios.<br>
							Utilice el siguiente filtro para localizar el producto del cual desea obtener información.</p>

							<br>
							<br>
							<!-- page-title end -->
							
							<div class="sorting-filters">
								<form class="form-inline">
									<div class="form-group col-md-2">
										<label>Documentación</label>
										<select class="form-control">
											<option selected="selected">Documentos
											<option>Prográmas
											<option>Firmware
											<option>Partes y Piezas
											<option>Marketing
											<option>Todos
										</select>
									</div>
									<div class="form-group col-md-3">
										<label>Marca</label>
										<select class="form-control">
											<option selected="selected">Quorion System
											<option>Sewoo
										</select> 
									</div>
									<div class="form-group col-md-3">
										<label>Categoría Producto</label>
										<select class="form-control">
											<option selected="selected">Cajas Registradoras
											<option>Impresoras Fiscales
											<option>Terminales POS
											<option>Accesorios y Periféricos
										</select> 
									</div>
									<div class="form-group col-md-2">
										<label>Tipo de producto</label>
										<select class="form-control">
											<option selected="selected">Portátiles
											<option>Ventas al por menor
											<option>Multipropósito
											<option>Desktops
											<option>Software
											<option>Accessories
										</select> 
									</div>

									<div class="form-group col-md-2">
										<label>Modelo</label>
										<select class="form-control">
											<option selected="selected">CR20
											<option>Tablets
											<option>Smart Watches
											<option>Desktops
											<option>Software
											<option>Accessories
										</select> 
									</div>
								

								<center><div class="form-group">
										<a href="soporte-cr20.html"><button type="button" class="btn btn-default ">Buscar</button></a>
									</div>	</center>
								</form>
							</div>		

						</div><!-- /.col -->
					</div><!-- /.row -->
					
				</div><!-- /.container -->
			</section>
		</main>








<table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="top" scope="col"><?= $Banners->showBanners(6);?></th>
              </tr>
              </table>
              <table width="983" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 8px;">
              <tr>
              
              
              <th colspan="7" background="images/new/titulo.jpg" style="text-align: left"><span class="titulo1"><span class="Mapa">&nbsp;&nbsp;<?=_("Soporte >> Descarga & Documentaci&oacute;n")?></span></span></th>
              <td><img src="images/new/spacer.gif" width="1" height="35" border="0" alt="" /></td>              
              
              
            </tr>
        </table>
	    <br />           
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" valign="top" scope="col" style="text-align: justify;">
                
                <table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr><td>
                <p class="trebuchet_gris14">Estos documentos le ayudarán con el funcionamiento de su Caja Registradora Fiscal y Terminal POS QUORiON, así como proporcionar instrucciones sobre cómo programar su modelo de ECR o POS. Para su conveniencia, hemos ordenado nuestra documentación en categorías de productos.</p>
                <p class="trebuchet_gris14">Por favor, ingrese la descripción del producto, seguidamente seleccione la categoría. A continuación se mostrarán cada uno de los documentos relacionados con el producto que usted está consultando. Seleccione uno de los productos del menú, a continuación podrá descargar el documento o programa de su elección. Simplemente haga clic en el manual de interés. A continuación se le pedirá que descargue el archivo.</p>
                <p class="trebuchet_gris14">Para consultas o comentarios, por favor póngase en contacto con nosotros a través del siguiente correo electrónico: <span class="trebuchet-rojo13bold">contactenos@ecrs.com.ve</span></p>
                </td></tr>
                </table>
                                
                <table width="680" border="0" align="center" cellpadding="0" cellspacing="0" class="productos_round_box">
                  <tr>
                    <th scope="col"> <form id="form3" name="form3" method="post" action="">                 
                      <table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
                        <tr>
                          <th height="33" align="left" valign="middle" class="trebuchet_gris20" scope="col">                                                                             
                          <span class="trebuchet_rojo20">&nbsp;<?=_("Buscar por")?>:</span><br /></th>
                        </tr>
                      </table>
                      <table width="95%" border="0" align="left" cellpadding="5" cellspacing="0">
                        <tr>
                          <th width="15%" align="left" class="trebuchet_gris14" scope="col"><?=_("Descripción")?>:</th>
                          <th width="26%" align="left" scope="col">
                            <input name="keyword" type="text" class="fotoborder" id="keyword" size="18" value="<?=strip_tags($_POST["keyword"])?>" /></th>
                          <th width="13%" align="left" scope="col"><span class="trebuchet_gris14"><?=_("Marca")?>:</span></th>
                          <th width="30%" align="left" scope="col"><label for="fk_marca"></label>
                            <select name="fk_fabricante" id="fk_fabricante">
                            <option><?=_("Todas")?></option>
	  <?php $Shop->llenarComboDb(TBL_FABRICANTES,"pk_fabricante","fabricante","",0,$_POST["fk_fabricante"],"","fabricante asc"); ?>
      </select> </th>
                          <th width="16%" align="left" scope="col"> <input type="submit" name="Submit" id="button" value="<?=_("Buscar")?>" class="botoncot"   /></th>
                        </tr>
                        <tr>
                          <td align="left" class="trebuchet_gris14" scope="col"><?=_("Categoría:")?></td>
                          <td align="left">
                            <select name="fk_categoria" id="fk_categoria">
                              <option><?=_("Todas")?></option>

                              
                                <?php
$rsscategoria_padre = $Shop->getCategoria(array("fk_categoria_padre"=>0));
foreach($rsscategoria_padre["results"] as $keyserf => $valueserf){
?> 
								<optgroup label="<?=$valueserf["categoria" .$_SESSION["LOCALE"]]?>">
                                <?php $Shop->llenarComboDb(TBL_CATEGORIAS,"pk_categoria","categoria".$_SESSION["LOCALE"],"fk_categoria_padre",$valueserf["pk_categoria"],intval($_POST["fk_categoria"]),"","categoria" . $_SESSION["LOCALE"]. " asc"); ?>
                                </optgroup>
                                
                                <?php } ?>
                            </select>
                            </td>
                          <td align="left" class="trebuchet_gris14">&nbsp;</td>
                          <td align="left"><label for="categoria"></label></td>
                          <td align="left">&nbsp;</td>
                        </tr>
                      </table>
                    </form></th>
                  </tr>
                </table>
                
                <?php
                if(isset($_POST["keyword"])){
					$rss = $Shop->searchProducto($_POST);
					foreach($rss["results"]as $k=>$v){
						$sql = "select distinct(c.categoria". $_SESSION["LOCALE"]. ") as cat from " . TBL_SOPORTE_CATEGORIAS . " c where c.fk_estatus=1 and c.fk_usuario_tipo='" . $_SESSION["user"]["fk_usuario_tipo"]. "' and c.pk_soporte_categoria in (select fk_soporte_categoria from " . TBL_SOPORTE_DESCARGAS_VS_CATEGORIAS . " vs1 inner join " . TBL_SOPORTE_DESCARGAS_VS_PRODUCTOS . " vs2 on vs1.fk_soporte_descarga=vs2.fk_soporte_descarga where vs1.fk_estatus=1 and vs2.fk_estatus=1 and  vs2.fk_producto=" . $v["pk_producto"] . ") ";
						//echo $sql . "<hr>";
						/*
						
						
						 inner join " . TBL_SOPORTE_DESCARGAS. " d on c.pk_soporte_categoria=d.fk_soporte_categoria  where  c.fk_estatus>0 and  d.fk_estatus>0 and c.fk_usuario_tipo='" . $_SESSION["user"]["fk_usuario_tipo"]. "' and d.pk_soporte_descarga in (select fk_soporte_descarga from " . TBL_SOPORTE_DESCARGAS_VS_PRODUCTOS . " where fk_producto=" . $v["pk_producto"] . " and fk_estatus>0 )
						 */
						//echo $sql . "<hr>";
						$cats = $Shop->Execute($sql);
						if(sizeof($cats["results"])==0){
							unset($rss["results"][$k]);	
						}else{
							$rss["results"][$k]["cats"]=$cats["results"];
						}
					}
				
				?> 
                  <table width="629" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <th height="39" align="left" class="trebuchet_rojo20" scope="col"><?=_("Resultados de su búsqueda")?>:</th>
                    </tr>
                </table>
                  <br />
                  <?php if(sizeof($rss["results"])==0){ ?>
                  <h2 style="text-align:center"><?=_("Su búsqueda no arrojó resultados")?></h2>
                  <?php
				  }else{
					  foreach($rss["results"]as $k=>$v){
				  ?>
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <th class="productos_round_titulos eras rojo20" scope="col"><div style="font-size:14px; color:#666;">SKU: <?=$v["sku"]?></div > <?=$v["nombre" . $_SESSION["LOCALE"]]?></th>
                  </tr>
                </table>
                <br />
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <th align="left" valign="top" class="productos_round_box" scope="col"><ul>
                    <?php foreach($v["cats"] as $k2=>$v2){?>
                      <li class="trebuchet_gris12"><?=$v2["cat"]?></li>
                    <?php } ?>
                    </ul>
                    
                    <div class="leertodasdiv" style="margin-left:30px"><a href="/?module=soporte_detalle&t=<?=$Shop->encode($v["pk_producto"])?>" class="leertodas"><?=_("Descargar / Ver todos")?> &raquo;</a></div>
                    
                    </th>
                  </tr>
                </table>
		<br />                
                <br />  
          
				<?php
					  }
				  }
				}
				?>
                
                </th>
                <th width="260" align="center" valign="top" scope="col"><?php require("inc_right.php") ?></th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>


<?php
}
?>

