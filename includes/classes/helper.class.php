<?php
	class Helper extends Common {
		   
		function __construct() {
			parent::__construct();
		} 
		
		public function __call($name,$arguments) {
			//error_log("Se esta intentando ejecutar la funcion . " . $name . " mediante __call()");
			$funciones = array("add","edit","del","get");
			$tabla = "";
			foreach($funciones as $funcion) {
				if(preg_match("/" . $funcion . "/",$name) > 0) {
					$action = $funcion;
					$tabla = "TBL_" . strtoupper(substr($name,strlen($funcion)));
					break;
				}
			}
			
			if($tabla == "") {
				//error_log("Funcion " . $name . " no esta definida"); 
				return false;
			}
			
			$constantes = get_defined_constants(true);
			$tabla = $constantes["user"][$tabla];
			
			$sql = "select column_name as columna from INFORMATION_SCHEMA.columns where table_name = '" . $tabla . "' and TABLE_SCHEMA = '" . DB_NAME . "'"; //pendiente de esto
			$columnas = $this->Execute($sql);
			foreach($columnas["results"] as $columna) {
				if(preg_match("/pk/",$columna["columna"]) > 0)
					$pk = $columna["columna"];
				else if(preg_match("/fk_estatus/",$columna["columna"]) > 0)
					continue;
				else
					$fields[] = $columna["columna"];
			}
			//var_dump($arguments[0]);
			switch($action) {
				case "add":
				case "edit":
					return $this->addGeneral($pk,$tabla,$fields,$arguments[0]);
				break;
				
				case "get":
					//parche para eketing 
					$arr = $arguments[0];
					//$arr = array("tabla"=>$tabla);
					$arr["tabla"] = $tabla;
					if(intval($arguments[0][$pk]) > 0) 
						$arr[$pk] = intval($arguments[0][$pk]);
					else { //parche
						$arr = $arguments[0];
						$arr["tabla"] = $tabla;
						unset($arr[$pk]);
					}
					//var_dump($arr);
					$data = $this->getTabla($arr,$arguments[2],$arguments[1]);
					return $data;
				break;
				
				case "del":
					$this->deleteGeneral($pk,$tabla,$arguments[0]);
				break;
			}
		}

	}
?>