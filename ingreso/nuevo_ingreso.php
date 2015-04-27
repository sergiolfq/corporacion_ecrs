
<!DOCTYPE html>
<?php require_once("../soporte/dal/conexion.php"); ?>

<html>
    <head>
        <title>Registro de Usuario</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="styles/registro/bootstrap.css" rel="stylesheet">
        <link href="styles/registro/bootstrap-responsive.css" rel="stylesheet">
        <link href="styles/registro/preview.css" rel="stylesheet">
        <link href="styles/registro/fontello.css" rel="stylesheet">
        <link href="styles/registro/styles.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href="styles/registro/font-awesome.css" rel="stylesheet">


    </head>
    <body>

        <!-- background image -->
        <div class="coming-soon-bg"></div>


        <div class="divider large visible-desktop"></div>
        <div class="divider  hidden-desktop"></div>

        <div class="container">



            <div class="row-fluid" id="demo-1">
                <div class="span10 offset1">

                    <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#panel1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;&nbsp;&nbsp;<span>Datos de Identificación</span></a></li>
                            <li><a href="#panel2" data-toggle="tab"><i class="icon-user"></i>&nbsp;&nbsp;&nbsp;<span>Registro</span></a></li>
                            <li><a href="#panel3" data-toggle="tab"><i class="icon-key"></i>&nbsp;&nbsp;&nbsp;<span>Olvidó su contraseña ?</span></a></li>
                            <!--li><a href="#panel4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>ContÃ¡ctenos</span></a></li-->
                        </ul>
                        <div class="tab-content ">
                            <div class="tab-pane active" id="panel1">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <h4 style="margin-top: 8px;"><i class="icon-lock"></i>&nbsp;&nbsp; Ingrese </h4>


                                        <div class="alert alert-error" style="display:none" id="sesion_error" style="margin-right: 75px; margin-left: 75px;">
                                            El usuario o contraseña no son correctos
                                        </div>

                                        <label>Email</label>
                                        <input type="text" id="email" name="email" class="span8">
                                        <label>Password<a href="#" class="pull-right">&nbsp;</a> </label>
                                        <input type="password" id="password" name="password" class="span8">

                                        <br>
                                        <br>

