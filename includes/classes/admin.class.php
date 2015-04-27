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
## Clase:				admin 																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
class Admin extends Common{
	function __construct() {
			parent::__construct();
	}
	
	function isAdmin(){
		if(isset($_SESSION["administrator"])){
			return true;
		}else{
			return false;
		}
	}
	
	function loginAdmin($post){
		$captcha = new Captcha;
		if($captcha->verify($post["captcha"])){ 
			$rs = $this->Execute("select * from " . TBL_ADMINISTRADORES . " where login='" . $this->clearSql_S($post["login"]) . "' and password='" . md5($post[$post["cc1"]]). "' and fk_estatus=1");
			if(sizeof($rs["results"])>0){
				$_SESSION["administrator"] = $rs["results"][0];
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function chkPermisosAdmin($permiso){
		$rs2 = $this->Execute("select * from " . TBL_ADMINISTRADORES_VS_PERMISOS . " where fk_estatus=1 and fk_administrador=" . intval($_SESSION["administrator"]["pk_administrador"]) . " and fk_permiso=" . intval($permiso));
      // echo"R2 = ".var_dump($r2);
			if(sizeof($rs2["results"])>0){
				return true;
			}else{
				require(SERVER_ROOT . "admin/modules/error.php");
				exit;
				return true;
			}  
	
	}  
	function addAdministrador($post){
	
		$fields = array("nombres","login"); 
		
		if(intval($post["pk_administrador"])>0){//es un edit realmente
			array_push($fields,"pk_administrador");
		}else{
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		
		if(trim($post["password"])!=''){
			array_push($fields,"password");
			$post["password"]=md5($post["password"]);
		}
		$arrTemp= array("tabla" => TBL_ADMINISTRADORES);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		
		$id=$this->addEdtTabla($arrTemp);
		if(intval($post["pk_administrador"])>0){//es un edit realmente
			$id=$post["pk_administrador"];
		}
		
		$Aggregator = new Aggregator();
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_ADMINISTRADORES_VS_PERMISOS,"fk"=>"fk_administrador","fk2"=>"fk_permiso","id"=>$id));
		
		return $id;
	}
	
	function editAdministrador($post){
		return $this->addAdministrador($post);
	
	}
	
	function deleteAdministrador($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_ADMINISTRADORES . " set fk_estatus=0 where pk_administrador=" . $value);
			}
		return true;
	}
	function getAdministrador($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_ADMINISTRADORES);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
}
?>