<?php
$arr=false;
require_once("../includes/includes.php");
$Shop = new Shop; 
if(isset($_POST["email"])){
	$arr=$Shop->searchEmail($_POST);
}
if($arr){
	echo "true";
}else{
	echo "false";
}
?>
