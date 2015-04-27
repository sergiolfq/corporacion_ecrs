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
## Clase:				common 																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
	class Common extends MYSQLDB{
		function __construct() {
			@session_start();
			parent::__construct();

			if(isset($_GET['module'])) {
				$GLOBALS["modulo"] = stripslashes(stripcslashes(eregi_replace("\.","",eregi_replace("\/","",$_GET['module']))));
                                //echo $GLOBALS['modulo'];
			} else {
				$GLOBALS["modulo"]='main';
			}
			
			$this->pageGet = (isset($_GET["page"])) ? $_GET["page"]:0;
			$this->pagePost = (isset($_POST["page"])) ? $_POST["page"]:0;
		}
		
		function makeSumario($texto,$largo){
               $sumario = wordwrap(strip_tags($texto), $largo, "\n", true);
               $sumarioarr = split("\n",$sumario);    
               return $sumarioarr[0];
          }
		  
		
		
		function addEdtTabla($columnas) {
			
			array_walk($columnas,array($this,"searchColumn"),"pk");
			$pk = $GLOBALS['searchColumn'];
			if($columnas[$pk] == 0) {
				$sql = "insert into {$columnas["tabla"]} (";
				$sqlValues = "";
				foreach($columnas as $key => $value) {
					if($key != $pk && $key != "tabla") {
						$sql .= "$key,";
						$sqlValues .= "'$value',";
					}	
				}
				$sql = substr($sql,0,strlen($sql) -1) . ") values (" . substr($sqlValues,0,strlen($sqlValues) - 1) . ")";
			} else {
				$sql = "update {$columnas["tabla"]} set ";
				foreach($columnas as $key => $value) {
					if($key != $pk && $key != "tabla") {
						$sql .= "$key = '$value',";
					}	
				}
				$sql = substr($sql,0,strlen($sql) -1) . " where $pk = '{$columnas[$pk]}'";
			}
			
			//echo $sql . "<br><br>";
			//error_log($sql);
			return $this->ExecuteAlone($sql);
		}
		
		function searchColumn(&$value,$key,$busqueda) {
			if(preg_match("/^$busqueda/i",$key) == 1) {
				$GLOBALS['searchColumn'] = $key;
			}
		} 
		
		function getTabla($columnas,$results_per_page=999999,$page=0) {
			//var_dump($columnas);
		    $Admin = new Admin;
			$is_admin=$Admin->isAdmin();
			
			unset($GLOBALS['searchColumn']);
			$estatus = ($is_admin) ? "fk_estatus >= 1":"fk_estatus=1";
			
			
			if(isset($columnas["fk_estatus"])) { //parche para eketing vigilar que funcione
				if($columnas["fk_estatus"] == "null")
					$estatus = "1 = 1";
				else
					$estatus = "fk_estatus = " . $columnas["fk_estatus"];
			}
			
			array_walk($columnas,array($this,"searchColumn"),"pk");
			$pk = $GLOBALS['searchColumn'];
			
			if(sizeof($columnas)<=1 || (sizeof($columnas) <= 2 && isset($columnas["orderby"])) ){
				$sql = "select * from {$columnas["tabla"]} where {$estatus}";
			}else{
				$sql = "select * from {$columnas["tabla"]} where {$estatus}";
				foreach($columnas as $key=>$value){
					if($key!='tabla' && $key !="orderby" && $key != "fk_estatus" && $key != "sql_like")
						if(eregi("fk_",$key) || eregi("pk_",$key)){
							$sql .= " and " . $this->clearSql_s($key) . "=" . $this->clearSql_n($value);
						}else{
							if(isset($columnas["sql_like"]))
								$sql .= " and " . $this->clearSql_s($key) . " like '%" . $this->clearSql_s($value) . "%'";
							else
								$sql .= " and " . $this->clearSql_s($key) . "='" . $this->clearSql_s($value) . "'";
						}
				}
			}
			
			if(trim($pk)!='' && !isset($columnas["orderby"]))
				$sql .= " order by $pk desc";
			elseif(isset($columnas["orderby"])) 
				$sql .= " order by " . $columnas["orderby"];
				 
			error_log($sql);
			
			return $this->Execute($sql,$results_per_page,$page);
		}
		
		function getJoinTabla($columnas,$results_per_page=999999,$page=0) { //beta version
		
			$Settings = new Settings;
			$is_admin=$Settings->isUsuarioAdmin();
			
			unset($GLOBALS['searchColumn']);
			$estatus = ($is_admin) ? "fk_estatus >= 1":"fk_estatus=1";
			array_walk($columnas,array($this,"searchColumn"),"pk");
			$pk = $GLOBALS['searchColumn'];
			
			if(sizeof($columnas) <= 1 && intval($columnas[$pk]) == 0) {
				$sql = "select * from {$columnas["tabla"]} where {$estatus}";
			} else {
				$sql = "select " . $columnas["tabla"] . ".* ";
				$sqljoin = "";
				if(is_array($columnas["join"])) {
					foreach($columnas["join"] as $join) {
						//los pk y fk se pueden sacar del catalogo de mysql
						//sacamos los campos del catalogo porque esta verga no le gustan los campos repetidos
						//esto viene de la clase de MSSQL pero myqsl no tiene este problema =) lindo mysql
						/*
						$sqlcolumns = "select column_name from INFORMATION_SCHEMA.columns where table_name = '" . $join["table_left"] . "'";
						$campos = $this->Execute($sqlcolumns);
						foreach($campos["results"] as $campo) {
							if($campo["column_name"] == "fk_estatus")
								continue; //ahorita lo eliminamos pero se puede hacer otra cosa como renombrar el fk_estatus o lo duplicados algo asi
							else
								$camposJoin .= $join["table_left"] . "." . $campo["column_name"] . ",";
						}
						
						$camposJoin = $this->removeLastChar($camposJoin);
						//fin de los campos por catalogo
						*/
						$sql .=  "," . $join["table_left"] . ".* "; //"," . $camposJoin;
						$sqljoin .= " inner join " . $join["table_left"]  . " on " . $join["table_left"] . "." . $join["pk_left"] . " = " . $join["table_right"] . "." . $join["pk_right"] . " ";  
					}
					$sql .= " from " . $columnas["tabla"] . " ";
					$sql .= $sqljoin;
				}
				$sql .=  " where " . $columnas["tabla"] . ".{$estatus}";
				foreach($columnas as $key=>$value){
					if($key!='tabla' && $key != "join" && $key != "orderby" && $key != "sql_like") { //no podemos seguir este modelo cada vez habria que agregar mas cosas al if
						if(eregi("fk_",$key) || eregi("pk_",$key)){
							if(intval($value)>0 || eregi("pk_",$key))
								$sql .= " and " . $this->clearSql_s($key) . "=" . $this->clearSql_n($value);
						}else{
							if(trim($value)!='')
								if(isset($columnas["sql_like"])){
									$sql .= " and " . $this->clearSql_s($key) . " like '%" . $this->clearSql_s($value) . "%'";
								}else{
									$sql .= " and " . $this->clearSql_s($key) . "='" . $this->clearSql_s($value) . "'";
								}
						}
					}
					
				}
			}
			
			if(trim($pk)!='')
				$sql .= " order by " . $columnas["tabla"] . ".$pk desc";
			else if(isset($columnas["orderby"]))
				$sql .= " order by " . $columnas["orderby"] . " desc";
			//error_log("aquiiiiiiiiii " . $sql);
			//echo $sql . "<br>";
			return $this->Execute($sql,$results_per_page,$page);
		}
		
		function delTabla($columnas) {
			array_walk($columnas,array($this,"searchColumn"),"pk");
			$pk = $GLOBALS['searchColumn'];
			$sql = "update {$columnas["tabla"]} set fk_estatus = 0 where $pk = '{$columnas[$pk]}'";
			return $this->ExecuteAlone($sql);
		}
		
		function searchInTabla($columnas,$results_per_page=999999,$page=0) {
		
			
			if(sizeof($columnas)<=1 || (sizeof($columnas) <= 2 && isset($columnas["orderby"])) ){
				$sql = "select * from {$columnas["tabla"]} where fk_estatus >= 1";
			}else{
				$sql = "select * from {$columnas["tabla"]} where fk_estatus >= 1";
				foreach($columnas as $key=>$value){
					if($key!='tabla' && $key !="orderby" && $key !="sql_like")
						if(eregi("fk_",$key) || eregi("pk_",$key)){
							if(intval($value)>0 || eregi("pk_",$key))
								$sql .= " and " . $this->clearSql_s($key) . "=" . $this->clearSql_n($value);
						}else{
							if(trim($value)!='')
								if(isset($columnas["sql_like"])){
									$sql .= " and " . $this->clearSql_s($key) . " like '%" . $this->clearSql_s($value) . "%'";
								}else{
									$sql .= " and " . $this->clearSql_s($key) . "='" . $this->clearSql_s($value) . "'";
								}
						}
				}
			}
			
			if(trim($pk)!='' && !isset($columnas["orderby"]))
				$sql .= " order by $pk desc";
			elseif(isset($columnas["orderby"])) 
				$sql .= " order by " . $columnas["orderby"];
				 
			//error_log($sql);
			
			return $this->Execute($sql,$results_per_page,$page);
		}
		
		function prepareSqlVars($vars){
			if(is_array($vars)){
				foreach($vars as $key=>$value){
					if($key!='orderby' && $key!='groupby'){
						if(!is_array($value)){
							$value= array($value);
						}
						
						foreach($value as $kk => $vv){
							
							if(strstr($key,"|or|")){
								$concat = " or ";
								$keyF = str_replace("|or|","",$key);
							}else{
								$concat = " and ";
								$keyF = $key;
							}
							
							unset($vartmp);
							
							if(stristr($key,"fk_") || stristr($key,"pk_")){ // esto es un mumerico de calle!
								$vartmp =  $this->clearSql_n($vv);
							}else{
								$vartmp = "'" . $this->clearSql_s($vv) . "'";
							}
							
							if( !stristr($key,">") || !stristr($key,">") || !stristr($key,"like |") ){ // es una normal
								$sql .= $concat . $this->clearSql_s($keyF) . "=" . $vartmp;
							}else{
								$sql .= $concat . $this->clearSql_s($keyF) . $vartmp;
							}							
							
						}
					}
				}
			}	
			if(isset($vars['groupby'])){
				$sql .= " group by " . $vars['groupby'];
			}
			
			if(isset($vars['orderby'])){
				$sql .= " order by " . $vars['orderby'];
			}
			
			//error_log($sql);
			return $sql;
		}
		
		
		function datediff($interval,$date1,$date2) {
			// get the number of seconds between the two dates 

			if(!is_int($date1)){
				$date1 = strtotime($date1);
			}
			if(!is_int($date2)){
				$date2 = strtotime($date2);
			}
			$timedifference = $date2 - $date1;
			
			//echo $timedifference;
		
			switch ($interval) {
				case 'w':
					$retval = bcdiv($timedifference,604800);
					break;
				case 'd':
					$retval = bcdiv($timedifference,86400);
					break;
				case 'h':
					$retval = bcdiv($timedifference,3600);
					break;
				case 'n':
					$retval = bcdiv($timedifference,60);
					break;
				case 's':
					$retval = $timedifference;
					break;
					
			}
			return $retval;
			
		}
		
		
		
		function dateadd($datestr, $num, $unit) {

			$units = array("Y","m","d","H","i","s");
			$unix = strtotime($datestr);
			while(list(,$u) = each($units)) $$u = date($u, $unix);
			$$unit += $num;
			return mktime($H, $i, $s, $m, $d, $Y);
		
		}
		
		function limpiarTexto($texto){
			$texto = preg_replace("/(\S{30,})/ise", "wordwrap('\\1', 30, ' ', true);", $texto);
			return  strip_tags($texto);
		}
              
             
		
function enviarFormMail($nombre_usuario,$nuevo_pass,$emails,$tipo_cliente,$activacion_url){
    
    
        //var_dump('$nombre_usuario: '.$nombre_usuario. ' $emails: '.$emails);
		  
           require_once("../includes/PHPMailer/PHPMailerAutoload.php");  
                  $mail = new PHPMailer();    
           //Conexion al Smtp de GMAIL    //Configuracion para el asunto, destinatario, remitente,cuerpo del correo a enviar
           $mail->IsSMTP(); // send via SMTP
           $mail->IsHTML(true);
           $mail->SMTPAuth = true; // turn on SMTP authentication
           
            //$mail->SMTPSecure = 'tls';
           $mail->Host = "mail.ecrs.com.ve";
           $mail->Port = 26;
           $mail->Username = "distribuidores@ecrs.com.ve"; // SMTP username
           $mail->Password = "euAu%914";
    
        /*   $mail->SMTPSecure = 'tls';
           $mail->Host = "smtp.gmail.com";
           $mail->Port = 587;
           $mail->Username = "ecrsven@gmail.com"; // SMTP username
           $mail->Password = "ecrs12345"; // SMTP password*/
           $mail->Timeout = 30;
           $mail->SMTPDebug = 2; // debug que sirve para seguir la traza con el cliente correo y el servidor de correo           
           $webmaster_email = "distribuidores@ecrs.com.ve";
           $name = "CORPORACION ECRS C.A";          
           $mail->WordWrap = 70; // set word wrap
           $mail->HeaderLine("Sender","$webmaster_email");
           $mail->HeaderLine("From","$webmaster_email");
           $mail->HeaderLine("MIME-Version","1.0");
           $mail->HeaderLine("Content-Type","text/html; charset=utf-8");
           $mail->HeaderLine("Content-Transfer-Encoding","8bit"); // Correo y Nombre-Apellido del Nuevo Usuario      
           $mail->From = $webmaster_email;
           $mail->FromName = $name;
           $mail->AddAddress($emails,$nombre_usuario);
           $mail->AddBCC($webmaster_email,$name);
           $mail->AddBCC("agonzalez@ecrs.com.ve","Anibal Gonzalez");
           $mail->AddBCC("jgonzalez@ecrs.com.ve","Jorge Gonzalez");
           $mail->AddBCC("aperez@quorion.com.ve","Alejandro P�rez Bret�n");
           $mail->AddReplyTo($webmaster_email,$name);
         
                 
           if(($tipo_cliente) && (!$activacion_url)){ // Cliente Natural //recuperacion de contrase�a
         
                    $asunto = "Olvido De Contrase�a Sistema Web CORPORACION ECRS C.A";
             
                   
                    $body_mail = '<html>
                                        <body>
                                            <table width="98%" cellspacing="10" cellpadding="20" border="0">
                                              <tr>
                                                <td bgcolor="#FFFFFF">Hola '."$nombre_usuario".' has solicitado el envio de tu clave por email
                                            <br />
                                            <br />
                                            Por seguridad no almacenamos ni enviamos las claves originales por email, asi que te  hemos cambiado la que antigua por una nueva.<br />
                                            <br />
                                            Tu nueva clave es: <strong>'."$nuevo_pass".'</strong><br />
                                            Ingresa a http://www.ecrs.com.ve/?module=ingreso para iniciar sesion y modificar tu clave  
                                            (** http://ecrs/?module=ingreso (Desarrollo)**)<br />
                                         
                                            <br />
                                            Este email es meramente informativo, por favor NO responda este email, si desea contactarnos utilice el formulario de contacto de nuestro website.<br /><br />
                                            
                                            </td>
                                              </tr>
                                            </table>
                                        </body>
                                  </html> ';
                    
                    $mail->Subject = $asunto; // Asunto del Correo
                    $mail->Body = $body_mail; //HTML Body
                    $mail->AltBody = "Olvido De Contrase�a Sistema Web CORPORACION ECRS C.A"; //Text Body
                    
                    if(!$mail->Send())
                    {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    }
                    else
                    {
                    echo "Message has been sent";
                    }         
         
            
           }else if(($tipo_cliente)  && (!$activacion_url)){  //Cliente Distribuidor //recuperacion de contrase�a
   
           
           
           $asunto = "Olvido De Contrase�a Sistema Web CORPORACION ECRS C.A";
                            
                    $body_mail = '<html>
                                        <body>
                                            <table width="98%" cellspacing="10" cellpadding="20" border="0">
                                              <tr>
                                                <td bgcolor="#FFFFFF">Hola '."$nombre_usuario".' has solicitado el envio de tu clave por email
                                            <br />
                                            <br />
                                            Por seguridad no almacenamos ni enviamos las claves originales por email, asi que te  hemos cambiado la que antigua por una nueva.<br />
                                            <br />
                                            Tu nueva clave es: <strong>'."$nuevo_pass".'</strong><br />
                                            Ingresa a http://www.ecrs.com.ve/?module=ingreso para iniciar sesion y modificar tu clave  
                                            (** http://ecrs/?module=ingreso (Desarrollo)**)<br />
                                         
                                            <br />
                                            Este email es meramente informativo, por favor NO responda este email, si desea contactarnos utilice el formulario de contacto de nuestro website.<br /><br />
                                            
                                            </td>
                                              </tr>
                                            </table>
                                        </body>
                                  </html> ';
                   
                    $mail->Subject = $asunto; // Asunto del Correo
                    $mail->Body = $body_mail; //HTML Body
                    $mail->AltBody = "Olvido De Contrase�a Sistema Web CORPORACION ECRS C.A"; //Text Body
                    
                    if(!$mail->Send())
                    {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    }
                    else
                    {
                    echo "El Mensaje ha sido enviado | Message has been sent";
                    }         
         
            
           }else if( ($tipo_cliente == 1) && ($activacion_url) ){ // REGISTRO CLIENTE NUEVO Natural y Juridico
                                        $mail_user_nuevo = $emails;
                                        $usuario = $emails;
                                        $pass_usuario = $nuevo_pass;
                                        $nombreApellido = $nombre_usuario;                                       
                                        $asunto = "Bienvenido A la web de Corporacion ECRS C.A";
                                         if($tipo_cliente == 2){
                                            $clinte_tipo = "Juridico";
                                            }else{
                                            $clinte_tipo = "Natural";
                                        }
                                        $body_mail = '<!doctype html>
                                    <html>
                                        <head>
                                        	<title>Bienvendido a Corporacion ECRS C.A</title>
                                        </head>
                                            <body>
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">========================================================================<br />
                                                ==== &Eacute;STE ES UN MENSAJE GENERADO AUTOM&Aacute;TICAMENTE. NO LO RESPONDAS. ====<br />
                                                ========================================================================</span></span></p>
                                                
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Bienvenido estimado amigo: '."$nombreApellido".' te has registrado como Cliente '.$clinte_tipo.' </span></span></p>
                                                
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Queremos agradecerle por su inter&eacute;s en acceder a nuestro nuevo sitio web.<br />
                                                En nombre de la Corporacion ECRS C.A, deseamos comunicarle nuestros objetivos e ilusiones en el d&iacute;a a d&iacute;a que desarrollamos.</span></span></p>
                                                
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">La calidad de nuestra empresa no reside s&oacute;lo en los productos y servicios que comercializamos, sino tambi&eacute;n en las otras facetas de nuestro negocio: comerciales, de relaciones p&uacute;blicas y de comunicaci&oacute;n.</span></span></p>
                                                
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Por favor conserva este mensaje. Los datos de tu cuenta son los siguientes:</span></span></p>
                                                
                                                <hr />
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Usuario: '."$usuario".'<br />
                                                Contrase&ntilde;a: '."$pass_usuario".'</span></span></p>
                                                
                                                <!--<p> Para activar su cuenta: '."$activacion_url".'</p>-->
                                                
                                                <p> http://ecrs/</p>
                                                
                                                <hr />
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Un cordial saludo.<br />
                                                El equipo de Corporacion ECRS C.A,</span></span></p>
                                                
                                                <p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;"><img alt="" src="http://ecrs.com.ve/images/tope/corporacion-ECRS.png" style="width: 160px; height: 81px;" /></span></span></p>
                                            </body>
                                    </html>
                                                        ';
                                        //Configuracion para el asunto, destinatario, remitente,cuerpo del correo a enviar
                                        $mail->AddAddress($mail_user_nuevo,$nombreApellido); // Correo y Nombre-Apellido del Nuevo Usuario 
                                      
                                      
                                        $mail->Subject = $asunto; // Asunto del Correo
                                        $mail->Body = $body_mail; //HTML Body
                                        $mail->AltBody = "Registro De Nuevo Usuario Sistema Web CORPORACION ECRS C.A"; //Text Body
                                        
                                        if(!$mail->Send())
                                        {
                                        echo "Mailer Error: " . $mail->ErrorInfo;
                                        }
                                        else
                                        {
                                        echo "Message has been sent";
                                        }
        
            
           }else{
            
            echo "Error N";
           } 
           
            /*
            ini_set(sendmail_from,'ro-reply@' . $_SERVER["SERVER_NAME"]);  // the INI lines are to force the From Address to be used !

            $headers .= 'From: ' . SITE_NAME . ' <' . MAIL_FROM . '>'.$eol;
            $headers .= 'Reply-To: ' . SITE_NAME . ' <' . MAIL_FROM . '>'.$eol;
            $headers .= 'Return-Path: ' . SITE_NAME . ' <' . MAIL_FROM . '>'.$eol;    // these two to set reply address
            $headers .= "Message-ID: <".$now." TheSystem@".SERVER_HOST.">".$eol;
            $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters            
            
            @mail("ljimenez@quorion.com.ve", "Hola Mundo", "mensaje", $headers);
            

			//error_log(print_r($arreglovars,true));
			$lc_recipient=$emails;
			if(!file_exists(SERVER_ROOT . "mail_forms/" . $archivo . ".php")){
				die("no existe la plantilla");
			}
			$fp = fopen(SERVER_ROOT . "mail_forms/" . $archivo . ".php", "r"); //la direccion del template
			$lc_message="";
			while(!feof($fp)){
				   $txthtml = $txthtml . fgets($fp, 160000);
			}
			while(list($key, $value) = each($arreglovars)){
				if(is_array($value)){
				$keytemp ='';
					foreach ($value as $valor) {
					 $keytemp .= $valor . ", ";
					}
					$value=$keytemp;
				}
				$txthtml = str_replace("{" . $key . "}", $value, $txthtml);	
			}
			
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
				  $eol="\r\n";
				} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
				  $eol="\r";
				} else {
				  $eol="\n";
				} 
				
				$emailaddress=$lc_recipient;
				# Message Subject
				$emailsubject=$asunto;
				
				$body=$txthtml;    
				# Common Headers
				$headers .= 'From: ' . SITE_NAME . ' <' . MAIL_FROM . '>'.$eol;
				$headers .= 'Reply-To: ' . SITE_NAME . ' <' . MAIL_FROM . '>'.$eol;
				$headers .= 'Return-Path: ' . SITE_NAME . ' <' . MAIL_FROM . '>'.$eol;    // these two to set reply address
				$headers .= "Message-ID: <".$now." TheSystem@".SERVER_HOST.">".$eol;
				$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
				# Boundry for marking the split & Multitype Headers
				$mime_boundary=md5(time());
				$headers .= 'MIME-Version: 1.0'.$eol;
				$headers .= "Content-Type: multipart/related; boundary=\"".$mime_boundary."\"".$eol;
				$msg = "";
								
				//$msg .= "Content-Type: multipart/alternative".$eol;               // comentado por LJ
												
				# HTML Version
				//$msg .= "--".$mime_boundary.$eol;                                 // comentado por LJ
				//$msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;       // comentado por LJ
				//$msg .= "Content-Transfer-Encoding: 8bit".$eol;                   // comentado por LJ
				$msg .= $body.$eol;//.$eol;                                         // comentado por LJ
				
				# Text Version
				/*
				$msg .= "--".$mime_boundary.$eol;
				$msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
				$msg .= "Content-Transfer-Encoding: 8bit".$eol;
				$msg .= "+ + + +".$eol;
				$msg .= "Puede no estar visualizando correctamente este email.".$eol;
				$msg .= "El formato de este email podria estar en HTML, y su lector de correos no es capaz de mostrarlo correctamente.".$eol;
				$msg .= "+ + + +".$eol;
				$msg .= strip_tags(str_replace("<br>", "\n", substr($body, (strpos($body, "<body>")+6)))).$eol.$eol;
				
				
				//echo $msg;
				//exit;
				//extraigo las imagenes a mostrar
				preg_match_all("/\[img\](.+)\[\\/img\]/smU",$msg,$arrAtt);
				
				if(sizeof($arrAtt[1])>0)
					$attachments = $arrAtt[1];
					
					
					//var_dump($attachments);
				//exit;
				//$msg .= serialize($arrAtt[1]);
					
				$contenttypes = array( 'html' => 'text/html',
									   'htm'  => 'text/html',
									   'txt'  => 'text/plain',
									   'gif'  => 'image/gif',
									   'jpg'  => 'image/jpeg',
									   'png'  => 'image/png',
									   'sxw'  => 'application/vnd.sun.xml.writer',
									   'sxg'  => 'application/vnd.sun.xml.writer.global',
									   'sxd'  => 'application/vnd.sun.xml.draw',
									   'sxc'  => 'application/vnd.sun.xml.calc',
									   'sxi'  => 'application/vnd.sun.xml.impress',
									   'xls'  => 'application/vnd.ms-excel',
									   'ppt'  => 'application/vnd.ms-powerpoint',
									   'doc'  => 'application/msword',
									   'rtf'  => 'text/rtf',
									   'zip'  => 'application/zip',
									   'mp3'  => 'audio/mpeg',
									   'pdf'  => 'application/pdf',
									   'tgz'  => 'application/x-gzip',
									   'gz'   => 'application/x-gzip',
									   'vcf'  => 'text/vcf' );
			
				//$attachments[] = array("file" => SERVER_ROOT . "images/logo.gif");
				//echo sizeof($attachments);
				//exit;
				if (sizeof($attachments)>0){
					
					for($i=0; $i < count($attachments); $i++)
					{
					  $from_HTML=false;
					  if(in_array($attachments[$i],$arrAtt[1])){
						if(substr($attachments[$i],0,1)!='/'){
							$attachments[$i] = '/' . $attachments[$i];
						}
						$attachments[$i] = SERVER_ROOT . $attachments[$i];
						$from_HTML=true;
					  }
						
					  if (is_file($attachments[$i]))
					  {  
					  	$ext=trim(substr(strtolower($attachments[$i]),-3,3));
					
						
					  	$content_type = $contenttypes[$ext];

						if(trim($content_type)!=''){
							$content_type = $contenttypes[$ext];
						}else{
							$content_type ="application/octet-stream";
						}
						
					
					 
						# File for Attachment
						$file_name = substr($attachments[$i], (strrpos($attachments[$i], "/")+1));
					   
						$handle=fopen($attachments[$i], 'rb');
						$f_contents=fread($handle, filesize($attachments[$i]));
						$f_contents=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
						$f_type=filetype($attachments[$i]);
						fclose($handle);
					   
						# Attachment 
                        /*                        
						$msg .= "--".$mime_boundary.$eol;
						$msg .= "Content-Type: ". $content_type ."; name=\"".$file_name."\"".$eol;  // sometimes i have to send MS Word, use 'msword' instead of 'pdf'
						$msg .= "Content-Transfer-Encoding: base64".$eol;
						
						
						if($from_HTML){
							$cnt_id= strtoupper(md5($f_contents));
							$msg = str_replace($arrAtt[0][$i],"cid:" . $cnt_id,$msg);
							
							$msg .= "Content-ID: <". $cnt_id . ">" .$eol.$eol;
						}else{
							$msg .= "Content-Description: ".$file_name.$eol;
							$msg .= "Content-Disposition: attachment; filename=\"".$file_name."\"".$eol.$eol; // !! This line needs TWO end of lines !! IMPORTANT !!
						}
						$msg .= $f_contents.$eol.$eol;  
                                            
					  }
					}
				}
				

				//$msg .= "--".$mime_boundary."--".$eol.$eol;  // finish with two eol's for better security. see Injection.
				
				$msg = str_replace("SERVER_ROOT",SERVER_ROOT,$msg);
				$msg = str_replace("WEB_ROOT",WEB_ROOT,$msg);
				
				# METODO NORMAL DE ENVIO
				//error_log($msg);
				ini_set(sendmail_from,'no-reply@' . $_SERVER["SERVER_NAME"]);  // the INI lines are to force the From Address to be used !
				//@mail($emailaddress, $emailsubject, $msg, $headers);
                
//    $tok = strtok($headers, "\r\n");
//    while ($tok !== false) {
//        list($first,$second) = split(":",$tok,2);
//        echo $first.":".$second;
//        $tok = strtok("\r\n");
//    }                 

$postdata = http_build_query(
    array(
        'emailaddress' => $emailaddress,
        'emailsubject' => $emailsubject,
        'msg' => $msg,
        'headers'  => $headers   
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
                
$context  = stream_context_create($opts);
                  
                file_get_contents("http://www.ladobueno.com/email.php",false,$context);
                
                //file_get_contents("http://www.ladobueno.com/email.php?emailaddress=" . $emailaddress . "&emailsubject=" . $emailsubject . "&msg=" . $msg . "&headers=" . $headers);
                //var_dump($emailaddress);
                //var_dump($emailsubject);
                //var_dump($msg);
                //var_dump($headers);
				//@mail("taufpate@gmail.com", $emailsubject, $msg, $headers);
				ini_restore(sendmail_from); 
				
				
				return true;
				
							
				////// METODO ALTERNATIVO DE ENVIO!!!!!!!!! ////
				/*
				require_once(SERVER_ROOT . "includes/libs/xpertmailer/SMTP.php");
				
				define('DISPLAY_XPM4_ERRORS', false); // display XPM4 errors
				
				$f = MAIL_FROM; // from (Gmail mail address)
				$t = $emails; // to mail address
				$p = PASS_SMTP ; // Gmail password
				
				// standard mail message RFC2822

				$m = 'From: ' . SITE_NAME . ' <' . MAIL_FROM . '>'."\r\n".
					 'To: ' . $emails . "\r\n".
					 'Subject: ' . $asunto ."\r\n".
					 'MIME-Version: 1.0'."\r\n".
				     "Content-Type: multipart/related; boundary=\"".$mime_boundary."\""."\r\n\r\n".
					 $msg;
				
				// connect to MTA server (relay) 'smtp.gmail.com' via SSL (TLS encryption) with authentication using port '465' and timeout '10' secounds
				// make sure you have OpenSSL module (extension) enable on your php configuration
				$c = SMTP::connect('smtp.gmail.com', 465, $f, $p, 'tls', 10);// or die(print_r($_RESULT));
				
				// send mail relay
				$s = SMTP::send($c, array($t), $m, $f);
				
				// print result
				if ($s){
					return true;
				}else{
					 error_log($_RESULT);
					 mail('error_tc@taufpate.com', "Error mail todoclon", $_RESULT);
				}
				
				// disconnect
				SMTP::disconnect($c);
				*/
				
		} // fin envio por email enviarForMail
		function month2letter($mes){
			
			$meses =array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			
			return $meses[($mes-1)];
		}
		function formatcurrency($numero){
			return number_format($numero, 2, ".", ",");
		}
		
		function getVarsPag($vars){
			while(list($key, $value) = each($vars)){
					if($key!="page"){
						if(is_array($value)){
							foreach($value as $key2 => $value2)
								$variablesget .= $key .  "[]=" . $value2 . "&";
						}else{
							$variablesget .= "$key=$value&";
						}
					}
			}
			return $variablesget;
		
		}
		
		function llenarComboDbEnum($tabla,$column,$selected='') {
			$sql = "SELECT * FROM information_schema.COLUMNS WHERE table_schema = '" . DB_NAME . "' AND table_name = '" . $tabla . "' and column_name = '" . $column . "'";
			$data = $this->Execute($sql);

			$datos = split(",",str_replace("'","",str_replace('enum(','',substr($data["results"][0]["COLUMN_TYPE"],0,-1))));
					
			foreach($datos as $dato) { 
				$sel = "";
				if($selected == $dato)
					$sel = "selected";
					
				$var .= "<option value='" . $dato . "' " . $sel . ">" . $dato . "</option>";
			}
			
			return $var;
		}
		
		function llenarComboDb($tabla,$campo_pk,$campo_value,$campoPadre="",$valorPadre=0,$selectedVal=0,$funcion='',$orderBy=''){
			$sql = "select " . $this->clearSql_s($campo_pk) . "," . $this->clearSql_s($campo_value) . " from " . $this->clearSql_s($tabla) . " where fk_estatus = 1 ";
			if($campoPadre!=''){
				$sql .= " and " . $this->clearSql_s($campoPadre) . "=" . $this->clearSql_s($valorPadre);
			}
			if($orderBy!='')
				$sql .= " order by " . $orderBy;
			else
				$sql .= " order by $campo_pk desc";
			
				
			//error_log($sql);
			$resultado=$this->Execute($sql);
			$arrtmp=array();
			foreach($resultado["results"] as $key => $value){
				$arrtmp[(string) $value[$campo_pk]]=$value[$campo_value];
			}
			return $this->llenarCombo($arrtmp,$selectedVal,$funcion);
			
		}
		function llenarCombo($arr,$selectedVal=0,$funcion=''){
			foreach($arr as $key => $value){
				if(!is_array($selectedVal))
					$selected = ($key==$selectedVal) ? "selected" : "";
				else
					$selected = in_array($key,$selectedVal) ? "selected" : ""; 
				echo "<option value=\"{$key}\" {$selected}>" . $this->aplicaFuncion($value,$funcion) . "</option>";
			}
		}
		
		function aplicaFuncion($variable='',$funcion=''){
			if(trim($funcion!='')){
				$fin=str_replace("|elemento|",$variable,$funcion). ";";
				$bb="";
				eval("\$bb=" . $fin);
				return $bb;
			}else{
				return $variable;
			}
		}
		
		function removeLastChar($string) {
			return substr($string,0,strlen($string) -1);
		}
		
		function transformarFecha_Es2Ansi($fecha) {
			if(trim($fecha)){
				if(eregi(" ",$fecha)){
					$arr=split(" ",$fecha);
					$fecha = $arr[0];
					$hora = $arr[1];
				}
				if(eregi("-",$fecha)){
					$sep = '-';
				}else{ 
					$sep = '/';
				}
				
				$arr=split($sep,$fecha);
				return $arr[2] . '/' . $arr[1] . '/' .$arr[0] . " " . $hora;
			}
		}
		
		function transformarFecha_Ansi2Es($fecha) {
			$fecha = date("Y-n-d",strtotime($fecha));
			if(trim($fecha)){
				if(eregi("-",$fecha)){
					$sep = '-';
				}else{ 
					$sep = '/';
				}
				$arr=split($sep,$fecha);
				return $arr[2] . '/' . $arr[1] . '/' .$arr[0];
			}
		}
		
		function colorGrid($number,$id='%%%'){
			if($number % 2==0){
				$clase = "row_1";
			}else{
				$clase = "row_2";
			}
			if($id=='%%%'){
				$id = "R_" . $number . substr(md5(microtime() * mktime()),0,5);	
			}
			return 'class="' .$clase . '" onmouseover="cambiaClase(\'' . $id . '\',\'row_over\')" onmouseout="cambiaClase(\'' . $id . '\',\'' . $clase . '\')" id="' . $id . '" ';
		}
		
		function prepareSearchInTabla($post,$fields,$excluyente=0) {
			if(is_array($post))
				foreach($post as $key => $value){
					if(in_array($key,$fields)) {
						if($excluyente == 1) {
							if(is_numeric($value) && $value > 0)
								$arr[$key] = $value;
							else if(trim($value) != "")
								$arr[$key] = $value;
						} else {
							$arr[$key]=$value;
						}
					}
				}
			else { // no me gusta esta solucion pero buehh
				foreach($fields as $key => $value)
					unset($_POST[$value]);
			}
			return $arr;
		}

		function makeJsCalendar($idText,$winid,$format="%Y-%m-%d"){
		
			$rand =  $winid . substr(md5(microtime() * mktime() * rand(1,99999)),0,5);
			
			return '
			
			<img src="/images/others/calendar.png" name="f_' . $rand . '" width="20" height="20" id="f_' . $rand . '" style="cursor: pointer;" title="Date selector"/><br />
			<div id="mc_' . $rand . '" style="width: 188px;"></div>
			<script type="text/javascript">
			Calendar.setup({
				idText  :    "' . $idText . '",
				flat    :    "mc_' . $rand . '",
				flatCallback : dateChanged,
				ifFormat       :    "' . $format . '",
				button         :    "f_' . $rand . '",
				align          :    "Tl",
				singleClick    :    true,
				date		   :	transformDate("' . $idText . '")
			});
			</script>';

		}
		
		function addGeneral($pk,$tabla,$fields,$post) {
			if(intval($post[$pk])>0){//es un edit realmente
				array_push($fields,$pk);
			} else {
				array_push($fields,"fecha_agregado");
				$post["fecha_agregado"]=date("Y/m/d H:i");
			}
			
			array_push($fields,"fecha_modificado");
			$post["fecha_modificado"]=date("Y/m/d H:i");
			
			$arrTemp= array("tabla" => $tabla);
			$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
			
			$id=$this->addEdtTabla($arrTemp);
			if(intval($post[$pk])>0){//es un edit realmente
				$id=$post[$pk];
			}
			
			return $id;
		}
		
		function deleteGeneral($pk,$tabla,$post) {
			if(is_array($post["delete"]))
				foreach($post["delete"] as $key => $value){
					//error_log("update " . $tabla . " set fk_estatus=0 where " . $pk . " = " . intval($value));
					$this->ExecuteAlone("update " . $tabla . " set fk_estatus=0 where " . $pk . " = " . intval($value));
				}
			return true;
		}
		function _format_bytes($a_bytes)
		{
			if ($a_bytes < 1024) {
				return $a_bytes .' B';
			} elseif ($a_bytes < 1048576) {
				return round($a_bytes / 1024, 2) .' KiB';
			} elseif ($a_bytes < 1073741824) {
				return round($a_bytes / 1048576, 2) . ' MiB';
			} elseif ($a_bytes < 1099511627776) {
				return round($a_bytes / 1073741824, 2) . ' GiB';
			} elseif ($a_bytes < 1125899906842624) {
				return round($a_bytes / 1099511627776, 2) .' TiB';
			} elseif ($a_bytes < 1152921504606846976) {
				return round($a_bytes / 1125899906842624, 2) .' PiB';
			} elseif ($a_bytes < 1180591620717411303424) {
				return round($a_bytes / 1152921504606846976, 2) .' EiB';
			} elseif ($a_bytes < 1208925819614629174706176) {
				return round($a_bytes / 1180591620717411303424, 2) .' ZiB';
			} else {
				return round($a_bytes / 1208925819614629174706176, 2) .' YiB';
			}
		}
		
		function agregator($params) {
			?> 
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td>
                    <div class="" style="width: 50%; position:relative; float:left">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <?php
                            $objs = array("tabla"=>$params["table"]);
                            $objData = $this->getTabla($objs);  
                            
                            $variables = preg_match_all("/#\{([^\}]{1,})\}/",$params["template_add"],$matches,PREG_SET_ORDER);
                            foreach($objData["results"] as $item) {
                                $template = $params["template_add"];
                                foreach($matches as $match) {
                                    $template = preg_replace("/#{" . $match[1] . "}/",$item[$match[1]],$template);
                                } 
                                echo $template;
                            } 
                         ?>
                        </table>
                    </div>
                    <div class="" style="width:50%; position:relative; float:left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="agregator_<?=$_POST["winid"]?>">
                    	<tr>
                        <?php
						//cabezara
						if(is_array($params["header"]))
							foreach($params["header"] as $key => $value) {
								?>
								<td width="<?=$value?>"><?=$key?></td>
								<?php
							}
							?>
                        </tr>
                    <?php
                        //cargamos la data ya agregada 
                        $join = array("table_left"=>$params["table"],"pk_left"=>$params["pk"],"table_right"=>$params["table_join"],"pk_right"=>$params["pk_join"]);
                        $objs = array("tabla"=>$params["table_join"],$params["pk_search"]=>$params["pk_search_id"],"join"=>array($join));
                        $objData = $this->getJoinTabla($objs);
                        
                        $variables = preg_match_all("/#\{([^\}]{1,})\}/",$params["template_del"],$matches,PREG_SET_ORDER);
                        foreach($objData["results"] as $item) {
                                $template = $params["template_del"];
                                foreach($matches as $match) {
                                    if(preg_match("/checked_/",$match[1])) {
										preg_match_all("/checked_([\w]{1,})$/",$match[1],$campo,PREG_SET_ORDER);
										if($item[$campo[0][1]] == 1) 
											$item[$match[1]] = "checked";
										else
											$item[$match[1]] = "";
									}
									
									$template = preg_replace("/#{" . $match[1] . "}/",$item[$match[1]],$template);
                                } 
                                echo $template;
                        } ?> 
                    </table>
                    </div>
                </td>
              </tr>
            </table>
            <script language="javascript" type="text/javascript">
                var template_<?=$_POST["winid"]?> = new Template('<?=$params["template_del"]?>');
                agregatorAddItem_<?=$_POST["winid"]?> = function(obj) {
                    $('agregator_<?=$_POST["winid"]?>').insert(template_<?=$_POST["winid"]?>.evaluate(obj));
                }
                
                agregatorDelItem_<?=$_POST["winid"]?> = function(obj) {
                    obj.ancestors()[2].remove();
                }
            </script>
            <?php
		}
		
		function getHTMLByTag($params) {
			$this->onlyID = $params["onlyID"];
			register_shutdown_function("ob_end_flush");
			ob_start(array(&$this,"getHTML"));
			
		}
		
		function getHTML($string) {
			$string = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>' . $string;
			$string .= "</html>";
			$doc = new DOMDocument();
			@$doc->loadHTML($string);
			$elemento = $doc->getElementById($this->onlyID);
			$nodo = $elemento->cloneNode(TRUE);
			//error_log($nodo->get_content());
			return "";
		}
		
		function encode($string,$key=HASH) {
			$orgStr = $string;
			$key = sha1($key);
			$strLen = strlen($string);
			$keyLen = strlen($key);
			for ($i = 0; $i < $strLen; $i++) {
				$ordStr = ord(substr($string,$i,1));
				if ($j == $keyLen) { $j = 0; }
				$ordKey = ord(substr($key,$j,1));
				$j++;
				$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
			}
		
			return md5($orgStr . $key) . $hash;
		}
		
		function decode($string,$key=HASH) {
			$md5 = substr($string,0,32);
			$string = substr($string,32,strlen($string));
			
			$key = sha1($key);
			$strLen = strlen($string);
			$keyLen = strlen($key);
			for ($i = 0; $i < $strLen; $i+=2) {
				$ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
				if ($j == $keyLen) { $j = 0; }
				$ordKey = ord(substr($key,$j,1));
				$j++;
				$hash .= chr($ordStr - $ordKey);
			}
			if(md5($hash . $key)==$md5){
				return $hash;
			}else{
				die("Error 662991;");
			}
		}
		function exportCVS($rs,$campos){
		
			foreach($campos as $key => $value){
				$cuerpo .= $key . ",";
			}
			
			$cuerpo = substr($cuerpo,0,-1) . "\n";
			
			if(sizeof($rs["results"])>0){
				foreach($rs["results"] as $key => $value){
					foreach($campos as $key2 => $value2){
						$cuerpo .= str_replace(",",";",$value[$value2]) . ",";
					}
					$cuerpo = substr($cuerpo,0,-1) . "\n";
				}
			}
			
			
			$fname = date("D-M-Y-H-i-s") . ".csv";
			$fsize = strlen($cuerpo);
			header("HTTP/1.1 200 OK");	
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header('Date: ' . date("D M j G:i:s T Y"));
			header('Last-Modified: ' . date("D M j G:i:s T Y"));
			header("Content-Length: $fsize");
			header("Content-type: application/octet-stream\n");
			header("Content-Disposition: attachment; filename=$fname");
			header("Content-Transfer-Encoding: binary");
			echo $cuerpo;
			exit;
		
		}
		
		function calendar($date){

         if($date == null)
            $date = getDate();

         $day = $date["mday"];
         $month = $date["mon"];
         $month_name = $this->month2letter($month); //$date["month"];
         $year = $date["year"];
		 
		  $arrDays = array("D","L","M","M","J","V","S");

         $this_month = getDate(mktime(0, 0, 0, $month, 1, $year));
         $next_month = getDate(mktime(0, 0, 0, $month + 1, 1, $year));


         $first_week_day = $this_month["wday"];
         $days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));

         $calendar_html = "<table style=\"background-color:666699; color:ffffff;\">";

         $calendar_html .= "<tr><td colspan=\"7\" align=\"center\" style=\"background-color:9999cc; color:000000;\"> <a href=\"JavaScript:void(selMonth(" . $month . "," . $year . ",-1))\">&laquo;</a>&nbsp;&nbsp;&nbsp;" .
                           $month_name . " " . $year . " &nbsp;&nbsp;&nbsp;<a href=\"JavaScript:void(selMonth(" . $month . "," . $year . ",1))\">&raquo;</a></td></tr>";
						   
		$calendar_html .= "<tr>";
		foreach($arrDays as $k=> $v){
			$calendar_html .= "<td align=\"center\">" . $v . "</td>";
		}
		$calendar_html .= "</tr>";

         $calendar_html .= "<tr>";


         for($week_day = 0; $week_day < $first_week_day; $week_day++)
            {
            $calendar_html .= "<td class=\"calCuadrito\"> </td>";
            }

         $week_day = $first_week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0)
               $calendar_html .= "</tr><tr>";


			$onclick = 'onClick="JavaScript:void(selCalendar(' . $day_counter . ',' . $month . ',' . $year . '))"';
            if($day == $day_counter)
               $calendar_html .= "<td align=\"center\" class=\"calCuadrito\" style=\"background-color:#FFFFCC\" " . $onclick . "><b>" . $day_counter . "</b></td>";
            else
               $calendar_html .= "<td align=\"center\"  class=\"calCuadrito\" " . $onclick . ">&nbsp;" .
                                 $day_counter . " </td>";

            $week_day++;
            }

         $calendar_html .= "</tr>";
         $calendar_html .= "</table>";

         return($calendar_html);
         }
		 
		 function completarChr($string,$longitud,$caracter) {
			$numero_total = "";
			$tam = strlen($string);
			$total = $longitud - $tam;
			for($b=1;$b<=$total;$b++) $numero_total .= $caracter;
			return $numero_total .= $string; 
		}
	}
?>