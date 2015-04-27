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
## Clase:				banners																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
class Banners extends Common{
	function __construct() {
			parent::__construct();
		//activo los banners que cumplen las condiciones
		$this->ExecuteAlone("update " . TBL_BANNERS . " set fk_estatus = 1 where fecha_ini <= now() and fecha_fin >=now() and fk_estatus<>1 and fk_estatus<>0");
		//desactivo los banners que cumplen las condiciones
		$this->ExecuteAlone("update " . TBL_BANNERS . " set fk_estatus = 2 where ( fecha_ini > now() or fecha_fin < now() ) and fk_estatus=1  and fk_estatus<>0");
		
		$this->ExecuteAlone("update " . TBL_BANNERS . " set fk_estatus = 2  where max_impresiones<=impresiones and max_impresiones<>0 and fk_estatus=1 and fk_estatus<>0");
		$this->ExecuteAlone("update " . TBL_BANNERS . " set fk_estatus = 2  where max_clicks<=clicks and max_clicks<>0 and fk_estatus=1 and fk_estatus<>0");
	}
	
	function addBanner($post,$file){
		$fields = array("banner","tipo_banner", "codigo", "fecha_ini", "fecha_fin","max_impresiones","max_clicks","href","fheight","fwidth","fk_estatus","target","fk_libre","texto","texto_en","locale"); 
		
		if(file_exists($file["imagen"]["tmp_name"])){
			if(eregi("image",$file["imagen"]["type"])){
				$Media = new Media;
				array_push($fields,"extension");
				$post["extension"]=$Media->getImageExt($file["imagen"]["tmp_name"]);
			}else{
				die("Operacion ilegal!, solo puede subir imagenes!");
				exit;
			}	
		}
		if(intval($post["pk_banner"])>0){//es un edit realmente
			array_push($fields,"pk_banner");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_BANNERS);
		
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_banner"])>0){//es un edit realmente
			$id=$post["pk_banner"];
		}
		
		if(isset($post["extension"])){
			$bannpath= SERVER_ROOT . "images/banners/" . $id . $post["extension"];
			@unlink($bannpath);
			move_uploaded_file($file["imagen"]["tmp_name"], $bannpath);
			@chmod($bannpath,0755);	
		}
		if(file_exists($file["flash"]["tmp_name"])){
			if(eregi("application/x-shockwave-flash",$file["flash"]["type"])){
				$bannpath= SERVER_ROOT . "images/banners/" . $id . ".swf";
				move_uploaded_file($file["flash"]["tmp_name"], $bannpath);
			}else{
				die("Operacion ilegal!, solo puede subir flash!");
				exit;
			}	
		}
		$Aggregator = new Aggregator();
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_BANNERS_VS_ZONAS,"fk"=>"fk_banner","fk2"=>"fk_banner_zona","id"=>$id));
		
		return $id;
	}
	
	function editBanner($post,$file){
		return $this->addBanner($post,$file);
	}
	
	function deleteBanner($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_BANNERS . " set fk_estatus=0 where pk_banner=" . $value);
			}
		return true;
	}
	function getBanner($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_BANNERS);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function getBannerbyZonas($pk_zona) {
		$sql = "select " . TBL_BANNERS . ".* from " . TBL_BANNERS . " inner join " . TBL_BANNERS_VS_ZONAS . " on " . TBL_BANNERS . ".pk_banner=" . TBL_BANNERS_VS_ZONAS . ".fk_banner  where " . TBL_BANNERS_VS_ZONAS . ".fk_estatus=1 and " . TBL_BANNERS . ".fk_estatus=1 and " . TBL_BANNERS_VS_ZONAS . ".fk_banner_zona=" . intval($pk_zona);
		
		if(isset($_SESSION["LOCALE"])){
			$sql .= " and locale='" . $this->clearsql_S($_SESSION["LOCALE"]) . "'";
		}
		
		
		$sql .= " order by " . TBL_BANNERS_VS_ZONAS . ".orden asc";
		
		return $this->Execute($sql);
	}
	
	function makeCodigoBanner($arreglo,$cssClass){
          //    var_dump($arreglo);
		if($arreglo["tipo_banner"]==1){ //es de codigo
			$out = '<span class="' . $cssClass . '">' . $arreglo["codigo"] .  '</span>';
		}elseif($arreglo["tipo_banner"]==2){
                
		$out='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,47,0" width="' . $arreglo["fwidth"] .  '" height="' . $arreglo["fheight"] .  '">
  <param name="movie" value="/images/banners/' . $arreglo["pk_banner"] .  '.swf" />
  <param name="quality" value="high" />
  <embed src="/images/banners/' . $arreglo["pk_banner"] .  '.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="' . $arreglo["fwidth"] .  '" height="' . $arreglo["fheight"] .  '"></embed>
</object>';
		$out='';
		}else{ // es de imagen
			$out = '<img src="/images/banners/' . $arreglo["pk_banner"] . $arreglo["extension"] . '" border="0" />';
			if(trim($arreglo["href"])!='' && strtolower(trim($arreglo["href"]))!='http://'){
				$out = '<a href="?bannerid=' . $arreglo["pk_banner"] . '" target="' . $arreglo["target"] . '" class="' . $cssClass . '">' . $out  . '</a>';
			}
		}
		return $out;
	}
        
        
        // funcion para el home nuevo 
    function makeCodigoBannerBoostrap($arreglo, $cssClass) {
        //    var_dump($arreglo);
        
      //  var_dump($arreglo["tipo_banner"]);
        if ($arreglo["tipo_banner"] == 1) { //es de codigo
            $out =  $arreglo["codigo"] ;
          } elseif ($arreglo["tipo_banner"] == 2) {
       //    echo "jkljnmjkkjlnmjklm ";
            $out = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,47,0" width="' . $arreglo["fwidth"] . '" height="' . $arreglo["fheight"] . '">
  <param name="movie" value="/images/banners/' . $arreglo["pk_banner"] . '.swf" />
  <param name="quality" value="high" />
  <embed src="/images/banners/' . $arreglo["pk_banner"] . '.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="' . $arreglo["fwidth"] . '" height="' . $arreglo["fheight"] . '"></embed>
</object>';
            $out = '';
        } else { // es de imagen
         // echo "jkljnmjkkjlnmjklm2  ";
            $out = '<img src="/images/banners/' . $arreglo["pk_banner"] . $arreglo["extension"] . '" border="0" />';
            if (trim($arreglo["href"]) != '' && strtolower(trim($arreglo["href"])) != 'http://') {
                $out = '<a href="?bannerid=' . $arreglo["pk_banner"] . '" target="' . $arreglo["target"] . '" class="' . $cssClass . '">' . $out . '</a>';
            }
        }
        
      
        return $out;
    }

    // fin de funcion para el home nuevo 
        
           
       
