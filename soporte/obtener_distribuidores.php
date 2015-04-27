<?php
require_once("dal/conexion.php"); 

    $params = array();
    
    if(!empty($_POST["codigo"])){
        
        $codigo = $_POST["codigo"];
        
        $sql_dist= "SELECT usu.nombres, usu.apellidos, usu.direccion, usu.telefono1, usu.email, 
                    usu.cedula_rif, contrato_csa, contrato_d, fk_estatus, fk_pais, fk_estado, fk_ciudad
                    FROM tbl_usuarios AS usu
                    INNER JOIN tbl_codigo_usuario cod
                    ON usu.cedula_rif = cod.cedula_rif
                    WHERE cod.codigo_cliente = '{$codigo}'";
                    
        $res_dist = mysql_query($sql_dist);
        $num_regs = mysql_num_rows($res_dist);

        if ($num_regs > 0) {
            while($row= mysql_fetch_array($res_dist)) {
                $razon_social = $row["nombres"];
                $contacto = $row["apellidos"];
                $direccion = $row["direccion"];
                $email = $row["email"];
                $rif_razon = $row["cedula_rif"];
                $telefono = $row["telefono1"];
                $contrato_csa = $row["contrato_csa"];
                $contrato_d = $row["contrato_d"];
                $estatus = $row["fk_estatus"];
                $pais = $row["fk_pais"];
                $estado = $row["fk_estado"];
                $ciudad = $row["fk_ciudad"];
            }
            
            if($contrato_csa == ''){
                $letra_contrato = 'D';
                $contrato = $contrato_d;
            }else{
                $letra_contrato = 'CSA';
                $contrato = $contrato_csa;
            }
            
            $letra_rif_cliente = substr($rif_razon, 0, 1);
            $rif_cliente = substr($rif_razon, 1);
            
            $params['razon_social'] = $razon_social;
            $params['contacto'] = $contacto;
            $params['direccion'] = $direccion;
            $params['email'] = $email;
            $params['letra_rif_cliente'] = $letra_rif_cliente;
            $params['rif_cliente'] = $rif_cliente;
            $params['telefono'] = $telefono;
            $params['letra_contrato'] = $letra_contrato;
            $params['contrato'] = $contrato;
            $params['estatus'] = $estatus;
            $params['pais'] = $pais;
            $params['estado'] = $estado;
            $params['ciudad'] = $ciudad;
            

            echo json_encode($params);
            
        }else{
            echo json_encode($params);
        }
        
        
        
         
    }
    
?>