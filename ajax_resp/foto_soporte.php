<?php
require("../includes/includes.php");
$Media = new Media; 
if(isset($_GET["f"])){
echo $Media->_sendImage($Media->resizePropImage(SERVER_ROOT . "images/products/pic_1_" . intval($_GET["f"]) . ".jpg",300)); 
}else{
	echo $Media->_sendImage($Media->resizePropImage(SERVER_ROOT . "images/products/pic_1_" . intval($_GET["a"]) . ".jpg",110)); 
}
?>