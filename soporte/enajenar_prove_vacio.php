<!DOCTYPE html>
<?php 

session_start();
require_once("dal/conexion.php");  

?>


<html xmlns="">
<head>
    <title>Formulario Enajenaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles\enagenaciones_vacias\bootstrap.css" rel="stylesheet">
    <link href="styles\enagenaciones_vacias\bootstrap-responsive.css" rel="stylesheet">
    <link href="styles\enagenaciones_vacias\preview.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="styles\enagenaciones_vacias\font-awesome.css" rel="stylesheet">
    <link href="styles\enagenaciones_vacias\styles.css" rel="stylesheet">
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

    <div class="container">



        <div class="row-fluid" id="demo">
            <div class="span12">
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                    <!--ul class="nav nav-tabs">
                        
                        <li><a href="#panel4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contactenos</span></a></li>
                    </ul-->
                    
                    
                    <div class="tab-content">
                       
                        <form id="" name="" method="post" action="save_prove_vacio.php"> 
                            
                            <div class="row-fluid">

                                <div class=" span10 offset1">
                                    
                                    <h3>Declaración Informativa de Máquinas Fiscales</h3>
                                    
                                    <h3 align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (DIMAFI)</h3><br>

                                    <h4>&nbsp;&nbsp;Datos del Distribuidor</h4>
                                    
                                    <?php// var_dump($pais_contribu); ?>
                                   
                                    N° de Contrato &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="" id="" disabled name="tipo_cliente" class="input-block-level span2">
                                    <br>

                                    Tipo de Usuario &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="<?php echo $tipo_cliente;?>" id="" disabled name="tipo_cliente" class="input-block-level span2">

                                    &nbsp;&nbsp;
                                    Razón Social &nbsp;&nbsp;<input type="text" disabled value="<?php echo $_SESSION["user"]["nombres"];?>" id="" name="razon_disri" class="input-block-level span5">
                                    <br>
                                    RIF &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" value="<?php echo $_SESSION["user"]["id_distribuidor"];?>" id="" disabled name="id_distribuidor" class="input-block-level span2">

                                    <input type="hidden" value="<?php echo $_SESSION["user"]["id_usuario"];?>" name="id_usuario" >
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Persona Contacto &nbsp;&nbsp;<input type="text" value="<?php echo $_SESSION["user"]["apellidos"];?>" id="" disabled name="nombre" class="input-block-level span4">

                                    <br>

                                    Dirección &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <textarea row="2" class="span8" disabled ><?php echo $_SESSION["user"]["direccion"];?></textarea>

                                    <br>

                                    País &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  
                                    <input type="text" value="<?php echo $pais;?>" id="" disabled name="nombre" class="input-block-level span2 " STYLE="font-family : Arial; font-size : 9pt">

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado&nbsp;&nbsp; <input type="text" value="<?php echo $estado;?>" id="" disabled name="nombre" class="input-block-level span2 " STYLE="font-family : Arial; font-size : 9pt">

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ciudad &nbsp;&nbsp; <input type="text" value="<?php echo $ciudad;?>" id="" disabled name="nombre" class="input-block-level span2 " STYLE="font-family : Arial; font-size : 9pt">

                                    <br>
                                    Teléfono &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" value="<?php echo $_SESSION["user"]["telefono1"];?>" id="" disabled name="nombre" class="input-block-level span3">
                                    &nbsp; &nbsp;&nbsp; &nbsp;
                                    Email  &nbsp; &nbsp; <input type="text" value="<?php echo $_SESSION["user"]["email"];?>" id="" disabled name="nombre" class="input-block-level span4">
                                    <br>

                                </div>

                            </div>

                                <br>
                                    
                                <center>
                                    <div class="alert alert-error" style="margin-right: 75px; margin-left: 75px;" id='articulo'>
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            De acuerdo con lo establecido en la Providencia 0592 en su sección IV, 
                                            articulo 37, literal 2, el distribuidor de máquinas fiscales deberá informar
                                            al fabricante o al representante las enajenaciones de Máquinas Fiscales efectuadas a los usuarios,
                                            dentro de los cincos (5) días hábiles siguientes a la fiscalización de cada mes.
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

                                   <h4>&nbsp;&nbsp;Período de Enajenación</h4></
                                      
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

                            <?php
                            
                            $actual_mes = date('m', strtotime('-1 month'));
                            
                            $Anio_Enajeno = date('Y');
                            $enajeno = '';
                            
                            $sql_enajeno = "SELECT mes_enajenar FROM q_enajenacion
                                            WHERE mes_enajenar = '{$actual_mes}'
                                            AND anio_enajenar = '{$Anio_Enajeno}'
                                            AND id_usuario = '{$_SESSION["user"]["id_usuario"]}'";
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
                                    <center>Usted ya realizo una carga de enajenaciones para el mes (<?php echo $enajeno;?>)</center>
                                </div>
                            <?php } ?> 
                            
                                     
                            <br>
                            <?php// if($dia_actual <= 05 ){ ?>
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
    <script src="javascript\enagenaciones_vacias\campos.js"></script>
    <script src="javascript\enagenaciones_vacias\jquery-1.9.1.js"></script>
    <script src="javascript\enagenaciones_vacias\bootstrap.js"></script>
    <script src="javascript\enagenaciones_vacias\numerico_vacio.js"></script>
    <script src="javascript\enagenaciones_vacias\tabs-addon.js"></script>

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

