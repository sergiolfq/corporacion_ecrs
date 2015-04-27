<?php 

include('rif.php');

/* Devuelve un booleano que indice si se encuentra registrado ese rif o no*/
//function validar($rif){
//
//$val=false;
//$obj= new rif($rif);
//$info=json_decode($obj->getInfo(),true);
//
//if(((int)$info['code_result'])==1)
//$val=true;
//
//return $val;
//}

/* Devuelve un array de la forma {codigo,mensaje}  */
function validarMensaje($rif){

$var=array();
$obj= new rif($rif);
$info=json_decode($obj->getInfo(),true);
$var[]=$info['code_result'];
$var[]=$info['message']; 

return $var;

}

$rif_validar = '';
$params = array();
//ejemplos de uso 
/*echo validar('V202054125');
$info=validarMensaje('V202054125');
echo $info[0].' '.$info[1];*/

if($_POST){
        
    $rif_validar = $_POST["rif_validar"];
    $info=validarMensaje($rif_validar);
    
    $params['datos'] = $info[1];
    
    echo json_encode($params);

}

?>