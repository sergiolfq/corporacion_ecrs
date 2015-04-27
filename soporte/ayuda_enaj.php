<?php
    $ocultar_deberes=false;
    $ocultar_ayuda_enaj=true;
    
    if (!isset($_SESSION)) {                
        session_start();               
    } 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head><!--hola-->
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
        <title>Enajenaciones</title>     
        <link href="css/ecrs_estilos.css" rel="stylesheet" type="text/css" />                                
    </head>
    <body style="background: white;">
        <form name="default_form">
            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td>
                        <table class="TablaNormal" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" id="Table1" style="z-index:102; text-align:left">
                            <tr>
                                <td width="4%"></td>
                                <td>
                                <?php include("controls/access.inc"); ?>
                                </td>
                                <td width="6%"></td>
                            </tr>
                        </table>                      
                    </td>
                </tr>             
                <tr>
                    <td style="text-align: justify;">
                        <table border="0" cellspacing="0" cellpadding="0" width="90%" align="center" style="text-align: justify"><tr><td>
                        <hr align="center" /><br /> 
                        <p class="trebuchet-rojo13bold"><u>Sistema Declaraci&oacute;n Informativa de <i>M&aacute;quinas Fiscales</i></u>:</p>
                        <p class="trebuchet_gris12">El manual t&eacute;cnico del Sistema Declaraci&oacute;n Informativa de <i>M&aacute;quinas Fiscales</i> menciona lo siguiente: "De acuerdo a lo establecido en el art&iacute;culo 34 de la Providencia 0592 en su secci&oacute;n IV de los deberes de los fabricantes y representantes de <i>M&aacute;quinas Fiscales</i>, sus distribuidores y centros de servicio t&eacute;cnico autorizados, las personas naturales constituidas bajo la figura de sociedades cooperativas y las sociedades mercantiles domiciliadas en el pa&iacute;s que fabriquen estos equipos o que representen a fabricantes no domiciliados en el pa&iacute;s, deber&aacute;n presentar declaraci&oacute;n mensual que indique las operaciones realizadas con las <i>m&aacute;quinas</i>. Esta declaraci&oacute;n informativa deber&aacute; ser presentada al Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT), dentro de los quince (15) d&iacute;as continuos siguientes a la finalizaci&oacute;n de cada mes, ingresando al Portal SENIAT."</p>
                        <p class="trebuchet_gris12">Enmarcado en esta providencia, la presente ayuda constituye un instrumento de consulta y apoyo para los distribuidores y/o representantes de <i>M&aacute;quinas Fiscales</i> Autorizados, con la finalidad de cumplir a cabalidad el proceso de declaraci&oacute;n mensual de la informaci&oacute;n de las operaciones realizadas con las <i>M&aacute;quinas Fiscales</i>, a trav&eacute;s del sistema de nuestra p&aacute;gina Web aprovechando los beneficios de Internet en ubicuidad, rapidez y sencillez. Al hacer click en el bot&oacute;n <span class="rojosubrayado">Volver</span> de esta p&aacute;gina se encontrar&aacute; con el men&uacute; y el cuadro que ve a continuaci&oacute;n:</p>
                        <img src="/soporte/images/ayuda-enaj/img_2.png" width="620" height="312" alt="img_2.png (9.651 bytes)" />
                        <p class="trebuchet_gris12">Al igual que una hoja de Excel, podr&aacute; abrir las divisiones entre las columnas y visualizar de forma completa la descripci&oacute;n del nombre de cada campo, o puede detener el cursor sobre los t&iacute;tulos de cada columna para ver el <i>tooltip</i> con la descripci&oacute;n completa del nombre. En este cuadro se mostrar&aacute;n las <i>Enajenaciones</i> que vaya registrando en el sistema, observando los siguientes campos:</p>
                        <ul>
                        <li type="disc" class="trebuchet_gris12">RIF del Distribuidor</li>
                        <li type="disc" class="trebuchet_gris12">Nombre del Distribuidor</li>
                        <li type="disc" class="trebuchet_gris12">RIF del Cliente</li>
                        <li type="disc" class="trebuchet_gris12">Nombre del Cliente</li>
                        <li type="disc" class="trebuchet_gris12">RIF del T&eacute;cnico</li>
                        <li type="disc" class="trebuchet_gris12">Nombre del T&eacute;cnico</li>
                        <li type="disc" class="trebuchet_gris12">Numero de Registro Fiscal</li>
                        <li type="disc" class="trebuchet_gris12">Tipo de Operaci&oacute;n</li>
                        <li type="disc" class="trebuchet_gris12">Nombre del Tipo de Operaci&oacute;n</li>
                        <li type="disc" class="trebuchet_gris12">Fecha (DD/MM/AAAA)</li>
                        </ul>
                        <p class="trebuchet_gris12">Para visualizar un mes espec&iacute;fico de enajenaci&oacute;n deber&aacute; seleccionar el Mes y el A&ntilde;o deseado. Posteriormente haga click sobre el bot&oacute;n "Buscar" para completar su consulta:</p>
                        <img src="/soporte/images/ayuda-enaj/img_10.png" width="444" height="43" alt="img_10.png (2.968 bytes)" />                        
                        <br />
                        <p class="trebuchet-rojo13bold"><u>Registro de Enajenaciones</u>:</p>
                        <p class="trebuchet_gris12">Si hacemos click en el primer bot&oacute;n <i>Continuar Enajenando</i> el sistema nos redirigir&aacute; a la pantalla de <i>Enajenar Equipo</i> donde se colocar&aacute;n los datos esenciales para el registro de las actividades con los equipos fiscales.</p>
                        <ul>
                        <li type="disc" class="trebuchet_gris12">RIF del Cliente
                            <ul><li type="none" class="trebuchet_gris12">- RIF del contribuyente final, es decir, aquella persona natural o jur&iacute;dica que realiz&oacute; la compra de la <i>M&aacute;quina Fiscal</i> o solicit&oacute; un servicio para alguna de ellas.</li></ul>
                        </li>
                        <br />
                        <li type="disc" class="trebuchet_gris12">RIF del T&eacute;cnico
                            <ul><li type="none" class="trebuchet_gris12">- RIF de la persona natural que sirve como personal t&eacute;cnico, el cual realiz&oacute; el servicio.</li></ul>
                        </li>                        
                        <br />
                        <li type="disc" class="trebuchet_gris12">Serial del Equipo
                            <ul><li type="none" class="trebuchet_gris12">- N&uacute;mero de identificaci&oacute;n de la <i>M&aacute;quina Fiscal</i>.</li></ul>
                        </li>
                        <br />
                        <li type="disc" class="trebuchet_gris12">Tipo de Operaci&oacute;n
                            <ul><li type="none" class="trebuchet_gris12">- Tipo de operaci&oacute;n que se realice a la <i>M&aacute;quina Fiscal</i>.</li></ul>
                        </li>
                        <br />
                        <li type="disc" class="trebuchet_gris12">Fecha
                            <ul><li type="none" class="trebuchet_gris12">- Fecha en que se realiz&oacute; el servicio o venta de la <i>M&aacute;quina Fiscal</i>.</li></ul>
                        </li>
                        </ul>                        
                        <img src="/soporte/images/ayuda-enaj/img_3.png" width="620" height="229" alt="img_3.png (11.134 bytes)" />
                        <p class="trebuchet-rojo13bold"><u>RIF del Cliente</u>:</p>
                        <p class="trebuchet_gris12">El primer caracter es una letra seguido de 9 n&uacute;meros, las letras v&aacute;lidas son:</p>
                        <ul>
                        <li type="disc" class="trebuchet_gris12">J - Jur&iacute;dico</li>
                        <li type="disc" class="trebuchet_gris12">V - Venezolano</li>
                        <li type="disc" class="trebuchet_gris12">E - Extranjero</li>
                        <li type="disc" class="trebuchet_gris12">P - Pasaporte</li>
                        <li type="disc" class="trebuchet_gris12">G - Gobierno</li>
                        </ul>                        
                        <img src="/soporte/images/ayuda-enaj/img_5.png" width="620" height="231" alt="img_5.png (11.474 bytes)" />
                        <p class="trebuchet-rojo13bold"><u>RIF del T&eacute;cnico</u>:</p>
                        <p class="trebuchet_gris12">El primer caracter es una letra seguido de 9 n&uacute;meros, las letras v&aacute;lidas son:</p>
                        <ul>
                        <li type="disc" class="trebuchet_gris12">V - Venezolano</li>
                        <li type="disc" class="trebuchet_gris12">E - Extranjero</li>
                        <li type="disc" class="trebuchet_gris12">P - Pasaporte</li>
                        </ul>                        
                        <img src="/soporte/images/ayuda-enaj/img_6.png" width="620" height="232" alt="img_6.png (11.630 bytes)" />
                        <p class="trebuchet-rojo13bold"><u>N&uacute;mero de Registro de la <i>M&aacute;quina Fiscal</i></u>:</p>
                        <p class="trebuchet_gris12">N&uacute;mero de Identificaci&oacute;n de la <i>M&aacute;quina Fiscal</i>, el cual deber&aacute; ser &uacute;nico  y estar&aacute; conformado por 10 caracteres; los tres primeros, de izquierda a derecha, ser&aacute;n otorgados por el Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT) al momento de la autorizaci&oacute;n, y los restantes ser&aacute;n asignados por el fabricante o su representante al momento de su enajenaci&oacute;n.</p>
                        <p class="trebuchet_gris12">Los caracteres suministrados por el Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT), se&ntilde;alar&aacute;n de izquierda a derecha respectivamente: el fabricante o representante, la marca y el modelo de la <i>M&aacute;quina Fiscal</i> autorizada.</p>
                        <img src="/soporte/images/ayuda-enaj/img_8.png" width="620" height="234" alt="img_8.png (11.675 bytes)" />                        
                        <p class="trebuchet_gris12">La descripci&oacute;n de las actividades se hayan en la lista desplegable <i>Tipo de operaci&oacute;n</i>.</p>
                        <img src="/soporte/images/ayuda-enaj/img_4.png" width="620" height="283" alt="img_4.png (19.139 bytes)" />                        
                        <p class="trebuchet_gris12">La fecha del servicio podr&aacute; ser seleccionada haciendo click sobre la ventana calendario o escribiendo en el campo de texto D&iacute;a/Mes/A&ntilde;o.</p>
                        <img src="/soporte/images/ayuda-enaj/img_7.png" width="620" height="361" alt="img_7.png (18.119 bytes)" />
                        <br /><br />
                        <hr />
                        <p class="trebuchet_gris12">Para mayor informaci&oacute;n cont&aacute;ctenos a trav&eacute;s de nuestra direcci&oacute;n de correo electr&oacute;nico: <a href="mailto:soporte@ecrs.com.ve">soporte@ecrs.com.ve</a></p>                        
                        <br /><br />
                        </td></tr></table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>