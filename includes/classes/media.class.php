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
## Clase:				media 																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
class Media extends Common{
	function __construct() {
			parent::__construct();
		//$this->mediaType = array("jpg","jpeg","gif","png","bmp","avi","mpg","mpeg","mp4","mov","wma","wmv","asf");
	} 
	
	
	function addImage($id,$file){
		$path = SERVER_ROOT . "media/";
		$ext = $this->getImageExt($file["tmp_name"]);
		@unlink($file["tmp_name"], $path . $id . "." . $ext);
		$this->resizeImage($file["tmp_name"],$path . $id . $ext,1024,768); 
		//move_uploaded_file($file["tmp_name"], $path . $id . $ext);
		chmod($path . $id . $ext,0755);
		@unlink($path . "tb_" . $id . "." . $ext);
		$this->cropCenterImage($path . $id . $ext,75,75,$path . "tb_" . $id . $ext);
			
		return true;
	}
	
	function addVideo($id,$file){
		$path = SERVER_ROOT . "media/";
		@unlink($path . "org_" . $id . "_" . $file["name"]);
		move_uploaded_file($file["tmp_name"], $path . "org_" . $id . "_" . $file["name"]);
		chmod($path . "org_" . $id . "_" . $file["name"],0755);
		$this->encodeVideo("org_" . $id . "_" . $file["name"],$id,".flv",$path);
		
		return $path . $id . ".flv";
		
	}
	
	function getImageExt($imgPath='',$tipoimagen=0){
		if($tipoimagen==0){
			//$tipoimagen = exif_imagetype($imgPath);
			if ( ! function_exists( 'exif_imagetype' ) ) {
				function exif_imagetype ( $filename ) {
					if ( ( list($width, $height, $type, $attr) = getimagesize( $filename ) ) !== false ) {
						$tipoimagen = $type;
					}
				}
			}
		}
			
		switch ($tipoimagen) {
		     case 1:
		        return ".gif";
		        break;
		     case 2:
		        return ".jpg";
		        break;
		     case 3:
		     	return ".png";
		     	break;
		     case 6:
		     	return ".bmp";
		     	break;
		}
		
		return false;	
		
	}
	
	function getMediaExtById($id) {
		if($id==999){
			$id=2;
		}
		$arr = array("gif","jpg","png","swf","psd","bmp","tiff","tiff","jpc","jp2","jpx","jb2","swc","iff","wbmp","xbm");
		return $arr[$id-1];
	}
	
	function resizeImage($srcname,$destname,$maxwidth,$maxheight){
        global $config;
        $oldimg = $srcname;
        $newimg = $destname;

        $imagedata = GetImageSize($oldimg);
        $imagewidth = $imagedata[0];
        $imageheight = $imagedata[1];
        $imagetype = $imagedata[2];

        $shrinkage = 1;
        if ($imagewidth > $maxwidth){
                $shrinkage = $maxwidth/$imagewidth;
        }
        if($shrinkage !=1){
                $dest_height = $shrinkage * $imageheight;
                $dest_width = $maxwidth;
        }else{
                $dest_height=$imageheight;
                $dest_width=$imagewidth;
        }
        if($dest_height > $maxheight){
                $shrinkage = $maxheight/$dest_height;
                $dest_width = $shrinkage * $dest_width;
                $dest_height = $maxheight;
        }
        if($imagetype==2){
                $src_img = imagecreatefromjpeg($oldimg);
                $dst_img = imageCreateTrueColor($dest_width, $dest_height);
                ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
                imagejpeg($dst_img, $newimg, 100);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        }elseif ($imagetype == 3){
                $src_img = imagecreatefrompng($oldimg);
                $dst_img = imageCreateTrueColor($dest_width, $dest_height);
                ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
                imagepng($dst_img, $newimg, 100);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        }elseif ($imagetype == 6){
                $src_img = imagecreatefromwbmp($oldimg);
                $dst_img = imageCreateTrueColor($dest_width, $dest_height);
                ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
                imagewbmp($dst_img, $newimg, 100);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        }else{
                $src_img = imagecreatefromgif($oldimg);
                $dst_img = imageCreateTrueColor($dest_width, $dest_height);
                ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
                imagejpeg($dst_img, $newimg, 100);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        }
	}
	
