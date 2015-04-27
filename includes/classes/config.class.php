<?php

/*
if(!isset($_GET["ss"])){
	echo "En mantenimiento";
	exit;
}
*/
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
## Clase:				config 																	  		##
## Version:				0.1																				##
## Licencia:		Todos los derechos reservados al autor												##
## Comentarios:		Si vas a usar esta clase (o parte de ella), cambiarla o adaptarla,					##
## 					enviame un e-mail, vamos que es gratis y no te tomara ni 3 minutos :-)				##
## 																										##
########################################################################################################*/
	class Config {
		function __construct() {
			$this->dbTables();
		}
		
		function dbTables(){
			$global_vars = array(
			
				"LANGUAGE"		=>"es",
				
				//site info
				"SITE_NAME"		=>"ECRS",
				"MAIL_FROM"		=>"no-reply@ecrs.com.ve",
				"MAIL_PEDIDOS"		=>"josemejicano82@gmail.com",
				"MAIL_CONTACTO"		=>"contactenos@ecrs.com.ve",
				"PASS_SMTP"		=>"ifG8u_6",
	 		
				//relative paths  

				"WEB_ROOT"		=>"http://ecrs/",
				"RELATIVE_ROOT"		=>"/",
				"SERVER_ROOT"		=>$_SERVER['DOCUMENT_ROOT'] . "/",  
				"SERVER_HOST"		=>"ecrs.com.ve", 
				
				"HASH"				=>"#@wef#$%GFE>.",
				
				"realm"             =>"Admin  ID: ",
				"auth_error"        =>"Acceso No Autorizado", 
				

				
				"db_host"                                       =>                      "localhost",
				"db_user"                                       =>                      "ecrs_siteuser",
				"db_password"                    		=>                      "15022413",
				"db_port"                                       =>                      "3306",
				"db_name"                                       =>                      "ecrs_website",	

				"results_per_page"          =>          "10"

				
			);	
			
			$global_tables = array(
				"tbl_estatus"					=>			"tbl_estatus",
				
				"tbl_administradores"				=>			"tbl_administradores",
				"tbl_administradores_permisos"			=>			"tbl_administradores_permisos",
				"tbl_administradores_vs_permisos"		=>			"tbl_administradores_vs_permisos",
				
				
				"tbl_encuestas"					=>			"tbl_encuestas",
				"tbl_encuestas_respuestas"			=>			"tbl_encuestas_respuestas",
				
				"tbl_noticias"					=>			"tbl_noticias",
				
				"tbl_categorias"				=>			"tbl_categorias",
				
				"tbl_fabricantes"				=>			"tbl_fabricantes",
				
				"tbl_productos"					=>			"tbl_productos",
				"tbl_productos_relacionados"			=>			"tbl_productos_relacionados",
				"tbl_productos_vs_categorias"			=>			"tbl_productos_vs_categorias",
				"tbl_productos_vs_proveedores"			=>			"tbl_productos_vs_proveedores",
				
				"tbl_proveedores"				=>			"tbl_proveedores",
				
				"tbl_tickets"					=>			"tbl_tickets",
				"tbl_tickets_tipo"				=>			"tbl_tickets_tipo",
				"tbl_tickets_detalle"				=>			"tbl_tickets_detalle",
				"tbl_tickets_estados"				=>			"tbl_tickets_estados",
				
				"tbl_usuarios"					=>			"tbl_usuarios",
				"tbl_usuarios_direcciones"			=>			"tbl_usuarios_direcciones",
				
				"tbl_paises"					=>			"tbl_paises",
				"tbl_estados"					=>			"tbl_estados",
				"tbl_ciudades"					=>			"tbl_ciudades",
				
				"tbl_banners"					=>			"tbl_banners",
				"tbl_banners_zonas"				=>			"tbl_banners_zonas",
				"tbl_banners_vs_zonas"				=>			"tbl_banners_vs_zonas",	
				
				"tbl_textos"					=>			"tbl_textos",	
				
				"tbl_ordenes"					=>			"tbl_ordenes",	
				"tbl_ordenes_detalle"				=>			"tbl_ordenes_detalle",
				"tbl_ordenes_estado"				=>			"tbl_ordenes_estado",	
				"tbl_ordenes_detalle_variante"			=>			"tbl_ordenes_detalle_variante",
				
				"tbl_common_words"				=>			"tbl_common_words",	
				
				"tbl_modo_pago"					=>			"tbl_modo_pago",	
				
				"tbl_productos_home"				=>			"tbl_productos_home",
				
				"tbl_caracteristicas"				=>			"tbl_caracteristicas",
				
				"tbl_testimonios"				=>			"tbl_testimonios",
				
			
				
				"tbl_productos_vs_caracteristicas"		=>			"tbl_productos_vs_caracteristicas",
				
				"tbl_productos_combinables"			=>			"tbl_productos_combinables",
				

				
				"tbl_articulos"					=>			"tbl_articulos",
				"tbl_articulos_tipo"				=>			"tbl_articulos_tipo",
				
				"tbl_articulos_vs_categorias"			=>			"tbl_articulos_vs_categorias",
				"tbl_articulos_vs_productos"			=>			"tbl_articulos_vs_productos",
				
				"tbl_tpv_mercantil"				=>			"tbl_tpv_mercantil",
				
				
				"tbl_variantes_tipo"				=>			"tbl_variantes_tipo",
				"tbl_variantes"					=>			"tbl_variantes",
				"tbl_productos_vs_variantes_tipo"		=>			"tbl_productos_vs_variantes_tipo",
				"tbl_soporte_categorias"			=>			"tbl_soporte_categorias",
				"tbl_soporte_descargas"				=>			"tbl_soporte_descargas",
				"tbl_soporte_descargas_vs_productos"		=>			"tbl_soporte_descargas_vs_productos",
				"tbl_soporte_descargas_vs_categorias"		=>			"tbl_soporte_descargas_vs_categorias",
				"tbl_usuarios_tipo"				=>			"tbl_usuarios_tipo",
				
				"tbl_traza"					=>			"tbl_traza",

			);	
			

			if(!defined('SITE_NAME')){
				while (list($key, $value) = each($global_tables)) {
					define(strtoupper($key), $value);
				}
				
				while (list($key, $value) = each($global_vars)) {
					define(strtoupper($key), $value);
				}
			}
		}
		
	}
?>