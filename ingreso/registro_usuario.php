<?php 
require_once("../soporte/dal/conexion.php");  

    if (isset($_POST))
    {
        $email = $_POST["email"];
        $razon_social = $_POST["razon_social"];
        $rif_razon_social = $_POST["rif_razon_social"];
        $contacto = $_POST["contacto"];
        $rif_contacto = $_POST["rif_contacto"];
        $direccion = $_POST["direccion"];
        $pais = $_POST["pais"];
        $estado = $_POST["estado"];
        $ciudad = $_POST["ciudad"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $fecha_agragado = date("Y-m-d H:i:s");
        $tipo_usuario = $_POST["tipo_usuario"];
        $valores = '';
         
        $query_rif ="SELECT *
            FROM tbl_usuarios 
            WHERE cedula_rif = '{$rif_razon_social}'";         

        $res_rif = mysql_query($query_rif) or die('Consulta fallida Rif DB: ' . mysql_error());
        $num_regis_rif = mysql_fetch_array($res_rif);

        if($num_regis_rif != 0){
            $valores = 00;
            //var_dump('este rif ya esta guardado');
        }else{
            
            $query_es ="SELECT *
                    FROM tbl_usuarios 
                    WHERE email = '{$email}'";         
                    
            $result = mysql_query($query_es) or die('Consulta fallida sesion: ' . mysql_error());

            if($row = mysql_fetch_array($result)){
                $valores = 0;
                //var_dump('este email ya esta guardado');
            }else{
                
                //valido si los tecnicosa existen en la db
                $j = 0;
                for ($j = 1; $j <= 4; $j++) {
                    $rif_tecnico1 = $_POST["rif_tecnico".$j];
                    if($rif_tecnico1 != ''){
                        $sql_tecVal = " SELECT *
                                        FROM tbl_tecnicos 
                                        WHERE id_tecnico = '{$rif_tecnico1}'";         
                    
                        $res_tecVal = mysql_query($sql_tecVal) or die('Consulta fallida Tecnico Existente: ' . mysql_error());
                        
                        if($row_tecVal = mysql_fetch_array($res_tecVal)){
                            $valores = -3;
                            // el tecnico ya esta guardado
                        }else{
                            $valores = '';
                            // tecnico validado
                        }
                    }    
                }
                if($valores == ''){
                    //carga de un nuevo usuario
                    $query_user = " INSERT INTO tbl_usuarios (nombres,cedula_rif,apellidos,id_usuario,direccion,fk_pais,fk_estado,
                                        fk_ciudad,telefono1,email,fk_estatus,fecha_agregado,id_distribuidor,fk_usuario_tipo)
                                    VALUES('".$razon_social."','".$rif_razon_social."','".$contacto."','".$rif_contacto."','".$direccion."','".$pais."','".$estado."',
                                        '".$ciudad."','".$phone."','".$email."','2','".$fecha_agragado."','".$rif_razon_social."','".$tipo_usuario."')";  


                    $res_user = mysql_query($query_user) or die('Consulta fallida User: ' . mysql_error());
                    if($res_user){
                        //var_dump('inserto el registro');
                        // Se Realiza la carga de los tecnicos asociados a la empresa
                        $valores = 1;
                        
                        $i = 0;
                        for ($i = 1; $i <= 4; $i++) {
                            $nombre_tecnico = $_POST["nombre_tecnico".$i];
                            $rif_tecnico = $_POST["rif_tecnico".$i];
                            if($nombre_tecnico != '' && $rif_tecnico != ''){
                                $query_tecnico ="INSERT INTO tbl_tecnicos (id_distribuidor,id_tecnico,nombre_tecnico)
                                VALUES ('".$rif_razon_social."','".$rif_tecnico."','".$nombre_tecnico."')";  
                                $res_tecnico = mysql_query($query_tecnico) or die('Consulta fallida tecnico: ' . mysql_error());
                                if($res_tecnico){
                                    //se cargaron los tecnicos
                                }else{
                                    //ocurrio un error
                                }
                            }
                        }
                        
                    }else{
                        $valores = -1;
                        // ocurrio un error al cargar el usuario
                    }
                }     
            }  
        }
        echo $valores;
        
    }
    
    


?>


