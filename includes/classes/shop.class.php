<?php
/*########################################################################################################
##																										##
## ISOMETRICO.COM																						##
## 																										##
## Programacion por:    	                                     										##
##                   Mauricio A. Duran D. taufpate@taufpate.com                                         ##
##                   										                                            ##
##																										##
## Fecha de Creacion: 	Septiembre 2007																	##
## Ultima modificacion: Septiembre 2007    																##
## Clase:				shop 																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
class Shop extends Common{
	function __construct(){
			parent::__construct();
		//$this->arrIdiomas = array("en_US","es_ES");
		//$this->setIdioma($_SESSION["LOCALE"]);
	}
	function setIdioma($idioma){
		if(!isset($_SESSION["LOCALE"]) || !in_array($idioma,$this->arrIdiomas) ){
			$_SESSION["LOCALE"]= "es_ES";
		}elseif($_SESSION["LOCALE"] != $idioma){
				$_SESSION["LOCALE"]=$idioma;
		}
		$l = setlocale(LC_MESSAGES, $_SESSION["LOCALE"]);
		bindtextdomain('messages', SERVER_ROOT.'locale');
	}
	
	function migas($get){
		switch($_GET["module"]) {
			case "":
			case "main":
				$var = "<span class=\"titulorojo_destacado\">" . _("Inicio") . "</span>";
			break;
			case "ingreso":
				$var = "<span class=\"titulorojo_destacado\">" . _("Ingreso") . "</span>";
			break;
			case "registro":
				$var = "<span class=\"titulorojo_destacado\">" . _("Registro") . "</span>";
			break;
			case "activate":
				$var = "<span class=\"titulorojo_destacado\">" . _("Activación de usuario") . "</span>";
			break;
			case "account":
			case "account_edt":
				$var = "<span class=\"titulorojo_destacado\">" . _("Mi cuenta") . "</span>";
			break;
			
			case "account_address":
			case "account_address_adtedt":
				$var = "Mi cuenta &raquo;  <span class=\"titulorojo_destacado\">" . _("Mis direcciones") . "</span>";
			break;
			
			case "account_orders":
			case "account_orders_details":
				$var = "Mi cuenta &raquo;  <span class=\"titulorojo_destacado\">" . _("Mis pedidos") . "</span>";
			break;
			
			case "account_tickets":
			case "account_tickets_details":
				$var = "Mi cuenta &raquo;  <span class=\"titulorojo_destacado\">" . _("Mis comunicaciones") . "</span>";
			break;
			 
			case "contacto":
				$var = "<span class=\"titulorojo_destacado\">" . _("Contáctenos") . "</span>";
			break;
			
			break;
			case "product_detail":
				$var = "<span class=\"titulorojo_destacado\">" . _("Detalle de producto") . "</span>";
			break;
			case "categoria":
				if(!isset($get["buscar"])){
					$vv = $this->getCategoriaTree($get["pkcat"]);
					$vv2 = $this->getCategoria(array("pk_categoria" => $get["pkcat"]));
					$var = "" . _("Productos") . " &raquo; " . $vv[0]["categoria" .$_SESSION["LOCALE"]] . " &raquo; <span class=\"titulorojo_destacado\">" . $vv2["results"][0]["categoria" .$_SESSION["LOCALE"]] . "</span>";
				}else{
					$var = "" . _("Productos") . " &raquo; <span class=\"titulorojo_destacado\">" . _("Búsqueda de productos") . "</span>";
				}
			break;
			case "forgot":
				$var = "<span class=\"titulorojo_destacado\">" . _("Recuperar contraseña") . "</span>";
			break;
			case "cart":
			case "cart_check":
			case "cart_addr":
			case "cart_review":
			case "cart_end":
				$var = "<span class=\"titulorojo_destacado\">" . _("Mi carrito") . "</span>";
			break;
			
		}
		return $var;
	}
	function addCategoria($post,$file){
	
		$fields = array("categoria","categoria_en","categoria_co","categoria_es","fk_destacado","fk_orden","texto","texto_en"); 
		
		if(intval($post["pk_categoria"])>0){//es un edit realmente
			array_push($fields,"pk_categoria");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		
		$arrTemp= array("tabla" => TBL_CATEGORIAS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);

		if(intval($post["pk_categoria"])>0){//es un edit realmente
			$id=$post["pk_categoria"];
		}
		
		if(trim($post["categoria2"])!=''){ // tiene una hija
			unset($fields);
			unset($arrTemp);
			$fields = array("categoria","categoria_en","categoria_co","fk_categoria_padre","fecha_agregado","fk_destacado"); 
			$post["fecha_agregado"]=date("Y/m/d H:i");
			$post["fk_categoria_padre"]=$id;
			$post["categoria"]=$post["categoria2"];
			$post["categoria_en"]=$post["categoria2_en"];
			$post["categoria_co"]=$post["categoria2_co"];
			$arrTemp= array("tabla" => TBL_CATEGORIAS);
			$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
			$this->addEdtTabla($arrTemp);
		}
		
		if(is_uploaded_file($file["imagen"]['tmp_name'])){	
			$path= SERVER_ROOT . "images/categorias/";
			$Media = new Media;		
			$Media->cropCenterImage($file["imagen"]["tmp_name"],150,150,$path . "cat_" . $id . ".jpg"); 
		}
		
		return $id;
	}
	
	function editCategoria($post,$file){
		return $this->addCategoria($post,$file);
	
	}
	
	function deleteCategoria($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_CATEGORIAS . " set fk_estatus=0 where pk_categoria=" . $value);
			}
		return true;
	}
	function getCategoria($post='',$page=0,$results_per_page=999){
		$arr=array("tabla"=>TBL_CATEGORIAS);
		if(!isset($post["orderby"]))
			$post["orderby"]="categoria asc";
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
			$arr["orderby"]='fk_orden asc';
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function getCategoriaTree($pk_categoria,$direction='up') {
		$arr = array();
		$arr2 = array();
		if($direction=='up'){
			$rs1=$this->getCategoria(array("pk_categoria" => $pk_categoria));
			$fk_padre=intval($rs1["results"][0]["fk_categoria_padre"]);
			
			if($fk_padre>0){
				do{
					$rs=$this->getCategoria(array("pk_categoria" => $fk_padre));
					if(sizeof($rs["results"])>0){
						$arr[] = $rs["results"][0];
					}
					$fk_padre=intval($rs["results"][0]["fk_categoria_padre"]);
				}while(sizeof($rs["results"])>0);
				krsort($arr);
			}
		}else{
			$rs=$this->getCategoria(array("fk_categoria_padre" => $pk_categoria));
			if(sizeof($rs["results"])>0){
				foreach($rs["results"] as $key => $value){
					$arr[]=$value;
					$arr2 = $this->getCategoriaTree($value["pk_categoria"],'down');
					
					$arr = array_merge($arr,$arr2);
				}
			}
			
		}
		return $arr;
	}
		
	function getProductosDestacadosByCategoria(){ 
		$arr = array();
		$sql = "select * from  " . TBL_PRODUCTOS . " p inner join " . TBL_PRODUCTOS_VS_CATEGORIAS . " vs on p.pk_producto=vs.fk_producto inner join  " . TBL_CATEGORIAS . " c on vs.fk_categoria=c.pk_categoria where p.fk_estatus>0 and p.fk_destacado=1 and c.fk_estatus>0 and c.fk_categoria_padre>0 and vs.fk_estatus=1 order by c.fk_orden, c.pk_categoria asc";	
		$rs = $this->Execute($sql);
		foreach($rs["results"] as $k=>$v){
			if(!isset($arr[$v["categoria"]])){
				$arr[$v["categoria"]] = array();
			}
			$arr[$v["categoria"]][]=$v;
		}
		return $arr;
	}
    
    function getProductosPromocionadosByCategoria(){ 
        $arr = array();
        $sql = "select * from  " . TBL_PRODUCTOS . " p inner join " . TBL_PRODUCTOS_VS_CATEGORIAS . " vs on p.pk_producto=vs.fk_producto inner join  " . TBL_CATEGORIAS . " c on vs.fk_categoria=c.pk_categoria where p.fk_estatus>0 and p.fk_oferta=1 and c.fk_estatus>0 and c.fk_categoria_padre>0 and vs.fk_estatus=1 order by c.fk_orden, c.pk_categoria asc";    
        $rs = $this->Execute($sql);
        foreach($rs["results"] as $k=>$v){
            if(!isset($arr[$v["categoria"]])){
                $arr[$v["categoria"]] = array();
            }
            $arr[$v["categoria"]][]=$v;
        }
        return $arr;
    }                
    			
	function addProducto($post,$files){

		$fields = array("fecha_ini","fecha_fin","sku","fk_fabricante","nombre","nombre_en","sumario","sumario_en","precio00","precio10","precio20","precio01","precio11","precio21","precio02","precio12","precio22","fk_oferta","fk_vendido","fk_destacado","fk_recomendado","fecha_agregado","fk_estatus","general","general_en","valor","valor_en","referencias","referencias_en","especificaciones","especificaciones_en","caracteristicas","caracteristicas_en","accesorios","accesorios_en","nombre_soporte_en","nombre_soporte");
		
		
		if(intval($post["pk_producto"])>0){//es un edit realmente
			array_push($fields,"pk_producto");
		}else{
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_PRODUCTOS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		$id = $this->addEdtTabla($arrTemp);
		
		if($post["pk_producto"] > 0) $id = $post["pk_producto"]; 
		
		$Aggregator = new Aggregator();
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_PRODUCTOS_VS_CATEGORIAS,"fk"=>"fk_producto","fk2"=>"fk_categoria","id"=>$id));
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_PRODUCTOS_VS_CARACTERISTICAS,"fk"=>"fk_producto","fk2"=>"fk_caracteristica","id"=>$id));
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_PRODUCTOS_VS_PROVEEDORES,"fk"=>"fk_producto","fk2"=>"fk_proveedor","id"=>$id));
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_PRODUCTOS_RELACIONADOS,"fk"=>"fk_producto_origen","fk2"=>"fk_producto_destino","id"=>$id));
		
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_PRODUCTOS_COMBINABLES,"fk"=>"fk_producto_origenC","fk2"=>"fk_producto_destinoC","id"=>$id));
		
		
		$this->ExecuteAlone("update " .  TBL_PRODUCTOS_VS_VARIANTES_TIPO . " set fk_estatus=0 where fk_producto=" . $id );
		if(sizeof($post["variantes"])>0){
			foreach($post["variantes"] as $key => $value){
				$this->ExecuteAlone("insert into " .  TBL_PRODUCTOS_VS_VARIANTES_TIPO . " (fk_producto,fk_variante_tipo) values (" . $id . "," . $this->clearSql_n($value) . ")");
			}
		}
		
		$this->fotosProducto($files,$id,$post["fk_oferta"]);
		
		
		
		if($post["pk_producto"] == 0){
			//$this->generarSiteMap();
		}
		
		
		return $id;
	}
	
	function editProducto($post,$files){
		return $this->addProducto($post,$files);
	
	}
	
	function fotosProducto($files,$id,$fk_oferta=0){
                $path= SERVER_ROOT . "images/products/";
                $Media = new Media;
                if(is_array($files)){
                        foreach($files as $key => $value){
                                if(is_uploaded_file($value['tmp_name'])){
                                        $ext = $Media->getImageExt($value["tmp_name"]);
                                        if($key == 'foto_sumario'){
                                                $Media->cropCenterImage($value["tmp_name"],125,90,$path . "tb_" . $id . ".jpg");
												$Media->cropCenterImage($value["tmp_name"],300,200,$path . "tb2_" . $id . ".jpg");
                                        }elseif($key == 'foto_banner' ){
												$Media->cropCenterImage($value["tmp_name"],980,215,$path  . "ban_" . $id . ".jpg");
										}elseif($key == 'foto_destacado'){											
												@unlink($path  . "foto_dest_" . $id . ".jpg");
												move_uploaded_file($value["tmp_name"],$path  . "foto_dest_" . $id . ".jpg");
                                        }elseif($key == 'foto_promocion'){                                            
                                                @unlink($path  . "foto_promo_" . $id . ".jpg");
                                                move_uploaded_file($value["tmp_name"],$path  . "foto_promo_" . $id . ".jpg");
										}elseif($key == 'foto_banner_en' ){
												$Media->cropCenterImage($value["tmp_name"],980,215,$path  . "ban_en_" . $id . ".jpg");	
										}else{
                                                error_log($key);
                                                error_log(substr($key,0,5));
                                                if(substr($key,0,5)=='picc_'){
                                                        
                                                        $Media->cropCenterImage($value["tmp_name"],80,80,$path  .$key . "_" . $id . ".jpg");
                                                }else{
                                                      //  $Media->cropCenterImage($value["tmp_name"],630,282,$path ."m_" . $key . "_". $id . ".jpg");
													  	$Media->cropCenterImage($value["tmp_name"],800,686,$path .$key . "_". $id . "big.jpg");
                                                        $Media->cropCenterImage($value["tmp_name"],455,390,$path .$key . "_". $id . ".jpg");
                                                }
                                        }
                                }
                        }
                }
        }
	
	function deleteProducto($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_PRODUCTOS . " set fk_estatus=0 where pk_producto=" . $value);
				
				for($a=1;$a<=5;$a++){
					@unlink(SERVER_ROOT . "images/products/pic_" . $a . "_" . $value . ".jpg");
				}

				@unlink(SERVER_ROOT . "images/products/tb_" . $value . ".jpg");
				@unlink(SERVER_ROOT . "images/products/tb_Off_" . $value . ".jpg");
			
			}
		return true;
	}
	
	function getProducto($vars='',$page=0,$results_per_page=10) {
	
		//$sql= "select " . TBL_PRODUCTOS . ".*," . TBL_FABRICANTES . ".fabricante from " .TBL_PRODUCTOS . " inner join " . TBL_FABRICANTES . " on " .TBL_PRODUCTOS . ".fk_fabricante=" . TBL_FABRICANTES . ".pk_fabricante left join " . TBL_PRODUCTOS_VS_CATEGORIAS . " on " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto=" .TBL_PRODUCTOS . ".pk_producto  where ";
                $sql= "select " . TBL_PRODUCTOS . ".*," . TBL_FABRICANTES . ".fabricante, " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_categoria from " .TBL_PRODUCTOS . " inner join " . TBL_FABRICANTES . " on " .TBL_PRODUCTOS . ".fk_fabricante=" . TBL_FABRICANTES . ".pk_fabricante left join " . TBL_PRODUCTOS_VS_CATEGORIAS . " on " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto=" .TBL_PRODUCTOS . ".pk_producto  where ";
		
		
		$Admin = new Admin;
		$is_admin=$Admin->isAdmin();
		
		$sql .= ($is_admin) ? TBL_PRODUCTOS . ".fk_estatus >= 1":TBL_PRODUCTOS . ".fk_estatus=1";
		if(!$is_admin){
			$sql.= " and " . TBL_PRODUCTOS . ".fecha_ini<=now() and " . TBL_PRODUCTOS . ".fecha_fin>=now()";
		}
	
		if(
				intval($vars["fk_categoria"])==0 && 
				intval($vars[TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_categoria"])==0 && 
				intval($vars["pk_producto"])==0
			){//para no cargar mucho a la db por la consultota
			
			$vars["groupby"]=TBL_PRODUCTOS . ".pk_producto";
		
		}elseif(intval($vars["fk_oferta"])!=0 || intval($vars["fk_vendido"])!=0 || intval($vars["fk_destacado"])!=0 || intval($vars["fk_promocion"])!=0 ){
			$vars["groupby"]=TBL_PRODUCTOS . ".pk_producto";
		}
		
		if(isset($vars["banda_precio"])){
			$sql .= " and " . TBL_PRODUCTOS . ".precio" . $this->clearSql_s($vars["banda_precio"]) . ">0 ";
			unset($vars["banda_precio"]);
		}
		
		if(isset($_SESSION["fk_pais_seleccionado"]) && !$is_admin){
			$sql .= " and " . TBL_PRODUCTOS . ".disponible_" . intval($_SESSION["fk_pais_seleccionado"]) . "=0 ";
		}
		
		$sql .= $this->prepareSqlVars($vars);
		//echo $sql . "<hr>";
		return $this->Execute($sql,$results_per_page,$page);	
	}
        	function getProductoBoostrap($vars='',$page=0,$results_per_page=10) {
                    require_once (" ../soporte/da1/conexion.php");
              	$sql= "select distinct tbl_productos.* from tbl_productosorder by rand() limit 16 ";
                 
		return $this->Execute($sql,$results_per_page,$page);	
	}
        
        
        
        
        
        
	function getMarcasByCategoria($post,$page=0,$results_per_page=9999){
		$sql = "select " . TBL_FABRICANTES . ".* from " . TBL_PRODUCTOS . " inner join " . TBL_PRODUCTOS_VS_CATEGORIAS . " on " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto=" . TBL_PRODUCTOS . ".pk_producto inner join " . TBL_FABRICANTES . " on " . TBL_PRODUCTOS . ".fk_fabricante=" . TBL_FABRICANTES . ".pk_fabricante where " . TBL_FABRICANTES . ".fk_estatus=1 and ";
		
		$Admin = new Admin;
		$is_admin=$Admin->isAdmin();
		
		$sql .= ($is_admin) ? TBL_PRODUCTOS . ".fk_estatus >= 1":TBL_PRODUCTOS . ".fk_estatus=1";
		if(!$is_admin){
			$sql.= " and " . TBL_PRODUCTOS . ".fecha_ini<=now() and " . TBL_PRODUCTOS . ".fecha_fin>=now()";
		}
		
		if(isset($post["fk_categoria"]) && intval($post["fk_categoria"])>0){
			$sql.= " and " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_estatus=1 and " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_categoria=" . intval($post["fk_categoria"]);
		}
		
		$sql .= " group by " . TBL_FABRICANTES . ".pk_fabricante order by " . TBL_FABRICANTES . ".fabricante asc";
		
		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function pricesProducto($post){
	
		if($post["porcentaje"]=="0"){
			die("Cero??");
		}
		$arrproEX = array();
		$arrproIN = array();
		$arrModificados=array();
		$arrVerificados=array();
		
		if(sizeof($post["fk_fabricante"])>0 && sizeof($post["fk_categoria"])>0){ //busco los productos que deberian ir
			foreach($post["fk_fabricante"] as $key => $value){
				foreach($post["fk_categoria"] as $key2 => $value2){
					$sql = "select " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto from " . TBL_PRODUCTOS_VS_CATEGORIAS . " inner join " . TBL_PRODUCTOS . " on " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto=" . TBL_PRODUCTOS . ".pk_producto  where " . TBL_PRODUCTOS . ".fk_fabricante=" . intval($value) . " and " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_categoria=" . intval($value2) . " and  " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_estatus=1 group by " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto";	
					//error_log($sql);
					$arrtemp = $this->Execute($sql,99999999,0);
					if(sizeof($arrtemp["results"])>0){	
						foreach($arrtemp["results"] as $keyRR => $valueRR){
							$arrproIN[] =intval($valueRR["fk_producto"]);
						}
					}
				}
			}
			//var_dump($arrproIN);
			//echo "<hr>";
		}
	
		if(sizeof($post["fk_fabricante2"])>0 && sizeof($post["fk_categoria2"])>0){ //busco los productos que debo excluir
			
			foreach($post["fk_fabricante2"] as $key => $value){
				foreach($post["fk_categoria2"] as $key2 => $value2){
					$sql = "select " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto from " . TBL_PRODUCTOS_VS_CATEGORIAS . "  inner join " . TBL_PRODUCTOS . " on " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto=" . TBL_PRODUCTOS . ".pk_producto  where " . TBL_PRODUCTOS . ".fk_fabricante=" . intval($value) . " and  " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_categoria=" . intval($value2) . " and  " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_estatus=1 group by " . TBL_PRODUCTOS_VS_CATEGORIAS . ".fk_producto";	
				
					$arrtemp = $this->Execute($sql,99999999,0);
					if(sizeof($arrtemp["results"])>0){	
						foreach($arrtemp["results"] as $keyRR => $valueRR){
							$arrproEX[]=intval($valueRR["fk_producto"]);
						}
					}
				}
			}
			//var_dump($arrproEX);
			//echo "<hr>";
		}
		//echo "<hr color='#ff0000'>";
		//comienzo el cambio
		
		
		foreach($arrproIN as $key => $value){
		//echo $value . "-" . array_search($value,$arrproEX) . "<hr>";
			if(!in_array($value,$arrVerificados,false)){ //no fue modificado anteriormente
			  //echo $value . "<hr>";
			 
				$arrVerificados[]= intval($value);
				if(!in_array($value,$arrproEX,false)){ //no es un producto excluido
					//modifico el precio
					//echo $value . " -----<hr>";
					if($post["porcentaje"]>0){
						$signo = '+';
					}else{
						$signo = '-';
					}
					$arrModificados[]=intval($value);
					$sql = "update " . TBL_PRODUCTOS . " set ";
					if(in_array("VE",$post["monedas"])){
						$sql .= "precio00= (precio00 {$signo} (precio00* " . (abs($post["porcentaje"])/100) . ")),";
						$sql .= "precio01= (precio01 {$signo} (precio01* " . (abs($post["porcentaje"])/100) . ")),";
						$sql .= "precio02= (precio02 {$signo} (precio02* " . (abs($post["porcentaje"])/100) . ")),";
					}
					if(in_array("CO",$post["monedas"])){
						$sql .= "precio10= (precio10 {$signo} (precio10* " . (abs($post["porcentaje"])/100) . ")),";
						$sql .= "precio11= (precio11 {$signo} (precio11* " . (abs($post["porcentaje"])/100) . ")),";
						$sql .= "precio12= (precio12 {$signo} (precio12* " . (abs($post["porcentaje"])/100) . ")),";
						
					}
					if(in_array("US",$post["monedas"])){
						$sql .= "precio20= (precio20 {$signo} (precio20* " . (abs($post["porcentaje"])/100) . ")),";
						$sql .= "precio21= (precio21 {$signo} (precio21* " . (abs($post["porcentaje"])/100) . ")),";
						$sql .= "precio22= (precio22 {$signo} (precio22* " . (abs($post["porcentaje"])/100) . ")),";
					}
					
					$sql .= " fecha_modificado=now() where pk_producto=" . intval($value);
					//echo $sql;
					$this->ExecuteAlone($sql);
				}
			}
		}
		return $arrModificados;
	}
	
	function searchProducto($cadena,$orderby='',$page=0,$results_per_page=10){
		
		if(!is_array($cadena)){
			$cadena .= " ";
			$palabras = split(" ",$cadena);
		}else{
			$vars = $cadena;
			$cadena = $vars["keyword"] . " ";
			$palabras = split(" ",$cadena);
		}
		
		foreach($palabras as $key => $value){
			$palabra = $this->clearSql_s($value);
			$rcw = $this->Execute("select * from " . TBL_COMMON_WORDS . " where word='" . $palabra . "'");
			
			if(sizeof($rcw["results"])==0 && trim($palabra)!=''){ //no es una palabra comun

				$sqltmp[0] .= " if (" . TBL_PRODUCTOS . ".sku like '%" . $palabra . "%',5,0) + if (" . TBL_PRODUCTOS . ".nombre like '%" . $palabra . "%',4,0) + if (" . TBL_PRODUCTOS . ".especificaciones like '%" . $palabra . "%',1,0) + if (" . TBL_PRODUCTOS . ".sumario like '%" . $palabra . "%',2,0) + if (" . TBL_FABRICANTES . ".fabricante like '%" . $palabra . "%',3,0) +";
				$sqltmp[1] .= " " . TBL_PRODUCTOS . ".sku like '%" . $palabra . "%' or ";
				$sqltmp[2] .= " " . TBL_PRODUCTOS . ".nombre  like '%" . $palabra . "%' or " . TBL_PRODUCTOS . ".nombre_en  like '%" . $palabra . "%' or ";
				$sqltmp[3] .= " " . TBL_PRODUCTOS . ".especificaciones  like '%" . $palabra . "%' or ";
				$sqltmp[4] .= " " . TBL_PRODUCTOS . ".sumario  like '%" . $palabra . "%' or " . TBL_PRODUCTOS . ".sumario_en  like '%" . $palabra . "%' or ";
				$sqltmp[5] .= " " . TBL_FABRICANTES . ".fabricante  like '%" . $palabra . "%' or ";
			
			}
		}
		$sqltmp[0] = substr($sqltmp[0],0,(strlen($sqltmp[0])-2));
		$sqltmp[1] = substr($sqltmp[1],0,(strlen($sqltmp[1])-4));
		$sqltmp[2] = substr($sqltmp[2],0,(strlen($sqltmp[2])-4));
		$sqltmp[3] = substr($sqltmp[3],0,(strlen($sqltmp[3])-4));
		$sqltmp[4] = substr($sqltmp[4],0,(strlen($sqltmp[4])-4));
		$sqltmp[5] = substr($sqltmp[5],0,(strlen($sqltmp[5])-4));
		
		$sqlselect = "select ";
		if(trim($sqltmp[0])!=''){
			$sqlselect .= $sqltmp[0] . " as relevancia, ";
			if($orderby==''){
				$orderby='relevancia desc';	
			}
		}else{
			if($orderby==''){
				$orderby='pk_producto desc';	
			}
		}
		$sqlselect .= TBL_PRODUCTOS . ".*," . TBL_FABRICANTES . ".fabricante";
		$sql = $sqlselect . " from " . TBL_PRODUCTOS . "  inner join " . TBL_FABRICANTES . " on " . TBL_PRODUCTOS . ".fk_fabricante=" . TBL_FABRICANTES . ".pk_fabricante where " ;
		$Admin = new Admin;
		
		$is_admin=$Admin->isAdmin();
		$sql .= ($is_admin) ? TBL_PRODUCTOS . ".fk_estatus >= 1":TBL_PRODUCTOS . ".fk_estatus=1";
		
		if(isset($_SESSION["fk_pais_seleccionado"]) && !$is_admin){
			$sql .= " and " . TBL_PRODUCTOS . ".disponible_" . intval($_SESSION["fk_pais_seleccionado"]) . "=0 ";
		}
		
		if(isset($vars["fk_fabricante"]) && intval($vars["fk_fabricante"])>0){
			$sql .= " and " . TBL_PRODUCTOS . ".fk_fabricante=" . intval($vars["fk_fabricante"]) . " ";
		}
		
		if(isset($vars["fk_categoria"]) && intval($vars["fk_categoria"])>0){
			$sql .= " and " . TBL_PRODUCTOS . ".pk_producto in (select fk_producto from " . TBL_PRODUCTOS_VS_CATEGORIAS . " where fk_estatus>0 and fk_categoria=" . intval($vars["fk_categoria"]) . ")";
		}
		if(trim($sqltmp[0])!=''){
			$sql .= " and " . TBL_FABRICANTES . ".fk_estatus=1 and ( (" . $sqltmp[1] . ") or (" . $sqltmp[2] . ") or  (" . $sqltmp[3] . ") or (" . $sqltmp[4] . ") or  (" . $sqltmp[5] . ") )";
		}
		$sql .= " group by " . TBL_PRODUCTOS . ".pk_producto order by " . $orderby;
		
		
		
		
		//echo "<!--" . $sql . "-->";
		//echo $sql;
		return $this->Execute($sql,$results_per_page,$page);
		
	}
	
	function getProductoRelacionado($pk_producto){
		$sql= "select " . TBL_PRODUCTOS . ".* from " .TBL_PRODUCTOS . " inner join " . TBL_FABRICANTES . " on " .TBL_PRODUCTOS . ".fk_fabricante=" . TBL_FABRICANTES . ".pk_fabricante inner join " . TBL_PRODUCTOS_RELACIONADOS . " on " . TBL_PRODUCTOS_RELACIONADOS . ".fk_producto_destino=" . TBL_PRODUCTOS . ".pk_producto  where " . TBL_PRODUCTOS_RELACIONADOS . ".fk_estatus=1 and " . TBL_PRODUCTOS . ".fk_estatus=1 and " . TBL_PRODUCTOS_RELACIONADOS . ".fk_producto_origen=" . intval($pk_producto);
		return $this->Execute($sql);
	}
	function getProductoCombinable($pk_producto){
		$sql= "select " . TBL_PRODUCTOS . ".* from " .TBL_PRODUCTOS . " inner join " . TBL_FABRICANTES . " on " .TBL_PRODUCTOS . ".fk_fabricante=" . TBL_FABRICANTES . ".pk_fabricante inner join " . TBL_PRODUCTOS_COMBINABLES . " on " . TBL_PRODUCTOS_COMBINABLES . ".fk_producto_destinoC=" . TBL_PRODUCTOS . ".pk_producto  where " . TBL_PRODUCTOS_COMBINABLES . ".fk_estatus=1 and " . TBL_PRODUCTOS . ".fk_estatus=1 and " . TBL_PRODUCTOS_COMBINABLES . ".fk_producto_origenC=" . intval($pk_producto);
		return $this->Execute($sql);
	}
	
	
	function addProveedor($post,$file){
	
		$fields = array("proveedor","rif","nit","direccion","fk_ciudad","fk_estado","fk_pais","telefono","fax","contacto","email","url","observaciones"); 
		
		if(intval($post["pk_proveedor"])>0){//es un edit realmente
			array_push($fields,"pk_proveedor");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_PROVEEDORES);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_proveedor"])>0){//es un edit realmente
			$id=$post["pk_proveedor"];
		}
		
		return $id;
	}
	
	function editProveedor($post,$file){
		return $this->addProveedor($post,$file);
	
	}
	
	function deleteProveedor($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_PROVEEDORES . " set fk_estatus=0 where pk_proveedor=" . $value);
			}
		return true;
	}
	function getProveedor($post='',$page=0,$results_per_page=999) {
		$sql = "select * from " . TBL_PROVEEDORES . " where fk_estatus>0";
		
		if(intval($post["pk_proveedor"])>0){
			$sql .= " and pk_proveedor=" . intval($post["pk_proveedor"]);
		}
		
		if(trim($post["proveedor"])!=''){
			$sql .= " and proveedor like '%" . $this->clearSql_S($post["proveedor"]) . "%'";
		}
		
		//echo $sql;
		return $this->Execute($sql,$results_per_page,$page);
	}
	
	
	function addFabricante($post,$file){
	
		$fields = array("fabricante","url"); 
		
		if(intval($post["pk_fabricante"])>0){//es un edit realmente
			array_push($fields,"pk_fabricante");
		}else{
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_FABRICANTES);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_fabricante"])>0){//es un edit realmente
			$id=$post["pk_fabricante"];
		}
		
		if(is_uploaded_file($file["imagen"]['tmp_name'])){	
			$path= SERVER_ROOT . "images/fabricantes/";
			$Media = new Media;		
			$Media->cropCenterImage($file["imagen"]["tmp_name"],236,120,$path . $id . ".jpg");
		}
		
		return $id;
	}
	
	function editFabricante($post,$file){
		return $this->addFabricante($post,$file);
	
	}
	
	function deleteFabricante($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_FABRICANTES . " set fk_estatus=0 where pk_fabricante=" . $value);
			}
		return true;
	}
	function getFabricante($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_FABRICANTES);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	function addCaracteristica($post,$file){
	
		$fields = array("caracteristica"); 
		
		if(intval($post["pk_caracteristica"])>0){//es un edit realmente
			array_push($fields,"pk_caracteristica");
		}else{
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_CARACTERISTICAS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_caracteristica"])>0){//es un edit realmente
			$id=$post["pk_caracteristica"];
		}
		
		if(is_uploaded_file($file["imagen"]['tmp_name'])){	
			$path= SERVER_ROOT . "images/caracteristicas/";
			$Media = new Media;		
			$Media->cropCenterImage($file["imagen"]["tmp_name"],80,80,$path . "car_" . $id . ".jpg");
		}
		
		return $id;
	}
	
	function editCaracteristica($post,$file){
		return $this->addCaracteristica($post,$file);
	
	}
	
	function deleteCaracteristica($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_CARACTERISTICAS . " set fk_estatus=0 where pk_caracteristica=" . $value);
			}
		return true;
	}
	function getCaracteristica($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_CARACTERISTICAS);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function addTalla($post,$file){
	
		$fields = array("talla"); 
		
		if(intval($post["pk_talla"])>0){//es un edit realmente
			array_push($fields,"pk_talla");
		}else{
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_TALLAS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_talla"])>0){//es un edit realmente
			$id=$post["pk_talla"];
		}
		
	
		
		return $id;
	}
	
	function editTalla($post,$file){
		return $this->addTalla($post,$file);
	
	}
	
	function deleteTalla($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_TALLAS . " set fk_estatus=0 where pk_talla=" . $value);
			}
		return true;
	}
	function getTalla($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_TALLAS);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	function getTallaByProducto($pk_producto){
		$sql= "select " . TBL_TALLAS . ".* from " .TBL_PRODUCTOS . " inner join " . TBL_PRODUCTOS_VS_TALLAS . " on " .TBL_PRODUCTOS . ".pk_producto=" . TBL_PRODUCTOS_VS_TALLAS . ".fk_producto inner join " . TBL_TALLAS . " on " .TBL_PRODUCTOS_VS_TALLAS . ".fk_talla=" . TBL_TALLAS . ".pk_talla where " . TBL_PRODUCTOS_VS_TALLAS . ".fk_estatus=1 and " . TBL_TALLAS . ".fk_estatus=1 and " . TBL_PRODUCTOS . ".fk_estatus=1 and " . TBL_PRODUCTOS . ".pk_producto=" . intval($pk_producto);
		return $this->Execute($sql);
	}                 
		
		
	function searchEmail($post){
		
		$sql = "select * from  " . TBL_USUARIOS . "  where lower(email)=lower('" . $this->clearSql_s($post["email"]) . "') and fk_estatus!=0";
		$r = $this->Execute($sql);
		if(sizeof($r["results"])==0 && trim($post["email"])!=''){
			return true;
		}else{
			return false;
		}
	}
	
	function addUsuario($post,$new=1){
        //var_dump($post);
		if($new==1 && !$this->searchEmail($post)){ //el email ya existe en ls db, quizas trataron de violar el JS
			return false;
		}
		
		$fields = array("email", "fk_banda_precios", "cedula_rif",	"nombres", "apellidos", "telefono1", "telefono2", "fax", "fk_pais", "fk_estado","fk_ciudad","direccion","proveniente","fk_usuario_tipo");
		
		if(isset($_SESSION["fk_pais_seleccionado"])){
				array_push($fields,"fk_pais_seleccionado")	;
				$post["fk_pais_seleccionado"]=$_SESSION["fk_pais_seleccionado"];
		}
		if(intval($post["pk_usuario"])>0){//es un edit realmente
			array_push($fields,"pk_usuario");
            array_push($fields,"fk_estatus"); //agregado por Luis Jiménez
		}else{
			//maldito utf8
			$post["nombres"] = utf8_decode($post["nombres"]);
			$post["apellidos"] = utf8_decode($post["apellidos"]);
			$post["telefono1"] = utf8_decode($post["telefono1"]);
			$post["telefono2"] = utf8_decode($post["telefono2"]);
			$post["direccion"] = utf8_decode($post["direccion"]);
			$post["proveniente"] = utf8_decode($post["proveniente"]);
			$post["fax"] = utf8_decode($post["fax"]);
			$post["cedula_rif"] = utf8_decode(strtoupper(trim($post["cedula_rif"]))); //modificado por Luis Jiménez
            $post["fk_usuario_tipo"]=$post["tblusu"]; //modificado por Luis Jiménez
            $post["pass_no_md5"] = utf8_decode($post['pass']);
			
			array_push($fields,"pass");
			array_push($fields,"tipo_persona");
			array_push($fields,"fecha_agregado");
			$post["pass"]=md5($post["pass"]);
			$post["fk_banda_precios"]=0;
			$post["fecha_agregado"]=date("Y/m/d H:i");            
		}
		$arrTemp= array("tabla" => TBL_USUARIOS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		$id = $this->addEdtTabla($arrTemp);
		
		
		
		if($post["pk_usuario"] > 0) 
			$id = $post["pk_usuario"]; 
		
		if($new==1){
			$this->sendActivation($post,$id);
		}
		
		return $id;
	}
	
	function activateMember($get){
		$pk_usuario = substr($get["usratc"],5,strlen($get["usratc"]));
		
		if( $get["key"] == md5(HASH . $pk_usuario)){
		    $sql = "update " . TBL_USUARIOS . " set fk_estatus=1,fecha_aprobacion='" . date("Y/m/d H:i:s") . "' where fk_estatus=2 and pk_usuario=" . intval($pk_usuario);

			$this->ExecuteAlone($sql);
			$this->login('',$pk_usuario);
			return $pk_usuario;
		}else{
			return false;
		}
	}	
    
    function tipoDePersona($pid){
        $retval = '';
        switch($pid)
        {
            case '1':  $retval = 'Cliente final'; break;
            case '2':  $retval = 'Distribuidor'; break;
            case '3':  $retval = 'Integrador'; break;
            case '4':  $retval = 'Adaptacion'; break;
            case '5':  $retval = 'Tecnico'; break;
            case '6':  $retval = 'Revendedor'; break;
            case '7':  $retval = 'Proveedor'; break;
        }
        return $retval;
    }        
	
	function sendActivation($arr,$id){
		$arreglovars=$arr;
        $arreglovars["tipoPersona"]=$this->tipoDePersona($arr["fk_usuario_tipo"]);
		$arreglovars["urlActivate"]="http://ecrs/" . "?module=activate&key=" . md5(HASH . $id) . "&usratc=" . rand(10000,99999) . $id . "&prt=". $_SESSION["fk_pais_seleccionado"];        
		if(trim($arr["fromurl"])!=''){
			$arreglovars["urlActivate"] .= "&fromurl=" . trim($arr["fromurl"]);
		}
		//$this->enviarFormMail("confirm_registro" . $_SESSION["LOCALE_IMG"] ,$arreglovars,_("Por favor visita este enlace para confirmar tu registro en ") . SITE_NAME,$arreglovars["email"]);
	    //$this->enviarFormMail("confirm_regusers" , $arreglovars, _("Hemos recibido su solicitud de registro en ") . SITE_NAME, $arreglovars["email"]);
        //$this->enviarFormMail("confirm_registro" . $_SESSION["LOCALE_IMG"] , $arreglovars, _("Se ha recibido una solicitud registro en ") . SITE_NAME, MAIL_PEDIDOS);
        
        $this->enviarFormMail($arreglovars['nombres']." ".$arreglovars['apellidos'],
                               $arreglovars['pass_no_md5'],
                               $arreglovars['email'],
                               $arreglovars['fk_usuario_tipo'],
                               $arreglovars["urlActivate"]);
		return true;
	}     
    
    function sendActivationNote($arr,$id){
        $arreglovars=$arr;
        $arreglovars["tipoPersona"]=$this->tipoDePersona($arr["fk_usuario_tipo"]);
        $arreglovars["urlActivate"]=WEB_ROOT . "?module=activate&key=" . md5(HASH . $id) . "&usratc=" . rand(10000,99999) . $id . "&prt=". $_SESSION["fk_pais_seleccionado"];        
        if(trim($arr["fromurl"])!=''){
            $arreglovars["urlActivate"] .= "&fromurl=" . trim($arr["fromurl"]);
        }
        //$this->enviarFormMail("confirm_registro" . $_SESSION["LOCALE_IMG"] ,$arreglovars,_("Por favor visita este enlace para confirmar tu registro en ") . SITE_NAME,$arreglovars["email"]);
        //$this->enviarFormMail("confirm_regusers" , $arreglovars, _("Hemos recibido su solicitud de registro en ") . SITE_NAME, $arreglovars["email"]);
        $this->enviarFormMail("confirm_registro" . $_SESSION["LOCALE_IMG"] , $arreglovars, _("Se ha recibido una solicitud registro en ") . SITE_NAME, MAIL_PEDIDOS);
        return true;
    }     

	
	function editUsuario($post){
		$this->addUsuario($post,0);
	}
	function forgotPasswordUsuario($post){
		unset($_SESSION["user"]);
		$sql = "select * from " . TBL_USUARIOS . " where email='" . $this->clearSql_s($post["email"]) . "' and (fk_estatus=1 or fk_estatus=3 or fk_estatus=4)";
		//var_dump($sql);
        
        		$rs=$this->Execute($sql);
		if(sizeof($rs["results"])==0){
			return false;
		}else{////aca le envio el pass al usuario
			$arreglovars = $rs["results"][0];
           // print_r($arreglovars);
			$arreglovars["new_pass"]=substr(md5(date("Y-n-d H:i:s~A") . rand(1,99999999)),0,6);
           // print_r($arreglovars);
			$sql="update " . TBL_USUARIOS . " set pass='" . md5($arreglovars["new_pass"]) . "' where pk_usuario=" . $arreglovars["pk_usuario"];
			$this->ExecuteAlone($sql);
            $nombre_usuario = $arreglovars["nombres"]." ".$arreglovars["apellidos"];
            $email = $arreglovars["email"];
            $pass_new = $arreglovars["new_pass"];
            $tipo_cliente = $arreglovars["fk_usuario_tipo"];
            //print_r($sql);
            //$tipo_cliente = '2';
		$salidaMail =$this->enviarFormMail($nombre_usuario,$pass_new,$email,$tipo_cliente,null);
       // print_r($salidaMail);
            
		}
		return true;
	}
	function login($post,$force=0){
		unset($_SESSION["user"]);
		if(strlen(trim($post["pass"]))!=32){
			$post["pass"] = md5($post["pass"]);	
		}
		
		if(intval($force)==0){
			$sql = "select * from " . TBL_USUARIOS . " where email='" . $this->clearSql_s($post["email"]) . "' and (fk_estatus=1 or fk_estatus=3 or fk_estatus=4)";
		}else{
			$sql = "select * from " . TBL_USUARIOS . " where pk_usuario=" . $this->clearSql_n($force) . " and (fk_estatus=1 or fk_estatus=3 or fk_estatus=4)";
		}
	
		$rs=$this->Execute($sql);
		
		if(sizeof($rs["results"])==0){ //el email no se encuentra
			return _("Email no registrado"); 
		}else{	//el email se encontro
			if($post["pass"]==$rs["results"][0]["pass"] || intval($force)!=0){// el password concuerda
				foreach($rs["results"][0] as $key => $value){ //levanto todos los datos del usuario en la session
					$_SESSION["user"][(string) $key]=$value;
				}
				$this->ExecuteAlone("update " . TBL_USUARIOS . " set login_count=login_count+1, fecha_lastlogin=now() where pk_usuario=" . $this->clearSql_n($_SESSION["user"]["pk_usuario"])); //actualizo la tabla del usuario
				return $_SESSION["user"]["fk_estatus"] == 3 ? 3 : 2;  //modificado por Luis Jiménez
			}else{ //el password NO concuerda
				return _("Contraseña errónea");
			}
		}
	}
	function changePassUsuario($post){
		if(intval($_SESSION["user"]["pk_usuario"])!=0){
			$sql = "select count(*) as total from " . TBL_USUARIOS. " where email='" . $this->clearSql_s($_SESSION["user"]["email"]) . "' and fk_estatus=1 and pass='" . md5($post["actual"]) . "' and pk_usuario=". intval($_SESSION["user"]["pk_usuario"]);
			$this->Execute($sql);
			if($this->GetField()==1){
				$this->ExecuteAlone("update " . TBL_USUARIOS. " set pass='" . md5($post["newpass1"]) . "' where pk_usuario=" . intval($_SESSION["user"]["pk_usuario"]));
				return 1;
			}else{
				return 2;
			}
		}else{
			exit;
		}
	}
	
	function addEdtDireccionesUsuario($post){
		$fields = array("fk_usuario", "fk_pais", "fk_estado", "fk_ciudad", "urbanizacion", "direccion","persona_contacto","telefono");
		if(intval($post["pk_direccion"])>0){//es un edit realmente
			array_push($fields,"pk_direccion");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_USUARIOS_DIRECCIONES);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_direccion"])>0){//es un edit realmente
			$id=$post["pk_direccion"];
		}
		
		return $id;
	
	}
	
	function getDireccionesUsuario($post,$results_per_page=9999,$page=0){
		$sql = "select " . TBL_USUARIOS_DIRECCIONES . ".*," . TBL_PAISES . ".pais," . TBL_ESTADOS . ".estado," . TBL_CIUDADES . ".ciudad from " . TBL_USUARIOS_DIRECCIONES . " left join " . TBL_PAISES . " on " . TBL_USUARIOS_DIRECCIONES . ".fk_pais=" . TBL_PAISES . ".pk_pais left join " . TBL_ESTADOS . " on " . TBL_USUARIOS_DIRECCIONES . ".fk_estado=" . TBL_ESTADOS . ".pk_estado left join " . TBL_CIUDADES . " on " . TBL_USUARIOS_DIRECCIONES . ".fk_ciudad=" . TBL_CIUDADES . ".pk_ciudad where " . TBL_USUARIOS_DIRECCIONES . ".fk_estatus>=1";
		if(intval($post["pk_direccion"])>0){
			$sql .=" and " . TBL_USUARIOS_DIRECCIONES . ".pk_direccion=" . intval($post["pk_direccion"]);
		}
		
		if(intval($post["fk_usuario"])>0){
			$sql .=" and " . TBL_USUARIOS_DIRECCIONES . ".fk_usuario=" . intval($post["fk_usuario"]);
		}
		if(intval($post["fk_estatus"])>0){
			$sql .=" and " . TBL_USUARIOS_DIRECCIONES . ".fk_estatus=" . intval($post["fk_estatus"]);
		}
		//echo $sql . "<br><br>";
		return $this->Execute($sql,$results_per_page,$page);
	}
	function delDireccionesUsuario($pk_direccion,$fk_usuario){
		$this->ExecuteAlone("update " . TBL_USUARIOS_DIRECCIONES . " set fk_estatus=0 where fk_estatus=1 and pk_direccion=" . intval($pk_direccion) . " and fk_usuario=". intval($fk_usuario));
		return true;
	}
	
	function busquedaUsuario($post,$results_per_page=9999,$page=0){
		$sql = "select " . TBL_USUARIOS . ".*," . TBL_PAISES . ".pais," . TBL_ESTADOS . ".estado, ". TBL_CIUDADES . ".ciudad," . TBL_USUARIOS_TIPO . ".tipo, if (" . TBL_USUARIOS . ".tipo_persona =1,'Natural','Juridica') as tipo_persona_txt from " . TBL_USUARIOS . " left join " . TBL_PAISES . " on " . TBL_USUARIOS . ".fk_pais=" . TBL_PAISES . ".pk_pais left join " . TBL_ESTADOS . " on " . TBL_USUARIOS . ".fk_estado=" . TBL_ESTADOS . ".pk_estado left join " . TBL_CIUDADES . " on " . TBL_USUARIOS . ".fk_ciudad=" . TBL_CIUDADES . ".pk_ciudad inner join " . TBL_USUARIOS_TIPO . " on  " . TBL_USUARIOS_TIPO . ".pk_usuario_tipo=" . TBL_USUARIOS . ".fk_usuario_tipo  where " . TBL_USUARIOS  . ".fk_estatus>=0";
		
		if(intval($post["pk_usuario"])!=0){
			$sql .= " and " . TBL_USUARIOS  . ".pk_usuario=" .intval($post["pk_usuario"]);
		}
		if(intval($post["fk_usuario_tipo"])!=0){
			$sql .= " and " . TBL_USUARIOS  . ".fk_usuario_tipo=" .intval($post["fk_usuario_tipo"]);
		}
		
		if(intval($post["fk_pais"])!=0){
			$sql .= " and " . TBL_USUARIOS  . ".fk_pais=" .intval($post["fk_pais"]);
		}
		if(intval($post["fk_estado"])!=0){
			$sql .= " and " . TBL_USUARIOS  . ".fk_estado=" .intval($post["fk_estado"]);
		}
		if(intval($post["fk_ciudad"])!=0){
			$sql .= " and " . TBL_USUARIOS  . ".fk_ciudad=" .intval($post["fk_ciudad"]);
		}
		if(intval($post["tipo_persona"])!=0){
			$sql .= " and " . TBL_USUARIOS  . ".tipo_persona=" .intval($post["tipo_persona"]);
		}
		
		if(trim($post["email"])!=''){
			$sql .= " and " . TBL_USUARIOS  . ".email like '%" . $this->clearSql_s($post["email"]) . "%'";
		}
		if(trim($post["nomape"])!=''){
			$arr = split(" ",$post["nomape"] . " ");
			foreach($arr as $key =>$value){
				if(trim($value)!=''){
					$sql .= " and (" . TBL_USUARIOS  . ".nombres like '%" . $this->clearSql_s(trim($value)) . "%' or " . TBL_USUARIOS  . ".apellidos like '%" . $this->clearSql_s(trim($value)) . "%')";
				}
			}
			
		}
		
		if(trim($post["nombres"])!=''){
			$sql .= " and " . TBL_USUARIOS  . ".nombres like '%" . $this->clearSql_s($post["nombres"]) . "%'";
		}
		if(trim($post["apellidos"])!=''){
			$sql .= " and " . TBL_USUARIOS  . ".apellidos like '%" . $this->clearSql_s($post["apellidos"]) . "%'";
		}
		if(trim($post["cedula_rif"])!=''){
			$sql .= " and " . TBL_USUARIOS  . ".cedula_rif like '%" . $this->clearSql_s($post["cedula_rif"]) . "%'";
		}
		
		if(isset($post["fecha_inia"]) && strtotime($post["fecha_inia"])>0 && strtotime($post["fecha_fina"])>0){
			$sql .= " and " . TBL_USUARIOS  . ".fecha_agregado>='" . $this->clearSql_f($post["fecha_inia"]) . " 00:00:00' and " . TBL_USUARIOS  . ".fecha_agregado<='" . $this->clearSql_f($post["fecha_fina"]) . " 23:59:59'";
		}
		
		$sql .=" order by fecha_agregado desc";
//echo $sql;
//exit;
		return $this->Execute($sql,$results_per_page,$page);
		
		
	}
	
	function addTicket($post,$session=''){
		if(intval($post["fk_usuario"])==0){
			$post["fk_usuario"]=$session["user"]["pk_usuario"];
		}
		//var_dump($post);
		$fields = array("fk_usuario", "fecha_last_request");
		
		if(isset($post["fk_ticket_estado"])){
			array_push($fields,"fk_ticket_estado");
		}
		
		if(isset($post["fk_pk_relacionado"])){
			array_push($fields,"fk_pk_relacionado");
		}
		
		if(isset($post["fk_ticket_tipo"])){
			array_push($fields,"fk_ticket_tipo");
		}
		
		if(isset($post["asunto"])){
			array_push($fields,"asunto");
		}
		
		if(intval($post["pk_ticket"])>0){//es un edit realmente
			array_push($fields,"pk_ticket");
		}else{
			array_push($fields,"fecha_apertura");
			$post["fecha_apertura"]=date("Y/m/d H:i");
		}
		
		
		
		$post["fecha_last_request"]=date("Y-m-d H:i");
		
		$arrTemp= array("tabla" => TBL_TICKETS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_ticket"])>0){//es un edit realmente
			$id=$post["pk_ticket"];
		}
		
		if(trim($post["texto"])!=''){ //agrego el nuevo detalle de ticket
			$sql = "insert into " . TBL_TICKETS_DETALLE . " (fk_ticket, fecha, fk_administrador, texto) values (" . $id . ",now()," . intval($session["administrator"]["pk_administrador"]) . ",'" . $this->clearSql_S($post["texto"]) . "')";
			$this->ExecuteAlone($sql);
		}
		
		if(intval($post["fk_ticket_estado"])!=intval($post["fk_ticket_estado_old"])){ //esta cambiando de estatus
			if(intval($session["administrator"]["pk_administrador"])!=0){ //busco el nomrbe del admin
				$rs = $this->Execute("select nombres from " . TBL_ADMINISTRADORES . " where pk_administrador=" . intval($session["administrator"]["pk_administrador"]));
				$str = $rs["results"][0][0];
			}else{ //busco el nombre del cliente
				$rs = $this->Execute("select nombres from " . TBL_USURIOS . " where pk_usuario=" . intval($post["fk_usuario"]));
				$str = $rs["results"][0][0];
			}
			
			$rs = $this->Execute("select estado from " . TBL_TICKETS_ESTADOS . " where pk_ticket_estado=" . intval($post["fk_ticket_estado_old"]));
			
			$str .= " cambió el estatus de " . $rs["results"][0][0];
			
			$rs = $this->Execute("select estado from " . TBL_TICKETS_ESTADOS . " where pk_ticket_estado=" . intval($post["fk_ticket_estado"]));
			
			$str .= " a " . $rs["results"][0][0];
			
			$sql = "insert into " . TBL_TICKETS_DETALLE . " (fk_ticket, fecha, fk_administrador, texto) values (" . $id . ",now()," . intval($session["administrator"]["pk_administrador"]) . ",'" . $this->clearSql_S($str) . "')";
			$this->ExecuteAlone($sql);
		}
		if(intval($session["administrator"]["pk_administrador"])!=0){
			$this->sendTicketByMail($id,0,$post["tipo_respuesta"]);
		}else{
			$this->sendTicketByMail($id,1,$post["tipo_respuesta"]);
		}
		return $id;
		
	}
	
	function editTicket($post,$session=''){
		return $this->addTicket($post,$session);
	}
	
	function busquedaTicket($post,$results_per_page=9999,$page=0){
		$sql = "select " . TBL_TICKETS  . ".*," . TBL_TICKETS_ESTADOS . ".estado," . TBL_TICKETS_TIPO . ".tipo," . TBL_USUARIOS . ".nombres," . TBL_USUARIOS . ".apellidos," . TBL_USUARIOS . ".email from " . TBL_TICKETS . " inner join " . TBL_USUARIOS . " on " . TBL_TICKETS . ".fk_usuario=" . TBL_USUARIOS . ".pk_usuario inner join " . TBL_TICKETS_ESTADOS . " on " . TBL_TICKETS  . ".fk_ticket_estado=" . TBL_TICKETS_ESTADOS . ".pk_ticket_estado inner join " . TBL_TICKETS_TIPO . " on " . TBL_TICKETS  . ".fk_ticket_tipo=" . TBL_TICKETS_TIPO . ".pk_ticket_tipo where " . TBL_TICKETS  . ".fk_estatus>0";
		
		unset($post["page"]);
		unset($post["module"]);
		unset($post["Submit"]);
		
		if(trim($post["cliente"])!=''){
			$keywords = split(" ",trim($post["cliente"]) . " ");
			$sql .=" and (";
			foreach($keywords as $key => $value){
				if(trim($value)!=''){
					$sql .= "(" . TBL_USUARIOS . ".nombres like '%" . $this->clearSql_s($value) . "%' or " . TBL_USUARIOS . ".apellidos like '%" . $this->clearSql_s($value) . "%') or" ;
				}
			}
			$sql = substr($sql,0,strlen($sql)-2) . ")";
		}
		
		unset($post["cliente"]);
		
		if(isset($post["fecha_inia"])>0 && isset($post["fecha_fina"])>0){
			$sql .= " and " . TBL_TICKETS . ".fecha_apertura>='" . $this->clearSql_f($post["fecha_inia"]) . " 00:00:00' and " . TBL_TICKETS . ".fecha_apertura<='" . $this->clearSql_f($post["fecha_fina"]) . " 23:59:59'";
			
		}
		unset($post["fecha_inia"]);
		unset($post["fecha_fina"]);
		
		if(isset($post["fecha_iniu"])>0 && isset($post["fecha_finu"])>0){
			$sql .= " and " . TBL_TICKETS . ".fecha_last_request>='" . $this->clearSql_f($post["fecha_iniu"]) . " 00:00:00' and " . TBL_TICKETS . ".fecha_last_request<='" . $this->clearSql_f($post["fecha_finu"]) . " 23:59:59'";
			
		}
		unset($post["fecha_iniu"]);
		unset($post["fecha_finu"]);
		
		if(intval($post["fk_ticket_tipo"])!=0){
			$sql .= " and " . TBL_TICKETS . ".fk_ticket_tipo=" . intval($post["fk_ticket_tipo"]);
		}
		unset($post["fk_ticket_tipo"]);
		
		if(intval($post["fk_ticket_estado"])!=0){
			$sql .= " and " . TBL_TICKETS . ".fk_ticket_estado=" . intval($post["fk_ticket_estado"]);
		}
		unset($post["fk_ticket_estado"]);
		
		$sql .= $this->prepareSqlVars($post);
		
		//echo $sql;
		
		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function getTicketHistorico($pk_ticket){
		$sql = "select " . TBL_TICKETS_DETALLE . ".*," . TBL_ADMINISTRADORES . ".nombres from " . TBL_TICKETS_DETALLE . " left join " . TBL_ADMINISTRADORES . " on " . TBL_TICKETS_DETALLE . ".fk_administrador=" . TBL_ADMINISTRADORES . ".pk_administrador where " . TBL_TICKETS_DETALLE . ".fk_ticket=" . intval($pk_ticket) . " order by fecha asc";
		$rs = $this->Execute($sql);
		foreach($rs["results"] as $key => $value){
			if($value["fk_administrador"]==0){
				if(!isset($cliname)){
					$sql ="select " . TBL_USUARIOS . ".nombres from " . TBL_USUARIOS . " inner join " . TBL_TICKETS . " on " . TBL_USUARIOS . ".pk_usuario=" . TBL_TICKETS . ".fk_usuario where " . TBL_TICKETS . ".pk_ticket=" . intval($pk_ticket);
				
					$rs2 = $this->Execute($sql);
					$cliname=$rs2["results"][0][0];
					//echo $cliname;
				}
				$rs["results"][$key]["nombres"]=$cliname;
			}
		}
		return $rs;
	}
	
	function sendTicketByMail($pk_ticket,$via=0,$tipo_respuesta=0){
		$ticket = $this->busquedaTicket(array(
				"pk_ticket"=>$pk_ticket,
				));
				
		
		$historico = $this->getTicketHistorico($pk_ticket);
		
		//foreach($historico["results"] as $key => $value){ 
		for($a=sizeof($historico["results"])-1;$a>=0;$a--){
		   $value = $historico["results"][$a];
		   
           $historicoTxt .= '<tr><td><strong>' . date("d/m/Y H:i",strtotime($value["fecha"])) .'</strong><br /><span class="t1">' . $value["nombres"] . '</span><br />';
			if(sizeof($historico["results"])-1==$a){
		   		$historicoTxt .='<span style="color:#FF0000">' . nl2br($value["texto"]) . '</span>';
			}else{
				$historicoTxt .= nl2br($value["texto"]);
			}
		   
		   $historicoTxt .= '<p class="titulorojo_destacado">&nbsp;</p></td></tr>';
        } 


		$arreglovars = $ticket["results"][0];
		$arreglovars["pk_ticket"] = sprintf("%05d",$pk_ticket);
		
		$arreglovars["fecha_apertura"]=date("d/m/Y",strtotime($ticket["results"][0]["fecha_apertura"]));
		$arreglovars["fecha_last_request"]=date("d/m/Y",strtotime($ticket["results"][0]["fecha_last_request"]));
		
		if($tipo_respuesta==1){
			$subject = _("Notificación de pago / ");
		}else{
			$subject = _("Sobre la comunicación #") . sprintf("%05d",$pk_ticket) . _(" en ") . SITE_NAME;
		}
		
		if($via==0){
			$arreglovars["urlActivate"] = WEB_ROOT . "?module=account_tickets_details&i=" . md5(HASH . $pk_ticket) . $pk_ticket . "&flog=" . md5(HASH . $arreglovars["fk_usuario"]) . $arreglovars["fk_usuario"];
			$arreglovars["historico"]='<tr><td><span style="color:#FF0000"><strong><br />' . _("Usted ha recibido una respuesta sobre su compra, para visualizarla presione sobre el siguiente link") . ': <a href="' . $arreglovars["urlActivate"] . '">' . $arreglovars["urlActivate"] . '</a><br /></strong></span></td></tr>';
			
			$this->enviarFormMail("ticket",$arreglovars,$subject,$arreglovars["email"]);
		}else{
			$arreglovars["urlActivate"] = WEB_ROOT . "/admin/?module=ticket_detail&i=" . $pk_ticket;
			$arreglovars["historico"]=$historicoTxt;
			$this->enviarFormMail("ticket",$arreglovars,$subject,MAIL_PEDIDOS);
		}
		 
	}
	
	function convertMoneda($valor,$session){
		//if($session["moneda"]==1){
		//	$valor = $valor/1000;
		//	$prefijo = "Bs.F. ";
		//}else{
		//	$prefijo = "Bs. ";
		//}
		if(intval($session["fk_pais_seleccionado"])==0){
			$prefijo = "Bs.F.:";
		}elseif(intval($session["fk_pais_seleccionado"])==1){
			$prefijo = "COP$ ";
		}else{
			$prefijo = "USD$ ";
		}
		return $prefijo . number_format($valor, 2, ',', '.');
	}
	
	function calculaSeguro($valor){
		return ($valor * 3) / 100;
	}
	
	function manageCart($post,$get){
	
		if(isset($get["ctr"])){ //lo esta agregando via link
			$pk_pro = substr($get["ctr"],32,strlen($get["ctr"]));
			
			$variantes = $get["v"];
			
			if(is_array($variantes)){
				sort($variantes,SORT_NUMERIC);
			}else{
				$variantes = array();
			}
		
		
			if(md5(HASH . $pk_pro) == substr($get["ctr"],0,32)){
			
				$uniqueProducto = md5(HASH . implode(",", $variantes) . $pk_pro);
				$_SESSION["cart"]["products"][$uniqueProducto]["uniqueProducto"]=$uniqueProducto;
				$_SESSION["cart"]["products"][$uniqueProducto]["qty"]=1;
				$_SESSION["cart"]["products"][$uniqueProducto]["pk_producto"]=$pk_pro;
				$_SESSION["cart"]["products"][$uniqueProducto]["variantes"]=$variantes;

			}else{
				die("Ocurrio un error:  #32498");
			}
		}
		if(isset($get["del"])){ //lo esta eliminando via link
			unset($_SESSION["cart"]["products"][$get["del"]]);
		}
		
		if(sizeof($post)>0){
			foreach($post as $key => $value){
				$uniqueProducto = substr($key,2,32);
				if(intval($value)<=0){
					unset($_SESSION["cart"]["products"][$uniqueProducto]);
				}else{
					$_SESSION["cart"]["products"][$uniqueProducto]["qty"]=intval($value);
				}
			}
		}
	}
	
	function getCart($session){
		if(sizeof($session["cart"]["products"])>0){
			foreach($session["cart"]["products"] as $key => $value){
				$rs = $this->getProducto(array("pk_producto" => $value["pk_producto"]));
				if(sizeof($rs["results"])>0){
					$arrtmp[]=array_merge($rs["results"][0],$session["cart"]["products"][$key]);
				}else{
					unset($_SESSION["cart"]["products"][$key]);
				}
			}
		}
		return $arrtmp;
	}
	
	function saveCartOrder($session){
		$cart = $this->getCart($session);
		
		$p_banda = intval($session["user"]["fk_banda_precios"]);
		$p_pais = intval($session["fk_pais_seleccionado"]);
		$p_precio =  $p_pais . $p_banda;
		
		if(sizeof($cart)>0 && intval($session["cart"]["billaddr"])>0 && intval($session["cart"]["shipaddr"])>0 && intval($session["user"]["pk_usuario"])>0){
			$pk_orden= $this->ExecuteAlone("insert into " . TBL_ORDENES . " (fk_usuario, fecha, pk_direccion_ship, pk_direccion_bill,fk_moneda,fk_banda) values (" . intval($session["user"]["pk_usuario"]) . ",now()," . intval($session["cart"]["shipaddr"]) . "," . intval($session["cart"]["billaddr"]) . "," . $p_pais . "," . $p_banda . ")");
			foreach($cart as $key => $value){
				$pk_orden_detalle = $this->ExecuteAlone("insert into " . TBL_ORDENES_DETALLE . " (fk_orden, fk_producto, cantidad, precio) values (" . $pk_orden . "," . $value["pk_producto"]. "," . $value["qty"] . "," . $value["precio" . $p_precio] . ")");
				
				foreach($value["variantes"] as $kvar => $vvars){
					$this->ExecuteAlone("insert into " . TBL_ORDENES_DETALLE_VARIANTE . " (fk_orden_detalle,fk_variante_tipo) values (" . $pk_orden_detalle  . "," . $this->clearSql_n($vvars) . ")");
				}
			}
			$this->ExecuteAlone("update " . TBL_USUARIOS_DIRECCIONES . " set fk_estatus=2 where pk_direccion=" . intval($session["cart"]["billaddr"]) . " or pk_direccion=" . intval($session["cart"]["shipaddr"]));
			return $pk_orden;			
		}else{
			return false;
		}
	
	}
	
	function searchOrders($vars,$results_per_page=10,$page=0){
		$sql .= "select " . TBL_ORDENES . ".*," . TBL_USUARIOS . ".*," . TBL_ORDENES_ESTADO . ".estatus," . TBL_ADMINISTRADORES . ".nombres as A_nombres from " . TBL_ORDENES . " inner join " . TBL_ORDENES_ESTADO . " on " . TBL_ORDENES . ".fk_orden_estado=" . TBL_ORDENES_ESTADO . ".pk_orden_estado inner join " . TBL_USUARIOS . " on " . TBL_ORDENES . ".fk_usuario=" . TBL_USUARIOS . ".pk_usuario left join " . TBL_ADMINISTRADORES . " on " . TBL_ORDENES . ".fk_administrador=" . TBL_ADMINISTRADORES . ".pk_administrador where " . TBL_ORDENES . ".fk_estatus>0 ";
		
		if(trim($vars["cliente"])!=''){
			$keywords = split(" ",trim($vars["cliente"]) . " ");
			$sql .=" and (";
			foreach($keywords as $key => $value){
				if(trim($value)!=''){
					$sql .= "(" . TBL_USUARIOS . ".nombres like '%" . $this->clearSql_s($value) . "%' or " . TBL_USUARIOS . ".apellidos like '%" . $this->clearSql_s($value) . "%' or " . TBL_USUARIOS . ".cedula_rif like '%" . $this->clearSql_s($value) . "%') or" ;
				}
			}
			$sql = substr($sql,0,strlen($sql)-2) . ")";
		}
		
		
		
		if(is_array($vars["fk_administrador"])){
			$sql .= " and (";
			foreach($vars["fk_administrador"] as $key=>$value){
				$sql .= "fk_administrador='" . $this->clearSql_n($value) ."' or ";
			}
			$sql = substr($sql,0,strlen($sql)-3) .")";
		}
		if(is_array($vars["fk_orden_estado"])){
			$sql .= " and (";
			foreach($vars["fk_orden_estado"] as $key=>$value){
				$sql .= "fk_orden_estado='" . $this->clearSql_n($value) ."' or ";
			}
			$sql = substr($sql,0,strlen($sql)-3) .")";
		}
		if(isset($vars["fecha_inia"]) && strtotime($vars["fecha_inia"])>0 && strtotime($vars["fecha_fina"])>0){
			$sql .= " and " . TBL_ORDENES  . ".fecha>='" . $this->clearSql_f($vars["fecha_inia"]) . " 00:00:00' and " . TBL_ORDENES  . ".fecha<='" . $this->clearSql_f($vars["fecha_fina"]) . " 23:59:59'";
		}
		
		$sql .= " order by pk_orden desc";
		
		//echo $sql;
		
		return $this->Execute($sql,$results_per_page,$page);
		
	}
	
	function getOrders($vars,$results_per_page=10,$page=0){
		$sql .= "select " . TBL_ORDENES . ".*," . TBL_USUARIOS . ".*," . TBL_ORDENES_ESTADO . ".estatus," . TBL_ADMINISTRADORES . ".nombres as A_nombres from " . TBL_ORDENES . " inner join " . TBL_ORDENES_ESTADO . " on " . TBL_ORDENES . ".fk_orden_estado=" . TBL_ORDENES_ESTADO . ".pk_orden_estado inner join " . TBL_USUARIOS . " on " . TBL_ORDENES . ".fk_usuario=" . TBL_USUARIOS . ".pk_usuario left join " . TBL_ADMINISTRADORES . " on " . TBL_ORDENES . ".fk_administrador=" . TBL_ADMINISTRADORES . ".pk_administrador where " . TBL_ORDENES . ".fk_estatus>0 ";
		
		$sql .= $this->prepareSqlVars($vars);

		return $this->Execute($sql,$results_per_page,$page);
	}
	function getOrdersProducts($vars){
		$sql="select " . TBL_ORDENES_DETALLE . ".*," . TBL_PRODUCTOS . ".sku," . TBL_PRODUCTOS . ".nombre from " . TBL_ORDENES_DETALLE . " inner join " . TBL_PRODUCTOS . " on " . TBL_ORDENES_DETALLE . ".fk_producto=" . TBL_PRODUCTOS . ".pk_producto where " . TBL_ORDENES_DETALLE . ".fk_estatus>0 ";
		
		$sql .= $this->prepareSqlVars($vars);
		
		//echo $sql;
		return $this->Execute($sql);
	}
	
	function getOrdersProductsVariantes($vars){
	
		$sql = "select " .TBL_VARIANTES . ".*," .  TBL_VARIANTES_TIPO . ".* from " . TBL_ORDENES_DETALLE_VARIANTE . " inner join " . TBL_ORDENES_DETALLE . " on " . TBL_ORDENES_DETALLE_VARIANTE . ".fk_orden_detalle=" . TBL_ORDENES_DETALLE . ".pk_orden_detalle inner join " . TBL_VARIANTES_TIPO . " on " . TBL_VARIANTES_TIPO . ".pk_variante_tipo=" . TBL_ORDENES_DETALLE_VARIANTE . ".fk_variante_tipo inner join " . TBL_VARIANTES . " on " . TBL_VARIANTES . ".pk_variante=" . TBL_VARIANTES_TIPO . ".fk_variante where " . TBL_ORDENES_DETALLE_VARIANTE . ".fk_estatus>0 "; 
		
		$sql .= $this->prepareSqlVars($vars);
		
		//echo $sql . "<hr>";
		return $this->Execute($sql);
	}
	
	function editOrder($post,$session){
	//var_dump($post);
		//$fields = array("observaciones"); 
		$fields = array(); 
		
		if(intval($post["pk_orden"])>0){//es un edit realmente
			array_push($fields,"pk_orden");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		
		if(isset($post["fk_modo_pago"])){
			array_push($fields,"fk_modo_pago");
		}
		
		if(isset($post["fk_activate_tpv"])){
			array_push($fields,"fk_activate_tpv");
		}

		if(isset($post["fk_orden_estado"])){
			array_push($fields,"fk_orden_estado");
		}
		if(isset($post["fk_administrador"])){
			array_push($fields,"fk_administrador");
		}
		
		if(isset($post["factura"])){
			array_push($fields,"factura");
		}
		$arrTemp= array("tabla" => TBL_ORDENES);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_orden"])>0){//es un edit realmente
			$id=intval($post["pk_orden"]);
		}
		
		if(isset($post["ajax"]) && intval($post["ajax"])==1){ //se modificaron los productos
			$observaciones .= "El: <strong>" . date("d/m/Y H:i") ." " . $session["administrator"]["nombres"] . "</strong>:</span>\nModific&oacute; productos de este pedido" . "\n";
			$this->ExecuteAlone("update " . TBL_ORDENES_DETALLE . " set fk_estatus=0 where fk_orden=" . $id);
			if(is_array($post["fk_producto"]))
				foreach($post["fk_producto"] as $key => $value){
						$this->ExecuteAlone("insert into " . TBL_ORDENES_DETALLE . " (fk_orden, fk_producto, cantidad, precio) values (" . $id ."," . $value . "," . intval($post["cantidad"][$key]) . ",'" . $this->clearSql_n($post["precio"][$key]) . "')");
				}
		}
		
		if(intval($post["fk_orden_estado"])!=intval($post["fk_orden_estado_act"])){
			$observaciones .= "El: <strong>" . date("d/m/Y H:i") ." " . $session["administrator"]["nombres"] . "</strong>:\nCambi&oacute; el estatus de este pedido" . "\n";
		}
		if(trim($post["observaciones"])!=''){
			$observaciones .= "El: <strong>" . date("d/m/Y H:i") ." " . $session["administrator"]["nombres"] . "</strong>:\n" . trim($post["observaciones"]) . "\n";
			
		}
		
		if(trim($observaciones)!=''){
			$rs = $this->Execute("select observaciones from " . TBL_ORDENES . " where pk_orden=" . $id);
			$observaciones .= trim($rs["results"][0]["observaciones"]);
			$sql = "update " . TBL_ORDENES . " set observaciones = '" .  $this->clearSql_s($observaciones) . "' where pk_orden=" . $id;
			$this->ExecuteAlone($sql);
			
			//echo $sql;
		}
		return true;
	
	}
	
	function addArticulo($post,$file){
	
		$fields = array("titulo","fk_articulo_tipo","sumario","descripcion"); 
		
		if(intval($post["pk_articulo"])>0){//es un edit realmente
			array_push($fields,"pk_articulo");
			array_push($fields,"fecha_modificado");
			$post["fecha_modificado"]=date("Y/m/d H:i");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_ARTICULOS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_articulo"])>0){//es un edit realmente
			$id=$post["pk_articulo"];
		}
		
		if(is_uploaded_file($file["imagen"]['tmp_name'])){	
			$path= SERVER_ROOT . "images/articulos/";
			$Media = new Media;	
			@unlink($path . "tb_" . $id . ".jpg");
			$Media->cropCenterImage($file["imagen"]["tmp_name"],105,80,$path . "tb_" . $id . ".jpg");
		}
		
		$Aggregator = new Aggregator();
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_ARTICULOS_VS_CATEGORIAS,"fk"=>"fk_articulo","fk2"=>"fk_categoria","id"=>$id));
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_ARTICULOS_VS_PRODUCTOS,"fk"=>"fk_articulo","fk2"=>"fk_producto","id"=>$id));
		
		
		return $id;
	}
	
	function editArticulo($post,$file){
		return $this->addArticulo($post,$file);
	
	}
	
	function deleteArticulo($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_ARTICULOS . " set fk_estatus=0 where pk_articulo=" . $value);
			}
		return true;
	}
	function getArticulo($post='',$page=0,$results_per_page=999) {
	
		$sql = "select * from " . TBL_ARTICULOS . " left join " . TBL_ARTICULOS_VS_CATEGORIAS . " on " . TBL_ARTICULOS . ".pk_articulo=" . TBL_ARTICULOS_VS_CATEGORIAS . ".fk_articulo left join " . TBL_ARTICULOS_VS_PRODUCTOS . " on " . TBL_ARTICULOS . ".pk_articulo=" . TBL_ARTICULOS_VS_PRODUCTOS . ".fk_articulo where " . TBL_ARTICULOS . ".fk_estatus>0 ";
		
		if(intval($post["pk_articulo"])>0){
			$sql .= " and " . TBL_ARTICULOS . ".pk_articulo=" . intval($post["pk_articulo"]);
		}
		
		if(intval($post["fk_producto"])>0){
			$sql .= " and " . TBL_ARTICULOS_VS_PRODUCTOS . ".fk_estatus>0 and " . TBL_ARTICULOS_VS_PRODUCTOS . ".fk_producto=" . intval($post["fk_producto"]);
		}
		
		if(intval($post["fk_categoria"])>0){
			$sql .= " and " . TBL_ARTICULOS_VS_CATEGORIAS . ".fk_estatus>0 and " . TBL_ARTICULOS_VS_CATEGORIAS . ".fk_categoria=" . intval($post["fk_categoria"]);
		}
		
		if(intval($post["fk_articulo_tipo"])>0){
			$sql .= " and " . TBL_ARTICULOS . ".fk_articulo_tipo=" . intval($post["fk_articulo_tipo"]);
		}
		
		$sql .= " group by " . TBL_ARTICULOS . ".pk_articulo  order by " . TBL_ARTICULOS . ".pk_articulo desc";

		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function crediMercantil($monto){
		$total = ($monto * 29.50) / 100;
		$total +=  $monto;
		$cuotas = $total/36;
		return $cuotas;
	}
	
	function generarSiteMap(){
		$str='<?xml version=\'1.0\' encoding=\'UTF-8\'?>
		<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		
		$str.='<url><loc>' . WEB_ROOT . '</loc><changefreq>daily</changefreq><priority>1</priority></url>';
	
		$rs = $this->Execute("select * from " . TBL_PRODUCTOS . " where fk_estatus>0 order by pk_producto asc");
		foreach($rs["results"] as $key => $value){
			$str.='<url><loc>' . WEB_ROOT . '?module=product_detail&amp;pro=' . md5( HASH . $value["pk_producto"]) . $value["pk_producto"]. '</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
		}
		
		$rs = $this->Execute("select * from " . TBL_CATEGORIAS . " where fk_estatus>0");
		
		foreach($rs["results"] as $key => $value){
			$str.='<url><loc>' . WEB_ROOT . '?module=categoria&pkcat=' . $value["pk_categoria"] .'&amp;pkcatp=' . $value["fk_categoria_padre"]. '</loc><changefreq>daily</changefreq><priority>0.5</priority></url>';
		}
		
		
		$str.='</urlset>';
		$fp = @fopen(SERVER_ROOT .'sitemap.xml', 'w');
		if($fp){
			fwrite($fp, $str);
			fclose($fp);
		}
		return true;
	}
	
	function getTPV_Mercantil($post,$results_per_page=10,$page=0){
		$sql = "select * from " . TBL_TPV_MERCANTIL . " where fk_estatus>0 ";
		
		$sql .= $this->prepareSqlVars($post);

		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function getVariantes($vars='',$results_per_page=9999,$page=0){
		$sql .= "select * from " . TBL_VARIANTES . " where " . TBL_VARIANTES . ".fk_estatus>0 ";
		
		$sql .= $this->prepareSqlVars($vars);

		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function getVariantesTipo($vars,$results_per_page=9999,$page=0){
		$sql .= "select " .TBL_VARIANTES . ".*," .  TBL_VARIANTES_TIPO . ".* from " . TBL_VARIANTES . " inner join " .  TBL_VARIANTES_TIPO . " on " .  TBL_VARIANTES . ".pk_variante=" .  TBL_VARIANTES_TIPO . ".fk_variante  where " . TBL_VARIANTES . ".fk_estatus>0 and  " .  TBL_VARIANTES_TIPO . ".fk_estatus>0 ";
		
		$sql .= $this->prepareSqlVars($vars);

		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function getVariantesTipoByProducto($vars,$results_per_page=9999,$page=0){
		$sql .= "select " .TBL_VARIANTES . ".*," .  TBL_VARIANTES_TIPO . ".* from " . TBL_VARIANTES . " inner join " .  TBL_VARIANTES_TIPO . " on " .  TBL_VARIANTES . ".pk_variante=" .  TBL_VARIANTES_TIPO . ".fk_variante inner join " . TBL_PRODUCTOS_VS_VARIANTES_TIPO . " on " . TBL_PRODUCTOS_VS_VARIANTES_TIPO . ".fk_variante_tipo=" .  TBL_VARIANTES_TIPO . ".pk_variante_tipo  where " . TBL_VARIANTES . ".fk_estatus>0 and  " .  TBL_VARIANTES_TIPO . ".fk_estatus>0 and  " . TBL_PRODUCTOS_VS_VARIANTES_TIPO . ".fk_estatus>0 ";
		
		$sql .= $this->prepareSqlVars($vars);
	

		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function addEncuesta($post){
		$fields = array("pregunta","pregunta_en","disponible_0","disponible_1","disponible_2","disponible_3","fk_destacado"); 
		
		if(intval($post["pk_encuesta"])>0){//es un edit realmente
			array_push($fields,"pk_encuesta");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_ENCUESTAS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_encuesta"])>0){//es un edit realmente
			$id=$post["pk_encuesta"];
		}
		
		$this->executeAlone("update " . TBL_ENCUESTAS_RESPUESTAS . " set fk_estatus=0 where fk_encuesta=" . $id);
		foreach($post as $key => $value){
			if(substr($key,0,10)=='respuesta_'){
				$cadenaIdentificadora =  substr($key,10,strlen($key));
				if(intval(substr($key,10,1))>0){
					$sql = "update " . TBL_ENCUESTAS_RESPUESTAS . " set respuesta='" . $this->clearSql_S($value) . "',respuesta_en='" . $this->clearSql_S($post["respuestaen_"  . $cadenaIdentificadora]) . "', votos='" . intval($post["votos_" . $cadenaIdentificadora]) . "', fk_estatus=1 where pk_encuesta_respuesta=" . intval($cadenaIdentificadora);
				}else{
					$sql = "insert into " . TBL_ENCUESTAS_RESPUESTAS . " (fk_encuesta,respuesta,respuesta_en,votos) values (" . intval($id) . ",'" . $this->clearSql_S($value) . "','" . $this->clearSql_S($post["respuestaen_"  . $cadenaIdentificadora]) . "','" . intval($post["votos_" . $cadenaIdentificadora]) . "')";
				}
				$this->ExecuteAlone($sql);
			}
		}
		
		if(intval($post["fk_destacado"])>0){
			//$this->ExecuteAlone("update " . TBL_ENCUESTAS . " set fk_destacado=0");
			$this->ExecuteAlone("update " . TBL_ENCUESTAS . " set fk_destacado=" .  intval($post["fk_destacado"]) . " where pk_encuesta=" . $id);
		}
		
		return $id;
	}
	
	function editEncuesta($post){
		return $this->addEncuesta($post,$file);
	
	}
	
	function deleteEncuesta($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_ENCUESTAS . " set fk_estatus=0 where pk_encuesta=" . $value);
			}
		return true;
	}
	
	function getEncuesta($post='',$page=0,$results_per_page=10) {
		$sql = "select * from " . TBL_ENCUESTAS . " where fk_estatus>0";
		if(intval($post["pk_encuesta"])>0){
			$sql .= " and pk_encuesta=" . intval($post["pk_encuesta"]);
		}
		
		if(intval($post["fk_destacado"])>0){
			$sql .= " and fk_destacado=" . intval($post["fk_destacado"]);
		}
		
		$Admin = new Admin;
		$is_admin=$Admin->isAdmin();
		
		if(isset($_SESSION["fk_pais_seleccionado"]) && !$is_admin){
			$sql .= " and " . TBL_ENCUESTAS . ".disponible_" . intval($_SESSION["fk_pais_seleccionado"]) . "=0 ";
		}
		$sql .= " order by pk_encuesta desc";
		//echo $sql;
		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function getEncuestaRespuestas($fk_encuesta=0) {
		$arr=array("tabla"=>TBL_ENCUESTAS_RESPUESTAS,"fk_encuesta"=>intval($fk_encuesta));
		return $this->getTabla($arr,99999,0);
	}
	
	function votoEncuesta($post){
		if(intval($post["respuesta"])>0){
			$this->ExecuteAlone("update " . TBL_ENCUESTAS_RESPUESTAS . " set votos=votos+1 where pk_encuesta_respuesta=" . intval($post["respuesta"]));
		}
	}
	
	function addNoticia($post,$file){
       
                $fields = array("titulo","sumario","texto","titulo_en","sumario_en","texto_en","fk_destacada","fk_tipo","fk_fija","fecha_noticia");
                array_push($fields,"fecha_modificado");
                $post["fecha_modificado"]=date("Y/m/d H:i");
                       
                if(intval($post["pk_noticia"])>0){//es un edit realmente
                        array_push($fields,"pk_noticia");
                }else{
                        array_push($fields,"fecha_agregado");
                        $post["fecha_agregado"]=date("Y/m/d H:i");
                       
                }
                $arrTemp= array("tabla" => TBL_NOTICIAS);
                $arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
               
               
                $id=$this->addEdtTabla($arrTemp);
                if(intval($post["pk_noticia"])>0){//es un edit realmente
                        $id=$post["pk_noticia"];
                }
               
               
                if(is_array($file)){
             
					$path= SERVER_ROOT . "images/noticias/";
				   
					if(is_uploaded_file($file["pic_1"]['tmp_name'])){
							$Media = new Media;
							$Media->cropCenterImage($file["pic_1"]['tmp_name'],322,200,$path  . $id . ".jpg");
							//$Media->cropCenterImage($value["tmp_name"],70,100,$path  . $id . "_tb.jpg");
					}
					
					if(is_uploaded_file($file["pdf"]['tmp_name'])){
							move_uploaded_file($file["pdf"]['tmp_name'],$path  . $id . ".pdf");
							$this->ExecuteAlone("update " . TBL_NOTICIAS . " set pdf_name='" . $this->clearSql_s($file["pdf"]['name']) . "' where pk_noticia=" . $id);
					}
                        
                }
               
                return $id; 
        }
       
        function editNoticia($post,$file){
                return $this->addNoticia($post,$file);
       
        }
       
        function deleteNoticia($post){
                if(is_array($post["delete"]))
                        foreach($post["delete"] as $key => $value){
                                $this->ExecuteAlone("update " . TBL_NOTICIAS . " set fk_estatus=0 where pk_noticia=" . $value);
                        }
                return true;
        }
        function getNoticia($post='',$page=0,$results_per_page=10) {
                $arr=array("tabla"=>TBL_NOTICIAS);
                if(is_array($post))
                        foreach($post as $key => $value){
                                $arr[$key]=$value;
                        }
				if(!isset( $post["orderby"])){		
                	$arr["orderby"] = " pk_noticia desc";
				}
                return $this->getTabla($arr,$results_per_page,$page);
        }
		
		function addTestimonio($post,$file){
       
                $fields = array("titulo","sumario","titulo_en","sumario_en","fk_destacada");
                array_push($fields,"fecha_modificado");
                $post["fecha_modificado"]=date("Y/m/d H:i");
                       
                if(intval($post["pk_testimonio"])>0){//es un edit realmente
                        array_push($fields,"pk_testimonio");
                }else{
                        array_push($fields,"fecha_agregado");
                        $post["fecha_agregado"]=date("Y/m/d H:i");
                       
                }
                $arrTemp= array("tabla" => TBL_TESTIMONIOS);
                $arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
               
               
                $id=$this->addEdtTabla($arrTemp);
                if(intval($post["pk_testimonio"])>0){//es un edit realmente
                        $id=$post["pk_testimonio"];
                }
               
               
                if(is_array($file)){
             
					$path= SERVER_ROOT . "images/testimonios/";
				   
					if(is_uploaded_file($file["pic_1"]['tmp_name'])){
							$Media = new Media;
							$Media->cropCenterImage($file["pic_1"]['tmp_name'],160,65,$path  . $id . "_tb.jpg");
							$Media->cropCenterImage($file["pic_1"]['tmp_name'],200,81,$path  . $id . ".jpg");
					}
					
					
                        
                }
               
                return $id; 
        }
       
        function editTestimonio($post,$file){
                return $this->addTestimonio($post,$file);
       
        }
       
        function deleteTestimonio($post){
                if(is_array($post["delete"]))
                        foreach($post["delete"] as $key => $value){
                                $this->ExecuteAlone("update " . TBL_TESTIMONIOS . " set fk_estatus=0 where pk_testimonio=" . $value);
                        }
                return true;
        }
        function getTestimonio($post='',$page=0,$results_per_page=10) {
                $arr=array("tabla"=>TBL_TESTIMONIOS);
                if(is_array($post))
                        foreach($post as $key => $value){
                                $arr[$key]=$value;
                        }
                $arr["orderby"] = " pk_testimonio desc";
                return $this->getTabla($arr,$results_per_page,$page);
        }
}
?>