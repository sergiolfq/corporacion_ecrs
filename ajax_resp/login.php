<?php
require_once(dirname(dirname(__FILE__)) . "/includes/includes.php");
$Shop = new Shop;
echo $Shop->login($_POST);
?>