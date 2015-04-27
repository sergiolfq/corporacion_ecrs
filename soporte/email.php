<?php
 //require_once "mail.php";

 /*
 $to = "ljimenez@ecrs.com.ve";
 $subject = "Hi!";
 $body = "Hi,\n\nComo estas?";
 if (mail($to, $subject, $body)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
  */
  /*
  //Asignamos a Host el nombre de nuestro servidor smtp
  $mail->Host = "mail.quorion.com.ve"; //Puedes dejar el mismo en ambos scripts ya que ambos dominios estan en el mismo servidor y funciona igual

  //Le indicamos que el servidor smtp requiere autenticación
  $mail->SMTPAuth = true;  //Esto es muy importante ya que el servidor de Windows requiere autenticación, esto es para evitar que se envie SPAM

  //Le decimos cual es nuestro nombre de usuario y password
  $mail->Username = "micuenta@quorion.com.ve"; 
  $mail->Password = "mipassword";

  //Indicamos cual es nuestra dirección de correo y el nombre que 
  //queremos que vea el usuario que lee nuestro correo
  $mail->From = "micuenta@quorion.com.ve";  //Es muy importante que uses la misma anterior, porque muchos correos como Hotmail, gmail,etc ponen automáticamente en spam los 
                                                                                              //correos que no coinciden
  $mail->FromName = "Contacto - Quorion";

  //el valor por defecto 10 de Timeout es un poco corto 
  // por tanto lo pongo a 30  
  $mail->Timeout=30;
  */
 ?>
 
 <?php
    
    require_once("../includes/PHPMailer/PHPMailerAutoload.php");   
       /*$activacion = new Shop();
       $activacion->activateMember($_POST['pass']); */
       
    //require_once('../includes/PHPMailer_v2.0.4/class.pop3.php'); // required for POP before SMTP
    //$pop = new POP3();
    //$pop->Authorise('mail.ecrs.com.ve', 110, 30, 'ljimenez@ecrs.com.ve', 'yq$pgeM#', 1);
    //Autenticacion De SMTP pot GMAIL
    $mail = new PHPMailer();
    $mail->IsSMTP(); // send via SMTP
    $mail->SMTPAuth = true; // turn on SMTP authentication
    //$mail->SMTPSecure = 'ssl';
    $mail->Host = "mail.ecrs.com.ve";
    $mail->Port = 26;
    $mail->Username = "distribuidores@ecrs.com.ve"; // SMTP username
    $mail->Password = "euAu%914"; // SMTP password
    $mail->Timeout = 30;
    $mail->SMTPDebug = 2;
    //$mail->do_debug = 0;
    //$mail = new PHPMailer();
    //$mail->IsSMTP(); // send via SMTP
    //$mail->SMTPAuth = true; // turn on SMTP authentication
    //$mail->SMTPSecure = "ssl";
    //$mail->Host = "mail.ecrs.com.ve";
    //$mail->Port = 26;
    //$mail->Username = "ljimenez@ecrs.com.ve"; // SMTP username
    //$mail->Password = "yq$pgeM#"; // SMTP password
    //----    
