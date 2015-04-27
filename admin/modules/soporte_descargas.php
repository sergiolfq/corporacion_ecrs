 <?php
$Admin->chkPermisosAdmin(5);
$Helper = new Helper; 

if(intval($_POST["pk_soporte_descarga"])==0 && trim($_POST["descarga"])!=""){
	$pk=$Helper->addSoporte_Descargas($_POST);
	$mensaje="El elemento fue agregado";
}elseif(intval($_POST["pk_soporte_descarga"])>0){
	$Helper->editSoporte_Descargas($_POST);
	$pk= intval($_POST["pk_soporte_descarga"]);
	$mensaje="El elemento fue editado";
}elseif(is_array($_POST["delete"])){
	$Helper->delSoporte_Descargas($_POST);
	foreach($_POST["delete"] as $k=>$v){
		unlink(SERVER_ROOT . "/descargas/" . $v . ".dat");
	}
	$mensaje="Los elementos selecionados fueron eliminados";
}

if(intval($pk)>0){
	$Aggregator = new Aggregator();
	$Aggregator->addEdtVsAggregatorByModule($_POST,array("versus"=>TBL_SOPORTE_DESCARGAS_VS_PRODUCTOS,"fk"=>"fk_soporte_descarga","fk2"=>"fk_producto","id"=>$pk));
	$Aggregator->addEdtVsAggregatorByModule($_POST,array("versus"=>TBL_SOPORTE_DESCARGAS_VS_CATEGORIAS,"fk"=>"fk_soporte_descarga","fk2"=>"fk_soporte_categoria","id"=>$pk));
		
	if(is_file(SERVER_ROOT . "/descargas/" . $_POST["carga_file"] . ".tmp")){
		unlink(SERVER_ROOT . "/descargas/" . $pk . ".dat");
		copy(SERVER_ROOT . "/descargas/" . $_POST["carga_file"] . ".tmp",SERVER_ROOT . "/descargas/" . $pk . ".dat");
		unlink(SERVER_ROOT . "/descargas/" . $_POST["carga_file"] . ".tmp");
	}
}

if(intval($_GET["edt"])>0){
	$arr = array("pk_soporte_descarga" => intval($_GET["edt"]));
	$rs = $Helper->getSoporte_Descargas($arr,0,1);
	$fecha_version = strtotime($rs["results"][0]["fecha_version"]);
}else{
	$fecha_version =  time();	
}

$carga_file= time();

