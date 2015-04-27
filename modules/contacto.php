<head>
    <!-- Google Maps javascript -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>

    <!-- Api de Google para el reCatcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Initialization of Plugins -->
    <script type="text/javascript" src="../estilos/js/template.js"></script>

    <!-- Custom Scripts -->
    <script type="text/javascript" src="../estilos/js/custom.js"></script>
    
    <script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="javascript\enajenar\jquery-1.9.1.js"></script>
    <script src="modules\javascript\contacto\contacto.js"></script>

</head>


<!-- banner start -->
<!-- ================ -->
<div class="banner">
    <div class="fixed-image dark-translucent-bg section" style="background-image:url('../estilos/images/portfolio-3.jpg');">
        <div class="container">
            <div class="space"></div>
            <h1>En CORPORACIÓN ECRS C.A, </h1>
            <div class="separator-2"></div>
            <p class="lead">trabajamos para brindarle el mejor servicio y ofrecerle respuestas oportunas a sus  requerimientos.<br class="hidden-xs hidden-sm">A continuación le entregamos una guía rápida de contactos, donde encontrará un canal de comunicación directo con nuestra empresa.</p>
        </div>
    </div>
</div>


<!-- banner end -->


<section class="main-container">

    <div class="container">
        <div class="row">

            <!-- main start -->
            <!-- ================ -->
            <div class="main col-md-12">

                <!-- page-title start -->
                <!-- ================ -->

                <!-- page-title end -->
                <div class="row">

                    <div class="col-md-5">
                        <h1>Contáctenos</h1>
                        <div class="separator-2"></div>


                                        <?php
                                            
                                            if(isset($_POST["g-recaptcha-response"]) && $_POST["g-recaptcha-response"]){
                                                
                                                //var_dump($_POST);
                                                $secret = "6LcRZAUTAAAAADe5SSXtPWcGJFn5pceG0lwdhLH4";
                                                $ip = $_SERVER['REMOTE_ADDR'];
                                                $captcha = $_POST['g-recaptcha-response'];
                                                $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
                                                //var_dump($rsp);
                                                $arr = json_decode($rsp, TRUE);
                                                if($arr['success']){
                                                    
                                                    
                                                    
                                                    
                                                //josemejicano82@gmail.com  contactenos@ecrs.com.ve
                                                $mail_corporacion = 'contactenos.ecrs@gmail.com';
                                                $email_usuario = $_POST["email"];
                                                //cuerpo del correo que se envia a contactenos@ecrs.com.ve
                                                $to = $mail_corporacion;
                                                $subject = "Nuevo Mensaje Sección Contáctenos";

                                                $contenido = "<html><head></head><body>"."\n";
                                                $contenido .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo01.png' alt='' />"."<br><br>";
                                                $contenido .= "Se ha recibido un mensaje a través de la sección de contacto, en la plataforma web www.ecrs.com.ve.<br> Basados en la premisa de ofrecer calidad de servicio a nuestros clientes, atenderemos su requerimiento<br> con eficiencias  y celeridad."."<br><br>";
                                                $contenido .= "A continuación se encuentran los detalles del mensaje."."<br><br>";
                                                $contenido .= "Nombre: ".$_POST["nombre"]."<br>";
                                                $contenido .= "Empresa: ".$_POST["empresa"]."<br>";
                                                $contenido .= "Email: ".$email_usuario."<br>";
                                                $contenido .= "Teléfono: ".$_POST["telef_cod"].$_POST["telefono"]."<br>";
                                                if($_POST["celular_cod"] != '' && $_POST["celular_numero"] != ''){
                                                    $contenido .= "Celular: ".$_POST["celular_cod"].$_POST["celular_numero"]."<br>";
                                                }
                                                if($_POST["twitter"] != ''){
                                                    $contenido .= "Twitter: ".$_POST["twitter"]."<br>";
                                                }
                                                if($_POST["BBpin"] != ''){
                                                    $contenido .= "Blackberry PIN: ".$_POST["BBpin"]."<br>";
                                                }
                                                $contenido .= "Motivo: ".$_POST["motivos"]."<br><br>";
                                                $contenido .= "Comentario: ".$_POST["mensaje"]."<br><br><br>";
                                                $contenido .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo03.png' alt='' />";
                                                $contenido .= "</body></html>";

                                                // Always set content-type when sending HTML email
                                                $headers = "MIME-Version: 1.0" . "\r\n";
                                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                $headers .= 'From: <contactenos@ecrs.com.ve>' . "\r\n";

                                                if(mail($to, $subject, $contenido ,$headers)){
                                                    ?>    
                                                        <div class="alert alert-success" id='mail_contacto' role="alert">
                                                            Gracias por contactarnos, usted recibirá una respuesta a la brevedad posible.
                                                            Si no llega a su bandeja de entrada revise su carpeta de SPAM.
                                                        </div>
                                                    <?php 

                                                    if($mail_corporacion != $email_usuario){
                                                        // Cuerpo del mensaje que se envia al usuario
                                                        $para = $email_usuario;
                                                        $titulo = "Corporación ECRS C.A.";

                                                        $counter = "<html><head></head><body>"."\n";
                                                        $counter .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo01.png' alt='' />"."<br>";
                                                        $counter .= "Gracias por contactarnos."."<br><br><br>";
                                                        $counter .= "En Corporación ECRS, C.A., estamos para brindarle soluciones oportunas y satisfactorias. Le informamos <br> que el requerimiento ingresado a través de nuestra plataforma de contacto, ha sido recibido<br> satisfactoriamente. En breve nos comunicaremos con usted para ofrecerle respuesta a sus necesidades."."<br>";
                                                        $counter .= "Este email es meramente informativo, por favor NO responda este email, si desea<br> contactarnos utilice el formulario de contacto de nuestro website."."<br><br><br>";
                                                        $counter .= "Saludos Cordiales."."<br><br><br>";
                                                        $counter .= "<img src='http://ecrs.com.ve/modules/img/plantilla_correo03.png' alt='' />";
                                                        $counter .= "</body></html>";
                                                        // Always set content-type when sending HTML email
                                                        $header = "MIME-Version: 1.0" . "\r\n";
                                                        $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                                        $header .= 'From: <contactenos@ecrs.com.ve>' . "\r\n";
                                                        mail($para, $titulo, $counter ,$header);
                                                    }
                                                }else{
                                                    echo "Ocurrió un error en el envio, por favor intente mas tarde. Disculpe las molestias ocasionadas.";
                                                    
                                                    ?>    
                                                    <div class="alert alert-danger" id="mail_error" role="alert">
                                                        Ocurrió un error con el código de validación en imagen, presione el botón regresar de su navegador e intente nuevamente
                                                    </div>
                                                    <?php
                                                    
                                                }
                                                   
                                                }else{
                                                    ?>    
                                                    <div class="alert alert-danger" id="error_captcha" role="alert">
                                                        Ocurrió un error con el código de validación en imagen, presione el botón regresar de su navegador e intente nuevamente
                                                    </div>
                                                    <?php 
                                                }
                                                
                                            } ?>   

                            		

                                <p style="color:#a30327;"> Los campos marcados con ( * ) son oboligatorios </p>
                                
                                
                            <div class="contact-form"style="padding-right: 100px;">
                                <form id="form2xcp" name="form2xcp" method="post" action="" onsubmit="comprueba(); return false">
                                    
                                    <div class="form-group has-feedback">
                                        <label for="nombre"><font style="color:red">*&nbsp;</font>Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="">

                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="empresa"><font style="color:red">*&nbsp;</font>Empresa</label>
                                        <input type="text" class="form-control" id="empresa" name="empreso" placeholder="">

                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="email"><font style="color:red">*&nbsp;</font>E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="">

                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="numero"><font style="color:red">*&nbsp;</font>Número Local</label>
                                        <input type="text" class="form-control" id="telefono " name="telefono" placeholder="">

                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="celular_numero"><font style="color:red">*&nbsp;</font>Móvil</label>
                                        <div class="row ">
                                            <input type="text" class="form-control" id="celular_numero" name="celular_numero" placeholder="">
                                        </div>
                                    </div>
                                    </br>
                                    
                                    <SELECT NAME="Colores" name="motivos" SIZE="1" class="form-control" STYLE="font-family : Arial; font-size : 9pt">
                                        <OPTION VALUE="">--Seleccione el Motivo--</OPTION>
                                        <OPTION VALUE="r">Solucitud de Producto(s)</OPTION>
                                        <OPTION VALUE="g">Consultas o Dudas</OPTION>
                                        <OPTION VALUE="b">Sugerencias</OPTION>
                                        <OPTION VALUE="b">Reclamos</OPTION>
                                        <OPTION VALUE="b">Otros</OPTION>
                                    </SELECT> 
                                    
                                    </br>
                                    <div class="form-group has-feedback">
                                        <label for="mensaje"><font style="color:red">*&nbsp;</font>Mensaje</label>
                                        <textarea class="form-control" rows="4" id="mensaje" name="mensaje" placeholder=""></textarea>

                                    </div> 

                                    <!-- Captcha Nuevo -->
                                    <div class="g-recaptcha" data-sitekey="6LcRZAUTAAAAAHzC9RQbtuvi6gWGvYwXbaS-CdGK"></div>

                                    <input type="submit" value="Submit" id="Enviar" name="Enviar" class="btn btn-default">


                                    <script type="text/javascript">
                                        var valid = new Validation('form2xcp', {immediate: true, focusOnError: true});
                                        function comprueba() {
                                            var result = valid.validate();
                                            if (result) {
                                                form2xcp.submit();
                                            } else {
                                                return false;
                                            }
                                            return false;
                                        }
                                    </script>





                                </form>

                                
                        </div>
                    </div>
                    <div class="col-md-7" style="padding-left: 31px;" >

                        <h1 class="page-title">Ubicación</h1>
                        <div class="separator-2"></div>
                        <!-- google maps start -->
                        <br>
                        <br>
                        <br>
                        
                        <div class="iframe-rwd">
                            <iframe width="600" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.123100361198!2d-66.92469799999996!3d10.490961000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c2a5f2253def0dd%3A0x66beb4568b673398!2sCORPORACION+ECRS%2C+C.+A.!5e0!3m2!1ses-419!2sve!4v1429201229239"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Seattle,+WA&amp;aq=0&amp;oq=seattle&amp;sll=37.822293,-85.76824&amp;sspn=6.628688,16.907959&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=Seattle,+King,+Washington&amp;z=11&amp;ll=47.60621,-122.332071" style="color:#0000FF;text-align:left">View Larger Map</a></medium>
                        </div>
                             
                        <!-- google maps end -->
                    </div>
                </div>
            </div>
            <!-- main end -->

        </div>
    </div>
