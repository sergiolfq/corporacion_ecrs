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
## Clase:				textos 																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
class Textos extends Common{
	function __construct() {
			parent::__construct();
	}	
	function getTexto($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_TEXTOS);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		$arr["orderby"] = "pk_texto asc";
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function addTexto($post){
	
		$fields = array("titulo","texto","titulo_en","texto_en","texto_es","titulo_co","texto_co","titulo_es"); 
		
		if(intval($post["pk_texto"])>0){//es un edit realmente
			array_push($fields,"pk_texto");
		}
		
		$arrTemp= array("tabla" => TBL_TEXTOS);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);

		if(intval($post["pk_texto"])>0){//es un edit realmente
			$id=$post["pk_texto"];
		}

		return $id;
	}
	
	function editTexto($post){
		return $this->addTexto($post);
	}
	
}
?>