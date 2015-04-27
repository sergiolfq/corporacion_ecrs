<?php
/*########################################################################################################
##																										##
## ISOMETRICO.COM																						##
## 																										##
## Programacion por:    	                                     										##
##                   Mauricio A. Duran D. taufpate@taufpate.com                                         ##
##                   										                                            ##
##																										##
## Fecha de Creacion: 	Octubre 2007																	##
## Ultima modificacion: Octubre 2007    																##
## Clase:				mailing																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/

/* 
PENDIENTES

crear grupos de usuarios y que las campa;as se envien unicamente a grupos
guardar el header y el body de la campa;a en la base de datos para no procesar todo el verguero cada vez
agregar las variables de usuario a la campa;a tipo {nombre} por ejemplo
estadisticas de las campa;as

*/

class Mailing extends Common{
	function Mailing(){
		$this->Common();
		$this->mime_boundary=md5(time());
		if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
		  $this->eol="\r\n";
		} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
		  $this->eol="\r";
		} else {
		  $this->eol="\n";
		}
		$this->contenttypes = array( 'html' => 'text/html',
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
	}
	
	function getContenido($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_MAILING_CONTENIDO);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function addContenido($post){
		$fields = array("titulo","texto"); 
		
		if(intval($post["pk_mailing_contenido"])>0){//es un edit realmente
			array_push($fields,"pk_mailing_contenido");
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		
		$arrTemp= array("tabla" => TBL_MAILING_CONTENIDO);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		$id=$this->addEdtTabla($arrTemp);

		if(intval($post["pk_mailing_contenido"])>0){//es un edit realmente
			$id=$post["pk_mailing_contenido"];
		}
		

		return $id;
	}
	
	function editContenido($post){
		return $this->addContenido($post);
	}
	
	function deleteContenido($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_MAILING_CONTENIDO . " set fk_estatus=0 where pk_mailing_contenido=" . $value);
			}
		return true;
	}
	
	function getUser($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_MAILING_USER);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function addUser($post){
		$fields = array("email","nombre","apellido"); 
		
		if(intval($post["pk_mailing_user"])>0){//es un edit realmente
			array_push($fields,"pk_mailing_user");
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		
		$arrTemp= array("tabla" => TBL_MAILING_USER);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		$id=$this->addEdtTabla($arrTemp);

		if(intval($post["pk_mailing_user"])>0){//es un edit realmente
			$id=$post["pk_mailing_user"];
		}

		return $id;
	}
	
	function editUser($post){
		return $this->addUser($post);
	}
	
	function deleteUser($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_MAILING_USER . " set fk_estatus=0 where pk_mailing_user=" . $value);
			}
		return true;
	}
	
	function getCampaign($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_MAILING_CAMPAIGN);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function addCampaign($post){
		$fields = array("titulo","attach_images"); 
		
		if(intval($post["pk_mailing_campaign"])>0){//es un edit realmente
			array_push($fields,"pk_mailing_campaign");
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		
		$arrTemp= array("tabla" => TBL_MAILING_CAMPAIGN);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		$id=$this->addEdtTabla($arrTemp);

		if(intval($post["pk_mailing_campaign"])>0){//es un edit realmente
			$id=$post["pk_mailing_campaign"];
		}
		$Aggregator = new Aggregator();
		$Aggregator->addEdtVsAggregatorByModule($post,array("versus"=>TBL_MAILING_CONTENIDO_VS_CAMPAIGN,"fk"=>"fk_mailing_campaign","fk2"=>"fk_mailing_contenido","id"=>$id));
		$body= $this->constructEmailBody($id);
		$header= $this->constructEmailHeader($id);
		
		$this->Execute("update " . TBL_MAILING_CAMPAIGN . " set header='" . addslashes(gzcompress($header)) . "', body='" . addslashes(gzcompress($body)) . "' where pk_mailing_campaign=" . $id);

		return $id;
	}
	
	function editCampaign($post){
		return $this->addCampaign($post);
	}
	
	function deleteCampaign($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_MAILING_CAMPAIGN . " set fk_estatus=0 where pk_mailing_campaign=" . $value);
			}
		return true;
	}
	
	function getContenidoCampaign($pk_mailing_campaign){
		$sql = "select " . TBL_MAILING_CONTENIDO . ".* from " . TBL_MAILING_CONTENIDO . " inner join " . TBL_MAILING_CONTENIDO_VS_CAMPAIGN . " on " . TBL_MAILING_CONTENIDO . ".pk_mailing_contenido=" . TBL_MAILING_CONTENIDO_VS_CAMPAIGN . ".fk_mailing_contenido where " . TBL_MAILING_CONTENIDO . ".fk_estatus=1 and " . TBL_MAILING_CONTENIDO_VS_CAMPAIGN . ".fk_estatus=1 and " . TBL_MAILING_CONTENIDO_VS_CAMPAIGN . ".fk_mailing_campaign=" . intval($pk_mailing_campaign);
		return $this->Execute($sql);
	
	}
	
	function buildCampaignContent($pk_mailing_campaign){
		$contenidos = $this->getContenidoCampaign($pk_mailing_campaign);
		if(sizeof($contenidos["results"])>0){
			foreach($contenidos["results"] as $key => $value){
				$str .= $value["texto"];
			}
		}

		return $str;
	}
	function getGroup($post='',$page=0,$results_per_page=999) {
		$arr=array("tabla"=>TBL_MAILING_GROUP);
		if(is_array($post))
			foreach($post as $key => $value){
				$arr[$key]=$value;
			}
		return $this->getTabla($arr,$results_per_page,$page);
	}
	
	function addGroup($post){
		$fields = array("titulo"); 
		
		if(intval($post["pk_mailing_group"])>0){//es un edit realmente
			array_push($fields,"pk_mailing_group");
			array_push($fields,"fecha_agregado");
			$post["fecha_agregado"]=date("Y/m/d H:i");
		}
		
		$arrTemp= array("tabla" => TBL_MAILING_GROUP);
		$arrTemp = array_merge($arrTemp,$this->clearSql_Array($fields,$post));
		
		$id=$this->addEdtTabla($arrTemp);

		if(intval($post["pk_mailing_group"])>0){//es un edit realmente
			$id=$post["pk_mailing_group"];
		}
		

		return $id;
	}
	
	function editGroup($post){
		return $this->addGroup($post);
	}
	
	function deleteGroup($post){
		if(is_array($post["delete"]))
			foreach($post["delete"] as $key => $value){
				$this->ExecuteAlone("update " . TBL_MAILING_GROUP . " set fk_estatus=0 where pk_mailing_group=" . $value);
			}
		return true;
	}
	
	function getGroupMembers($vars,$results_per_page=10,$page=0){
	
		$sql = "select " . TBL_MAILING_USER . ".* from " . TBL_MAILING_USER . " inner join " . TBL_MAILING_USER_VS_GROUP . " on " . TBL_MAILING_USER . ".pk_mailing_user=" . TBL_MAILING_USER_VS_GROUP . ".fk_mailing_user where " . TBL_MAILING_USER_VS_GROUP . ".fk_estatus=1 ";
		if(isset($vars["email"])){
			$sql .= " and " . TBL_MAILING_USER . ".email like '%" . $this->clearSql_s($vars["email"]) . "%' ";
		}
		
		$sql .= $this->prepareSqlVars($vars);

		return $this->Execute($sql,$results_per_page,$page);
	}
	
	function addGroupMembers($pk_mailing_user,$pk_mailing_group){
		$sql ="insert into " . TBL_MAILING_USER_VS_GROUP . " (fk_mailing_user,fk_mailing_group) values (" . intval($pk_mailing_user) . "," . intval($pk_mailing_group) . ")";
		$this->ExecuteAlone($sql);
		
	}
	
	function delGroupMembers($pk_mailing_user,$pk_mailing_group){
		$sql ="delete from " . TBL_MAILING_USER_VS_GROUP . " where fk_mailing_user=" .  intval($pk_mailing_user) . " and " . intval($pk_mailing_group) . "";
		$this->ExecuteAlone($sql);
	}
	
	function buildMailContent($pk_mailing_campaign){
		$campaign = $this->getCampaign(array("pk_mailing_campaign" => intval($pk_mailing_campaign)));
		$contenido = $this->buildCampaignContent($pk_mailing_campaign);
		$imagenes = $this->get_images($contenido);
		$links = $this->get_links($contenido);


		if(is_array($links)){ //acomodo los links relativos
			foreach($links as $key => $value){
				if(!eregi("^http",$value) && !eregi("^mailto:",$value)){
					if(substr($value,0,1)=='/'){ //si tiene / inicial se lo quito
						$newLink = WEB_ROOT . substr($value,1,strlen($value));
					}
					$contenido =str_replace($value,$newLink,$contenido);
				}
			}
		}

		if(is_array($imagenes)){
			if($campaign["results"][0]["attach_images"]!=0){ // las imagenes deberan ir atachadas al mail! comienzo a crear el arreglo con todos los attact en base 64
				foreach($imagenes as $key => $value){ //tiene una url externa
					if(eregi("^http",$value)){
						$fileExterno=$this->http_retrieve($value);
						$imgBase64 = chunk_split(base64_encode($fileExterno['body']));
					}else{ //es una imagen que esta en este server
						if(substr($value,0,1)=='/'){ //si tiene / inicial se lo quito
							$fileExterno = SERVER_ROOT . substr($value,1,strlen($value));
						}else{
							$fileExterno = SERVER_ROOT . $value;
						}
						$handle=fopen($fileExterno, 'rb');
						$f_contents=fread($handle, filesize($fileExterno));
						$imgBase64=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
						fclose($handle);
					}
					
					$ext=trim(substr(strtolower(basename($value)),-3,3));
					$content_type = $this->contenttypes[$ext];
					if(trim($content_type)!=''){
						$content_type = $this->contenttypes[$ext];
					}else{
						$content_type ="application/octet-stream";
					}
					//agrego la imagen a un arreglo de imagenes
					$arrImage[] = array("name" => md5($imgBase64), "base" => $imgBase64, "ext" => $ext, "contenttype" => $content_type, "filename" => basename($value)); 
					$newImage="cid:" .md5($imgBase64);
					//la reemplazo por su nuevo cid
					$contenido =str_replace($value,$newImage,$contenido);
				}
			}else{ //reemplazo los links relativos al sitio con la url real del sitio
				foreach($imagenes as $key => $value){
					if(!eregi("^http",$value)){
						if(substr($value,0,1)=='/'){ //si tiene / inicial se lo quito
							$newImage = WEB_ROOT . substr($value,1,strlen($value));
						}
						$contenido =str_replace($value,$newImage,$contenido);
					}
				}
				
			}
		}

		return array("contenido" => $contenido, "imagenes" => $arrImage);
	}
	
	function constructEmailHeader($pk_mailing_campaign){
			if(defined('MAIL_FROM_MAILING')){ 
				$mail_from=MAIL_FROM_MAILING;
				$mail_from_name=MAIL_NAME_FROM_MAILING;
			}else{
				$mail_from='ro-reply@' . $_SERVER["SERVER_NAME"];
				$mail_from_name=SITE_NAME;
			}
			$headers .= 'From: ' . $mail_from_name . ' <' . $mail_from . '>'.$this->eol;
			$headers .= 'Reply-To: ' . $mail_from_name . ' <' . $mail_from . '>'.$this->eol;
			$headers .= 'Return-Path: ' . $mail_from_name . ' <' . $mail_from . '>'.$this->eol;    // these two to set reply address
			$headers .= "Message-ID: <".$now." TheSystem@".SERVER_HOST.">".$this->eol;
			$headers .= "X-Mailer: PHP v".phpversion().$this->eol;          // These two to help avoid spam-filters
			$headers .= 'MIME-Version: 1.0'.$this->eol;
			$headers .= "Content-Type: multipart/related; boundary=\"".$this->mime_boundary."\"".$this->eol;
			return $headers;
	}
	
	function constructEmailBody($pk_mailing_campaign,$attachments=''){
		$arr = $this->buildMailContent($pk_mailing_campaign);
		$arrFiles =$arr["imagenes"];
		$body = $arr["contenido"];
		
		
		$msg = "";
		$msg .= "Content-Type: multipart/alternative".$this->eol;
		# HTML Version
		$msg .= "--".$this->mime_boundary.$this->eol;
		$msg .= "Content-Type: text/html; charset=iso-8859-1".$this->eol;
		$msg .= "Content-Transfer-Encoding: 8bit".$this->eol;
		$msg .=   "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n".
				  "<html>\n".
				  "<head>\n".
				  "<meta content=\"text/html;charset=ISO-8859-1\" http-equiv=\"Content-Type\">\n".
				  "<title></title>\n".
				  "</head>\n<body>\n" . $body . "</body>\n</html>\n" .$this->eol.$this->eol;
		
		# Text Version
		
		$msg .= "--".$this->mime_boundary.$this->eol;
		$msg .= "Content-Type: text/plain; charset=iso-8859-1".$this->eol;
		$msg .= "Content-Transfer-Encoding: 8bit".$this->eol;
		$msg .= "+ + + +".$this->eol;
		$msg .= "Puede no estar visualizando correctamente este email.".$this->eol;
		$msg .= "El formato de este email podria estar en HTML, y su lector de correos no es capaz de mostrarlo correctamente.".$this->eol;
		$msg .= "+ + + +".$this->eol;
		$msg .= strip_tags(str_replace("<br>", "\n", substr($body, (strpos($body, "<body>")+6)))).$this->eol.$this->eol;
		if (is_array($attachments) && sizeof($attachments)>0){
			foreach($attachments as $key => $value){
				$handle=fopen($fileExterno, 'rb');
				$f_contents=fread($handle, filesize($value));
				$fileBase64=chunk_split(base64_encode($f_contents));
				fclose($handle);
				$ext=trim(substr(strtolower(basename($value)),-3,3));
				$content_type = $this->contenttypes[$ext];
				if(trim($content_type)!=''){
					$content_type = $this->contenttypes[$ext];
				}else{
					$content_type ="application/octet-stream";
				}
				//agrego la imagen a un arreglo de imagenes
				$arrFiles[] = array("name" => md5($fileBase64), "base" => $fileBase64, "ext" => $ext, "contenttype" => $content_type, "filename" => basename($value),"attach" => 1);
			}
		}
		if (sizeof($arrFiles)>0){
			foreach($arrFiles as $key => $value){
				$msg .= "--".$this->mime_boundary.$this->eol;
				$msg .= "Content-Type: ". $value["contenttype"] ."; name=\"".$value["filename"]."\"".$this->eol;
				$msg .= "Content-Transfer-Encoding: base64".$this->eol;
				if(intval($value["attach"])==0){
					$msg .= "Content-ID: <". $value["name"] . ">" .$this->eol.$this->eol;
				}else{
					$msg .= "Content-Description: ".$value["filename"].$this->eol;
					$msg .= "Content-Disposition: attachment; filename=\"".$value["filename"]."\"".$this->eol.$this->eol; // !! This line needs TWO end of lines !! IMPORTANT !!
				}
				$msg .= $value["base"].$this->eol.$this->eol;
			}
		}
		# Finished
		$msg .= "--".$this->mime_boundary."--".$this->eol.$this->eol;  // finish with two eol's for better security. see Injection.

		return $msg;
	}
	
	function get_images($str){
		preg_match_all('/<img[^>]*>/im', $str, $imgTags);
		$imgTags = $imgTags[0]; 
		if(sizeof($imgTags)>0){
			foreach($imgTags as $key => $imgTag){
			preg_match('/src="([^"]*)"/i', $imgTag, $srcstr);  
			$temp = $srcstr[1]; 
			$temp = trim($temp);
			$images[] = preg_replace('/\s/', '%20', $temp);
			}
		}
		return $images;
	}
	 
	function get_links($str){
		preg_match_all('/<a[^>]*>/im', $str, $linkTags);
		$linkTags = $linkTags[0];  
		if(sizeof($linkTags)>0){
			foreach($linkTags as $key => $linkTag){
			preg_match('/href="([^"]*)"/i', $linkTag, $srcstr);  
			$temp = $srcstr[1]; 
			$temp = trim($temp);
			$links[] = trim(preg_replace('/\s/', '%20', $temp));
			}
		}
		return $links;
	}
	
	function http_retrieve($url, $followRedirects = true){
	  # Returns array(['url'] array(['headers']) ['body']) on success
	  # Returns array(['url'] ['errornumber'] ['errorstring']) on failure
	  $url = preg_replace('/[\r]|[\n]/', '', $url);       $url_parsed = parse_url($url);
	  if (empty($url_parsed['scheme'])) $url_parsed = parse_url('http://'.$url);
	  $return['url'] = $url_parsed;
	  if(!isset($url_parsed["port"])) $url_parsed["port"] = 80;
	  $return['url']['port'] = $url_parsed["port"];
	  $path = $url_parsed["path"];
	  if(empty($path)) $path="/";
	  if(!empty($url_parsed["query"])) $path .= "?".$url_parsed["query"];
	  $return['url']['path'] = $path;
	  $host = $url_parsed["host"];
	  $foundBody = false;
	  $out = "GET $path HTTP/1.0\r\n";
	  $out .= "Host: $host\r\n";
	  $out .= "Connection: Close\r\n\r\n";
	  if(!$fp = @fsockopen($host, $url_parsed["port"], $errornumber, $errorstring, 5)){
		  $return['errornumber'] = $errornumber;
		  $return['errorstring'] = $errorstring;
		  return $return;
	  }
	  fwrite($fp, $out);
	  $headers = NULL;
	  $body = NULL;
	  while (!feof($fp)) {
		  $s = fgets($fp, 128);
		  if ($s == "\r\n"){
			  $foundBody = true;
			  continue;
		  }
		  if ($foundBody){
			  $body .= $s;
		  }else{
			  if(($followRedirects) && (stristr($s, "location:") != false))
					  return http_retrieve(trim(preg_replace("/location:/i", "", $s)));
			  $headers .= $s;
		  }
	  }
	  fclose($fp);
	  $headers = explode("\n", trim($headers));
	  foreach($headers as $header){
		  if(strpos($header, ':')){
			  list($header, $value) = explode(':', $header);
			  $return['headers'][trim($header)] = trim($value);
		  }else{
			  $return['headers'][substr($header, 0, 4)] = $header;
		  }
	  }
	  $return['body'] = trim($body);
	  return $return;
	}
}
?>