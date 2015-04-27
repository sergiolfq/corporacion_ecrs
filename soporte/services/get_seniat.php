<?php
if(isset($_POST["rif"])) {
    @$retval = file_get_contents("http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$_POST["rif"]); 
    if($retval !== FALSE) {
        $data = trim(filter_var(stripslashes($retval), FILTER_SANITIZE_STRING));
        $limite = strlen($data)-4;
        $nombre_user = substr($data, 0, $limite);
        $retval = preg_replace('/[^a-z0-9 _\.\,\(\)]/i', '', $nombre_user);
        $agente_retencion_IVA = substr($data, $limite, 2);
        $contribuyente_IVA = substr($data, $limite+2, 2);    
    }
    else $retval = "";
    echo $retval;
}
?>