	function resizePropImage($imgPath,$factor,$destino='',$fac=1){
		if(is_file($imgPath)){
			$tipoimagen = @getimagesize($imgPath);
			$tipoimagen=$tipoimagen[2];
			switch ($tipoimagen) {
				 case 1:
					$imgorigen = @imagecreatefromgif($imgPath);
					break;
				 case 2:
					$imgorigen = @imagecreatefromjpeg($imgPath);
					break;
				 case 3:
					$imgorigen = @imagecreatefrompng($imgPath);
					break;
				 case 6:
					$imgorigen = @imagecreatefromwbmp($imgPath);
					break;
			}
			$ancho = @imagesx($imgorigen);
			$alto= @imagesy($imgorigen);
		}else{
			$imgorigen =$imgPath[0];
			$tipoimagen=$imgPath[1];
			$ancho = $imgPath[2];
			$alto= $imgPath[3];
		}
		
		if($ancho>=$alto && $fac==1){
			if ($ancho>$factor)
				$factorresize = $ancho / $factor;
			else
				$factorresize=1;
		}else{
			if ($alto>$factor)
				$factorresize= $alto / $factor;
			else
				$factorresize=1;
		}
		//$imgdestino = @imagecreatetruecolor(($ancho / $factorresize) - 1,($alto / $factorresize) - 1);
		$imgdestino = @imagecreatetruecolor(($ancho / $factorresize) ,($alto / $factorresize) );
		if($factorresize>0){
			//$altodestino = ($alto - 1) / $factorresize;
			//$anchodestino = ($ancho - 1) / $factorresize;
			
			$altodestino = ($alto ) / $factorresize;
			$anchodestino = ($ancho ) / $factorresize;
		}
		$fondo=@imagecolorAllocate($imgdestino,255,255,255);
		@imagefill($imgdestino,0,0,$fondo);
		@imagecopyresampled($imgdestino,$imgorigen,0,0,0,0,$anchodestino,$altodestino,$ancho,$alto);
		$img = array();
		$img[0]=$imgdestino;
		$img[1]=$tipoimagen;
		$img[2]=$anchodestino;
		$img[3]=$altodestino;
		if($destino!='')
			$this->_saveImage($img,$destino);
			else
				return $img;

	}
	