<!--<center>-->
                                        <button type="button" onclick="window.location.href = '/?module=noticias_home'" class="btnn-default small">Volver</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" id="iniciar_sesion" class="btnn-default small">Iniciar Sesión</button>
                                        <!--</center>-->

                                        <br>
                                        <br>   

                                        <!--                                        <label>Control</label>
                                        
                                                                                <input>  </input>-->
                                    </div>



                                    <div class="span6">
                                        <h4>&nbsp;&nbsp;Problemas al ingresar </h4>
                                        <div class="box">
                                            <p class="text-justify">
                                                Si tiene problemas para acceder a su cuenta, comuníquese con nosotros a través del formulario de contacto, para que podamos solucionar y monitorear el inconveniente.
                                            </p>
                                        </div>


                                        <div class="row">

                                            <center> <img src="img/ecrs-tabla.png"> </center>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        
                            <div class="tab-pane" id="panel2">
                                <form method="post" id="formulario1" onsubmit="return validaciones()"> 
                                    <div class="row-fluid">
                                        <div class="span4" id="registro">
                                            <h4><i class="icon-user"></i>&nbsp;&nbsp; Registro</h4>

                                            <div>

                                                <p ><h5> Seleccione el tipo de usuario a registrar:</h3></p>

                                                <label class="radio">
                                                    <input type="radio" name="optionsRadios" id="distribuidor" value="2">
                                                    Distribuidor.
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="optionsRadios" id="csa" value="10">
                                                    Centro de Servicio Autorizado (CSA).
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="optionsRadios" id="casa_software" value="11">
                                                    Casas de Software.
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="optionsRadios" id="integrador" value="3">
                                                    Integrador.
                                                </label>    
                                                <label class="radio">
                                                    <input type="radio" name="optionsRadios" id="vendedor" value="0">
                                                    Vendedor.
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="optionsRadios" id="usuario" value="1">
                                                    Usuario Final.
                                                </label>
                                                
                                            </div>

                                            <br>
                                            <br>
                                            <center>
                                                <button type="button" id="continuar" class="btnn-default small">Continuar</button>
                                            </center>

                                        </div>

                                        <div class="span8" id="bienvenido">
                                            <h4><i class="icon-user"></i>&nbsp;&nbsp;Bienvenido</h4>

                                            <div class="box">
                                                <p class="text-justify">
                                                    Ingrese sus datos&nbsp; en el siguiente formulario para proceder&nbsp; a crear su cuenta &nbsp;, y &nbsp;tener &nbsp;acceso a &nbsp;
                                                    los
                                                    beneficios que &nbsp;Corporación ECRS C.A. ofrece a sus usuarios registrados.

                                                    Ingrese sus datos&nbsp; en el siguiente formulario para proceder&nbsp; a crear su cuenta &nbsp;, y &nbsp;tener &nbsp;acceso a &nbsp;
                                                    los
                                                    beneficios que &nbsp;Corporación ECRS C.A. ofrece a sus usuarios registrados.

                                                    Ingrese sus datos&nbsp; en el siguiente formulario para proceder&nbsp; a crear su cuenta &nbsp;, y &nbsp;tener &nbsp;acceso a &nbsp;
                                                    los
                                                    beneficios que &nbsp;Corporación ECRS C.A. ofrece a sus usuarios registrados.
                                                    Ingrese sus datos&nbsp; en el siguiente formulario para proceder&nbsp; a crear su cuenta &nbsp;, y &nbsp;tener &nbsp;acceso a &nbsp;
                                                    los
                                                    beneficios que &nbsp;Corporación ECRS C.A. ofrece a sus usuarios registrados.
                                                </p>

                                            </div>

                                        </div>
                                    </div>


                                    <div class="row-fluid" id="datos_ingreso">

                                        <div class=" span10 offset1">

                                            <h4>&nbsp;&nbsp;Datos del Usuario</h4>

                                            <br>

                                            <div class="row2" style="margin-bottom: 0px">
                                                <font style="color:red">*&nbsp;</font>Razón Social &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" id="razon_social" title="Nombre de la empresa" name="razon_contrib" class="input-block-level span4">
                                                &nbsp;&nbsp;&nbsp;&nbsp;<font style="color:red">*</font> RIF N° &nbsp;
                                                <select id="Letra_rif_cliente" required name="Letra_rif_cliente" title="Elija el tipo de RIF" class="input-mini">
                                                    <option value="">--</option>
                                                    <option value="J">J</option>
                                                    <option value="G">G</option>
                                                    <option value="V">V</option>
                                                    <option value="E">E</option>
                                                    <option value="P">P</option>
                                                </select>
                                                &nbsp;
                                                <input type="text" id="id_cliente" required maxlength="9" title="N° de Registro de Identificación Fiscal" name="id_cliente" class="input-block-level span2">

                                            </div>

                                            <div class="row2" style="margin-bottom: 0px">
                                                <font style="color:red">*&nbsp;</font>Contacto &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" value="" id="contacto" placeholder="Nombre" name="nombre" class="input-block-level span4">
                                                &nbsp;&nbsp;&nbsp;  
                                                <font style="color:red">*</font> RIF N° &nbsp;
                                                <select id="Letra_rif_contacto" name="Letra_rif_contacto" class="input-mini">
                                                    <option value="">--</option>
                                                    <option value="J">J</option>
                                                    <option value="G">G</option>
                                                    <option value="V">V</option>
                                                    <option value="E">E</option>
                                                    <option value="P">P</option>
                                                </select>
                                                &nbsp;
                                                <input type="text" value="" id="rif_contacto" maxlength="9" name="rif_contacto" class="input-block-level span2 ">
                                            </div>

                                            <div class="row2" style="margin-bottom: 0px">
                                                <font style="color:red">*&nbsp;</font>Dirección &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <textarea row="2" id="direccion" title='Domicilio Fiscal' name="direccion" class="span8"></textarea>
                                            </div>

                                            <div class="row2" style="margin-bottom: 0px">
                                                <font style="color:red">*&nbsp;</font>País&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  
                                                <SELECT class="span3" id="pais_contrib" name="pais_contrib" SIZE="1" STYLE="font-family : Arial; font-size : 9pt">
                                                    <?php
                                                    $query_pa = "SELECT * FROM `tbl_paises` ORDER BY pais";
                                                    $result = mysql_query($query_pa);
                                                    echo '<option value="">Seleccione</option>';
                                                    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                                        if ($pais_contribu == $row['pk_pais']) {
                                                            echo '<option value="' . $row['pk_pais'] . '" selected="selected">' . $row['pais'] . '</option>';
                                                        } else {
                                                            echo "<option value='" . $row['pk_pais'] . "'>" . $row['pais'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </SELECT> 

                                                &nbsp;&nbsp;<font style="color:red">*&nbsp;</font>Estado&nbsp;
                                                <select class="span3" id="estado_contrib" name="estado_contrib" STYLE="font-family : Arial; font-size : 9pt"></select>

                                                &nbsp;&nbsp;&nbsp;<font style="color:red">*&nbsp;</font>Ciudad &nbsp;
                                                <SELECT class="span2" id="ciudad_contrib"  name="ciudad_contrib" STYLE="font-family : Arial; font-size : 9pt"></SELECT> 
                                            </div>

                                            <div class="row2" style="margin-bottom: 0px">
                                                <font style="color:red">*&nbsp;</font>Teléfono &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                <input type="text" id="phone" title="Número de Teléfono" maxlength="14" name="phone_contrib" pattern="[+-0-1-2-3-4-5-6-7-8-9]*" class="input-block-level span3">
                                                &nbsp;&nbsp;

                                                <font style="color:red">*&nbsp;</font>Email &nbsp;
                                                <input type="email" id="email_contrib" title="Correo Electrónico de la empresa" name="email_contrib" class="input-block-level span4">
                                            </div>

                                        <div id="personal_tecnico" style="display:none">   
                                            <h4>&nbsp;&nbsp;Datos del Técnico</h4>
   
                                            Personal Técnico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="text" value="" id="nombre_tecnico1" title="Nombre del técnico" name="nombre_tecnico1" class="input-block-level span3">

                                            &nbsp; &nbsp; &nbsp; <font style="color:red">*</font> RIF N° &nbsp;
                                            <select id="letra_rif_tecnico1" name="letra_rif_tecnico1" class="input-mini">
                                                <option value="">--</option>
                                                <option value="J">J</option>
                                                <option value="G">G</option>
                                                <option value="V">V</option>
                                                <option value="E">E</option>
                                                <option value="P">P</option>
                                            </select>
                                            &nbsp;<input type="text" id="rif_tecnico1" maxlength="9" title="N° de Registro de Identificación Fiscal" name="rif_tecnico1" class="input-block-level span2 ">

                                            <font id="more_tec" type="button" data-toggle="tooltip" data-placement="right" title="Agregar Técnico">
                                            <img src="img/check.png" id="mas" width="25" height="25" style="padding: 0px 0px 10px 3px;">
                                            </font>
                                            <font id="sin_tec" type="button" data-toggle="tooltip" data-placement="right" title="Limite de Técnico">
                                            <img src="img/delete.png" id="mas" width="30" height="30" style="padding: 0px 0px 10px 0px;">
                                            </font>

                                            <div class="form-inline" id="new_tec">
                                                Personal Técnico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" value="" id="nombre_tecnico2" title="Nombre del técnico" name="nombre_tecnico2" class="input-block-level span3">

                                                &nbsp; &nbsp; &nbsp; <font style="color:red">*</font> RIF N° &nbsp;
                                                <select id="letra_rif_tecnico2" name="letra_rif_tecnico2" class="input-mini">
                                                    <option value="">--</option>
                                                    <option value="J">J</option>
                                                    <option value="G">G</option>
                                                    <option value="V">V</option>
                                                    <option value="E">E</option>
                                                    <option value="P">P</option>
                                                </select>
                                                &nbsp;<input type="text" id="rif_tecnico2" maxlength="9" title="N° de Registro de Identificación Fiscal" name="rif_tecnico2" class="input-block-level span2 ">

                                                <font id="delete_tec" type="button" data-toggle="tooltip" data-placement="right" title="Eliminar Técnico">
                                                <img id="borrar_tec" src="img/delete.png" width="30" height="30" style="padding: 0px 0px 10px 0px;">
                                                </font>

                                            </div>

                                            <div class="form-inline" id="other_tec">
                                                Personal Técnico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" value="" id="nombre_tecnico3" title="Nombre del técnico" name="nombre_tecnico3" class="input-block-level span3">

                                                &nbsp; &nbsp; &nbsp; <font style="color:red">*</font> RIF N° &nbsp;
                                                <select id="letra_rif_tecnico3" name="letra_rif_tecnico3" class="input-mini">
                                                    <option value="">--</option>
                                                    <option value="J">J</option>
                                                    <option value="G">G</option>
                                                    <option value="V">V</option>
                                                    <option value="E">E</option>
                                                    <option value="P">P</option>
                                                </select>
                                                &nbsp;<input type="text" id="rif_tecnico3" maxlength="9" title="N° de Registro de Identificación Fiscal" name="rif_tecnico3" class="input-block-level span2 ">

                                                <font type="button" data-toggle="tooltip" data-placement="right" title="Eliminar Técnico">
                                                <img id="borro_tec" src="img/delete.png" width="30" height="30" style="padding: 0px 0px 10px 0px;">
                                                </font>

                                            </div> 


                                            <div class="form-inline" id="mas_tec">
                                                Personal Técnico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" value="" id="nombre_tecnico4" title="Nombre del técnico" name="nombre_tecnico4" class="input-block-level span3">

                                                &nbsp; &nbsp; &nbsp; <font style="color:red">*</font> RIF N° &nbsp;
                                                <select id="letra_rif_tecnico4" name="letra_rif_tecnico4" class="input-mini">
                                                    <option value="">--</option>
                                                    <option value="J">J</option>
                                                    <option value="G">G</option>
                                                    <option value="V">V</option>
                                                    <option value="E">E</option>
                                                    <option value="P">P</option>
                                                </select>
                                                &nbsp;<input type="text" id="rif_tecnico4" maxlength="9" title="N° de Registro de Identificación Fiscal" name="rif_tecnico4" class="input-block-level span2 ">

                                                <font  type="button" data-toggle="tooltip" data-placement="right" title="Eliminar Técnico">
                                                <img id="masDelete_tec" src="img/delete.png" width="30" height="30" style="padding: 0px 0px 10px 0px;">
                                                </font>

                                            </div>
                                        </div>


                                            <h4></h4>

                                            <div class="alert alert-error" style="display:none" id="no_conexion" style="margin-right: 75px; margin-left: 75px;">
                                                Tiempo de espera agotado para validación de RIF. Intente nuevamente.
                                            </div>
                                            <div class="alert alert-error" style="display:none" id="rif_invalido" style="margin-right: 75px; margin-left: 75px;">
                                                Rif de la Razón Social Inexistente o Inválido. Verifique sus datos.
                                            </div>
                                            <div class="alert alert-error" style="display:none" id="email_invalido" style="margin-right: 75px; margin-left: 75px;">
                                                Esta cuenta de Correo Electrónico ya existe. Ingrese una cuenta nueva.
                                            </div>
                                            <div class="alert alert-error" style="display:none" id="rif_duplicado" style="margin-right: 75px; margin-left: 75px;">
                                                El Rif de la Razón Social no es valido. Verifique sus datos.
                                            </div>
                                            <div class="alert alert-error" style="display:none" id="user_error" style="margin-right: 75px; margin-left: 75px;">
                                                Ha ocurido un error al cargar los datos. Por favor intente nuevamente.
                                            </div>
                                            <div class="alert alert-error" style="display:none" id="tec_existe" style="margin-right: 75px; margin-left: 75px;">
                                                EL Personal Técnico que intenta validar, se encuentra activo en otro Distribuidor. Por favor contacte al Proveedor.
                                            </div>

                                            <br>
                                            <div id="procesando">
                                                <center>
                                                    <div style="font-family : Arial; font-size : 16pt;">
                                                        <img src="img/procesando.gif" width="30" height="30">
                                                    </div>
                                                </center>
                                                <br>
                                            </div>

                                            <center>
                                                <button type="button" id="back_registro" class="btnn-default small">Volver</button>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <button type="submit" id="guardar_datos" class="btnn-default small">Guardar</button>

                                            </center>

                                        </div>
                                    </div>
                                </form>    
                            </div>
                                 

                            <div class="tab-pane" id="panel3">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <h4 style="margin-top: 8px;"><i class="icon-key"></i>&nbsp;&nbsp; Recuperación de contraseña</h4>
                                        
                                        <div class="alert alert-error" style="display:none" id="error_recuperar" style="margin-right: 75px; margin-left: 75px;">
                                            Los datos introducidos no son correctos.
                                        </div>

                                        <label>Email</label>
                                        <input type="text" id="email_recuperar" class="span8">

                                        <label>RIF N°</label>
                                        <input type="text" id="rif_recuperar" class="span8">
                                        <br>
                                        <br>
                                        
                                        <button type="button" id="recuperar_clave" class="btnn-default small" style="margin-left: 110px;">Enviar</button>
                                    </div>
                                    <div class="span6">
                                        <h4>&nbsp;&nbsp;Ayuda</h4>
                                        <div class="box">
                                            <p>Si ha olvidado su contraseña, introduzca  la dirección de correo electrónico que utilizó para asociar su cuenta y su número de cedula. Posteriormente verifique su correo, le enviaremos un email con las indicaciones para obtener una nueva clave de ingreso. </p>

                                            <p> Recuerde que la contraseña es sensible y precisa, por lo que si usa mayúsculas, debe utilizar los mismos caracteres siempre que inicie una sesión.</p>

                                        </div>

                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </div>
            
            
            
            <div id="modal_save" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                  
                  <h3 id="myModalLabel">Información</h3>
                </div>
                <div class="modal-body">
                    <p>Hemos recibido sus datos satisfactoriamente, estos se encuentran en proceso de verificación. Pronto lo estaremos contactando.</p><br>
                    
                </div>
                <div class="modal-footer">
                    <center>
                        <button class="btnn-default small" id="datos_guardatos">Aceptar</button>
                    </center>    
                </div>
                <script src="javascript/registro/bootstrap.js"></script>
            </div>
            
            <div id="modal_recuperar_clave" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h3 id="myModalLabel">Información</h3>
                </div>
                <div class="modal-body" style="text-justify: ">
                    <p>Verifique su correo electrónico, le hemos enviado toda la información necesaria para restablecer su contraseña.
                    Si no localiza el email en su BANDEJA DE ENTRADA, por favor revise su carpeta de SPAM. Este puede haber sido clasificado como correo electrónico no deseado.</p>
                    
                </div>
                <div class="modal-footer">
                    <center>
                        <button class="btnn-default small" data-dismiss="modal" id="datos_guardatos">Aceptar</button>
                    </center>    
                </div>
                <script src="javascript/registro/bootstrap.js"></script>
            </div>
            
            



            <script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
            <script src="javascript/registro/registro.js"></script>
            <script src="javascript/registro/jquery-1.9.1.js"></script>
            <script src="javascript/registro/bootstrap.js"></script>
            <script src=javascript/registro/tabs-addon.js"></script>

            <script type="text/javascript">
                                    $(function ()
                                    {
                                        $("a[href^='#demo']").click(function (evt)
                                        {
                                            evt.preventDefault();
                                            var scroll_to = $($(this).attr("href")).offset().top;
                                            $("html,body").animate({scrollTop: scroll_to - 80}, 600);
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
                                            trigger: "hover", html: true, placement: "top"
                                        });
                                    });

            </script>

    </body>
</html>


