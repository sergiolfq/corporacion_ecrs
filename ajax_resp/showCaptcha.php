<?php
require("../includes/includes.php");
$captcha = new Captcha;
$data =$captcha->generate();  
?>