?><?php if(trim($mensaje)!=''){ ?><div align="center"><br><div class="ntf1"><img src="/images/admin/icono-alerta.gif" width="30" height="30" align="absmiddle">&nbsp;&nbsp;<?=$mensaje; ?></div><br></div><?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="comprueba(); return false">
  <table width="100%" border="0" class="brd1">
    <tr>
      <td colspan="2" class="t1"><span style="float:left ">
        <?php if(isset($_GET["edt"])){?>
        Editar
        <?php }else{ ?>
        Agregar
        <?php } ?>
        </span>
          <?php if(isset($_GET["edt"])){?>
        <span style="float:right;"><a href="?module=<?=$_GET["module"]?>" class="t1">Nuevo</a></span>
        <?php } ?></td>
    </tr>
    <tr>
      <td width="10%" valign="top" class="t3">Titulo espa&ntilde;ol</td>
      <td valign="top"><input name="descarga" type="text" id="descarga" value="<?=$rs["results"][0]["descarga"]?>" size="50" maxlength="255" class="required" />
      <input name="pk_soporte_descarga" type="hidden" id="pk_soporte_descarga" value="<?=$rs["results"][0]["pk_soporte_descarga"]?>" />
      <input name="carga_file" type="hidden" id="carga_file" value="<?=$carga_file?>" />
      
      </td>
    </tr>  
    <tr>
      <td width="10%" valign="top" class="t3">Titulo  Ingl&eacute;s</td>
      <td valign="top"><input name="descarga_en" type="text" id="descarga_en" value="<?=$rs["results"][0]["descarga_en"]?>" size="50" maxlength="255" class="required" /></td>
    </tr>
    <!--
    <tr>
      <td width="10%" valign="top" class="t3">Categoria</td>
      <td valign="top">
      <select name="fk_soporte_categoria" id="fk_soporte_categoria" class="required validate-selection">
      <option>Seleccione</option>
       <?php $Common->llenarComboDb(TBL_SOPORTE_CATEGORIAS,"pk_soporte_categoria","categoria","",0,intval($rs["results"][0]["fk_soporte_categoria"]),"","categoria asc"); ?>
      </select>
      </td>
    </tr>
    -->
    <tr>
      <td width="10%" valign="top" class="t3">Version</td>
      <td valign="top"><input name="version" type="text" id="version" value="<?=$rs["results"][0]["version"]?>" size="50" maxlength="255"  /></td>
    </tr>
      <tr>
      <td width="10%" valign="top" class="t3">Archivo</td>
      <td valign="top">
       <style media="screen">
.progressWrapper {
	width: 200px;
	overflow: hidden;
}

.progressContainer {
	margin: 5px;
	padding: 4px;
	border: solid 1px #E8E8E8;
	background-color: #F7F7F7;
	overflow: hidden;
}
/* Message */
.message {
	margin: 1em 0;
	padding: 10px 20px;
	border: solid 1px #FFDD99;
	background-color: #FFFFCC;
	overflow: hidden;
}
/* Error */
.red {
	border: solid 1px #B50000;
	background-color: #FFEBEB;
}

/* Current */
.green {
	border: solid 1px #DDF0DD;
	background-color: #EBFFEB;
}

/* Complete */
.blue {
	border: solid 1px #CEE2F2;
	background-color: #F0F5FF;
}

.progressName {
	font-size: 8pt;
	font-weight: 700;
	color: #555;
	width: 323px;
	height: 14px;
	text-align: left;
	white-space: nowrap;
	overflow: hidden;
}

.progressBarInProgress,
.progressBarComplete,
.progressBarError {
	font-size: 0;
	width: 0%;
	height: 2px;
	background-color: blue;
	margin-top: 2px;
}

.progressBarComplete {
	width: 100%;
	background-color: green;
	visibility: hidden;
}

.progressBarError {
	width: 100%;
	background-color: red;
	visibility: hidden;
}

.progressBarStatus {
	margin-top: 2px;
	width: 337px;
	font-size: 7pt;
	font-family: Arial;
	text-align: left;
	white-space: nowrap;
}

a.progressCancel {
	font-size: 0;
	display: block;
	height: 14px;
	width: 14px;
	background-image: url(/images/cancelbutton.gif);
	background-repeat: no-repeat;
	background-position: -14px 0px;
	float: right;
}

a.progressCancel:hover {
	background-position: 0px 0px;
}


/* -- SWFUpload Object Styles ------------------------------- */
.swfupload {
	vertical-align: top;
}
</style>
<script type="text/javascript" src="/includes/SWFUpload/swfupload.js"></script> 
<script type="text/javascript" src="/includes/SWFUpload/swfupload.queue.js"></script>
<script type="text/javascript" src="/includes/SWFUpload/fileprogress.js"></script>
<script type="text/javascript" src="/includes/SWFUpload/handlers.js"></script>
<div id="myfilename" style="font-weight:bold; color:#CC6600"><a href="/?dws=<?=$Shop->encode($rs["results"][0]["pk_soporte_descarga"]);?>"><?=$rs["results"][0]["file_name"]?></a></div>
        
        
<div class="fieldset flash" id="fsUploadProgress"></div>
<input name="file_name" type="hidden" id="file_name" value="<?=$rs["results"][0]["file_name"]?>" />


  <span id="spanButtonPlaceHolder"></span>
    <input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px; display:none;" />
    <script>
var swfu;
window.onload = function() {
	var settings = {
				flash_url : "/includes/SWFUpload/Flash/swfupload.swf",
				upload_url: "/includes/SWFUpload/upload.php",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>","pk" : "<?php echo $carga_file;?>" },
				file_size_limit : "100 MB",
				file_types : "*", 
				file_types_description : "Archivo",
				file_queue_limit : 1,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "/images/cargarfoto.png",
				button_width: "109",
				button_height: "24",
				button_placeholder_id: "spanButtonPlaceHolder",
				
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess, //uploadSuccess
				upload_complete_handler : terminoUp,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
}

function terminoUp(file){
	$('myfilename').innerHTML=file.name
	$('file_name').value=file.name 
	
	//console.log(file);  
	return true;
 }
</script>

      
      
      </td>
    </tr>
    <tr>
      <td width="10%" valign="top" class="t3">Fecha</td>
      <td valign="top">
      <input type="text" name="fecha_version" id="fecha_version" readonly="1" value="<?=date("Y-m-d",$fecha_version)?>" class="required" />
        <img id="f_trigger_c" title="Date selector" style="cursor: pointer;" src="/images/admin/24px-Crystal_Clear_app_date.png"/>
        <script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_version",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
        </script></td>
    </tr>
    <tr>
      <td width="10%" valign="top" class="t3">Importancia</td>
      <td valign="top">
      <select name="importancia" id="importancia" class="required validate-selection">
      <option>Seleccione</option>
      <?=$Helper->llenarComboDbEnum(TBL_SOPORTE_DESCARGAS,'importancia',$rs["results"][0]["importancia"])?>
      </select>
      </td>
    </tr> 
    
    <tr>
      <td width="10%" valign="top" class="t3">Productos</td>
      <td valign="top">
      <?php 
	  $AGGvars = array("versus"=>TBL_SOPORTE_DESCARGAS_VS_PRODUCTOS,"fk"=>"fk_soporte_descarga","tabla"=>TBL_PRODUCTOS,"pk"=>"pk_producto","fk_1"=>"fk_producto","campo_buscar"=>"sku");
	  include("vs_aggregator.php"); 
	  ?>
      
      
      
      </td>
    </tr>
       <tr>
      <td width="10%" valign="top" class="t3">Categorias</td>
      <td valign="top">
      <?php 
	  $AGGvars = array("versus"=>TBL_SOPORTE_DESCARGAS_VS_CATEGORIAS,"fk"=>"fk_soporte_descarga","tabla"=>TBL_SOPORTE_CATEGORIAS,"pk"=>"pk_soporte_categoria","fk_1"=>"fk_soporte_categoria","campo_buscar"=>"categoria");
	  include("vs_aggregator.php"); 
	  ?>
      
      
      
      </td>
    </tr>
	
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar" /></td>
    </tr>
  </table>
  <script>
function comprueba(){
	
	if(valid.validate())  form1.submit();

	return false;
}

  var valid = new Validation('form1', {immediate : true,focusOnError : true});
  </script>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd1">
  <tr>
      <td colspan="3" class="t1"><a name="bupro" id="bupro"></a>Descargas      
      <select name="fk_tipo" id="fk_tipo" onchange="document.location='?module=<?=$_GET["module"]?>&fk_tipo='+this.value + '#bupro'">
      <option value="0" >Todas</option>
      <?php $Common->llenarComboDb(TBL_SOPORTE_CATEGORIAS,"pk_soporte_categoria","categoria","",0,$_GET["fk_tipo"],"","categoria asc"); ?>
      </select>   
      </td>
       
    </tr>
    <tr>
    <td class="t5">Descarga</td>
    <td class="t5">Archivo</td>
     <td width="1%" class="t5">Eliminar</td>
    </tr>
<?php
if(intval($_GET["fk_tipo"])==0){
	$rss = $Helper->getSoporte_Descargas(array("orderby"=>"pk_soporte_descarga desc"),$_GET["page"],10);
}else{
	$rss = $Helper->Execute("select * from " . TBL_SOPORTE_CATEGORIAS . " sc inner join " . TBL_SOPORTE_DESCARGAS_VS_CATEGORIAS . " vs on sc.pk_soporte_categoria=vs.fk_soporte_categoria inner join " . TBL_SOPORTE_DESCARGAS. " d on d.pk_soporte_descarga=vs.fk_soporte_descarga where sc.fk_estatus>0 and vs.fk_estatus>0 and d.fk_estatus>0 and sc.pk_soporte_categoria=" . intval($_GET["fk_tipo"]) . " group by d.pk_soporte_descarga",10,$_GET["page"] );
}
foreach($rss["results"] as $key => $value){
?>
    <tr>
      <td><a href="?module=<?=$_GET["module"]?>&edt=<?=$value["pk_soporte_descarga"]?>"><?=$value["descarga"]?></a></td>
      <td><?=$value["file_name"]?></td>
      <td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="<?=$value["pk_soporte_descarga"]?>" /></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="2" align="right"><?=$Helper->paginateResults($rss)?></td>
      <td><input type="submit" name="Submit2" value="Eliminar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
