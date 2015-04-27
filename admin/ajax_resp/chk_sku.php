<?php
$arr=false;
require_once("../../includes/includes.php");
$Shop = new Shop; 
$rs = $Shop->getProducto(array("sku" => trim($_POST["sku"])));

if(sizeof($rs["results"])==0){
	echo "true";
}else{
	echo "false";
}
?>