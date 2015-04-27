<?php

// Conectando, seleccionando la base de datos
$link = mysql_connect('localhost', 'ecrs_siteuser', '15022413')
    or die('No se pudo conectar: ' . mysql_error());
//echo 'Connected successfully';
mysql_set_charset('utf8'); 
mysql_select_db('ecrs_website') or die('No se pudo seleccionar la base de datos');

// Realizar una consulta MySQL
//$query = 'SELECT * FROM tbl_usuarios';
//$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
//
//// Imprimir los resultados en HTML
//echo "<table>\n";
//while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
//    echo "\t<tr>\n";
//    foreach ($line as $col_value) {
//        echo "\t\t<td>$col_value</td>\n";
//    }
//    echo "\t</tr>\n";
//}
//echo "</table>\n";  
