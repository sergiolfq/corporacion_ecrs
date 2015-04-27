<?php
    include("dal/sql_helper.php");
    
    function clean($string) {
        //- l�neas originales
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        //return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        //-
        return preg_replace('/[^A-Za-z0-9 \-]/', '', $string); // Removes special chars.
    }    
    
    $staff = isset($_POST['hfstaff']) ? $_POST['hfstaff'] : '%';
    $cmd = isset($_POST['hfcmd']) ? $_POST['hfcmd'] : '';
    $mes = isset($_POST['hfmes']) ? $_POST['hfmes'] : '12';
    $anio = isset($_POST['hfanio']) ? $_POST['hfanio'] : '2012';     
    $fecha_enaj = $anio.'-'.$mes;   
   // echo '<br/>';
    

    $gente[][] = '';
    $gente[0][0] = '%'; $gente[0][1] = '[Todos]';    
    $gente[1][0] = 'V061712271'; $gente[1][1] = 'Jhon Higuera';
    $gente[2][0] = 'V197404910'; $gente[2][1] = 'Yessica Oviedo';
    $gente[3][0] = 'V168794262'; $gente[3][1] = 'Antonio Cardenas';    
    $gente[4][0] = 'V191118258'; $gente[4][1] = 'Jimmy Alonso';
    $gente[5][0] = 'V096726410'; $gente[5][1] = 'Roberto Loureiro';
    $gente[6][0] = 'V159832640'; $gente[6][1] = 'Amaru Pastran';
    $gente[7][0] = 'V175147159'; $gente[7][1] = 'Humberto Molina';
    
    $meses[][] = '';
    $meses[0][0] = '01'; $meses[0][1] = 'Enero';    
    $meses[1][0] = '02'; $meses[1][1] = 'Febrero';
    $meses[2][0] = '03'; $meses[2][1] = 'Marzo';
    $meses[3][0] = '04'; $meses[3][1] = 'Abril';
    $meses[4][0] = '05'; $meses[4][1] = 'Mayo';
    $meses[5][0] = '06'; $meses[5][1] = 'Junio';
    $meses[6][0] = '07'; $meses[6][1] = 'Julio';
    $meses[7][0] = '08'; $meses[7][1] = 'Agosto';
    $meses[8][0] = '09'; $meses[8][1] = 'Septiembre';
    $meses[9][0] = '10'; $meses[9][1] = 'Octubre';
    $meses[10][0] = '11'; $meses[10][1] = 'Noviembre';
    $meses[11][0] = '12'; $meses[11][1] = 'Diciembre'; 

    $anios[][] = '';
    $anios[0][0] = '2007'; $anios[0][1] = '2007';
    $anios[1][0] = '2008'; $anios[1][1] = '2008';
    $anios[2][0] = '2009'; $anios[2][1] = '2009';
    $anios[3][0] = '2010'; $anios[3][1] = '2010';
    $anios[4][0] = '2011'; $anios[4][1] = '2011';
    $anios[5][0] = '2012'; $anios[5][1] = '2012';
    $anios[6][0] = '2013'; $anios[6][1] = '2013';
    $anios[7][0] = '2014'; $anios[7][1] = '2014';
    $anios[8][0] = '2015'; $anios[8][1] = '2015';
    $anios[9][0] = '2016'; $anios[9][1] = '2016';
    $anios[10][0] = '2017'; $anios[10][1] = '2017';
    
    if (!isset($_SESSION)) { 
        session_start();               
    }  
    
  //  echo $_SESSION['id_usuario'];
    
    //$_SESSION['fecha_enaj'] = $anio.'-'.$mes.'-'.'%'; 
    $allow = sql_helper::get_permissions(isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '','historial.php');
    
   // print_r($allow); 
    //var_dump($allow);
    //echo $allow;
    
    if($allow['authenticated'] || $allow['non-registered'])
    {   
        /*                         
        $rif_distribuidor = $_SESSION['id_usuario'];
        $dsplit = explode('-', $rif_distribuidor);
        $xml = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$dsplit[0].$dsplit[1]);
        $data = trim(filter_var(stripslashes($xml), FILTER_SANITIZE_STRING));
        $limite = strlen($data)-4;
        $nombre_distribuidor = substr($data, 0, $limite);
        $agente_retencion_IVA = substr($data, $limite, 2);
        $contribuyente_IVA = substr($data, $limite+2, 2);
        */ 
        $_SESSION['enaj'] = array();
        $allow['rif_distribuidor'];

      //  var_dump($fecha_enaj,$staff);       
        if($allow['generar_xml']) {
            //var_dump(queries::prc_get_enajs_desc."'".$fecha_enaj."-%','".$staff."'");
            $_SESSION['enaj'] = sql_helper::exec_query(queries::prc_get_enajs_desc, "'".$fecha_enaj."-%','".$staff."'");
        } 
        else if($allow['rif_distribuidor']) {
            $_SESSION['enaj'] = sql_helper::exec_query(queries::prc_get_enajs_by_usuario_id, "'".$_SESSION['id_usuario']."','".$fecha_enaj."-%'");
        }
        else {
            $_SESSION['enaj'] = sql_helper::exec_query(queries::prc_get_enajs_by_distribuidor_id, "'".$_SESSION['id_usuario']."','".$fecha_enaj."-%'");
            }
                                                                                    
        $data = 'var data = [];';                
        $max=count($_SESSION['enaj']);
        for($i = 0; $i < $max; $i++) {
            $data .= '
            data['.$i.'] = {
            id: "'.$_SESSION['enaj'][$i][0].'",
            rif_proveedor: "'.$_SESSION['enaj'][$i][1].'",
            rs_proveedor: "'.clean($_SESSION['enaj'][$i][9]).'",
            rif_distribuidor: "'.$_SESSION['enaj'][$i][2].'",
            rs_distribuidor: "'.clean($_SESSION['enaj'][$i][10]).'",
            rif_cliente: "'.$_SESSION['enaj'][$i][3].'",
            rs_cliente: "'.clean($_SESSION['enaj'][$i][11]).'",
            rif_tecnico: "'.$_SESSION['enaj'][$i][4].'",
            rs_tecnico: "'.clean($_SESSION['enaj'][$i][12]).'",
            serial: "'.$_SESSION['enaj'][$i][5].'",
            tipo_op: "'.$_SESSION['enaj'][$i][6].'",
            rs_tipo_op: "'.$_SESSION['enaj'][$i][13].'",
            fecha: "'.$_SESSION['enaj'][$i][7].'"                    
            };
            ';            
        }
       

        
        /*
        if($max > 0 && $cmd == 'xml') {
            $doctree = new DOMDocument('1.0', 'UTF-8');
            $doctree->formatOutput = true;    
            
            $docroot = $doctree->createElement("Proveedor");             
            $rif_proveedor = $enajs[0][1];
            $dsplit = explode('-', $rif_proveedor);        
            $docroot->setAttribute('RIF_proveedor', $dsplit[0].$dsplit[1]);
            $docroot->setAttribute('Periodo_Declaracion', $enajs[0][7]);
            $docroot = $doctree->appendChild($docroot);
            
            for($i = 0; $i < $max; $i++) {        
                $docdist = $doctree->createElement("Distribuidor");
                $rif_distribuidor = $enajs[$i][2];
                $dsplit = explode('-', $rif_distribuidor);                
                $docdist->setAttribute('Rif_distribuidor', $dsplit[0].$dsplit[1]);
                $docdist = $docroot->appendChild($docdist);
                
                $docmaqn = $doctree->createElement('Maquinas');
                $docmaqn = $docdist->appendChild($docmaqn);
                
                $docmaqn->appendChild($doctree->createElement('Numero_registro_maquina',$enajs[$i][5]));
                $docmaqn->appendChild($doctree->createElement('Fecha_operacion',$enajs[$i][7]));
                $docmaqn->appendChild($doctree->createElement('Tipo_operacion','0'.$enajs[$i][6]));                                    
                //--
                $docdist = $doctree->createElement("Distribuidor");
                $rif_distribuidor = $enajs[$i][2];
                $dsplit = explode('-', $rif_distribuidor);                
                $docdist->setAttribute('Rif_distribuidor', $dsplit[0].$dsplit[1]);
                $docdist = $docroot->appendChild($docdist);
                
                $docmaqn = $doctree->createElement('Usuario');
                $docmaqn = $docdist->appendChild($docmaqn);

                $rif_cliente_final = $enajs[$i][3];
                $dsplit = explode('-', $rif_cliente_final);             
                $docmaqn->appendChild($doctree->createElement('RIF_usuario',$dsplit[0].$dsplit[1]));
                $docmaqn->appendChild($doctree->createElement('Numero_registro_maquina',$enajs[$i][5]));
                $docmaqn->appendChild($doctree->createElement('Fecha_operacion',$enajs[$i][7]));
                $docmaqn->appendChild($doctree->createElement('Tipo_operacion','0'.$enajs[$i][6]));                                                
            }
            
            //echo $doctree->save("file.xml");
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"enajenaciones.xml\"");
            echo $doctree->saveXML();
        }        
        */
        //if($cmd == 'xml') 
            //header('location:get_xml.php');
      //  echo $data;
    }
    else {
         
       
               header("location:default.php");      
       
    }  