// nueva funcion para generar código del home 
        function showBanners($pk_zona, $fk_libre = 0, $separadorini = '', $separadorfin = '', $multiple = 0, $cssClass = '') {
        //funcion que muestra los banner, si tiene separador significa que se mostraran varios
        $rszona = $this->Execute("select * from " . TBL_BANNERS_ZONAS . " where fk_estatus=1 and pk_banner_zona=" . intval($pk_zona));
        if (sizeof($rszona["results"]) > 0) {
            $separadorini = $rszona["results"][0]["separador_ini"];
            $separadorfin = $rszona["results"][0]["seperador_fin"];
            $multiple = $rszona["results"][0]["max_display"];

            $ordenamiento = $rszona["results"][0]["ordenamiento"];
        }

        //selecciono los baners activos para la zona
        $sql = "select " . TBL_BANNERS . ".* from " . TBL_BANNERS . " inner join " . TBL_BANNERS_VS_ZONAS . " on " . TBL_BANNERS . ".pk_banner=" . TBL_BANNERS_VS_ZONAS . ".fk_banner  where " . TBL_BANNERS_VS_ZONAS . ".fk_estatus=1 and " . TBL_BANNERS . ".fk_estatus=1 and " . TBL_BANNERS_VS_ZONAS . ".fk_banner_zona=" . intval($pk_zona);

        if (intval($fk_libre) > 0) {
            $sql .= " and " . TBL_BANNERS . ".fk_libre=" . intval($fk_libre);
        }

        if (isset($_SESSION["LOCALE"])) {
            $sql .= " and locale='" . $this->clearsql_S($_SESSION["LOCALE"]) . "'";
        }

        if (intval($ordenamiento) == 0) {
            $sql .= " order by " . TBL_BANNERS_VS_ZONAS . ".orden asc";
        } else {
            $sql .= " order by rand()";
        }
        if (intval($multiple) > 0) {
            $perpage = intval($multiple);
        } else {
            $perpage = 9999;
        }

        $bans = $this->Execute($sql, $perpage);

        if (sizeof($bans["results"]) > 0) {
            //if($multiple==1){//aca va solo un banner
            //	$numero = rand (0, sizeof($bans["results"])-1);
            //	$this->ExecuteAlone("update " . TBL_BANNERS . " set impresiones=impresiones+1 where pk_banner=" . intval($bans["results"][$numero]["pk_banner"]));
            //	return $separadorini . $this->makeCodigoBanner($bans["results"][$numero],$cssClass) . $separadorfin;
            //}else{

            $out = "";
            foreach ($bans["results"] as $key => $value) {
                //var_dump($value);
                $out .= $separadorini . $this->makeCodigoBanner($value, $cssClass) . $separadorfin;
                $this->ExecuteAlone("update " . TBL_BANNERS . " set impresiones=impresiones+1 where pk_banner=" . intval($value["pk_banner"]));
            }
            
          //  var_dump($out);
            return $out;
            //}
        }
    }

    // fin
    
    // nueva funcion para el home 
    
     function showBannersBoostrap($pk_zona, $fk_libre = 0, $separadorini = '', $separadorfin = '', $multiple = 0, $cssClass = '') {
        //funcion que muestra los banner, si tiene separador significa que se mostraran varios
        $rszona = $this->Execute("select * from " . TBL_BANNERS_ZONAS . " where fk_estatus=1 and pk_banner_zona=" . intval($pk_zona));
        if (sizeof($rszona["results"]) > 0) {
            $separadorini = $rszona["results"][0]["separador_ini"];
            $separadorfin = $rszona["results"][0]["seperador_fin"];
            $multiple = $rszona["results"][0]["max_display"];

            $ordenamiento = $rszona["results"][0]["ordenamiento"];
        }

        //selecciono los baners activos para la zona
        $sql = "select " . TBL_BANNERS . ".* from " . TBL_BANNERS . " inner join " . TBL_BANNERS_VS_ZONAS . " on " . TBL_BANNERS . ".pk_banner=" . TBL_BANNERS_VS_ZONAS . ".fk_banner  where " . TBL_BANNERS_VS_ZONAS . ".fk_estatus=1 and " . TBL_BANNERS . ".fk_estatus=1 and " . TBL_BANNERS_VS_ZONAS . ".fk_banner_zona=" . intval($pk_zona);

        if (intval($fk_libre) > 0) {
            $sql .= " and " . TBL_BANNERS . ".fk_libre=" . intval($fk_libre);
        }

        if (isset($_SESSION["LOCALE"])) {
            $sql .= " and locale='" . $this->clearsql_S($_SESSION["LOCALE"]) . "'";
        }

        if (intval($ordenamiento) == 0) {
            $sql .= " order by " . TBL_BANNERS_VS_ZONAS . ".orden asc";
        } else {
            $sql .= " order by rand()";
        }
        if (intval($multiple) > 0) {
            $perpage = intval($multiple);
        } else {
            $perpage = 9999;
        }

        $bans = $this->Execute($sql, $perpage);

        if (sizeof($bans["results"]) > 0) {
            //if($multiple==1){//aca va solo un banner
            //	$numero = rand (0, sizeof($bans["results"])-1);
            //	$this->ExecuteAlone("update " . TBL_BANNERS . " set impresiones=impresiones+1 where pk_banner=" . intval($bans["results"][$numero]["pk_banner"]));
            //	return $separadorini . $this->makeCodigoBanner($bans["results"][$numero],$cssClass) . $separadorfin;
            //}else{

            $out = "";
            foreach ($bans["results"] as $key => $value) {
                //var_dump($value);
                $out .= $separadorini . $this->makeCodigoBannerBoostrap($value, $cssClass) . $separadorfin;
                $this->ExecuteAlone("update " . TBL_BANNERS . " set impresiones=impresiones+1 where pk_banner=" . intval($value["pk_banner"]));
            }
            
            
            //var_dump($separadorini); 
            
         //  var_dump($out);
            return $out;
            //}
        }
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	function sumaBanner($pk_banner){
		global $db;
		//funcion que cuenta los clicks de los banners
		if(intval($pk_banner)!=0){
			$sql = "select href from " . TBL_BANNERS . " where pk_banner=" . intval($pk_banner);
			$this->Execute($sql);
			$link = $this->GetField(0);
			$this->ExecuteAlone("update " . TBL_BANNERS . " set clicks=clicks+1 where pk_banner=" . intval($pk_banner));
			header("location: $link");
			exit;
		}
	}
	
	function addBannerZona($post){
	
		$fields = array("zona","max_display","separador_ini","seperador_fin","ordenamiento"); 
		
		if(intval($post["pk_banner_zona"])>0){//es un edit realmente
			array_push($fields,"pk_banner_zona");
		}else{
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		$arrTemp= array("tabla" => TBL_BANNERS_ZONAS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_banner_zona"])>0){//es un edit realmente
			$id=$post["pk_banner_zona"];
		}
		
		return $id;
	}
	
	function editBannerZona($post){
		if(sizeof($post["bannerorden"])>0 && intval($post["pk_banner_zona"])>0){
			foreach($post["bannerorden"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_BANNERS_VS_ZONAS . " set orden=" . intval($key) . " where fk_banner=" . intval($value) . " and fk_banner_zona=" . intval($post["pk_banner_zona"]) . " and fk_estatus=1");
				//echo "update " . TBL_BANNERS_VS_ZONAS . " set orden=" . intval($key) . " where fk_banner=" . intval($value) . " and fk_banner_zona=" . intval($post["pk_banner_zona"]) . " and fk_estatus=1<br><br>";
			}
		}
		return $this->addBannerZona($post);
	
	}
	
	function deleteBannerZona($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_BANNERS_ZONAS . " set fk_estatus=0 where pk_banner_zona=" . $value);
			}
		return true;
	}
	function getBannerZona($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_BANNERS_ZONAS);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
}
?>