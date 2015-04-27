<?php
$Admin->chkPermisosAdmin(4);

$Banners = new Banners;

if(intval($_POST["pk_banner"])==0 && trim($_POST["banner"])!=""){
	$Banners->addBanner($_POST,$_FILES);
	//unset($_POST);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_banner"])>0){
	$Banners->editBanner($_POST,$_FILES);
	//unset($_POST);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Banners->deleteBanner($_POST);
	$mensaje="Los elementos selecionados fueron eliminados";
}

if(intval($_GET["edt"])>0){
	$arr = array("pk_banner" => intval($_GET["edt"]));
	$rs = $Banners->getBanner($arr);
}

 if (trim($mensaje) != ''){ ?>
    <div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?= $mensaje; ?></div><br></div>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0" class="brd1">
    <tr>
      <td colspan="2" class="t1"><span style="float:left ">
        <?php if(isset($_GET["edt"])){?>
        Editar
        <?php } else{ ?>
        Agregar
        <?php } ?>
        </span>
          <?php if(isset($_GET["edt"])){?>
        <span style="float:right;"><a href="?module=<?=$_GET["module"]?>" class="t1">Nuevo </a></span>
        <?php } ?></td>
    </tr>
    <tr>
      <td width="20%" valign="top" class="t3">Banner</td>
      <td valign="top"><input name="banner" type="text" id="banner" value="<?=$rs["results"][0]["banner"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_banner" type="hidden" id="pk_banner" value="<?=$rs["results"][0]["pk_banner"]?>" /></td>
    </tr>
    <tr>
      <td width="15%" valign="top" class="t3">Idioma</td>
      <td valign="top"><select name="locale" id="locale">
	  <option value="">Espa&ntilde;ol</option>
      <option value="_en" <?php if($rs["results"][0]["locale"]=='_en'){ ?> selected="selected"<?php } ?>>Ingl&eacute;s</option>
      </select>      </td>
	</tr>
	<tr>
      <td width="15%" valign="top" class="t3">Estatus</td>
      <td valign="top"><select name="fk_estatus" id="fk_estatus">
	  <?php $Common->llenarComboDb(TBL_ESTATUS,"pk_estatus","estatus","",0,intval($rs["results"][0]["fk_estatus"]),"","pk_estatus asc"); ?>
      </select>      </td>
	</tr>
    <tr>
      <td width="15%" valign="top" class="t3">Categor&iacute;a (s&oacute;lo si aplica)</td>
      <td valign="top"><select name="fk_libre" id="fk_libre">
   	   <option value="0">No aplica</option>
	  <?php $Common->llenarComboDb(TBL_CATEGORIAS,"pk_categoria","categoria","fk_categoria_padre",0,intval($rs["results"][0]["fk_libre"]),"","categoria asc"); ?>
      </select>      </td>
	</tr>
	<tr>
      <td width="20%" valign="top" class="t3">Tipo:</td>
      <td valign="top"><span class="t3"><input name="tipo_banner" type="radio" value="0" <?php if(intval($rs["results"][0]["tipo_banner"])==0){ ?> checked="checked" <?php } ?> onclick="bannertype(this.value)" />
      Im&aacute;gen 
      <input name="tipo_banner" type="radio" value="1" <?php if(intval($rs["results"][0]["tipo_banner"])==1){ ?> checked="checked" <?php } ?> onclick="bannertype(this.value)" />
      C&oacute;digo HTML 
      <input name="tipo_banner" type="radio" value="2" <?php if(intval($rs["results"][0]["tipo_banner"])==2){ ?> checked="checked" <?php } ?> onclick="bannertype(this.value)" /> 
      Flash
</span></td>
    </tr>
	<tr id="btipo0" style="display:none;">
      <td width="10%" valign="top" class="t3">Im&aacute;gen</td>
      <td valign="top"><input name="imagen" type="file" id="imagen" />
	  <?php if(file_exists(SERVER_ROOT . "images/banners/" . intval($rs["results"][0]["pk_banner"]) . $rs["results"][0]["extension"])) { ?>
      <a href="javascript:void(window.open('viewpic.php?foto=/images/banners/<?=$rs["results"][0]["pk_banner"]?><?=trim($rs["results"][0]["extension"])?>' ,'foto<?=$rs["results"][0]["pk_banner"]?>','width=50,height=50'))">(ver imagen actual)</a>      
	  <?php } ?></td>
	</tr>
	 <tr id="btipo1" style="display:none;">
      <td width="10%" valign="top" class="t3">C&oacute;digo HTML </td>
      <td valign="top"><textarea name="codigo" cols="50" rows="6" id="direccion"><?=$rs["results"][0]["codigo"]?></textarea></td>
    </tr>
	<tr id="btipo2" style="display:none;">
      <td width="10%" valign="top" class="t3">Flash</td>
      <td valign="top" class="t3"><input name="flash" type="file" id="flash" />
      width: 
        <input name="fwidth" type="text" id="fwidth" size="4" maxlength="4" value="<?=$rs["results"][0]["fwidth"]?>" />
      height: 
      <input name="fheight" type="text" id="fheight" size="4" maxlength="4" value="<?=$rs["results"][0]["fheight"]?>" /></td>
    </tr>
	<tr>
      <td width="20%" valign="top" class="t3">Target:</td>
      <td valign="top"><select name="target" id="target">
        <option value="_blank"<?php if($rs["results"][0]["target"]=='_blank'){?> selected="selected"<?php } ?>>Nueva ventana</option>
        <option value="_self"<?php if($rs["results"][0]["target"]=='_self'){?> selected="selected"<?php } ?>>Misma ventana</option>
      </select>
      </td>
	</tr>
	 <tr>
      <td width="20%" valign="top" class="t3">Link:</td>
      <td valign="top"><input name="href" type="text" id="href" value="<?php if(substr($rs["results"][0]["href"],0,1)!='/'){echo "http://" . eregi_replace("http://","",$rs["results"][0]["href"]);}else{echo $rs["results"][0]["href"];}?>" size="50" maxlength="255" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Fecha inicio: </td>
      <td valign="top"><input type="text" name="fecha_ini" id="fecha_ini" readonly="1" value="<?=date("Y-m-d",strtotime($rs["results"][0]["fecha_ini"]))?>" class="required" />
        <img id="f_trigger_c" title="Date selector" style="cursor: pointer;" src="/images/admin/24px-Crystal_Clear_app_date.png"/>
        <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_ini",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script></td>
    </tr>
	 <tr>
      <td width="10%" valign="top" class="t3">Fecha fin: </td>
      <td valign="top"><input type="text" name="fecha_fin" id="fecha_fin" readonly="1" value="<?php if(isset($rs["results"][0]["fecha_fin"])){ echo date("Y-m-d",strtotime($rs["results"][0]["fecha_fin"])); }else{ echo date("Y-m-d",strtotime("2020/12/31")); }?>" class="required" />
        <img id="f_trigger_c2" title="Date selector" style="cursor: pointer;" src="/images/admin/24px-Crystal_Clear_app_date.png"/>
        <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_fin",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c2",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">CRT:</td>
      <td valign="top"><?php if(intval($rs["results"][0]["impresiones"])==0){?>0<? }else{ echo number_format((intval($rs["results"][0]["clicks"])*100)/intval($rs["results"][0]["impresiones"]), 3, '.', '');}?>%</td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Impresiones:</td>
      <td valign="top"><?=intval($rs["results"][0]["impresiones"])?></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Clicks:</td>
      <td valign="top"><?=intval($rs["results"][0]["clicks"])?></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Max Impresiones:<br />
(Cero para ilimitado)</td>
      <td valign="top"><input name="max_impresiones" type="text" id="max_impresiones" value="<?=intval($rs["results"][0]["max_impresiones"])?>" size="10" maxlength="255" class="required validate-number" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Max Clicks:<br />
(Cero para ilimitado)</td>
      <td valign="top"><input name="max_clicks" type="text" id="max_clicks" value="<?=intval($rs["results"][0]["max_clicks"])?>" size="10" maxlength="255" class="required validate-number" /></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">Zonas:</td>
      <td valign="top"><?php 
	  $AGGvars = array("versus"=>TBL_BANNERS_VS_ZONAS,"fk"=>"fk_banner","tabla"=>TBL_BANNERS_ZONAS,"pk"=>"pk_banner_zona","fk_1"=>"fk_banner_zona","campo_buscar"=>"zona");
	  include("vs_aggregator.php"); 
	  ?></td>
    </tr>
    <tr>
      <td width="10%" valign="top" class="t3">Texto  español<br />
Solo para producto destacado </td>
      <td valign="top"><textarea name="texto" cols="50" rows="6" id="texto"><?=$rs["results"][0]["texto"]?></textarea></td>
    </tr>
    <tr>
      <td width="10%" valign="top" class="t3">Texto  ingles<br />
Solo para producto destacado </td>
      <td valign="top"><textarea name="texto_en" cols="50" rows="6" id="texto_en"><?=$rs["results"][0]["texto_en"]?></textarea></td>
    </tr>
	<tr>
      <td width="10%" valign="top" class="t3">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
  <script type="text/javascript">
  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  function bannertype(id){
		$('btipo0').style.display='none'
		$('btipo1').style.display='none'
		$('btipo2').style.display='none'
		$('btipo' + id).style.display=''
	}
	bannertype(<?=intval($rs["results"][0]["tipo_banner"])?>)
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="?module=<?=$_GET["module"]?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
    <tr>
      <td colspan="4" class="t1">Banners</td>
    </tr>
    <tr>
      <td class="t5">Banner</td>
      <td width="1%" class="t5">Impresiones</td>
      <td width="1%" class="t5">Clicks</td>
      <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
$rss = $Banners->getBanner('',$_GET["page"],10);
foreach($rss["results"] as $key => $value) {
    
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_banner"]?>"><?=$value["banner"]?></a></td>
      <td align="center">
        <?=$value["impresiones"]?>      </td>
      <td align="center">
        <?=$value["clicks"]?>      </td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_banner"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="3" align="right"><?=$Banners->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
