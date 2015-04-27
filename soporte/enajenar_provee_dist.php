<!DOCTYPE html>
<?php 

session_start();
require_once("dal/conexion.php");  

?>


<html xmlns="">
<head>
    <title>Formulario Enajenaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles\enajenar\bootstrap.css" rel="stylesheet">
    <link href="styles\enajenar\bootstrap-responsive.css" rel="stylesheet">
    <link href="styles\enajenar\preview.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="styles\enajenar\font-awesome.css" rel="stylesheet">
    <link href="styles\enajenar\styles.css" rel="stylesheet">
</head>
<body class=" ">
    
<?php
if(!isset($_SESSION["user"])  ){
	echo $_SESSION["user"];
}

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


$mes_enajenar = '';
$anio_enajenar = '';
$razon_contrib = '';
$numero_factura = '';
$numero_control = '';
$contacto_contribuyente = '';
$id_cliente = '';
$letra_rif_cliente = '';
$rif_cliente = '';
$direccion_contribuyente = '';
$pais_contribu = '';
$estado_contribu = '';
$ciudad_contribu = '';
$telefono_contribu = '';
$email_contribu = '';
$serial = '';
$precinto_maquina = '';
$id_producto = '';
$fecha_enajenacion = '';
$tipo_op = '';
$id_tecnico = '';
$observaciones = '';

if(isset($_GET["Ope"])){
    $operacion = trim($_GET["Ope"]);
    if(strtoupper($operacion)=="EDITAR"){
    //Buscamos los datos para ese usuario    
        $id=$_GET["id"];
        $query_edit="SELECT mes_enajenar,anio_enajenar,razon_contribuyente,numero_factura,numero_control,contacto_contribuyente,
                id_cliente,direccion_contribuyente,pais_contribuyente,telefono_contribuyente,estado_contribuyente,ciudad_contribuyente,
                telefono_contribuyente,email_contribuyente,serial,precinto_maquina,id_producto,fecha_enajenacion,tipo_op,id_tecnico,observaciones
                FROM q_enajenacion WHERE id=".$id;
        $resource = @mysql_query($query_edit);
        if(mysql_num_rows($resource)>0){
            //En caso de que consiga al usuario    
            $mes_enajenar = mysql_result($resource,0,"mes_enajenar");
            $anio_enajenar = mysql_result($resource,0,"anio_enajenar");
            $razon_contrib = mysql_result($resource,0,"razon_contribuyente");
            $numero_factura = mysql_result($resource,0,"numero_factura");
            $numero_control = mysql_result($resource,0,"numero_control");
            $contacto_contribuyente = mysql_result($resource,0,"contacto_contribuyente");
            $id_cliente = mysql_result($resource,0,"id_cliente");
            $direccion_contribuyente = mysql_result($resource,0,"direccion_contribuyente");
            $pais_contribu = mysql_result($resource,0,"pais_contribuyente");
            $telefono_contribu = mysql_result($resource,0,"telefono_contribuyente");
            $estado_contribu = mysql_result($resource,0,"estado_contribuyente");
            $ciudad_contribu = mysql_result($resource,0,"ciudad_contribuyente");
            $email_contribu = mysql_result($resource,0,"email_contribuyente");
            $serial = mysql_result($resource,0,"serial");
            $precinto_maquina = mysql_result($resource,0,"precinto_maquina");
            $id_producto = mysql_result($resource,0,"id_producto");
            $fecha_enajenacion = mysql_result($resource,0,"fecha_enajenacion");
            $tipo_op = mysql_result($resource,0,"tipo_op");
            $id_tecnico = mysql_result($resource,0,"id_tecnico");
            $observaciones = mysql_result($resource,0,"observaciones");
            
            
            
            $letra_rif_cliente = substr($id_cliente, 0, 1);
            $rif_cliente = substr($id_cliente, 1);
            
            
            
           $mensaje="Se logrará Editar los datos con éxito";
        }
        else{
            $mensaje="No existe el usuario de Identidad $id";
        }
    }
}