	function cropCenterImage($imgPath,$wB,$hB,$destino=''){
		$factor = ($wB>=$hB) ? $wB : $hB;
		$imgPath=$this->resizePropImage($imgPath,$factor,'',0);
		if(is_file($imgPath)){
			$tipoimagen = getimagesize($imgPath);
			$tipoimagen=$tipoimagen[2];
			switch ($tipoimagen) {
				 case 1:
					$imgorigen = @imagecreatefromgif($imgPath);
					break;
				 case 2:
					$imgorigen = @imagecreatefromjpeg($imgPath);
					break;
				 case 3:
					$imgorigen = @imagecreatefrompng($imgPath);
					break;
				 case 6:
					$imgorigen = @imagecreatefromwbmp($imgPath);
					break;
			}
			$ancho = @imagesx($imgorigen);
			$alto= @imagesy($imgorigen);
		}else{
			$imgorigen =$imgPath[0];
			$tipoimagen=$imgPath[1];
			$ancho = $imgPath[2];
			$alto= $imgPath[3];
		}
		$xa= ceil(($ancho-$wB)/2);
		$ya= ceil(($alto-$hB)/2);
		$imgdestino = imagecreatetruecolor($wB,$hB);
		$fondo=imagecolorAllocate($imgdestino,255,255,255);
		@imagecopymerge($imgdestino, $imgorigen, 0, 0, $xa, $ya, $wB, $hB,100);
		@imagefilledrectangle ($imgdestino, 0, 0, ceil(($wB-$ancho)/2),$hB, $fondo); //para rellenar los lados negros (left)
		//@imagefilledrectangle ($imgdestino, $wB-round(($wB-$ancho)/2)-1, 0, $wB,$hB, $fondo); //para rellenar los lados negros (right)
		@imagefilledrectangle ($imgdestino, $wB-ceil(($wB-$ancho)/2), 0, $wB,$hB, $fondo);
		@imagefilledrectangle ($imgdestino, 0, 0, $wB,ceil(($hB-$alto)/2), $fondo); //para rellenar los lados negros (top)
		//@imagefilledrectangle ($imgdestino, 0, $hB-round(($hB-$alto)/2)-1, $wB,$hB, $fondo); //para rellenar los lados negros (down)
		@imagefilledrectangle ($imgdestino, 0, $hB-ceil(($hB-$alto)/2), $wB,$hB, $fondo);
		$img = array();
		$img[0]=$imgdestino;
		$img[1]=$tipoimagen;
		$img[2]=$wB;
		$img[3]=$hB;
		if($destino!='')
			$this->_saveImage($img,$destino);
		else
				return $img;
	}
	function _saveImage($imagen,$imgDestino){
		switch ($imagen[1]) {
		     case 1:
		        @imagegif($imagen[0],$imgDestino,100);
		        break;
		     case 2:
				@imagejpeg($imagen[0],$imgDestino,100);
		        break;
		     case 3:
		     	@imagepng($imagen[0],$imgDestino);
		     	break;
		     case 6:
		     	@imagewbmp($imagen[0],$imgDestino);
		     	break;
		}
		chmod($imgDestino,0777);
	}
	function _sendImage($imagen){
		switch ($imagen[1]) {
		     case 1:
				header("Content-type: image/gif");
		        @imagegif($imagen[0]);
		        break;
		     case 2:
			 	header("Content-type: image/jpeg");
				@imagejpeg($imagen[0]);
		        break;
		     case 3:
			 	header("Content-type: image/png");
		     	@imagepng($imagen[0]);
		     	break;
		     case 6:
				header("Content-type: image/vnd.wap.wbmp");
		     	@imagewbmp($imagen[0]);
		     	break;
		}
		exit;
	} 
	function encodeVideo($video,$nombre='',$formato='.flv',$path='',$size='320x240'){
			if($path=='')
				$path=SERVER_ROOT . "media/";
			$errFlag=0;
			$flvtmp = split("\.",$video);	
			$origen =$path . $video;
			
			if($nombre=='')
				$destino=$path . $flvtmp[0] . $formato;
			else
				$destino=$path . $nombre .  $formato;
			
			$commands = array();
			//echo 'ffmpeg -y -i ' . $origen . ' -acodec mp3 -ar 22050 -ab 32 -f flv -s ' . $size . ' -r 12 ' . $destino . ' > ' . $path . 'Log';
			

			
			exec('ffmpeg -y -i ' . escapeshellarg($origen) . ' -acodec mp3 -ar 22050 -ab 32 -f flv -s ' . $size . ' -r 12 ' . $destino . ' > ' . $path . 'Log',$retorno1,$retorno2);
			//error_log( "-1-> " . $retorno1 . " -2-> " . $retorno2);
			sleep(5);
			//var_dump($retorno);nice -n -10 
			
			if($retorno2!=0){
				unlink($destino);
				exec("mencoder " . escapeshellarg($origen) . " -vf scale=320:240 -ofps 30000/1001 -ovc lavc -lavcopts vcodec=mpeg2video:aspect=4/3 -oac lavc -lavcopts acodec=mp2 -o " . escapeshellarg($path . $flvtmp[0] . ".mpg"));
				
				exec('ffmpeg -y -i ' . escapeshellarg($path . $flvtmp[0] . ".mpg") . ' -acodec mp3 -ar 22050 -ab 32 -f flv -s ' . $size . ' -r 12 ' . $destino);
				sleep(5);
				exec("rm -f " . $path . $flvtmp[0] . ".mpg");
					
			}
			
			exec("cat " . $destino . " | flvtool2 -U stdin " . $destino);
			if($this->video_to_frame($origen,$path,$nombre))
				unlink($origen);	


	}
	
	function video_to_frame($video,$path,$nombre){
		$mov = new ffmpeg_movie($video);
        $frcount=$mov->getFrameCount()-1;
		$p = rand(1,$frcount);
		$ff_frame= $mov->getFrame($p);
		sleep(3);
		if($ff_frame==true){
			$gd_image = $ff_frame->toGDImage();
			$ff=$path . "tb_" . $nombre . ".jpg";
			imagejpeg($gd_image, $ff);
			$fd=$path . "tb_" . $nombre . ".jpg";
			$this->cropCenterImage($ff,75,75,$fd);
			//$this->resizePropImage($ff,100,$fd);
		}
		sleep(2);
		return true;
	}	
}
?>
