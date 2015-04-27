<?php
    include_once("dal/sql_helper.php");
    
    $solo_distri = !empty($_GET['solo_distri']) ? (bool)$_GET['solo_distri'] : false;
    $solo_ventas = !empty($_GET['solo_ventas']) ? (bool)$_GET['solo_ventas'] : false;
    $solo_distri_maq = !empty($_GET['solo_distri_maq']) ? (bool)$_GET['solo_distri_maq'] : false;
    $solo_servic = !empty($_GET['solo_servic']) ? (bool)$_GET['solo_servic'] : false;
    $fecha_enaj = !empty($_GET['fecha_enaj']) ? $_GET['fecha_enaj'] : '%';
    
    if($solo_distri) {
        $enajs = sql_helper::exec_query(queries::prc_get_enajs_distr, "'".$fecha_enaj."-%'");
    }
    else if($solo_ventas||$solo_distri_maq) {   // si es alguna de estas
        $enajs = sql_helper::exec_query(queries::prc_get_enajs_sells, "'".$fecha_enaj."-%'");
    }    
    else if($solo_servic) {
           
        $enajs = sql_helper::exec_query(queries::prc_get_enajs_servc, "'".$fecha_enaj."-%'");
        //var_dump($enajs);
    }
    else{
        $enajs = sql_helper::exec_query(queries::prc_get_enajs, "'".$fecha_enaj."-%'");   
    }
    
    $max=count($enajs);    
    $doctree = new DOMDocument('1.0', 'UTF-8');
    $doctree->formatOutput = true;  
    $pivot = null;  

    if($max > 0) {    
        $docroot = $doctree->createElement("Proveedor");             
        $rif_proveedor = $enajs[0][1];
        $docroot->setAttribute('RIF_proveedor', $rif_proveedor);
        $docroot->setAttribute('Periodo_Declaracion', $fecha_enaj);
        $docroot->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");    
        $docroot = $doctree->appendChild($docroot);
        
        $docdist = null;
        $last_dist = null;
        $last_disp = null;
        $count = 0;
        for($i = 0; $i < $max; $i++) {             
            $rif_distribuidor = $enajs[$i][2];
            $rif_cliente_final = $enajs[$i][3];
            $rif_tecnico = $enajs[$i][4];
            $serial = $enajs[$i][5];
            $op = intval($enajs[$i][6]) < 10 ? "0".$enajs[$i][6] : $enajs[$i][6];
            $fecha = $enajs[$i][7];
            
            if($rif_proveedor == $rif_distribuidor) {   //El distribuidor es el mismo Proveedor
                if($op == 1) {  //Venta de equipo                
                    $roles = sql_helper::exec_query(queries::prc_get_roles, "'".$rif_cliente_final."'");
                    $esd = in_array('Distribuidor',$roles[0]);
                    $esc = in_array('Revendedor',$roles[0]);
                    if( $esd || $esc) {  //Escenario N�2: Proveedor a Distribuidor(cliente)
                        $last_disp = null;
                        if($last_dist != $rif_cliente_final&&$solo_distri_maq) {
                            $docdist = $doctree->createElement("Distribuidor"); 
                            $docdist->setAttribute('Rif_distribuidor', $rif_cliente_final);
                            $docdist = $docroot->appendChild($docdist);
                            $last_dist = $rif_cliente_final;                            
                        }
                        if($solo_distri_maq) // inicio de la condicion de reporte  2
                        {
                        $docmaqn = $doctree->createElement('Maquinas');
                        $docmaqn = $docdist->appendChild($docmaqn);                        
                        $docmaqn->appendChild($doctree->createElement('Numero_registro_maquina',$serial));
                        $docmaqn->appendChild($doctree->createElement('Fecha_operacion',$fecha));
                        $docmaqn->appendChild($doctree->createElement('Tipo_operacion',$op)); 
                        $docmaqn->appendChild($doctree->createElement('Observaciones',"")); 
                       // $docmaqn->appendChild($doctree->createElement('EntreCaso2',""));                        
                          if($i==0) $pivot = $docdist;
                        } //  fin de la condicion de reporte  2
                     //    if($i==0) $pivot = $docdist;
                    }  //sino es distribuidor es usuario final, as� de sencillo
                    else {  //Escenario N�1: Proveedor a UsuarioFinal(cliente)
                       
                      //$last_dist = null;
                      //$last_disp = null;
                        if($solo_ventas){  // inicio de la condicion de reporte 1
                            $last_dist = null;
                            $last_disp = null;
                        $docuser = $doctree->createElement('Usuario');
                        $docuser = $pivot == null ? $docroot->appendChild($docuser) : $docroot->insertBefore($docuser, $pivot);
                        $docuser->appendChild($doctree->createElement('RIF_usuario',$rif_cliente_final));
                        $docuser->appendChild($doctree->createElement('Numero_registro_maquina',$serial));
                        $docuser->appendChild($doctree->createElement('Fecha_operacion',$fecha));
                        $docuser->appendChild($doctree->createElement('Tipo_operacion',$op));   
                        $docuser->appendChild($doctree->createElement('Observaciones',""));
                       // $docuser->appendChild($doctree->createElement('EntreCaso1',""));    
                        if($i==0) $pivot = $docuser;
                        
                        } // fin de la condicion de ese reporte 1   
                        //  if($i==0) $pivot = $docuser;
                    }
                }
                else{  //Escenario N�4: Tecnico que trabaja directo con el proveedor
                    $last_dist = null;
                    $last_disp = null;
                    $doctecn = $doctree->createElement('PersonalTecnico');
                    $doctecn = $docroot->appendChild($doctecn);
                    $doctecn->appendChild($doctree->createElement('RIF_personal_tecnico',$rif_tecnico));
                    $doctecn->appendChild($doctree->createElement('RIF_usuario',$rif_cliente_final));
                    $doctecn->appendChild($doctree->createElement('Numero_registro_maquina',$serial));
                    $doctecn->appendChild($doctree->createElement('Fecha_operacion',$fecha));
                    $doctecn->appendChild($doctree->createElement('Tipo_operacion',$op));   
                    $doctecn->appendChild($doctree->createElement('Observaciones',"")); 
                   // $doctecn->appendChild($doctree->createElement('EntreCaso4',""));  
                }
            }
            else {
                
                if($op==1){
                //Escenario N�3: Distribuidor a UsuarioFinal [asumimos cualquier operacion 01-10]
                $last_dist = null;
                if($last_disp != $rif_distribuidor) {
                    $docdist = $doctree->createElement("Distribuidor");    
                    $docdist->setAttribute('Rif_distribuidor', $rif_distribuidor);
                    $docdist = $docroot->appendChild($docdist);
                    $last_disp = $rif_distribuidor;
                }                
                //----
                $docuser = $doctree->createElement('Usuario');
                $docuser = $docdist->appendChild($docuser);
                $docuser->appendChild($doctree->createElement('RIF_usuario',$rif_cliente_final));
                $docuser->appendChild($doctree->createElement('Numero_registro_maquina',$serial));
                $docuser->appendChild($doctree->createElement('Fecha_operacion',$fecha));
                $docuser->appendChild($doctree->createElement('Tipo_operacion',$op));   
                $docuser->appendChild($doctree->createElement('Observaciones',""));  
                //$docuser->appendChild($doctree->createElement('EntreCaso3',""));
                
                }else{
                    $last_dist = null;
                    $last_disp = null;
                    $doctecn = $doctree->createElement('PersonalTecnico');
                    $doctecn = $docroot->appendChild($doctecn);
                    $doctecn->appendChild($doctree->createElement('RIF_personal_tecnico',$rif_tecnico));
                    $doctecn->appendChild($doctree->createElement('RIF_usuario',$rif_cliente_final));
                    $doctecn->appendChild($doctree->createElement('Numero_registro_maquina',$serial));
                    $doctecn->appendChild($doctree->createElement('Fecha_operacion',$fecha));
                    $doctecn->appendChild($doctree->createElement('Tipo_operacion',$op));   
                    $doctecn->appendChild($doctree->createElement('Observaciones',"")); 
                   // $doctecn->appendChild($doctree->createElement('EntreCaso4',""));  
                    
                    
                }   
            }
            $count++;
        }        
    }    

    //echo $doctree->save("file.xml");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"ECRS".$fecha_enaj.".xml\"");
    echo $doctree->saveXML();
?>
