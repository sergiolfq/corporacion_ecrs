<?php
require_once("../../includes/includes.php");
$Mailing = new Mailing;
if(isset($_POST["emailAdd"])){
	$mail = $Mailing->getUser(array("email" => $_POST["emailAdd"]));
	if(sizeof($mail["results"])==0){
    ?>
	El Email indicado no se encuentra registrado
	<?php
	}else{
		foreach($mail["results"] as $key => $value)
		$Mailing->addGroupMembers($value["pk_mailing_user"],$_POST["pk_mailing_group"]);
	?>
	El Email indicado fue agregado
	<?php
	}
}elseif(isset($_POST["pk_mailing_userDel"])){
	$Mailing->delGroupMembers($_POST["pk_mailing_userDel"],$_POST["pk_mailing_group"]);
	?>
	El Email indicado fue eliminado
	<?php

}elseif(isset($_POST["pk_mailing_groupMem"])){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
	  <?php
	  $miembros = $Mailing->getGroupMembers(array("fk_mailing_group" => $_POST["pk_mailing_groupMem"]),10,$_POST["page"]);
	  if(sizeof($miembros["results"])>0){
	  ?>
        <tr>
          <td class="t5">Email</td>
          <td class="t5">&nbsp;</td>
        </tr>
		<?php foreach($miembros["results"] as $key => $value){ ?>
        <tr>
          <td><?=$value["email"]?></td>
          <td><a href="JavaScript:void(eliminarUser(<?=$value["pk_mailing_user"]?>,<?=$_POST["pk_mailing_groupMem"]?>))">Eliminar</a></td>
        </tr>
		<?php } ?>
        <tr>
          <td colspan="2" align="right"><?=$Mailing->paginateResultsAjax($miembros,"members","/admin/ajax_resp/mailing_groups.php");?></td>
          </tr>
		 <?php }else{ ?>
		 <tr>
          <td colspan="2" align="center" class="ntf1">No se encontraron registros</td>
          </tr>
		 <?php } ?>
      </table>
	  <div id="delUserDiv" style="background-color:#CCFF00;"></div>
<?php
}
?>