?>
    
    
    <div id="cargando" style="position:absolute; width:100%;height:100%;background:rgba(0,0,0,0.2) url(images/loading.gif) no-repeat center;"></div>

    <div class="container">



        <div class="row-fluid" id="demo">
            <div class="span12">
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                    <!--ul class="nav nav-tabs">
                        
                        <li><a href="#panel4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contactenos</span></a></li>
                    </ul-->
                    <div class="tab-content">
                       
                        <form id="" name="" method="post" action="save_provee_dist.php"> 
                            
                            <div class="row-fluid">

                                <div class=" span10 offset1">
                                    
                                    <h3>Declaración Informativa de Máquinas Fiscales</h3>
                                    
                                    <h3 align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (DIMAFI)</h3><br>

                                        <?php// var_dump('Provee - dist'); ?>

                                </div>
                                

                            </div>

                                <br>
                                    
                                <center>
                                    <div class="alert alert-error" style="margin-right: 75px; margin-left: 75px;" id='articulo'>
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            De acuerdo con lo establecido en la Providencia 0592 en su sección IV, articulo 37, literal 2, el distribuidor de máquinas fiscales deberá informar al fabricante o al representante las enajenaciones de Máquinas Fiscales efectuadas a los usuarios, dentro de los cincos (5) días hábiles siguientes a la fiscalización de cada mes.
                                    </div>
                                </center>
                                    
                                <?php $dia_actual = date('d'); ?>
                                    
                                <?php if($dia_actual > 05){ ?>
                                    <div class="alert alert-error" style="margin-right: 75px; margin-left: 75px;">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <center>La carga de enajenaciones se encuentra bloqueada, por ser una declaración extemporánea.</center>
                                    </div>
                                <?php } ?>
                                 
                               
                            <div class="row-fluid">

                                <div class=" span10 offset1">

                                   <h4>&nbsp;&nbsp;Período de Declaración</h4></
                                      
                                    <br>
                                    
                                    
                                    
                                    
                                    <font style="color:red">*&nbsp;</font>Mes: &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select id="mes_enajenar" name="mes_enajenar" class="input-block-level span2">
                                        <option value="">Seleccione</option>
                                        <option value="01" <?php if($mes_enajenar == "01") echo 'selected';?>>Enero</option>
                                        <option value="02" <?php if($mes_enajenar == "02") echo 'selected';?>>Febrero</option>
                                        <option value="03" <?php if($mes_enajenar == "03") echo 'selected';?>>Marzo</option>
                                        <option value="04" <?php if($mes_enajenar == "04") echo 'selected';?>>Abril</option>
                                        <option value="05" <?php if($mes_enajenar == "05") echo 'selected';?>>Mayo</option>
                                        <option value="06" <?php if($mes_enajenar == "06") echo 'selected';?>>Junio</option>
                                        <option value="07" <?php if($mes_enajenar == "07") echo 'selected';?>>Julio</option>
                                        <option value="08" <?php if($mes_enajenar == "08") echo 'selected';?>>Agosto</option>
                                        <option value="09" <?php if($mes_enajenar == "09") echo 'selected';?>>Septiembre</option>
                                        <option value="10" <?php if($mes_enajenar == "10") echo 'selected';?>>Octubre</option>
                                        <option value="11" <?php if($mes_enajenar == "11") echo 'selected';?>>Noviembre</option>
                                        <option value="12" <?php if($mes_enajenar == "12") echo 'selected';?>>Diciembre</option>
                                    </select>   
                                    
                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    <font style="color:red">*&nbsp;</font>Año: &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select id="anio_enajenar" name="anio_enajenar" class="input-block-level span2">
                                            <?php
                                                    echo '<option value="">Seleccione</option>';
                                                for($anio=(date("Y")+1); 2015<=$anio; $anio--) {
                                                    if($anio_enajenar == $anio){
                                                        echo "<option value='".$anio."' selected='selected'>".$anio."</option>";
                                                    }else{
                                                        echo "<option value='".$anio."'>".$anio."</option>";
                                                    }
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                                    <center>
                                        <div class="alert alert-error" style="margin-right: 75px; margin-left: 75px;" id='valor'>
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        </div>
                                    </center>
                                    
                            <div class="row-fluid">
                                <div class=" span10 offset1" style="border-bottom: 1px solid #E8E3E3;"></div>
                            </div>


                            
                            <div class="row-fluid">

                                <div class=" span10 offset1">

                                    <center><h4 style="border-bottom: 1px solid #d1d1d1;padding-bottom: 15px;">&nbsp;&nbsp;Datos del Distribuidor</h4></center>
                                    
                                    <di class="form-inline">
                                        Codigo Cliente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" value="" id="codigo_cliente" maxlength="6" name="codigo_cliente" class="input-block-level span2">&nbsp;
                                        <button type="button" id="buscar_dist" class="btnn-default">Buscar Distribuidor</button>
                                        
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <font id="fine"> <img src="images/fine.png" title="Activo" width="20" height="20"> </font>
                                        <font id="nofine"> <img src="images/delete.png" title="Inactivo" width="20" height="20"></font>
                                        <font id="noimagen"> <img src="images/vacia.jpg" width="20" height="20"></font>
                                        
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        Contrato N° &nbsp;&nbsp;
                                        <select id="letra_contrato" name="letra_contrato" readonly="true" class="input-mini" style="font-family : Eras Medium ITC; font-size : 8pt">
                                            <option value="">--</option>
                                            <option value="CSA" <?php if($letra_rif_cliente == "CSA") echo 'selected';?>>CSA</option>
                                            <option value="D" <?php if($letra_rif_cliente == "D") echo 'selected';?>>(D)</option>
                                        </select>
                                        <input type="text" value="" id="numero_contrato" readonly="true" name="numero_contrato" class="input-block-level span2">
                                        
                                        
                                        
                                    </di><br><br>
                                    <div class="alert alert-error" style="margin-right: 75px; margin-left: 75px;" id='no_distrib'>
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            No existe ningun Distribuidor con ese Código de Cliente, Por favor verifiquelo
                                    </div>
                                    
                                    <font style="color:red">*&nbsp;</font>Razón Social &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="razon_contrib" readonly="true" value="<?php echo $razon_contrib;?>" id="razon_contrib" title="Nombre de la empresa" name="razon_contrib" class="input-block-level span4">
                                    <font style="color:red">*</font> Factura N°
                                    <input type="text" value="<?php echo $numero_factura;?>" id="numero_factura" title="Ingrese Número de Factura" name="numero_factura" class="input-block-level span2 ">
                                    <font style="color:red">*</font> Control N°
                                    <input type="text" value="<?php echo $numero_control;?>" id="numero_control" title="Ingrese Número de Control" name="numero_control" class="input-block-level span2 ">
                                    <br>

                                    <font style="color:red">*&nbsp;</font>Contacto &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" readonly="true" value="<?php echo $contacto_contribuyente;?>" id="contacto_contrib" title="Nombre de la persona a contactar" name="contacto_contrib" class="input-block-level span4">
                                    
                                    
                                    &nbsp;&nbsp;&nbsp;&nbsp;<font style="color:red">*</font> RIF N° &nbsp;
                                    <select id="Letra_rif_cliente" readonly="true" name="Letra_rif_cliente" class="input-mini">
                                        <option value="">--</option>
                                        <option value="J" <?php if($letra_rif_cliente == "J") echo 'selected';?>>J</option>
                                        <option value="G" <?php if($letra_rif_cliente == "G") echo 'selected';?>>G</option>
                                        <option value="V" <?php if($letra_rif_cliente == "V") echo 'selected';?>>V</option>
                                        <option value="E" <?php if($letra_rif_cliente == "E") echo 'selected';?>>E</option>
                                        <option value="P" <?php if($letra_rif_cliente == "P") echo 'selected';?>>P</option>
                                    </select>
                                    <input type="text" readonly="true" value="<?php echo $rif_cliente;?>" id="id_cliente" maxlength="9" title="N° de Registro de Identificación Fiscal" name="id_cliente" class="input-block-level span2 ">

                                    <br>

                                    <font style="color:red">*&nbsp;</font>Dirección &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <textarea row="2" id="direccion_contrib" readonly="true" title='Domicilio Fiscal' name="direccion_contrib" class="span8"><?php echo $direccion_contribuyente;?></textarea>
                                    <br>

                                    <font style="color:red">*&nbsp;</font>País&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  
                                    <SELECT class="span3" id="pais_contrib" readonly="true" name="pais_contrib" SIZE="1" STYLE="font-family : Arial; font-size : 9pt">
                                        <?php
                                            $query_pa = "SELECT * FROM `tbl_paises`";
                                            $result = mysql_query($query_pa);  
                                            echo '<option value="">Seleccione</option>';
                                            while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
                                                if($pais_contribu == $row['pk_pais']){
                                                    echo '<option value="'.$row['pk_pais'].'" selected="selected">'.$row['pais'].'</option>';
                                                }else{
                                                    echo "<option value='".$row['pk_pais']."'>".$row['pais']."</option>";
                                                }
                                            }   
                                        ?>
                                    </SELECT> 
                                    
                                    &nbsp;&nbsp;<font style="color:red">*&nbsp;</font>Estado&nbsp;
                                    <select class="span3" id="estado_contrib" readonly="true" name="estado_contrib" STYLE="font-family : Arial; font-size : 9pt">
                                        <?php
                                            $query_pa = "SELECT * FROM `tbl_estados`";
                                            $result = mysql_query($query_pa);  
                                            echo '<option value="">Seleccione</option>';
                                            while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
                                                if($pais_contribu == $row['pk_estado']){
                                                    echo '<option value="'.$row['pk_estado'].'" selected="selected">'.$row['estado'].'</option>';
                                                }else{
                                                    echo "<option value='".$row['pk_estado']."'>".$row['estado']."</option>";
                                                }
                                            }   
                                        ?>
                                    </select>

                                    &nbsp;&nbsp;&nbsp;&nbsp;<font style="color:red">*&nbsp;</font>Ciudad &nbsp;
                                    <SELECT class="span2" id="ciudad_contrib" readonly="true" name="ciudad_contrib" STYLE="font-family : Arial; font-size : 9pt">
                                        <?php
                                            $query_pa = "SELECT * FROM `tbl_ciudades`";
                                            $result = mysql_query($query_pa);  
                                            echo '<option value="">Seleccione</option>';
                                            while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
                                                if($pais_contribu == $row['pk_ciudad']){
                                                    echo '<option value="'.$row['pk_ciudad'].'" selected="selected">'.$row['ciudad'].'</option>';
                                                }else{
                                                    echo "<option value='".$row['pk_ciudad']."'>".$row['ciudad']."</option>";
                                                }
                                            }   
                                        ?>
                                    </SELECT> 



                                    <br>


                                    <font style="color:red">*&nbsp;</font>Teléfono &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                    <input type="text" readonly="true" value="<?php echo $telefono_contribu;?>" id="phone_contrib" title="Número de Teléfono" maxlength="14" name="phone_contrib" pattern="[+-0-1-2-3-4-5-6-7-8-9]*" class="input-block-level span3">
                                    &nbsp;&nbsp;
                                    
                                    <font style="color:red">*&nbsp;</font>Email &nbsp;
                                    <input type="email" readonly="true" value="<?php echo $email_contribu;?>" id="email_contrib" title="Correo Electrónico de la empresa" name="email_contrib" class="input-block-level span4">
                                    
                                    
                                </div>
                            </div>

                            
                            <div class="row-fluid">
                                <div class=" span10 offset1">

                                    <h4 style="border-bottom: 1px solid #d1d1d1;padding-bottom: 8px;"></h4>

                                    

                                        <center><h4 style="border-bottom: 1px solid #d1d1d1;padding-bottom: 10px;">&nbsp;&nbsp;Datos de la Máquina Fiscal</h4></center>

                                         <br>


                                        
                                        <font style="color:red">*&nbsp;</font>Serial N° 
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" value="<?php echo $serial;?>" id="serial_equipo" maxlength="10" title="Número de Registro de la Máquina Físcal (Ej. XWA-123456)" name="serial_equipo" class="input-block-level span2">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <font style="color:red">*&nbsp;</font>Precinto N° &nbsp;&nbsp;&nbsp;
                                        <input type="text" value="<?php echo $serial;?>" id="precinto" title="Número de precinto" name="precinto" class="input-block-level span2">
                                        <br>

                                        <font style="color:red">*&nbsp;</font>Nombre del Producto &nbsp;&nbsp;&nbsp;
                                        <SELECT class="span6" id="producto" name="producto" SIZE="1" STYLE="font-family : Arial; font-size : 9pt">
                                            <?php 
                                                $query = "SELECT * FROM `tbl_tipo_productos` ORDER BY productos" ;
                                                $result = mysql_query($query);  
                                                echo '<option value="">--Seleccione el Producto--</option>';
                                                while($row=mysql_fetch_array($result, MYSQL_ASSOC)){    
                                                    if($id_producto == $row['id']){
                                                        echo '<option value="'.$row['id'].'" selected="selected">'.$row['productos'].'</option>';
                                                    }else{
                                                        echo "<option value='".$row['id']."'>".$row['productos']."</option>";
                                                    }
                                                }   
                                            ?>
                                        </SELECT> 
                                        
                                        <br>

                                        <font style="color:red">*&nbsp;</font>Fecha de Operación &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="date" value="<?php echo $fecha_enajenacion;?>" id="fecha_enajenacion" title="Fecha en la que se realizó la venta o el servicio" name="fecha_enajenacion" class="input-block-level span3 offset3">

                                        <br>

                                        <font style="color:red">*&nbsp;</font>Tipo de Operación &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <SELECT id="tipo_op" class="span8" name="tipo_op" SIZE="1" STYLE="font-family : Arial; font-size : 9pt">
                                            <option value="">--Seleccione--</option>
                                            <option value="1" <?php if($tipo_op == "1") echo 'selected';?> >Enajenaci&oacute;n</option>
                                            <option value="2" <?php if($tipo_op == "2") echo 'selected';?> >Inspecci&oacute;n anual</option>
                                            <option value="3" <?php if($tipo_op == "3") echo 'selected';?> >Reparaci&oacute;n</option>
                                            <option value="4" <?php if($tipo_op == "4") echo 'selected';?> >Adaptaci&oacute;n</option>
                                            <option value="5" <?php if($tipo_op == "5") echo 'selected';?> >Sustituci&oacute;n de memoria fiscal</option>
                                            <option value="6" <?php if($tipo_op == "6") echo 'selected';?> >Sustituci&oacute;n de memoria de auditor&iacute;a</option>
                                            <option value="7" <?php if($tipo_op == "7") echo 'selected';?> >Alteraci&oacute;n o remoci&oacute;n de dispositivos de seguridad</option>
                                            <option value="8" <?php if($tipo_op == "8") echo 'selected';?> >Reporte de p&eacute;rdida o robo por parte del distribuidor, centros, personal t&eacute;cnico o proveedor</option>
                                            <option value="9" <?php if($tipo_op == "9") echo 'selected';?> >Reporte de p&eacute;rdida o robo por parte del usuario
                                            <option value="10" <?php if($tipo_op == "10") echo 'selected';?> >Desincorporaci&oacute;n</option>
                                        </SELECT>
                                         <br>
                                         
                                         <font style="color:red">*&nbsp;</font>Personal Técnico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                         <SELECT class="span3" id="nombre_tecnico" disabled="true" name="nombre_tecnico" SIZE="1" STYLE="font-family : Arial; font-size : 9pt">
                                            <?php 
                                                $query = "SELECT * 
                                                          FROM `tbl_usuarios` 
                                                          WHERE id_distribuidor = '{$_SESSION["user"]["cedula_rif"]}'
                                                          AND tipo_persona = 4
                                                          ORDER BY nombre_tecnico" ;
                                                $result = mysql_query($query);  
                                                echo '<option value="">--Seleccione el Técnico--</option>';
                                                while($row=mysql_fetch_array($result, MYSQL_ASSOC)){ 
                                                    if($id_tecnico == $row['cedula_rif']){
                                                        echo '<option value="'.$row['cedula_rif'].'" selected="selected">'.$row['nombre_tecnico'].'</option>';
                                                    }else{
                                                        echo "<option value='".$row['cedula_rif']."'>".$row['nombre_tecnico']."</option>";
                                                    }
                                                    
                                                }   
                                            ?>
                                        </SELECT> 
                                        
                                        &nbsp; &nbsp; RIF N° &nbsp;&nbsp;
                                        <input type="text" value="" id="id_tecnico" disabled="true" name="id_tecnico" class="input-block-level span2 ">
                                        <br>

                                        Obsevaciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <textarea row="2" id="observacion" class="span8" name="observacion"><?php echo $observaciones;?></textarea>

                                        <br>
                                        <br>
                                            <p style="color:#a30327;"> Los campos marcados con ( * ) son oboligatorios </p>
                                        <br>
                                        
                                        <center>
                                            <div id="error" class="alert alert-error" style="margin-right: 75px; margin-left: 75px;">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            </div>
                                        </center>
                                        
                                        <?php
                                            if(isset($_GET["Ope"])){  
                                                $id=$_GET["id"];
                                        ?>       
                                            <input type="hidden" value="<?php echo $id;?>" name="editar_datos" >
                                        <?php } ?>
                                        
                                        <h4></h4>
                                </div>
                            </div>
                                
                                <?php
                            
                            $actual_mes = date('m', strtotime('-1 month'));
                            $Anio_Enajeno = date('Y');
                            $enajeno = '';
                            
                            $sql_enajeno = "SELECT mes_enajenar FROM q_enajenacion
                                            WHERE mes_enajenar = '{$actual_mes}'
                                            AND anio_enajenar = '{$Anio_Enajeno}'
                                            AND id_usuario = '{$_SESSION["user"]["id_usuario"]}'
                                            AND id_estatus_enajenacion = 5";
                            $result_enaje = mysql_query($sql_enajeno);
                            $num_enaje = mysql_num_rows($result_enaje);

                            //var_dump($sql_enajeno);
                            
                            if ($num_enaje > 0) {
                                while($fil_ena= mysql_fetch_array($result_enaje)) {
                                    $enajeno = $fil_ena["mes_enajenar"];
                                }
                            }
                            ?>
                            
                            <?php if($enajeno != ''){ ?>
                               <div class="alert alert-error" style="margin-right: 75px; margin-left: 75px;">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <center>Usted ya realizo una carga de enajenaciones vacias para el mes (<?php echo $enajeno;?>)</center>
                                </div>
                            <?php } ?>
                                     
                            <br>
                            <?php// if($dia_actual <= 05){ ?>
                                <?php if($enajeno == ''){ ?>
                                    <div class="form-inline">
                                        <center>
                                            <button type="button" onclick="window.location.href='default.php'" class="btnn-default">Volver</button>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <button type="submit" id="validar" class="btnn-default">Continuar</button>
                                        </center>
                                    </div>
                                 <?php } ?>    
                            <?php// } ?>
                        </form>
                                  
                    </div>

                </div>

            </div>
            
        </div>

    
    <script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="javascript\enajenar\campos.js"></script>
    <script src="javascript\enajenar\jquery-1.9.1.js"></script>
    <script src="javascript\enajenar\bootstrap.js"></script>
    <script src="javascript\enajenar\proveedor_dist.js"></script>
    <script src="javascript\enajenar\tabs-addon.js"></script>

    <script type="text/javascript">
        $(function ()
        {
            $("a[href^='#demo']").click(function (evt)
            {
                evt.preventDefault();
                var scroll_to = $($(this).attr("href")).offset().top;
                $("html,body").animate({ scrollTop: scroll_to - 80 }, 600);
            });
            $("a[href^='#bg']").click(function (evt)
            {
                evt.preventDefault();
                $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-image", "url('bgs/" + $(this).data("file") + "')");
                console.log($(this).data("file"));


            });
            $("a[href^='#color']").click(function (evt)
            {
                evt.preventDefault();
                var elm = $(".tabbable");
                elm.removeClass("grey").removeClass("dark").removeClass("dark-input").addClass($(this).data("class"));
                if (elm.hasClass("dark dark-input"))
                {
                    $(".btn", elm).addClass("btn-inverse");
                }
                else
                {
                    $(".btn", elm).removeClass("btn-inverse");

                }

            });
            $(".color-swatch div").each(function ()
            {
                $(this).css("background-color", $(this).data("color"));
            });
            $(".color-swatch div").click(function (evt)
            {
                evt.stopPropagation();
                $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-color", $(this).data("color"));
            });
            $("#texture-check").mouseup(function (evt)
            {
                evt.preventDefault();

                if (!$(this).hasClass("active"))
                {
                    $("body").css("background-image", "url(bgs/n1.png)");
                }
                else
                {
                    $("body").css("background-image", "none");
                }
            });

            $("a[href='#']").click(function (evt)
            {
                evt.preventDefault();

            });

            $("a[data-toggle='popover']").popover({
                trigger:"hover",html:true,placement:"top"
            });
        });

    </script>

</body>
</html>