/*
$header='';
$header.="Sender: $from\r\n";
$header.="From: $from\r\n";
$header.="MIME-Version: 1.0\r\n";
$header.="Content-Type: text/html; charset=utf-8\r\n";
$header.="Content-Transfer-Encoding: 8bit\r\n";
 
mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $text, $header);
*/
//Datos De Usuario Nuevo para el envio del correo de registro 
  /*  $mail_user_nuevo = $_POST['email'];  INICIO DE TODO EL COMENTARIO DEL CODIGO QUE GENERA EMAIL
    $usuario =  $_POST['email'];
    $pass_usuario = $_POST['pass'];
    $nombreApellido = $_POST['nombres']." ".$_POST['apellidos'];
    $webmaster_email = "ecrsven@gmail.com"; //Reply to this email ID
    $email = "ecrsven@gmail.com"; // Recipients email ID
    $name = "CORPORACION ECRS C.A"; // Recipient's name
    $asunto = "Bienvenido A la web de Corporacion ECRS C.A";
    
    $body_mail = '<!doctype html>
<html>
<head>
	<title>Bienvendido a Corporacion ECRS C.A</title>
</head>
<body>
<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">========================================================================<br />
==== &Eacute;STE ES UN MENSAJE GENERADO AUTOM&Aacute;TICAMENTE. NO LO RESPONDAS. ====<br />
========================================================================</span></span></p>

<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Bienvenido estimado amigo: '."$nombreApellido".' </span></span></p>

<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Queremos agradecerle por su inter&eacute;s en acceder a nuestro nuevo sitio web.<br />
En nombre de la Corporacion ECRS C.A, deseamos comunicarle nuestros objetivos e ilusiones en el d&iacute;a a d&iacute;a que desarrollamos.</span></span></p>

<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">La calidad de nuestra empresa no reside s&oacute;lo en los productos y servicios que comercializamos, sino tambi&eacute;n en las otras facetas de nuestro negocio: comerciales, de relaciones p&uacute;blicas y de comunicaci&oacute;n.</span></span></p>

<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Por favor conserva este mensaje. Los datos de tu cuenta son los siguientes:</span></span></p>

<hr />
<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Usuario: '."$usuario".'<br />
Contrase&ntilde;a: '."$pass_usuario".'</span></span></p>

<hr />
<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;">Un cordial saludo.<br />
El equipo de Corporacion ECRS C.A,</span></span></p>

<p style="text-align: justify;"><span style="font-size:12px;"><span style="font-family: verdana,geneva,sans-serif;"><img alt="" src="http://ecrs.com.ve/images/tope/corporacion-ECRS.png" style="width: 160px; height: 81px;" /></span></span></p>
</body>
</html>
                    ';
    //Configuracion para el asunto, destinatario, remitente,cuerpo del correo a enviar
    $mail->From = $webmaster_email;
    $mail->FromName = "Webmaster";
   // $mail->AddAddress($email,$name);
    $mail->AddAddress($mail_user_nuevo,$nombreApellido); // Correo y Nombre-Apellido del Nuevo Usuario 
    $mail->AddBCC($webmaster_email,$name);
    //$mail->AddBCC("agonzalez@ecrs.com.ve","Anibal Gonzalez");
    $mail->AddBCC("aperez@ecrs.com.ve","Alejandro Pérez Bretón");
    $mail->AddReplyTo($webmaster_email,"Webmaster");
    $mail->WordWrap = 70; // set word wrap
    $mail->HeaderLine("Sender","$webmaster_email");
    $mail->HeaderLine("From","$webmaster_email");
    $mail->HeaderLine("MIME-Version","1.0");
    $mail->HeaderLine("Content-Type","text/html; charset=utf-8");
    $mail->HeaderLine("Content-Transfer-Encoding","8bit");
    //$mail->HeaderLine()
    //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
    //$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
    $mail->IsHTML(true); // send as HTML
    $mail->Subject = $asunto; // Asunto del Correo
    $mail->Body = $body_mail; //HTML Body
    $mail->AltBody = "Registro De Nuevo Usuario Sistema Web CORPORACION ECRS C.A"; //Text Body
    
    if(!$mail->Send())
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
    echo "Message has been sent";
    }
        
    /*    
    require_once('../includes/PHPMailer_v2.0.4/class.phpmailer.php');
    //require_once('../includes/PHPMailer_v2.0.4/class.pop3.php'); // required for POP before SMTP
    //$pop = new POP3();
    //$pop->Authorise('mail.ecrs.com.ve', 110, 30, 'ljimenez@ecrs.com.ve', 'yq$pgeM#', 1);
    $mail = new PHPMailer();
    $body = "Hola"; //file_get_contents('contents.html');
    //$body = eregi_replace("[\]",'',$body);
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'mail.ecrs.com.ve';
    $mail->Port = 26;
    $mail->SetFrom("corporacion_ecrs@outlook.com","First Last");
    $mail->AddReplyTo("corporacion_ecrs@outlook.com","First Last");
    $mail->Subject = "PHPMailer Test Subject via POP before SMTP, basic";
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    $mail->MsgHTML($body);
    $address = "whoto@otherdomain.com";
    $mail->AddAddress($address, "John Doe");
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
    echo "Message sent!";
    }
    */    
    
    /*
    require_once('PHPMailer_v2.0.4/class.phpmailer.php');
    $mail = new PHPGMailer();
    $mail->Username = 'luisjavierjn@ladobueno.com'; 
    $mail->Password = 'qupadl30';
    $mail->From = 'corporacion_ecrs@outlook.com'; 
    $mail->FromName = 'Luis Javier';
    $mail->Subject = 'Titulo';
    $mail->AddAddress('luisjavier_jn@yahoo.com');
    $mail->Body = "Hey buddy, here's an email!";
    $mail->Send(); 
    */   
    
/*
$to = "ljimenez@ecrs.com.ve";
$subject = "Hi!";
$body = "Hi,\n\nComo estas?";
if (mail($to, $subject, $body)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
*/
    
?>