</section>
<!-- main-container end -->




<div class="section parallax dark-translucent-bg parallax-bg-2">
    <div class="container">
        <div class="row">


        </div>
        <center>
            <div class="col-sm-12">
                <h2 class="title"style="padding-top: 10px;">Suscríbete</h2><br>
                <p class="lead">Suscríbase para recibir nuestros boletines promocionales, obteniendo miles de ofertas y descuentos. Además de mantenerse actualizado  con noticias y novedades de los sectores Retail & Hospitality.</p>
                <form class="margin-bottom-clear form-inline">
                    <div class="form-group has-feedback">
                        <label class="sr-only" for="subscribe">Dirección de Correo</label>
                        <input type="email" class="form-control" id="subscribe" placeholder="Correo Electrónico" name="subscribe">
                    </div>
                    <button type="button" id="guardar_correo" class="btn btn-default btn-sm">Enviar</button>
                </form>
                <div class="col-sm-3"></div>
                <div class="alert alert-success col-sm-6" style="display:none" id="correo_guardado" style="margin-right: 75px; margin-left: 75px;">
                    <p STYLE="font-family : Arial; font-size : 11pt">Gracias por su suscripción.</p>
                </div>
                <div class="alert alert-danger col-sm-6" style="display:none" id="correo_warning" style="margin-right: 75px; margin-left: 75px;">
                    <p STYLE="font-family : Arial; font-size : 11pt">Se se pudo realizar la Suscripción. Inténtelo más tarde.</p>
                </div>
                <div class="col-sm-3"></div>
                    
            </div>
        </center>
    </div>
</div>













