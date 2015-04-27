<?php

@header('Content-Type: text/html; charset=iso-8859-1');
require_once(dirname(__FILE__) . "/../../includes/includes.php");
$Aggregator = new Aggregator();


if(isset($_POST["palabra"])) { 
	$AGGvars = unserialize(urldecode(base64_decode($_POST["AGGvars"])));
}elseif(!isset($AGGvars["hash"])){
	$AGGvars["hash"] = md5(microtime() * mktime() * rand(0,99999999));
}

$recursos = $Aggregator->busquedaVsAggregator($AGGvars,$_POST,5,intval($_POST["page"]));

if(isset($_POST["palabra"]) || isset($primero_include)){

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="brd1">
			  <tr>
				<td class="t5">Elemento</td>
				<td width="11%" class="t5">&nbsp;</td>
			  </tr>
			  <?php foreach($recursos["results"] as $key => $recurso) {?>
			  <tr>
				<td class="txt1" id="<?=$AGGvars["hash"]?>_<?=$recurso[$AGGvars["pk"]]?>"><?=utf8_decode(str_replace("'","",$recurso[$AGGvars["campo_buscar"]]))?></td>
				<td align="right" class="txt1"><a href="javascript:void(cargar_<?=$AGGvars["hash"]?>('pk=<?=$recurso[$AGGvars["pk"]]?>&<?=$AGGvars["campo_buscar"]?>=<?=str_replace("'","",$recurso[$AGGvars["campo_buscar"]])?>&mode=1&AGGvars=<?=urlencode(base64_encode(serialize($AGGvars))) ?>','<?=$recurso[$AGGvars["pk"]]?>'))"><img src="/images/admin/add.png" width="16" height="16" border="0" /></a></td>
			  </tr>
			  <?php } ?>
			  <tr>
				<td colspan="2" class="txt1"><?=$Aggregator->paginateResultsAjax($recursos,'div' . $AGGvars["hash"],"modules/vs_aggregator.php",array("palabra"=>$_POST["palabra"],"AGGvars"=>urlencode(base64_encode(serialize($AGGvars)))))?></td>
				</tr>
</table>
<?php           
}else{
	
?>           
            
<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="50%">
			 <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="4" align="center" class="t1">Buscar
				  <input type="text" name="buscar" id="buscar" onKeyUp="new Ajax.Updater('div<?=$AGGvars["hash"]?>','modules/vs_aggregator.php',{parameters:'palabra=' + encodeURIComponent(this.value) + '&AGGvars=<?=urlencode(base64_encode(serialize($AGGvars))) ?>'});"></td>
			</tr>
			</table>
		
			<div id="div<?=$AGGvars["hash"]?>">
				<?php 
				$primero_include=true;
				include(__FILE__);
				?>
			</div>

			<td width="50%" align="center"><table width="85%" border="0" cellspacing="0" cellpadding="0"  class="brd1"> 
			  <tr>
				<td>
				<div id="<?=$AGGvars["hash"]?>_mensaje" style="display:none; text-align: center"><b>El elemento ya se encuentra en esta lista</b></div>
				<ul id="<?=$AGGvars["hash"]?>_cargados">
                <?php
				$elementos = $Aggregator->getVsAggregatorByModule($AGGvars,$_GET["edt"]); 
				foreach($elementos["results"] as $key => $value){
?>
                
		<li id="<?=$AGGvars["hash"]?><?=$value[$AGGvars["pk"]]?>" class="lista_<?=$AGGvars["hash"]?>">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="90%" align="left"><?=($value[$AGGvars["campo_buscar"]])?></td>
			  <td width="10%" align="left"><a href="javascript:void($('<?=$AGGvars["hash"]?><?=$value[$AGGvars["pk"]]?>').remove());"><img src="/images/admin/action_stop.gif" width="16" height="16" border="0" /></a>
		      <input type='hidden' name='<?=$AGGvars["fk_1"]?>[]' value='<?=$value[$AGGvars["pk"]]?>' id="ppps_<?=$AGGvars["hash"]?>_<?=$value[$AGGvars["pk"]]?>"/></td>
			</tr>
		</table> 
		</li>  
        
        
              <?php } ?>
            
				</ul>
				</td>
			  </tr>
			</table></td>
		  </tr>
		</table>
<script language="javascript">
var agregadas<?=$AGGvars["hash"]?> = new Array;
cargar_<?=$AGGvars["hash"]?> = function(parametros,pk) {
	$('<?=$AGGvars["hash"]?>_mensaje').hide();
	if($('ppps_<?=$AGGvars["hash"]?>_' + pk)) {
		$('<?=$AGGvars["hash"]?>_mensaje').show();
	} else {
			
			
			str = '<li id="<?=$AGGvars["hash"]?>' + pk + '" class="lista_<?=$AGGvars["hash"]?>"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
			
			str+= '<td width="90%" align="left">' + $('<?=$AGGvars["hash"]?>_'+pk).innerHTML + '</td>';
			
			
			str+= '<td width="10%" align="left"><a href="javascript:void($(\'<?=$AGGvars["hash"]?>' + pk + '\').remove());" onclick="agregadas<?=$AGGvars["hash"]?>[' + pk + '] = 0;"><img src="/images/admin/action_stop.gif" width="16" height="16" border="0" /></a><input type="hidden" name="<?=$AGGvars["fk_1"]?>[]" value="' + pk + '"  id="ppps_<?=$AGGvars["hash"]?>_' + pk + '"/></td>'
			
			
			str+= '</tr></table></li>';
				
			$('<?=$AGGvars["hash"]?>_cargados').innerHTML +=str;
	}
}

<?php
if($_GET["edt"] > 0) {
	foreach($elementos["results"] as $key => $recurso) {
		echo "agregadas" . $AGGvars["hash"] . "[" .  $recurso[$AGGvars["pk"]] . "] = 1;\n";
	}
}
?>

</script> 
<?php 
unset($primero_include);
unset($AGGvars);
unset($recursos);
} 

?>