?>      
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

    <head>

<!-- ENTRA NUEVAS LIBRERIAS DE BOOSTRAP ETC  -->

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700,300&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>

        <!-- Bootstrap core CSS -->
        <link href="styles/historial/bootstrap.css" rel="stylesheet"> <!--MIGRADO  -->
        <link href="styles/historial/style.css" rel="stylesheet"> 
       

        <!-- Fontello CSS -->
     <!--   <link href="css\fontello\css\fontello.css" rel="stylesheet"> <!-- MIGRADO -->

        <!-- Plugins -->
     

        <link rel="shortcut icon" href="../favicon.ico">   
        <link rel="stylesheet" type="text/css" href="styles/historial/normalize-1.css" />  <!--MIGRADO  -->
        <link rel="stylesheet" type="text/css" href="styles/historial/demo-1.css" />  <!--MIGRADO  -->
        <link rel="stylesheet" type="text/css" href="styles/historial/tabs.css" />  <!--MIGRADO  -->
        <link rel="stylesheet" type="text/css" href="styles/historial/tabstyles.css" /> <!--MIGRADO  -->
        <script src="javascript/historial/modernizr.custom.js"></script>   

        <!-- iDea core CSS file -->
        <link href="styles/historial/style.css" rel="stylesheet">  <!--MIGRADO  -->
        <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script> 

      

        <!-- Custom css --> 
        <link href="controls/SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet"> 
