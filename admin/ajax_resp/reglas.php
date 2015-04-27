<?php
require_once("../../includes/includes.php");
$Textos = new Textos;
$rs = $Textos->getTexto(array("pk_texto" => intval($_POST["i"])));
echo ($rs["results"][0]["texto"]);
?>