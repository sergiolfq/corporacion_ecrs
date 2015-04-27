<?php    
    $ocultar_deberes=true;
    $ocultar_ayuda_enaj=false;
    
    if (!isset($_SESSION)) { 
        session_start();               
    } 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
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
                    <td>                        
                        <table border="0" cellspacing="0" cellpadding="0" width="90%" align="center" style="text-align: justify"><tr><td>                        
                        <hr /><br />
                        <p class="trebuchet-rojo13bold"><u>Enajenaciones</u>:</p>
                        <p class="trebuchet-rojo13bold">Cu&aacute;les son los deberes de los distribuidores de <i>M&aacute;quinas Fiscales? (Art. 37)</i></p>
                        <p class="trebuchet-rojo13bold">Los distribuidores de <i>M&aacute;quinas Fiscales</i> deben:</p>                                                
                        <ol>
                        <li value="1" class="trebuchet_gris12">Suscribir contrato con el fabricante o representante autorizado por el Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT).</li>
                        <li class="trebuchet_gris12">Informar al fabricante o al representante las enajenaciones de <i>M&aacute;quinas Fiscales</i> efectuadas a los usuarios, dentro de los cinco d&iacute;as h&aacute;biles siguientes a la finalizaci&oacute;n de cada mes. Este informe deber&aacute; entregarse mensualmente aun cuando no se hayan efectuado enajenaciones.</li>
                        <li class="trebuchet_gris12">Entregar el <i>Manual del Usuario</i> de la <i>M&aacute;quina Fiscal</i>, en castellano, que incluya el procedimiento para obtener el <i>Reporte Fiscal de Memoria Fiscal</i>.</li>
                        <li class="trebuchet_gris12">Suministrar al usuario de la <i>M&aacute;quina Fiscal</i> un Libro de Control, Reparaci&oacute;n y Mantenimiento por cada equipo.</li>
                        <li class="trebuchet_gris12">Troquelar el dispositivo de seguridad con el Sello Fiscal.</li>
                        <li class="trebuchet_gris12">No subcontratar la distribuci&oacute;n de <i>M&aacute;quinas Fiscales</i>.</li>
                        </ol>                        
                        <div class="trebuchet_gris12">La informaci&oacute;n a que se refiere el numeral 2 de este art&iacute;culo debe ser presentada seg&uacute;n las especificaciones que al efecto establezca el Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT), en su Portal Fiscal.</div>
                        <br />
                        <p class="trebuchet-rojo13bold"><u>Centro de Servicio Autorizado (CSA)</u>:</p>
                        <p class="trebuchet-rojo13bold">Cu&aacute;les son las obligaciones de la persona dedicada a prestar servicio t&eacute;cnico de <i>M&aacute;quinas Fiscales</i>? (Art. 38) </p>
                        <p class="trebuchet_gris12">La persona dedicada a la prestaci&oacute;n del servicio t&eacute;cnico de <i>M&aacute;quinas Fiscales</i>, deber&aacute;:</p>
                        <ol>
                        <li value="1" class="trebuchet_gris12">Suscribir contrato con el fabricante o representante autorizado por el Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT).</li>
                        <li class="trebuchet_gris12">Informar al fabricante o al representante:
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td valign="top" class="trebuchet_gris12">a.&nbsp;</td>
                                <td class="trebuchet_gris12">La imposible reparaci&oacute;n o el agotamiento de las unidades de memoria de la <i>M&aacute;quina Fiscal</i>, dentro de los cinco d&iacute;as h&aacute;biles siguientes de conocido el hecho.</td>
                            </tr>
                            <tr>
                                <td valign="top" class="trebuchet_gris12">b.&nbsp;</td>
                                <td class="trebuchet_gris12">Las inspecciones efectuadas, dentro de los cinco d&iacute;as h&aacute;biles siguientes a la finalizaci&oacute;n de cada mes.</td>
                            </tr>      
                            <tr>
                                <td valign="top" class="trebuchet_gris12">c.&nbsp;</td>
                                <td class="trebuchet_gris12">La alteraci&oacute;n o remoci&oacute;n del dispositivo de seguridad por persona no autorizada, as&iacute; como cualquier otra modificaci&oacute;n capaz de perturbar el normal funcionamiento de la <i>M&aacute;quina Fiscal</i>.</td>
                            </tr>                                    
                            <tr>
                                <td valign="top" class="trebuchet_gris12">d.&nbsp;</td>
                                <td class="trebuchet_gris12">La desincorporaci&oacute;n de cualquier <i>M&aacute;quina Fiscal</i>, sea por desuso, sustituci&oacute;n, imposibilidad de reparaci&oacute;n, agotamiento de las memorias o cualquier otra circunstancia que justifique su inutilizaci&oacute;n, dentro de los cinco d&iacute;as h&aacute;biles siguientes de conocido el hecho.</td>
                            </tr>                                    
                            <tr>
                                <td valign="top" class="trebuchet_gris12">e.&nbsp;</td>
                                <td class="trebuchet_gris12">La p&eacute;rdida de <i>M&aacute;quinas Fiscales</i> de su propiedad o del usuario que se encontraren en su poder con fines de reparaci&oacute;n, al d&iacute;a h&aacute;bil siguiente de producida.</td>
                            </tr>                                    
                            <tr>
                                <td valign="top" class="trebuchet_gris12">f.&nbsp;</td>
                                <td class="trebuchet_gris12">La p&eacute;rdida de la <i>M&aacute;quina Fiscal</i> que hubiere sufrido un usuario, dentro de los cinco d&iacute;as h&aacute;biles siguientes de conocido el hecho.</td>
                            </tr> 
                        </table>                      
                        </li>
                        <li class="trebuchet_gris12">Efectuar las inspecciones anuales obligatorias.</li>
                        <li class="trebuchet_gris12">Troquelar el dispositivo de seguridad con el Sello Fiscal, en los casos que el mismo hubiere sido retirado, a los fines de la reparaci&oacute;n o el mantenimiento de la <i>M&aacute;quina Fiscal</i>.</li>
                        <li class="trebuchet_gris12">No subcontratar la prestaci&oacute;n del servicio t&eacute;cnico.</li>
                        <li class="trebuchet_gris12">Llenar los datos en el <i>Libro de Control de Reparaci&oacute;n y Mantenimiento</i>.</li>
                        </ol>  
                        <p class="trebuchet_gris12">La informaci&oacute;n a que se refiere el numeral 2 del art&iacute;culo 38 debe ser presentada mensualmente, seg&uacute;n las especificaciones que al efecto establezca el Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT) en su Portal Fiscal, con independencia que se efect&uacute;en o hubieren acaecido las circunstancias o situaciones especificadas en el citado numeral.</p>
                        <p class="trebuchet-rojo13bold">Qu&eacute; se debe hacer en caso de aver&iacute;a de la M&aacute;quina Fiscal? (Art.39)</p>
                        <p class="trebuchet_gris12">En caso de sustituci&oacute;n de la <i>M&aacute;quina Fiscal</i>, de imposibilidad de reparaci&oacute;n de la misma o del agotamiento de las memorias, el fabricante o el representante, directamente o a trav&eacute;s de sus centros de servicio t&eacute;cnico autorizados, deber&aacute;:</p>
                        <ol>
                        <li value="1" class="trebuchet_gris12">Imprimir, de ser posible, un <i>Reporte Global Diario o Reporte "Z"</i>.</li>
                        <li class="trebuchet_gris12">Extraer la informaci&oacute;n contenida en las memorias de la <i>M&aacute;quina Fiscal</i>, para su env&iacute;o al Servicio Nacional Integrado de Administraci&oacute;n Aduanera y Tributaria (SENIAT), conforme a las especificaciones que establezca en su Portal Fiscal.</li>
                        <li class="trebuchet_gris12">Extraer la <i>Memoria Fiscal</i> y la <i>Memoria de Auditoria</i>, las cuales ser&aacute;n entregadas al usuario de la <i>M&aacute;quina Fiscal</i>, quien deber&aacute; conservarlas de acuerdo con lo dispuesto en la Providencia 592.</li>
                        </ol>
                        <p class="trebuchet-rojo13bold">En Cu&aacute;nto tiempo el servicio t&eacute;cnico (CSA) debe reparar una M&aacute;quina Fiscal? (Art.42)</p>
                        <p class="trebuchet_gris12">El tiempo de reparaci&oacute;n de una <i>M&aacute;quina Fiscal</i> no debe ser superior a quince d&iacute;as continuos. Vencido el referido plazo se considerar&aacute; que la <i>M&aacute;quina Fiscal</i> es de imposible reparaci&oacute;n, debiendo informarse tal circunstancia.</p>
                        <br />
                        </td></tr></table>
                    </td>
                </tr>           
                <tr>
                    <td style="text-align: justify;">
                        <table class="TablaNormal" border="0" cellspacing="0" cellpadding="0" width="94%" align="left" id="Table1" style="z-index:102; text-align:left">
                            <tr>
                                <td>                                                                

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>