<!-- FIN DE LIBRERIAS BOOSTRAP ETC-->



        <meta http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Lang" content="en" />
        <meta name="author" content="" />
        <meta http-equiv="Reply-to" content="@.com" />
        <meta name="generator" content="PhpED 6.0" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="creation-date" content="06/01/2011" />
        <meta name="revisit-after" content="15 days" />       
        <title>Ingreso de Enajenaciones</title>  
        
   <!--     <link rel="stylesheet" href="styles/historial/slick.grid.css" type="text/css"/>
        <link rel="stylesheet" href="styles/historial/jquery-ui-1.8.16.custom.css" type="text/css"/>
        <link rel="stylesheet" href="styles/historial/slick.pager.css" type="text/css"/>
        <link rel="stylesheet" href="styles/historial/enajenaciones.css" type="text/css"/>     -->
   
        <link href="css/ecrs_estilos.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="controls/SlickGrid/slick.grid.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/controls/slick.pager.css" type="text/css"/>
        <link rel="stylesheet" href="controls/SlickGrid/examples/enajenaciones.css" type="text/css"/> 
   
   
        <link href="css/validation.css" rel="stylesheet" type="text/css" />
        
        <script src="javascript/historial/jquery-1.7.1.min.js" type="text/javascript"></script> 

        <STYLE TYPE="text/css">
       
tr td {
    white-space: nowrap;
    padding:0px;
    margin: 0px
}

tr th {
    white-space: nowrap;
    padding:0px;
    margin: 0px;
}

