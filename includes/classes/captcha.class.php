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
## Clase:				captcha																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
class Captcha extends Common{
	function __construct(){
		parent::__construct();	
		$sid= @session_id();
		if(trim($sid)==''){
			@session_start();
		} 
$this->imgBase64="iVBORw0KGgoAAAANSUhEUgAAADoAAAAaCAYAAAGREH+IAAAACXBIWXMAAAsTAAALEwEAmpwYAAAK
TWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVN3WJP3Fj7f92UPVkLY8LGXbIEAIiOsCMgQ
WaIQkgBhhBASQMWFiApWFBURnEhVxILVCkidiOKgKLhnQYqIWotVXDjuH9yntX167+3t+9f7vOec
5/zOec8PgBESJpHmomoAOVKFPDrYH49PSMTJvYACFUjgBCAQ5svCZwXFAADwA3l4fnSwP/wBr28A
AgBw1S4kEsfh/4O6UCZXACCRAOAiEucLAZBSAMguVMgUAMgYALBTs2QKAJQAAGx5fEIiAKoNAOz0
ST4FANipk9wXANiiHKkIAI0BAJkoRyQCQLsAYFWBUiwCwMIAoKxAIi4EwK4BgFm2MkcCgL0FAHaO
WJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHi
wmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryM
AgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0l
YqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHi
NLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYA
QH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6c
wR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBie
whi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1c
QPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqO
Y4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hM
WEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgoh
JZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSU
Eko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/p
dLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Y
b1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7O
UndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsb
di97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W
7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83
MDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxr
PGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW
2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1
U27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd
8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H0
8PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+H
vqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsG
Lww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjg
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
QmCC
";
	
	}
	
	function encode_img($img){
		$fd = fopen ($img, 'rb');
		$size=filesize ($img);
		$cont = fread ($fd, $size);
		fclose ($fd);
		$encimg = base64_encode($cont);
		return $encimg;
  	}
	
	function generate(){
		unset($_SESSION["captcha"]);
		$textC = substr(md5(microtime() * mktime()),0,5); 
		$data=base64_decode($this->imgBase64);
		
	
		
		$captcha = imagecreatefromstring($data);
		
		$black = imagecolorallocate($captcha, 0, 0, 0);
		$line = imagecolorallocate($captcha,233,239,239); 
		
		//imageline($captcha,0,0,39,29,$line);
		//imageline($captcha,40,0,64,29,$line);
		imagestring($captcha, 5, 7, 5, $textC, $black); 
		
		
		if ($captcha !== false) {
			$_SESSION["captcha"]=$textC;
			header('Content-Type: image/png');
			imagepng($captcha);
		}
		else {
			echo 'An error occurred.';
		}
	}
	
	function verify($captcha){
		if(strtolower(trim($captcha))==strtolower($_SESSION["captcha"])){
			unset($_SESSION["captcha"]);
			return true;
		}else{
			return false;
		}
	}
}
?>