<?php
session_start();
require_once("dal/conexion.php");  
$mensaje='';
$id_registro = ''; 
$acepta_delete = '';


$strsqls= "SELECT pa.pais, es.estado, ci.ciudad, tip.tipo 
            FROM tbl_usuarios AS us
            INNER JOIN tbl_paises AS pa
            ON us.fk_pais = pa.pk_pais
            INNER JOIN tbl_estados AS es
            ON us.fk_estado = es.pk_estado
            INNER JOIN tbl_ciudades AS ci
            ON us.fk_ciudad = ci.pk_ciudad
            INNER JOIN tbl_usuarios_tipo AS tip
            ON us.fk_usuario_tipo = tip.pk_usuario_tipo
            WHERE us.pk_usuario = {$_SESSION["user"]["pk_usuario"]}";
$rss = mysql_query($strsqls);
$num_regs = mysql_num_rows($rss);

if ($num_regs > 0) {
    while($row= mysql_fetch_array($rss)) {
        $pais = $row["pais"];
        $estado = $row["estado"];
        $ciudad = $row["ciudad"];
        $tipo_cliente = $row["tipo"];
    }
}
$anio_enajenar = $_POST['anio_enajenar'];
$anio_vacio = $anio_enajenar;
$mes_enajenar = $_POST["mes_enajenar"];
$razon_distri = $_SESSION["user"]["nombres"];
$id_distribuidor = $_SESSION["user"]["id_distribuidor"];
//var_dump($id_distribuidor);
$id_usuario = $_POST["id_usuario"];
$fecha_registro = date("Y-m-d");
$hora_registro = date("H:i:s");
$id_proveedor = 'J313222798';
$id_estatus_enajenacion = 5;    //agregar

    $sql = "INSERT INTO q_enajenacion (anio_enajenar, mes_enajenar, id_proveedor, fecha_registro, id_usuario, tipo_cliente, id_distribuidor, id_estatus_enajenacion, hora_registro)
            VALUES ('".$anio_enajenar."','".$mes_enajenar."','".$id_proveedor."','".$fecha_registro."','".$id_usuario."','".$tipo_cliente."','".$id_distribuidor."','".$id_estatus_enajenacion."','".$hora_registro."')";
    
    // var_dump($sql);
    
    $resultados_inser = mysql_query($sql) or die('Consulta fallida: ' . mysql_error());



$fecha_actual = date("Y-m-d");

$Hora = Time() + (60 *60 * -1); 
$nueva_hora = date('H:i:s',$Hora); //  -1 hora

    $mes_vacio = '';
    $mes=date("m");

    if ($mes_enajenar==01){
    $mes_vacio = "Enero";
    } else if ($mes_enajenar==02){
    $mes_vacio = "Febrero";
    } else if ($mes_enajenar==03){
    $mes_vacio = "Marzo";
    } else if ($mes_enajenar==04){
    $mes_vacio = "Abril";
    } else if ($mes_enajenar==05){
    $mes_vacio = "Mayo";
    } else if ($mes_enajenar==06){
    $mes_vacio = "Junio";
    } else if ($mes_enajenar==07){
    $mes_vacio = "Julio";
    } else if ($mes_enajenar==08){
    $mes_vacio = "Agosto";
    } else if ($mes_enajenar==09){
    $mes_vacio = "Septiembre";
    } else if ($mes_enajenar==10){
    $mes_vacio = "Octubre";
    } else if ($mes_enajenar==11){
    $mes_vacio = "Noviembre";
    } else if ($mes_enajenar==12){
    $mes_vacio = "Diciembre";
    }


?>
<div style="background-color: #f5f5f5;">

<h3>Declaración Informativa de Máquinas Fiscales</h3>
                                    
<h3 align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    (DIMAFI)</h3>

<h4>&nbsp;&nbsp;Período de Declaración (<?php echo $mes_vacio ?> / <?php echo $anio_vacio ?>)</h4>
<div style="border-bottom: 4px solid; color:#a30327;"></div>