TH{font-family: Arial; font-size: 10pt;

}

        td{
        padding:0px; 
        }
      
        </STYLE>

    </head>
    <body style="margin-top: 0px; background: white;"> 
        <script type="text/javascript">
            function consultar_periodo() {
                <?php if($allow['generar_xml']) { ?>
                document.historial_form.hfstaff.value=document.getElementById('staff').value;
                <?php } ?>
                document.historial_form.hfmes.value=document.getElementById('meses').value;
                document.historial_form.hfanio.value=document.getElementById('anios').value;
                document.historial_form.submit();           
            }
            
            function generar_periodo(fecha_enaj, solo_ventas) {
                window.location='get_xml.php?fecha_enaj=' + fecha_enaj + '&solo_ventas=' + solo_ventas;
            }

            function generar_distrib_maq(fecha_enaj, solo_distri_maq) {  // nuevo reporte
                window.location='get_xml.php?fecha_enaj=' + fecha_enaj + '&solo_distri_maq=' + solo_distri_maq;
            } 

            function generar_distrib(fecha_enaj, solo_distri) {
                window.location='get_xml.php?fecha_enaj=' + fecha_enaj + '&solo_distri=' + solo_distri;
            }
            
            function generar_servics(fecha_enaj, solo_servic) {
                window.location='get_xml.php?fecha_enaj=' + fecha_enaj + '&solo_servic=' + solo_servic;
            }            
        </script>    
        <form name="historial_form" id="historial_form" action="" method="post" enctype="multipart/form-data">            
            <input type="hidden" name="hfmes" value="<?php echo $mes; ?>" />
            <input type="hidden" name="hfanio" value="<?php echo $anio; ?>"/>
            <input type="hidden" name="hfstaff" value="<?php echo $staff; ?>"/>
            <input type="hidden" name="hfcmd"/>  
            
           
            
            <table width="700" align="center" border="0" cellpadding="4" >
            
                <tr>
                    <td valign="top">
                    <div class="form-inline" role="form" >
                <h1 id="forms" style="padding-bottom:0px" class="page-title">Consultas DIMAFI</h1>
                            
                  <!--          <h3><a href="http://ecrs.com.ve/?module=enajenaciones">Deberes y Obligaciones de los Distribuidores y (CSA) de M&aacute;quinas Fiscales</a></h3> -->

                            <br>

                                <div><button type='button' class='btn-default btn-xs' style='margin-right:20px;' onclick="window.location.href='default.php'" > Volver</button> <button type='button' class='btn-default btn-xs' onclick="window.location.href='ayuda_enaj.php'">Ayuda</button></div> 

                                <br>
                      <div class="row"  align="center" style="padding-bottom: 10px;">
                                     <label>
                                        <h6>Consultar Periodo de Enajenaci&oacute;n:</h6>
                                    </label>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="form-group span-15">
                                        <select class="form-control span-10" style="padding:5px;height: 32px; font-size:10px;" name='meses' id='meses'>
                                            <?php for ($i = 0; $i < count($meses); $i++) { ?>
                                                <option value="<?php echo $meses[$i][0]; ?>"<?php if ($meses[$i][0] == $mes) echo ' selected="selected"'; ?> ><?php echo $meses[$i][1]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="form-group span-10">

                                        <select class="form-control " style="padding:5px;height: 32px; font-size:10px;" name='anios' id='anios'>
                                            <?php for ($i = 0; $i < count($anios); $i++) { ?>
                                                <option value="<?php echo $anios[$i][0]; ?>"<?php if ($anios[$i][0] == $anio) echo ' selected="selected"'; ?>><?php echo $anios[$i][1]; ?></option>
                                            <?php } ?>   
                                        </select>
                                    </div>


                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="form-group span-20">

                                       
                                        <select class='form-control ' style="padding:5px;height: 32px; font-size:10px;" name="staff" id="staff">
                                            <?php for ($i=0; $i < count($gente); $i++) { ?>
                                                <option value="<?php echo $gente[$i][0]; ?>"<?php if ($gente[$i][0] == $staff) echo ' selected="selected"'; ?> class=' small'  ><?php echo $gente[$i][1]; ?></option>
                                            <?php } ?>
                                        </select>  
                                       

                                    </div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-sm btn-default" style="padding:0px" onclick="return consultar_periodo()">Buscar</button>
                      </div>
                                    <!--<input type="button" value="Enajenar Equipo" class='btn btn-sm btn-default'   onclick="window.location='enajenar.php'" />&nbsp;&nbsp;&nbsp; -->
                                    <!--fin de parte nueva --> 
                                    </div>

                                    <!-- aqui iba el otro panel que quite -->
                                    <center>                                                  
                                        <div id="myGrid"  style="width:700px; height:400px;" ></div>
                                        <br/>
                                        <!-- tabla principal  !-->
                                       
                                        <!-- fin de tabla principal -->


                                    </center>
                                    <br />
                                  
                                </td>
                            </tr>
                        </table>
            
            
            
          
            
<!--    </div>      -->
<!-- </div>   -->

      <div style="padding-top:10px">
                                    <table id="descragas" name="descragas" align="center" border="0" cellpadding="0" cellspacing="5">
                                        <tr>
                                            <td>  
                                                
                                                     <div style="padding-top: 5; padding-right:10px" align="center"><!-- primer escenario -->
                                                    <input type="button" class='btnn btn-sm btn-default' value="Generar XML ECRS Usuario" onclick="return generar_periodo('<?php echo $fecha_enaj; ?>', true)" />
                                                </div>
                                        
                                            </td>



                                            <td>
                                           
                                                
                                                     <div style="padding-top: 5; padding-right:10px" align="center"> <!--  segundo escenario -->
                                                    <input type="button" class='btnn btn-sm btn-default' value="Generar XML ECRS Dist" onclick="return generar_distrib_maq('<?php echo $fecha_enaj; ?>', true)" />
                                                </div>
                                                
                                                
                                            </td>
                                            <td>
                                                <div style="padding-top: 5;padding-right:10px" align="center"> <!-- tercer escenario-->
                                                    <input type="button" class='btnn btn-sm btn-default' value="Generar XML Dist Usuario" onclick="return generar_distrib('<?php echo $fecha_enaj; ?>', true)" />
                                                </div>
                                            </td>
                                            <td>
                                                <div style="padding-top: 5;padding-right:10px" align="center"> <!-- cuarto escenario  -->
                                                    <input type="button" class='btnn btn-sm btn-default'  value="Generar XML ECRS T&eacute;cnico" onclick="return generar_servics('<?php echo $fecha_enaj; ?>', true)" />
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div> 


            <script src="controls/SlickGrid/lib/jquery-1.7.min.js"></script>
            <script src="controls/SlickGrid/lib/jquery.event.drag-2.0.min.js"></script>
            <script src="controls/SlickGrid/slick.core.js"></script>
            <script src="controls/SlickGrid/slick.grid.js"></script>

<!--
            <script src="javascript/historial/jquery-1.7.min.js"></script>
            <script src="javascript/historial/jquery.event.drag-2.0.min.js"></script>

            <script src="javascript/historial/slick.core.js"></script>
            <script src="javascript/historial/slick.grid.js"></script> -->

            <script>                   
                var grid;
                var columns = [
                    {id: "id_fecha", name: "Fecha (DD/MM/AAAA)", field: "fecha"},
                    <?php if($allow['rif_distribuidor']) { ?>
                    {id: "id_rif_distribuidor", name: "Rif del Distribuidor", field: "rif_distribuidor"},
                    {id: "id_rs_distribuidor", name: "Nombre del Distribuidor", field: "rs_distribuidor"},
                    <?php } ?>
                    {id: "id_rif_cliente", name: "Rif del Cliente", field: "rif_cliente"},
                    {id: "id_rs_cliente", name: "Nombre del Cliente", field: "rs_cliente"},
                    {id: "id_rif_tecnico", name: "Rif del Tecnico", field: "rif_tecnico"},
                    {id: "id_rs_tecnico", name: "Nombre del Tecnico", field: "rs_tecnico"},
                    {id: "id_serial", name: "Numero de Registro Fiscal", field: "serial"},
                    {id: "id_tipo_op", name: "Tipo de Operacion", field: "tipo_op"},
                    {id: "id_rs_tipo_op", name: "Nombre del Tipo de Operacion", field: "rs_tipo_op"}                   
                ];     
                  
                var options = {
                    editable: false,
                    enableAddRow: false,
                    enableCellNavigation: true,
                    enableColumnReorder: false,
                };                

                $(function () {     
                    <?php echo $data; 
                     ?>
                    grid = new Slick.Grid("#myGrid", data, columns, options);
                });
            </script>
            </form>        
    </body>
</html>

