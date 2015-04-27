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
## Clase:				aggregator																  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
class Aggregator extends Common{
	function __construct() {
			parent::__construct();
	}
	function busquedaVsAggregator($AGGvars,$post,$results_per_page=9999,$page=0) {
		$palabra = $this->clearSql_s($post["palabra"]);
		$sql = "select * from " . $AGGvars["tabla"] . " where (" . $AGGvars["campo_buscar"] . " like '%" . $palabra . "%') and fk_estatus = 1";
		
		return $this->Execute($sql,$results_per_page,$page);
	}
	
	
	function getVsAggregatorByModule($AGGvars,$id) {  
		$sql = "select " . $AGGvars["tabla"] . ".* from " . $AGGvars["tabla"] . " inner join " . $AGGvars["versus"] . " on " . $AGGvars["tabla"] . "." . $AGGvars["pk"] . " = " . $AGGvars["versus"] . "." . $AGGvars["fk_1"] . " where " . $AGGvars["versus"] . "." . $AGGvars["fk"] . " = " . intval($id) . " and " . $AGGvars["versus"] . ".fk_estatus = 1";
//		echo $sql;
		return $this->Execute($sql);
	}
	
	function addEdtVsAggregatorByModule($post,$module) {	
		$sql = "update " . $module["versus"] . " set fk_estatus=0 where " . $module["fk"] . " = " . intval($module["id"]);
		//echo $sql;
		$this->ExecuteAlone($sql);
		if(is_array($post[$module["fk2"]])) {
			foreach($post[$module["fk2"]] as $elemento) {
				$sql = "insert into " . $module["versus"] . " (" . $module["fk"] . "," . $module["fk2"] . ") values ('" . $module["id"] . "','" . intval($elemento) . "')";
				//echo $sql . "<br>";
				$this->ExecuteAlone($sql);
			}
		}
	}
}
?>