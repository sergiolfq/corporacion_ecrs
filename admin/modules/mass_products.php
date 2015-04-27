<?php
$Admin->chkPermisosAdmin(8);

?>
<form action="?module=<?=$_GET["module"]?>#productos" method="post" enctype="multipart/form-data" name="form2" id="form2">
  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="brd1">
    <tr>
      <td colspan="2" class="t1">Cargar productos  en masa (CSV)</td>
    </tr>
    <tr>
      <td>Archivo CSV :</td>
      <td><input type="file" name="archivo" id="archivo" /></td>
    </tr>
	
    <tr>
      <td>Formato:</td>
      <td>CDG, ID marca, ID categoria, Nombre del producto, Sumario, General, Valor, Referencias, Especificaciones, Caracteristicas, Accesorios, Nombre del producto ingl&eacute;s, Sumario ingl&eacute;s, General ingl&eacute;s, Valor ingl&eacute;s, Referencias ingl&eacute;s, Especificaciones ingl&eacute;s, Caracteristicas ingl&eacute;s, Accesorios ingl&eacute;s<br />
<strong>se ignorar&aacute; la primera fila</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>

</form>

<br />
<br />
<?php
if(is_file($_FILES["archivo"]["tmp_name"]) && substr($_FILES["archivo"]["name"],-4,4)=='.csv'){
		$handle = fopen($_FILES["archivo"]["tmp_name"], "r");
		$resultados = array();
		
		$H = new Helper;
		$cont=0;
		while (($rs = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($cont==0){
				$cont++;
				continue;
			}
		
			if(trim($rs[0])!=''){
			
				$rsPro = $Shop->getProducto(array("sku" => trim($rs[0])));
				$fab = $Shop->getFabricante(array("pk_fabricante"=>intval($rs[1])));
				$cat = $Shop->getCategoria(array("pk_categoria"=>intval($rs[2])));
			
				
			
						
				if(sizeof($fab["results"])>0 && sizeof($cat["results"])>0 ){
					
						$prox=array(		
											"sku"=>$rs[0],
											"fk_fabricante"=>$rs[1],
											"nombre"=>$rs[3],
											"sumario"=>$rs[4],
											"general"=>$rs[5],
											"valor"=>$rs[6],
											"referencias"=>$rs[7],
											"especificaciones"=>$rs[8],
											"caracteristicas"=>$rs[9],
											"accesorios"=>$rs[10],
											
											"nombre_en"=>$rs[11],
											"sumario_en"=>$rs[12],
											"general_en"=>$rs[13],
											"valor_en"=>$rs[14],
											"referencias_en"=>$rs[15],
											"especificaciones_en"=>$rs[16],
											"caracteristicas_en"=>$rs[17],
											"accesorios_en"=>$rs[18],
										);
						
						if(sizeof($rsPro["results"])>0){
							$prox["pk_producto"]=$rsPro["results"][0]["pk_producto"];
							$resultados[]=array($rs[0],"Producto modificado");
						}else{
							$resultados[]=array($rs[0],"Producto agregado");	
						}
						$pk_producto = $H->addProductos($prox);	
						
						$sql = "update " . TBL_PRODUCTOS_VS_CATEGORIAS . " set fk_estatus=0 where fk_producto=" . $pk_producto . " and fk_categoria=" . intval($rs[2]);
						$Shop->ExecuteAlone($sql);
					
					
						$sql = "insert into " . TBL_PRODUCTOS_VS_CATEGORIAS . " (fk_producto, fk_categoria) values (" . $pk_producto . "," . intval($rs[2]) . ")";
						$Shop->ExecuteAlone($sql);
						
					
				}else{
					$resultados[]=array($rs[0],"ERROR, fabricante o categoria no existe");
				}
			}
		}
		
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="brd1">
  <tr>
    <td colspan="3" class="t1">Resultado<a name="productos" id="productos"></a> </td>
  </tr>
  <tr>
  	<td class="t5">#</td>
    <td class="t5">CDG</td>
    <td class="t5">&nbsp;</td>
  </tr>
<?php 
$cont =1;
foreach($resultados as $key => $value){ 
?>
  <tr>
  	<td><?=$cont++?></td>
    <td><strong><?=$value[0]?></strong></td>
    <td><?=$value[1]?></td>
  </tr>
<?php } ?>
</table>
<?php
}
?>