<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <center>Durante el periodo correspondiente a <?php echo $mes_vacio.' - '.$anio_vacio;?>, no existen registros de Enajenaciones de Máquinas Fiscales.</center>
</div>

<table class='table table-condensed' width="1000" style="font-family : Arial; font-size : 9pt; background-color: #fff;"><br>
    <tr style='background-color:#a30327;color:#fff'>
        <th>Fecha</th>
        <th>Rif Distribuidor</th>
        <th>Nombre Distribuidor</th>
        <th>Rif Cliente</th>
        <th>Nombre Contribuyente</th>
        <th>Rif Técnico</th>
        <th>Nombre Cliente</th>
        <th>Maquina</th>
        <th>Tipo Op.</th>
    </tr>
    
<?php 
$query = "SELECT id,fecha_registro,id_distribuidor,razon_distribuidor,id_cliente,razon_contribuyente,id_tecnico,nombre_tecnico,serial,tipo_op
            FROM q_enajenacion WHERE id_usuario = '{$_SESSION["user"]["id_usuario"]}' AND fecha_registro = '$fecha_actual' AND hora_registro > '{$nueva_hora}' ";
            


$result = mysql_query($query) or die('Consulta fallida N° 2: ' . mysql_error());
while($usuario=mysql_fetch_array($result,MYSQL_ASSOC)){
                ?>
                <tr>
                    <td><?php echo $fecha_actual; ?></td>
                    <td>Datos Vacios</td>
                    <td>Datos Vacios</td>
                    <td>Datos Vacios</td>
                    <td>Datos Vacios</td>
                    <td>Datos Vacios</td>
                    <td>Datos Vacios</td>
                    <td>Datos Vacios</td>
                    <td>Datos Vacios</td>
                </tr>
                <?php } ?>
                
    
</table>
<div style="border-bottom: 4px solid; color:#a30327;"></div>

<!--  echo $pais_contrib.'<br>'.$tipo_cliente.'<br>'.$id_distribuidor.'<br>'.$id_usuario.'<br>'.$fecha_ini
    .'<br>'.$fecha_fin.'<br>'.$razon_contrib.'<br>'.$id_cliente.'<br>'.$contacto_contrib.'<br>'.
    $direccion_contrib.'<br>'.$telefono_contrib.'<br>'.$email_contrib.'<br>'.$serial_equipo.'<br>'.
    $fecha_enajenacion.'<br>'.$tipo_op.'<br>'.$observacion.'<br>'.$precinto.'<br>'.$nombre_tecnico;-->

    <br>  

        
<center>         
        <div class="form-inline">
            <button type="submit" class="btnn-default" onclick="location.href = 'default.php'">Volver</button>
        </div>
    <br>
</center> 
        
        
<div id="modalCertificado" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Confirmación</h3>
  </div>
  <div class="modal-body">
      <p class="text-left">¿Desea imprimir el reporte de enajenaciones? 
        Recuerde que una vez emitido el Certificado, no podrá realizar cambios en las enajenaciones declaradas.</p>
  </div>
  <div class="modal-footer">
    <center>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button class="btnn-default" data-dismiss="modal" id="certModal">Aceptar</button>
    </center>
  </div>
</div>
<?php
//style='background-color:#0000FF;color:#fff'

if(isset($_POST["actStatus"])){
    $acepta_delete = $_POST["actStatus"];
    var_dump($acepta_delete);
}
?>   

 
    
<script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript\save_enajenacion\campos_save.js"></script>
<script src="javascript\save_enajenacion\jquery-1.9.1.js"></script>
<script src="javascript\save_enajenacion\bootstrap.js"></script>
<!--<script src="javascript\operaciones.js"></script>-->
<script src="javascript\save_enajenacion\tabs-addon.js"></script>

<link href="styles\save_enajenacion\bootstrap.css" rel="stylesheet">
<link href="styles\save_enajenacion\bootstrap-responsive.css" rel="stylesheet">
<link href="styles\save_enajenacion\font-awesome.css" rel="stylesheet">
<link href="styles\save_enajenacion\styles.css" rel="stylesheet">
