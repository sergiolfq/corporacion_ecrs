<?php
/*########################################################################################################
##																										##
## ISOMETRICO.COM																						##
## 																										##
## Programacion por:    	                                     										##
##                   Mauricio A. Duran D. taufpate@taufpate.com                                         ##
##                   Andres D. Garcia A.  andres@dranes.com                                             ##
##																										##
## Fecha de Creacion: 	Mayo 2007																		##
## Ultima modificacion: Septiembre 2007	  																##
## Clase:				MYSQLDB 																	    ##
## Versi&oacute;n:				0.1																		##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
	class MYSQLDB extends Config {
		var $host;
		var $port;
		var $dbname;
		var $user;
		var $password;
		var $connection;
		var $result;
		var $resultstatus;
		var $last_sentence;
		
		function __construct() {
			parent::__construct();
			
			$this->host = DB_HOST;
			$this->user = DB_USER;
			$this->password = DB_PASSWORD;
			$this->dbname = DB_NAME;
			$this->port = DB_PORT;
			
			$this->connection = null;
			$this->result = null;
			$this->Connect();
		}
		
		function toString() {
			return "MySQL Manipulation Class";	
		}
		
		function Connect() {
			if(defined('connection')){ 
				$this->connection = connection;
			}else{
				$this->connection=mysql_connect($this->host.":".$this->port,$this->user,$this->password);
				if ($this->connection){
					mysql_select_db($this->dbname,$this->connection);
					mysql_set_charset('utf8');
					define('connection',$this->connection);
					return $this->connection;
				}else{
					die("Ha ocurrido un error de conexi&oacute;n a la base de datos :-( ");
				}
			}
		}
		function saveLog(){
			if(defined('TBL_TRAZA') && Admin::isAdmin()){ 
				
				if(eregi("^insert",trim($this->last_sentence)) || eregi("^update",trim($this->last_sentence)) || eregi("^delete",trim($this->last_sentence)) ){
					$sql = "insert into " . TBL_TRAZA . " (fecha, pk_administrador, traza) values (" . time() . "," . $_SESSION["administrator"]["pk_administrador"]. ",'" . gzcompress($this->last_sentence). "')";
					mysql_query($sql,$this->connection);
					
					//borro el log de mas de 90 dias
					mysql_query("delete from " . TBL_TRAZA . " where fecha<" .( time() - (90 * 24 * 60 *60)),$this->connection);
					
				}
			}
			return true;
		}
		
		function ExecuteAlone($sql,$secuencia='') {
			$this->last_sentence = $sql;
			$this->saveLog();
			//error_log($sql);
			mysql_query($sql,$this->connection);
			if(eregi("^insert",trim($this->last_sentence))){
				return $this->LastInsertID();
			}
		}
		
		function Execute($sql,$results_per_page=999999,$page=0,$secuencia='') {	 
			$this->last_sentence=$sql;
			$this->saveLog();
			
			if(eregi("^insert",trim($this->last_sentence))){
				mysql_query($sql,$this->connection);
				return $this->LastInsertID();
			}elseif(eregi("^update",trim($this->last_sentence))){
				return mysql_query($sql,$this->connection);
			}else{ 
				$indiceResult = 0;
				$array = null;
				
				$arreglo=array();
				$results_per_page = intval($results_per_page);
				$sql = trim($sql);
				
				$query = $sql;
				
				if (preg_match('#GROUP\s+BY#is', $query) === 1 ||
					preg_match('#SELECT.+SELECT#is', $query) === 1 ||
					preg_match('#\sUNION\s#is', $query) === 1 ||
					preg_match('#SELECT.+DISTINCT.+FROM#is', $query) === 1
            	) {
					// GROUP BY, DISTINCT, UNION and subqueries are special cases
					// ==> use the normal query and then numRows()
					//echo "oooouch!";
					//echo $query;
					$this->result = mysql_query($query,$this->connection);
					$this->result = mysql_query("SELECT FOUND_ROWS()",$this->connection);
					$total_results = $this->GetField();
					$this->ClearResults();
				} else {
					// don't query the whole table, just get the number of rows
					$query = preg_replace('#SELECT\s.+\sFROM#is',
										  'SELECT COUNT(*) FROM',
										  $query);
					$this->result = mysql_query($query,$this->connection);
					$total_results = $this->GetField();
					$this->ClearResults();
				}
		
				/*
				$sqlP = $sql;
				if (preg_match("/^\s*SELECT\s+DISTINCT/is", $sqlP) || 
					preg_match('/\s+GROUP\s+BY\s+/is',$sqlP) || 
					preg_match('/\s+UNION\s+/is',$sqlP)) {
					
					$rewritesql = preg_replace('/(\sORDER\s+BY\s[^)]*)/is','',$sqlP);
					$rewritesql = "SELECT COUNT(*) FROM ($rewritesql) _ADODB_ALIAS_";
					$sqlP=$rewritesql;
					
				}else{
	
					$sqlP = preg_replace('#SELECT\s.*?\sFROM#is', 'SELECT COUNT(*) FROM',$sqlP,1);
					$sqlP = preg_replace("#order[[:space:]]+by#","order by",$sqlP);
					$arr =preg_split("#order[[:space:]]+by#",$sqlP,-1,PREG_SPLIT_OFFSET_CAPTURE);
					if(sizeof($arr)>0 && !preg_match("#\)#",$arr[sizeof($arr)-1][0])>0){
						$sqlP = substr($sqlP,0,$arr[sizeof($arr)-1][1]-8);
					}
				}
				*/
				
				//error_log($sqlP);
				//esto es un bug y hay que solucionarlo!!!!!!
				//$sqlP = preg_replace('#SELECT\s.*?\sFROM#is', 'SELECT COUNT(*) FROM',$sql,1);
				//echo $sqlP;
				$page = intval($page);
				
				
				
				$limit_down = intval($page * $results_per_page);
			
				$num_pages = floor($total_results / $results_per_page);
				
				if (($total_results / $results_per_page) > $num_pages){
					$num_pages = $num_pages + 1;
				}
				$sql .= " limit $results_per_page offset $limit_down";
			
				$this->result = mysql_query($sql,$this->connection);
				//error_log($sql);
				
				$arrReturn = array();
				$arrReturn["total"]=$total_results;
				$arrReturn["pages"]=$num_pages;
				$arrReturn["currpage"]=$page;
				$arrReturn["currresults"]=$this->NumRows();
	
				$arrtmp = array();
				if($arrReturn["currresults"]!=0){
					while($row=$this->FetchArray()){
						$arrtmp[] = $row;
					}
				}
				$arrReturn["results"]=$arrtmp;
				return $arrReturn;
			}
			
		}	
		
		function LastInsertID($tabla='') {
			return mysql_insert_id($this->connection);
		}
		
		function paginateResults($arrReturn,$siguiente='Siguiente',$anterior='Anterior',$principalClass="paginacion",$siguienteClass='t2',$anteriorClass='t2'){
			global $HTTP_GET_VARS;
			$variablesget = "";
			$str_paginacion_prev = "";
			$str_paginacion_next = "";
			$next_page=0;
			$prev_page=0;
			while(list($key, $value) = each($_GET)){
				if($key!="page"){
					if(is_array($value)){
						foreach($value as $key2 => $value2)
							$variablesget .= $key .  "[]=" . $value2 . "&";
					}else{
						$variablesget .= "$key=$value&";
					}
				}
			}
			if ($arrReturn["pages"] > ($arrReturn["currpage"]+1)){	 
				$next_page = $arrReturn["currpage"] + 1;
				$str_paginacion_next = "<a href='?page=$next_page&$variablesget' class='" . $siguienteClass ."'>" . $siguiente . "</a>";
			}
			
			
			
			if ($arrReturn["currpage"] != 0){	
				$prev_page = $arrReturn["currpage"] - 1;
				$str_paginacion_prev = "<a href='?page=$prev_page&$variablesget' class='" . $anteriorClass . "' >" . $anterior . "</a>";
			}
			
			
			for($a=$next_page+1;$a<=$next_page+3;$a++){
				if($a<=$arrReturn["pages"] && $arrReturn["currpage"]!=($arrReturn["pages"]-1) ){
					$str_paginacion_nextInd .= " <a href='?page=" . ($a-1) . "&$variablesget' class='" . $siguienteClass ."'>" . $a . "</a>"; 
				}
			}
			for($a=$prev_page-1;$a<=$prev_page+1;$a++){
				if($a>0 && $arrReturn["currpage"]!=0){
					$str_paginacion_prevInd .= " <a href='?page=" . ($a-1) . "&$variablesget' class='" . $siguienteClass ."'>" . $a . "</a>"; 
				}
			}
			
			
			if ($arrReturn["pages"] < 0){$arrReturn["pages"] = 1;}
			$str_paginacion = "Pag " . $str_paginacion_prevInd . " " . ($arrReturn["currpage"]+1) . " " . $str_paginacion_nextInd . " / " . " <a href='?page=" . ($arrReturn["pages"]-1) . "&$variablesget' class='" . $siguienteClass ."'>" . $arrReturn["pages"] . "</a> " . $str_paginacion_prev . " " . $str_paginacion_next;
			
				//$str_paginacion .= '<div class=' . $principalClass . '>' . $str_paginacion_prev . ' P&aacute;gina ' . ($arrReturn["currpage"]+1) . ' de ' . $arrReturn["pages"] . ' ' . $str_paginacion_next . '</div><br>';
				return $str_paginacion;
		
		}
		 
		function paginateResultsAjax($arrReturn,$div,$url,$arrParams=0,$siguiente='Siguiente',$anterior='Anterior',$principalClass="txt_gray",$siguienteClass='txt_gray',$anteriorClass='txt_gray',$arrOnEvents=0){
			//global $HTTP_POST_VARS; //$HTTP_GET_VARS;
			//$HTTP_POST_VARS = $_POST;
			$variablesget = "";
			$str_paginacion_prev = "";
			$str_paginacion_next = "";
			if(isset($_POST["page"])){
				$myvalues = array($_POST,$arrParams); //volvemos a escribir todos los parametros pasados por post y por parametro en un url
			}else{
				$myvalues = array($arrParams);
			}
			while(list($mykey,$myvalue) = each($myvalues)) {
				if(is_array($myvalue)) {
					foreach($myvalue as $key => $value) {
						if($key!="page" && substr($key,0,3)!="frm"){
							if(is_array($value)){
								foreach($value as $key2 => $value2)
									$variablesget .= $key .  "[]=" . $value2 . "&";
							}else{
								$variablesget .= "$key=$value&";
							}
						}
					}
				}
			}
			
			$funcionJS = "new Ajax.Updater('$div','$url',{method:'post',evalScripts: true,parameters:'page=@page&@parametros'";
			if(is_array($arrOnEvents)) {//si le pasamos al a funcion algo en $arrOnEvents extendemos el js para incluirle los eventos onComplete etc...
				$funcionJS .= ",";
				while(list($key,$value) = each($arrOnEvents)) {
					$funcionJS .= $key . ": function() {" . $value . "},";
				}
				$funcionJS = $this->removeLastChar($funcionJS); //como siempre al final queda una coma separada para que no de error de js
			}
			$funcionJS .= "})";
			
			if ($arrReturn["pages"] > ($arrReturn["currpage"]+1)) {	
				$next_page = $arrReturn["currpage"] + 1;
				$url_name = "siguiente";	
			}
			
			if ($arrReturn["currpage"] != 0) {	
				$prev_page = $arrReturn["currpage"] - 1;
				$url_name = "anterior";
			}
			
			$estructura_link =  "<a class='@clase' href=\"javascript:void($funcionJS)\">@texto_url</a> ";
			$buscar = array("/@clase/","/@page/","/@parametros/","/@texto_url/");
			
			$str_paginacion_next = preg_replace($buscar,array($siguienteClass,$next_page,$variablesget,"Siguiente"),$estructura_link);
			$str_paginacion_prev = preg_replace($buscar,array($anteriorClass,$prev_page,$variablesget,"Anterior"),$estructura_link);
			
			//desaparecemos los siguientes y anteriores dependiente del caso
			if($arrReturn["pages"] <= 1) { //hay una sola pagina desaparecemos anterior y siguiente
				$str_paginacion_next = "";
				$str_paginacion_prev = ""; 
			} else if($arrReturn["pages"] == ($arrReturn["currpage"] + 1)) { //llegamos a la ultima pagina
				$str_paginacion_next = "";
			} else if($arrReturn["currpage"] == 0) { //estamos en la primera pagina
				$str_paginacion_prev = "";
			}		

			if ($arrReturn["pages"] <= 0){ //el query no devolvio resultados
				$arrReturn["pages"] = 1;
			}
			
			$pagx = "";
			if($arrReturn["pages"]>3){
				for($a=2; $a>=0; $a--){
					if($arrReturn["currpage"]-$a+1 > 0) {

						$px = ($arrReturn["currpage"]-$a);
						
						if($px!=$arrReturn["currpage"]) {		
							$pagx .= preg_replace($buscar,array($anteriorClass,$px,$variablesget,$px + 1),$estructura_link);
						} else {
							$pagx .= "<strong>" . ($px+1) . "</strong> ";
						}
					}
				}
				
				for($a=1; $a<4; $a++){
					if($arrReturn["currpage"]+$a+1 < $arrReturn["pages"] ){
						$px = ($arrReturn["currpage"]+$a);
						$pagx .= preg_replace($buscar,array($anteriorClass,$px,$variablesget,$px + 1),$estructura_link);
					}
				}
				
			} else {
				$pagx = ($arrReturn["currpage"]+1);
			}
			
			$texto_url = $arrReturn["pages"];
			$pagina = $arrReturn["pages"] - 1;
			
			$pagy = preg_replace($buscar,array($anteriorClass,$pagina,$variablesget,$texto_url),$estructura_link);
					
			$str_paginacion = '<div class="' . $principalClass . '">P&aacute;gina ' .  $pagx . ' de ' . $pagy   . ' ' . $str_paginacion_prev . ' ' . $str_paginacion_next . '</div>';
			return $str_paginacion;
		}
		 
		
		//obtiene un campo de la primera fila
		function GetField($field=0){
			return @mysql_result($this->result,0,$field);
		}
		//obtiene cualquier campo de cualquier fila
		function GetRowColumn($row,$column){
			return @mysql_result($this->result,$row,"$column");
		}
		
		//limpia el cursor
		function ClearResults() {
			if ($this->result) {
				mysql_free_result($this->result);
				$this->result='';
			}
    	}
		
		//devuelve el numero de registros
		function NumRows() {
			if ($this->result) {
				return mysql_num_rows($this->result);
			} else {
				return false;
			}
    	}
		
		function FetchArray() {
        	return @mysql_fetch_array($this->result);
    	}
		
		function clearSql_Array($fields,$post){
        	foreach($fields as $key => $value){
				if(ereg("^fk_",$value) || ereg("^id",$value) || ereg("^pk_",$value)){ //si pinta ser un entero le paso el clear_N
					$arrTemp[(string) $value] = $this->clearSql_n($post[$value]);
				}else{
					$arrTemp[(string) $value] = $this->clearSql_s($post[$value]);
				}
			}  
			return $arrTemp;
    	}
		
		function clearSql_s($cadena){
        	return str_replace("'","\'",str_replace("\'","'",$cadena));      
    	}
		
		function clearSql_f($cadena){
        	return $this->clearSql_s($cadena);      
    	}
		
		function clearSql_n($cadena){
			if(is_numeric($cadena))
				return $cadena;  
			else
				return 0;  
		}
	}
?>
