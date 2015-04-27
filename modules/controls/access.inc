<?php include("services/access_inc_check.php"); ?>
<link href="css/estilos.css" type="text/css" rel="stylesheet" />
<style> 
    <!-- 
    a:hover{text-decoration:none;} 
    a{text-decoration:none;} 
    --> 
</style>  

<form id="access_inc_form" name="access_inc_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="logout" id="logout" value="" />
    <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr <?php if($access_inc_signedin) echo 'style="display: none;"'; ?>>
            <td align="right" colspan="2"> 
                <a href="default.php">inicio</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="login.php">ingresar</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="register.php">registrarse</a>
            </td>
        </tr>
        <tr <?php if(!$access_inc_signedin) echo 'style="display: none;"'; ?>>
            <td align="left">                 
                <a href="deberes.php" <?php if($ocultar_deberes) echo 'style="display: none;"'; ?>> Deberes y Obligaciones de los Distribuidores y (CSA) de <i>M&aacute;quinas Fiscales</i></a>&nbsp;&nbsp;
            </td>
            <td align="right">                 
                <a href="default.php">Volver</a><span <?php if($ocultar_ayuda_enaj) echo 'style="display: none;"'; ?>>&nbsp;&nbsp; <a href="ayuda_enaj.php">Ayuda</a>&nbsp;&nbsp;</span> 
            </td>
        </tr>        
    </table>
</form>